<?php
include("conexaoBD.php");

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $nomePrato = isset($_POST["nomePrato"]) ? $_POST["nomePrato"] : "";

    try {
        $stmt = $pdo->prepare("DELETE FROM pratosPHP WHERE nomePrato = :nomePrato");
        $stmt->bindValue(':nomePrato', $nomePrato, PDO::PARAM_STR);
        $stmt->execute();
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>