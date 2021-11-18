<html>
<body>
<?php
if (isset($_GET["codigo"])) {
	$db = new SQLite3("face.db");
	$db->exec("PRAGMA foreign_keys = ON");
	$db->exec("update citacao set ativo = false where citacao.codigo= ". $_GET["codigo"]);
	echo "Citação desativada.";
	$db->close();
}
?>
</body>
<script>
</script>
</html>

