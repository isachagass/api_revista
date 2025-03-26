<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once '../database.php';

header('Content-Type: application/json');
$json = json_decode(file_get_contents("php://input"), true);

// Verifica se os campos necessários foram enviados
if (!isset($json['Usuario_nome']) || !isset($json['Usuario_email']) || !isset($json['Usuario_senha'])) {
    echo json_encode(["status" => "erro", "mensagem" => "Campos obrigatórios ausentes"]);
    exit;
}

$nome = $json['Usuario_nome'];
$email = $json['Usuario_email'];
$senha = password_hash($json['Usuario_senha'], PASSWORD_DEFAULT); // Hash seguro

$sql = $conn->prepare("INSERT INTO Usuarios (Usuario_nome, Usuario_email, Usuario_senha) VALUES (:nome, :email, :senha)");
$sql->bindParam(':nome', $nome);
$sql->bindParam(':email', $email);
$sql->bindParam(':senha', $senha);
$sql->execute();

if ($sql->rowCount() > 0) {
    echo json_encode(["status" => "success", "mensagem" => "Usuário cadastrado com sucesso"]);
} else {
    echo json_encode(["status" => "erro", "mensagem" => "Erro ao cadastrar usuário"]);
}
