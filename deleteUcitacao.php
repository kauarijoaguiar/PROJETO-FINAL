<html>
<body>
<?php
if (isset($_GET["CODIGO"])) {
	$db = new SQLite3("face.db");
	$db->exec("PRAGMA foreign_keys = ON");
	$db->exec("update citacao set ativo = false where citacao.codigo= ". $_GET["CODIGO"]);
	echo "Citação desativada.";
	$db->close();
}
?>
</body>
<script>
</script>
</html>

