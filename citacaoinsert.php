<html>

<head>
	<title>Incluir Usuario na citação</title>
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
			//$db->exec("insert into usuario (email, nome, datacadastro, cidade, pais, uf, genero, nascimento, ativo) values ('" . $_POST["email"] . "', '" . $_POST["nome"] . "' , '" . $_POST["data"] . "' , '" . $_POST["cidade"] . "', '" . $_POST["paises"] . "', '" . $_POST["uf"] . "', '" . $_POST["genero"] . "', '" . $_POST["nascimento"] . "', '" . $_POST["ativo"] . "')");
			$db->close();
		} else {
			echo "<font color=\"red\">" . $error . "</font>";
		}
	} else {
		$db = new SQLite3("face.db");
		echo '<form name="insert" method="post">';
		echo '<table>';
		echo '<caption><h1>Incluir Usuario na citação</h1></caption>';
		echo '<tbody>';

        echo '<td><select name="nome" id="nome">';
		$results = $db->query("select usuario.nome as nome from usuario");
		while ($row = $results->fetchArray()) {
			echo "<option value=\"" . $row["email"] . "\">" . $row["nome"] . "</option>";
		}
		echo '</select></td>';
        echo '<tr>';
        echo '<td><label for="Data">Data</label></td>';
        echo '<td>' . ucfirst(strftime('%a %d/%m/%y', strtotime('today'))) . '</td>';
        echo '</tr>';

        echo '<tr>';

		echo '</tr>';
		
		echo '<tr>';
		echo '<td><input type="submit" name="Inclui" value="Inclui"></td>';
		echo '</tr>';


		echo '</tbody>';
		echo '</table>';
		echo '</form>';
	}

	?>
</body>
<?php


?>

</html>