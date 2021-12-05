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
    $usuario = $db->query("SELECT USUARIO.NOME AS NOME FROM USUARIO");
    $assuntosmais = $db->query("SELECT ASSUNTO.ASSUNTO AS ASSUNTO, COUNT(ASSUNTO) AS QUANTIDADE FROM ASSUNTO 
    JOIN ASSUNTOPOST ON ASSUNTOPOST.CODIGOASSUNTO = ASSUNTO.CODIGO 
    JOIN POST ON ASSUNTOPOST.CODIGOPOST = POST.CODIGO 
    GROUP BY ASSUNTO.ASSUNTO 
    ORDER BY 2 DESC");


    echo " <div class=\"w3-bar w3-theme-d2 w3-left-align w3-large\">";
    echo "<p>Sugerir amigos para
    <select id=\"usuario\" name=\"usuario\">";
    while ($listausuario = $usuario->fetchArray()) {
        echo "<option value=\"" . $listausuario["EMAIL"] . "\"".">" . $listausuario["NOME"] . "</option>";
    }        
    echo "</select> ,considerando que, se o usuario selecionado e outro usuario não são amigos mas possuem no mínimo
    <input type=\"number\" id=\"numassuntos\" name=\"numassuntos\" value=\"1\" min=\"1\"> 
      assuntos em comum entre os
      <input type=\"number\" id=\"top\" name=\"top\" value=\"1\" min=\"1\" max=\"1000\"> 
        assuntos mais comentados por cada um nos últimos
        <input type=\"number\" id=\"nummeses\" name=\"nummeses\" value=\"1\" min=\"1\" max=\"1000\"> 
         meses, este sera sugerido como amigo para o usuario selecionado.<a
            href=\"\" onclick=\"value = document.getElementById('usuario').value.trim().replace(/ +/g, '+');
            onclick=\"value = document.getElementById('numassuntos').value.trim().replace(/ +/g, '+');
            onclick=\"value = document.getElementById('top').value.trim().replace(/ +/g, '+');
            onclick=\"value = document.getElementById('nummeses').value.trim().replace(/ +/g, '+');
            onclick=\"value = document.getElementById('horas').value.trim().replace(/ +/g, '+'); 
            \"  >&#x1F50E;</a></p>";
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
    echo "<td><b>Usuario Sugerido</b></td>\n";

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

    $results = $db->query("SELECT u1.NOME AS USUARIOA, GROUP_CONCAT(u2.NOME) AS USUARIOB
    FROM USUARIO u1,USUARIO u2
    JOIN (SELECT POST.EMAIL_USUARIO, ASSUNTO.CODIGO FROM ASSUNTO
        JOIN ASSUNTOPOST ON ASSUNTOPOST.CODIGOASSUNTO = ASSUNTO.CODIGO
        JOIN POST ON ASSUNTOPOST.CODIGOPOST = POST.CODIGO
    WHERE DATE(POST.DATAPOST, 'localtime') BETWEEN DATE ('now', '-12 months', 'localtime') 
    AND DATE ('now', 'localtime')    
    GROUP BY POST.EMAIL_USUARIO,ASSUNTO.CODIGO
    ORDER BY COUNT(ASSUNTO) DESC
    LIMIT 10) ASSUNTOSPOSTUSUARIO1 ON ASSUNTOSPOSTUSUARIO1.EMAIL_USUARIO=U1.EMAIL
    JOIN (SELECT POST.EMAIL_USUARIO, ASSUNTO.CODIGO,  ASSUNTO.ASSUNTO FROM ASSUNTO
        JOIN ASSUNTOPOST ON ASSUNTOPOST.CODIGOASSUNTO = ASSUNTO.CODIGO
        JOIN POST ON ASSUNTOPOST.CODIGOPOST = POST.CODIGO
    WHERE DATE(POST.DATAPOST, 'localtime') BETWEEN DATE ('now', '-12 months', 'localtime') 
    AND DATE ('now', 'localtime')    
    GROUP BY POST.EMAIL_USUARIO,ASSUNTO.CODIGO
    ORDER BY COUNT(ASSUNTO) DESC
    LIMIT 10) ASSUNTOSPOSTUSUARIO2 ON ASSUNTOSPOSTUSUARIO2.EMAIL_USUARIO=U2.EMAIL
    AND ASSUNTOSPOSTUSUARIO1.CODIGO =ASSUNTOSPOSTUSUARIO2.CODIGO
    WHERE NOT EXISTS(SELECT 1
                     FROM AMIZADE 
                     WHERE (AMIZADE.EMAIL_USUARIO1 = u1.EMAIL AND
                            AMIZADE.EMAIL_USUARIO2 = u2.EMAIL)
                         OR(AMIZADE.EMAIL_USUARIO1 = u2.EMAIL AND
                            AMIZADE.EMAIL_USUARIO2 = u1.EMAIL))
    AND u1.EMAIL != u2.EMAIL
    GROUP BY u1.EMAIL
    HAVING COUNT(*) >= 1;");
    while ($row = $results->fetchArray()) {
        echo "<tr>\n";
        echo "<td>" . $row["USUARIOB"] . "</td>\n";
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