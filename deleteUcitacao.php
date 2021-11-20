<html>
<body>
<?php
if (isset($_GET["CODIGO"])) {
	$db = new SQLite3("face.db");
	$db->exec("PRAGMA foreign_keys = ON");
	$db->exec("UPDATE CITACAO SET ATIVO = FALSE WHERE CITACAO.CODIGO = "."'". $_GET["CODIGO"]."'");
	echo "Citação desativada.";
	$db->close();
}
?>
</body>
<script>
</script>
</html>

