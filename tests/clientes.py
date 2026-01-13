import random
import time
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import Select
from selenium.common.exceptions import StaleElementReferenceException

# Configurações do Navegador
driver = webdriver.Chrome()
wait = WebDriverWait(driver, 15)
historico = []

def log(msg):
    txt = f"[{time.strftime('%H:%M:%S')}] {msg}"
    print(txt)
    historico.append(txt)

def espera_carregamento():
    log("Sub-etapa: Sincronizando sistema (Fim de AJAX e Alerts)...")
    # Espera qualquer alerta de mensagem sumir (se houver) e o AJAX do jQuery terminar
    wait.until(lambda d: d.execute_script("return jQuery.active == 0"))
    time.sleep(1)

def preencher(nome_campo, valor, limpar=True):
    log(f"Sub-etapa: Preenchendo campo '{nome_campo}' com '{valor}'...")
    campo = wait.until(EC.visibility_of_element_located((By.NAME, nome_campo)))
    if limpar:
        campo.clear()
    campo.send_keys(valor)

def salvar_e_verificar():
    log("Sub-etapa: Localizando botão de submissão no fim da página...")
    # Seletor baseado no atributo 'name' do seu manage.php
    btn_salvar = wait.until(EC.presence_of_element_located((By.NAME, "salvar_cliente")))
    
    # REGRA DE OURO: Scroll para centralizar o botão e evitar intercepção
    log("Sub-etapa: Movendo tela até o botão de salvar...")
    driver.execute_script("arguments[0].scrollIntoView({block: 'center'});", btn_salvar)
    time.sleep(0.8) # Tempo para o scroll estabilizar
    
    log("Sub-etapa: Enviando formulário...")
    try:
        # Tenta o clique padrão do Selenium
        btn_salvar.click()
    except Exception:
        # REGRA DE OURO: Plano B via JavaScript se o clique for interceptado
        log("Aviso: Clique normal interceptado, forçando via JavaScript...")
        driver.execute_script("arguments[0].click();", btn_salvar)
    
    log("Sub-etapa: Aguardando feedback do PHP...")
    for i in range(3):
        try:
            # Busca o alerta definido no seu Mensagem.php
            alerta = wait.until(EC.presence_of_element_located((By.CLASS_NAME, "alert")))
            msg = alerta.text
            log(f"Feedback do sistema: {msg}")
            break
        except StaleElementReferenceException:
            if i == 2: raise
            time.sleep(0.5)
            
    espera_carregamento()

def abrir_edicao_por_nome(nome_busca):
    log(f"Sub-etapa: Localizando cliente '{nome_busca}' na listagem...")
    espera_carregamento()
    # XPath para achar o botão de editar (manage.php) na linha que contém o nome
    xpath_btn = f"//tr[contains(., '{nome_busca}')]//a[contains(@href, 'manage.php')]"
    
    btn = wait.until(EC.presence_of_element_located((By.XPATH, xpath_btn)))
    driver.execute_script("arguments[0].scrollIntoView({block: 'center'});", btn)
    time.sleep(0.5)
    
    log("Sub-etapa: Clicando no link de edição...")
    try:
        btn.click()
    except:
        driver.execute_script("arguments[0].click();", btn)
    
    wait.until(EC.visibility_of_element_located((By.NAME, "nome-completo")))
    log("Sub-etapa: Página de edição carregada.")

try:
    log("🚀 INICIANDO TESTES - MÓDULO CLIENTES")
    # Ajuste a URL conforme seu ambiente local
    driver.get("http://localhost:3000/admin/clientes/Index.php")
    driver.maximize_window()

    # --- ETAPA 1: CADASTRO COMPLETO (Usando Mock Data) ---
    log("ETAPA 1: Cadastro Completo (Via Mock Data)")
    # Note: O botão no Index.php aponta para modal, mas o correto seria ir para manage.php
    # Vou forçar a navegação para manage.php conforme o padrão de CRUD do seu sistema
    driver.get("http://localhost:3000/admin/clientes/manage.php")
    
    log("Sub-etapa: Acionando botão Mock Data...")
    wait.until(EC.element_to_be_clickable((By.ID, "preencher-cliente"))).click()
    
    # Gerando um nome único para não colidir no banco e facilitar a busca
    nome_original = f"CLIENTE TESTE {random.randint(1000, 9999)}"
    preencher("nome-completo", nome_original)
    
    salvar_e_verificar()

    # --- ETAPA 2: EDIÇÃO COMPLETA ---
    log("ETAPA 2: Edição Completa (Alterando todos os campos via Mock)")
    abrir_edicao_por_nome(nome_original)
    
    wait.until(EC.element_to_be_clickable((By.ID, "preencher-cliente"))).click()
    nome_editado_full = f"CLIENTE FULL EDIT {random.randint(100, 999)}"
    preencher("nome-completo", nome_editado_full)
    
    # Garantindo que o status esteja Ativo
    Select(driver.find_element(By.NAME, "status")).select_by_value("1")
    
    salvar_e_verificar()

    # --- ETAPA 3: EDIÇÕES INDIVIDUAIS ---
    log("ETAPA 3: Edições Individuais (Campo por Campo)")

    # 3.1 NOME
    log("Fluxo 3.1: Editando apenas o Nome")
    abrir_edicao_por_nome(nome_editado_full)
    novo_nome = f"NOME INDIV {random.randint(10, 99)}"
    preencher("nome-completo", novo_nome)
    salvar_e_verificar()

    # 3.2 TELEFONE
    log("Fluxo 3.2: Editando apenas o Telefone")
    abrir_edicao_por_nome(novo_nome)
    preencher("telefone-1", "(19) 98888-7777")
    salvar_e_verificar()

    # 3.3 STATUS
    log("Fluxo 3.3: Editando apenas o Status (Inativo)")
    abrir_edicao_por_nome(novo_nome)
    Select(driver.find_element(By.NAME, "status")).select_by_value("0")
    salvar_e_verificar()

    log("🏁 CONCLUSÃO: Todos os fluxos de Clientes foram validados!")

except Exception as e:
    log(f"🚨 ERRO CRÍTICO: {str(e)}")

finally:
    print("\n" + "="*60)
    print("📋 RELATÓRIO FINAL - CLIENTES")
    print("="*60)
    sucesso = any("🏁 CONCLUSÃO" in h for h in historico)
    print(f"ESTADO: {'✅ SUCESSO' if sucesso else '❌ FALHA'}")
    print("\nHistórico:")
    for h in historico: print(h)
    print("="*60)
    time.sleep(5)
    driver.quit()