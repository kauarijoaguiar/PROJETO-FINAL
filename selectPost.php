<html>

<body>
    <?php
    function url($campo, $valor)
    {
        $result = array();
        if (isset($_GET["CODIGO"])) $result["CODIGO"] = "CODIGO=" . $_GET["CODIGO"];
        if (isset($_GET["EMAIL_USUARIO"])) $result["EMAIL_USUARIO"] = "EMAIL_USUARIO=" . $_GET["EMAIL_USUARIO"];
        if (isset($_GET["POST"])) $result["POST"] = "POST=" . $_GET["POST"];
        if (isset($_GET["CIDADE"])) $result["CIDADE"] = "CIDADE=" . $_GET["CIDADE"];
        if (isset($_GET["UF"])) $result["UF"] = "UF=" . $_GET["UF"];
        if (isset($_GET["PAIS"])) $result["PAIS"] = "PAIS=" . $_GET["PAIS"];
        if (isset($_GET["DATAPOST"])) $result["DATAPOST"] = "DATAPOST=" . $_GET["DATAPOST"];
        if (isset($_GET["CODIGOGRUPO"])) $result["CODIGOGRUPO"] = "CODIGOGRUPO=" . $_GET["CODIGOGRUPO"];
        if (isset($_GET["ATIVO"])) $result["ATIVO"] = "ATIVO=" . $_GET["ATIVO"];
        if (isset($_GET["orderby"])) $result["orderby"] = "orderby=" . $_GET["orderby"];
        if (isset($_GET["offset"])) $result["offset"] = "offset=" . $_GET["offset"];
        $result[$campo] = $campo . "=" . $valor;
        return ("selectPost.php?" . strtr(implode("&", $result), " ", "+"));
    }

    $db = new SQLite3("face.db");
    $db->exec("PRAGMA foreign_keys = ON");

    $limit = 6;

    echo "<h1>Posts</h1>\n";

    echo "<select id=\"campo\" name=\"campo\">\n";
    echo "<option value=\"CODIGO\"" . ((isset($_GET["CODIGO"])) ? " selected" : "") . ">Código</option>\n";
    echo "<option value=\"POST\"" . ((isset($_GET["POST"])) ? " selected" : "") . ">Post</option>\n";
    echo "<option value=\"EMAIL_USUARIO\"" . ((isset($_GET["EMAIL_USUARIO"])) ? " selected" : "") . ">Usuário</option>\n";
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
    echo "<td><a href=\"insertPost.php\">&#x1F4C4;</a></td>\n";
    echo "<td><b>Código</b> <a href=\"" . url("orderby", "CODIGO+asc") . "\" title=\"Ordenação Ascendente\">&#x25BE;</a> <a href=\"" . url("orderby", "CODIGO+desc") . "\" title=\"Ordenação Descendente\">&#x25B4;</a></td>\n";
    echo "<td><b>Post</b> <a href=\"" . url("orderby", "POST+asc") . "\"title=\"Ordenação Ascendente\">&#x25BE;</a> <a href=\"" . url("orderby", "POST+desc") . "\" title=\"Ordenação Descendente\">&#x25B4;</a></td>\n";
    echo "<td><b>Data</b> <a href=\"" . url("orderby", "DATAPOST+asc") . "\"title=\"Ordenação Ascendente\">&#x25BE;</a> <a href=\"" . url("orderby", "DATAPOST+desc") . "\" title=\"Ordenação Descendente\">&#x25B4;</a></td>\n";
    echo "<td><b>Local</b> <a href=\"" . url("orderby", "CIDADE+asc", "UF+asc", "PAIS+asc") . "\"title=\"Ordenação Ascendente\">&#x25BE;</a> <a href=\"" . url("orderby", "CIDADE+desc", "UF+desc", "PAIS+desc") . "\" title=\"Ordenação Descendente\">&#x25B4;</a></td>\n";
    echo "<td><b>Grupo</b> <a href=\"" . url("orderby", "CODIGOGRUPO+asc") . "\"title=\"Ordenação Ascendente\">&#x25BE;</a> <a href=\"" . url("orderby", "CODIGOGRUPO+desc") . "\" title=\"Ordenação Descendente\">&#x25B4;</a></td>\n";
    echo "<td><b>Assuntos</b> <a href=\"" . url("orderby", "CODIGOGRUPO+asc") . "\"title=\"Ordenação Ascendente\">&#x25BE;</a> <a href=\"" . url("orderby", "CODIGOGRUPO+desc") . "\" title=\"Ordenação Descendente\">&#x25B4;</a></td>\n";
    echo "<td><b>Reações</b></td>\n";
    echo "<td><b>Compartilhamentos</b></td>\n";
    echo "</tr>\n";

    $where = array();
    if (isset($_GET["CODIGO"])) $where[] = "CODIGO = " . $_GET["CODIGO"];
    if (isset($_GET["POST"])) $where[] = "POST like '%" . strtr($_GET["POST"], " ", "%") . "%'";
    $where = (count($where) > 0) ? "where " . implode(" and ", $where) : "";

    $total = $db->query("select count(*) as total from POST JOIN ASSUNTO ON ASSUNTO.CODIGO = ASSUNTOPOST.CODIGOASSUNTO
        JOIN ASSUNTOPOST ON ASSUNTOPOST.CODIGOPOST = POST.CODIGO " . $where)->fetchArray()["total"];

    $orderby = (isset($_GET["orderby"])) ? $_GET["orderby"] : "POST.CODIGO asc";

    $offset = (isset($_GET["offset"])) ? max(0, min($_GET["offset"], $total - 1)) : 0;
    $offset = $offset - ($offset % $limit);

    $results = $db->query("select POST.CODIGO AS COD,POST,DATAPOST,CIDADE,UF,PAIS,CODIGOGRUPO from post 
        where ATIVO = 1 GROUP BY COD ". $where . " order by " . $orderby . " limit " . $limit . " offset " . $offset);
    while ($row = $results->fetchArray()) {
        $results3 = $db->query("select GROUP_CONCAT(ASSUNTO.ASSUNTO) as CONCAT from POST JOIN ASSUNTO ON ASSUNTO.CODIGO = ASSUNTOPOST.CODIGOASSUNTO
        JOIN ASSUNTOPOST ON ASSUNTOPOST.CODIGOPOST = POST.CODIGO where POST.    ATIVO = 1 and CODIGOPOST = "."'".$row["CODIGOGRUPO"]."'");
        $row3 = $results3->fetchArray();
        $results2 = $db->query("select * from GRUPO where ATIVO = 1 and CODIGO = "."'".$row["CODIGOGRUPO"]."'");
        $row2 = $results2->fetchArray();
        echo "<tr>\n";
        echo "<td><a href=\"updatePost.php?CODIGO=" . $row["COD"] . "\" title=\"Alterar Comentario\">&#x1F4DD;</a></td>\n";
        echo "<td>" . $row["COD"] . "</td>\n";
        echo "<td>" . $row["POST"] . "</td>\n";
        echo "<td>".date("d/m/Y H:i", strtotime($row["DATAPOST"]))."</td>\n";
        echo "<td>" . $row["CIDADE"] .", ". $row["UF"] .", ". $row["PAIS"]. "</td>\n";
        echo "<td>" . $row2["NOMEGRUPO"] . "</td>\n";
        echo "<td>" . $row3["CONCAT"] . "</td>\n";
        echo "<td> <a href=\"selectReaçao.php?LINK=" . $row["COD"] . "\" title=\"Ver Reação\">Ver Reações</a> </td>\n";
        echo "<td> <a href=\"selectCompart.php?LINK=" . $row["COD"] . "\" title=\"Ver Compartilhamento\">Ver Compartilhamentos</a> </td>\n";
        echo "<td><a href=\"insertReaçao.php?CODIGO=" . $row["COD"] . "\"  title=\"Reagir\");\">&#128077;</a></td>\n";
        echo "<td><a href=\"insertCompart.php?CODIGO=" . $row["COD"] . "\"  title=\"Comapartilhar\");\">&#9993;</a></td>\n";
        echo "<td><a href=\"insertASPost.php?CODIGO=" . $row["COD"] . "\"  title=\"Incluir assuntos\");\">&#9993;</a></td>\n";
        echo "<td><a href=\"deletePost.php?CODIGO=" . $row["COD"] . "\"  title=\"Excluir\" onclick=\"return(confirm('Excluir este post" . "?'));\">&#x1F5D1;</a></td>\n";
        echo "<td><a href=\"deleteASPost.php?CODIGO=" . $row["COD"] . "\"  title=\"Excluir Assuntos\");\">&#10060;</a></td>\n";
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