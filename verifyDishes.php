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
    include("conexaoBD.php");

     if ($_SERVER["REQUEST_METHOD"] === 'POST') {

         if (isset($_POST["nomePrato"]) && ($_POST["nomePrato"] != "")) {
             $nomePrato = $_POST["nomePrato"];
             $stmt = $pdo->prepare("SELECT * FROM pratosPHP 
             where nomePrato= :nomePrato ORDER BY nomePrato, precoPrato, imagemPrato");
             $stmt->bindParam(':nomePrato', $nomePrato );
         } else {
             $stmt = $pdo->prepare("SELECT * FROM pratosPHP 
             ORDER BY nomePrato, precoPrato, imagemPrato");
         }

         try {
             //buscando dados
             $stmt->execute();

             echo "<form method='post'><table border='1px'>";
             echo "<tr><th></th><th>Nome</th><th>Preço</th><th>Foto</th></tr>";

             while ($row = $stmt->fetch()) {
                 echo "<tr>";
                 echo "<td><input type='radio' name='nomePrato' 
                      value='" . $row['nomePrato'] . "'>";
                      echo "</td>";
                 echo "<td>" . $row['nomePrato'] . "</td>";
                 echo "<td>" . $row['precoPrato'] . "</td>";

                 if ($row["imagemPrato"] == null) {
                     echo "<td align='center'>-</td>";
                 } else {
                    echo "<td align='center'><img src=".$row['imagemPrato'] . " width='50px' height='50px'></td>";
                 }
                 echo "</tr>";
             }

             echo "</table><br>
             
             <button type='submit' formaction='remove.php'>Excluir Prato</button>
             <button type='submit' formaction='edicao.php'>Alterar Prato</button>
             
             </form>";


         } catch (PDOException $e) {
             echo 'Error: ' . $e->getMessage();
         }

     }
?>