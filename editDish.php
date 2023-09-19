<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edição de Pratos</title>
</head>
    <body>
        <a href="index.html">Home</a> | <a href="verifyDishes.php">Consulta</a>
        <hr>
        <h1>Edição de pratos</h1>
    </body>
</html>

<?php
include("funcoes.php");
if($_SERVER["REQUEST_METHOD"] === "POST") {
if(isset($_POST["codigoPrato"])) {
    echo "Selecione um prato a ser alterado.";
} else {
    $codigoPrato = $_POST["codigoPrato"];
    try {

        $stmt = alterDish($codigoPrato);

    } catch (\PDOException $e) {

        echo $e->getMessage();
    
}
}
}

?>
