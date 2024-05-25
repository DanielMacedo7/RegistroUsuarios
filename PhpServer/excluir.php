<?php
require 'config.php';
require 'connect.php';

// Verifica se foi fornecido um ID para exclusão
if (isset($_GET['id'])) {
    $idUsuario = $_GET['id'];
    
    try {
        // Conecta ao banco de dados usando a classe Connect
        $connect = new Connect();
        $pdo = $connect->getPdo();

        // Query para excluir o usuário com o ID fornecido
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $idUsuario);
        $stmt->execute();

        // Retorna uma resposta de sucesso
        echo "Usuário excluído com sucesso!";
    } catch (PDOException $e) {
        // Em caso de erro, exibe a mensagem de erro
        echo "Erro ao excluir usuário: " . $e->getMessage();
    }
} else {
    // Se nenhum ID foi fornecido, retorna uma mensagem de erro
    echo "ID do usuário não fornecido.";
}
?>
