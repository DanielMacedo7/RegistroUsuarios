<?php
// Inclui o arquivo de configuração e a classe de conexão
require 'config.php';
require 'connect.php';

// Verifica se todos os campos do formulário foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Id']) && isset($_POST['Username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['cpf'])) {
    // Obtém os dados do formulário
    $id = $_POST['Id'];
    $username = $_POST['Username'];
    $email = $_POST['email'];
    $telefone = $_POST['password'];
    $cpf = $_POST['cpf'];

    // Conecta ao banco de dados usando a classe Connect
    try {
        $connect = new Connect();
        $pdo = $connect->getPdo();

        // Atualiza os dados do usuário no banco de dados
        $sql = "UPDATE usuarios SET username = :username, email = :email, telefone = :telefone, cpf = :cpf WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        // Vincula os parâmetros
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':cpf', $cpf);

        // Executa a consulta
        $stmt->execute();

        // Exibe uma mensagem de sucesso
        echo "Dados atualizados com sucesso!";

        header('Location: Table.html');
        exit; // Certifique-se de sair após o redirecionamento para evitar que o script continue a ser executado


    } catch (PDOException $e) {
        // Em caso de erro, exibe a mensagem de erro
        echo "Erro ao atualizar dados no PostgreSQL: " . $e->getMessage();
    }
} else {
    // Se algum campo estiver faltando, exibe uma mensagem de erro
    echo "Todos os campos são obrigatórios.";
}
?>
