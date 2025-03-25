<?php
header("Content-Type: application/json");
require '../database.php';

$sql = "SELECT Usuario_nome, Matéria_tipo, Atividade_titulo, Atividade_img, Atividade_cont FROM Atividades INNER JOIN Usuarios ON Atividades.Usuarios_idUsuarios = Usuarios.idUsuarios JOIN Matéria ON Matéria.idMatéria = Atividades.Matéria_idMatéria";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($result);