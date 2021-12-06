<html>
<body>
<?php
if (isset($_GET["CODIGO"])) {
	$db = new SQLite3("face.db");
	$db->exec("PRAGMA foreign_keys = ON");
	$db->exec("UPDATE ASSUNTOCOMPART SET ATIVO = 0 WHERE ASSUNTOCOMPART.ASSUNTOCOMPART = "."'". $_GET["CODIGO"]."'");
	echo "Assuntos retirados.";
	$db->close();
}
?>
</body>
<script>
    setTimeout(function () { window.open("selectPost.php","_self"); }, 1000);
</script>
</html>
