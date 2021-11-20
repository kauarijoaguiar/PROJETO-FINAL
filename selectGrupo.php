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

    $limit = 5;

    echo "<h1>Cadastro de Grupos</h1>\n";

    echo "<select id=\"campo\" name=\"campo\">\n";
    echo "<option value=\"CODIGO\"" . ((isset($_GET["CODIGO"])) ? " selected" : "") . ">Código</option>\n";
    echo "<option value=\"NOMEGRUPO\"" . ((isset($_GET["NOMEGRUPO"])) ? " selected" : "") . ">Nome do Grupo</option>\n";
    echo "</select>\n";

    $value = "";
    if (isset($_GET["CODIGO"])) $value = $_GET["CODIGO"];
    if (isset($_GET["NOMEGRUPO"])) $value = $_GET["NOMEGRUPO"];
    echo "<input type=\"text\" id=\"valor\" name=\"valor\" value=\"" . $value . "\" size=\"20\"> \n";

    $parameters = array();
    if (isset($_GET["orderby"])) $parameters[] = "orderby=" . $_GET["orderby"];
    if (isset($_GET["offset"])) $parameters[] = "offset=" . $_GET["offset"];
    echo "<a href=\"\" title=\"Pesquisar\" onclick=\"value = document.getElementById('valor').value.trim().replace(/ +/g, '+'); result = '" . strtr(implode("&", $parameters), " ", "+") . "'; result = ((value != '') ? document.getElementById('campo').value+'='+value+((result != '') ? '&' : '') : '')+result; this.href ='selectGrupo.php'+((result != '') ? '?' : '')+result;\">&#x1F50E;</a><br>\n";
    echo "<br>\n";

    echo "<table border=\"1\">\n";
    echo "<tr>\n";
    echo "<td><a href=\"insertGrupo.php\" title=\"Incluir Grupo\">&#x1F4C4;</a></td>\n";
    echo "<td><b>Código</b> <a href=\"" . url("orderby", "CODIGO+asc") . "\" title=\"Ordenação Ascendente\">&#x25BE;</a> <a href=\"" . url("orderby", "CODIGO+desc") . "\" title=\"Ordenação Descendente\">&#x25B4;</a></td>\n";
    echo "<td><b>Nome do Grupo</b> <a href=\"" . url("orderby", "NOMEGRUPO+asc") . "\"title=\"Ordenação Ascendente\">&#x25BE;</a> <a href=\"" . url("orderby", "NOMEGRUPO+desc") . "\" title=\"Ordenação Descendente\">&#x25B4;</a></td>\n";
    echo "<td></td>\n";
    echo "<td></td>\n";
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

    $results = $db->query("select CODIGO,NOMEGRUPO from grupo " . $where . " order by " . $orderby . " limit " . $limit . " offset " . $offset);
    while ($row = $results->fetchArray()) {
        echo "<tr>\n";
        echo "<td><a href=\"updateGrupo.php?CODIGO=" . $row["CODIGO"] . "\" title=\"Alterar Grupo\">&#x1F4DD;</a></td>\n";
        echo "<td>" . $row["CODIGO"] . "</td>\n";
        echo "<td>" . $row["NOMEGRUPO"] . "</td>\n";
        echo "<td><a href=\"selectMembrosGrupo.php?codigoGrupo=" . $row["CODIGO"] . "\" title=\"Membros do Grupo\">👥</a></td>\n";
        echo "<td><a href=\"deleteGrupo.php?CODIGO=" . $row["CODIGO"] . "\"  title=\"Eliminar Grupo\" onclick=\"return(confirm('Excluir " . $row["NOMEGRUPO"] . "?'));\">&#x1F5D1;</a></td>\n";
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