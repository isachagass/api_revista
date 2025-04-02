<?php
header("Content-Type: application/json");
require '../database.php';

$sql = "SELECT Mural_titulo, Mural_cont, Mural_img FROM Murais INNER JOIN Usuarios ON Murais.Usuarios_idUsuarios = Usuarios.idUsuarios";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($result);