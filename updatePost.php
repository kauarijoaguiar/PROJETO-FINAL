<html>
<body>
<?php
if (isset($_GET["CODIGO"]) && !isset($_POST["Alterar"])) {
        $db = new SQLite3("face.db");
        $db->exec("PRAGMA foreign_keys = ON");
        $posts = $db->query("SELECT * FROM POST WHERE CODIGO = " . $_GET["CODIGO"] . "");
        $posts = $posts->fetchArray();
        $db->close();
    if ($posts === false) {
        echo "<font color=\"red\">Grupo não encontrado</font>";
    } 
    else {
echo '<form action="updatePost.php" method="post" id="form">';
echo '<table>';
echo '<tr>';
echo '<td>';
echo '<h1>Alterar Post</h1>';
echo '</td>';
echo '</tr>';
echo '<td>';
ECHO $HOLDER = $posts[2];
echo '</td>';
echo '<tr>';
echo '<td><input type="text" name="POST" id="POST" pattern="^([a-zA-Z]{2,}\s[a-zA-Z]{1,}"?-?[a-zA-Z]{2,}\s?([a-zA-Z]{1,})?)" required size="50"></td>';
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
            $db->exec("UPDATE POST SET POST = "."'" .$_POST["POST"] . "'"."' WHERE CODIGO = " . "'" .$_POST["CODIGO"] . "'");
            $db->close();
            echo "Grupo alterado!";
        } else {
            echo "<font color=\"red\">" . $error . "</font>";
        }
    }
?>
</body>
<?php
?>
</html>
