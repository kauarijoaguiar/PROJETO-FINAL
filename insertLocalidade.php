<html>

<head>
	<title>Incluir Localidade</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<?php
	/*
.headers on
.mode column
PRAGMA foreign_keys = ON;
*/
	if (isset($_POST["Inclui"])) {
		$error = "";
		if ($error == "") {
			$db = new SQLite3("face.db");
			$db->exec("PRAGMA foreign_keys = ON");
			if ($_GET["ORIGEM"] == "PAISES" || $_GET["ORIGEM"] == "POST") {
				$db->exec("insert into localidade ( CODIGO, PAISES) values (" . $_GET["CODIGO"] . ", '" . $_POST["PAISES"] . "')");
			} elseif ($_GET["ORIGEM"] == "ESTADOS" || $_GET["ORIGEM"] == "POST") {
				$db->exec("insert into citacao ( CODIGO, ESTADOS) values (" . $_GET["CODIGO"] . ", '" . $_POST["ESTADOS"] . "')");
			} elseif ($_GET["ORIGEM"] == "CIDADES" || $_GET["ORIGEM"] == "POST") {
				$db->exec("insert into citacao ( CODIGOS, CIDADES) values (" . $_GET["CODIGO"] . ", '" . $_POST["CIDADES"] . "')");
			}
			$db->lastInsertRowID();
			$db->close();
		} else {
			echo "<font color=\"red\">" . $error . "</font>";
		}
	} else {
		$db = new SQLite3("face.db");

		$pais = $db->query("SELECT * FROM PAISES");
		echo '<tr>';
		echo '<td><label for="pais">Pais</label></td>';
		echo '<td><select name="pais" id="pais">';
		echo '<option value="" disabled selected>Escolha um Pais</option>';
		while ($listapais = $pais->fetchArray()) {
			echo "<option value=\"" . $listapais["CODIGO"] . "\">" . $listapais["NOME"] . "</option>";
		}
		echo '</select></td>';
		echo '</tr>';

		$estado = $db->query("SELECT * FROM ESTADOS");
		echo '<tr>';
		echo '<td><label for="estado">Estado</label></td>';
		echo '<td><select name="estado" id="estado">';
		echo '<option value="" disabled selected>Escolha um Estado</option>';
		while ($listaestado = $estado->fetchArray()) {
			echo "<option value=\"" . $listaestado["CODIGO"] . "\">" . $listaestado["NOME"] . "</option>";
		}
		echo '</select></td>';
		echo '</tr>';

		$cidade = $db->query("SELECT * FROM CIDADES");
		echo '<tr>';
		echo '<td><label for="cidade">Cidade</label></td>';
		echo '<td><select name="cidade" id="cidade">';
		echo '<option value="" disabled selected>Escolha uma Cidade</option>';
		while ($listacidade = $cidade->fetchArray()) {
			echo "<option value=\"" . $listacidade["CODIGO"] . "\">" . $listacidade["NOME"] . "</option>";
		}
	}


	echo '<td><input type="submit" name="Inclui" value="Inclui"></td>';
	?>
</body>
<?php
if (isset($_POST["Inclui"]) && $_GET["ORIGEM"] == "PAISES") {
	echo "<script>setTimeout(function () { window.open(\"selectInteraçao.php\",\"_self\"); }, 3000);</script>";
}
if (isset($_POST["Inclui"]) && $_GET["ORIGEM"] == "ESTADOS") {
	echo "<script>setTimeout(function () { window.open(\"selectReaçao.php\",\"_self\"); }, 3000);</script>";
}
if (isset($_POST["Inclui"]) && $_GET["ORIGEM"] == "CIDADES") {
	echo "<script>setTimeout(function () { window.open(\"selectCompart.php\",\"_self\"); }, 3000);</script>";
}
?>

</html>