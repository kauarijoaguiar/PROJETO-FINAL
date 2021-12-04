<html>

<head>
	<title>Localidade</title>
</head>

<body>
	<?php
	function url($campo, $valor)
	{
		$result = array();
		if (isset($_GET["CIDADE"])) $result["CIDADE"] = "CIDADE=" . $_GET["CIDADE"];
		if (isset($_GET["PAIS"])) $result["PAIS"] = "PAIS=" . $_GET["PAIS"];
		if (isset($_GET["UF"])) $result["UF"] = "UF=" . $_GET["UF"];
		if (isset($_GET["orderby"])) $result["orderby"] = "orderby=" . $_GET["orderby"];
		if (isset($_GET["offset"])) $result["offset"] = "offset=" . $_GET["offset"];
		$result[$campo] = $campo . "=" . $valor;
		return ("selectLocalidade.php?" . strtr(implode("&", $result), " ", "+"));
	}

	$db = new SQLite3("face.db");
	$db->exec("PRAGMA foreign_keys = ON");

	$limit = 5;

	echo "<h1>Localidade</h1>\n";


	echo "<select id=\"campo\" name=\"campo\">\n";
	echo "<option value=\"CIDADE\"" . ((isset($_GET["CIDADE"])) ? " selected" : "") . ">CIDADE</option>\n";
	echo "<option value=\"PAIS\"" . ((isset($_GET["PAIS"])) ? " selected" : "") . ">PAIS</option>\n";
	echo "<option value=\"UF\"" . ((isset($_GET["UF"])) ? " selected" : "") . ">UF</option>\n";
	echo "</select>\n";

	$value = "";


	if (isset($_GET["CIDADE"])) $value = $_GET["CIDADE"];
	if (isset($_GET["PAIS"])) $value = $_GET["PAIS"];
	if (isset($_GET["UF"])) $value = $_GET["UF"];
	echo "<input type=\"text\" id=\"valor\" name=\"valor\" value=\"" . $value . "\" size=\"20\" pattern=\"[a-z\s]+$\"> \n";



	$parameters = array();
	if (isset($_GET["orderby"])) $parameters[] = "orderby=" . $_GET["orderby"];
	if (isset($_GET["offset"])) $parameters[] = "offset=" . $_GET["offset"];
	echo "<a href=\"\" onclick=\"value = document.getElementById('valor').value.trim().replace(/ +/g, '+'); result = '" . strtr(implode("&", $parameters), " ", "+") . "'; result = ((value != '') ? document.getElementById('campo').value+'='+value+((result != '') ? '&' : '') : '')+result; this.href ='selectusuario.php'+((result != '') ? '?' : '')+result;\">&#x1F50E;</a><br>\n";
	echo "<br>\n";

	echo "<table class=\"grid\">\n";
	echo "<tr>\n";
	echo "<td><a href=\"insertUsuario.php\">&#x1F4C4;</a></td>\n";
	echo "<td><b>CIDADE</b><a href=\"" . url("orderby", "CIDADE+asc") . "\">&#x25BE;</a> <a href=\"" . url("orderby", "CIDADE+desc") . "\">&#x25B4;</a></td>\n";
	echo "<td><b>PAIS</b><a href=\"" . url("orderby", "PAIS+asc") . "\">&#x25BE;</a> <a href=\"" . url("orderby", "PAIS+desc") . "\">&#x25B4;</a></td>\n";
	echo "<td><b>UF</b><a href=\"" . url("orderby", "UF+asc") . "\">&#x25BE;</a> <a href=\"" . url("orderby", "UF+desc") . "\">&#x25B4;</a></td>\n";
	echo "<td></td>\n";
	echo "</tr>\n";

	$where = array();
	$where[] = " ATIVO = 1 ";
	if (isset($_GET["CIDADE"])) $where[] = "CIDADE like '%" . strtr($_GET["CIDADE"], " ", "%") . "%'";
	if (isset($_GET["PAIS"])) $where[] = "PAIS like '%" . strtr($_GET["PAIS"], " ", "%") . "%'";
	if (isset($_GET["UF"])) $where[] = "UF like '%" . strtr($_GET["UF"], " ", "%") . "%'";
	
	$where = (count($where) > 0) ? "where " . implode(" and ", $where) : "";

	$total = $db->query("select count(*) as total from (select cidade,pais,uf as NASCIMENTO from usuario " . $where . ")")->fetchArray()["total"];

	$orderby = (isset($_GET["orderby"])) ? $_GET["orderby"] : "NOME asc";

	$offset = (isset($_GET["offset"])) ? max(0, min($_GET["offset"], $total - 1)) : 0;
	$offset = $offset - ($offset % $limit);

	$results = $db->query("select cidade,pais,uf as NASCIMENTO from usuario " . $where . " order by " . $orderby . " limit " . $limit . " offset " . $offset);

	while ($row = $results->fetchArray()) {
		echo "<tr>\n";
		echo "<td><a href=\"updateUsuario.php?PAIS=" . $row["PAIS"] . "\">&#x1F4DD;</a></td>\n";
		echo "<td>" . $row["CIDADE"] . "</td>\n";
		echo "<td>\n";
		echo $row["PAIS"];
		echo "</td>\n";
		echo "<td>" . $row["UF"] . "</td>\n";

		echo "<td><a href=\"softdeleteUsuario.php?PAIS=" . $row["EMAIL"] . "\">&#x1F5D1;</a></td>\n";
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