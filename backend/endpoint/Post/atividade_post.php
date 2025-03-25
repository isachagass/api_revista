<?php
require_once '../database.php';

header('Content-Type: application/json');
$json = json_decode(file_get_contents("php://input"),true);


$sql = $conn->prepare(query: "INSERT INTO Atividades VALUE(NULL, :titulo, :conteudo, :img, :fkmateria, :fkUsuario)");
$sql->bindValue(':titulo', $json['Atividade_titulo']);
$sql->bindValue(':img', $json['Atividade_img']);
$sql->bindValue(':conteudo', $json['Atividade_cont']);
$sql->bindValue(':fkmateria', value: $json['Matéria_idMatéria']);
$sql->bindValue(':fkUsuario', $json['Usuarios_idUsuarios']);


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


