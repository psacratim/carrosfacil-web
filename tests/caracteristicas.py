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
wait = WebDriverWait(driver, 15) # Tempo extra para segurança
historico = []

def log(msg):
    txt = f"[{time.strftime('%H:%M:%S')}] {msg}"
    print(txt)
    historico.append(txt)

def espera_carregamento():
    log("Sub-etapa: Sincronizando sistema (Fim de AJAX e Animações)...")
    # Espera o modal e o fundo escuro sumirem
    wait.until(EC.invisibility_of_element_located((By.CLASS_NAME, "modal-backdrop")))
    # Espera o jQuery terminar de atualizar a tabela
    wait.until(lambda d: d.execute_script("return jQuery.active == 0"))
    time.sleep(1) # Respiro necessário para o DOM estabilizar

def abrir_modal_cadastro():
    log("Sub-etapa: Localizando e clicando em 'Adicionar'...")
    btn = wait.until(EC.element_to_be_clickable((By.CSS_SELECTOR, '[data-bs-target="#acessoriosModal"]')))
    btn.click()
    wait.until(EC.visibility_of_element_located((By.ID, "acessoriosModal")))
    log("Sub-etapa: Modal de cadastro aberto na tela.")

def preencher(nome_campo, valor, limpar=True):
    log(f"Sub-etapa: Preenchendo campo '{nome_campo}' com '{valor}'...")
    campo = wait.until(EC.visibility_of_element_located((By.NAME, nome_campo)))
    if limpar:
        campo.clear()
    campo.send_keys(valor)

def salvar_e_verificar():
    log("Sub-etapa: Enviando formulário (Clique em Salvar/Cadastrar)...")
    btn_salvar = wait.until(EC.element_to_be_clickable((By.CSS_SELECTOR, '#acessoriosModal button[type="submit"]')))
    btn_salvar.click()
    
    log("Sub-etapa: Aguardando feedback do PHP...")
    # Lógica para evitar Stale Element no alerta
    for i in range(3):
        try:
            alerta = wait.until(EC.presence_of_element_located((By.CLASS_NAME, "alert")))
            msg = alerta.text
            log(f"Feedback do sistema: {msg}")
            break
        except StaleElementReferenceException:
            if i == 2: raise
            time.sleep(0.5)
            
    espera_carregamento()

def abrir_edicao_ultimo():
    log("Sub-etapa: Localizando último registro para edição...")
    # Garante que a tabela tem dados
    wait.until(EC.presence_of_element_located((By.CSS_SELECTOR, "table-target table tbody tr")))
    
    selector = "table-target table tbody tr:last-child .editar-btn, table-target table tbody tr:last-child [title='Editar'], table-target table tbody tr:last-child button.btn-outline-success"
    
    # Retry para o botão de editar (caso a linha atualize via AJAX)
    btn = None
    for i in range(3):
        try:
            btn = wait.until(EC.element_to_be_clickable((By.CSS_SELECTOR, selector)))
            driver.execute_script("arguments[0].scrollIntoView({block: 'center'});", btn)
            time.sleep(0.5)
            btn.click()
            break
        except (StaleElementReferenceException, Exception):
            if i == 2: raise
            log("Aviso: Tentando re-clicar no botão de editar...")
            time.sleep(0.5)

    wait.until(EC.visibility_of_element_located((By.NAME, "name")))
    log("Sub-etapa: Modal de edição carregado.")

try:
    log("🚀 INICIANDO BATERIA DE TESTES - MÓDULO CARACTERÍSTICAS")
    driver.get("http://localhost:3000/admin/vitems/Index.php")
    driver.maximize_window()

    # --- ETAPA 1: CADASTRO COMPLETO ---
    log("ETAPA 1: Teste de Cadastro Completo")
    abrir_modal_cadastro()
    
    nome_original = f"Item Automatizado {random.randint(100, 999)}"
    preencher("name", nome_original)
    preencher("observation", "Cadastro inicial para teste de fluxo.")
    
    # Verifica status desativado
    status_field = driver.find_element(By.NAME, "status")
    if not status_field.is_enabled():
        log("Info: Campo status desativado no cadastro (OK).")
    
    salvar_e_verificar()

    # --- ETAPA 2: EDIÇÃO COMPLETA ---
    log("ETAPA 2: Teste de Edição Completa (Tudo de uma vez)")
    abrir_edicao_ultimo()
    
    nome_editado = nome_original + " FULL"
    preencher("name", nome_editado)
    preencher("observation", "Editando todos os campos simultaneamente.")
    
    log("Sub-etapa: Alterando Status para Ativado...")
    Select(driver.find_element(By.NAME, "status")).select_by_value("1")
    
    salvar_e_verificar()

    # --- ETAPA 3: EDIÇÕES INDIVIDUAIS ---
    log("ETAPA 3: Teste de Edições Individuais")

    # 3.1 NOME
    log("Fluxo 3.1: Editando apenas o NOME")
    abrir_edicao_ultimo()
    preencher("name", "NOME INDIV " + str(random.randint(10, 99)))
    salvar_e_verificar()

    # 3.2 OBSERVAÇÃO
    log("Fluxo 3.2: Editando apenas a OBSERVAÇÃO")
    abrir_edicao_ultimo_item = abrir_edicao_ultimo() # Reutiliza a lógica
    preencher("observation", "Apenas a observação foi alterada.")
    salvar_e_verificar()

    # 3.3 STATUS (O ponto onde deu erro antes)
    log("Fluxo 3.3: Editando apenas o STATUS")
    abrir_edicao_ultimo()
    log("Sub-etapa: Alterando Status para Inativo...")
    Select(wait.until(EC.visibility_of_element_located((By.NAME, "status")))).select_by_value("0")
    salvar_e_verificar()

    log("🏁 CONCLUSÃO: Todos os fluxos foram validados com sucesso!")

except Exception as e:
    log(f"🚨 ERRO CRÍTICO NO TESTE: {str(e)}")

finally:
    print("\n" + "="*60)
    print("📋 RESUMO FINAL DO RELATÓRIO")
    print("="*60)
    
    sucesso = any("CONCLUSÃO" in h for h in historico)
    if sucesso:
        print("ESTADO FINAL: ✅ SUCESSO")
        print("O sistema passou em todos os testes de CRUD e integridade.")
    else:
        print("ESTADO FINAL: ❌ FALHA")
        print(f"O teste travou em: {historico[-1]}")

    print("\nDetalhamento dos Logs:")
    for h in historico:
        print(h)
    
    print("="*60)
    time.sleep(5)
    driver.quit()