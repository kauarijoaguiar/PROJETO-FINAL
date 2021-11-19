<html>

<head>
	<title>Alterar Sabor</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<?php
	/*
.headers on
.mode column
PRAGMA foreign_keys = ON;
*/

	if (isset($_GET["CODIGO"])) {
		$db = new SQLite3("face.db");
		$db->exec("PRAGMA foreign_keys = ON");
		$db->query("SELECT * FROM CITACAO WHERE CODIGO = " . $_GET["CODIGO"]);
		$db->fetchArray();
		$db->close();
		if ($db === false) {
			//echo "<font color=\"red\">Sabor não encontrado</font>";
		} else {
			$db = new SQLite3("face.db");
			echo '<form name="insert" method="post">';
			echo '<table>';
			echo '<caption><h1>Alterar Usuario</h1></caption>';
			echo '<tbody>';
            echo '<form name="insert" method="post">';
            echo '<table>';
            echo '<caption><h1>Incluir Usuario Em Uma Interação</h1></caption>';
            echo '<tbody>';
    
    
			echo '<td><select name="email" id="email">';
			$results = $db->query("SELECT * FROM USUARIO");
			while ($row = $results->fetchArray()) {
				echo "<option value=\"" . $row["EMAIL"] . "\">" . $row["NOME"] . "</option>";
			}
			echo '</select></td>';
			echo '<tr>';
			echo '<td><label for="Data">Data</label></td>';
			echo '<td>' . ucfirst(strftime('%a %d/%m/%y', strtotime('today'))) . '</td>';
			echo '</tr>';
	
			echo '<tr>';
	
			echo '</tr>';
			
			echo '<tr>';
			echo '<td><input type="submit" name="Alterar" value="Alterar"></td>';
			echo '</tr>';

			echo '</tbody>';
			echo '</table>';
			echo '</form>';
		}
	} else {
		if (isset($_POST["Alterar"])) {
			$error = "";
			if ($error == "") {
				$db = new SQLite3("face.db");
				$db->exec("PRAGMA foreign_keys = ON");
				//$db->exec("UPDATE CITACAO SET EMAIL = '" . $_POST["nome"] . "', tipo=" . $_POST["tipo"] . " where codigo = " . $_POST["codigo"]);
				$db->exec("UPDATE CITACAO SET EMAIL_USUARIO = '". $_POST["email"] ."'");
			
				$db->close();
			} else {
				echo "<font color=\"red\">" . $error . "</font>";
			}
		}
	}

	?>
</body>

</html>