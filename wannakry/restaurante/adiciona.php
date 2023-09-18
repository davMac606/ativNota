<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Pratos</title>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    >
    <style>
        body {
            background-color: #f0f8ff;
            font-family: Arial, sans-serif;
            font-size: 18px; 
            margin: 0;
            
        }
        .navbar {
            background-color: #333;
            color: white;
            padding: 8px;
            text-align: right;
        }
        .navbar .btn-back {
            background-color: #333;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s;
            border-radius: 5px; 
        }
        .navbar .btn-back:hover {
            background-color: #555;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center; 
            justify-content: center; 
            min-height: 85vh;
        }
        .form-container {
            width: 50%;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        h1 {
            color: white;
            font-size: 32px;
            text-align: center;
            font-weight: bold;
        }
        form {
            text-align: left;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-row {
            margin-bottom: 15px;
        }
        .btn-submit {
            background-color: #333;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin: 0 auto;
            display: block;
            border-radius: 5px;
        }
        .btn-submit:hover {
            background-color: #555;
        }
        input[type="text"],
        input[type="number"],
        input[type="file"] {
            border-radius: 5px; 
            padding: 8px;
            width: 100%;
            border: 1px solid #ccc;
        }
        
        #success-message, #error-message {
            text-align: center;
            font-weight: bold;
            margin-top: 20px;
            
            padding: 10px;
            border-radius: 5px;
 position: fixed; 
    bottom: 0;
    left: 0;
    width: 100%; 
    background-color: #f44336;
    color: white;
    text-align: center;
    padding: 10px;
    font-weight: bold;
    border-radius: 5px;
  

        }
        #success-message {
            background-color: #4CAF50;
            color: white;
        }
        #error-message {
            background-color: #f44336;
            color: white;
        }

        .navbar {
            background-color: #333;
            color: white;
            padding: 15px;
            text-align: center;
        }
        
        .navbar .menu-button {
            background-color: #333;
            color: white;
            border: none;
            padding: 10px 20px;
            margin: 10px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 20px;
        }
        .navbar .menu-button:hover {
            background-color: #555;
        }

    </style>
</head>
<body>
<div class="navbar">
    <h1 style="margin: 0; padding: 8px; float: left;">Cadastro de Pratos</h1>
    <form method="post" style="float: right;">
       
        <button class="menu-button" type="submit" formaction="verifica.php">Consultar Pratos</button>
        <button class="menu-button" type="submit" formaction="index.html">Voltar</button>
    </form>
</div>


    <div class="container">
        <div class="form-container">
            <form method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="col-md-6">
                        <label for="nomePrato">Nome do prato:</label>
                        <input type="text" name="nomePrato" id="nomePrato" required>
                    </div>
                    <div class="col-md-6">
                        <label for="precoPrato">Preço:</label>
                        <input type="number" name="precoPrato" id="precoPrato" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6">
                        <label for="ingredientesPrato">Ingredientes:</label>
                        <input type="text" name="ingredientesPrato" id="ingredientesPrato" required>
                    </div>
                    <div class="col-md-6">
                        <label for="pesoPrato">Peso em gramas:</label>
                        <input type="number" name="pesoPrato" id="pesoPrato" required>
                    </div>
                </div>
                <div class="form-row">
                    <label for="foto">Selecionar Imagem:</label>
                    <input type="file" name="imagemPrato" id="imagemPrato" accept="image/*" required>
                </div>
                <div class="form-row">
                    <button type="submit" class="btn-submit">Inserir</button>
                </div>
            </form>
        </div>
    </div>
    <?php
include("conexaoBD.php");

define('TAMANHO_MAXIMO', (2 * 1024 * 1024));

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    try {
        $nomePrato = isset($_POST['nomePrato']) ? $_POST['nomePrato'] : "";
        $precoPrato = isset($_POST['precoPrato']) ? (float) $_POST['precoPrato'] : 0;
        $ingredientesPrato = isset($_POST['ingredientesPrato']) ? $_POST['ingredientesPrato'] : "";
        $pesoPrato = isset($_POST['pesoPrato']) ? (int) $_POST['pesoPrato'] : 0;

        $uploadDir = 'upload/pratos/';
        $uploadfile = "";

        $foto = isset($_FILES['imagemPrato']) ? $_FILES['imagemPrato'] : null;


        // Verifica se o campo nomePrato está vazio
        if (trim($nomePrato) == "") {
            echo '<div id="error-message">O nome do prato deve ser informado.</div>';
        } else if (trim($precoPrato) == 0) {
            echo '<div id="error-message">O preço do prato deve ser informado e maior que zero.</div>';
        } else if (trim($ingredientesPrato) == "") {
            echo '<div id="error-message">Os ingredientes do prato devem ser informados.</div>';
        } else if ($pesoPrato == 0) {
            echo '<div id="error-message">O peso do prato deve ser informado e maior que zero.</div>';
        } else if ($foto === null || $foto['error'] !== UPLOAD_ERR_OK) {
            echo '<div id="error-message">Erro no upload da imagem.</div>';
        } else if (!preg_match('/^image\/(jpeg|png|gif)$/', $foto['type'])) {
            echo '<div id="error-message">Isso não é uma imagem válida.</div>';
        } else if ($foto['size'] > TAMANHO_MAXIMO) {
            echo '<div id="error-message">A imagem deve possuir no máximo 2 MB.</div>';
        } else {
            $stmt = $pdo->prepare("SELECT * FROM pratosPHP WHERE nomePrato = :nomePrato");
            $stmt->bindParam(':nomePrato', $nomePrato);
            $stmt->execute();

            $rows = $stmt->rowCount();

            if ($rows <= 0) {
                $novoNomeFoto = substr($foto['name'], 0, 4) . "." . pathinfo($foto['name'], PATHINFO_EXTENSION);

                if (move_uploaded_file($foto['tmp_name'], $uploadDir . $novoNomeFoto)) {
                    $uploadfile = $uploadDir . $novoNomeFoto;
                } else {
                    $uploadfile = "";
                }

                $stmt = $pdo->prepare("INSERT INTO pratosPHP (nomePrato, precoPrato, ingredientesPrato, pesoPrato, imagemPrato) VALUES (:nome, :preco, :ingredientes, :peso, :imagem)");
                $stmt->bindParam(':nome', $nomePrato);
                $stmt->bindParam(':preco', $precoPrato);
                $stmt->bindParam(':ingredientes', $ingredientesPrato);
                $stmt->bindParam(':peso', $pesoPrato);
                $stmt->bindParam(':imagem', $uploadfile);
                $stmt->execute();

                echo '<div id="success-message">Prato cadastrado!</div>';
            } else if ($rows > 0) {
                echo '<div id="error-message">Prato já existente.</div>';
            }
        }
    } catch (PDOException $ex) {
        echo "Erro: " . $ex->getMessage();
    }
}
?>

    
<script>
document.addEventListener("DOMContentLoaded", function() {
    window.addEventListener("beforeunload", function() {
        document.getElementById("error-message").style.display = "none";
    });
      

});</script>

</body>
</html>
