<?php
//para startar o server php -S localhost:8000 -t "C:\Users\Daniel De Macedo\Desktop\TrabalhoWeb"
// Inclui o arquivo de configuração e a classe de conexão
require 'config.php';
require 'connect.php';

// Verifica se todos os campos do formulário foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tipo']) && isset($_POST['descricao']) && isset($_POST['finalidade']) && isset($_POST['cnpj'])) {
    // Obtém os dados do formulário
    $tipo = $_POST['tipo'];
    $descricao = $_POST['descricao'];
    $finalidade = $_POST['finalidade'];
    $cnpj = $_POST['cnpj'];

    // Conecta ao banco de dados usando a classe Connect
    try {
        $connect = new Connect();
        $pdo = $connect->getPdo();

        // Insere os dados no banco de dados
        $sql = "INSERT INTO service(tipo, descricao, finalidade, cnpj) VALUES (:tipo, :descricao, :finalidade, :cnpj)";
        $stmt = $pdo->prepare($sql);

        // Vincula os parâmetros
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':finalidade', $finalidade);
        $stmt->bindParam(':cnpj', $cnpj);

        // Executa a consulta
        $stmt->execute();

        // Exibe uma mensagem de sucesso
        echo "Dados inseridos com sucesso!";
        
        // Redireciona para Table.html após a inserção bem-sucedida
        header('Location: Table.html');
        exit; // Certifique-se de sair após o redirecionamento para evitar que o script continue a ser executado

    } catch (PDOException $e) {
        // Em caso de erro, exibe a mensagem de erro
        echo "Erro ao inserir dados no PostgreSQL: " . $e->getMessage();
    }
} else {
    // Se algum campo estiver faltando, exibe uma mensagem de erro
    echo "Todos os campos são obrigatórios.";
}
?>

