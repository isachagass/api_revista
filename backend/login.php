<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once "./endpoint/database.php"; // Verifique se esse caminho está correto

$json = json_decode(file_get_contents("php://input"), true);

$email = $json['Usuario_email'] ?? '';
$senha = $json['Usuario_senha'] ?? '';

// Verifica se os dados foram enviados
if (empty($email) || empty($senha)) {
    echo json_encode(["status" => "erro", "mensagem" => "Preencha todos os campos"]);
    exit;
}

// Busca o usuário pelo e-mail
$sql = "SELECT * FROM Usuarios WHERE Usuario_email = :email";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if ($usuario) {
    // Verifica a senha (se estiver armazenada com password_hash, descomente a linha abaixo)
    // if (password_verify($senha, $usuario['Usuario_senha'])) {
    
    if ($senha === $usuario['Usuario_senha']) { // Caso as senhas não estejam criptografadas
        unset($usuario['Usuario_senha']); // Remove a senha do retorno

        echo json_encode([
            'status' => "success",
            "mensagem" => "Login realizado com sucesso!",
            "usuario" => $usuario
        ]);
    } else {
        echo json_encode([
            'status' => "erro",
            'mensagem' => "Email ou senha incorretos"
        ]);
    }
} else {
    echo json_encode([
        'status' => "erro",
        'mensagem' => "Email ou senha incorretos"
    ]);
}
