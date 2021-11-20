<html>
<body>
<?php
if (isset($_POST["confirma"])) {
	$error = "";
	if ($error == "") {
		$db = new SQLite3("face.db");
		$db->exec("PRAGMA foreign_keys = ON");
		$db->exec("insert into amizade (EMAIL_USUARIO1, EMAIL_USUARIO2, DATAAMIZADE) values ('" . $_POST["us1"] . "', '" . $_POST["us2"] ."','".date('d/m/Y H:i')."')");
		echo $db->changes()." Amizade feita<br>\n";
		$db->close();
		} else {
		echo "<font color=\"red\">".$error."</font>";
	}
} else {
$db = new SQLite3("face.db");
echo '<form action="AmizInsert.php" method="post" id="form">';
echo '<table>';
echo '<tr>';
echo '<td>';
echo '<h1>Solicitação de amizade</h1>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>';
echo "Data: ".date('d/m/Y H:i');
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>';
echo '<label for="us1">Usuário 1:</label>';
echo '<select name="us1" id="us1">';
$results = $db->query("select * from usuario");
while ($row = $results->fetchArray()){
    echo "<option value=\"".$row["EMAIL"]."\">".$row["NOME"]."</option>";
}
echo '</select>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>';
echo '<label for="us2">Usuário 2:</label>';
echo '<select name="us2" id="us2">';
$results = $db->query("select * from usuario");
while ($row = $results->fetchArray()){
    echo "<option value=\"".$row["EMAIL"]."\">".$row["NOME"]."</option>";
}
echo '</select>';
echo '</td>';
echo '</tr>';
echo '<td>';
echo '<button type="submit" name="confirma" id="confirma">Confirmar</button>';
echo '</td>';
echo '</tr>';
echo '</table>';
echo '</form>';
}
?>
</body>
<?php
if (isset($_POST["confirma"])) {
	echo "<script>setTimeout(function () { window.open(\"amizades.php\",\"_self\"); }, 3000);</script>";
}
?>
</html>
