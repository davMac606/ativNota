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
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["codigoPrato"])) {
        echo "Selecione um prato a ser alterado.";
    } else {
        $codigoPrato = $_POST["codigoPrato"];
        try {

            $stmt = prepAlter($codigoPrato);

            echo "<form method='post' action='alter.php' enctype='multipart/form-data'>\n
            <label for='nomePrato'>Nome do prato: </label>\n
            <input type='text' name='nomePrato' value='$row[nomePrato]' required> *\n
            <label for='precoPrato'>Preço: </label>\n
            <input type='text' name='precoPrato' value='$row[precoPrato]' required> *\n
            <label for='ingredientesPrato'>Ingredientes: </label>\n
            <input type='text' name='ingredientesPrato' value='$row[ingredientesPrato]' required> *\n
            <label for='fotoPrato'>Foto: </label>\n
            <input type='file' name='fotoPrato' accept='image/*' value required>\n

            <input type='submit' value='Atualizar'>
            <hr>


        
        
            </form>";
        } catch (\PDOException $e) {

            echo $e->getMessage();
        }
    }
}

?>