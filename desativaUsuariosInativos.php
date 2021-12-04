<html>

<head>
    <title>Desativar Usuários Inativos</title>
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
    if (isset($_POST["Desativar"])) {
        $error = "";
        if ($error == "") {
            $db = new SQLite3("face.db");
            $db->exec("PRAGMA foreign_keys = ON");

            $db->exec("UPDATE USUARIO
                SET ATIVO = 0
                FROM (SELECT CASE WHEN MAX(DATAPOST) IS NULL THEN DATETIME('1900-01-01') ELSE MAX(DATAPOST) END AS DATAMAXIMA, EMAIL FROM USUARIO LEFT JOIN POST ON POST.EMAIL_USUARIO = USUARIO.EMAIL GROUP BY EMAIL) AS POST, 
                (SELECT CASE WHEN MAX(DATACOMPARTILHAMENTO) IS NULL THEN DATETIME('1900-01-01') ELSE MAX(DATACOMPARTILHAMENTO) END AS DATAMAXIMA, EMAIL FROM USUARIO LEFT JOIN COMPARTILHAMENTO ON COMPARTILHAMENTO.EMAIL_USUARIO = USUARIO.EMAIL GROUP BY EMAIL) AS COMPARTILHAMENTO,
                (SELECT CASE WHEN MAX(DATAREACAO) IS NULL THEN DATETIME('1900-01-01') ELSE MAX(DATAREACAO) END AS DATAMAXIMA, EMAIL FROM USUARIO LEFT JOIN REACAO ON REACAO.EMAIL_USUARIO = USUARIO.EMAIL GROUP BY EMAIL) AS REACAO
                WHERE 
                (USUARIO.EMAIL = POST.EMAIL AND POST.DATAMAXIMA < DATE('now', '-". $_POST["numAnos"]." years', 'localtime'))
                AND 
                (USUARIO.EMAIL = COMPARTILHAMENTO.EMAIL AND COMPARTILHAMENTO.DATAMAXIMA < DATE('now', '-" . $_POST["numAnos"] . " years', 'localtime'))
                AND 
                (USUARIO.EMAIL = REACAO.EMAIL AND REACAO.DATAMAXIMA < DATE('now', '-" . $_POST["numAnos"] . " years', 'localtime'))
                AND USUARIO.PAIS='". $_POST["pais"]."';");


        
            echo "Usuários inativos desativados";
            $db->close();
        } else {
            echo "<font color=\"red\">" . $error . "</font>";
        }
    } else {
        $db = new SQLite3("face.db");

        echo '<form name="desativa" method="post">';

        echo " <div class=\"w3-bar w3-theme-d2 w3-left-align w3-large\">";

        echo '<p>Desativar temporariamente as contas dos usuários do país ';
        $pais = $db->query("SELECT * FROM PAISES");
        echo '<select name="pais" id="pais">';
        echo '<option value="" disabled selected>Escolha um país</option>';
        while ($listapais = $pais->fetchArray()) {
            echo "<option value=\"" . $listapais["CODIGO"] . "\">" . $listapais["NOME"] . "</option>";
        }
        echo '</select>';
        echo ' que não possuem qualquer interação há mais de ';
        echo ' <input type="number" id="numAnos" name="numAnos" value="1" min="1" max="100"> ';
        echo ' ano(s) </p>';
        echo '</div>';

        echo '<input type="submit" name="Desativar" value="Desativar">';


        echo '</form>';
    }

    ?>
</body>
<?php


if (isset($_POST["Inclui"])) {
    echo "<script>setTimeout(function () { window.open(\"index.html\",\"_self\"); }, 1000);</script>";
}


?>

</html>