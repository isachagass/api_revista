<?php
require_once '../database.php';

header('Content-Type: application/json');

$json = file_get_contents("php://input");
$dados = json_decode($json, true);

// Verifica se os dados foram recebidos corretamente
if (empty($dados)) {
    echo json_encode(["status" => "error", "message" => "Nenhum dado recebido"]);
    exit;
}

$atividade_titulo = $dados['Atividade_titulo'] ?? null;
$atividade_cont = $dados['Atividade_cont'] ?? null;
$atividade_exp = $dados['Atividade_exp'] ?? null;
$atividade_img = $dados['Atividade_img'];
$materia_id = $dados['Materia_idMateria'] ?? null;
$usuario_id = $dados['Usuarios_idUsuarios'] ?? null;

if (!$atividade_titulo || !$atividade_cont || !$atividade_exp || !$atividade_img || !$materia_id || !$usuario_id) {
    echo json_encode(["status" => "error", "message" => "Campos obrigatórios ausentes"]);
    exit;
}

try{
    $sql = $conn->prepare(query: "INSERT INTO Atividades VALUE(NULL, :titulo, :conteudo, :exp, :img, :fkmateria, :fkUsuario)");
    $sql->bindValue(':titulo', $json['Atividade_titulo']);
    $sql->bindValue(':img', $json['Atividade_img']);
    $sql->bindValue(':conteudo', $json['Atividade_cont']);
    $sql->bindValue(':exp', $json['Atividade_exp']);
    $sql->bindValue(':fkmateria', value: $json['Matéria_idMatéria']);
    $sql->bindValue(':fkUsuario', $json['Usuarios_idUsuarios']);
    
    
    
    $sql->execute();

    if ($sql->rowCount() > 0) {
        echo json_encode(["status" => "success", "message" => "Conteúdo cadastrado com sucesso"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Falha ao inserir no banco de dados"]);
    }

} catch(PDOException $e){
    echo json_encode(["status" => "error", "message" => "Erro no banco de dados: " . $e->getMessage()]);
}





