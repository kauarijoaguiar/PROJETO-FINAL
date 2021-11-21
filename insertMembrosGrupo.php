<html>

<head>
    <title>Incluir Membro no Grupo</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    if (isset($_POST["Inclui"])) {
        $error = "";
        if ($error == "") {
            $db = new SQLite3("face.db");
            $db->exec("PRAGMA foreign_keys = ON");
            $ocorrenciaUsuarioGrupo = $db->query("select count(*) as total from grupousuario where codigogrupo = " . $_GET["CODIGOGRUPO"]. " AND email_usuario = '". $_POST["email"] ."' AND ATIVO = 1")->fetchArray()["total"];
            if($ocorrenciaUsuarioGrupo > 0) {
                echo "Membro já está no grupo!";
            
            } else {
                $ocorrenciaUsuarioGrupoInativo = $db->query("select count(*) as total from grupousuario where codigogrupo = " . $_GET["CODIGOGRUPO"] . " AND email_usuario = '" . $_POST["email"] . "' AND ATIVO = 0")->fetchArray()["total"];
                if($ocorrenciaUsuarioGrupoInativo > 0 ){
                    $db->exec("update grupousuario set ativo=1  where codigogrupo=" . $_GET["CODIGOGRUPO"] . " and  email_usuario = '" . $_POST["email"] . "'");
                } else {
                    $db->exec("insert into grupousuario (codigogrupo, email_usuario) values (". $_GET["CODIGOGRUPO"].",'" . $_POST["email"] . "')");
                }
                echo "Membro adicionado ao grupo!";
            }
            $db->close();
        } else {
            echo "<font color=\"red\">" . $error . "</font>";
        }
    } else {
        $db = new SQLite3("face.db");
        $nomeGrupo = $db->query("select grupo.NOMEGRUPO from grupo where grupo.codigo = " . $_GET["CODIGOGRUPO"])->fetchArray()["NOMEGRUPO"];


        echo '<form name="insert" method="post">';
        echo '<table>';
        echo '<caption><h1>Incluir Membro no Grupo '.$nomeGrupo.'</h1></caption>';
        echo '<tbody>';

        echo '<tr>';
        echo '<td><select name="email" id="email">';
        $results = $db->query("SELECT * FROM USUARIO");
        while ($row = $results->fetchArray()) {
            echo "<option value=\"" . $row["EMAIL"] . "\">" . $row["NOME"] . "</option>";
        }
        echo '</select></td>';
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
    echo "<script>setTimeout(function () { window.open(\"selectMembrosGrupo.php?CODIGOGRUPO=" . $_GET["CODIGOGRUPO"] . "\",\"_self\"); }, 2000);</script>";
}

?>

</html>