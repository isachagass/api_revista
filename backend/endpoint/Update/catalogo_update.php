
<?php
require_once '../database.php';

header('Content-Type: application/json');
$json = json_decode(file_get_contents("php://input"), true);

$sql = $conn->prepare("UPDATE Catalogos SET Catalogo_titulo = :titulo, Catalogo_sinopse = :conteudo, Catalogo_img = :img,  Usuarios_idUsuarios = :fkUsuario WHERE idCatalogos = :id");
$sql->bindValue(':titulo', $json['Catalogo_titulo']);
$sql->bindValue(':img', $json['Catalogo_img']);
$sql->bindValue(':conteudo', $json['Catalogo_sinopse']);
$sql->bindValue(':fkUsuario', $json['Usuarios_idUsuarios']);
$sql->bindValue(':id', $json['idCatalogos'], PDO::PARAM_INT);

$sql->execute();

if ($sql->rowCount() > 0) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "erro"]);
}