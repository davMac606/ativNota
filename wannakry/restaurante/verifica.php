<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Consulta de Pratos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            text-align: center;
            margin: 0;
            padding: 0;
            font-size: 20px;
        }
        .navbar {
            background-color: #333;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar h1 {
            font-size: 32px;
            margin: 0;
        }
        .menu-button {
            background-color: #333;
            color: white;
            border: none;
            padding: 10px 20px;
            margin: 10px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 20px;
           display: block;
           text-align: center;
           align-items: center;
              justify-content: center;


        }
         .menu-button:hover {
            background-color: #555;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }
        table {
            border-collapse: collapse;
            width: 80%;
            background-color: #fff;
            margin-top: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            
        }
        th, td {
            border: 1px solid #ddd;
            padding: 16px;
            text-align: center;
            align-items: center;
            justify-content: center;

        }
        th {
            background-color: #f2f2f2;
        }
        h2 {
            margin-top: 20px;
        }
        a {
            text-decoration: none;
            color: #333;
        }
        a:hover {
            color: #555;
        }
        .form-container {
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        .form-container p {
            font-weight: bold;
            font-size: 20px;
            margin-bottom: 10px;
        }
        .form-container input[type="text"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container input[type="submit"] {
            background-color: #333;
            color: white;
            border: none;
            padding: 10px 20px;
            margin: 10px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 20px;
        }
        .form-container input[type="submit"]:hover {
            background-color: #555;
        }
        .form-container label {
            font-weight: bold;
            font-size: 20px;
        }
        .form-container input[type="radio"] {
            margin-right: 10px;
        }
        #error-message {
            text-align: center;
            font-weight: bold;
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            font-size: 20px;
        }

        #error-message {
            background-color: #f44336;
            color: white;
        }

        #success-message {
            text-align: center;
            font-weight: bold;
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            font-size: 20px;
        }

        #success-message {
            background-color: green;
            color: white;
        }

        #nomePrato {
            font-size: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="navbar">
    <h1>Consulta de Pratos</h1>
    <form method="post">
        <button class="menu-button" type="submit" formaction="adiciona.php">Inserir Prato</button>
        <button class="menu-button" type="submit" formaction="index.html">Voltar</button>
    </form>
</div>
<div class="container">
    <div class="form-container">
        <form method="post">
            <strong>Nome do prato:</strong>
            <input type="text" name="nomePrato">
            
            <input type="checkbox" name="vegetariano" value="1"> Somente Vegetarianos
            <br>
            <br>
            
            <label>Ordenar por:</label>
            <input type="radio" name="ordenarPor" value="nomePrato"> Nome
            <input type="radio" name="ordenarPor" value="precoPrato"> Preço Mais Baixo
            <br>
            <br>
            <input type="submit" value="Consultar" class="menu-button">
        </form>
    </div>

    <?php
    include("conexaoBD.php");

    $nomePrato = isset($_POST["nomePrato"]) ? $_POST["nomePrato"] : "";
    $somenteVegetarianos = isset($_POST["vegetariano"]) && $_POST["vegetariano"] == "1";

    try {
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            $ordenarPor = isset($_POST["ordenarPor"]) ? $_POST["ordenarPor"] : "nomePrato"; // Ordenar por nome por padrão

            if ($nomePrato != "") {
                // Se um nome de prato for especificado na pesquisa
                $stmt = $pdo->prepare("SELECT * FROM pratosPHP 
                    WHERE nomePrato LIKE :nomePrato " . ($somenteVegetarianos ? "AND ingredientesPrato NOT LIKE '%carne%'" : "") . "
                    ORDER BY $ordenarPor, precoPrato, imagemPrato");
                $stmt->bindValue(':nomePrato', '%' . $nomePrato . '%', PDO::PARAM_STR);
            } else {
                // Se nenhum nome de prato for especificado na pesquisa
                $stmt = $pdo->prepare("SELECT * FROM pratosPHP 
                    " . ($somenteVegetarianos ? "WHERE ingredientesPrato NOT LIKE '%carne%'" : "") . "
                    ORDER BY $ordenarPor, precoPrato, imagemPrato");
            }

            // Buscando dados
            $stmt->execute();

            echo "<table>";
            echo "<tr><th>Nome</th><th>Preço em reais </th><th>Ingredientes</th><th>Peso do Prato em gramas</th><th>Foto</th> <th>Edição</th> <th>Exclusão</th></tr>";

            $resultFound = false; // Variável para verificar se algum resultado foi encontrado
            while ($row = $stmt->fetch()) {
                echo "<tr>";
                echo "<td class='editable' contenteditable='true' data-column='nomePrato'>" . $row['nomePrato'] . "</td>";
                echo "<td class='editable' contenteditable='true' data-column='precoPrato'> " . $row['precoPrato'] . "</td>";
                echo "<td class='editable' contenteditable='true' data-column='ingredientesPrato'>" . $row['ingredientesPrato'] . "</td>";
                echo "<td class='editable' contenteditable='true' data-column='pesoPrato'>" . $row['pesoPrato'] . "</td>";
                echo "<td class='editable' contenteditable='true' data-column='imagemPrato'>    <img src='upload/pratos/" . $row['imagemPrato'] . "' width='100px'></td>";



                echo "<td>";
                echo "<button class='menu-button edit-button' onclick='toggleEdit(this)'>Editar</button>";
                echo "<button class='menu-button confirm-button' style='display: none' onclick='confirmEdit(this)'>Confirmar</button>";
                echo "</td>";
               

echo "<td>";
                echo "<button class='menu-button remove-button' onclick='removeRow(this)'>Excluir</button>";
              
                echo "</td>";
               
               
                echo "</tr>";
                $resultFound = true;
            }

            echo "</table>";

            // Exibir mensagem se nenhum prato foi encontrado
            if (!$resultFound) {
                echo '<div id="error-message">Prato inexistente!</div>';
            }
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
    ?>

</div>
<script>
    function toggleEdit(button) {
        var row = button.parentNode.parentNode;
        var cells = row.querySelectorAll(".editable");
        var confirmButton = row.querySelector(".confirm-button");
        var editButton = row.querySelector(".edit-button");

        for (var i = 0; i < cells.length; i++) {
            cells[i].setAttribute("contenteditable", "true");
        }

        confirmButton.style.display = "block";
         

        editButton.style.display = "none";
    }

    function confirmEdit(button) {
        var row = button.parentNode.parentNode;
        var cells = row.querySelectorAll(".editable");
        var confirmButton = row.querySelector(".confirm-button");
        var editButton = row.querySelector(".edit-button");

        for (var i = 0; i < cells.length; i++) {
            cells[i].setAttribute("contenteditable", "false");
        }

        confirmButton.style.display = "none";
        editButton.style.display = "block";

        var nomePrato = row.querySelector("[data-column='nomePrato']").innerHTML;
        var precoPrato = row.querySelector("[data-column='precoPrato']").innerHTML;
        var ingredientesPrato = row.querySelector("[data-column='ingredientesPrato']").innerHTML;
        var pesoPrato = row.querySelector("[data-column='pesoPrato']").innerHTML;
        var imagemPrato = row.querySelector("[data-column='imagemPrato']").innerHTML;

        var formData = new FormData();
        formData.append("nomePrato", nomePrato);
        formData.append("precoPrato", precoPrato);
        formData.append("ingredientesPrato", ingredientesPrato);
        formData.append("pesoPrato", pesoPrato);
        formData.append("imagemPrato", imagemPrato);

        var request = new XMLHttpRequest();
        request.open("POST", "edita.php");
        request.send(formData);
    }

    function removeRow(button) {
        var row = button.parentNode.parentNode;
        var nomePrato = row.querySelector("[data-column='nomePrato']").innerHTML;

        var formData = new FormData();
        formData.append("nomePrato", nomePrato);

        var request = new XMLHttpRequest();
        request.open("POST", "remove.php");
        request.send(formData);

        row.parentNode.removeChild(row);
    }
    </script>

    
<script>
document.addEventListener("DOMContentLoaded", function() {
    window.addEventListener("beforeunload", function() {
        document.getElementById("error-message").style.display = "none";
    });
      

});</script>

</body>

</html>