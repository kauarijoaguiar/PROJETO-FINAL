<html>

<body>
    <?php
    function url($campo, $valor)
    {
        $result = array();
        if (isset($_GET["CODIGO"])) $result["CODIGO"] = "CODIGO=" . $_GET["CODIGO"];
        if (isset($_GET["EMAIL_USUARIO"])) $result["EMAIL_USUARIO"] = "POST=" . $_GET["EMAIL_USUARIO"];
        if (isset($_GET["COD_POST"])) $result["COD_POST"] = "COD_POST=" . $_GET["COD_POST"];
        if (isset($_GET["DATACOMPARTILHAMENTO"])) $result["DATACOMPARTILHAMENTO"] = "DATACOMPARTILHAMENTO=" . $_GET["DATACOMPARTILHAMENTO"];
        if (isset($_GET["ATIVO"])) $result["ATIVO"] = "ATIVO=" . $_GET["ATIVO"];
        if (isset($_GET["orderby"])) $result["orderby"] = "orderby=" . $_GET["orderby"];
        if (isset($_GET["offset"])) $result["offset"] = "offset=" . $_GET["offset"];
        $result[$campo] = $campo . "=" . $valor;
        return ("selectCompart.php?" . strtr(implode("&", $result), " ", "+"));
    }

    $db = new SQLite3("face.db");
    $db->exec("PRAGMA foreign_keys = ON");

    $limit = 5;

    echo "<h1>Compartilhamentos</h1>\n";

    echo "<select id=\"campo\" name=\"campo\">\n";
    echo "<option value=\"CODIGO\"" . ((isset($_GET["CODIGO"])) ? " selected" : "") . ">Código</option>\n";
    echo "<option value=\"EMAIL_USUARIO\"" . ((isset($_GET["EMAIL_USUARIO"])) ? " selected" : "") . ">Usuário</option>\n";
    echo "<option value=\"COD_POST\"" . ((isset($_GET["COD_POST"])) ? " selected" : "") . ">Post</option>\n";
    echo "<option value=\"DATACOMPARTILHAMENTO\"" . ((isset($_GET["DATACOMPARTILHAMENTO"])) ? " selected" : "") . ">Data</option>\n";
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
    echo "<td><b>Usuário</b> <a href=\"" . url("orderby", "EMAIL_USUARIO+asc") . "\"title=\"Ordenação Ascendente\">&#x25BE;</a> <a href=\"" . url("orderby", "EMAIL_USUARIO+desc") . "\" title=\"Ordenação Descendente\">&#x25B4;</a></td>\n";
    echo "<td><b>Post</b> <a href=\"" . url("orderby", "COD_POST+asc") . "\"title=\"Ordenação Ascendente\">&#x25BE;</a> <a href=\"" . url("orderby", "COD_POST+desc") . "\" title=\"Ordenação Descendente\">&#x25B4;</a></td>\n";
    echo "<td><b>Data</b> <a href=\"" . url("orderby", "DATACOMPARTILHAMENTO+asc") . "\"title=\"Ordenação Ascendente\">&#x25BE;</a> <a href=\"" . url("orderby", "DATACOMPARTILHAMENTO+desc") . "\" title=\"Ordenação Descendente\">&#x25B4;</a></td>\n";
    echo "</tr>\n";

    $where = array();
    if (isset($_GET["CODIGO"])) $where[] = "CODIGO = " . $_GET["CODIGO"];
    if (isset($_GET["POST"])) $where[] = "POST like '%" . strtr($_GET["POST"], " ", "%") . "%'";
    $where = (count($where) > 0) ? "where " . implode(" and ", $where) : "";

    $total = $db->query("select count(*) as total from COMPARTILHAMENTO " . $where)->fetchArray()["total"];

    $orderby = (isset($_GET["orderby"])) ? $_GET["orderby"] : "CODIGO asc";

    $offset = (isset($_GET["offset"])) ? max(0, min($_GET["offset"], $total - 1)) : 0;
    $offset = $offset - ($offset % $limit);

    $results = $db->query("select * from COMPARTILHAMENTO where COD_POST = '".$_GET["LINK"] ."'"."order by ".$orderby." limit ".$limit." offset ".$offset);
    while ($row = $results->fetchArray()) {
        $j = strval($row["EMAIL_USUARIO"]);
        $results2 = $db->query("select usuario.nome as nome from usuario where usuario.email = '".$j."'");
        $row2 = $results2->fetchArray();
        echo "<tr>\n";
        echo "<td><a href=\"updateCompart.php?CODIGO=" . $row["CODIGO"] . "\" title=\"Alterar Comaprtilhamento\">&#x1F4DD;</a></td>\n";
        echo "<td>".$row["CODIGO"]."</td>\n";
        echo "<td>".$row2["nome"]."</td>\n";
        echo "<td>".$row["COD_POST"]."</td>\n";
        echo "<td>".date("d/m/Y H:i", strtotime($row["DATACOMPARTILHAMENTO"]))."</td>\n";
        echo "<td><a href=\"insertCitacao.php?CODIGO=" . $row["CODIGO"] . "&ORIGEM=COMPARTILHAMENTO\"  title=\"Incluir citação\">@</a></td>\n";
        
        echo "<td><a href=\"deleteComapart.php?CODIGO=" . $row["CODIGO"] . "\"  title=\"desfazer\" onclick=\"return(confirm(Desfazer compartilhamento?));\">&#x1F5D1;</a></td>\n";
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