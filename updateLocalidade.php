<html>

<head>
    <title>Alterar Usuario</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    /*
.headers on
.mode column
PRAGMA foreign_keys = ON;
*/

    if (isset($_GET["PAISES"])) {
        $db = new SQLite3("face.db");
        $db->exec("PRAGMA foreign_keys = ON");
        $LOCALIDADE = $db->query("SELECT * FROM PAISES WHERE CODIGO = " . "'" . $_GET["CODIGO"] . "'");
        $L = $LOCALIDADE->fetchArray();
        $db->close();
        if ($L === false) {
            echo "<font color=\"red\">Localidade não encontrado</font>";
        } else {
            $db = new SQLite3("face.db");
            echo '<form name="insert" action="updateLocalidade.php" method="post">';
            echo '<table>';
            echo '<caption><h1>Alterar Localidade</h1></caption>';
            echo '<tbody>';

            $cidade = $db->query("SELECT * FROM CIDADES");
            echo '<tr>';
            echo '<td><label for="cidade">cidade</label></td>';
            echo '<td><select name="cidade" id="cidade">';
            while ($listacidade = $cidade->fetchArray()) {
                echo "<option value=\"" . $listacidade["CODIGO"] . "\">" . $listacidade["CIDADES"] . "</option>";
            }
            echo '</select></td>';
            echo '</tr>';

            $pais = $db->query("SELECT * FROM PAISES");
            echo '<tr>';
            echo '<td><label for="pais">Pais</label></td>';
            echo '<td><select name="pais" id="pais">';
            while ($listapais = $pais->fetchArray()) {
                echo "<option value=\"" . $listapais["CODIGO"] . "\">" . $listapais["NOME"] . "</option>";
            }
            echo '</select></td>';
            echo '</tr>';

            $estado = $db->query("SELECT * FROM ESTADOS");
            echo '<tr>';
            echo '<td><label for="estado">Estado</label></td>';
            echo '<td><select name="estado" id="estado">';
            while ($listaestado = $estado->fetchArray()) {
                echo "<option value=\"" . $listaestado["CODIGO"] . "\">" . $listaestado["ESTADOs"] . "</option>";
            }
            echo '</select></td>';
            echo '</tr>';

            echo '</tbody>';
            echo '</table>';
            echo '</form>';
        }
    } else {
        if (isset($_POST["Alterar"])) {
            $error = "";
            if ($error == "") {
                $db = new SQLite3("face.db");
                $db->exec("PRAGMA foreign_keys = ON");
                $db->exec("UPDATE PAISES SET CODIGO =" . "'" . $_POST["CIDADES"] . "', PAISES =" . "'" . $_POST["PAISES"] . "', ESTADOS =" . "'" . $_POST["ESTADOS"] ."', CODIGO =" . "'" . $_POST["CODIGO"] . "'");
                $db->close();
            } else {
                echo "<font color=\"red\">" . $error . "</font>";
            }
        }
    }

    ?>
</body>
<?php


if (isset($_POST["Alterar"])) {
    echo "<script>setTimeout(function () { window.open(\"selectusuario.php\",\"_self\"); }, 3000);</script>";
}


?>

</html>