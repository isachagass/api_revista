<?php
require_once '../database.php';

header('Content-Type: application/json');

// Obtendo o JSON enviado
$json = json_decode(file_get_contents("php://input"), true);

// Verificando se os campos obrigatórios foram recebidos
if (!isset($json['Usuario_email']) || !isset($json['Usuario_senha'])) {
    echo json_encode(["status" => "erro", "mensagem" => "Usuário ou senha incorretos"]);
    exit;
}

$email = $json['Usuario_email'];
$senha = $json['Usuario_senha'];

// Modificando a consulta para buscar pelo email
$sql = "SELECT Usuario_senha, Usuario_nome FROM Usuarios WHERE Usuario_email = :email";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":email", $email, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    // Verificando a senha utilizando password_verify
    if (password_verify($senha, $result["Usuario_senha"])) {
        echo json_encode([
            "status" => "success",
            "mensagem" => "Login realizado com sucesso",
            "usuario" => ["nome" => $result["Usuario_nome"]]
        ]);
    } else {
        echo json_encode(["status" => "erro", "mensagem" => "Usuário ou senha incorretos"]);
    }
} else {
    echo json_encode(["status" => "erro", "mensagem" => "Usuário ou senha incorretos"]);
}
?>
