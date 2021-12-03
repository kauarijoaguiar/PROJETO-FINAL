<html>

<head>
	<title>Usuarios</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<?php
	function url($campo, $valor)
	{
		$result = array();
		if (isset($_GET["CODIGO"])) $result["CODIGO"] = "CODIGO=" . $_GET["CODIGO"];
		if (isset($_GET["COD_POST"])) $result["COD_POST"] = "COD_POST=" . $_GET["COD_POST"];
		if (isset($_GET["COD_COMPARTILHAMENTO"])) $result["COD_COMPARTILHAMENTO"] = "COD_COMPARTILHAMENTO=" . $_GET["COD_COMPARTILHAMENTO"];
		if (isset($_GET["COD_RECAO"])) $result["COD_RECAO"] = "COD_RECAO=" . $_GET["COD_RECAO"];
		if (isset($_GET["EMAIL_USUARIO"])) $result["EMAIL_USUARIO"] = "EMAIL_USUARIO=" . $_GET["EMAIL_USUARIO"];
		if (isset($_GET["ATIVO"])) $result["ATIVO"] = "ATIVO=" . $_GET["ATIVO"];
        if (isset($_GET["orderby"])) $result["orderby"] = "orderby=" . $_GET["orderby"];
		if (isset($_GET["offset"])) $result["offset"] = "offset=" . $_GET["offset"];
		$result[$campo] = $campo . "=" . $valor;
		return ("selectcitacao.php?" . strtr(implode("&", $result), " ", "+"));
	}

	$db = new SQLite3("face.db");
	$db->exec("PRAGMA foreign_keys = ON");

	$limit = 5;

	echo "<h1>Usuarios</h1>\n";


	echo "<select id=\"campo\" name=\"campo\">\n";
	echo "<option value=\"CODIGO\"" . ((isset($_GET["CODIGO"])) ? " selected" : "") . ">CODIGO</option>\n";
	echo "<option value=\"COD_POST\"" . ((isset($_GET["COD_POST"])) ? " selected" : "") . ">COD_POST</option>\n";
	echo "<option value=\"COD_COMPARTILHAMENTO\"" . ((isset($_GET["COD_COMPARTILHAMENTO"])) ? " selected" : "") . ">COD_COMPARTILHAMENTO</option>\n";
    echo "<option value=\"COD_RECAO\"" . ((isset($_GET["COD_RECAO"])) ? " selected" : "") . ">COD_RECAO</option>\n";
	echo "<option value=\"EMAIL_USUARIO\"" . ((isset($_GET["EMAIL_USUARIO"])) ? " selected" : "") . ">EMAIL_USUARIO</option>\n";
    echo "<option value=\"ATIVO\"" . ((isset($_GET["ATIVO"])) ? " selected" : "") . ">ATIVO</option>\n";
	echo "</select>\n";

	$value = "";

	if (isset($_GET["CODIGO"])) $value = $_GET["CODIGO"];
	if (isset($_GET["COD_POST"])) $value = $_GET["COD_POST"];
	if (isset($_GET["COD_COMPARTILHAMENTO"])) $value = $_GET["COD_COMPARTILHAMENTO"];
    if (isset($_GET["COD_RECAO"])) $value = $_GET["COD_RECAO"];
	if (isset($_GET["EMAIL_USUARIO"])) $value = $_GET["EMAIL_USUARIO"];
	if (isset($_GET["ATIVO"])) $value = $_GET["ATIVO"];
	echo "<input type=\"text\" id=\"valor\" name=\"valor\" value=\"" . $value . "\" size=\"20\" pattern=\"[a-z\s]+$\"> \n";

	echo '<script>';
	echo 'var valor = document.querySelector("#valor");';
	echo 'valor.addEventListener("input", function () {';
	echo 'valor.value = valor.value.toUpperCase();';
	echo '});';
	echo '</script>';

	$parameters = array();
	if (isset($_GET["orderby"])) $parameters[] = "orderby=" . $_GET["orderby"];
	if (isset($_GET["offset"])) $parameters[] = "offset=" . $_GET["offset"];
	echo "<a href=\"\" onclick=\"value = document.getElementById('valor').value.trim().replace(/ +/g, '+'); result = '" . strtr(implode("&", $parameters), " ", "+") . "'; result = ((value != '') ? document.getElementById('campo').value+'='+value+((result != '') ? '&' : '') : '')+result; this.href ='selectcitacao.php'+((result != '') ? '?' : '')+result;\">&#x1F50E;</a><br>\n";
	echo "<br>\n";

	echo "<table class=\"grid\">\n";
	echo "<tr>\n";
	echo "<td><a href=\"insertcitacao.php\">&#x1F4C4;</a></td>\n";
	echo "<td><b>CODIGO</b> <a href=\"" . url("orderby", "codigo+asc") . "\">&#x25BE;</a> <a href=\"" . url("orderby", "codigo+desc") . "\">&#x25B4;</a></td>\n";
	echo "<td><b>COD_POST</b> <a href=\"" . url("orderby", "COD_POST+asc") . "\">&#x25BE;</a> <a href=\"" . url("orderby", "COD_POST+desc") . "\">&#x25B4;</a></td>\n";
    echo "<td><b>COD_COMPARTILHAMENTO</b> <a href=\"" . url("orderby", "COD_COMPARTILHAMENTO+asc") . "\">&#x25BE;</a> <a href=\"" . url("orderby", "COD_COMPARTILHAMENTO+desc") . "\">&#x25B4;</a></td>\n";
    echo "<td><b>COD_RECAO</b> <a href=\"" . url("orderby", "COD_RECAO+asc") . "\">&#x25BE;</a> <a href=\"" . url("orderby", "COD_RECAO+desc") . "\">&#x25B4;</a></td>\n";
    echo "<td><b>EMAIL_USUARIO</b> <a href=\"" . url("orderby", "EMAIL_USUARIO+asc") . "\">&#x25BE;</a> <a href=\"" . url("orderby", "EMAIL_USUARIO+desc") . "\">&#x25B4;</a></td>\n";
	echo "<td></td>\n";
	echo "</tr>\n";

	$where = array();

	$where[] = 'ATIVO = 1';
	if (isset($_GET["CODIGO"])) $where[] = "CODIGO like '%" . strtr($_GET["CODIGO"], " ", "%") . "%'";
	if (isset($_GET["COD_POST"])) $where[] = "COD_POST like '%" . strtr($_GET["COD_POST"], " ", "%") . "%'"; 
	if (isset($_GET["COD_COMPARTILHAMENTO"])) $where[] = "COD_COMPARTILHAMENTO like '%" . strtr($_GET["COD_COMPARTILHAMENTO"], " ", "%") . "%'";
    if (isset($_GET["COD_RECAO"])) $where[] = "COD_RECAO like '%" . strtr($_GET["COD_RECAO"], " ", "%") . "%'";
	if (isset($_GET["EMAIL_USUARIO"])) $where[] = "EMAIL_USUARIO like '%" . strtr($_GET["EMAIL_USUARIO"], " ", "%") . "%'"; 
	if (isset($_GET["ATIVO"])) $where[] = "ATIVO like '%" . strtr($_GET["ATIVO"], " ", "%") . "%'"; 
    $where = (count($where) > 0) ? " where " . implode(" and ", $where) : "";

	$total = $db->query("select count(*) as total from citacao " . $where . ";")->fetchArray()["total"];

	$orderby = (isset($_GET["orderby"])) ? $_GET["orderby"] : "codigo asc";

	$offset = (isset($_GET["offset"])) ? max(0, min($_GET["offset"], $total - 1)) : 0;
	$offset = $offset - ($offset % $limit);

	$results = $db->query("select * from citacao ". $where . " order by " . $orderby . " limit " . $limit . " offset " . $offset);

	while ($row = $results->fetchArray()) {
		echo "<tr>\n";
		echo "<td><a href=\"updateCitacao.php?CODIGO=" . $row["CODIGO"] . "\">&#x1F4DD;</a></td>\n";
		echo "<td>" . $row["CODIGO"] . "</td>\n";
		echo "<td>\n";
		echo $row["COD_POST"];
		echo "</td>\n";
		echo "<td>\n";
		echo $row["COD_COMPARTILHAMENTO"];
		echo "</td>\n";
        echo "<td>" . $row["COD_RECAO"] . "</td>\n";
		echo "<td>\n";
		echo $row["EMAIL_USUARIO"];
		echo "</td>\n";
		


		echo "<td><a href=\"deleteUcitacao.php?CODIGO=" . $row["CODIGO"] . "\">&#x1F5D1;</a></td>\n";
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