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
        <label for="nome">Nome do prato:</label>
        <input type="text" name="nomePrato" id="nomePrato" required> *
        <br><br>

        <label for="preco">Preço:</label>
        <input type="text" name="precoPrato" id="precoPrato" required> *
        <br><br>

        <label for="ingredientes">Ingredientes:</label>
        <input type="text" name="ingredientesPrato" id="ingredientesPrato">
        <br><br>

        <label for="imagem">Imagem:</label>
        <input type="file" name="imagemPrato" id="imagemPrato" accept="image/*" required> *
        <br><br>

        <input type="submit" value="Inserir">
</body>

</html>
<?php

include("conexaoBD.php");

define('TAMANHO_MAXIMO', (2 * 1024 * 1024));

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    try {
        $nomePrato = $_POST['nomePrato'];
        $precoPrato = (float) $_POST['precoPrato'];
        $ingredientesPrato = $_POST['ingredientesPrato'];

        $uploadDir = 'upload/pratos';

        $imagem = $_FILES['imagemPrato'];
        $nomeImagem = $imagem['name'];
        $tipoImagem = $imagem['type'];
        $tamanhoImagem = $imagem['size'];

        $info = new SPLFileInfo($nomeImagem);
        $extensao = $info->getExtension();
        $novoNomeImagem = substr($nomePrato, 1, 4) . "." . $extensao;

        if ((trim($nomePrato) == "")) {
            echo "O nome do prato deve ser informado.";
        } else if ((trim($precoPrato) == "")) {
            echo "O preço do prato deve ser informado.";
        } else if (($nomeImagem != "") && (!preg_match('/^image\/(jpeg|png|gif)$/', $tipoImagem))) { //validção tipo arquivo
            echo "<span id='error'>Isso não é uma imagem válida</span>";

        } else if (($nomeImagem != "") && ($tamanhoImagem > TAMANHO_MAXIMO)) { //validação tamanho arquivo
            echo "<span id='error'>A imagem deve possuir no máximo 2 MB</span>";
        } else {
            if (move_uploaded_file($imagem['tmp_name'], $uploadDir . '/' . $novoNomeImagem)) {
                $sql = "INSERT INTO Pratos (nomePrato, precoPrato, ingredientesPrato, imagemPrato) VALUES (:nome, :preco, :ingredientes, :imagem)";

                $stmt = $pdo->prepare($sql);

                $stmt->bindParam(':nome', $nomePrato);
                $stmt->bindParam(':preco', $precoPrato);
                $stmt->bindParam(':ingredientes', $ingredientesPrato);
                $stmt->bindParam(':imagem', $novoNomeImagem);

                $stmt->execute();

                $rows = $stmt->rowCount();

                if ($rows <= 0) {
                    if ((move_uploaded_file($_FILES['foto']['tmp_name'], $uploadDir . $novoNomeImagem))) {
                        $uploadFile = $uploadDir . $novoNomeImagem;
                    } else {
                        echo "Falha no upload da imagem.";
                        $uploadFile = null;
                    }

                    $stmt = $pdo -> prepare("INSERT INTO Pratos (nome, preco, ingredientes, imagem) VALUES (:nome, :preco, :ingredientes, :imagem)");
                    $stmt -> bindParam(':nome', $nomePrato);
                    $stmt -> bindParam(':preco', $precoPrato);
                    $stmt -> bindParam(':ingredientes', $ingredientesPrato);
                    $stmt -> bindParam(':imagem', $uploadFile);
                    $stmt -> execute();

                    echo "Prato cadastrado com sucesso.";
                } else {
                    echo "Falha no cadastro do prato.";
                }
            }

    
        }


    } catch (PDOException $ex) {
        echo "Erro: " . $ex->getMessage();
    }
}
?>