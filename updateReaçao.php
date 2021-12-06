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
echo '<form action="updateReaçao.php" method="post" id="form">';
echo '<table>';
echo '<tr>';
echo '<td>';
echo '<h1>Alterar Reação '.$_GET["CODIGO"].'</h1>';
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
            $db->exec("UPDATE REACAO SET TIPOREACAO = "."'" .$_POST["reacao"] . "'"."' WHERE CODIGO = " . "'" .$_GET["CODIGO"] . "'");
            $db->close();
            echo "Reação ALTERADA!";
        } else {
            echo "<font color=\"red\">" . $error . "</font>";
        }
    }
?>
</body>
<?php
if (isset($_POST["Alterar"])) {
	echo "<script>setTimeout(function () { window.open(\"selectPost.php\",\"_self\"); }, 3000);</script>";
}
?>
</html>
