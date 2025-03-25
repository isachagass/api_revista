<?php
require_once '../database.php';

header('Content-Type: application/json');
$json = json_decode(file_get_contents("php://input"),true);


$sql = $conn->prepare(query: "INSERT INTO Noticias VALUE(NULL, :titulo , :img, :conteudo, :fkUsuario, :fkmateria)");
$sql->bindValue(':titulo', $json['Noticia_titulo']);
$sql->bindValue(':img', $json['Noticia_img']);
$sql->bindValue(':conteudo', $json['Noticia_cont']);
$sql->bindValue(':fkUsuario', $json['Usuarios_idUsuarios']);
$sql->bindValue(':fkmateria', $json['Matéria_idMatéria']);

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


