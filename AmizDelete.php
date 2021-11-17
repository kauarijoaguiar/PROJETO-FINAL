<html>
<body>
<?php
if (isset($_GET["email"], $_GET["email2"])) {
    $db = new SQLite3("pizzaria.db");
    $results = $db->query("select * from amizade where EMAIL_USUARIO1 = " . $_GET["email"]. " and ". "EMAIL_USUARIO2 = ".$_GET["email2"]);
    $db->exec("delete from from amizade where EMAIL_USUARIO1 = " . $_GET["email"]. " and ". "EMAIL_USUARIO2 = ".$_GET["email2"]);
    echo $db->changes()." Amizade desfeita.";
    $db->close();
}
?>
</body>
<script>
// setTimeout(function () { window.open("select.php","_self"); }, 3000);
</script>
</html>
