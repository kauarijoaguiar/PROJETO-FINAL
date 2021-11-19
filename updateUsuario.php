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

            echo '<tr>';
            echo '<td><label for="email">Email</label></td>';
            echo "<td><input type=\"email\" name=\"email\" id=\"email\" pattern=\"[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$\" value=\"" . $_GET["email"] . "\" required></td>";
            echo '</tr>';
    
            echo '<tr>';
            echo '<td><label for="nome">Nome</label></td>';
            echo "<td><input type=\"text\" name=\"nome\" id=\"nome\" pattern=\"^([a-zA-Z]{2,}\s[a-zA-Z]{1,}'?-?[a-zA-Z]{2,}\s?([a-zA-Z]{1,})?)\" value=\"" . $_GET["email"] . "\"required></td>";
            echo '</tr>';
    
            echo '<tr>';
            echo '<td><label for="Data">Data</label></td>';
            echo '<td>' . ucfirst(strftime('%a %d/%m/%y', strtotime('today'))) . '</td>';
            echo '</tr>';
    
            $cidade = $db->query("SELECT * FROM CIDADES");
            echo '<tr>';
            echo '<td><label for="cidade">cidade</label></td>';
            echo '<td><select name="cidade" id="cidade">';
            while ($listacidade = $cidade->fetchArray()) {
                echo "<option value=\"" . $listacidade["CODIGO"] . "\">" . $listacidade["CIDADE"] . "</option>";
            }
            echo '</select></td>';
            echo '</tr>';
    
            $pais = $db->query("SELECT * FROM PAISES");
            echo '<tr>';
            echo '<td><label for="pais">Pais</label></td>';
            echo '<td><select name="pais" id="pais">';
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
            echo '<td><label for="ativo">ativo</label></td>';
            echo '<td><input type="text" name="ativo" id="ativo"  required></td>';
            echo '</tr>';
    
    
            echo '<tr>';
            echo '<td><input type="submit" name="Inclui" value="Inclui"></td>';
            echo '</tr>';
    
            echo "<td><a href=\"updateUsuario.php\">UPDATE</a></td>\n";

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