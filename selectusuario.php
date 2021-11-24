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
		if (isset($_GET["EMAIL"])) $result["EMAIL"] = "EMAIL=" . $_GET["EMAIL"];
		if (isset($_GET["NOME"])) $result["NOME"] = "NOME=" . $_GET["NOME"];
		if (isset($_GET["DATACADASTRO"])) $result["DATACADASTRO"] = "DATACADASTRO=" . $_GET["DATACADASTRO"];
		if (isset($_GET["CIDADE"])) $result["CIDADE"] = "CIDADE=" . $_GET["CIDADE"];
		if (isset($_GET["PAIS"])) $result["PAIS"] = "PAIS=" . $_GET["PAIS"];
		if (isset($_GET["UF"])) $result["UF"] = "UF=" . $_GET["UF"];
        if (isset($_GET["GENERO"])) $result["GENERO"] = "GENERO=" . $_GET["GENERO"];
		if (isset($_GET["NASCIMENTO"])) $result["NASCIMENTO"] = "NASCIMENTO=" . $_GET["NASCIMENTO"];
		if (isset($_GET["ATIVO"])) $result["ATIVO"] = "ATIVO=" . $_GET["ATIVO"];
        if (isset($_GET["orderby"])) $result["orderby"] = "orderby=" . $_GET["orderby"];
		if (isset($_GET["offset"])) $result["offset"] = "offset=" . $_GET["offset"];
		$result[$campo] = $campo . "=" . $valor;
		return ("selectusuario.php?" . strtr(implode("&", $result), " ", "+"));
	}

	$db = new SQLite3("face.db");
	$db->exec("PRAGMA foreign_keys = ON");

	$limit = 5;

	echo "<h1>Usuarios</h1>\n";


	echo "<select id=\"campo\" name=\"campo\">\n";
	echo "<option value=\"EMAIL\"" . ((isset($_GET["EMAIL"])) ? " selected" : "") . ">EMAIL</option>\n";
	echo "<option value=\"NOME\"" . ((isset($_GET["NOME"])) ? " selected" : "") . ">NOME</option>\n";
	echo "<option value=\"DATACADASTRO\"" . ((isset($_GET["DATACADASTRO"])) ? " selected" : "") . ">DATACADASTRO</option>\n";
    echo "<option value=\"CIDADE\"" . ((isset($_GET["CIDADE"])) ? " selected" : "") . ">CIDADE</option>\n";
	echo "<option value=\"PAIS\"" . ((isset($_GET["PAIS"])) ? " selected" : "") . ">PAIS</option>\n";
	echo "<option value=\"UF\"" . ((isset($_GET["UF"])) ? " selected" : "") . ">UF</option>\n";
    echo "<option value=\"GENERO\"" . ((isset($_GET["GENERO"])) ? " selected" : "") . ">GENERO</option>\n";
	echo "<option value=\"NASCIMENTO\"" . ((isset($_GET["NASCIMENTO"])) ? " selected" : "") . ">NASCIMENTO</option>\n";
	echo "<option value=\"ATIVO\"" . ((isset($_GET["ATIVO"])) ? " selected" : "") . ">ATIVO</option>\n";
	echo "</select>\n";

	$value = "";

	if (isset($_GET["EMAIL"])) $value = $_GET["EMAIL"];
	if (isset($_GET["NOME"])) $value = $_GET["NOME"];
	if (isset($_GET["DATACADASTRO"])) $value = $_GET["DATACADASTRO"];
    if (isset($_GET["CIDADE"])) $value = $_GET["CIDADE"];
	if (isset($_GET["PAIS"])) $value = $_GET["PAIS"];
	if (isset($_GET["UF"])) $value = $_GET["UF"];
    if (isset($_GET["GENERO"])) $value = $_GET["GENERO"];
	if (isset($_GET["NASCIMENTO"])) $value = $_GET["NASCIMENTO"];
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
	echo "<a href=\"\" onclick=\"value = document.getElementById('valor').value.trim().replace(/ +/g, '+'); result = '" . strtr(implode("&", $parameters), " ", "+") . "'; result = ((value != '') ? document.getElementById('campo').value+'='+value+((result != '') ? '&' : '') : '')+result; this.href ='selectusuario.php'+((result != '') ? '?' : '')+result;\">&#x1F50E;</a><br>\n";
	echo "<br>\n";

	echo "<table class=\"grid\">\n";
	echo "<tr>\n";
	echo "<td><a href=\"insertUsuario.php\">&#x1F4C4;</a></td>\n";
	echo "<td><b>EMAIL</b> <a href=\"" . url("orderby", "EMAIL+asc") . "\">&#x25BE;</a> <a href=\"" . url("orderby", "EMAIL+desc") . "\">&#x25B4;</a></td>\n";
	echo "<td><b>NOME</b><a href=\"" . url("orderby", "NOME+asc") . "\">&#x25BE;</a> <a href=\"" . url("orderby", "NOME+desc") . "\">&#x25B4;</a></td>\n";
    echo "<td><b>DATACADASTRO</b><a href=\"" . url("orderby", "DATACADASTRO+asc") . "\">&#x25BE;</a> <a href=\"" . url("orderby", "DATACADASTRO+desc") . "\">&#x25B4;</a></td>\n";
    echo "<td><b>CIDADE</b><a href=\"" . url("orderby", "CIDADE+asc") . "\">&#x25BE;</a> <a href=\"" . url("orderby", "CIDADE+desc") . "\">&#x25B4;</a></td>\n";
    echo "<td><b>PAIS</b><a href=\"" . url("orderby", "PAIS+asc") . "\">&#x25BE;</a> <a href=\"" . url("orderby", "PAIS+desc") . "\">&#x25B4;</a></td>\n";
    echo "<td><b>UF</b><a href=\"" . url("orderby", "UF+asc") . "\">&#x25BE;</a> <a href=\"" . url("orderby", "UF+desc") . "\">&#x25B4;</a></td>\n";
    echo "<td><b>GENERO</b><a href=\"" . url("orderby", "GENERO+asc") . "\">&#x25BE;</a> <a href=\"" . url("orderby", "GENERO+desc") . "\">&#x25B4;</a></td>\n";
    echo "<td><b>NASCIMENTO</b><a href=\"" . url("orderby", "NASCIMENTO+asc") . "\">&#x25BE;</a> <a href=\"" . url("orderby", "NASCIMENTO+desc") . "\">&#x25B4;</a></td>\n";
    echo "<td><b>ATIVO</b></td>\n";
	echo "<td></td>\n";
	echo "</tr>\n";

	$where = array();

	if (isset($_GET["EMAIL"])) $where[] = "EMAIL like '%" . strtr($_GET["EMAIL"], " ", "%") . "%'";
	if (isset($_GET["NOME"])) $where[] = "NOME like '%" . strtr($_GET["NOME"], " ", "%") . "%'"; 
	if (isset($_GET["DATACADASTRO"])) $where[] = "DATACADASTRO like '%" . strtr($_GET["DATACADASTRO"], " ", "%") . "%'";
    if (isset($_GET["CIDADE"])) $where[] = "CIDADE like '%" . strtr($_GET["CIDADE"], " ", "%") . "%'";
	if (isset($_GET["PAIS"])) $where[] = "PAIS like '%" . strtr($_GET["PAIS"], " ", "%") . "%'"; 
    if (isset($_GET["UF"])) $where[] = "UF like '%" . strtr($_GET["UF"], " ", "%") . "%'";
	if (isset($_GET["GENERO"])) $where[] = "GENERO like '%" . strtr($_GET["GENERO"], " ", "%") . "%'"; 
    if (isset($_GET["NASCIMENTO"])) $where[] = "NASCIMENTO like '%" . strtr($_GET["NASCIMENTO"], " ", "%") . "%'";
	if (isset($_GET["ATIVO"])) $where[] = "ATIVO like '%" . strtr($_GET["ATIVO"], " ", "%") . "%'"; 
    $where = (count($where) > 0) ? "where " . implode(" and ", $where) : "";

	$total = $db->query("select count(*) as total from usuario " . $where . ";")->fetchArray()["total"];

	$orderby = (isset($_GET["orderby"])) ? $_GET["orderby"] : "NOME asc";

	$offset = (isset($_GET["offset"])) ? max(0, min($_GET["offset"], $total - 1)) : 0;
	$offset = $offset - ($offset % $limit);

	$results = $db->query("select * from usuario". $where . " order by " . $orderby . " limit " . $limit . " offset " . $offset);

	while ($row = $results->fetchArray()) {
		echo "<tr>\n";
		echo "<td><a href=\"updateUsuario.php?EMAIL=" . $row["EMAIL"] . "\">&#x1F4DD;</a></td>\n";
		echo "<td>" . $row["EMAIL"] . "</td>\n";
		echo "<td>\n";
		echo $row["NOME"];
		echo "</td>\n";
		echo "<td>\n";
		echo $row["DATACADASTRO"];
		echo "</td>\n";
        echo "<td>" . $row["CIDADE"] . "</td>\n";
		echo "<td>\n";
		echo $row["PAIS"];
		echo "</td>\n";
        echo "<td>" . $row["UF"] . "</td>\n";
		echo "<td>\n";
		echo $row["GENERO"];
		echo "</td>\n";
        echo "<td>" . $row["NASCIMENTO"] . "</td>\n";
		echo "<td>\n";
		echo $row["ATIVO"];
		echo "</td>\n";


		echo "<td><a href=\"softdeleteUsuario.php?EMAIL=" . $row["EMAIL"] . "\">&#x1F5D1;</a></td>\n";
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