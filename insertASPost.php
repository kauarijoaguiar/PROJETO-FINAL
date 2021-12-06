<html>
<body>
<?php
if (isset($_GET["CODIGO"]) && !isset($_POST["Alterar"])) {
        $db = new SQLite3("face.db");
        $db->exec("PRAGMA foreign_keys = ON");
        $posts = $db->query("SELECT * FROM POST WHERE CODIGO = " . $_GET["CODIGO"] . "");
        $posts = $posts->fetchArray();
        $db->close();
    if ($posts === false) {
        echo "<font color=\"red\">Post não encontrada</font>";
    } 
    else {
$db = new SQLite3("face.db");
echo '<form action="insertASPost.php" method="post" id="form">';
echo '<table>';
echo '<tr>';
echo '<td>';
echo '<h1>Incluir assuntos ao post '.$_GET["CODIGO"].'</h1>';
echo '</td>';
echo '</tr>';
$assunto = $db->query("SELECT * FROM ASSUNTO");
		echo '<tr>';
        echo '<td><label for="assunto">Assunto</label>';
        echo '<select name="assunto" id="assunto">';
		echo '<option value="" disabled selected>Escolha um Assunto</option>';
        while ($assuntos = $assunto->fetchArray()) {
            echo "<option value=\"" . $assuntos["CODIGO"] . "\">" . $assuntos["ASSUNTO"] . "</option>";
        }
        echo '</select></td>';
        echo '</tr>';
echo '<tr>';
echo '<td>';
echo '<input type="submit" name="Alterar" value="Incluir">';
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
            $db->exec("insert into ASSUNTOPOST (CODIGOASSUNTO, CODIGOPOST) values ('" . $_POST["assunto"] . "', '" . $_GET["CODIGO"] ."')");
            $db->close();
            echo "Assunto inserido!";
        } else {
            echo "<font color=\"red\">" . $error . "</font>";
        }
    }
?>
</body>
<?php
?>
</html>
