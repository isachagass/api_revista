<?php
header("Content-Type: application/json");
require '../database.php';

$sql = "SELECT * FROM Conteudos";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($result);