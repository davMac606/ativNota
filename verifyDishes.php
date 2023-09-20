<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Consulta de Pratos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
</head>

<body>

    <a href="index.html">Home</a>
    <hr>

    <h2>Consulta de pratos</h2>
    <div>
        <form method="post">

            Código do prato:<br>
            <input type="text" size="10" name="codigoPrato">
            <input type="submit" value="Consultar">
            <hr>
        </form>
    </div>

</body>

</html>

<?php
require("funcoes.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $codigoPrato = $_POST["codigoPrato"];
    if (isset($_POST["codigoPrato"]) && ($_POST["codigoPrato"] !== "")) {
        consultaParam($codigoPrato);
    } else {
        consulta();
    }


}
?>