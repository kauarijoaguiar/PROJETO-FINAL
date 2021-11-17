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

	if (isset($_GET["email"])) {
		$db = new SQLite3("face.db");
		$db->exec("PRAGMA foreign_keys = ON");
		$sabor = $db->query("select * from usuario where email = " . $_GET["email"]);
		$s = $sabor->fetchArray();
		$db->close();
		if ($s === false) {
			echo "<font color=\"red\">Sabor não encontrado</font>";
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
    
    
            echo '<td><select name="nome" id="nome">';
            $results = $db->query("select usuario.nome as nome from usuario");
            while ($row = $results->fetchArray()) {
                echo "<option value=\"" . $row["email"] . "\">" . $row["nome"] . "</option>";
            }
            echo '</select></td>';
            echo '<td><select name="nome" id="nome">';
            echo "<option>kaua</option>";
            echo "<option>th</option>";
            echo "<option>julia</option>";
            echo "<option>christian</option>";
            echo "<option>marina</option>";
            echo "<option>sabrina</option>";
    
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
	} else {
		if (isset($_POST["Alterar"])) {
			$error = "";
			if ($error == "") {
				$db = new SQLite3("face.db");
				$db->exec("PRAGMA foreign_keys = ON");
				//$db->exec("update sabor set nome = '" . $_POST["nome"] . "', tipo=" . $_POST["tipo"] . " where codigo = " . $_POST["codigo"]);
				$db->close();
			} else {
				echo "<font color=\"red\">" . $error . "</font>";
			}
		}
	}

	?>
</body>

</html>