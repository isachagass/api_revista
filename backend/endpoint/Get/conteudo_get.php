<?php
header("Content-Type: application/json");
require '../database.php';

$sql = "SELECT Usuario_nome, Matéria_tipo, Conteudo_titulo, Conteudo_img, Conteudo_cont FROM Conteudos INNER JOIN Usuarios ON Conteudos.Usuarios_idUsuarios = Usuarios.idUsuarios JOIN Matéria ON Matéria.idMatéria = Conteudos.Matéria_idMatéria";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($result);
// pega os conteudos certos para expor sobre as noticias como o titulo, conteudo, imagem,
// a qual matéria pertence, e o nome do usuria que a registrou