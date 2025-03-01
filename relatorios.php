<?php
require 'conexao.php';

// Relatório de Visitantes Ativos
$sql = "SELECT * FROM visitantes WHERE ativo = 1";
$stmt = $pdo->query($sql);
$visitantes = $stmt->fetchAll();

echo "<h2>Relatório de Visitantes Ativos</h2>";
echo "<table border='1'>";
echo "<tr><th>ID</th><th>Nome</th><th>Telefone</th><th>Email</th><th>Data da Visita</th><th>Observações</th></tr>";
foreach ($visitantes as $visitante) {
    echo "<tr>";
    echo "<td>{$visitante['id']}</td>";
    echo "<td>{$visitante['nome']}</td>";
    echo "<td>{$visitante['telefone']}</td>";
    echo "<td>{$visitante['email']}</td>";
    echo "<td>{$visitante['data_visita']}</td>";
    echo "<td>{$visitante['observacoes']}</td>";
    echo "</tr>";
}
echo "</table>";

echo "<br><a href='visitantes_inativos.php'><button>Exibir Visitantes Inativos</button></a>";
?>
