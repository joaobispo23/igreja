<?php
require 'conexao.php';

// Função para carregar os dados de um visitante pelo ID
function carregarVisitante($pdo, $id) {
    $sql = "SELECT * FROM visitantes WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch();
}

// Cadastrar ou Editar Visitante
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? null;
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $data_visita = $_POST['data_visita'];
    $observacoes = $_POST['observacoes'];

    if ($id) {
        // Editar visitante existente
        $sql = "UPDATE visitantes SET nome = ?, telefone = ?, email = ?, data_visita = ?, observacoes = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $telefone, $email, $data_visita, $observacoes, $id]);
        echo "Visitante atualizado com sucesso!";
    } else {
        // Cadastrar novo visitante
        $sql = "INSERT INTO visitantes (nome, telefone, email, data_visita, observacoes) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $telefone, $email, $data_visita, $observacoes]);
        echo "Visitante cadastrado com sucesso!";
    }

    // Redirecionar para a lista de visitantes após salvar
    header("Location: lista_visitantes.php");
    exit();
}

// Carregar visitante para edição
$visitante = null;
if (isset($_GET['editar'])) {
    $id = $_GET['editar'];
    $visitante = carregarVisitante($pdo, $id);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?= $visitante ? 'Editar Visitante' : 'Cadastrar Visitante' ?></title>
</head>
<body>
    <h1><?= $visitante ? 'Editar Visitante' : 'Cadastrar Visitante' ?></h1>
    <form method="post">
        <input type="hidden" name="id" value="<?= $visitante['id'] ?? '' ?>">
        Nome: <input type="text" name="nome" value="<?= $visitante['nome'] ?? '' ?>" required><br>
        Telefone: <input type="text" name="telefone" value="<?= $visitante['telefone'] ?? '' ?>"><br>
        Email: <input type="email" name="email" value="<?= $visitante['email'] ?? '' ?>"><br>
        Data da Visita: <input type="date" name="data_visita" value="<?= $visitante['data_visita'] ?? '' ?>" required><br>
        Observações: <textarea name="observacoes"><?= $visitante['observacoes'] ?? '' ?></textarea><br>
        <input type="submit" value="<?= $visitante ? 'Atualizar' : 'Cadastrar' ?>">
        <a href="lista_visitantes.php">Cancelar</a>
    </form>
</body>
</html>