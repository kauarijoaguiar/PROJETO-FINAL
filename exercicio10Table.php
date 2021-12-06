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
    function url($campo, $valor)
    {
        $result = array();
        if (isset($_GET[""])) $result["ASSUNTO"] = "ASSUNTO=" . $_GET["ASSUNTO"];
        if (isset($_GET["INTERACOES"])) $result["INTERACOES"] = "INTERACOES=" . $_GET["INTERACOES"];
        if (isset($_GET["orderby"])) $result["orderby"] = "orderby=" . $_GET["orderby"];
        if (isset($_GET["offset"])) $result["offset"] = "offset=" . $_GET["offset"];
        $result[$campo] = $campo . "=" . $valor;
        return ("exercicio12Table.php?NUMASSUNTOS=" . $_GET["NUMASSUNTOS"] . "&PAIS=" . $_GET["PAIS"] . "&NUMMESES=" .  $_GET["NUMMESES"] . "&" . strtr(implode("&", $result), " ", "+"));
    }

    $db = new SQLite3("face.db");
    $db->exec("PRAGMA foreign_keys = ON");




    echo "<table border=\"1\">\n";
    echo "<tr>\n";
    echo "<td><b>Número de usuários</b></td>\n";
    echo "</tr>\n";

  

    $total = $db->query("SELECT COALESCE(COUNT(*),0) AS TOTAL FROM (SELECT COUNT(*) AS QuantidadeUsuario FROM(
        SELECT USUARIO.NOME AS NOME, COUNT(REACAO.CODIGO) AS NUMEROREACOES FROM POST 
        JOIN REACAO ON POST.CODIGO= REACAO.COD_POST
        JOIN USUARIO ON POST.EMAIL_USUARIO=USUARIO.EMAIL
        WHERE (REACAO.DATAREACAO BETWEEN POST.DATAPOST
            AND DATE(POST.DATAPOST, '+" . $_GET["HORAS"] . " hour','-1 minute', 'localtime'))
            AND (POST.DATAPOST BETWEEN DATE('now', '-" . $_GET["DIAS"] . " days', 'localtime')
            AND DATE('NOW'))
            AND POST.PAIS = " . $_GET["PAIS"] . "
            GROUP BY POST
            HAVING NUMEROREACOES > " . $_GET["NUMCURTIDAS"] . "
        ));")->fetchArray()["TOTAL"];

    $results = $db->query("SELECT COUNT(*) AS QuantidadeUsuario FROM(
        SELECT USUARIO.NOME AS NOME, COUNT(REACAO.CODIGO) AS NUMEROREACOES FROM POST 
        JOIN REACAO ON POST.CODIGO= REACAO.COD_POST
        JOIN USUARIO ON POST.EMAIL_USUARIO=USUARIO.EMAIL
        WHERE (REACAO.DATAREACAO BETWEEN POST.DATAPOST
            AND DATE(POST.DATAPOST, '+" . $_GET["HORAS"] . " hour','-1 minute', 'localtime'))
            AND (POST.DATAPOST BETWEEN DATE('now', '-". $_GET["DIAS"]." days', 'localtime')
            AND DATE('NOW'))
            AND POST.PAIS = ". $_GET["PAIS"]."
            GROUP BY POST
            HAVING NUMEROREACOES > " . $_GET["NUMCURTIDAS"] . "
        );");

    while ($row = $results->fetchArray()) {
        echo "<tr>\n";
        echo "<td>" . $row["QuantidadeUsuario"] . "</td>\n";
        echo "</tr>\n";
    }

    echo "</table>\n";
    echo "<br>\n";

    $db->close();
    ?>
</body>
<?php


if (isset($_POST["Inclui"])) {
    echo "<script>setTimeout(function () { window.open(\"index.html\",\"_self\"); }, 1000);</script>";
}


?>

</html>