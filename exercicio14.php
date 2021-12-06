<html>

<head>
    <title>Assuntos mais interagidos</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="icon" href="icon.png">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <?php

    $db = new SQLite3("face.db");

    echo '<form name="Pesquisar" method="post">';

    $db->exec("PRAGMA foreign_keys = ON");

    $usuario = $db->query("SELECT USUARIO.NOME AS NOME FROM USUARIO");

    $assuntosmais = $db->query("SELECT ASSUNTO.ASSUNTO AS ASSUNTO, COUNT(ASSUNTO) AS QUANTIDADE FROM ASSUNTO 
    JOIN ASSUNTOPOST ON ASSUNTOPOST.CODIGOASSUNTO = ASSUNTO.CODIGO 
    JOIN POST ON ASSUNTOPOST.CODIGOPOST = POST.CODIGO 
    GROUP BY ASSUNTO.ASSUNTO 
    ORDER BY 2 DESC");


    echo " <div class=\"w3-bar w3-theme-d2 w3-left-align w3-large\">";
    echo "<p>Sugerir amigos para
    <select id=\"usuario\" name=\"usuario\">";
    while ($listausuario = $usuario->fetchArray()) {
        echo "<option value=\"" . $listausuario["EMAIL"] . "\"".">" . $listausuario["NOME"] . "</option>";
    }        
    echo "</select> ,considerando que, se o usuario selecionado e outro usuario não são amigos mas possuem no mínimo
    <input type=\"number\" id=\"numassuntos\" name=\"numassuntos\" value=\"1\" min=\"1\"> 
      assuntos em comum entre os
      <input type=\"number\" id=\"top\" name=\"top\" value=\"1\" min=\"1\" max=\"1000\"> 
        assuntos mais comentados por cada um nos últimos
        <input type=\"number\" id=\"nummeses\" name=\"nummeses\" value=\"1\" min=\"1\" max=\"1000\"> 
         meses, este sera sugerido como amigo para o usuario selecionado.</p>";
            echo "<br>\n";
            
            echo "</div>";
    echo '<div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">    ';

    echo '<input type="button" name="Pesquisar" value="Pesquisar" onClick="enviar();">';

    echo '</form>';
        echo '<script>';

        echo 'function enviar() {';
            echo 'let usuario = document.getElementById("usuario").value;';
            echo 'let numassuntos = document.getElementById("numassuntos").value;';
            echo 'let top = document.getElementById("top").value;';
            echo 'let nummeses = document.getElementById("nummeses").value;';
            echo 'window.location.href = (window.location.href).replace("exercicio14.php", "exercicio14Table.php?USUARIO="+usuario+"&NUMASSUNTO="+numassuntos+"&TOP="+top+"&NUMMESES="+nummeses);';
            echo '}';
            echo '</script>';
    
        ?>
    </body>
    
    </html>