import random
import time
import mysql.connector
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import Select
from selenium.common.exceptions import StaleElementReferenceException, ElementClickInterceptedException

# =================================================================
# CLASSE BASE: INFRAESTRUTURA E REGRAS DE BLINDAGEM CRÍTICAS
# =================================================================
class SistemaBase:
    def __init__(self, driver):
        self.driver = driver
        self.wait = WebDriverWait(self.driver, 15)
        self.db_config = {
            'host': 'localhost',
            'user': 'root',
            'password': '',
            'database': 'carrosfacil_ti50'
        }

    def log(self, msg):
        print(f"[{time.strftime('%H:%M:%S')}] {msg}")

    def sincronizar(self):
        """Blindagem AJAX: Garante jQuery.active == 0"""
        try:
            self.wait.until(lambda d: d.execute_script(
                "return (typeof jQuery !== 'undefined') ? jQuery.active == 0 : true"
            ))
            time.sleep(0.5)
        except: pass

    def esperar_modal(self):
        """Trata o fade do Bootstrap e garante remoção do backdrop"""
        self.log("Blindagem: Tratando camadas de modal...")
        self.wait.until(EC.invisibility_of_element_located((By.CLASS_NAME, "modal-backdrop")))
        self.wait.until(EC.presence_of_element_located((By.CSS_SELECTOR, "body:not(.modal-open)")))
        self.sincronizar()

    def preencher(self, locator, valor, limpar=True):
        """Preenchimento robusto com limpeza profunda"""
        campo = self.wait.until(EC.visibility_of_element_located(locator))
        if limpar:
            campo.click()
            campo.send_keys(Keys.CONTROL + "a")
            campo.send_keys(Keys.BACKSPACE)
        campo.send_keys(valor)
        return campo

    def rolar_e_clicar(self, locator):
        """Anti-intercepção: ScrollIntoView + Fallback JS"""
        elemento = self.wait.until(EC.presence_of_element_located(locator))
        self.driver.execute_script("arguments[0].scrollIntoView({block: 'center'});", elemento)
        time.sleep(0.5)
        try:
            self.wait.until(EC.element_to_be_clickable(locator)).click()
        except:
            self.driver.execute_script("arguments[0].click();", elemento)

    def capturar_feedback(self):
        """Retry loop para alertas PHP (Stale Element Protection)"""
        for i in range(3):
            try:
                alerta = self.wait.until(EC.presence_of_element_located((By.CLASS_NAME, "alert")))
                msg = alerta.text
                self.log(f"Feedback PHP: {msg}")
                self.sincronizar()
                return msg
            except StaleElementReferenceException:
                time.sleep(0.5)

    def validar_db(self, tabela, coluna_busca, valor_busca, campos_esperados):
        """Validação de Integridade SQL"""
        self.log(f"🔍 Verificando integridade SQL na tabela '{tabela}'...")
        try:
            conn = mysql.connector.connect(**self.db_config)
            cursor = conn.cursor(dictionary=True)
            sql = f"SELECT * FROM {tabela} WHERE {coluna_busca} = %s ORDER BY id DESC LIMIT 1"
            cursor.execute(sql, (valor_busca,))
            row = cursor.fetchone()
            if not row:
                self.log(f"❌ Erro: Registro '{valor_busca}' não encontrado no banco.")
                return False
            for col, v_exp in campos_esperados.items():
                v_real = row.get(col)
                if isinstance(v_real, bytes): v_real = int.from_bytes(v_real, "big") # Trata BIT
                if str(v_real) != str(v_exp):
                    self.log(f"❌ Diferença na coluna {col}: Banco={v_real}, Esperado={v_exp}")
                    return False
            self.log(f"✅ Integridade SQL confirmada para ID {row['id']}.")
            return True
        except Exception as e:
            self.log(f"🚨 Erro SQL: {str(e)}")
            return False
        finally:
            if conn.is_connected():
                cursor.close()
                conn.close()

# =================================================================
# CLASSES DE MÓDULO (IMPLEMENTAÇÃO COMPLETA SEM SIMPLIFICAÇÃO)
# =================================================================

class TesteVeiculos(SistemaBase):
    def executar(self):
        self.log("🚀 Módulo Veículos - Iniciando Bateria Completa")
        self.driver.get("http://localhost:3000/admin/veiculos/Index.php")
        
        # 1. Cadastro Completo
        self.rolar_e_clicar((By.LINK_TEXT, "Adicionar Veículo"))
        self.rolar_e_clicar((By.ID, "mock-veiculo"))
        time.sleep(1)
        modelo_nome = Select(self.driver.find_element(By.ID, "modelo")).first_selected_option.text
        self.preencher((By.ID, "preco_custo"), "5000000")
        self.preencher((By.ID, "lucro_esperado"), "20")
        self.rolar_e_clicar((By.NAME, "salvar_veiculo"))
        self.capturar_feedback()
        self.validar_db("veiculo", "preco_custo", "50000.00", {"lucro": 20})

        # 2. Edição Categoria e Cor
        self.driver.get("http://localhost:3000/admin/veiculos/Index.php")
        self.preencher((By.ID, "model-filter"), modelo_nome)
        self.sincronizar()
        self.rolar_e_clicar((By.XPATH, f"//tr[contains(., '{modelo_nome}')]//a[contains(@href, 'id=')]"))
        Select(self.driver.find_element(By.ID, "categoria")).select_by_value("Pickup")
        self.preencher((By.ID, "cor"), "Azul Metálico")
        self.rolar_e_clicar((By.NAME, "salvar_veiculo"))
        self.capturar_feedback()
        self.validar_db("veiculo", "cor", "Azul Metálico", {"categoria": "Pickup"})

        # 3. Edição de Estoque
        self.driver.get("http://localhost:3000/admin/veiculos/Index.php")
        self.preencher((By.ID, "model-filter"), modelo_nome)
        self.sincronizar()
        self.rolar_e_clicar((By.XPATH, f"//tr[contains(., '{modelo_nome}')]//a[contains(@href, 'id=')]"))
        self.preencher((By.ID, "estoque"), "5")
        self.rolar_e_clicar((By.NAME, "salvar_veiculo"))
        self.capturar_feedback()
        self.validar_db("veiculo", "cor", "Azul Metálico", {"estoque": 5})

class TesteVItems(SistemaBase):
    def executar(self):
        self.log("🚀 Módulo Características - Iniciando Bateria Completa")
        self.driver.get("http://localhost:3000/admin/vitems/Index.php")
        
        # 1. Cadastro Completo
        self.rolar_e_clicar((By.CSS_SELECTOR, '[data-bs-target="#acessoriosModal"]'))
        nome_orig = f"Item {random.randint(100, 999)}"
        self.preencher((By.NAME, "name"), nome_orig)
        self.preencher((By.NAME, "observation"), "Cadastro Inicial")
        self.rolar_e_clicar((By.CSS_SELECTOR, '#acessoriosModal button[type="submit"]'))
        self.capturar_feedback()
        self.esperar_modal()
        self.validar_db("caracteristica", "nome", nome_orig, {"descricao": "Cadastro Inicial"})

        # 2. Edição Full
        self.rolar_e_clicar((By.CSS_SELECTOR, "table-target tr:last-child .editar-btn"))
        nome_edit = nome_orig + " FULL"
        self.preencher((By.NAME, "name"), nome_edit)
        Select(self.driver.find_element(By.NAME, "status")).select_by_value("1")
        self.rolar_e_clicar((By.CSS_SELECTOR, '#acessoriosModal button[type="submit"]'))
        self.capturar_feedback()
        self.esperar_modal()

        # 3. Edição Individual NOME
        self.rolar_e_clicar((By.CSS_SELECTOR, "table-target tr:last-child .editar-btn"))
        nome_indiv = "NOME INDIV " + str(random.randint(10, 99))
        self.preencher((By.NAME, "name"), nome_indiv)
        self.rolar_e_clicar((By.CSS_SELECTOR, '#acessoriosModal button[type="submit"]'))
        self.capturar_feedback()
        self.esperar_modal()

        # 4. Edição Individual OBS
        self.rolar_e_clicar((By.CSS_SELECTOR, "table-target tr:last-child .editar-btn"))
        self.preencher((By.NAME, "observation"), "Obs alterada")
        self.rolar_e_clicar((By.CSS_SELECTOR, '#acessoriosModal button[type="submit"]'))
        self.capturar_feedback()
        self.esperar_modal()

        # 5. Edição Individual STATUS
        self.rolar_e_clicar((By.CSS_SELECTOR, "table-target tr:last-child .editar-btn"))
        Select(self.driver.find_element(By.NAME, "status")).select_by_value("0")
        self.rolar_e_clicar((By.CSS_SELECTOR, '#acessoriosModal button[type="submit"]'))
        self.capturar_feedback()
        self.esperar_modal()
        self.validar_db("caracteristica", "nome", nome_indiv, {"status": 0})

class TesteCargos(SistemaBase):
    def executar(self):
        self.log("🚀 Módulo Cargos - Iniciando Bateria Completa")
        self.driver.get("http://localhost:3000/admin/cargos/Index.php")
        
        # 1. Cadastro
        self.rolar_e_clicar((By.CSS_SELECTOR, '[data-bs-target="#cargosModal"]'))
        nome = f"Cargo {random.randint(100, 999)}"
        self.preencher((By.NAME, "name"), nome)
        self.rolar_e_clicar((By.CSS_SELECTOR, '#cargosModal button[type="submit"]'))
        self.capturar_feedback()
        self.esperar_modal()

        # 2. Edição Full
        self.rolar_e_clicar((By.XPATH, f"//tr[contains(., '{nome}')]//button"))
        nome_edit = nome + " EDIT"
        self.preencher((By.NAME, "name"), nome_edit)
        Select(self.driver.find_element(By.NAME, "status")).select_by_value("1")
        self.rolar_e_clicar((By.CSS_SELECTOR, '#cargosModal button[type="submit"]'))
        self.capturar_feedback()
        self.esperar_modal()

        # 3. Edição Individual OBS
        self.rolar_e_clicar((By.XPATH, f"//tr[contains(., '{nome_edit}')]//button"))
        self.preencher((By.NAME, "observation"), "Apenas Obs")
        self.rolar_e_clicar((By.CSS_SELECTOR, '#cargosModal button[type="submit"]'))
        self.capturar_feedback()
        self.esperar_modal()
        self.validar_db("cargo", "nome", nome_edit, {"observacao": "Apenas Obs"})

class TesteFuncionarios(SistemaBase):
    def executar(self):
        self.log("🚀 Módulo Funcionários - Iniciando Bateria Completa")
        self.driver.get("http://localhost:3000/admin/funcionarios/Index.php")
        
        # 1. Cadastro Mock
        self.rolar_e_clicar((By.LINK_TEXT, "Adicionar"))
        self.rolar_e_clicar((By.ID, "mock-funcionario"))
        time.sleep(1)
        nome_orig = f"FUNC QA {random.randint(1000, 9999)}"
        self.preencher((By.NAME, "nome"), nome_orig)
        self.rolar_e_clicar((By.NAME, "salvar_funcionario"))
        self.capturar_feedback()

        # 2. Edição Full
        self.driver.get("http://localhost:3000/admin/funcionarios/Index.php")
        self.rolar_e_clicar((By.XPATH, f"//tr[contains(., '{nome_orig}')]//a[contains(@href, 'manage.php')]"))
        nome_full = f"EDIT FULL {random.randint(100, 999)}"
        self.preencher((By.NAME, "nome"), nome_full)
        self.preencher((By.NAME, "salario"), "5.500,00")
        Select(self.driver.find_element(By.NAME, "tipo_acesso")).select_by_value("1")
        self.rolar_e_clicar((By.NAME, "salvar_funcionario"))
        self.capturar_feedback()

        # 3. Edição Individual NOME
        self.driver.get("http://localhost:3000/admin/funcionarios/Index.php")
        self.rolar_e_clicar((By.XPATH, f"//tr[contains(., '{nome_full}')]//a[contains(@href, 'manage.php')]"))
        nome_final = f"NOME FINAL {random.randint(10, 99)}"
        self.preencher((By.NAME, "nome"), nome_final)
        self.rolar_e_clicar((By.NAME, "salvar_funcionario"))
        self.capturar_feedback()

        # 4. Edição Individual SALARIO
        self.driver.get("http://localhost:3000/admin/funcionarios/Index.php")
        self.rolar_e_clicar((By.XPATH, f"//tr[contains(., '{nome_final}')]//a[contains(@href, 'manage.php')]"))
        self.preencher((By.NAME, "salario"), "9.999,99")
        self.rolar_e_clicar((By.NAME, "salvar_funcionario"))
        self.capturar_feedback()

        # 5. Edição Individual STATUS
        self.driver.get("http://localhost:3000/admin/funcionarios/Index.php")
        self.rolar_e_clicar((By.XPATH, f"//tr[contains(., '{nome_final}')]//a[contains(@href, 'manage.php')]"))
        Select(self.driver.find_element(By.NAME, "status")).select_by_value("0")
        self.rolar_e_clicar((By.NAME, "salvar_funcionario"))
        self.capturar_feedback()
        self.validar_db("funcionario", "nome", nome_final, {"status": 0, "salario": "9999.99"})

class TesteClientes(SistemaBase):
    def executar(self):
        self.log("🚀 Módulo Clientes - Iniciando Bateria Completa")
        self.driver.get("http://localhost:3000/admin/clientes/manage.php")
        
        # 1. Cadastro Mock
        self.rolar_e_clicar((By.ID, "preencher-cliente"))
        nome_orig = f"CLI {random.randint(1000, 9999)}"
        self.preencher((By.NAME, "nome-completo"), nome_orig)
        self.rolar_e_clicar((By.NAME, "salvar_cliente"))
        self.capturar_feedback()

        # 2. Edição Full
        self.driver.get("http://localhost:3000/admin/clientes/Index.php")
        self.rolar_e_clicar((By.XPATH, f"//tr[contains(., '{nome_orig}')]//a[contains(@href, 'manage.php')]"))
        self.rolar_e_clicar((By.ID, "preencher-cliente"))
        nome_full = f"FULL CLI {random.randint(100, 999)}"
        self.preencher((By.NAME, "nome-completo"), nome_full)
        Select(self.driver.find_element(By.NAME, "status")).select_by_value("1")
        self.rolar_e_clicar((By.NAME, "salvar_cliente"))
        self.capturar_feedback()

        # 3. Edição NOME
        self.driver.get("http://localhost:3000/admin/clientes/Index.php")
        self.rolar_e_clicar((By.XPATH, f"//tr[contains(., '{nome_full}')]//a[contains(@href, 'manage.php')]"))
        nome_indiv = f"NOME INDIV {random.randint(10, 99)}"
        self.preencher((By.NAME, "nome-completo"), nome_indiv)
        self.rolar_e_clicar((By.NAME, "salvar_cliente"))
        self.capturar_feedback()

        # 4. Edição TELEFONE
        self.driver.get("http://localhost:3000/admin/clientes/Index.php")
        self.rolar_e_clicar((By.XPATH, f"//tr[contains(., '{nome_indiv}')]//a[contains(@href, 'manage.php')]"))
        self.preencher((By.NAME, "telefone-1"), "(19) 98888-7777")
        self.rolar_e_clicar((By.NAME, "salvar_cliente"))
        self.capturar_feedback()

        # 5. Edição STATUS
        self.driver.get("http://localhost:3000/admin/clientes/Index.php")
        self.rolar_e_clicar((By.XPATH, f"//tr[contains(., '{nome_indiv}')]//a[contains(@href, 'manage.php')]"))
        Select(self.driver.find_element(By.NAME, "status")).select_by_value("0")
        self.rolar_e_clicar((By.NAME, "salvar_cliente"))
        self.capturar_feedback()
        self.validar_db("cliente", "nome", nome_indiv, {"status": 0, "telefone1": "(19) 98888-7777"})

class TesteModelos(SistemaBase):
    def executar(self):
        self.log("🚀 Módulo Modelos - Iniciando Bateria Completa")
        self.driver.get("http://localhost:3000/admin/modelos/Index.php")
        
        # 1. Cadastro
        self.rolar_e_clicar((By.CSS_SELECTOR, '[data-bs-target="#modelosModal"]'))
        Select(self.driver.find_element(By.NAME, "id_marca")).select_by_index(1)
        nome_orig = f"Modelo {random.randint(100, 999)}"
        self.preencher((By.NAME, "name"), nome_orig)
        self.rolar_e_clicar((By.CSS_SELECTOR, '#modelosModal button[type="submit"]'))
        self.capturar_feedback()
        self.esperar_modal()

        # 2. Edição Full
        self.preencher((By.ID, "nome-modelo-filter"), nome_orig)
        self.sincronizar()
        self.rolar_e_clicar((By.XPATH, f"//tr[contains(., '{nome_orig}')]//button"))
        nome_full = nome_orig + " FULL"
        self.preencher((By.NAME, "name"), nome_full)
        Select(self.driver.find_element(By.NAME, "status")).select_by_value("0")
        self.rolar_e_clicar((By.CSS_SELECTOR, '#modelosModal button[type="submit"]'))
        self.capturar_feedback()
        self.esperar_modal()

        # 3. Edição NOME
        self.preencher((By.ID, "nome-modelo-filter"), nome_full)
        self.sincronizar()
        self.rolar_e_clicar((By.XPATH, f"//tr[contains(., '{nome_full}')]//button"))
        nome_indiv = f"MOD INDIV {random.randint(10, 99)}"
        self.preencher((By.NAME, "name"), nome_indiv)
        self.rolar_e_clicar((By.CSS_SELECTOR, '#modelosModal button[type="submit"]'))
        self.capturar_feedback()
        self.esperar_modal()

        # 4. Edição OBS
        self.preencher((By.ID, "nome-modelo-filter"), nome_indiv)
        self.sincronizar()
        self.rolar_e_clicar((By.XPATH, f"//tr[contains(., '{nome_indiv}')]//button"))
        self.preencher((By.NAME, "observation"), "Nova Obs Modelo")
        self.rolar_e_clicar((By.CSS_SELECTOR, '#modelosModal button[type="submit"]'))
        self.capturar_feedback()
        self.esperar_modal()

        # 5. Edição STATUS
        self.preencher((By.ID, "nome-modelo-filter"), nome_indiv)
        self.sincronizar()
        self.rolar_e_clicar((By.XPATH, f"//tr[contains(., '{nome_indiv}')]//button"))
        Select(self.driver.find_element(By.NAME, "status")).select_by_value("1")
        self.rolar_e_clicar((By.CSS_SELECTOR, '#modelosModal button[type="submit"]'))
        self.capturar_feedback()
        self.esperar_modal()
        self.validar_db("modelo", "nome", nome_indiv, {"status": 1})

class TesteMarcas(SistemaBase):
    def executar(self):
        self.log("🚀 Módulo Marcas - Iniciando Bateria Completa")
        self.driver.get("http://localhost:3000/admin/marcas/Index.php")
        
        # 1. Cadastro
        self.rolar_e_clicar((By.CSS_SELECTOR, '[data-bs-target="#marcasModal"]'))
        nome_orig = f"Marca {random.randint(100, 999)}"
        self.preencher((By.NAME, "name"), nome_orig)
        self.rolar_e_clicar((By.CSS_SELECTOR, '#marcasModal button[type="submit"]'))
        self.capturar_feedback()
        self.esperar_modal()

        # 2. Edição Full
        self.preencher((By.ID, "nome-filter"), nome_orig)
        self.sincronizar()
        self.rolar_e_clicar((By.XPATH, f"//tr[contains(., '{nome_orig}')]//button"))
        nome_full = nome_orig + " FULL"
        self.preencher((By.NAME, "name"), nome_full)
        Select(self.driver.find_element(By.NAME, "status")).select_by_value("0")
        self.rolar_e_clicar((By.CSS_SELECTOR, '#marcasModal button[type="submit"]'))
        self.capturar_feedback()
        self.esperar_modal()

        # 3. Edição NOME
        self.preencher((By.ID, "nome-filter"), nome_full)
        self.sincronizar()
        self.rolar_e_clicar((By.XPATH, f"//tr[contains(., '{nome_full}')]//button"))
        nome_indiv = f"MAR INDIV {random.randint(10, 99)}"
        self.preencher((By.NAME, "name"), nome_indiv)
        self.rolar_e_clicar((By.CSS_SELECTOR, '#marcasModal button[type="submit"]'))
        self.capturar_feedback()
        self.esperar_modal()

        # 4. Edição OBS
        self.preencher((By.ID, "nome-filter"), nome_indiv)
        self.sincronizar()
        self.rolar_e_clicar((By.XPATH, f"//tr[contains(., '{nome_indiv}')]//button"))
        self.preencher((By.NAME, "observation"), "Obs Individual")
        self.rolar_e_clicar((By.CSS_SELECTOR, '#marcasModal button[type="submit"]'))
        self.capturar_feedback()
        self.esperar_modal()

        # 5. Edição STATUS
        self.preencher((By.ID, "nome-filter"), nome_indiv)
        self.sincronizar()
        self.rolar_e_clicar((By.XPATH, f"//tr[contains(., '{nome_indiv}')]//button"))
        Select(self.driver.find_element(By.NAME, "status")).select_by_value("1")
        self.rolar_e_clicar((By.CSS_SELECTOR, '#marcasModal button[type="submit"]'))
        self.capturar_feedback()
        self.esperar_modal()
        self.validar_db("marca", "nome", nome_indiv, {"status": 1})

# =================================================================
# MENU INTERATIVO PRINCIPAL
# =================================================================
if __name__ == "__main__":
    driver = webdriver.Chrome()
    driver.maximize_window()
    
    opcoes = {
        "1": ("Veículo", TesteVeiculos),
        "2": ("Característica", TesteVItems),
        "3": ("Cargo", TesteCargos),
        "4": ("Funcionário", TesteFuncionarios),
        "5": ("Cliente", TesteClientes),
        "6": ("Modelo", TesteModelos),
        "7": ("Marca", TesteMarcas)
    }

    try:
        while True:
            print("\n" + "="*50)
            print("  ENGINEER QA - REGRESSION SUITE (FULL STEPS)")
            print("="*50)
            for k, v in opcoes.items(): print(f"[{k}] {v[0]}")
            print("[0] Sair")
            
            cmd = input("\nEscolha a bateria de teste: ")
            if cmd == "0": break
            if cmd in opcoes:
                nome_bat, classe_bat = opcoes[cmd]
                print(f"\n▶ Executando: {nome_bat}")
                suite = classe_bat(driver)
                suite.executar()
                print(f"✔ Bateria {nome_bat} finalizada.")
            else:
                print("❌ Opção inválida.")
    finally:
        driver.quit()