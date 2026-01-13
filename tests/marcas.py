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
    # Espera o modal-backdrop sumir
    wait.until(EC.invisibility_of_element_located((By.CLASS_NAME, "modal-backdrop")))
    # Espera o body destravar
    wait.until(EC.presence_of_element_located((By.CSS_SELECTOR, "body:not(.modal-open)")))
    # Espera o jQuery terminar de renderizar a tabela
    wait.until(lambda d: d.execute_script("return jQuery.active == 0"))
    time.sleep(1)

def abrir_modal_cadastro():
    log("Sub-etapa: Localizando botão 'Adicionar'...")
    btn = wait.until(EC.element_to_be_clickable((By.CSS_SELECTOR, '[data-bs-target="#marcasModal"]')))
    btn.click()
    wait.until(EC.visibility_of_element_located((By.ID, "marcasModal")))
    log("Sub-etapa: Modal de cadastro aberto.")

def preencher(nome_campo, valor, limpar=True):
    log(f"Sub-etapa: Preenchendo '{nome_campo}' com '{valor}'...")
    campo = wait.until(EC.visibility_of_element_located((By.NAME, nome_campo)))
    if limpar:
        campo.clear()
    campo.send_keys(valor)

def salvar_e_verificar():
    log("Sub-etapa: Clicando em Salvar Marca...")
    btn_salvar = wait.until(EC.element_to_be_clickable((By.CSS_SELECTOR, '#marcasModal button[type="submit"]')))
    btn_salvar.click()
    
    log("Sub-etapa: Aguardando feedback do sistema...")
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
    log(f"Sub-etapa: Buscando marca '{nome_busca}' na tabela...")
    # Usa o filtro de busca para isolar o registro e evitar confusão com outros nomes
    filtro = driver.find_element(By.ID, "nome-filter")
    filtro.clear()
    filtro.send_keys(nome_busca)
    espera_carregamento()

    selector = f"//tr[contains(., '{nome_busca}')]//button[contains(@data-bs-target, 'marcasModal')]"
    
    for i in range(3):
        try:
            btn = wait.until(EC.presence_of_element_located((By.XPATH, selector)))
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
    log("🚀 INICIANDO TESTES - MÓDULO MARCAS")
    # URL do seu Index.php de marcas
    driver.get("http://localhost:3000/admin/marcas/Index.php")
    driver.maximize_window()

    # --- ETAPA 1: CADASTRO COMPLETO ---
    log("ETAPA 1: Teste de Cadastro Completo")
    abrir_modal_cadastro()
    
    nome_marca = f"Marca Automática {random.randint(100, 999)}"
    preencher("name", nome_marca)
    preencher("observation", "Cadastrada via script de teste.")
    
    salvar_e_verificar()

    # --- ETAPA 2: EDIÇÃO COMPLETA ---
    log("ETAPA 2: Teste de Edição Completa (Tudo)")
    abrir_edicao_por_nome(nome_marca)
    
    nome_editado = nome_marca + " FULL"
    preencher("name", nome_editado)
    preencher("observation", "Observação atualizada na edição completa.")
    
    log("Sub-etapa: Alterando Status para Desativado...")
    Select(driver.find_element(By.NAME, "status")).select_by_value("0")
    
    salvar_e_verificar()

    # --- ETAPA 3: EDIÇÕES INDIVIDUAIS ---
    log("ETAPA 3: Teste de Edições Sequenciais")

    # 3.1 NOME
    log("Fluxo 3.1: Editando apenas Nome")
    abrir_edicao_por_nome(nome_editado)
    nome_final = f"MARCA INDIV {random.randint(10, 99)}"
    preencher("name", nome_final)
    salvar_e_verificar()

    # 3.2 OBSERVAÇÃO
    log("Fluxo 3.2: Editando apenas Observação")
    abrir_edicao_por_nome(nome_final)
    preencher("observation", "Somente a observação mudou agora.")
    salvar_e_verificar()

    # 3.3 STATUS
    log("Fluxo 3.3: Voltando Status para Ativado")
    abrir_edicao_por_nome(nome_final)
    Select(driver.find_element(By.NAME, "status")).select_by_value("1")
    salvar_e_verificar()

    log("🏁 CONCLUSÃO: Todos os fluxos de Marcas foram validados!")

except Exception as e:
    log(f"🚨 ERRO CRÍTICO: {str(e)}")

finally:
    print("\n" + "="*60)
    print("📋 RELATÓRIO FINAL - MARCAS")
    print("="*60)
    sucesso = any("🏁 CONCLUSÃO" in h for h in historico)
    print(f"ESTADO: {'✅ SUCESSO' if sucesso else '❌ FALHA'}")
    print("\nLogs detalhados:")
    for h in historico: print(h)
    print("="*60)
    time.sleep(5)
    driver.quit()