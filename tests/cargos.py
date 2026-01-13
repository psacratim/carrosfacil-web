import random
import time
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import Select
from selenium.common.exceptions import StaleElementReferenceException

driver = webdriver.Chrome()
wait = WebDriverWait(driver, 15)
historico = []

def log(msg):
    txt = f"[{time.strftime('%H:%M:%S')}] {msg}"
    print(txt)
    historico.append(txt)

def espera_carregamento():
    log("Sub-etapa: Sincronizando sistema (Fim de AJAX e Animações)...")
    wait.until(EC.invisibility_of_element_located((By.CLASS_NAME, "modal-backdrop")))
    wait.until(EC.presence_of_element_located((By.CSS_SELECTOR, "body:not(.modal-open)")))
    wait.until(lambda d: d.execute_script("return jQuery.active == 0"))
    time.sleep(1)

def abrir_edicao_por_nome(nome_busca):
    log(f"Sub-etapa: Buscando registro '{nome_busca}' na tabela...")
    espera_carregamento()
    
    # XPath que encontra a linha (tr) que contém o nome e pega o botão de editar dela
    xpath_botao = f"//tr[contains(., '{nome_busca}')]//button[contains(@data-bs-target, 'cargosModal') or @title='Editar']"
    
    for i in range(3):
        try:
            btn = wait.until(EC.presence_of_element_located((By.XPATH, xpath_botao)))
            driver.execute_script("arguments[0].scrollIntoView({block: 'center'});", btn)
            time.sleep(0.5)
            driver.execute_script("arguments[0].click();", btn)
            log("Sub-etapa: Registro encontrado e botão clicado.")
            break
        except Exception:
            if i == 2: raise
            log("Aviso: Falha ao clicar, tentando novamente...")
            time.sleep(1)

    wait.until(EC.visibility_of_element_located((By.NAME, "name")))
    log("Sub-etapa: Modal de edição aberto com sucesso.")

def salvar_e_verificar():
    log("Sub-etapa: Clicando em salvar...")
    # Usa cargosModal conforme definido no seu Index.php
    btn_salvar = wait.until(EC.element_to_be_clickable((By.CSS_SELECTOR, '#cargosModal button[type="submit"]')))
    btn_salvar.click()
    
    log("Sub-etapa: Validando feedback do PHP...")
    alerta = wait.until(EC.presence_of_element_located((By.CLASS_NAME, "alert")))
    log(f"Feedback: {alerta.text}")
    espera_carregamento()

try:
    log("🚀 INICIANDO TESTES - MÓDULO CARGOS")
    driver.get("http://localhost:3000/admin/cargos/Index.php")
    driver.maximize_window()

    # --- CADASTRO ---
    log("ETAPA 1: Cadastro Completo")
    wait.until(EC.element_to_be_clickable((By.CSS_SELECTOR, '[data-bs-target="#cargosModal"]'))).click()
    
    nome_cargo = f"Cargo Teste {random.randint(100, 999)}"
    wait.until(EC.visibility_of_element_located((By.NAME, "name"))).send_keys(nome_cargo)
    driver.find_element(By.NAME, "observation").send_keys("Observação automatizada")
    
    salvar_e_verificar()

    # --- EDIÇÃO COMPLETA ---
    log("ETAPA 2: Edição Completa")
    abrir_edicao_por_nome(nome_cargo)
    
    novo_nome = nome_cargo + " EDITADO"
    campo_nome = driver.find_element(By.NAME, "name")
    campo_nome.clear()
    campo_nome.send_keys(novo_nome)
    
    # Ativando Status
    Select(driver.find_element(By.NAME, "status")).select_by_value("1")
    
    salvar_e_verificar()

    # --- EDIÇÃO INDIVIDUAL (EX: SÓ OBSERVAÇÃO) ---
    log("ETAPA 3: Edição Individual (Observação)")
    abrir_edicao_por_nome(novo_nome)
    
    campo_obs = driver.find_element(By.NAME, "observation")
    campo_obs.clear()
    campo_obs.send_keys("Alterando apenas este campo.")
    
    salvar_e_verificar()

    log("🏁 CONCLUSÃO: Todos os fluxos de Cargos validados!")

except Exception as e:
    log(f"🚨 ERRO CRÍTICO: {str(e)}")

finally:
    print("\n" + "="*60)
    print("📋 RELATÓRIO FINAL")
    print("="*60)
    for h in historico: print(h)
    time.sleep(5)
    driver.quit()