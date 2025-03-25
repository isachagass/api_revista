
<?php
require_once '../database.php';

header('Content-Type: application/json');
$json = json_decode(file_get_contents("php://input"), true);

$sql = $conn->prepare("UPDATE Atividades SET Atividade_titulo = :titulo, Atividade_cont = :conteudo, Atividade_img = :img,  Usuarios_idUsuarios = :fkUsuario, Matéria_idMatéria = :fkmateria WHERE idAtividades = :id");
$sql->bindValue(':titulo', $json['Atividade_titulo']);
$sql->bindValue(':img', $json['Atividade_img']);
$sql->bindValue(':conteudo', $json['Atividade_cont']);
$sql->bindValue(':fkUsuario', $json['Usuarios_idUsuarios']);
$sql->bindValue(':fkmateria', $json['Matéria_idMatéria']);
$sql->bindValue(':id', $json['idAtividades'], PDO::PARAM_INT);

$sql->execute();

if ($sql->rowCount() > 0) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "erro"]);
}