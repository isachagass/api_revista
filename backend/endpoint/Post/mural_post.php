<?php
require_once '../database.php';

header('Content-Type: application/json');
$json = json_decode(file_get_contents("php://input"), true);

// Atualizando a consulta SQL de acordo com a nova tabela 'Murais'
$sql = $conn->prepare("INSERT INTO Murais (Mural_titulo, Mural_cont, Mural_img, usuarios_idUsuarios) 
                       VALUES (:titulo, :conteudo, :img, :fkUsuario)");

// Bind dos parâmetros para a execução da query
$sql->bindValue(':titulo', $json['Mural_titulo']);
$sql->bindValue(':conteudo', $json['Mural_cont']);
$sql->bindValue(':img', $json['Mural_img']);
$sql->bindValue(':fkUsuario', $json['usuarios_idUsuarios']);

// Executando a consulta SQL
$sql->execute();

// Verificando se a inserção foi bem-sucedida
if ($sql->rowCount() > 0) {
    $mensagem = [
        "status" => "success",
    ];
    echo json_encode($mensagem);
} else {
    $mensagem = [
        "status" => "erro",
    ];
    echo json_encode($mensagem);
}
?>
