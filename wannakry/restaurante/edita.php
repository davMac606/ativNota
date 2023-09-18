<?php
include("conexaoBD.php");

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $nomePrato = isset($_POST["nomePrato"]);
    $precoPrato = isset($_POST["precoPrato"]);
    $ingredientesPrato = isset($_POST["ingredientesPrato"]);
    $imagemPrato = isset($_POST["imagemPrato"]);

    try {
        $stmt = $pdo->prepare("UPDATE pratosPHP SET nomePrato = :nomePrato, precoPrato = :precoPrato, ingredientesPrato = :ingredientesPrato, imagemPrato = :imagemPrato  WHERE idPrato = :idPrato");
        $stmt->bindValue(':nomePrato', $nomePrato);
        $stmt->bindValue(':precoPrato', $precoPrato);
        $stmt->bindValue(':ingredientesPrato', $ingredientesPrato);
        $stmt->bindValue(':imagemPrato', $imagemPrato);
        $stmt->execute();
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>
