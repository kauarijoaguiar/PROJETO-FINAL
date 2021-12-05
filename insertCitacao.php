<html>
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
			if($_GET["ORIGEM"] == "COMENTARIO" || $_GET["ORIGEM"] == "POST" ){
				$db->exec("insert into citacao ( COD_POST, EMAIL_USUARIO) values (".$_GET["CODIGO"].", '" . $_POST["email"] . "')");
			}
			elseif($_GET["ORIGEM"] == "REACAO" || $_GET["ORIGEM"] == "POST"){
				$db->exec("insert into citacao ( COD_REACAO, EMAIL_USUARIO) values (".$_GET["CODIGO"].", '" . $_POST["email"] . "')");
			}
			elseif($_GET["ORIGEM"] == "COMPARTILHAMENTO" || $_GET["ORIGEM"] == "POST"){
				$db->exec("insert into citacao ( COD_COMPARTILHAMENTO, EMAIL_USUARIO) values (".$_GET["CODIGO"].", '" . $_POST["email"] . "')");
			}
			$db->lastInsertRowID();
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

        echo '<td><select name="email" id="email">';
		$results = $db->query("SELECT * FROM USUARIO");
		while ($row = $results->fetchArray()) {
			echo "<option value=\"" . $row["EMAIL"] . "\">" . $row["NOME"] . "</option>";
		}
		echo '</select></td>';
		
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
if (isset($_POST["Inclui"])) {
	echo "<script>setTimeout(function () { window.open(\"insertCitacao.php\",\"_self\"); }, 3000);</script>";
}

?>

</html>