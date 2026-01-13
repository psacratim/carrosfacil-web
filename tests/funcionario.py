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

def espera_sincronizacao():
    log("Sub-etapa: Sincronizando sistema (AJAX e Carregamento)...")
    wait.until(lambda d: d.execute_script("return jQuery.active == 0"))
    time.sleep(1)

def preencher(nome_campo, valor, limpar=True):
    log(f"Sub-etapa: Preenchendo campo '{nome_campo}'...")
    campo = wait.until(EC.visibility_of_element_located((By.NAME, nome_campo)))
    if limpar:
        campo.clear()
    campo.send_keys(valor)

def abrir_edicao_por_nome(nome_busca):
    log(f"Sub-etapa: Buscando funcionário '{nome_busca}' na listagem...")
    espera_sincronizacao()
    # XPath para localizar o link de edição (manage.php?id=X) na linha do nome
    xpath_edit = f"//tr[contains(., '{nome_busca}')]//a[contains(@href, 'manage.php')]"
    
    btn = wait.until(EC.presence_of_element_located((By.XPATH, xpath_edit)))
    driver.execute_script("arguments[0].scrollIntoView({block: 'center'});", btn)
    time.sleep(0.5)
    
    log("Sub-etapa: Clicando no link de edição...")
    try:
        btn.click()
    except:
        driver.execute_script("arguments[0].click();", btn)
    
    wait.until(EC.visibility_of_element_located((By.NAME, "nome")))
    log("Sub-etapa: Página manage.php carregada.")

def salvar_e_verificar():
    log("Sub-etapa: Localizando botão de salvar no final da página...")
    btn_salvar = wait.until(EC.presence_of_element_located((By.NAME, "salvar_funcionario")))
    driver.execute_script("arguments[0].scrollIntoView({block: 'center'});", btn_salvar)
    time.sleep(0.5)
    
    log("Sub-etapa: Enviando formulário...")
    try:
        btn_salvar.click()
    except:
        driver.execute_script("arguments[0].click();", btn_salvar)
    
    log("Sub-etapa: Validando redirecionamento e mensagem...")
    for i in range(3):
        try:
            alerta = wait.until(EC.presence_of_element_located((By.CLASS_NAME, "alert")))
            log(f"Feedback do sistema: {alerta.text}")
            break
        except StaleElementReferenceException:
            if i == 2: raise
            time.sleep(0.5)
    espera_sincronizacao()

try:
    log("🚀 INICIANDO TESTES - MÓDULO FUNCIONÁRIOS")
    # Ajuste para sua URL
    driver.get("http://localhost:3000/admin/funcionarios/Index.php")
    driver.maximize_window()

    # --- ETAPA 1: CADASTRO COMPLETO (MOCK DATA) ---
    log("ETAPA 1: Cadastro Completo via Mock Data")
    wait.until(EC.element_to_be_clickable((By.LINK_TEXT, "Adicionar"))).click()
    
    log("Sub-etapa: Acionando Mock Data (API RandomUser)...")
    mock_btn = wait.until(EC.element_to_be_clickable((By.ID, "mock-funcionario")))
    mock_btn.click()
    
    # Espera o Mock Data preencher os campos (o botão volta ao estado normal)
    wait.until(EC.element_to_be_clickable((By.ID, "mock-funcionario")))
    log("Sub-etapa: Dados gerados com sucesso.")

    # Sobrescrevemos o nome para um ID único para o teste não se perder
    nome_original = f"FUNCIONARIO TESTE {random.randint(1000, 9999)}"
    preencher("nome", nome_original)
    
    salvar_e_verificar()

    # --- ETAPA 2: EDIÇÃO COMPLETA ---
    log("ETAPA 2: Edição Completa (Alterando tudo)")
    abrir_edicao_por_nome(nome_original)
    
    nome_editado_total = f"EDITADO FULL {random.randint(100, 999)}"
    preencher("nome", nome_editado_total)
    preencher("salario", "5.500,00")
    
    log("Sub-etapa: Alterando Tipo de Acesso para Administrador...")
    Select(driver.find_element(By.NAME, "tipo_acesso")).select_by_value("1")
    
    salvar_e_verificar()

    # --- ETAPA 3: EDIÇÕES INDIVIDUAIS ---
    log("ETAPA 3: Edições Individuais")

    # 3.1 NOME
    log("Fluxo 3.1: Alterando apenas o Nome")
    abrir_edicao_por_nome(nome_editado_total)
    nome_final = f"NOME FINAL {random.randint(10, 99)}"
    preencher("nome", nome_final)
    salvar_e_verificar()

    # 3.2 SALÁRIO
    log("Fluxo 3.2: Alterando apenas o Salário")
    abrir_edicao_por_nome(nome_final)
    preencher("salario", "9.999,99")
    salvar_e_verificar()

    # 3.3 STATUS
    log("Fluxo 3.3: Alterando apenas o Status (Inativo)")
    abrir_edicao_por_nome(nome_final)
    Select(driver.find_element(By.NAME, "status")).select_by_value("0")
    salvar_e_verificar()

    log("🏁 CONCLUSÃO: Bateria de testes de Funcionários finalizada!")

except Exception as e:
    log(f"🚨 ERRO CRÍTICO: {str(e)}")

finally:
    print("\n" + "="*60)
    print("📋 RELATÓRIO FINAL - QUADRO DE FUNCIONÁRIOS")
    print("="*60)
    sucesso = any("🏁 CONCLUSÃO" in h for h in historico)
    print(f"RESULTADO: {'✅ PASSOU' if sucesso else '❌ FALHOU'}")
    print("\nHistórico de Logs:")
    for h in historico: print(h)
    print("="*60)
    time.sleep(5)
    driver.quit()