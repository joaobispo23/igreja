<?php
require 'conexao.php';

// Relatório de Visitantes Inativos
$sql = "SELECT * FROM visitantes WHERE ativo = 0";
$stmt = $pdo->query($sql);
$visitantes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Visitantes Inativos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        button {
            padding: 8px 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .btn-secondary {
            background-color: #008CBA;
        }
        .btn-secondary:hover {
            background-color: #007bb5;
        }
    </style>
</head>
<body>

<h2>Relatório de Visitantes Inativos</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Telefone</th>
        <th>Email</th>
        <th>Data da Visita</th>
        <th>Rua</th>
        <th>Número</th>
        <th>CEP</th>
        <th>Bairro</th>
        <th>Cidade</th>
        <th>Observações</th>
        <th>Ação</th>
    </tr>
    <?php foreach ($visitantes as $visitante): ?>
        <tr>
            <td><?php echo $visitante['id']; ?></td>
            <td><?php echo $visitante['nome']; ?></td>
            <td><?php echo $visitante['telefone']; ?></td>
            <td><?php echo $visitante['email']; ?></td>
            <td><?php echo $visitante['data_visita']; ?></td>
            <td><?php echo $visitante['rua']; ?></td>
            <td><?php echo $visitante['numero']; ?></td>
            <td><?php echo $visitante['cep']; ?></td>
            <td><?php echo $visitante['bairro']; ?></td>
            <td><?php echo $visitante['cidade']; ?></td>
            <td><?php echo $visitante['observacoes']; ?></td>
            <td><a href="ativar_visitante.php?id=<?php echo $visitante['id']; ?>"><button>Ativar</button></a></td>
        </tr>
    <?php endforeach; ?>
</table>

<a href="lista_visitantes.php"><button class="btn-secondary">Exibir Visitantes Ativos</button></a>

</body>
</html>
