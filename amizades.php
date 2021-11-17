<html>
<body>
<?php
function url($campo, $valor) {
	$result = array();
	if (isset($_GET["codigo"])) $result["codigo"] = "codigo=".$_GET["codigo"];
	if (isset($_GET["nome"])) $result["nome"] = "nome=".$_GET["nome"];
	if (isset($_GET["tipo"])) $result["tipo"] = "tipo=".$_GET["tipo"];
	if (isset($_GET["ingredientes"])) $result["ingredientes"] = "ingredientes=".$_GET["ingredientes"];
	if (isset($_GET["orderby"])) $result["orderby"] = "orderby=".$_GET["orderby"];
	if (isset($_GET["offset"])) $result["offset"] = "offset=".$_GET["offset"];
	$result[$campo] = $campo."=".$valor;
	return("select.php?".strtr(implode("&", $result), " ", "+"));
}

$db = new SQLite3("face.db");
$db->exec("PRAGMA foreign_keys = ON");

$limit = 5;

echo "<h1>Amizades</h1>\n";

// echo "<select id=\"campo\" name=\"campo\">\n";
// echo "<option value=\"nome\"".((isset($_GET["nome"])) ? " selected" : "").">Nome</option>\n";
// echo "<option value=\"tipo\"".((isset($_GET["tipo"])) ? " selected" : "").">Tipo</option>\n";
// echo "<option value=\"ingrediente\"".((isset($_GET["ingredientes"])) ? " selected" : "").">Ingredientes</option>\n";
// echo "</select>\n"; 

// $value = "";
// if (isset($_GET["nome"])) $value = $_GET["nome"];
// if (isset($_GET["tipo"])) $value = $_GET["tipo"];
// if (isset($_GET["ingredientes"])) $value = $_GET["ingredientes"];
// echo "<input type=\"text\" id=\"valor\" name=\"valor\" value=\"".$value."\" size=\"20\"> \n";

// $parameters = array();
// if (isset($_GET["orderby"])) $parameters[] = "orderby=".$_GET["orderby"];
// if (isset($_GET["offset"])) $parameters[] = "offset=".$_GET["offset"];
// echo "<a href=\"\" onclick=\"value = document.getElementById('valor').value.trim().replace(/ +/g, '+'); result = '".strtr(implode("&", $parameters), " ", "+")."'; result = ((value != '') ? document.getElementById('campo').value+'='+value+((result != '') ? '&' : '') : '')+result; this.href ='select.php'+((result != '') ? '?' : '')+result;\">&#x1F50E;</a><br>\n";
// echo "<br>\n";

echo "<table border=\"1\">\n";
echo "<tr>\n";
// echo "<td><a href=\"insert.php\">&#x1F4C4;</a></td>\n";
echo "<td><b>Usuário 1</b> <a href=\"".url("orderby", "nome+asc")."\">&#x25BE;</a> <a href=\"".url("orderby", "nome+desc")."\">&#x25B4;</a></td>\n";
echo "<td><b>Data</b> <a href=\"".url("orderby", "tipo+asc")."\">&#x25BE;</a> <a href=\"".url("orderby", "tipo+desc")."\">&#x25B4;</a></td>\n";
echo "<td><b>Usuário 2</b> <a href=\"".url("orderby", "nome+asc")."\">&#x25BE;</a> <a href=\"".url("orderby", "nome+desc")."\">&#x25B4;</a></td>\n";
echo "<td><a href=\"insert.php\">&#x1F4C4;</a></td>\n";
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
	echo "<td><a href=\"delete.php?codigo=".$row["EMAIL_USUARIO1"]."\" onclick=\"return(confirm('Excluir ".$row["EMAIL_USUARIO1"]."?'));\">&#x1F5D1;</a></td>\n";
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

