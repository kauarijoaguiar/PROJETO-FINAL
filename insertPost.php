<html>
<body>
<?php
if (isset($_POST["Inclui"])) {
        $error = "";
        if ($error == "") {
            $db = new SQLite3("face.db");
            $db->exec("PRAGMA foreign_keys = ON");
            $db->exec("INSERT INTO POST (NOMEGRUPO) values ('" . $_POST["NOMEGRUPO"] . "')");
            echo "Grupo inserido!";
            $db->close();
        } else {
            echo "<font color=\"red\">" . $error . "</font>";
        }
    } else {
$db = new SQLite3("face.db");
echo '<form action="insertPost.php" method="post" id="form">';
echo '<table>';
echo '<tr>';
echo '<td>';
echo '<h1>Postar</h1>';
echo '</td>';
echo '</tr>';
echo '<td>';
echo '</td>';
echo '<tr>';
echo '<td><input type="text" name="POST" id="POST" pattern="^([a-zA-Z]{2,}\s[a-zA-Z]{1,}"?-?[a-zA-Z]{2,}\s?([a-zA-Z]{1,})?)" required size="50"></td>';
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
echo '<td>';
echo '<input type="submit" name="Alterar" value="Postar">';
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
