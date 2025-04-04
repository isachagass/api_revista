<?php
require_once '../database.php';

header('Content-Type: application/json');
$json = json_decode(file_get_contents("php://input"), true);

// Atualizando a consulta SQL de acordo com a tabela 'Murais'
$sql = $conn->prepare("UPDATE Murais 
                       SET Mural_titulo = :titulo, Mural_cont = :conteudo, Mural_img = :img, usuarios_idUsuarios = :fkUsuario 
                       WHERE idMurais = :id");

$sql->bindValue(':titulo', $json['Mural_titulo']);
$sql->bindValue(':conteudo', $json['Mural_cont']);
$sql->bindValue(':img', $json['Mural_img']);
$sql->bindValue(':fkUsuario', $json['usuarios_idUsuarios']);
$sql->bindValue(':id', $json['idMurais'], PDO::PARAM_INT);

// Executando a consulta SQL
$sql->execute();

// Verificando se a atualização foi bem-sucedida
if ($sql->rowCount() > 0) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "erro"]);
}
?>