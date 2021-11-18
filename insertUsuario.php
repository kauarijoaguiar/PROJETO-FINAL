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
			//$db->exec("insert into usuario (email, nome, datacadastro, cidade, pais, uf, genero, nascimento, ativo) values ('" . $_POST["email"] . "', '" . $_POST["nome"] . "' , '" . $_POST["data"] . "' , '" . $_POST["cidade"] . "', '" . $_POST["paises"] . "', '" . $_POST["uf"] . "', '" . $_POST["genero"] . "', '" . $_POST["nascimento"] . "', '" . $_POST["ativo"] . "')");
			$db->close();
		} else {
			echo "<font color=\"red\">" . $error . "</font>";
		}
	} else {
		$db = new SQLite3("face.db");
		echo '<form name="insert" method="post">';
		echo '<table>';
		echo '<caption><h1>Incluir Usuario</h1></caption>';
		echo '<tbody>';

        echo '<tr>';
		echo '<td><label for="email">Email</label></td>';
		echo '<td><input type="email" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required></td>';
		echo '</tr>';

		echo '<tr>';
		echo '<td><label for="nome">Nome</label></td>';
		echo '<td><input type="text" name="nome" id="nome" pattern="^([a-zA-Z]{2,}\s[a-zA-Z]{1,}"?-?[a-zA-Z]{2,}\s?([a-zA-Z]{1,})?)" required></td>';
		echo '</tr>';

        echo '<tr>';
        echo '<td><label for="Data">Data</label></td>';
        echo '<td>' . ucfirst(strftime('%a %d/%m/%y', strtotime('today'))) . '</td>';
        echo '</tr>';

		echo '<tr>';
		echo '<td><label for="nascimento">nascimento</label></td>';
		echo '<td><input type="date" name="nascimento" id="nascimento" required></td>';
		echo '</tr>';
		
		echo '<tr>';
		echo '<td><input type="submit" name="Inclui" value="Inclui"></td>';
		echo '</tr>';

		echo "<td><a href=\"update.php\">UPDATE</a></td>\n";
		echo '</tbody>';
		echo '</table>';
		echo '</form>';
	}

	?>
</body>
<?php


if (isset($_POST["Inclui"])) {
	echo "<script>setTimeout(function () { window.open(\"pizzariaA.php\",\"_self\"); }, 3000);</script>";
}


?>

</html>