<html>

<body>
    <?php
    if (isset($_GET["CODIGOGRUPO"]) && isset($_GET["EMAIL_USUARIO"])) {
        $db = new SQLite3("face.db");
        $db->exec("PRAGMA foreign_keys = ON");
        $db->exec("UPDATE GRUPOUSUARIO SET ATIVO = 0 WHERE CODIGOGRUPO = " . $_GET["CODIGOGRUPO"] . " AND EMAIL_USUARIO = '" . ($_GET["EMAIL_USUARIO"]) . "'");
        echo "Usuário retirado do grupo.";
        $db->close();
    }
    ?>
</body>

<?php

echo "<script>setTimeout(function () { window.open(\"selectMembrosGrupo.php?CODIGOGRUPO=" . $_GET["CODIGOGRUPO"] . "\",\"_self\"); }, 2000);</script>";

?>

</html>