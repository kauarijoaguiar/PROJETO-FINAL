<html>

<head>
    <title>Curtidas em post de usuário</title>
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

    $pais = $db->query("SELECT * FROM paises");

    

    echo " <div class=\"w3-bar w3-theme-d2 w3-left-align w3-large\">";
    echo "<p> Quantos usuários receberam mais de <input type=\"number\" id=\"numCurtidas\" name=\"numCurtidas\" value=\"1\" min=\"1\" max=\"1000\"> 
    curtidas em uma postagem, em menos de 
    <input type=\"number\" id=\"horas\" name=\"horas\" value=\"1\" min=\"1\" max=\"1000\"> hora(s)</p>
    <p> após a postagem, no país
    <select id=\"pais\" name=\"pais\">";
    while ($listaPaises = $pais->fetchArray()) {
        echo "<option value=\"" . $listaPaises["CODIGO"] . "\"" . ($listaPaises["NOME"]  == 'Brazil' ? " selected " : "") . ">" . $listaPaises["NOME"] . "</option>";
    }
    echo "</select> 
            nos últimos
            <input type=\"number\" id=\"numDias\" name=\"numDias\" value=\"1\" min=\"1\" max=\"100\"> dia(s)</p>";
    echo '<div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">    ';

    echo '<input type="button" name="Pesquisar" value="Pesquisar" onClick="enviar();">';


    echo '</form>';
    echo '<script>';

    echo 'function enviar() {';
    echo 'let numCurtidas = document.getElementById("numCurtidas").value;';
    echo 'let pais = document.getElementById("pais").value;';
    echo 'let horas = document.getElementById("horas").value;';
    echo 'let numDias = document.getElementById("numDias").value;';
    echo 'window.location.href = (window.location.href).replace("exercicio10.php", "exercicio10Table.php?NUMCURTIDAS="+numCurtidas+"&PAIS="+pais+"&HORAS="+horas+"&DIAS="+numDias);';
    echo '}';
    echo '</script>';

    ?>
</body>

</html>