<html>
<body>
<?php
if (isset($_GET["CODIGO"]) && !isset($_POST["Alterar"])) {
        $db = new SQLite3("face.db");
        $db->exec("PRAGMA foreign_keys = ON");
        $reacoes = $db->query("SELECT * FROM POST WHERE CODIGO = " . $_GET["CODIGO"] . "");
        $reacoes = $reacoes->fetchArray();
        $db->close();
    if ($reacoes === false) {
        echo "<font color=\"red\">Reação não encontrada</font>";
    } 
    else {
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
    } else if (isset($_POST["Alterar"])) {
        $error = "";
        if ($error == "") {
            $db = new SQLite3("face.db");
            $db->exec("PRAGMA foreign_keys = ON");
            $data = date('d-m-Y H:i');
            $db->exec("insert into REACAO (EMAIL_USUARIO, TIPOREACAO, COD_POST, CIDADE, UF, PAIS, DATAREACAO) values ('" . $_POST["us"] . "', '" . $_POST["reacao"] . "', '" . $_GET["CODIGO"] . "', '" . "' , $data , '" . $_POST["cidade"] . "', '" . $_POST["pais"] . "', '" . $_POST["estado"] ."')");
            $db->close();
            echo "Reação inserida!";
        } else {
            echo "<font color=\"red\">" . $error . "</font>";
        }
    }
?>
</body>
<?php
?>
</html>
