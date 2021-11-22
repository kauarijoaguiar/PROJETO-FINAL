<html>

<head>
	<title>Alterar Usuario</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<?php
	/*
.headers on
.mode column
PRAGMA foreign_keys = ON;
*/

	if (isset($_GET["EMAIL"])) {
		$db = new SQLite3("face.db");
		$db->exec("PRAGMA foreign_keys = ON");
		$USUARIO = $db->query("SELECT * FROM USUARIO WHERE EMAIL = "."'". $_GET["EMAIL"]."'");
		$U = $USUARIO->fetchArray();
		$db->close();
		if ($U === false) {
			echo "<font color=\"red\">Usuario não encontrado</font>";
		} else {
			$db = new SQLite3("face.db");
			echo '<form name="insert" action="updateUsuario.php" method="post">';
			echo '<table>';
			echo '<caption><h1>Alterar Usuario</h1></caption>';
			echo '<tbody>';

            echo '<tr>';
            echo '<td><label for="email">Email</label></td>';
            echo "<td><input type=\"email\" name=\"email\" id=\"email\" pattern=\"[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$\" value=\"" . $_GET["EMAIL"] . "\" required></td>";
            echo '</tr>';
    

            $nome = $db->query("SELECT USUARIO.NOME AS NOME FROM USUARIO WHERE EMAIL = "."'". $_GET["EMAIL"]."'");
			while ($n = $nome->fetchArray()) {
				echo '<td><label for="nome">Nome</label></td>';
				echo "<td><input type=\"text\" name=\"nome\" id=\"nome\" pattern=\"^([a-zA-Z]{2,}\s[a-zA-Z]{1,}'?-?[a-zA-Z]{2,}\s?([a-zA-Z]{1,})?)\" value=\"" . $n["NOME"] . "\" required></td>";
			}
    
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
            echo '<td><input type="submit" name="Alterar" value="Alterar"></td>';
            echo '</tr>';
    

            //$genero = $db->query("SELECT USUARIO.GENERO AS GENERO FROM USUARIO WHERE EMAIL = "."'". $_GET["EMAIL"]."'");

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
				$db->exec("UPDATE USUARIO SET EMAIL =  "."'". $_POST["email"]."', NOME ="."'". $_POST["nome"]."', DATACADASTRO = DATE('now', 'localtime')', CIDADE ="."'". $_POST["cidade"]."', PAIS ="."'". $_POST["pais"]."', UF ="."'". $_POST["estado"]."', GENERO ="."'". $_POST["genero"]."'  WHERE EMAIL = "."'". $_POST["email"]."'");
				 //echo ("UPDATE USUARIO SET EMAIL =  "."'". $_POST["email"]."' WHERE EMAIL = "."'". $_POST["email"]."'");
                 $db->close();
			} else {
				echo "<font color=\"red\">" . $error . "</font>";
			}
		}
	}

	?>
</body>
<?php


if (isset($_POST["Alterar"])) {
	echo "<script>setTimeout(function () { window.open(\"selectusuario.php\",\"_self\"); }, 3000);</script>";
}


?>

</html>