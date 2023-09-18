<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CRUD - Controle de alunos</title>
</head>

<body>

<a href="index.html">Home</a> | <a href="consulta.php">Consulta</a>
<hr>

<h2>Exclusão de Alunos</h2>

</body>
</html>

<?php
include("conexaoBD.php");

if (!isset($_POST["codigoPrato"])) {
    echo "Selecione um prato a ser excluído.";
} else {
    $idPrato = $_POST["codigoPrato"];
    try {
        $stmt = $pdo->prepare('SELECT fotoPrato FROM pratosPHP WHERE codigoPrato = :codigoPrato');
        $stmt->bindParam(':codigoPrato', $codigoPrato);
        $stmt->execute();
        $row = $stmt->fetch();
        $fotoPrato = $row["fotoPrato"];


        $stmt = $pdo->prepare("DELETE FROM pratosPHP WHERE codigoPrato = :codigoPrato");
        $stmt->bindValue(':codigoPrato', $codigoPrato, PDO::PARAM_STR);
        $stmt->execute();


        if ($fotoPrato != null) {
            unlink($fotoPrato);
        }
        
        echo $stmt->rowCount() . "prato removido!";
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }



}
    
?>