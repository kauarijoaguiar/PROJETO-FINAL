<html>
<body>
<?php
if (isset($_GET["email"])) {
	$db = new SQLite3("pizzaria.db");
	$db->exec("PRAGMA foreign_keys = ON");
	$db->exec("update usuario set ativo = false");
	echo "Usuario Desativado.";
	$db->close();
}
//a
?>
</body>
<script>
//setTimeout(function () { window.open("pizzariaD.php","_self"); }, 2000);
</script>
</html>