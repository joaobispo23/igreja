<?php
require 'conexao.php';

// Função para carregar os dados de um visitante pelo ID
function carregarVisitante($pdo, $id) {
    $sql = "SELECT * FROM visitantes WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch();
}

// Função para buscar endereço pelo CEP
function buscarEnderecoPorCep($pdo, $cep) {
    $sql = "SELECT rua, bairro FROM endereco WHERE cep = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$cep]);
    return $stmt->fetch();
}

// Cadastrar ou Editar Visitante
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? null;
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $data_visita = $_POST['data_visita'];
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $cep = $_POST['cep'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $observacoes = $_POST['observacoes'];

    if ($id) {
        // Editar visitante existente
        $sql = "UPDATE visitantes SET nome = ?, telefone = ?, email = ?, data_visita = ?, rua = ?, numero = ?, cep = ?, bairro = ?, cidade = ?, observacoes = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $telefone, $email, $data_visita, $rua, $numero, $cep, $bairro, $cidade, $observacoes, $id]);
        echo "Visitante atualizado com sucesso!";
    } else {
        // Cadastrar novo visitante
        $sql = "INSERT INTO visitantes (nome, telefone, email, data_visita, rua, numero, cep, bairro, cidade, observacoes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $telefone, $email, $data_visita, $rua, $numero, $cep, $bairro, $cidade, $observacoes]);
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

// Definir o fuso horário para garantir que a data esteja correta
date_default_timezone_set('America/Sao_Paulo');

// Obter a data atual no formato Y-m-d
$dataAtual = date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?= $visitante ? 'Editar Visitante' : 'Cadastrar Visitante' ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 160vh;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 10px;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, textarea, button {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
        }
        button {
            background-color: #5cb85c;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"] {
            background-color: rgb(160, 228, 252);
        }
        a button {
            background-color: #007bff;
        }
    </style>
    <script>
        async function buscarEndereco() {
            const cep = document.getElementById('cep').value;
            if (cep.length === 8) {
                const response = await fetch(`buscar_endereco.php?cep=${cep}`);
                const endereco = await response.json();
                if (endereco) {
                    document.getElementById('rua').value = endereco.rua;
                    document.getElementById('bairro').value = endereco.bairro;
                }
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1><?= $visitante ? 'Editar Visitante' : 'Cadastrar Visitante' ?></h1>
        <form method="post">
            <input type="hidden" name="id" value="<?= $visitante['id'] ?? '' ?>">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?= $visitante['nome'] ?? '' ?>" required>
            
            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" value="<?= $visitante['telefone'] ?? '' ?>">
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= $visitante['email'] ?? '' ?>">
            
            <label for="data_visita">Data da Visita:</label>
            <input type="date" id="data_visita" name="data_visita" value="<?= $visitante['data_visita'] ?? $dataAtual ?>" required>
            
            <label for="rua">Rua:</label>
            <input type="text" id="rua" name="rua" value="<?= $visitante['rua'] ?? '' ?>">
            
            <label for="numero">Número:</label>
            <input type="text" id="numero" name="numero" value="<?= $visitante['numero'] ?? '' ?>">
            
            <label for="cep">CEP:</label>
            <input type="text" id="cep" name="cep" value="<?= $visitante['cep'] ?? '' ?>" onblur="buscarEndereco()">
            
            <label for="bairro">Bairro:</label>
            <input type="text" id="bairro" name="bairro" value="<?= $visitante['bairro'] ?? '' ?>">
            
            <label for="cidade">Cidade:</label>
            <input type="text" id="cidade" name="cidade" value="<?= $visitante['cidade'] ?? '' ?>">
            
            <label for="observacoes">Observações:</label>
            <textarea id="observacoes" name="observacoes"><?= $visitante['observacoes'] ?? '' ?></textarea>
            
            <input type="submit" value="<?= $visitante ? 'Atualizar' : 'Cadastrar' ?>">
            <a href="lista_visitantes.php">
                <button type="button">Ver Lista de Visitantes</button>
            </a>
        </form>
    </div>
</body>
</html>
