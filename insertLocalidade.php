<html>

<head>
	<title>Incluir Usuario</title>
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
			$db->exec("insert into usuario (cidade, pais, uf values ('" . $_POST["cidade"] . "', '" . $_POST["pais"] . "', '" . $_POST["estado"] ."')");
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
        echo '</select></td>';
        echo '</tr>';		

	}

	?>
</body>
<?php


if (isset($_POST["Inclui"])) {
	echo "<script>setTimeout(function () { window.open(\"selectLocalidade.php\",\"_self\"); }, 3000);</script>";
}


?>

</html>
