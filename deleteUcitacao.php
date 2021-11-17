<html>
<body>
<?php
if (isset($_GET["codigo"])) {
	$db = new SQLite3("face.db");
	$db->exec("PRAGMA foreign_keys = ON");
	$db->exec("delete from citacao where codigo = ".$_GET["codigo"]);
	echo "Citação excluída.";
	$db->close();
}
?>
</body>
<script>
</script>
</html>

