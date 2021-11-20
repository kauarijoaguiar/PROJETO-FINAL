<html>
<body>
<?php
if (isset($_GET["EMAIL"])) {
	$db = new SQLite3("face.db");
	$db->exec("PRAGMA foreign_keys = ON");
	$db->exec("UPDATE USUARIO SET ATIVO = FALSE WHERE USUARIO.EMAIL= ". $_GET["EMAIL"]);
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