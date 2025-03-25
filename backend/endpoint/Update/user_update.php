
<?php
require_once '../database.php';

header('Content-Type: application/json');
$json = json_decode(file_get_contents("php://input"), true);

$sql = $conn->prepare("UPDATE Usuarios SET Usuario_nome = :nome, Usuario_email = :email, Usuario_senha= :senha, Usuario_nivel = :nivel WHERE idUsuarios = :id");
$sql->bindValue(':nome', $json['Usuario_nome']);
$sql->bindValue(':email', $json['Usuario_email']);
$sql->bindValue(':senha', $json['Usuario_senha']);
$sql->bindValue(':nivel', $json['Usuario_nivel']);
$sql->bindValue(':id', $json['idUsuarios'], PDO::PARAM_INT);

$sql->execute();

if ($sql->rowCount() > 0) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "erro"]);
}