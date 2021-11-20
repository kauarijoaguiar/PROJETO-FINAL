<html>
<body>
<?php
if (isset($_GET["EMAIL"])) {
	$db = new SQLite3("face.db");
	$db->exec("PRAGMA foreign_keys = ON");
	echo $db->exec("UPDATE USUARIO SET ATIVO = 0 WHERE USUARIO.EMAIL = "."'". $_GET["EMAIL"]."'");
	echo "Usuario deletado.";
	$db->close();
}
//a
?>
</body>
<script>
setTimeout(function () { window.open("selectusuario.php","_self"); }, 2000);
</script>
</html>