
<?php
require_once '../database.php';

header('Content-Type: application/json');
$json = json_decode(file_get_contents("php://input"), true);

$sql = $conn->prepare("UPDATE Noticias SET Noticia_titulo = :titulo, Noticia_img = :img, Noticia_cont = :conteudo, Usuarios_idUsuarios = :fkUsuario, Matéria_idMatéria = :fkmateria WHERE idNoticias = :id");
$sql->bindValue(':titulo', $json['Noticia_titulo']);
$sql->bindValue(':img', $json['Noticia_img']);
$sql->bindValue(':conteudo', $json['Noticia_cont']);
$sql->bindValue(':fkUsuario', $json['Usuarios_idUsuarios']);
$sql->bindValue(':fkmateria', $json['Matéria_idMatéria']);
$sql->bindValue(':id', $json['idNoticias'], PDO::PARAM_INT);

$sql->execute();

if ($sql->rowCount() > 0) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "erro"]);
}