import os
from pathlib import Path

def gerar_contexto_ia():
    # Caminho relativo: saindo de /test/ para /admin/
    diretorio_alvo = Path("../admin")
    arquivo_saida = "CONTEXTO_GERAL.txt"
    
    # Extensões que queremos capturar
    extensoes_permitidas = {'.php', '.html', '.js', '.css'} 

    if not diretorio_alvo.exists():
        print(f"Erro: A pasta {diretorio_alvo} não foi encontrada.")
        return

    print(f"Iniciando varredura em: {diretorio_alvo.resolve()}")

    with open(arquivo_saida, "w", encoding="utf-8") as f_out:
        # Cabeçalho do arquivo para a I.A.
        f_out.write("ESTRUTURA DE CÓDIGO FONTE - PROJETO ADMIN\n")
        f_out.write("Este arquivo contém o contexto consolidado do diretório /admin/.\n")
        f_out.write("="*50 + "\n\n")

        for arquivo in diretorio_alvo.rglob("*"):
            # Filtra apenas arquivos e as extensões desejadas
            if arquivo.is_file() and arquivo.suffix in extensoes_permitidas:
                # if not arquivo.name == "actions.php":
                #     continue
            
                try:
                    relative_path = arquivo.relative_to(diretorio_alvo.parent)
                    
                    # Delimitador de início de arquivo (Otimizado para I.A.)
                    f_out.write(f"--- START_FILE: {relative_path} ---\n")
                    
                    with open(arquivo, "r", encoding="utf-8", errors="ignore") as f_in:
                        f_out.write(f_in.read())
                    
                    # Delimitador de fim de arquivo
                    f_out.write(f"\n--- END_FILE: {relative_path} ---\n")
                    f_out.write("-" * 30 + "\n\n")
                    
                    print(f"Adicionado: {relative_path}")
                except Exception as e:
                    print(f"Erro ao ler {arquivo}: {e}")

    print(f"\nSucesso! Contexto salvo em: {os.path.abspath(arquivo_saida)}")

if __name__ == "__main__":
    gerar_contexto_ia()