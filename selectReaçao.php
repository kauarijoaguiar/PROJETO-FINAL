<html>

<body>
    <?php
    function url($campo, $valor)
    {
        $result = array();
        if (isset($_GET["CODIGO"])) $result["CODIGO"] = "CODIGO=" . $_GET["CODIGO"];
        if (isset($_GET["TIPOREACAO"])) $result["TIPOREACAO"] = "POST=" . $_GET["TIPOREACAO"];
        if (isset($_GET["EMAIL_USUARIO"])) $result["EMAIL_USUARIO"] = "EMAIL_USUARIO=" . $_GET["EMAIL_USUARIO"];
        if (isset($_GET["DATAREACAO"])) $result["DATAREACAO"] = "DATAREACAO=" . $_GET["DATAREACAO"];
        if (isset($_GET["orderby"])) $result["orderby"] = "orderby=" . $_GET["orderby"];
        if (isset($_GET["offset"])) $result["offset"] = "offset=" . $_GET["offset"];
        $result[$campo] = $campo . "=" . $valor;
        return ("selectReaçao.php?" . strtr(implode("&", $result), " ", "+"));
    }

    $db = new SQLite3("face.db");
    $db->exec("PRAGMA foreign_keys = ON");

    $limit = 10;

    echo "<h1>Reações</h1>\n";

    echo "<select id=\"campo\" name=\"campo\">\n";
    echo "<option value=\"CODIGO\"" . ((isset($_GET["CODIGO"])) ? " selected" : "") . ">Código</option>\n";
    echo "<option value=\"TIPOREACAO\"" . ((isset($_GET["TIPOREACAO"])) ? " selected" : "") . ">Reação</option>\n";
    echo "<option value=\"EMAIL_USUARIO\"" . ((isset($_GET["EMAIL_USUARIO"])) ? " selected" : "") . ">Usuário</option>\n";
    echo "<option value=\"DATAREACAO\"" . ((isset($_GET["DATAREACAO"])) ? " selected" : "") . ">Data</option>\n";
    echo "</select>\n";

    $value = "";
    if (isset($_GET["CODIGO"])) $value = $_GET["CODIGO"];
    if (isset($_GET["TIPOREACAO"])) $value = $_GET["TIPOREACAO"];
    if (isset($_GET["EMAIL_USUARIO"])) $value = $_GET["EMAIL_USUARIO"];
    if (isset($_GET["DATAREACAO"])) $value = $_GET["DATAREACAO"];
    echo "<input type=\"text\" id=\"valor\" name=\"valor\" value=\"" . $value . "\" size=\"20\"> \n";

    $parameters = array();
    if (isset($_GET["orderby"])) $parameters[] = "orderby=" . $_GET["orderby"];
    if (isset($_GET["offset"])) $parameters[] = "offset=" . $_GET["offset"];
    echo "<a href=\"\" title=\"Pesquisar\" onclick=\"value = document.getElementById('valor').value.trim().replace(/ +/g, '+'); result = '" . strtr(implode("&", $parameters), " ", "+") . "'; result = ((value != '') ? document.getElementById('campo').value+'='+value+((result != '') ? '&' : '') : '')+result; this.href ='selectReaçao.php'+((result != '') ? '?' : '')+result;\">&#x1F50E;</a><br>\n";
    echo "<br>\n";
    
    echo "<table border=\"1\">\n";
    echo "<tr>\n";
    echo "<td></td>\n";
    echo "<td><b>Código</b> <a href=\"" . url("orderby", "CODIGO+asc") . "\" title=\"Ordenação Ascendente\">&#x25BE;</a> <a href=\"" . url("orderby", "CODIGO+desc") . "\" title=\"Ordenação Descendente\">&#x25B4;</a></td>\n";
    echo "<td><b>Reação</b> <a href=\"" . url("orderby", "TIPOREACAO+asc") . "\"title=\"Ordenação Ascendente\">&#x25BE;</a> <a href=\"" . url("orderby", "TIPOREACAO+desc") . "\" title=\"Ordenação Descendente\">&#x25B4;</a></td>\n";
    echo "<td><b>Usuário</b> <a href=\"" . url("orderby", "EMAIL_USUARIO+asc") . "\"title=\"Ordenação Ascendente\">&#x25BE;</a> <a href=\"" . url("orderby", "EMAIL_USUARIO+desc") . "\" title=\"Ordenação Descendente\">&#x25B4;</a></td>\n";
    echo "<td><b>Data</b> <a href=\"" . url("orderby", "DATAREACAO+asc") . "\"title=\"Ordenação Ascendente\">&#x25BE;</a> <a href=\"" . url("orderby", "DATAREACAO+desc") . "\" title=\"Ordenação Descendente\">&#x25B4;</a></td>\n";
    echo "</tr>\n";

    $where = array();
    if (isset($_GET["CODIGO"])) $where[] = "CODIGO = " . $_GET["CODIGO"];
    if (isset($_GET["TIPOREACAO"])) $where[] = "TIPOREACAO like '%" . strtr($_GET["TIPOREACAO"], " ", "%") . "%'";
    if (isset($_GET["EMAIL_USUARIO"])) $where[] = "EMAIL_USUARIO like '%" . strtr($_GET["EMAIL_USUARIO"], " ", "%") . "%'";
    $where = (count($where) > 0) ? "where " . implode(" and ", $where) : "";

    $total = $db->query("select count(*) as total from REACAO" . $where)->fetchArray()["total"];

    $orderby = (isset($_GET["orderby"])) ? $_GET["orderby"] : "CODIGO asc";

    $offset = (isset($_GET["offset"])) ? max(0, min($_GET["offset"], $total - 1)) : 0;
    $offset = $offset - ($offset % $limit);

    $results = $db->query("select CODIGO,TIPOREACAO,EMAIL_USUARIO, DATAREACAO from REACAO where COD_POST = '".$_GET["LINK"] ."'". $where . " order by " . $orderby . " limit " . $limit . " offset " . $offset);
    while ($row = $results->fetchArray()) {
        $j = strval($row["EMAIL_USUARIO"]);
        $results2 = $db->query("select usuario.nome as nome from usuario where usuario.email = '".$j."'");
        $row2 = $results2->fetchArray();
        echo "<tr>\n";
        echo "<td><a href=\"updateReaçao.php?CODIGO=" . $row["CODIGO"] . "\" title=\"Alterar Reaçao\">&#x1F4DD;</a></td>\n";
        echo "<td>" . $row["CODIGO"] . "</td>\n";
        echo "<td>" . $row["TIPOREACAO"] . "</td>\n";
        echo "<td>" . $row2["nome"] . "</td>\n";
        echo "<td>".date("d/m/Y H:i", strtotime($row["DATAREACAO"]))."</td>\n";
        echo "<td><a href=\"insertReaçao.php?CODIGO=" . $row["CODIGO"] . "\"  title=\"Reagir a reação\">&#x1F4C4;</a></td>\n";
        echo "<td><a href=\"deleteReaçao.php?CODIGO=" . $row["CODIGO"] . "\"  title=\"Excluir comentario\" onclick=\"return(confirm('Excluir esta Reação" . "?'));\">&#x1F5D1;</a></td>\n";
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