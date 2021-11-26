<html>

<head>
	<title>Pagina ADM</title>

</head>
<body>
	<?php
/*
.headers on
.mode column
PRAGMA foreign_keys = ON;
*/
	if (isset($_POST["Inclui"])) {
		$error = "";
		if ($error == "") {
			$db = new SQLite3("face.db");
			$db->exec("PRAGMA foreign_keys = ON");
        //echo $_POST['data'];
        //echo $_POST['numero'];
			//$db->exec("insert into usuario (email, nome, datacadastro, cidade, pais, uf, genero, nascimento) values ('" . $_POST["email"] . "', '" . $_POST["nome"] . "' , DATE('now', 'localtime') , '" . $_POST["cidade"] . "', '" . $_POST["pais"] . "', '" . $_POST["estado"] . "', '" . $_POST["genero"] . "', '" . $_POST["nascimento"] ."')");
         $db->close();
		} else {
			echo "<font color=\"red\">" . $error . "</font>";
		}
	} else {
		$db = new SQLite3("face.db");
		
		echo '<form name="insert" method="post">';
		echo '<table>';
        echo '<caption><h4>Desativar conta de usuario do pais P não possuem qualquer interação há mais de A anos</h4></caption>';
        //echo '<caption>Desativar temporariamente as contas dos usuários do país P que não possuem qualquer interação há mais de A anos</caption>';
		echo '<tbody>';

        $pais = $db->query("SELECT * FROM PAISES");
		echo '<tr>';
        echo '<td><label for="pais">Pais</label></td>';
        echo '<td><select name="pais" id="pais">';
		echo '<option value="" disabled selected>Escolha um Pais</option>';
        while ($listapais = $pais->fetchArray()) {
            echo "<option value=\"" . $listapais["CODIGO"] . "\">" . $listapais["NOME"] . "</option>";
        }
        echo '</select></td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td><label for="numero">Ano</label></td>';
		echo '<td><input type="text" name="numero" id="numero" required></td>';
        echo '</tr>';

        echo '<tr>';
		echo '<td><input type="submit" name="Desativar" value="Desativar"></td>';
		echo '</tr>';

		echo '</tbody>';
		echo '</table>';
		echo '</form>';


        echo '<form name="mostrar" method="post">';
		echo '<table>';
        echo '<caption><h4>Mostrar qual faixa etária mais interagiu às postagens do grupo G nos últimos D dias</h></caption>';
        //echo '<caption>Mostrar qual faixa etária mais interagiu às postagens do grupo G nos últimos D dias</caption>';
		echo '<tbody>';

        $grupo = $db->query("SELECT * FROM GRUPO");
		echo '<tr>';
        echo '<td><label for="grupo">Grupo</label></td>';
        echo '<td><select name="grupo" id="grupo">';
        while ($listagrupo = $grupo->fetchArray()) {
            echo "<option value=\"" . $listagrupo["CODIGO"] . "\">" . $listagrupo["NOMEGRUPO"] . "</option>";
        }
        echo '</select></td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td><label for="numero">Dias</label></td>';
		echo '<td><input type="text" name="numero" id="numero" required></td>';
        echo '</tr>';

        echo '<tr>';
		echo '<td><input type="submit" name="Mostrar" value="Mostrar"></td>';
		echo '</tr>';

		echo '</tbody>';
		echo '</table>';
		echo '</form>';

	}

	?>
</body>
<?php


if (isset($_POST["Inclui"])) {
	echo "<script>setTimeout(function () { window.open(\"selectusuario.php\",\"_self\"); }, 3000);</script>";
}


?>

</html>




primeiro = echo "UPDATE USUARIO SET ATIVO = true FROM (SELECT CASE WHEN MAX(DATAPOST) IS NULL THEN DATETIME('1900-01-01') ELSE MAX(DATAPOST) END AS DATAMAXIMA, EMAIL FROM USUARIO LEFT JOIN POST ON POST.EMAIL_USUARIO = USUARIO.EMAIL GROUP BY EMAIL) AS POST WHERE (USUARIO.EMAIL = POST.EMAIL AND POST.DATAMAXIMA < DATE('now', '-5 years')) AND USUARIO.PAIS='Brasil';";

segundo = echo "SELECT 
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
COUNT(REACAO.CODIGO) AS QUANTIDADE FROM POST
JOIN REACAO ON POST.CODIGO= REACAO.COD_POST
JOIN USUARIO ON REACAO.EMAIL_USUARIO=USUARIO.EMAIL
WHERE CODIGOGRUPO = $_POST['grupo']
AND REACAO.DATAREACAO BETWEEN date ('now', '-."$_POST['grupo']"."days"', 'localtime' ) 
AND DATE ('now', 'localtime')
GROUP BY FAIXAETARIA
ORDER BY QUANTIDADE DESC
LIMIT 1;"