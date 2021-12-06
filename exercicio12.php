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

        $pais = $db->query("SELECT * FROM paises");


        echo " <div class=\"w3-bar w3-theme-d2 w3-left-align w3-large\">";
        echo "<p>Top <input type=\"number\" id=\"numAssuntos\" name=\"numAssuntos\" value=\"5\" min=\"1\" max=\"100\"> 
            assuntos mais interagidos por mês no país 
            <select id=\"pais\" name=\"pais\">";
        while ($listaPaises = $pais->fetchArray()) {
            echo "<option value=\"" . $listaPaises["CODIGO"] . "\"" . ($listaPaises["NOME"]  == 'Brasil' ? " selected " : "") . ">" . $listaPaises["NOME"] . "</option>";
        }
        echo "</select> 
            nos últimos 
            <input type=\"number\" id=\"numMeses\" name=\"numMeses\" value=\"1\" min=\"1\" max=\"100\"> mês(es)</p>";

        echo "</div>";
        echo '<div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">    ';

        echo '<input type="button" name="Pesquisar" value="Pesquisar" onClick="enviar();">';


        echo '</form>';
        echo '<script>';

        echo 'function enviar() {';
        echo 'let numAssuntos = document.getElementById("numAssuntos").value;';
        echo 'let numMeses = document.getElementById("numMeses").value;';
        echo 'let pais = document.getElementById("pais").value;';
        echo 'window.location.href = (window.location.href).replace("exercicio12.php", "exercicio12Table.php?NUMASSUNTOS="+numAssuntos+"&PAIS="+pais+"&NUMMESES="+numMeses);';
        echo '}';
        echo '</script>';

    ?>
</body>

</html>