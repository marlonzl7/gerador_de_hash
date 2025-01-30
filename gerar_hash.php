<?php 

function exibirMenu() {
    echo "\033[1;34m=== Gerador de Hash ===\033[0m\n";
    echo "1. Criar um hash\n";
    echo "2. Verificar uma senha\n";
    echo "3. Configurar um algoritmo de hashing\n";
    echo "4. Sair\n";
    echo "Escolha uma opção: ";
}

function escolherAlgoritmo() {
    echo "Escolha o algorimo:\n";
    echo "[1] para BCRYPT\n";
    echo "[2] para ARGON2I\n";

    $opcao = trim(fgets(STDIN));

    return match ($opcao) {
        '1' => PASSWORD_BCRYPT,
        '2' => PASSWORD_ARGON2I,
        default => PASSWORD_BCRYPT,
    };
}

$algoritmo = PASSWORD_BCRYPT;

while (true) {
    exibirMenu();
    $opcao = trim(fgets(STDIN));

    switch ($opcao) {
        case '1': // Criar hash
            do {
                echo "Digite a senha: ";
                $senha = trim(fgets(STDIN));

                if (strlen($senha) < 8) {
                    echo "Erro: A senha deve ter no mínimo 8 caracteres.\n";
                } else {
                    $hash = password_hash($senha, $algoritmo);
                    echo "\033[1;32mHash gerado:\033[0m $hash\n";
                }

            } while(strlen($senha) < 8);
            
            break;
        
        case '2': // Verificar senha
            echo "Digite a senha: ";
            $senha = trim(fgets(STDIN));
            echo "Digite o hash: ";
            $hash = trim(fgets(STDIN));

            if (password_verify($senha, $hash)) {
                echo "\033[1;32mSenha válida!\033[0m\n";
            } else {
                echo "\033[1;31mSenha inválida!\033[0m\n";
            }

            break;

        case '3': // Configurar Algoritmo
            $algoritmo = escolherAlgoritmo();
            echo "Algoritmo configurado com sucesso!\n";
            break;

        case '4': // Sair
            echo "Saindo...\n";
            exit;

        default:
            echo "Opção inválida.\n";
            break;
    }
}
