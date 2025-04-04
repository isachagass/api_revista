<?php
require_once '../database.php';

header('Content-Type: application/json');


if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["status" => "error", "message" => "Método inválido"]);
    exit;
}

$atividade_titulo = $_POST['Atividade_titulo'] ?? null;
$atividade_cont = $_POST['Atividade_cont'] ?? null;
$atividade_exp = $_POST['Atividade_exp'] ?? null;
$materia_id = $_POST['Matéria_idMatéria'] ?? null;
$usuario_id = $_POST['Usuarios_idUsuarios'] ?? null;


if (isset($_FILES["Atividade_img"]) && $_FILES["Atividade_img"]["error"] === 0) {
    $nomeArquivo = basename($_FILES["Atividade_img"]["name"]);
    $caminhoDestino = "../../uploads/" . $nomeArquivo;

    

    // Tenta mover a imagem para a pasta correta
    if (move_uploaded_file($_FILES["Atividade_img"]["tmp_name"], $caminhoDestino)) {
        $atividade_img = $caminhoDestino;
    } else {
        echo json_encode(["status" => "error", "message" => "Falha ao salvar imagem"]);
        exit;
    }
} else {
    echo json_encode(["status" => "error", "message" => "Imagem não enviada corretamente"]);
    exit;
}


if (!$atividade_titulo || !$atividade_cont || !$atividade_exp || !$materia_id || !$usuario_id) {
    echo json_encode(["status" => "error", "message" => "Campos obrigatórios ausentes"]);
    exit;
}

try{
    $sql = $conn->prepare("INSERT INTO Atividades (Atividade_titulo, Atividade_cont, Atividade_exp, Atividade_img, Matéria_idMatéria, Usuarios_idUsuarios) VALUES (:titulo, :conteudo, :exp, :img, :fkmateria, :fkUsuario)");

    $sql->bindValue(':titulo', $atividade_titulo);
    $sql->bindValue(':img', $atividade_img);
    $sql->bindValue(':conteudo', $atividade_cont);
    $sql->bindValue(':exp', $atividade_exp);
    $sql->bindValue(':fkmateria', $materia_id);
    $sql->bindValue(':fkUsuario', $usuario_id);
    
    
    
    $sql->execute();

    if ($sql->rowCount() > 0) {
        echo json_encode(["status" => "success", "message" => "Conteúdo cadastrado com sucesso"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Falha ao inserir no banco de dados"]);
    }

} catch(PDOException $e){
    echo json_encode(["status" => "error", "message" => "Erro no banco de dados: " . $e->getMessage()]);
}





