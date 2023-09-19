<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Pratos</title>
</head>

<body>
    <a href="index.html">Página principal</a>
    <hr>

    <hr>
    <h1>Cadastro de Pratos</h1>

    <hr>

    <form method='post' enctype="multipart/form-data">
        <label for="codigo">Código do prato:</label>
        <input type"text" name="codigoPrato" id="codigoPrato" required>
        <br><br>

        <label for="nome">Nome do prato:</label>
        <input type="text" name="nomePrato" id="nomePrato" required> *
        <br><br>

        <label for="preco">Preço:</label>
        <input type="text" name="precoPrato" id="precoPrato" required> *
        <br><br>

        <label for="ingredientes">Ingredientes:</label>
        <input type="text" name="ingredientesPrato" id="ingredientesPrato">
        <br><br>

        <label for="foto">Imagem:</label>
        <input type="file" name="foto" id="foto" accept="image/*" required> *
        <br><br>

        <input type="submit" value="Inserir">
</body>

</html>
<?php

define('TAMANHO_MAXIMO', (2 * 1024 * 1024));

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    include ("funcoes.php");
    try {
        $codigoPrato = $_POST['codigoPrato'];
        $nomePrato = $_POST['nomePrato'];
        $precoPrato = (float) $_POST['precoPrato'];
        $ingredientesPrato = $_POST['ingredientesPrato'];
        $foto = $_FILES['foto'];
    cadastra($codigoPrato, $nomePrato, $precoPrato, $ingredientesPrato, $foto);
    } catch (PDOException $ex) {
        echo "Erro: " . $ex->getMessage();
    }
}
?>