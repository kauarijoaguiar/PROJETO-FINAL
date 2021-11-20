<html>
<body>
<?php
echo $_GET["EMAIL_USUARIO1"];
if (isset($_GET["EMAIL_USUARIO1"], $_GET["EMAIL_USUARIO2"])) {
    $db = new SQLite3("face.db");
    $db->exec("PRAGMA foreign_keys = ON");
    $data = date('d/m/Y H:i');
    echo $db->exec("UPDATE AMIZADE SET ATIVO = 0 WHERE EMAIL_USUARIO1 = "."'". $_GET["EMAIL_USUARIO1"]."'"."AND"."EMAIL_USUARIO2 = "."'". $_GET["EMAIL_USUARIO2"]."')");    
    echo " Amizade desfeita.";
    $db->close();
}
//delete from amizade where EMAIL_USUARIO1 = 'alice@mail.com.br' and EMAIL_USUARIO2 = 'pele@cbf.com.br';
?>
</body>
<script>
setTimeout(function () { window.open("amizades.php","_self"); }, 3000);
</script>
</html>
