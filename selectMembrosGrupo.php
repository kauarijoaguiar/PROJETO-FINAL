<html>

<body>
    <?php
    function url($campo, $valor)
    {
        $result = array();
        if (isset($_GET["CODIGOGRUPO"])) $result["CODIGOGRUPO"] = "CODIGOGRUPO=" . $_GET["CODIGOGRUPO"];
        if (isset($_GET["NOMEUSUARIO"])) $result["NOMEUSUARIO"] = "NOMEUSUARIO=" . $_GET["NOMEUSUARIO"];
        if (isset($_GET["orderby"])) $result["orderby"] = "orderby=" . $_GET["orderby"];
        if (isset($_GET["offset"])) $result["offset"] = "offset=" . $_GET["offset"];
        $result[$campo] = $campo . "=" . $valor;
        return ("selectMembrosGrupo.php?" . strtr(implode("&", $result), " ", "+"));
    }

    $db = new SQLite3("face.db");
    $db->exec("PRAGMA foreign_keys = ON");

    $limit = 5;

    $nomeGrupo = $db->query("select grupo.NOMEGRUPO from grupo where grupo.codigo = " . $_GET["CODIGOGRUPO"])->fetchArray()["NOMEGRUPO"];

    echo "<h1>Usuários do grupo ".$nomeGrupo."</h1>\n";

    echo "<select id=\"campo\" name=\"campo\">\n";
    echo "<option value=\"NOMEUSUARIO\"" . ((isset($_GET["NOMEUSUARIO"])) ? " selected" : "") . ">Nome do Usuário</option>\n";
    echo "</select>\n";

    $value = "";
    if (isset($_GET["NOMEUSUARIO"])) $value = $_GET["NOMEUSUARIO"];
    echo "<input type=\"text\" id=\"valor\" name=\"valor\" value=\"" . $value . "\" size=\"20\"> \n";

    $parameters = array();
    $parameters[] = "CODIGOGRUPO=" . $_GET["CODIGOGRUPO"];
    if (isset($_GET["orderby"])) $parameters[] = "orderby=" . $_GET["orderby"];
    if (isset($_GET["offset"])) $parameters[] = "offset=" . $_GET["offset"];
    echo "<a href=\"\" title=\"Pesquisar\" onclick=\"value = document.getElementById('valor').value.trim().replace(/ +/g, '+'); result = '" . strtr(implode("&", $parameters), " ", "+") . "'; result = ((value != '') ? document.getElementById('campo').value+'='+value+((result != '') ? '&' : '') : '')+result; this.href ='selectMembrosGrupo.php'+((result != '') ? '?' : '')+result;\">&#x1F50E;</a><br>\n";
    echo "<br>\n";

    echo "<table border=\"1\">\n";
    echo "<tr>\n";
    echo "<td><a href=\"insertMembrosGrupo.php?CODIGOGRUPO=" . $_GET["CODIGOGRUPO"] ."\" title=\"Incluir Membro no Grupo\">&#x1F4C4;</a></td>\n";
    echo "<td><b>Nome do Usuário</b> <a href=\"" . url("orderby", "NOMEUSUARIO+asc") . "\"title=\"Ordenação Ascendente\">&#x25BE;</a> <a href=\"" . url("orderby", "NOMEUSUARIO+desc") . "\" title=\"Ordenação Descendente\">&#x25B4;</a></td>\n";
    echo "<td></td>\n";
    echo "</tr>\n";

    $where = array();
    $where[] = "grupousuario.ATIVO = 1 AND usuario.ativo = 1 AND grupoUsuario.CODIGOGRUPO = ".$_GET["CODIGOGRUPO"];
    if (isset($_GET["NOMEUSUARIO"])) $where[] = "NOMEUSUARIO like '%" . strtr($_GET["NOMEUSUARIO"], " ", "%") . "%'";
    $where = (count($where) > 0) ? "where " . implode(" and ", $where) : "";

    $total = $db->query("select count(grupousuario.email_usuario) as total, USUARIO.NOME as NOMEUSUARIO  from grupousuario left join usuario on usuario.email = grupousuario.email_usuario  " . $where)->fetchArray()["total"];

    $orderby = (isset($_GET["orderby"])) ? $_GET["orderby"] : " NOMEUSUARIO asc ";

    $offset = (isset($_GET["offset"])) ? max(0, min($_GET["offset"], $total - 1)) : 0;
    $offset = $offset - ($offset % $limit);

    $results = $db->query("select grupousuario.CODIGOGRUPO, grupousuario.EMAIL_USUARIO, USUARIO.NOME as NOMEUSUARIO from grupousuario left join usuario on usuario.email = grupousuario.email_usuario " . $where . " order by " . $orderby . " limit " . $limit . " offset " . $offset);
    while ($row = $results->fetchArray()) {
        echo "<tr>\n";
        echo "<td></td>\n";
        echo "<td>" . $row["NOMEUSUARIO"] . "</td>\n";
        echo "<td><a href=\"deleteMembrosGrupo.php?CODIGOGRUPO=" . $row["CODIGOGRUPO"] . "&EMAIL_USUARIO=" . $row["EMAIL_USUARIO"] . "\"  title=\"Eliminar Membro do Grupo\" onclick=\"return(confirm('Excluir " . $row["NOMEUSUARIO"] . " do grupo " . $nomeGrupo." ?'));\">&#x1F5D1;</a></td>\n";
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