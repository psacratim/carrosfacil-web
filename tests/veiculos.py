import random
import time
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
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
    log("Sub-etapa: Sincronizando sistema (AJAX)...")
    # Espera o jQuery terminar qualquer requisição ativa
    wait.until(lambda d: d.execute_script("return jQuery.active == 0"))
    time.sleep(1)

def preencher_moeda(id_campo, valor):
    log(f"Sub-etapa: Preenchendo moeda em '{id_campo}'...")
    campo = wait.until(EC.element_to_be_clickable((By.ID, id_campo)))
    campo.click()
    # Garante que o campo está vazio antes da máscara agir
    campo.send_keys(Keys.CONTROL + "a")
    campo.send_keys(Keys.BACKSPACE)
    time.sleep(0.3)
    campo.send_keys(valor)
    campo.send_keys(Keys.TAB) # Sai do campo para disparar o calcularVenda()
    time.sleep(0.5)

def abrir_edicao_por_modelo(modelo_busca):
    log(f"Sub-etapa: Filtrando modelo '{modelo_busca}'...")
    espera_sincronizacao()
    
    # Foca e limpa o filtro de modelo
    filtro = wait.until(EC.visibility_of_element_located((By.ID, "model-filter")))
    filtro.click()
    filtro.clear()
    filtro.send_keys(modelo_busca)
    
    log("Sub-etapa: Aguardando a tabela atualizar o resultado...")
    # Espera o AJAX acabar e o texto aparecer fisicamente no HTML da div table-target
    wait.until(lambda d: d.execute_script("return jQuery.active == 0"))
    wait.until(EC.text_to_be_present_in_element((By.ID, "listar"), modelo_busca))
    
    # Localiza o link de edição na linha correta
    xpath_edit = f"//tr[contains(., '{modelo_busca}')]//a[contains(@href, 'id=')]"
    btn = wait.until(EC.element_to_be_clickable((By.XPATH, xpath_edit)))
    
    driver.execute_script("arguments[0].scrollIntoView({block: 'center'});", btn)
    time.sleep(0.5)
    
    log("Sub-etapa: Acessando manutenção do veículo...")
    btn.click()
    wait.until(EC.visibility_of_element_located((By.ID, "modelo")))

def salvar_e_verificar():
    log("Sub-etapa: Localizando botão de salvar...")
    btn_salvar = wait.until(EC.presence_of_element_located((By.NAME, "salvar_veiculo")))
    driver.execute_script("arguments[0].scrollIntoView({block: 'center'});", btn_salvar)
    time.sleep(0.5)
    
    # Verifica o valor final de venda na tela
    venda_valor = driver.find_element(By.ID, "preco_venda").get_attribute("value")
    log(f"Info: Valor de venda calculado: R$ {venda_valor}")

    log("Sub-etapa: Enviando formulário...")
    try:
        btn_salvar.click()
    except:
        driver.execute_script("arguments[0].click();", btn_salvar)
    
    log("Sub-etapa: Validando feedback do PHP...")
    alerta = wait.until(EC.presence_of_element_located((By.CLASS_NAME, "alert")))
    log(f"Feedback do sistema: {alerta.text}")
    espera_sincronizacao()

try:
    log("🚀 INICIANDO BATERIA DE TESTES - VEÍCULOS")
    driver.get("http://localhost:3000/admin/veiculos/Index.php")
    driver.maximize_window()

    # --- ETAPA 1: CADASTRO COMPLETO ---
    log("ETAPA 1: Cadastro via Mock e Validação Financeira")
    wait.until(EC.element_to_be_clickable((By.LINK_TEXT, "Adicionar Veículo"))).click()
    
    log("Sub-etapa: Acionando Mock Veículo...")
    wait.until(EC.element_to_be_clickable((By.ID, "mock-veiculo"))).click()
    time.sleep(1) # Tempo para o Mock preencher e calcular

    # Descobre qual modelo o Mock escolheu
    select_modelo = Select(driver.find_element(By.ID, "modelo"))
    modelo_teste = select_modelo.first_selected_option.text
    log(f"Info: O modelo sorteado para o teste foi '{modelo_teste}'")

    # Força um valor manual para testar o cálculo (Custo 50k + 20% Lucro)
    preencher_moeda("preco_custo", "5000000") # Digita 5000000 para a máscara formatar 50.000,00
    preencher_moeda("lucro_esperado", "20")
    
    salvar_e_verificar()

    # --- ETAPA 2: EDIÇÃO ---
    log("ETAPA 2: Edição Completa")
    abrir_edicao_por_modelo(modelo_teste)
    
    log("Sub-etapa: Alterando categoria e cor...")
    Select(driver.find_element(By.ID, "categoria")).select_by_value("Pickup")
    driver.find_element(By.ID, "cor").clear()
    driver.find_element(By.ID, "cor").send_keys("Azul Metálico")
    
    salvar_e_verificar()

    # --- ETAPA 3: TESTE DE ESTOQUE ---
    log("ETAPA 3: Alteração de Estoque")
    abrir_edicao_por_modelo(modelo_teste)
    
    campo_estoque = driver.find_element(By.ID, "estoque")
    campo_estoque.clear()
    campo_estoque.send_keys("5")
    
    salvar_e_verificar()

    log("🏁 CONCLUSÃO: Bateria de Veículos finalizada com sucesso!")

except Exception as e:
    log(f"🚨 ERRO CRÍTICO: {str(e)}")

finally:
    print("\n" + "="*60)
    print("📋 RELATÓRIO FINAL - VEÍCULOS")
    print("="*60)
    sucesso = any("🏁 CONCLUSÃO" in h for h in historico)
    print(f"ESTADO FINAL: {'✅ SUCESSO' if sucesso else '❌ FALHA'}")
    print("\nLogs:")
    for h in historico: print(h)
    print("="*60)
    time.sleep(5)
    driver.quit()