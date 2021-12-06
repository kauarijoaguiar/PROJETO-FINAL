<html>
<body>
<?php
if (isset($_GET["CODIGO"])) {
	$db = new SQLite3("face.db");
	$db->exec("PRAGMA foreign_keys = ON");
	$db->exec("UPDATE ASSUNTOPOST SET ATIVO = 0 WHERE ASSUNTOPOST.CODIGOPOST = "."'". $_GET["CODIGO"]."'");
	echo "Assuntos retirados.";
	$db->close();
}
?>
</body>
<script>
    setTimeout(function () { window.open("selectPost.php","_self"); }, 1000);
</script>
</html>
