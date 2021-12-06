<html>

<body>
    <?php
    if (isset($_GET["CODIGO"]) && isset($_GET["PAISES"])) {
        $db = new SQLite3("face.db");
        $db->exec("PRAGMA foreign_keys = ON");
        $db->exec("UPDATE PAISES SET ATIVO = 0 WHERE CODIGO = " . $_GET["CODIGO"]);
        echo " Localidade desfeita.";
        $db->close();
    }
    if (isset($_GET["CODIGO"]) && isset($_GET["ESTADOS"])) {
        $db = new SQLite3("face.db");
        $db->exec("PRAGMA foreign_keys = ON");
        $db->exec("UPDATE ESTADOS SET ATIVO = 0 WHERE CODIGO = " . $_GET["CODIGO"]);
        echo " Localidade desfeita.";
        $db->close();
    }
    if (isset($_GET["CODIGO"]) && isset($_GET["CIDADES"])) {
        $db = new SQLite3("face.db");
        $db->exec("PRAGMA foreign_keys = ON");
        $db->exec("UPDATE CIDADES SET ATIVO = 0 WHERE CODIGO = " . $_GET["CODIGO"]);
        echo " Localidade desfeita.";
        $db->close();
    }
    ?>
</body>
<script>
    setTimeout(function() {
        window.open("selectAmizade.php", "_self");
    }, 3000);
</script>

</html>