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
    consulta($nomePrato);
    /*if (isset($_POST["codigoPrato"]) && ($_POST["codigoPrato"] !== "")) {
        $nomePrato = $_POST["nomePrato"];
        $stmt = $pdo->prepare("SELECT * FROM pratosPHP 
        WHERE nomePrato= :nomePrato ORDER BY codigoPrato, nomePrato, precoPrato, fotoPrato");
        $stmt->bindParam(':nomePrato', $codigoPrato);
    } else {
        $stmt = $pdo->prepare("SELECT * FROM pratosPHP ORDER BY codigoPrato, nomePrato, precoPrato, fotoPrato");
    }
    try {
        //buscando dados
        $stmt->execute();
    
        echo "<form method='post'><table border='1px'>";
        echo "<tr><th></th><th>Nome</th><th>Preço</th><th>Foto</th></tr>";
    
        while ($row = $stmt->fetch()) {
            echo "<tr>";
            echo "<td><input type='radio' name='idPrato' 
                 value='" . $row['codigoPrato'] . "'>";
                 echo "</td>";
            echo "<td>" . $row['nomePrato'] . "</td>";
            echo "<td>" . $row['precoPrato'] . "</td>";
    
            if ($row["fotoPrato"] == null) {
               echo "<td align='center'>-</td>";
           } else {
              echo "<td align='center'><img src=".$row['fotoPrato'] . " width='50px' height='50px'></td>";
           }
           echo "</tr>";
       }
    
        echo "</table><br>
        
        <button type='submit' formaction='remove.php'>Excluir Prato</button>
        <button type='submit' formaction='edicao.php'>Alterar Prato</button>
        
        </form>";
    
    
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }*/
}


?>