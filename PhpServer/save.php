<?php
//para startar o server php -S localhost:8000 -t "C:\Users\Daniel De Macedo\Desktop\TrabalhoWeb"
// Inclui o arquivo de configuração e a classe de conexão
require 'config.php';
require 'connect.php';

// Verifica se todos os campos do formulário foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['cpf'])) {
    // Obtém os dados do formulário
    $username = $_POST['Username'];
    $email = $_POST['email'];
    $telefone = $_POST['password'];
    $cpf = $_POST['cpf'];

    // Conecta ao banco de dados usando a classe Connect
    try {
        $connect = new Connect();
        $pdo = $connect->getPdo();

        // Insere os dados no banco de dados
        $sql = "INSERT INTO usuarios (username, email, telefone, cpf) VALUES (:username, :email, :telefone, :cpf)";
        $stmt = $pdo->prepare($sql);

        // Vincula os parâmetros
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':cpf', $cpf);

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

