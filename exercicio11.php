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
        return ("exercicio11.php?" . strtr(implode("&", $result), " ", "+"));
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
    echo "<p>  qual faixa etária mais interagiu às postagens do grupo
    <select id=\"campo\" name=\"campo\">
            <option value=\"Brasil\" selected>Brasil</option>
            </select>
            nos últimos
            <input type=\"number\" id=\"numDias\" name=\"numDias\" value=\"1\" min=\"1\" max=\"100\"> dia(s)<a
            href=\"\" onclick=\"value = document.getElementById('campo').value.trim().replace(/ +/g, '+');
            onclick=\"value = document.getElementById('numDias').value.trim().replace(/ +/g, '+'); \" >&#x1F50E;</a></p>";
    echo "</div>";
    echo '<div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">';



    $value = "";
    if (isset($_GET["CODIGO"])) $value = $_GET["CODIGO"];
    if (isset($_GET["NOMEGRUPO"])) $value = $_GET["NOMEGRUPO"];
    echo "";

    $parameters = array();
    if (isset($_GET["orderby"])) $parameters[] = "orderby=" . $_GET["orderby"];
    if (isset($_GET["offset"])) $parameters[] = "offset=" . $_GET["offset"];

    echo "<table align=\"center\">\n";
    echo "<tr>\n";
    echo "<td><b>Faixaetaria</b></td>\n";
    echo "<td><b>Interações</b></td>\n";
    echo "</tr>\n";

    $where = array();
    $where[] = "ATIVO = 1";
    if (isset($_GET["CODIGO"])) $where[] = "CODIGO = " . $_GET["CODIGO"];
    if (isset($_GET["NOMEGRUPO"])) $where[] = "NOMEGRUPO like '%" . strtr($_GET["NOMEGRUPO"], " ", "%") . "%'";
    $where = (count($where) > 0) ? "where " . implode(" and ", $where) : "";

    $total = $db->query("select count(*) as total from grupo " . $where)->fetchArray()["total"];

    $orderby = (isset($_GET["orderby"])) ? $_GET["orderby"] : "CODIGO asc";

    $offset = (isset($_GET["offset"])) ? max(0, min($_GET["offset"], $total - 1)) : 0;
    $offset = $offset - ($offset % $limit);

    $results = $db->query("SELECT 
    case when CAST((JULIANDAY('NOW', 'LOCALTIME') - JULIANDAY(USUARIO.NASCIMENTO, 'LOCALTIME'))/365.2422 AS INTEGER)  < 18 then  
    '-18'  
    when CAST((JULIANDAY('NOW', 'LOCALTIME') - JULIANDAY(USUARIO.NASCIMENTO, 'LOCALTIME'))/365.2422 AS INTEGER)   between 18 and 21 then  
    '18-21'  
    when  CAST((JULIANDAY('NOW', 'LOCALTIME') - JULIANDAY(USUARIO.NASCIMENTO, 'LOCALTIME'))/365.2422 AS INTEGER)   between 21 and 25 then  
    '21-25'
    when  CAST((JULIANDAY('NOW', 'LOCALTIME') - JULIANDAY(USUARIO.NASCIMENTO, 'LOCALTIME'))/365.2422 AS INTEGER)   between 25 and 30 then  
    '25-30'
    when  CAST((JULIANDAY('NOW', 'LOCALTIME') - JULIANDAY(USUARIO.NASCIMENTO, 'LOCALTIME'))/365.2422 AS INTEGER)   between 30 and 36 then  
    '30-36'
    when  CAST((JULIANDAY('NOW', 'LOCALTIME') - JULIANDAY(USUARIO.NASCIMENTO, 'LOCALTIME'))/365.2422 AS INTEGER)   between 36 and 43 then  
    '36-43'
    when  CAST((JULIANDAY('NOW', 'LOCALTIME') - JULIANDAY(USUARIO.NASCIMENTO, 'LOCALTIME'))/365.2422 AS INTEGER)   between 43 and 51 then  
    '43-51'
    when  CAST((JULIANDAY('NOW', 'LOCALTIME') - JULIANDAY(USUARIO.NASCIMENTO, 'LOCALTIME'))/365.2422 AS INTEGER)   between 51 and 60 then  
    '51-60'
    else '60+'
    end as FAIXAETARIA,
    COUNT(ASSUNTO) AS INTERACOES FROM POST 
    JOIN USUARIO ON REACAO.EMAIL_USUARIO=USUARIO.EMAIL
            JOIN ASSUNTOPOST ON POST.CODIGO= ASSUNTOPOST.CODIGOPOST
            JOIN ASSUNTO ON ASSUNTO.CODIGO= ASSUNTOPOST.CODIGOASSUNTO
            JOIN(
            SELECT COUNT(*) AS REACAO FROM REACAO
            GROUP BY COD_POST
            )
            JOIN(
            SELECT COUNT(*) AS COMPARTILHAMENTO FROM COMPARTILHAMENTO
            GROUP BY COD_POST)
            GROUP BY FAIXAETARIA
            ORDER BY INTERACOES DESC
            LIMIT 1;");
    while ($row = $results->fetchArray()) {
        echo "<tr>\n";
        echo "<td>" . $row["FAIXAETARIA"] . "</td>\n";
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