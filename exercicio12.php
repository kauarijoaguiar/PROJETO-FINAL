<html>

<body>
    <?php
    function url($campo, $valor)
    {
        $result = array();
        if (isset($_GET["CODIGO"])) $result["CODIGO"] = "CODIGO=" . $_GET["CODIGO"];
        if (isset($_GET["NOMEGRUPO"])) $result["NOMEGRUPO"] = "NOMEGRUPO=" . $_GET["NOMEGRUPO"];
        if (isset($_GET["orderby"])) $result["orderby"] = "orderby=" . $_GET["orderby"];
        if (isset($_GET["offset"])) $result["offset"] = "offset=" . $_GET["offset"];
        $result[$campo] = $campo . "=" . $valor;
        return ("selectGrupo.php?" . strtr(implode("&", $result), " ", "+"));
    }

    $db = new SQLite3("face.db");
    $db->exec("PRAGMA foreign_keys = ON");

    echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
    echo '<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">';
    echo '<link rel="icon" href="icon.png">';
    echo '<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">';
    echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">';
    echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">';

    $limit = 5;

    echo " <div class=\"w3-bar w3-theme-d2 w3-left-align w3-large\">";
    echo "<p>Top <input type=\"number\" id=\"numAssuntos\" name=\"numAssuntos\" value=\"1\" min=\"1\" max=\"100\"> 
            assuntos mais interagidos por mês no país 
            <select id=\"campo\" name=\"campo\">
            <option value=\"Brasil\" selected>Brasil</option>
            </select>
            nos últimos 
            <input type=\"number\" id=\"numMeses\" name=\"numMeses\" value=\"1\" min=\"1\" max=\"100\"> mês(es)</p>";
    echo "</div>";
    echo '<div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">    ';



    $value = "";
    if (isset($_GET["CODIGO"])) $value = $_GET["CODIGO"];
    if (isset($_GET["NOMEGRUPO"])) $value = $_GET["NOMEGRUPO"];
    echo "";

    $parameters = array();
    if (isset($_GET["orderby"])) $parameters[] = "orderby=" . $_GET["orderby"];
    if (isset($_GET["offset"])) $parameters[] = "offset=" . $_GET["offset"];

    echo "<table align=\"center\">\n";
    echo "<tr>\n";
    echo "<td><b>Assunto</b></td>\n";
    echo "<td><b>Interações</b></td>\n";
    echo "</tr>\n";

    $where = array();
    $where[] = "ATIVO = 1";
    if (isset($_GET["CODIGO"])) $where[] = "CODIGO = " . $_GET["CODIGO"];
    if (isset($_GET["NOMEGRUPO"])) $where[] = "NOMEGRUPO like '%" . strtr($_GET["NOMEGRUPO"], " ", "%") . "%'";
    $where = (count($where) > 0) ? "where " . implode(" and ", $where) : "";

    $total = $db->query("select count(*) as total from grupo " . $where)->fetchArray()["total"];

    $orderby = (isset($_GET["orderby"])) ? $_GET["orderby"] : "CODIGO asc";

    $offset = (isset($_GET["offset"])) ? max(0, min($_GET["offset"], $total - 1)) : 0;
    $offset = $offset - ($offset % $limit);

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
            GROUP BY ASSUNTO
            ORDER BY INTERACOES DESC;");
    while ($row = $results->fetchArray()) {
        echo "<tr>\n";
        echo "<td>" . $row["ASSUNTO"] . "</td>\n";
        echo "<td>" . $row["INTERACOES"] . "</td>\n";
        echo "</tr>\n";
    }

    echo "</table>\n";
    echo "<br>\n";
    echo '</div>    ';


    for ($page = 0; $page < ceil($total / $limit); $page++) {
        echo (($offset == $page * $limit) ? ($page + 1) : "<a href=\"" . url("offset", $page * $limit) . "\">" . ($page + 1) . "</a>") . " \n";
    }

    $db->close();
    ?>
</body>

</html>