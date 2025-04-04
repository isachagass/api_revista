<?php
require '../database.php';

try {
    $sql = "SELECT Catalogo_titulo, Catalogo_img, Catalogo_sinopse FROM Catalogos";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Obtém todos os registros de uma vez
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Adiciona o caminho correto para cada imagem
    $catalogos = array_map(function ($row) {
        return [
            "titulo" => $row["Catalogo_titulo"],
            "imagem" => "http://localhost/api_php/backend/uploads/" . $row["Catalogo_img"],
            "sinopse" => $row["Catalogo_sinopse"] // Adiciona a sinopse
        ];
    }, $resultados);

    header('Content-Type: application/json');
    echo json_encode($catalogos);

} catch (PDOException $e) {
    echo json_encode(["erro" => "Erro ao buscar catálogos: " . $e->getMessage()]);
}
?>
