<html>
<body>
<?php
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
echo '<form action="insertReaçao.php" method="post" id="form">';
echo '<table>';
echo '<tr>';
echo '<td>';
echo '<h1>Reagir</h1>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>';
echo '<label for="reacao">Reação:</label>';
echo '<select name="reacao" id="reacao">';
echo '<option value Amei = >Amei</option>';
echo '<option value Curtida = >Curtida</option>';
echo '<option value Triste = >Triste</option>';
echo '<option value Hahaha = >Hahaha</option>';
echo '</select>';
echo '</td>';
echo '</tr>';
echo '<tr>';
$assunto = $db->query("SELECT * FROM USUARIO");
	echo '<tr>';
    echo '<td><label for="us">Usuario</label>';
    echo '<select name="us" id="us">';
	echo '<option value="" disabled selected>Escolha um Usuário</option>';
    while ($assuntos = $assunto->fetchArray()) {
        echo "<option value=\"" . $assuntos["EMAIL"] . "\">" . $assuntos["NOME"] . "</option>";
    }
    echo '</select></td>';
    echo '</tr>';
$pais = $db->query("SELECT * FROM PAISES");
		echo '<tr>';
        echo '<td><label for="pais">Pais</label>';
        echo '<select name="pais" id="pais">';
		echo '<option value="" disabled selected>Escolha um Pais</option>';
        while ($listapais = $pais->fetchArray()) {
            echo "<option value=\"" . $listapais["CODIGO"] . "\">" . $listapais["NOME"] . "</option>";
        }
        echo '</select></td>';
        echo '</tr>';

		$estado = $db->query("SELECT * FROM ESTADOS");
		echo '<tr>';
        echo '<td><label for="estado">Estado</label>';
        echo '<select name="estado" id="estado">';
		echo '<option value="" disabled selected>Escolha um Estado</option>';
        while ($listaestado = $estado->fetchArray()) {
            echo "<option value=\"" . $listaestado["CODIGO"] . "\">" . $listaestado["NOME"] . "</option>";
        }
        echo '</select></td>';
        echo '</tr>';

		$cidade = $db->query("SELECT * FROM CIDADES");
		echo '<tr>';
        echo '<td><label for="cidade">Cidade</label>';
        echo '<select name="cidade" id="cidade">';
		echo '<option value="" disabled selected>Escolha uma Cidade</option>';
        while ($listacidade = $cidade->fetchArray()) {
            echo "<option value=\"" . $listacidade["CODIGO"] . "\">" . $listacidade["NOME"] . "</option>";
        }
        echo '</select></td>';
        echo '</tr>';		
echo '<tr>';
echo '<td>';
echo '<input type="submit" name="Alterar" value="Reagir">';
echo '</td>';
echo '</tr>';
echo '</table>';
echo '</form>';
}

?>
</body>
<?php
?>
</html>
