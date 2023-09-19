<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Consulta de Pratos</title>
</head>

<body>

<a href="index.html">Home</a>
<hr>

<h2>Consulta de pratos</h2>
<div>
    <form method="post">

        Nome do prato:<br>
        <input type="text" size="10" name="nomePrato">
        <input type="submit" value="Consultar">
        <hr>
    </form>
</div>

</body>
</html>

<?php
include("funcoes.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nomePrato = $_POST["nomePrato"];
    if (isset($_POST["nomePrato"]) && ($_POST["nomePrato"] !== "")) {
        consultaParam($nomePrato);
    } else {
        consulta();
    }

}
?>