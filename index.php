<?php

require_once "vendor/autoload.php";
?>
<!DOCTYPE html>

<html lang="pt">
 <head>

    <meta charset="utf-8">
    <title>DataFinder</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="src/styles/styleIndex.css" media="screen" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@1,700&family=Poppins:wght@300&display=swap" rel="stylesheet">

</head>

    <body>

        <div class='container'>

        <div class='containerMain'>
        <h1 style="font-family: 'Montserrat', sans-serif;">Digite aqui o CNPJ da empresa!</h1>
        <p style="font-family: 'Poppins', sans-serif;">Encontre o CNPJ, capital social, razão social, telefones, e-mail
        de contato e muito mais informações de 47 milhões de empresas.</p>
        <form action="src/formAction.php" method="get">
        <input type="text" name="inputCNPJ"  />
        <p><input type='submit' value="Procurar" style="font-family: 'Poppins', sans-serif;"/></p>

        </form> 
        </div>

        </div>
    </body>


</html>
