<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Exclusão de Pratos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
</head>

<body>

    <a href="index.html">Home</a> | <a href="verifyDishes.php">Consulta</a>
    <hr>

    <h2>Exclusão de Alunos</h2>

</body>

</html>

<?php
include("funcoes.php");
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST["codigoPrato"])) {
        echo "Selecione um prato a ser excluído.";
    } else {
        $codigoPrato = $_POST["codigoPrato"];
        removePrato($codigoPrato);
    }
}

?>