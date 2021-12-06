<html>

<head>
    <title>Sugerir amigos </title>
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
        if (isset($_GET["EMAIL"])) $result["EMAIL"] = "EMAIL=" . $_GET["EMAIL"];
        if (isset($_GET["NOME"])) $result["NOME"] = "NOME=" . $_GET["NOME"];
        if (isset($_GET["orderby"])) $result["orderby"] = "orderby=" . $_GET["orderby"];
        if (isset($_GET["offset"])) $result["offset"] = "offset=" . $_GET["offset"];
        $result[$campo] = $campo . "=" . $valor;
        return ("exercicio14Table.php?USUARIO=" . $_GET["USUARIO"]. "&NUMASSUNTO=". $_GET["NUMASSUNTO"]. "&TOP=" .  $_GET["TOP"] . "&NUMMESES" . $_GET["NUMMESES"] . "&" .strtr(implode("&", $result), " ", "+"));
    }

    $db = new SQLite3("face.db");
    $db->exec("PRAGMA foreign_keys = ON");

    //$limit = $_GET["NUMASSUNTOS"];


    echo "<select id=\"campo\" name=\"campo\">\n";
    echo "<option value=\"NOME\"" . ((isset($_GET["NOME"])) ? " selected" : "") . ">NOME</option>\n";
    echo "</select>\n";
    $value = "";
    if (isset($_GET["EMAIL"])) $value = $_GET["EMAIL"];
    if (isset($_GET["NOME"])) $value = $_GET["NOME"];
    echo "<input type=\" text\" id=\"valor\" name=\"valor\" value=\"" . $value . "\" size=\"20\"> \n";

    $parameters = array();
    if (isset($_GET["orderby"])) $parameters[] = "orderby=" . $_GET["orderby"];
    if (isset($_GET["offset"])) $parameters[] = "offset=" . $_GET["offset"];
    echo "<a href=\"\" title=\"Pesquisar\" onclick=\"value=document.getElementById('valor').value.trim().replace(/ +/g, '+' ); result='" . strtr(implode("&", $parameters), " ", "+") . "' ; result=((value !='' ) ? document.getElementById('campo').value+'='+value+((result != '') ? ' &' : '' ) : '' )+result; this.href='exercicio14Table.php?USUARIO=" . $_GET["USUARIO"]. "&NUMASSUNTO=". $_GET["NUMASSUNTO"]. "&TOP=" .  $_GET["TOP"] . "&NUMMESES" . $_GET["NUMMESES"] . "&" ."'+result;\">&#x1F50E;</a><br>\n";
    echo "<br>\n";

    echo "<table border=\"1\">\n";
    echo "<tr>\n";
    echo "<td><b>Assunto</b> <a href=\"" . url("orderby", "EMAIL+asc") . "\" title=\"Ordenação Ascendente\">&#x25BE;</a> <a href=\"" . url("orderby", "EMAIL+desc") . "\" title=\"Ordenação Descendente\">&#x25B4;</a></td>\n";
    echo "<td><b>Interações</b> <a href=\"" . url("orderby", "NOME+asc") . "\" title=\"Ordenação Ascendente\">&#x25BE;</a> <a href=\"" . url("orderby", "NOME+desc") . "\" title=\"Ordenação Descendente\">&#x25B4;</a></td>\n";
    echo "</tr>\n";

    $where = array();
    if (isset($_GET["EMAIL"])) $where[] = "EMAIL = " . $_GET["EMAIL"];
    if (isset($_GET["NOME"])) $where[] = "NOME like '%" . strtr($_GET["NOME"], " ", "%") . "%'";
    $where = (count($where) > 0 ? " and " : "" ).implode("", $where);

    $total = $db->query("SELECT COALESCE(COUNT(*),0) AS TOTAL FROM (SELECT ASSUNTO, COUNT(ASSUNTO) AS INTERACOES FROM POST
            JOIN ASSUNTOPOST ON POST.CODIGO= ASSUNTOPOST.CODIGOPOST
            JOIN ASSUNTO ON ASSUNTO.CODIGO= ASSUNTOPOST.CODIGOASSUNTO
            JOIN(
            SELECT COUNT(*) AS REACAO FROM REACAO
            GROUP BY COD_POST
            )
            JOIN(
            SELECT COUNT(*) AS COMPARTILHAMENTO FROM COMPARTILHAMENTO
            GROUP BY COD_POST)
            WHERE 
            POST.PAIS=" . $_GET["PAIS"] . " AND 
            POST.DATAPOST BETWEEN DATE('now', '-" . $_GET["NUMMESES"] . " month', 'localtime') AND DATE('now', 'localtime') "
            . $where .
            " GROUP BY ASSUNTO
            LIMIT " . $_GET["NUMASSUNTOS"] . ");")->fetchArray()["TOTAL"];

    $orderby = (isset($_GET["orderby"])) ? $_GET["orderby"] : "INTERACOES desc";

    $offset = (isset($_GET["offset"])) ? max(0, min($_GET["offset"], $total - 1)) : 0;
    $offset = $offset - ($offset % $limit);

    // $results = $db->query("SELECT ASSUNTO, COUNT(ASSUNTO) AS INTERACOES FROM POST
    //         JOIN ASSUNTOPOST ON POST.CODIGO= ASSUNTOPOST.CODIGOPOST
    //         JOIN ASSUNTO ON ASSUNTO.CODIGO= ASSUNTOPOST.CODIGOASSUNTO
    //         JOIN(
    //         SELECT COUNT(*) AS REACAO FROM REACAO
    //         GROUP BY COD_POST
    //         )
    //         JOIN(
    //         SELECT COUNT(*) AS COMPARTILHAMENTO FROM COMPARTILHAMENTO
    //         GROUP BY COD_POST)
    //         WHERE 
    //         POST.PAIS=" . $_GET["PAIS"] . " AND 
    //         POST.DATAPOST BETWEEN DATE('now', '-" . $_GET["NUMMESES"] ." months', 'localtime') AND DATE('now', 'localtime')"
    //        . $where .
            
    //         "GROUP BY ASSUNTO 
    //         ORDER BY " . $orderby 
    //         . $where . " limit " . $limit . " offset " . $offset);

$results = $db->query("SELECT ASSUNTO, COUNT(ASSUNTO) AS INTERACOES FROM POST
            JOIN ASSUNTOPOST ON POST.CODIGO= ASSUNTOPOST.CODIGOPOST
            JOIN ASSUNTO ON ASSUNTO.CODIGO= ASSUNTOPOST.CODIGOASSUNTO
            JOIN(
            SELECT COUNT(*) AS REACAO FROM REACAO
            GROUP BY COD_POST
            )
            JOIN(
            SELECT COUNT(*) AS COMPARTILHAMENTO FROM COMPARTILHAMENTO
            GROUP BY COD_POST)
            WHERE 
            POST.PAIS='Brasil' AND 
            POST.DATAPOST BETWEEN DATE('now', '-" . $_GET["NUMMESES"] .
        " months', 'localtime') AND DATE('now', 'localtime') "
            . $where .
            " GROUP BY ASSUNTO 
            ORDER BY " . $orderby
     . " limit " . $limit . " offset " . $offset);

    while ($row = $results->fetchArray()) {
        echo "<tr>\n";
        echo "<td>" . $row["ASSUNTO"] . "</td>\n";
        echo "<td>" . $row["INTERACOES"] . "</td>\n";
        echo "</tr>\n";
    }

    echo "</table>\n";
    echo "<br>\n";

    for ($page = 0; $page < ceil($total / $limit); $page++) {
        echo (($offset == $page * $limit) ? ($page + 1) : "<a href=\"" . url(" offset", $page * $limit) . "\">" . ($page + 1) . "</a>") . " \n";
    }

    $db->close();
    ?>
</body>
<?php


if (isset($_POST["Inclui"])) {
    echo "<script>setTimeout(function () { window.open(\"index.html\",\"_self\"); }, 1000);</script>";
}


?>

</html>