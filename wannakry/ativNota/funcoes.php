<?php
function conectaBD() {
    try {        
        // conexão PDO    // IP, nomeBD, usuario, senha   
        $db = 'mysql:host=143.106.241.3;dbname=cl201238;charset=utf8';
        $user = 'cl201238';
        $passwd = 'cl*14032006';
        $pdo = new PDO($db, $user, $passwd);
    
        // ativar o depurador de erros para gerar exceptions em caso de erros
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
    
    } catch (PDOException $e) {
        $output = 'Impossível conectar BD : ' . $e . '<br>';
        echo $output;
    }    
}

function consulta($codigoPrato) {

   include("conexaoBD.php");
    if (isset($_POST["codigoPrato"]) && ($_POST["codigoPrato"] !== "")) {
        $codigoPrato = $_POST["codigoPrato"];
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
    }
}


?>