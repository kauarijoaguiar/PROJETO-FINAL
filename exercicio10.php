<html>

<body>
    <?php
    function url($campo, $valor)
    {
        $result = array();
        if (isset($_GET["CODIGO"])) $result["CODIGO"] = "CODIGO=" . $_GET["CODIGO"];
        if (isset($_GET["EMAIL_USUARIO"])) $result["EMAIL_USUARIO"] = "EMAIL_USUARIO=" . $_GET["EMAIL_USUARIO"];
        if (isset($_GET["POST"])) $result["POST"] = "POST=" . $_GET["POST"];
        if (isset($_GET["CIDADE"])) $result["CIDADE"] = "CIDADE=" . $_GET["CIDADE"];
        if (isset($_GET["UF"])) $result["UF"] = "UF=" . $_GET["UF"];
        if (isset($_GET["PAIS"])) $result["PAIS"] = "PAIS=" . $_GET["PAIS"];
        if (isset($_GET["DATAPOST"])) $result["DATAPOST"] = "DATAPOST=" . $_GET["DATAPOST"];
        if (isset($_GET["CODPOSTREFERENCIA"])) $result["CODPOSTREFERENCIA"] = "CODPOSTREFERENCIA=" . $_GET["CODPOSTREFERENCIA"];
        if (isset($_GET["CODIGOGRUPO"])) $result["CODIGOGRUPO"] = "CODIGOGRUPO=" . $_GET["CODIGOGRUPO"];
        if (isset($_GET["CLASSIFICACAO"])) $result["CLASSIFICACAO"] = "CLASSIFICACAO=" . $_GET["CLASSIFICACAO"];

        
        
        if (isset($_GET["orderby"])) $result["orderby"] = "orderby=" . $_GET["orderby"];
        if (isset($_GET["offset"])) $result["offset"] = "offset=" . $_GET["offset"];
        $result[$campo] = $campo . "=" . $valor;
        return ("exercicio10.php?" . strtr(implode("&", $result), " ", "+"));
    }

    $db = new SQLite3("face.db");
    $db->exec("PRAGMA foreign_keys = ON");

    echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
    echo '<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">';
    echo '<link rel="icon" href="icon.png">';
    echo '<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">';
    echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">';
    echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">';

    $limit = 5;

    echo " <div class=\"w3-bar w3-theme-d2 w3-left-align w3-large\">";
    echo "<p> Quantos usuários receberam mais de <input type=\"number\" id=\"numCurtidas\" name=\"numCurtidas\" value=\"1\" min=\"1\" max=\"1000\"> 
    curtidas em uma postagem, em menos de 
    <input type=\"number\" id=\"horas\" name=\"horas\" value=\"1\" min=\"1\" max=\"1000\"> hora(s)</p>
    <p> após a postagem, no país
    <select id=\"campo\" name=\"campo\">
            <option value=\"Brasil\" selected>Brasil</option>
            </select>
            nos últimos
            <input type=\"number\" id=\"numDias\" name=\"numDias\" value=\"1\" min=\"1\" max=\"100\"> dia(s)<a
            href=\"\" onclick=\"value = document.getElementById('numCurtidas').value.trim().replace(/ +/g, '+');
            onclick=\"value = document.getElementById('horas').value.trim().replace(/ +/g, '+');
            onclick=\"value = document.getElementById('campo').value.trim().replace(/ +/g, '+');
            onclick=\"value = document.getElementById('numDias').value.trim().replace(/ +/g, '+'); \"  >&#x1F50E;</a></p>";
            echo "<br>\n";
            
            echo "</div>";
    echo '<div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">    ';



    $value = "";
    // if (isset($_GET["CODIGO"])) $value = $_GET["CODIGO"];
    // if (isset($_GET["NOMEGRUPO"])) $value = $_GET["NOMEGRUPO"];
    echo "";

    $parameters = array();
    if (isset($_GET["orderby"])) $parameters[] = "orderby=" . $_GET["orderby"];
    if (isset($_GET["offset"])) $parameters[] = "offset=" . $_GET["offset"];

    echo "<table align=\"center\">\n";
    echo "<tr>\n";
    echo "<td><b>Quantidade de Usuarios</b></td>\n";

    echo "</tr>\n";

    $where = array();
    $where[] = "ATIVO = 1";
    if (isset($_GET["CODIGO"])) $where[] = "CODIGO = " . $_GET["CODIGO"];
    //if (isset($_GET["NOMEGRUPO"])) $where[] = "NOMEGRUPO like '%" . strtr($_GET["NOMEGRUPO"], " ", "%") . "%'";
    $where = (count($where) > 0) ? "where " . implode(" and ", $where) : "";

    $total = $db->query("SELECT COUNT(*) AS total FROM(
        SELECT USUARIO.NOME AS NOME, COUNT(REACAO.CODIGO) AS NUMEROREACOES FROM POST 
        JOIN REACAO ON POST.CODIGO= REACAO.COD_POST
        JOIN USUARIO ON POST.EMAIL_USUARIO=USUARIO.EMAIL
        WHERE (REACAO.DATAREACAO BETWEEN REACAO.DATAREACAO
            AND DATE(POST.DATAPOST, '+1 day','-1 minute', 'localtime'))
            AND (POST.DATAPOST BETWEEN DATE('now', '-365 days', 'localtime') AND DATE('NOW'))
            AND POST.PAIS ='Brasil'
            GROUP BY POST
            HAVING NUMEROREACOES > 0
        );" . $where)->fetchArray()["total"];

    $orderby = (isset($_GET["orderby"])) ? $_GET["orderby"] : "CODIGO asc";

    $offset = (isset($_GET["offset"])) ? max(0, min($_GET["offset"], $total - 1)) : 0;
    $offset = $offset - ($offset % $limit);

    $results = $db->query("SELECT COUNT(*) AS QuantidadeUsuario FROM(
        SELECT USUARIO.NOME AS NOME, COUNT(REACAO.CODIGO) AS NUMEROREACOES FROM POST 
        JOIN REACAO ON POST.CODIGO= REACAO.COD_POST
        JOIN USUARIO ON POST.EMAIL_USUARIO=USUARIO.EMAIL
        WHERE (REACAO.DATAREACAO BETWEEN REACAO.DATAREACAO
            AND DATE(POST.DATAPOST, '+1 day','-1 minute', 'localtime'))
            AND (POST.DATAPOST BETWEEN DATE('now', '-365 days', 'localtime')
            AND DATE('NOW'))
            AND POST.PAIS ='Brasil'
            GROUP BY POST
            HAVING NUMEROREACOES > 0
        );");
    while ($row = $results->fetchArray()) {
        echo "<tr>\n";
        echo "<td>" . $row["QuantidadeUsuario"] . "</td>\n";
        echo "</tr>\n";
    }

    echo "</table>\n";
    echo "<br>\n";
    echo '</div>    ';


    for ($page = 0; $page < ceil($total / $limit); $page++) {
        echo (($offset == $page * $limit) ? ($page + 1) : "<a href=\"" . url("offset", $page * $limit) . "\">" . ($page + 1) . "</a>") . " \n";
    }

    $db->close();
    ?>
</body>

</html>