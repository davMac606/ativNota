<?php

    require("funcoes.php");
    $codigoPrato = $_POST['codigoPrato'];
    $novoNome = $_POST['nomePrato'];
    $novoPreco = $_POST['precoPrato'];
    $novosIngredientes = $_POST['ingredientesPrato'];
    $novaFoto = $_FILES['novaFoto'];
    
    if (isset($_FILES['novaFoto']) && ($_FILES['novaFoto'] !== "")) {
        alterDish($codigoPrato, $novoNome, $novoPreco, $novosIngredientes, $novaFoto);
    } else {
        alterNoPic($codigoPrato, $novoNome, $novoPreco, $novosIngredientes);
    }   

?>