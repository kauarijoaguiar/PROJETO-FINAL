<html>
<body>
<?php
if (isset($_GET["CODIGO"]) && !isset($_POST["Alterar"])) {
        $db = new SQLite3("face.db");
        $db->exec("PRAGMA foreign_keys = ON");
        $reacoes = $db->query("SELECT * FROM REACAO WHERE CODIGO = " . $_GET["CODIGO"] . "");
        $reacoes = $reacoes->fetchArray();
        $db->close();
    if ($reacoes === false) {
        echo "<font color=\"red\">Grupo não encontrado</font>";
    } 
    else {
echo '<form action="updateReaçao.php" method="post" id="form">';
echo '<table>';
echo '<tr>';
echo '<td>';
echo '<h1>Alterar Reação</h1>';
echo '</td>';
echo '</tr>';
echo '<td>';
echo '</td>';
echo '<tr>';
echo '<td>';
echo '<label for="reacao">Reação:</label>';
echo '<select name="reacao" id="reacao">';
echo '<option value="" disabled selected>'.$reacoes[2].'</option>';
echo '<option value Amei = >Amei</option>';
echo '<option value Curtida = >Curtida</option>';
echo '<option value Triste = >Triste</option>';
echo '<option value Hahaha = >Hahaha</option>';
echo '</select>';
echo '</td>';
echo '</tr>';
echo '<td>';
echo '<input type="submit" name="Alterar" value="Alterar">';
echo '</td>';
echo '</tr>';
echo '</table>';
echo '</form>';
}
    } else if (isset($_POST["Alterar"])) {
        $error = "";
        if ($error == "") {
            $db = new SQLite3("face.db");
            $db->exec("PRAGMA foreign_keys = ON");
            //$db->exec("insert into POST (CODIGO, EMAIL_USUARIO, POST, CIDADE, UF, PAIS, DATAPOST, CODPOSTREFERENCIA, CODIGOGRUPO, CLASSIFICACAO) values ('" . $_POST["CODIGO"] . "', '" . $_POST["nome"] . "' , DATE('now', 'localtime') , '" . $_POST["cidade"] . "', '" . $_POST["pais"] . "', '" . $_POST["estado"] . "', '" . $_POST["genero"] . "', '" . $_POST["nascimento"] ."')");
            $db->close();
            echo "Reação alterada!";
        } else {
            echo "<font color=\"red\">" . $error . "</font>";
        }
    }
?>
</body>
<?php
?>
</html>
