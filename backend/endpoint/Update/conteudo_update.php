<?php
require_once '../database.php';

header('Content-Type: application/json');
$json = json_decode(file_get_contents("php://input"), true);

$sql = $conn->prepare("UPDATE Conteudos SET Conteudo_titulo = :titulo, Conteudo_img = :img, Conteudo_cont = :conteudo, Conteudo_tipo = :tipo, Usuarios_idUsuarios = :fkUsuario, Matéria_idMatéria = :fkmateria WHERE idConteudos = :id");
$sql->bindValue(':titulo', $json['Conteudo_titulo']);
$sql->bindValue(':img', $json['Conteudo_img']);
$sql->bindValue(':conteudo', $json['Conteudo_cont']);
$sql->bindValue(':tipo', $json['Conteudo_tipo']);
$sql->bindValue(':fkUsuario', $json['Usuarios_idUsuarios']);
$sql->bindValue(':fkmateria', $json['Matéria_idMatéria']);
$sql->bindValue(':id', $json['idConteudos'], PDO::PARAM_INT);
$sql->execute();

if ($sql->rowCount() > 0) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "erro"]);
}