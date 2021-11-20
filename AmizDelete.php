<html>
<body>
<?php
if (isset($_GET["EMAIL_USUARIO1"], $_GET["EMAIL_USUARIO2"])) {
    $db = new SQLite3("face.db");
    $db->exec("delete from amizade where EMAIL_USUARIO1 = " ."'".$_GET["EMAIL_USUARIO1"]."'". " and ". "EMAIL_USUARIO2 = "."'".$_GET["EMAIL_USUARIO2"]."'");
    echo $db->changes()." Amizade desfeita.";
    $db->close();
}
//delete from amizade where EMAIL_USUARIO1 = alice@mail.com.br and EMAIL_USUARIO2 = pele@cbf.com.br;
?>
</body>
<script>
setTimeout(function () { window.open("amizades.php","_self"); }, 3000);
</script>
</html>
