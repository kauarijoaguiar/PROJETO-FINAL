<html>

<head>
    <title>Alterar Grupo</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php


    if (isset($_GET["CODIGO"]) && !isset($_POST["Alterar"])) {
        $db = new SQLite3("face.db");
        $db->exec("PRAGMA foreign_keys = ON");
        $grupos = $db->query("SELECT * FROM GRUPO WHERE CODIGO = " . $_GET["CODIGO"] . "");
        $grupo = $grupos->fetchArray();
        $db->close();
        if ($grupo === false) {
            echo "<font color=\"red\">Grupo não encontrado</font>";
        } else {
            echo '<caption><h3>Alterar Grupo</h3></caption>';
            echo '<form name="update" method="post">';
            echo '<table>';
            echo '<tbody>';

            echo '<tr>';
            echo '<td><label for="NOMEGRUPO">Nome</label></td>';
            echo '<td><input type="text" value="' . $grupo["NOMEGRUPO"] . '" name="NOMEGRUPO" id="NOMEGRUPO" pattern="^([a-zA-Z]{2,}\s[a-zA-Z]{1,}"?-?[a-zA-Z]{2,}\s?([a-zA-Z]{1,})?)" required></td>';
            echo '<td><input type="text" value="' . $grupo["CODIGO"] . '" name="CODIGO" id="CODIGO" hidden></td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td><input type="submit" name="Alterar" value="Alterar"></td>';
            echo '</tr>';

            echo '</tbody>';
            echo '</table>';
            echo '</form>';
        }
    } else if (isset($_POST["Alterar"])) {
        $error = "";
        if ($error == "") {
            $db = new SQLite3("face.db");
            $db->exec("PRAGMA foreign_keys = ON");
            $db->exec("UPDATE GRUPO SET NOMEGRUPO = '" . $_POST["NOMEGRUPO"] . "' WHERE CODIGO='" . $_POST["CODIGO"] . "'");

            $db->close();
            echo "Grupo alterado!";
        } else {
            echo "<font color=\"red\">" . $error . "</font>";
        }
    }

    ?>
</body>
<?php

if (isset($_POST["Alterar"])) {
    echo "<script>setTimeout(function () { window.open(\"selectGrupo.php\",\"_self\"); }, 1000);</script>";
}
?>

</html>