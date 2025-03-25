<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once '../database.php';

header('Content-Type: application/json');
$json = json_decode(file_get_contents("php://input"),true);


$sql = $conn->prepare(query: "INSERT INTO Usuarios VALUE(NULL, :nome , :email, :senha, NULL)");
$sql->bindValue(':nome', $json['Usuario_nome']);
$sql->bindValue(':email', $json['Usuario_email']);
$sql->bindValue(':senha', $json['Usuario_senha']);

$sql->execute();

if ($sql->rowCount() > 0) {
    header('Content-Type: application/json');
    $mesagem = [
        "status" => "success",
    ];
    echo json_encode($mesagem);

} else {
    header("Content-Type: application/json");
    $mesagem = [
        "status" => "erro",
    ];
    echo json_encode($mesagem);
}


