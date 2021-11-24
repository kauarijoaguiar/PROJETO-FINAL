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
			$db->exec("insert into usuario (email, nome, datacadastro, cidade, pais, uf, genero, nascimento) values ('" . $_POST["email"] . "', '" . $_POST["nome"] . "' , DATE('now', 'localtime') , '" . $_POST["cidade"] . "', '" . $_POST["pais"] . "', '" . $_POST["estado"] . "', '" . $_POST["genero"] . "', '" . $_POST["nascimento"] ."')");
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
        while ($listaestado = $estado->fetchArray()) {
            echo "<option value=\"" . $listaestado["CODIGO"] . "\">" . $listaestado["ESTADO"] . "</option>";
        }
        echo '</select></td>';
        echo '</tr>';

		$cidade = $db->query("SELECT * FROM CIDADES");
		echo '<tr>';
        echo '<td><label for="cidade">Cidade</label></td>';
        echo '<td><select name="cidade" id="cidade">';
        while ($listacidade = $cidade->fetchArray()) {
            echo "<option value=\"" . $listacidade["CODIGO"] . "\">" . $listacidade["CIDADE"] . "</option>";
        }
        echo '</select></td>';
        echo '</tr>';		


		echo '<tr>';
		echo '<td><label for="genero">Genero</label></td>';
		echo '<td><input type="radio" id="genero" name="genero" value="M">M</td>';
		echo '<td><input type="radio" id="genero" name="genero" value="F">F</td>';
		echo '<td><input type="radio" id="genero" name="genero" value="N">N</td>';
		echo '</tr>';


		echo '<tr>';
		echo '<td><label for="nascimento">nascimento</label></td>';
		echo '<td><input type="date" name="nascimento" id="nascimento" required></td>';
		echo '</tr>';
		
		
		
		

		echo '<tr>';
		echo '<td><input type="submit" name="Inclui" value="Inclui"></td>';
		echo '</tr>';

		//echo "<td><a href=\"updateUsuario.php\">UPDATE</a></td>\n";
		echo '</tbody>';
		echo '</table>';
		echo '</form>';
	}

	?>
</body>
<?php


if (isset($_POST["Inclui"])) {
	echo "<script>setTimeout(function () { window.open(\"selectusuario.php\",\"_self\"); }, 3000);</script>";
}


?>

</html>