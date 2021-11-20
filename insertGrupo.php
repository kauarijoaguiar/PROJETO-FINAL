<html>

<head>
    <title>Incluir Grupo</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    if (isset($_POST["Inclui"])) {
        $error = "";
        if ($error == "") {
            $db = new SQLite3("face.db");
            $db->exec("PRAGMA foreign_keys = ON");
            $db->exec("insert into grupo (NOMEGRUPO) values ('" . $_POST["NOMEGRUPO"] . "')");
            echo "Grupo inserido!";
            $db->close();
        } else {
            echo "<font color=\"red\">" . $error . "</font>";
        }
    } else {
        $db = new SQLite3("face.db");

        echo '<form name="insert" method="post">';
        echo '<table>';
        echo '<caption><h1>Incluir Grupo</h1></caption>';
        echo '<tbody>';

        echo '<tr>';
        echo '<td><label for="NOMEGRUPO">Nome</label></td>';
        echo '<td><input type="text" name="NOMEGRUPO" id="NOMEGRUPO" pattern="^([a-zA-Z]{2,}\s[a-zA-Z]{1,}"?-?[a-zA-Z]{2,}\s?([a-zA-Z]{1,})?)" required></td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td><input type="submit" name="Inclui" value="Inclui"></td>';
        echo '</tr>';

        echo '</tbody>';
        echo '</table>';
        echo '</form>';
    }

    ?>
</body>
<?php


if (isset($_POST["Inclui"])) {
    echo "<script>setTimeout(function () { window.open(\"selectGrupo.php\",\"_self\"); }, 1000);</script>";
}


?>

</html>