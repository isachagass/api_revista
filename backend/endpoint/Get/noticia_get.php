<?php
header("Content-Type: application/json");
require '../database.php';

$sql = "SELECT Usuario_nome, Matéria_tipo, Noticia_titulo, Noticia_img, Noticia_cont FROM Noticias INNER JOIN Usuarios ON Noticias.Usuarios_idUsuarios = Usuarios.idUsuarios JOIN Matéria ON Matéria.idMatéria = Noticias.Matéria_idMatéria";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($result);
// pega os conteudos certos para expor sobre as noticias como o titulo, conteudo, imagem,
// a qual matéria pertence, e o nome do usuria que a registrou