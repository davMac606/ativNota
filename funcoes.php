<?php
function conectaBD() {
        require("env.php");

        global $host, $database, $username, $password;

        $db = "mysql:host=$host;dbname=$database;charset=utf8";
        $pdo = new PDO($db, $username, $password);
    
        // ativar o depurador de erros para gerar exceptions em caso de erros
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
        return $pdo;
}

function cadastra($codigoPrato, $nomePrato, $precoPrato, $ingredientesPrato, $foto) {
    try {

    
    $pdo = conectaBD();
    $uploadDir = 'upload/pratos/';
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
        } catch (\PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }  

}
function consultaParam($nomePrato) {
    try {
        $pdo = conectaBD();
        $stmt = $pdo->prepare("SELECT codigoPrato, nomePrato, precoPrato, fotoPrato FROM pratosPHP WHERE nomePrato = :nomePrato ORDER BY codigoPrato, nomePrato, precoPrato, fotoPrato");
        $stmt->bindParam(':nomePrato',$nomePrato);
        
            $stmt->execute();

            echo "<form method='post'><table border='1px'>";
            echo "<tr><th></th><th>Nome</th><th>Preço</th><th>Foto</th></tr>";
    
            while ($row = $stmt->fetch()) {
                echo "<tr>";
                echo "<td><input type='radio' name='codigoPrato' 
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

function consulta() {
    $pdo = conectaBD();
        $stmt = $pdo->prepare("SELECT * FROM pratosPHP ORDER BY codigoPrato, nomePrato, precoPrato, fotoPrato");
        try {
            $stmt->execute();

            echo "<form method='post'><table border='1px'>";
            echo "<tr><th></th><th>Nome</th><th>Preço</th><th>Foto</th></tr>";
    
            while ($row = $stmt->fetch()) {
                echo "<tr>";
                echo "<td><input type='radio' name='codigoPrato' 
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
            
            <button type='submit' formaction='removeDish.php'>Excluir Prato</button>
            <button type='submit' formaction='alterDish.php'>Alterar Prato</button>
            
            </form>";
    
    
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        
    }
       
}

function removePrato($codigoPrato) {
    $pdo = conectaBD();
    $stmt =  $pdo->prepare('SELECT * FROM pratosPHP WHERE codigoPrato = :codigoPrato');
    $stmt = $pdo->prepare('DELETE FROM pratosPHP WHERE codigoPrato = :codigoPrato');
    $stmt->bindParam(':codigoPrato', $codigoPrato);
    $stmt->execute();
        $row = $stmt->fetch();
        $foto = $row["fotoPrato"];
        if ($foto != null) {
            unlink($foto);
        }
    echo "prato removido com sucesso!";
}

function alterDish($codigoPrato) {
    try {
    $pdo = conectaBD();
    $stmt = $pdo->prepare('UPDATE pratosPHP SET nomePrato = :nomePrato, precoPrato = :preco, ingredientesPrato = :ingredientes, fotoPrato = :foto
     WHERE codigoPrato = :codigoPrato');
    $stmt->bindParam(':novoNome', $nomePrato);
    $stmt->bindParam(':novoPreco', $precoPrato);
    $stmt->bindParam(':novosIngredientes', $ingredientesPrato);
    $stmt->bindParam(':novoFoto', $fotoPrato);
    $stmt->bindParam(':codigo', $codigoPrato);
    $stmt->execute();

    echo "Prato alterado com sucesso!";
} catch (PDOException $e) {
    echo 'Error: '. $e->getMessage();
}
}


?>