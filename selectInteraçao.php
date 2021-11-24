<html>

<body>
    <?php
    function url($campo, $valor)
    {
        $result = array();
        if (isset($_GET["CODIGO"])) $result["CODIGO"] = "CODIGO=" . $_GET["CODIGO"];
        if (isset($_GET["POST"])) $result["POST"] = "POST=" . $_GET["POST"];
        if (isset($_GET["DATAPOST"])) $result["DATAPOST"] = "DATAPOST=" . $_GET["DATAPOST"];
        if (isset($_GET["orderby"])) $result["orderby"] = "orderby=" . $_GET["orderby"];
        if (isset($_GET["offset"])) $result["offset"] = "offset=" . $_GET["offset"];
        $result[$campo] = $campo . "=" . $valor;
        return ("selectInteraçao.php?" . strtr(implode("&", $result), " ", "+"));
    }

    $db = new SQLite3("face.db");
    $db->exec("PRAGMA foreign_keys = ON");

    $limit = 5;

    echo "<h1>Comentários</h1>\n";

    echo "<select id=\"campo\" name=\"campo\">\n";
    echo "<option value=\"CODIGO\"" . ((isset($_GET["CODIGO"])) ? " selected" : "") . ">Código</option>\n";
    echo "<option value=\"POST\"" . ((isset($_GET["POST"])) ? " selected" : "") . ">Comentário</option>\n";
    echo "<option value=\"DATAPOST\"" . ((isset($_GET["DATAPOST"])) ? " selected" : "") . ">Data</option>\n";
    echo "</select>\n";

    $value = "";
    if (isset($_GET["CODIGO"])) $value = $_GET["CODIGO"];
    if (isset($_GET["POST"])) $value = $_GET["POST"];
    if (isset($_GET["DATAPOST"])) $value = $_GET["DATAPOST"];
    echo "<input type=\"text\" id=\"valor\" name=\"valor\" value=\"" . $value . "\" size=\"20\"> \n";

    $parameters = array();
    if (isset($_GET["orderby"])) $parameters[] = "orderby=" . $_GET["orderby"];
    if (isset($_GET["offset"])) $parameters[] = "offset=" . $_GET["offset"];
    echo "<a href=\"\" title=\"Pesquisar\" onclick=\"value = document.getElementById('valor').value.trim().replace(/ +/g, '+'); result = '" . strtr(implode("&", $parameters), " ", "+") . "'; result = ((value != '') ? document.getElementById('campo').value+'='+value+((result != '') ? '&' : '') : '')+result; this.href ='selectInteraçao.php'+((result != '') ? '?' : '')+result;\">&#x1F50E;</a><br>\n";
    echo "<br>\n";

    echo "<table border=\"1\">\n";
    echo "<tr>\n";
    echo "<td></td>\n";
    echo "<td><b>Código</b> <a href=\"" . url("orderby", "CODIGO+asc") . "\" title=\"Ordenação Ascendente\">&#x25BE;</a> <a href=\"" . url("orderby", "CODIGO+desc") . "\" title=\"Ordenação Descendente\">&#x25B4;</a></td>\n";
    echo "<td><b>Comentários</b> <a href=\"" . url("orderby", "POST+asc") . "\"title=\"Ordenação Ascendente\">&#x25BE;</a> <a href=\"" . url("orderby", "POST+desc") . "\" title=\"Ordenação Descendente\">&#x25B4;</a></td>\n";
    echo "<td><b>Data</b> <a href=\"" . url("orderby", "DATAPOST+asc") . "\"title=\"Ordenação Ascendente\">&#x25BE;</a> <a href=\"" . url("orderby", "DATAPOST+desc") . "\" title=\"Ordenação Descendente\">&#x25B4;</a></td>\n";
    echo "</tr>\n";

    $where = array();
    if (isset($_GET["CODIGO"])) $where[] = "CODIGO = " . $_GET["CODIGO"];
    if (isset($_GET["POST"])) $where[] = "POST like '%" . strtr($_GET["POST"], " ", "%") . "%'";
    $where = (count($where) > 0) ? "where " . implode(" and ", $where) : "";

    $total = $db->query("select count(*) as total from post where CODPOSTREFERENCIA != '' " . $where)->fetchArray()["total"];

    $orderby = (isset($_GET["orderby"])) ? $_GET["orderby"] : "CODIGO asc";

    $offset = (isset($_GET["offset"])) ? max(0, min($_GET["offset"], $total - 1)) : 0;
    $offset = $offset - ($offset % $limit);

    $results = $db->query("select CODIGO,POST,DATAPOST from post where CODPOSTREFERENCIA != '' and ATIVO = 1 ". $where . " order by " . $orderby . " limit " . $limit . " offset " . $offset);
    while ($row = $results->fetchArray()) {
        echo "<tr>\n";
        echo "<td><a href=\"updateInteraçao.php?CODIGO=" . $row["CODIGO"] . "\" title=\"Alterar Comentario\">&#x1F4DD;</a></td>\n";
        echo "<td>" . $row["CODIGO"] . "</td>\n";
        echo "<td>" . $row["POST"] . "</td>\n";
        echo "<td>".date("d/m/Y H:i", strtotime($row["DATAPOST"]))."</td>\n";
        echo "<td><a href=\"insertInteraçao.php?CODIGO=" . $row["CODIGO"] . "\"  title=\"Incluir comentario\">&#x1F4C4;</a></td>\n";
        echo "<td><a href=\"deleteInteraçao.php?CODIGO=" . $row["CODIGO"] . "\"  title=\"Excluir comentario\" onclick=\"return(confirm('Excluir este comentário" . "?'));\">&#x1F5D1;</a></td>\n";
        echo "</tr>\n";
    }

    echo "</table>\n";
    echo "<br>\n";

    for ($page = 0; $page < ceil($total / $limit); $page++) {
        echo (($offset == $page * $limit) ? ($page + 1) : "<a href=\"" . url("offset", $page * $limit) . "\">" . ($page + 1) . "</a>") . " \n";
    }

    $db->close();
    ?>
</body>

</html>