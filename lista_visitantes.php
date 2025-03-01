<?php
require 'conexao.php';

// Inativar Visitante (Exclusão lógica)
if (isset($_GET['inativar'])) {
    $id = $_GET['inativar'];
    $sql = "UPDATE visitantes SET ativo = 0 WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    echo "Visitante inativado com sucesso!";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Visitantes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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
        a.button {
            background-color: #add8e6;
            color: black;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
            border: 1px solid #ccc;
            display: inline-block;
            margin: 2px 5px;
        }
        a.button:hover {
            background-color: #87ceeb;
        }
        .actions {
            white-space: nowrap;
        }
        .button.inativar {
            background-color: #f08080;
        }
        .button.inativar:hover {
            background-color: #e57373;
        }
        .button.editar {
            background-color: #ffff00;
        }
        .button.editar:hover {
            background-color: #ffd700;
        }
        .button.cadastrar {
            background-color: #90ee90;
        }
        .button.cadastrar:hover {
            background-color: #76c776;
        }
        .button.ver-inativos {
            background-color: #f08080;
        }
        .button.ver-inativos:hover {
            background-color: #e57373;
        }
        .row-odd {
            background-color:rgb(165, 165, 165);
        }
        .row-even {
            background-color: #ffffff;
        }
    </style>
</head>
<body>
    <h1>Lista de Visitantes Ativos</h1>
    <div>
        <a href="cadastro_visitante.php" class="button cadastrar">Cadastrar Novo Visitante</a>
        <a href="visitantes_inativos.php" class="button ver-inativos">Ver Visitantes Inativos</a>
    </div>
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
            <th>Ações</th>
        </tr>
        <?php
        // Buscar apenas visitantes ativos
        $sql = "SELECT * FROM visitantes WHERE ativo = 1";
        $stmt = $pdo->query($sql);
        $row_count = 0;
        while ($row = $stmt->fetch()) {
            $row_class = ($row_count % 2 == 0) ? 'row-even' : 'row-odd';
            echo "<tr class='{$row_class}'>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['nome']}</td>";
            echo "<td>{$row['telefone']}</td>";
            echo "<td>{$row['email']}</td>";
            echo "<td>{$row['data_visita']}</td>";
            echo "<td>{$row['rua']}</td>";
            echo "<td>{$row['numero']}</td>";
            echo "<td>{$row['cep']}</td>";
            echo "<td>{$row['bairro']}</td>";
            echo "<td>{$row['cidade']}</td>";
            echo "<td>{$row['observacoes']}</td>";
            echo "<td class='actions'>
                <a href='cadastro_visitante.php?editar={$row['id']}' class='button editar'>Editar</a> |
                <a href='lista_visitantes.php?inativar={$row['id']}' class='button inativar' 
                   onclick='return confirm(\"Tem certeza que deseja inativar este visitante?\")'>
                   Inativar
                </a>
              </td>";
            echo "</tr>";
            $row_count++;
        }
        ?>
    </table>
</body>
</html>