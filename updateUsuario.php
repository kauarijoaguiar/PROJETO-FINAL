<html>

<head>
	<title>Alterar Sabor</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<?php
	/*
.headers on
.mode column
PRAGMA foreign_keys = ON;
*/

	if (isset($_GET["email"])) {
		$db = new SQLite3("face.db");
		$db->exec("PRAGMA foreign_keys = ON");
		$sabor = $db->query("select * from usuario where email = " . $_GET["email"]);
		$s = $sabor->fetchArray();
		$db->close();
		if ($s === false) {
			echo "<font color=\"red\">Sabor não encontrado</font>";
		} else {
			$db = new SQLite3("face.db");
			echo '<form name="insert" method="post">';
			echo '<table>';
			echo '<caption><h1>Alterar Usuario</h1></caption>';
			echo '<tbody>';

            echo '<tr>';
            echo '<td><label for="email">Email</label></td>';
            echo '<td><input type="email" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required></td>';
            echo '</tr>';
    
            echo '<tr>';
            echo '<td><label for="nome">Nome</label></td>';
            echo '<td><input type="text" name="nome" id="nome" pattern="^([a-zA-Z]{2,}\s[a-zA-Z]{1,}"?-?[a-zA-Z]{2,}\s?([a-zA-Z]{1,})?)" required></td>';
            echo '</tr>';
    
            echo '<tr>';
            echo '<td><label for="Data">Data</label></td>';
            echo '<td>' . ucfirst(strftime('%a %d/%m/%y', strtotime('today'))) . '</td>';
            echo '</tr>';
    
            echo '<tr>';
            echo '<td><label for="paises">Paises</label></td>';
            echo  '<td> <select name="paises" id="paises">';
            echo '<option value="Brasil" selected="selected">Brasil</option>';
            echo '<option value="Afeganistão">Afeganistão</option>';
            echo '<option value="África do Sul">África do Sul</option>';
            echo '<option value="Albânia">Albânia</option>';
            echo '<option value="Alemanha">Alemanha</option>';
            echo '<option value="Andorra">Andorra</option>';
            echo '<option value="Angola">Angola</option>';
            echo '<option value="Anguilla">Anguilla</option>';
            echo '<option value="Antilhas Holandesas">Antilhas Holandesas</option>';
            echo '<option value="Antárctida">Antárctida</option>';
            echo '<option value="Antígua e Barbuda">Antígua e Barbuda</option>';
            echo '<option value="Argentina">Argentina</option>';
            echo '<option value="Argélia">Argélia</option>';
            echo '<option value="Armênia">Armênia</option>';
            echo '<option value="Aruba">Aruba</option>';
            echo '<option value="Arábia Saudita">Arábia Saudita</option>';
            echo '<option value="Austrália">Austrália</option>';
            echo '<option value="Áustria">Áustria</option>';
            echo '<option value="Azerbaijão">Azerbaijão</option>';
            echo '<option value="Bahamas">Bahamas</option>';
            echo '<option value="Bahrein">Bahrein</option>';
            echo '<option value="Bangladesh">Bangladesh</option>';
            echo '<option value="Barbados">Barbados</option>';
            echo '<option value="Belize">Belize</option>';
            echo '<option value="Benim">Benim</option>';
            echo '<option value="Bermudas">Bermudas</option>';
            echo '<option value="Bielorrússia">Bielorrússia</option>';
            echo '<option value="Bolívia">Bolívia</option>';
            echo '<option value="Botswana">Botswana</option>';
            echo '<option value="Brunei">Brunei</option>';
            echo '<option value="Bulgária">Bulgária</option>';
            echo '<option value="Burkina Faso">Burkina Faso</option>';
            echo '<option value="Burundi">Burundi</option>';
            echo '<option value="Butão">Butão</option>';
            echo '<option value="Bélgica">Bélgica</option>';
            echo '<option value="Bósnia e Herzegovina">Bósnia e Herzegovina</option>';
            echo '<option value="Cabo Verde">Cabo Verde</option>';
            echo '<option value="Camarões">Camarões</option>';
            echo '<option value="Camboja">Camboja</option>';
            echo '<option value="Canadá">Canadá</option>';
            echo '<option value="Catar">Catar</option>';
            echo '<option value="Cazaquistão">Cazaquistão</option>';
            echo '<option value="Chade">Chade</option>';
            echo '<option value="Chile">Chile</option>';
            echo '<option value="China">China</option>';
            echo '<option value="Chipre">Chipre</option>';
            echo '<option value="Colômbia">Colômbia</option>';
            echo '<option value="Comores">Comores</option>';
            echo '<option value="Coreia do Norte">Coreia do Norte</option>';
            echo '<option value="Coreia do Sul">Coreia do Sul</option>';
            echo '<option value="Costa do Marfim">Costa do Marfim</option>';
            echo '<option value="Costa Rica">Costa Rica</option>';
            echo '<option value="Croácia">Croácia</option>';
            echo '<option value="Cuba">Cuba</option>';
            echo '<option value="Dinamarca">Dinamarca</option>';
            echo '<option value="Djibouti">Djibouti</option>';
            echo '<option value="Dominica">Dominica</option>';
            echo '<option value="Egito">Egito</option>';
            echo '<option value="El Salvador">El Salvador</option>';
            echo '<option value="Emirados Árabes Unidos">Emirados Árabes Unidos</option>';
            echo '<option value="Equador">Equador</option>';
            echo '<option value="Eritreia">Eritreia</option>';
            echo '<option value="Escócia">Escócia</option>';
            echo '<option value="Eslováquia">Eslováquia</option>';
            echo '<option value="Eslovênia">Eslovênia</option>';
            echo '<option value="Espanha">Espanha</option>';
            echo '<option value="Estados Federados da Micronésia">Estados Federados da Micronésia</option>';
            echo '<option value="Estados Unidos">Estados Unidos</option>';
            echo '<option value="Estônia">Estônia</option>';
            echo '<option value="Etiópia">Etiópia</option>';
            echo '<option value="Fiji">Fiji</option>';
            echo '<option value="Filipinas">Filipinas</option>';
            echo '<option value="Finlândia">Finlândia</option>';
            echo '<option value="França">França</option>';
            echo '<option value="Gabão">Gabão</option>';
            echo '<option value="Gana">Gana</option>';
            echo '<option value="Geórgia">Geórgia</option>';
            echo '<option value="Gibraltar">Gibraltar</option>';
            echo '<option value="Granada">Granada</option>';
            echo '<option value="Gronelândia">Gronelândia</option>';
            echo '<option value="Grécia">Grécia</option>';
            echo '<option value="Guadalupe">Guadalupe</option>';
            echo '<option value="Guam">Guam</option>';
            echo '<option value="Guatemala">Guatemala</option>';
            echo '<option value="Guernesei">Guernesei</option>';
            echo '<option value="Guiana">Guiana</option>';
            echo '<option value="Guiana Francesa">Guiana Francesa</option>';
            echo '<option value="Guiné">Guiné</option>';
            echo '<option value="Guiné Equatorial">Guiné Equatorial</option>';
            echo '<option value="Guiné-Bissau">Guiné-Bissau</option>';
            echo '<option value="Gâmbia">Gâmbia</option>';
            echo '<option value="Haiti">Haiti</option>';
            echo '<option value="Honduras">Honduras</option>';
            echo '<option value="Hong Kong">Hong Kong</option>';
            echo '<option value="Hungria">Hungria</option>';
            echo '<option value="Ilha Bouvet">Ilha Bouvet</option>';
            echo '<option value="Ilha de Man">Ilha de Man</option>';
            echo '<option value="Ilha do Natal">Ilha do Natal</option>';
            echo '<option value="Ilha Heard e Ilhas McDonald">Ilha Heard e Ilhas McDonald</option>';
            echo '<option value="Ilha Norfolk">Ilha Norfolk</option>';
            echo '<option value="Ilhas Cayman">Ilhas Cayman</option>';
            echo '<option value="Ilhas Cocos (Keeling)">Ilhas Cocos (Keeling)</option>';
            echo '<option value="Ilhas Cook">Ilhas Cook</option>';
            echo '<option value="Ilhas Feroé">Ilhas Feroé</option>';
            echo '<option value="Ilhas Geórgia do Sul e Sandwich do Sul">Ilhas Geórgia do Sul e Sandwich do Sul</option>';
            echo '<option value="Ilhas Malvinas">Ilhas Malvinas</option>';
            echo '<option value="Ilhas Marshall">Ilhas Marshall</option>';
            echo '<option value="Ilhas Menores Distantes dos Estados Unidos">Ilhas Menores Distantes dos Estados Unidos</option>';
            echo '<option value="Ilhas Salomão">Ilhas Salomão</option>';
            echo '<option value="Ilhas Virgens Americanas">Ilhas Virgens Americanas</option>';
            echo '<option value="Ilhas Virgens Britânicas">Ilhas Virgens Britânicas</option>';
            echo '<option value="Ilhas Åland">Ilhas Åland</option>';
            echo '<option value="Indonésia">Indonésia</option>';
            echo '<option value="Inglaterra">Inglaterra</option>';
            echo '<option value="Índia">Índia</option>';
            echo '<option value="Iraque">Iraque</option>';
            echo '<option value="Irlanda do Norte">Irlanda do Norte</option>';
            echo '<option value="Irlanda">Irlanda</option>';
            echo '<option value="Irã">Irã</option>';
            echo '<option value="Islândia">Islândia</option>';
            echo '<option value="Israel">Israel</option>';
            echo '<option value="Itália">Itália</option>';
            echo '<option value="Iêmen">Iêmen</option>';
            echo '<option value="Jamaica">Jamaica</option>';
            echo '<option value="Japão">Japão</option>';
            echo '<option value="Jersey">Jersey</option>';
            echo '<option value="Jordânia">Jordânia</option>';
            echo '<option value="Kiribati">Kiribati</option>';
            echo '<option value="Kuwait">Kuwait</option>';
            echo '<option value="Laos">Laos</option>';
            echo '<option value="Lesoto">Lesoto</option>';
            echo '<option value="Letônia">Letônia</option>';
            echo '<option value="Libéria">Libéria</option>';
            echo '<option value="Liechtenstein">Liechtenstein</option>';
            echo '<option value="Lituânia">Lituânia</option>';
            echo '<option value="Luxemburgo">Luxemburgo</option>';
            echo '<option value="Líbano">Líbano</option>';
            echo '<option value="Líbia">Líbia</option>';
            echo '<option value="Macau">Macau</option>';
            echo '<option value="Macedônia">Macedônia</option>';
            echo '<option value="Madagáscar">Madagáscar</option>';
            echo '<option value="Malawi">Malawi</option>';
            echo '<option value="Maldivas">Maldivas</option>';
            echo '<option value="Mali">Mali</option>';
            echo '<option value="Malta">Malta</option>';
            echo '<option value="Malásia">Malásia</option>';
            echo '<option value="Marianas Setentrionais">Marianas Setentrionais</option>';
            echo '<option value="Marrocos">Marrocos</option>';
            echo '<option value="Martinica">Martinica</option>';
            echo '<option value="Mauritânia">Mauritânia</option>';
            echo '<option value="Maurícia">Maurícia</option>';
            echo '<option value="Mayotte">Mayotte</option>';
            echo '<option value="Moldávia">Moldávia</option>';
            echo '<option value="Mongólia">Mongólia</option>';
            echo '<option value="Montenegro">Montenegro</option>';
            echo '<option value="Montserrat">Montserrat</option>';
            echo '<option value="Moçambique">Moçambique</option>';
            echo '<option value="Myanmar">Myanmar</option>';
            echo '<option value="México">México</option>';
            echo '<option value="Mônaco">Mônaco</option>';
            echo '<option value="Namíbia">Namíbia</option>';
            echo '<option value="Nauru">Nauru</option>';
            echo '<option value="Nepal">Nepal</option>';
            echo '<option value="Nicarágua">Nicarágua</option>';
            echo '<option value="Nigéria">Nigéria</option>';
            echo '<option value="Niue">Niue</option>';
            echo '<option value="Noruega">Noruega</option>';
            echo '<option value="Nova Caledônia">Nova Caledônia</option>';
            echo '<option value="Nova Zelândia">Nova Zelândia</option>';
            echo '<option value="Níger">Níger</option>';
            echo '<option value="Omã">Omã</option>';
            echo '<option value="Palau">Palau</option>';
            echo '<option value="Palestina">Palestina</option>';
            echo '<option value="Panamá">Panamá</option>';
            echo '<option value="Papua-Nova Guiné">Papua-Nova Guiné</option>';
            echo '<option value="Paquistão">Paquistão</option>';
            echo '<option value="Paraguai">Paraguai</option>';
            echo '<option value="País de Gales">País de Gales</option>';
            echo '<option value="Países Baixos">Países Baixos</option>';
            echo '<option value="Peru">Peru</option>';
            echo '<option value="Pitcairn">Pitcairn</option>';
            echo '<option value="Polinésia Francesa">Polinésia Francesa</option>';
            echo '<option value="Polônia">Polônia</option>';
            echo '<option value="Porto Rico">Porto Rico</option>';
            echo '<option value="Portugal">Portugal</option>';
            echo '<option value="Quirguistão">Quirguistão</option>';
            echo '<option value="Quênia">Quênia</option>';
            echo '<option value="Reino Unido">Reino Unido</option>';
            echo '<option value="República Centro-Africana">República Centro-Africana</option>';
            echo '<option value="República Checa">República Checa</option>';
            echo '<option value="República Democrática do Congo">República Democrática do Congo</option>';
            echo '<option value="República do Congo">República do Congo</option>';
            echo '<option value="República Dominicana">República Dominicana</option>';
            echo '<option value="Reunião">Reunião</option>';
            echo '<option value="Romênia">Romênia</option>';
            echo '<option value="Ruanda">Ruanda</option>';
            echo '<option value="Rússia">Rússia</option>';
            echo '<option value="Saara Ocidental">Saara Ocidental</option>';
            echo '<option value="Saint Martin">Saint Martin</option>';
            echo '<option value="Saint-Barthélemy">Saint-Barthélemy</option>';
            echo '<option value="Saint-Pierre e Miquelon">Saint-Pierre e Miquelon</option>';
            echo '<option value="Samoa Americana">Samoa Americana</option>';
            echo '<option value="Samoa">Samoa</option>';
            echo '<option value="Santa Helena, Ascensão e Tristão da Cunha">Santa Helena, Ascensão e Tristão da Cunha</option>';
            echo '<option value="Santa Lúcia">Santa Lúcia</option>';
            echo '<option value="Senegal">Senegal</option>';
            echo '<option value="Serra Leoa">Serra Leoa</option>';
            echo '<option value="Seychelles">Seychelles</option>';
            echo '<option value="Singapura">Singapura</option>';
            echo '<option value="Somália">Somália</option>';
            echo '<option value="Sri Lanka">Sri Lanka</option>';
            echo '<option value="Suazilândia">Suazilândia</option>';
            echo '<option value="Sudão">Sudão</option>';
            echo '<option value="Suriname">Suriname</option>';
            echo '<option value="Suécia">Suécia</option>';
            echo '<option value="Suíça">Suíça</option>';
            echo '<option value="Svalbard e Jan Mayen">Svalbard e Jan Mayen</option>';
            echo '<option value="São Cristóvão e Nevis">São Cristóvão e Nevis</option>';
            echo '<option value="São Marino">São Marino</option>';
            echo '<option value="São Tomé e Príncipe">São Tomé e Príncipe</option>';
            echo '<option value="São Vicente e Granadinas">São Vicente e Granadinas</option>';
            echo '<option value="Sérvia">Sérvia</option>';
            echo '<option value="Síria">Síria</option>';
            echo '<option value="Tadjiquistão">Tadjiquistão</option>';
            echo '<option value="Tailândia">Tailândia</option>';
            echo '<option value="Taiwan">Taiwan</option>';
            echo '<option value="Tanzânia">Tanzânia</option>';
            echo '<option value="Terras Austrais e Antárticas Francesas">Terras Austrais e Antárticas Francesas</option>';
            echo '<option value="Território Britânico do Oceano Índico">Território Britânico do Oceano Índico</option>';
            echo '<option value="Timor-Leste">Timor-Leste</option>';
            echo '<option value="Togo">Togo</option>';
            echo '<option value="Tonga">Tonga</option>';
            echo '<option value="Toquelau">Toquelau</option>';
            echo '<option value="Trinidad e Tobago">Trinidad e Tobago</option>';
            echo '<option value="Tunísia">Tunísia</option>';
            echo '<option value="Turcas e Caicos">Turcas e Caicos</option>';
            echo '<option value="Turquemenistão">Turquemenistão</option>';
            echo '<option value="Turquia">Turquia</option>';
            echo '<option value="Tuvalu">Tuvalu</option>';
            echo '<option value="Ucrânia">Ucrânia</option>';
            echo '<option value="Uganda">Uganda</option>';
            echo '<option value="Uruguai">Uruguai</option>';
            echo '<option value="Uzbequistão">Uzbequistão</option>';
            echo '<option value="Vanuatu">Vanuatu</option>';
            echo '<option value="Vaticano">Vaticano</option>';
            echo '<option value="Venezuela">Venezuela</option>';
            echo '<option value="Vietname">Vietname</option>';
            echo '<option value="Wallis e Futuna">Wallis e Futuna</option>';
            echo '<option value="Zimbabwe">Zimbabwe</option>';
            echo '<option value="Zâmbia">Zâmbia</option>';
            echo '</select></td>';
            echo '</tr>';
    
            echo '<tr>';
            echo '<td><label for="genero">Genero</label></td>';
            echo '<td><input type="radio" id="m" name="m" value="m">M</td>';
            echo '<td><input type="radio" id="f" name="f" value="f">F</td>';
            echo '<td><input type="radio" id="n" name="n" value="n">N</td>';
            echo '</tr>';
    
            echo '<tr>';
            echo '<td><label for="nascimento">nascimento</label></td>';
            echo '<td><input type="date" name="nascimento" id="nascimento" required></td>';
            echo '</tr>';
            
            echo '<tr>';
            echo '<td><input type="submit" name="Alterar" value="Alterar"></td>';
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
				//$db->exec("update sabor set nome = '" . $_POST["nome"] . "', tipo=" . $_POST["tipo"] . " where codigo = " . $_POST["codigo"]);
				$db->close();
			} else {
				echo "<font color=\"red\">" . $error . "</font>";
			}
		}
	}

	?>
</body>

</html>