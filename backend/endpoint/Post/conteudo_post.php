<?php

// Definir cabeçalhos para permitir requisições de qualquer origem
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");

// Conexão com o banco de dados
require_once '../database.php';

// Lê os dados JSON enviados pelo frontend
$json = file_get_contents("php://input");
$dados = json_decode($json, true);

// Verifica se os dados foram recebidos corretamente
if (empty($dados)) {
    echo json_encode(["status" => "error", "message" => "Nenhum dado recebido"]);
    exit;
}

// Captura os dados corretamente e evita erro de acesso a valores nulos
$conteudo_titulo = $dados['Conteudo_titulo'] ?? null;
$conteudo_cont = $dados['Conteudo_cont'] ?? null;
$conteudo_tipo = $dados['Conteudo_tipo'] ?? null;
$materia_id = $dados['Materia_idMateria'] ?? null;
$conteudo_img = $dados['Conteudo_img'] ?? null;
$usuario_id = $dados['Usuarios_idUsuarios'] ?? null;

// Verifica se os campos obrigatórios estão preenchidos
if (!$conteudo_titulo || !$conteudo_cont || !$materia_id || !$usuario_id) {
    echo json_encode(["status" => "error", "message" => "Campos obrigatórios ausentes"]);
    exit;
}

try {
    // Prepara a query SQL para inserir os dados
    $sql = $conn->prepare("INSERT INTO Conteudos VALUES (NULL, :titulo, :img, :conteudo, :tipo, :fkUsuario, :fkMateria)");
    $sql->bindValue(':titulo', $conteudo_titulo);
    $sql->bindValue(':img', $conteudo_img);
    $sql->bindValue(':conteudo', $conteudo_cont);
    $sql->bindValue(':tipo', $conteudo_tipo);
    $sql->bindValue(':fkUsuario', $usuario_id);
    $sql->bindValue(':fkMateria', $materia_id);
    
    $sql->execute();

    // Se inseriu no banco, retorna sucesso
    if ($sql->rowCount() > 0) {
        echo json_encode(["status" => "success", "message" => "Conteúdo cadastrado com sucesso"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Falha ao inserir no banco de dados"]);
    }

} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Erro no banco de dados: " . $e->getMessage()]);
}

?>
