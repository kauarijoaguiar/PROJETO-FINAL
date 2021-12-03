<html>
<body>
<?php
function url($campo, $valor) {
	$result = array();
	if (isset($_GET["NOMEUSUARIO1"])) $result["NOMEUSUARIO1"] = "NOMEUSUARIO1=".$_GET["NOMEUSUARIO1"];
	if (isset($_GET["NOMEUSUARIO2"])) $result["NOMEUSUARIO2"] = "NOMEUSUARIO2=".$_GET["NOMEUSUARIO2"];
	if (isset($_GET["DATAAMIZADE"])) $result["DATAAMIZADE"] = "DATAAMIZADE=".$_GET["DATAAMIZADE"];
	if (isset($_GET["orderby"])) $result["orderby"] = "orderby=".$_GET["orderby"];
	if (isset($_GET["offset"])) $result["offset"] = "offset=".$_GET["offset"];
	$result[$campo] = $campo."=".$valor;
	return("selectAmizade.php?".strtr(implode("&", $result), " ", "+"));
}

$db = new SQLite3("face.db");
$db->exec("PRAGMA foreign_keys = ON");

$limit = 10;

echo "<h1>Amizades</h1>\n";

echo "<select id=\"campo\" name=\"campo\">\n";
echo "<option value=\"NOMEUSUARIO1\"".((isset($_GET["NOMEUSUARIO1"])) ? " selected" : "").">Usuário 1</option>\n";
echo "<option value=\"NOMEUSUARIO2\"".((isset($_GET["NOMEUSUARIO2"])) ? " selected" : "").">Usuário 2</option>\n";
echo "<option value=\"DATAAMIZADE\"".((isset($_GET["DATAAMIZADE"])) ? " selected" : "").">Data</option>\n";
echo "</select>\n"; 

$value = "";
if (isset($_GET["NOMEUSUARIO1"])) $value = $_GET["NOMEUSUARIO1"];
if (isset($_GET["NOMEUSUARIO2"])) $value = $_GET["NOMEUSUARIO2"];
if (isset($_GET["DATAAMIZADE"])) $value = $_GET["DATAAMIZADE"];
echo "<input type=\"text\" id=\"valor\" name=\"valor\" value=\"".$value."\" size=\"20\"> \n";

$parameters = array();
if (isset($_GET["orderby"])) $parameters[] = "orderby=".$_GET["orderby"];
if (isset($_GET["offset"])) $parameters[] = "offset=".$_GET["offset"];
echo "<a href=\"\" onclick=\"value = document.getElementById('valor').value.trim().replace(/ +/g, '+'); result = '".strtr(implode("&", $parameters), " ", "+")."'; result = ((value != '') ? document.getElementById('campo').value+'='+value+((result != '') ? '&' : '') : '')+result; this.href ='selectAmizade.php'+((result != '') ? '?' : '')+result;\">&#x1F50E;</a><br>\n";
echo "<br>\n";

echo "<table border=\"1\">\n";
echo "<tr>\n";
echo "<td><b>Usuário 1</b> <a href=\"".url("orderby", "NOMEUSUARIO1+asc")."\">&#x25BE;</a> <a href=\"".url("orderby", "NOMEUSUARIO1+desc")."\">&#x25B4;</a></td>\n";
echo "<td><b>Data</b> <a href=\"".url("orderby", "DATAAMIZADE+asc")."\">&#x25BE;</a> <a href=\"".url("orderby", "DATAAMIZADE+desc")."\">&#x25B4;</a></td>\n";
echo "<td><b>Usuário 2</b> <a href=\"".url("orderby", "EMAIL_USUARIO2+asc")."\">&#x25BE;</a> <a href=\"".url("orderby", "EMAIL_USUARIO2+desc")."\">&#x25B4;</a></td>\n";
echo "<td><a href=\"insertAmizade.php\">&#x1F4C4;</a></td>\n";
echo "</tr>\n";

$where = array();
$where[] = " AMIZADE.ATIVO = 1 ";
if (isset($_GET["NOMEUSUARIO1"])) $where[] = "NOMEUSUARIO1 like '%".strtr($_GET["NOMEUSUARIO1"], " ", "%")."%'";
if (isset($_GET["NOMEUSUARIO2"])) $where[] = "NOMEUSUARIO2 like '%".strtr($_GET["NOMEUSUARIO2"], " ", "%")."%'";
if (isset($_GET["DATAAMIZADE"])) {
	$dataAmizade = explode('/', $_GET["DATAAMIZADE"]);
	$where[] = "DATAAMIZADE BETWEEN DATETIME('". $dataAmizade[2] . "-" . $dataAmizade[1] . "-" . $dataAmizade[0] . " 00:00:00', 'localtime') AND DATETIME('" . $dataAmizade[2] . "-" . $dataAmizade[1] . "-" . $dataAmizade[0] . " 23:59:59', 'localtime')";
}
$where = (count($where) > 0) ? " where ".implode(" and ", $where) : "";

$total = $db->query("select count(*) as total from (SELECT EMAIL_USUARIO1,EMAIL_USUARIO2, USUARIO1.NOME AS NOMEUSUARIO1, USUARIO2.NOME AS NOMEUSUARIO2, 
strftime('%d/%m/%Y', DATAAMIZADE) AS DATAAMIZADE, 
AMIZADE.ATIVO AS ATIVO
FROM AMIZADE
JOIN USUARIO USUARIO1 ON AMIZADE.EMAIL_USUARIO1= USUARIO1.EMAIL
JOIN USUARIO USUARIO2 ON AMIZADE.EMAIL_USUARIO2= USUARIO2.EMAIL " . $where . ") subselect")->fetchArray()["total"];

$orderby = (isset($_GET["orderby"])) ? $_GET["orderby"] : "NOMEUSUARIO1 asc";

$offset = (isset($_GET["offset"])) ? max(0, min($_GET["offset"], $total-1)) : 0;
$offset = $offset-($offset%$limit);

$results = $db->query("SELECT EMAIL_USUARIO1,EMAIL_USUARIO2, USUARIO1.NOME AS NOMEUSUARIO1, USUARIO2.NOME AS NOMEUSUARIO2,
strftime('%d/%m/%Y', DATAAMIZADE) AS DATAAMIZADE, 
AMIZADE.ATIVO 
FROM AMIZADE
JOIN USUARIO USUARIO1 ON AMIZADE.EMAIL_USUARIO1= USUARIO1.EMAIL
JOIN USUARIO USUARIO2 ON AMIZADE.EMAIL_USUARIO2= USUARIO2.EMAIL ".$where." order by ".$orderby." limit ".$limit." offset ".$offset);

while ($row = $results->fetchArray()) {

	echo "<tr>\n";
	echo "<td>".$row["NOMEUSUARIO1"]."</td>\n";
	echo "<td>".$row["DATAAMIZADE"]."</td>\n";
	echo "<td>".$row["NOMEUSUARIO2"]."</td>\n";
    echo "<td><a href=\"deleteAmizade.php?EMAIL_USUARIO1=" . $row["EMAIL_USUARIO1"] . "&EMAIL_USUARIO2=" . $row["EMAIL_USUARIO2"] . "\"  title=\"desfazer\" onclick=\"return(confirm(Desfazer amizade?));\">&#x1F5D1;</a></td>\n";
	echo "</tr>\n";
}

echo "</table>\n";
echo "<br>\n";

for ($page = 0; $page < ceil($total/$limit); $page++) {
	echo (($offset == $page*$limit) ? ($page+1) : "<a href=\"".url("offset", $page*$limit)."\">".($page+1)."</a>")." \n";
}

$db->close();
?>
</body>
</html>

