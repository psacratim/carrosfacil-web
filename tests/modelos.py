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
    log("Sub-etapa: Sincronizando sistema (AJAX + Animações)...")
    wait.until(EC.invisibility_of_element_located((By.CLASS_NAME, "modal-backdrop")))
    wait.until(EC.presence_of_element_located((By.CSS_SELECTOR, "body:not(.modal-open)")))
    wait.until(lambda d: d.execute_script("return jQuery.active == 0"))
    time.sleep(1)

def abrir_modal_cadastro():
    log("Sub-etapa: Localizando botão 'Adicionar'...")
    btn = wait.until(EC.element_to_be_clickable((By.CSS_SELECTOR, '[data-bs-target="#modelosModal"]')))
    btn.click()
    wait.until(EC.visibility_of_element_located((By.ID, "modelosModal")))
    log("Sub-etapa: Modal de cadastro aberto.")

def preencher(nome_campo, valor, limpar=True):
    log(f"Sub-etapa: Preenchendo '{nome_campo}' com '{valor}'...")
    campo = wait.until(EC.visibility_of_element_located((By.NAME, nome_campo)))
    if limpar:
        campo.clear()
    campo.send_keys(valor)

def salvar_e_verificar():
    log("Sub-etapa: Clicando em Salvar Modelo...")
    btn_salvar = wait.until(EC.element_to_be_clickable((By.CSS_SELECTOR, '#modelosModal button[type="submit"]')))
    btn_salvar.click()
    
    log("Sub-etapa: Validando feedback do PHP...")
    for i in range(3):
        try:
            alerta = wait.until(EC.presence_of_element_located((By.CLASS_NAME, "alert")))
            msg = alerta.text
            log(f"Feedback recebido: {msg}")
            break
        except StaleElementReferenceException:
            if i == 2: raise
            time.sleep(0.5)
            
    espera_carregamento()

def abrir_edicao_por_nome(nome_busca):
    log(f"Sub-etapa: Filtrando modelo '{nome_busca}'...")
    # Usa o filtro específico de modelo para isolar a linha
    filtro = driver.find_element(By.ID, "nome-modelo-filter")
    filtro.clear()
    filtro.send_keys(nome_busca)
    espera_carregamento()

    # XPath para achar o botão de editar na linha do modelo filtrado
    xpath_btn = f"//tr[contains(., '{nome_busca}')]//button[contains(@data-bs-target, 'modelosModal')]"
    
    for i in range(3):
        try:
            btn = wait.until(EC.presence_of_element_located((By.XPATH, xpath_btn)))
            driver.execute_script("arguments[0].scrollIntoView({block: 'center'});", btn)
            time.sleep(0.5)
            driver.execute_script("arguments[0].click();", btn)
            break
        except Exception:
            if i == 2: raise
            time.sleep(0.5)

    wait.until(EC.visibility_of_element_located((By.NAME, "name")))
    log("Sub-etapa: Modal de edição carregado.")

try:
    log("🚀 INICIANDO TESTES - MÓDULO MODELOS")
    driver.get("http://localhost:3000/admin/modelos/Index.php")
    driver.maximize_window()

    # --- ETAPA 1: CADASTRO COMPLETO ---
    log("ETAPA 1: Teste de Cadastro Completo")
    abrir_modal_cadastro()
    
    log("Sub-etapa: Selecionando a Marca...")
    select_marca = Select(driver.find_element(By.NAME, "id_marca"))
    if len(select_marca.options) > 0:
        select_marca.select_by_index(1) # Seleciona a primeira marca ativa (índice 0 costuma ser vazio ou título)
    
    nome_modelo = f"Modelo Teste {random.randint(100, 999)}"
    preencher("name", nome_modelo)
    preencher("observation", "Cadastrado via automação de fluxo.")
    
    salvar_e_verificar()

    # --- ETAPA 2: EDIÇÃO COMPLETA ---
    log("ETAPA 2: Teste de Edição Completa (Tudo)")
    abrir_edicao_por_nome(nome_modelo)
    
    nome_editado = nome_modelo + " FULL EDIT"
    preencher("name", nome_editado)
    preencher("observation", "Observação atualizada em edição total.")
    
    log("Sub-etapa: Alterando Status para Inativo...")
    Select(driver.find_element(By.NAME, "status")).select_by_value("0")
    
    salvar_e_verificar()

    # --- ETAPA 3: EDIÇÕES INDIVIDUAIS ---
    log("ETAPA 3: Teste de Edições Sequenciais")

    # 3.1 NOME
    log("Fluxo 3.1: Editando apenas Nome")
    abrir_edicao_por_nome(nome_editado)
    nome_final = f"MODELO INDIV {random.randint(10, 99)}"
    preencher("name", nome_final)
    salvar_e_verificar()

    # 3.2 OBSERVAÇÃO
    log("Fluxo 3.2: Editando apenas Observação")
    abrir_edicao_por_nome(nome_final)
    preencher("observation", "Somente a observação foi alterada.")
    salvar_e_verificar()

    # 3.3 STATUS
    log("Fluxo 3.3: Voltando Status para Ativado")
    abrir_edicao_por_nome(nome_final)
    Select(driver.find_element(By.NAME, "status")).select_by_value("1")
    salvar_e_verificar()

    log("🏁 CONCLUSÃO: Todos os fluxos de Modelos foram validados!")

except Exception as e:
    log(f"🚨 ERRO CRÍTICO: {str(e)}")

finally:
    print("\n" + "="*60)
    print("📋 RELATÓRIO FINAL - MODELOS")
    print("="*60)
    sucesso = any("🏁 CONCLUSÃO" in h for h in historico)
    print(f"ESTADO: {'✅ SUCESSO' if sucesso else '❌ FALHA'}")
    print("\nLogs detalhados:")
    for h in historico: print(h)
    print("="*60)
    time.sleep(5)
    driver.quit()