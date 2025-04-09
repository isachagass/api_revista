<?php
header("Content-Type: application/json");
require '../database.php';

$sql = "SELECT c.Conteudo_titulo, c.Conteudo_cont, c.Conteudo_img, m.Matéria_tipo AS nome_materia FROM Conteudos c INNER JOIN matéria m ON c.Matéria_idMatéria = m.idMatéria WHERE c.Conteudo_tipo = '2';";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($result);
// pega somente os conteudos das matérias