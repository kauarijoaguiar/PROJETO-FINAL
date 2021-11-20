<html>
<body>
<?php
function url($campo, $valor) {
	$result = array();
	if (isset($_GET["EMAIL_USUARIO1"])) $result["EMAIL_USUARIO1"] = "EMAIL_USUARIO1=".$_GET["EMAIL_USUARIO1"];
	if (isset($_GET["EMAIL_USUARIO2"])) $result["EMAIL_USUARIO2"] = "EMAIL_USUARIO2=".$_GET["EMAIL_USUARIO2"];
	if (isset($_GET["DATAAMIZADE"])) $result["DATAAMIZADE"] = "DATAAMIZADE=".$_GET["DATAAMIZADE"];
	if (isset($_GET["orderby"])) $result["orderby"] = "orderby=".$_GET["orderby"];
	if (isset($_GET["offset"])) $result["offset"] = "offset=".$_GET["offset"];
	$result[$campo] = $campo."=".$valor;
	return("amizades.php?".strtr(implode("&", $result), " ", "+"));
}

$db = new SQLite3("face.db");
$db->exec("PRAGMA foreign_keys = ON");

$limit = 5;

echo "<h1>Amizades</h1>\n";

echo "<select id=\"campo\" name=\"campo\">\n";
echo "<option value=\"usuario1\"".((isset($_GET["EMAIL_USUARIO1"])) ? " selected" : "").">Usuário 1</option>\n";
echo "<option value=\"usuario2\"".((isset($_GET["EMAIL_USUARIO2"])) ? " selected" : "").">Usuário 2</option>\n";
echo "<option value=\"data\"".((isset($_GET["DATAAMIZADE"])) ? " selected" : "").">Data</option>\n";
echo "</select>\n"; 

$value = "";
if (isset($_GET["EMAIL_USUARIO1"])) $value = $_GET["EMAIL_USUARIO1"];
if (isset($_GET["EMAIL_USUARIO2"])) $value = $_GET["EMAIL_USUARIO2"];
if (isset($_GET["DATAAMIZADE"])) $value = $_GET["DATAAMIZADE"];
echo "<input type=\"text\" id=\"valor\" name=\"valor\" value=\"".$value."\" size=\"20\"> \n";

$parameters = array();
if (isset($_GET["orderby"])) $parameters[] = "orderby=".$_GET["orderby"];
if (isset($_GET["offset"])) $parameters[] = "offset=".$_GET["offset"];
echo "<a href=\"\" onclick=\"value = document.getElementById('valor').value.trim().replace(/ +/g, '+'); result = '".strtr(implode("&", $parameters), " ", "+")."'; result = ((value != '') ? document.getElementById('campo').value+'='+value+((result != '') ? '&' : '') : '')+result; this.href ='amizades.php'+((result != '') ? '?' : '')+result;\">&#x1F50E;</a><br>\n";
echo "<br>\n";

echo "<table border=\"1\">\n";
echo "<tr>\n";
echo "<td><b>Usuário 1</b> <a href=\"".url("orderby", "EMAIL_USUARIO1+asc")."\">&#x25BE;</a> <a href=\"".url("orderby", "EMAIL_USUARIO1+desc")."\">&#x25B4;</a></td>\n";
echo "<td><b>Data</b> <a href=\"".url("orderby", "DATAAMIZADE+asc")."\">&#x25BE;</a> <a href=\"".url("orderby", "DATAAMIZADE+desc")."\">&#x25B4;</a></td>\n";
echo "<td><b>Usuário 2</b> <a href=\"".url("orderby", "EMAIL_USUARIO2+asc")."\">&#x25BE;</a> <a href=\"".url("orderby", "EMAIL_USUARIO2+desc")."\">&#x25B4;</a></td>\n";
echo "<td><b>Ativo</b></td>\n";
echo "<td><a href=\"AmizInsert.php\">&#x1F4C4;</a></td>\n";
echo "</tr>\n";

$where = array();
if (isset($_GET["nome"])) $where[] = "nome like '%".strtr($_GET["nome"], " ", "%")."%'";
if (isset($_GET["tipo"])) $where[] = "tipo = '".$_GET["tipo"]."'";
$where = (count($where) > 0) ? "where ".implode(" and ", $where) : "";

$total = $db->query("select count(*) as total from amizade ".$where)->fetchArray()["total"];

$orderby = (isset($_GET["orderby"])) ? $_GET["orderby"] : "EMAIL_USUARIO1 asc";

$offset = (isset($_GET["offset"])) ? max(0, min($_GET["offset"], $total-1)) : 0;
$offset = $offset-($offset%$limit);

$results = $db->query("select * from amizade ".$where."order by ".$orderby." limit ".$limit." offset ".$offset);
while ($row = $results->fetchArray()) {
    $j = strval($row["EMAIL_USUARIO1"]);
    $k = strval($row["EMAIL_USUARIO2"]);
    $results2 = $db->query("select usuario.nome as nome from usuario where usuario.email = '".$j."'");
    $row2 = $results2->fetchArray();
    $results3 = $db->query("select usuario.nome as nome2 from usuario where usuario.email = '".$k."'");
    $row3 = $results3->fetchArray();
	echo "<tr>\n";
	echo "<td>".$row2["nome"]."</td>\n";
	echo "<td>".date("d/m/Y H:i", strtotime($row["DATAAMIZADE"]))."</td>\n";
	echo "<td>".$row3["nome2"]."</td>\n";
	echo "<td>".$row["ATIVO"]."</td>\n";
	echo "<td><a href=\"AmizDelete.php?email="."'".$j."'"." & "."email2="."'".$k."'"."\" onclick=\"return(confirm('Excluir esta amizade?'));\">&#x1F5D1;</a></td>\n";
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

