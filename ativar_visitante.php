<?php
require 'conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Atualiza o status do visitante para ativo
    $sql = "UPDATE visitantes SET ativo = 1 WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Visitante ativado com sucesso.";
    } else {
        echo "Erro ao ativar visitante.";
    }
} else {
    echo "ID do visitante não fornecido.";
}

echo "<br><a href='visitantes_inativos.php'><button>Voltar para Visitantes Inativos</button></a>";
?>
