<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edição de Pratos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
</head>

<body>
    <a href="index.html">Home</a> | <a href="verifyDishes.php">Consulta</a>
    <hr>
    <h1>Edição de pratos</h1>
</body>

</html>

<?php
require("funcoes.php");
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST["codigoPrato"])) {
        echo "Selecione um prato a ser alterado.";
    } else {
        $codigoPrato = $_POST["codigoPrato"];
        try {

            $stmt = prepAlter($codigoPrato);
            while ($row = $stmt->fetch()) {
                echo "<form method='post' action='alter.php' enctype='multipart/form-data'><br><br>
            <label for='codigoPrato'>Código do prato: </label>\n
            <input type='text' name='codigoPrato' value='$row[codigoPrato]' readonly>
            <label for='nomePrato'>Nome do prato: </label>\n
            <input type='text' name='nomePrato' value='$row[nomePrato]'> *\n
            <label for='precoPrato'>Preço: </label>\n
            <input type='text' name='precoPrato' value='$row[precoPrato]'> *\n
            <label for='ingredientesPrato'>Ingredientes: </label>\n
            <input type='text' name='ingredientesPrato' value='$row[ingredientesPrato]'> *\n
            <label for='novaFoto'>Foto: </label>\n
            <input type='file' name='novaFoto' accept='image/*'>\n

            <input type='submit' value='Atualizar'>
            <hr>


        
        
            </form>";
            }
        } catch (\PDOException $e) {

            echo $e->getMessage();
        }
    }

}

?>