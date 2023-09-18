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

include("conexaoBD.php");

define('TAMANHO_MAXIMO', (2 * 1024 * 1024));

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    try {
        $codigoPrato = $_POST['codigoPrato'];
        $nomePrato = $_POST['nomePrato'];
        $precoPrato = (float) $_POST['precoPrato'];
        $ingredientesPrato = $_POST['ingredientesPrato'];

        $uploadDir = 'upload/pratos/';

        $foto = $_FILES['foto'];
        $nomeFoto = $foto['name'];
        $tipoFoto = $foto['type'];
        $tamanhoFoto = $foto['size'];

        $info = new SplFileInfo($nomeFoto);
        $extensaoArq = $info->getExtension();
        $novoNomeFoto = substr($nomeFoto, 1, 4) . "." . $extensaoArq;

        if ((trim($nomePrato) == "")) {
            echo "O nome do prato deve ser informado.";
        } else if ((trim($precoPrato) == "")) {
            echo "O preço do prato deve ser informado.";
        } else if (($nomeFoto != "") && (!preg_match('/^image\/(jpeg|png|gif)$/', $tipoFoto))) { //validção tipo arquivo
            echo "<span id='error'>Isso não é uma imagem válida</span>";

        } else if (($nomeFoto != "") && ($tamanhoFoto > TAMANHO_MAXIMO)) { //validação tamanho arquivo
            echo "<span id='error'>A imagem deve possuir no máximo 2 MB</span>";

        } else {
            $stmt = $pdo->prepare("SELECT * FROM pratosPHP WHERE nomePrato = :nomePrato");
            $stmt->bindParam(':nomePrato', $nomePrato);
            $stmt->execute();

            $rows = $stmt->rowCount();

            if ($rows <= 0) {
                if (($nomeFoto != "") && (move_uploaded_file($_FILES['foto']['tmp_name'], $uploadDir . $novoNomeFoto))) {
                    $uploadfile = $uploadDir . $novoNomeFoto; // caminho/nome da imagem
                } else {
                    $uploadfile = null;
                    echo "Sem upload de imagem.";
                }

                $stmt = $pdo->prepare("INSERT INTO pratosPHP (codigoPrato, nomePrato, precoPrato, ingredientesPrato, fotoPrato) VALUES (:codigo, :nome, :preco, :ingredientes, :imagem)");
                $stmt->bindParam(':codigo', $codigoPrato);
                $stmt->bindParam(':nome', $nomePrato);
                $stmt->bindParam(':preco', $precoPrato);
                $stmt->bindParam(':ingredientes', $ingredientesPrato);
                $stmt->bindParam(':imagem', $uploadfile);
                $stmt->execute();
                echo "<span id='sucess'>Prato cadastrado!</span>";
                } else {
                    echo "<span id='error'>prato já existente.</span>";
                }
            }           
            /*
             if (move_uploaded_file($imagem['tmp_name'], $uploadDir . '/' . $novoNomeImagem)) {
                $sql = "INSERT INTO pratosPHP (nomePrato, precoPrato, ingredientesPrato, fotoPrato) VALUES (:nome, :preco, :ingredientes, :imagem)";

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
                        echo $uploadFile;
                    } else {
                        echo "Falha no upload da imagem.";
                        $uploadFile = null;
                    }

                    $stmt = $pdo->prepare("INSERT INTO pratosPHP (nomePrato, precoPrato, ingredientesPrato, fotoPrato) VALUES (:nome, :preco, :ingredientes, :imagem)");
                    $stmt->bindParam(':nome', $nomePrato);
                    $stmt->bindParam(':preco', $precoPrato);
                    $stmt->bindParam(':ingredientes', $ingredientesPrato);
                    $stmt->bindParam(':imagem', $uploadFile);
                    $stmt->execute();

                    echo "Prato cadastrado com sucesso.";
                } else {
                    echo $uploadFile;
                    echo "Falha no cadastro do prato.";
                }
            }


        }

*/       
    } catch (PDOException $ex) {
        echo "Erro: " . $ex->getMessage();
    }
}
?>