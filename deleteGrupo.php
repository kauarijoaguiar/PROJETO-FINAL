<html>

<body>
    <?php
    if (isset($_GET["CODIGO"])) {
        $db = new SQLite3("face.db");
        $db->exec("PRAGMA foreign_keys = ON");
        $db->exec("UPDATE GRUPO SET ATIVO = 0 WHERE CODIGO = " . $_GET["CODIGO"]."");
        echo "Grupo eliminado.";
        $db->close();
    }
    ?>
</body>
<script>
    setTimeout(function () { window.open("selectGrupo.php","_self"); }, 1000);
</script>

</html>