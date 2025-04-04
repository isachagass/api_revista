<?php

require_once '../database.php';

header("Content-Type: application/json");

// Certifique-se de que está recebendo dados de um formulário multipart/form-data
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["status" => "error", "message" => "Método inválido"]);
    exit;
}

// Captura os dados do formulário
$catalogo_titulo = $_POST["Catalogo_titulo"] ?? null;
$catalogo_sinopse = $_POST["Catalogo_sinopse"] ?? null;
$id_user = $_POST["usuarios_idUsuarios"] ?? null;

// Captura a imagem
if (isset($_FILES["Catalogo_img"]) && $_FILES["Catalogo_img"]["error"] === 0) {
    $nomeArquivo = basename($_FILES["Catalogo_img"]["name"]);
    $caminhoDestino = "../../uploads/" . $nomeArquivo;

    

    // Tenta mover a imagem para a pasta correta
    if (move_uploaded_file($_FILES["Catalogo_img"]["tmp_name"], $caminhoDestino)) {
        $catalogo_imagem = $caminhoDestino;
    } else {
        echo json_encode(["status" => "error", "message" => "Falha ao salvar imagem"]);
        exit;
    }
} else {
    echo json_encode(["status" => "error", "message" => "Imagem não enviada corretamente"]);
    exit;
}

// Verifica se todos os campos obrigatórios estão preenchidos
if (!$catalogo_titulo || !$catalogo_sinopse || !$id_user) {
    echo json_encode(["status" => "error", "message" => "Campos obrigatórios ausentes"]);
    exit;
}

// Tenta inserir no banco de dados
try {
    $sql = $conn->prepare("INSERT INTO Catalogos (Catalogo_titulo, Catalogo_sinopse, Catalogo_img, usuarios_idUsuarios) VALUES (:titulo, :sinopse, :img, :fkidUser)");
    $sql->bindValue(':titulo', $catalogo_titulo);
    $sql->bindValue(':sinopse', $catalogo_sinopse);
    $sql->bindValue(':img', $catalogo_imagem);
    $sql->bindValue(':fkidUser', $id_user);

    $sql->execute();

    if ($sql->rowCount() > 0) {
        echo json_encode(["status" => "success", "message" => "Livro cadastrado com sucesso"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Falha ao inserir no banco de dados"]);
    }
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Erro no banco de dados: " . $e->getMessage()]);
}
