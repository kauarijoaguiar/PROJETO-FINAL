<html>

<head>
	<title>Localidade</title>
</head>

<body>
	<?php
	function url($campo, $valor)
	{
		$result = array();
		if (isset($_GET["CODIGO"])) $result["CODIGO"] = "CODIGO=" . $_GET["CODIGO"];
		if (isset($_GET["CIDADES"])) $result["CIDADES"] = "CIDADES=" . $_GET["CIDADES"];
		if (isset($_GET["PAIS"])) $result["PAISES"] = "PAISES=" . $_GET["PAISES"];
		if (isset($_GET["ESTADOS"])) $result["ESTADOS"] = "ESTADOS=" . $_GET["ESTADOS"];
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
	echo "<option value=\"CODIGO\"" . ((isset($_GET["CODIGO"])) ? " selected" : "") . ">Código</option>\n";
	echo "<option value=\"PAISES\"" . ((isset($_GET["PAISES"])) ? " selected" : "") . ">País</option>\n";
	echo "<option value=\"ESTADOS\"" . ((isset($_GET["ESTADOS"])) ? " selected" : "") . ">Estado</option>\n";
	echo "<option value=\"CIDADES\"" . ((isset($_GET["CIDADES"])) ? " selected" : "") . ">Cidade</option>\n";
	echo "</select>\n";

	$value = "";

	if (isset($_GET["CODIGO"])) $value = $_GET["CODIGO"];
	if (isset($_GET["CIDADES"])) $value = $_GET["CIDADES"];
	if (isset($_GET["PAISES"])) $value = $_GET["PAISES"];
	if (isset($_GET["ESTADOS"])) $value = $_GET["ESTADOS"];
	echo "<input type=\"text\" id=\"valor\" name=\"valor\" value=\"" . $value . "\" size=\"20\" pattern=\"[a-z\s]+$\"> \n";



	$parameters = array();
	if (isset($_GET["orderby"])) $parameters[] = "orderby=" . $_GET["orderby"];
	if (isset($_GET["offset"])) $parameters[] = "offset=" . $_GET["offset"];
	echo "<a href=\"\" title=\"Pesquisar\" onclick=\"value = document.getElementById('valor').value.trim().replace(/ +/g, '+'); result = '" . strtr(implode("&", $parameters), " ", "+") . "'; result = ((value != '') ? document.getElementById('campo').value+'='+value+((result != '') ? '&' : '') : '')+result; this.href ='selectLocalidade.php'+((result != '') ? '?' : '')+result;\">&#x1F50E;</a><br>\n";
	echo "<br>\n";

	echo "<table border=\"1\">\n";
	echo "<tr>\n";
	echo "<td></td>\n";
	echo "<td><b>Código</b> <a href=\"" . url("orderby", "CODIGO+asc") . "\" title=\"Ordenação Ascendente\">&#x25BE;</a> <a href=\"" . url("orderby", "CODIGO+desc") . "\" title=\"Ordenação Descendente\">&#x25B4;</a></td>\n";
	echo "<td><b>Países</b> <a href=\"" . url("orderby", "PAISES+asc") . "\"title=\"Ordenação Ascendente\">&#x25BE;</a> <a href=\"" . url("orderby", "PAISES+desc") . "\" title=\"Ordenação Descendente\">&#x25B4;</a></td>\n";
	echo "<td><b>Estados</b> <a href=\"" . url("orderby", "ESTADOS+asc") . "\"title=\"Ordenação Ascendente\">&#x25BE;</a> <a href=\"" . url("orderby", "ESTADOS+desc") . "\" title=\"Ordenação Descendente\">&#x25B4;</a></td>\n";
	echo "<td><b>Cidades</b> <a href=\"" . url("orderby", "CIDADES+asc") . "\"title=\"Ordenação Ascendente\">&#x25BE;</a> <a href=\"" . url("orderby", "CIDADES+desc") . "\" title=\"Ordenação Descendente\">&#x25B4;</a></td>\n";
	echo "</tr>\n";


	$where = array();
	$where[] = " ATIVO = 1 ";
	if (isset($_GET["CODIGO"])) $where[] = "CODIGO like '%" . strtr($_GET["CODIGO"], " ", "%") . "%'";
	if (isset($_GET["CIDADES"])) $where[] = "CIDADES like '%" . strtr($_GET["CIDADES"], " ", "%") . "%'";
	if (isset($_GET["PAISES"])) $where[] = "PAISES like '%" . strtr($_GET["PAISES"], " ", "%") . "%'";
	if (isset($_GET["ESTADOS"])) $where[] = "ESTADOS like '%" . strtr($_GET["ESTADOS"], " ", "%") . "%'";
	
	$where = (count($where) > 0) ? "where " . implode(" and ", $where) : "";

	$orderby = (isset($_GET["orderby"])) ? $_GET["orderby"] : "PAISES asc";

	$offset = (isset($_GET["offset"])) ? max(0, min($_GET["offset"], $total - 1)) : 0;
	$offset = $offset - ($offset % $limit);

	$results = $db->query("select CODIGO,CIDADES,PAISES,ESTADOS as PAISES from CODIGO " . $where . " order by " . $orderby . " limit " . $limit . " offset " . $offset);

	while ($row = $results->fetchArray()) {
		echo "<tr>\n";
		echo "<td><a href=\"updateLocalidade.php?PAIS=" . $row["PAISES"] . "\">&#x1F4DD;</a></td>\n";
		echo "<td>" . $row["CIDADES"] . "</td>\n";
		echo "<td>\n";
		echo $row["PAISES"];
		echo "</td>\n";
		echo "<td>" . $row["ESTADOS"] . "</td>\n";

		echo "<td><a href=\"softdeleteLocalidade.php?PAIS=" . $row["PAISES"] . "\">&#x1F5D1;</a></td>\n";
		echo "</tr>\n";
	}

	while ($row = $results->fetchArray()) {
		echo "<tr>\n";
		echo "<td><a href=\"updateLocalidade.php?CODIGO=" . $row["CODIGO"] . "\" title=\"Alterar Localidade\">&#x1F4DD;</a></td>\n";
		echo "<td>" . $row["PAISES"] . "</td>\n";
		echo "<td>" . $row["ESTADOS"] . "</td>\n";
		echo "<td>" . $row2["CIDADES"] . "</td>\n";
		echo "<td><a href=\"insertLocalidade.php?CODIGO=" . $row["CODIGO"] . "\"  title=\"Reagir a localidade\">&#x1F4C4;</a></td>\n";
		echo "<td><a href=\"insertLocalidade.php?CODIGO=" . $row["CODIGO"] . "&ORIGEM=LOCALIDADE\"  title=\"Incluir Localidade\">@</a></td>\n";
		echo "<td><a href=\"deletelocalidade.php?CODIGO=" . $row["CODIGO"] . "\"  title=\"Excluir comentario\" onclick=\"return(confirm('Excluir esta Localidade" . "?'));\">&#x1F5D1;</a></td>\n";
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