DROP TABLE PAISES

DROP TABLE USUARIO;

DROP TABLE AMIZADE;

DROP TABLE ASSUNTO;

DROP TABLE ASSUNTOPOST;

DROP TABLE CITACAO;

DROP TABLE REACAO;

DROP TABLE COMPARTILHAMENTO;

DROP TABLE POST;

DROP TABLE GRUPO;

DROP TABLE GRUPOUSUARIO;

CREATE TABLE PAISES (
	CODIGO INTEGER NOT NULL,
	NOME CHAR(100) NOT NULL,
);

CREATE TABLE USUARIO(
    EMAIL CHAR (100) NOT NULL,
    NOME CHAR(100) NOT NULL,
    DATACADASTRO DATETIME,
    CIDADE CHAR(100),
    PAIS CHAR(100),
    UF CHAR(100),
    GENERO CHAR (1),
    NASCIMENTO date,
    ATIVO BOOLEAN,
    PRIMARY KEY (EMAIL)
);

CREATE TABLE GRUPO(
    CODIGO INTEGER NOT NULL,
    NOMEGRUPO CHAR(100) NOT NULL, 
    PRIMARY KEY(CODIGO)
);

CREATE TABLE GRUPOUSUARIO(
    CODIGOGRUPO INTEGER NOT NULL,
    EMAIL_USUARIO CHAR (100) NOT NULL,
    PRIMARY KEY (CODIGOGRUPO, EMAIL_USUARIO)
);
CREATE TABLE AMIZADE(
    EMAIL_USUARIO1 CHAR (100) NOT NULL,
    EMAIL_USUARIO2 CHAR (100) NOT NULL,
    DATAAMIZADE DATETIME,
    FOREIGN KEY (EMAIL_USUARIO1) REFERENCES USUARIO(EMAIL),
    FOREIGN KEY (EMAIL_USUARIO2) REFERENCES USUARIO(EMAIL),
    PRIMARY KEY (EMAIL_USUARIO1, EMAIL_USUARIO2)
);

CREATE TABLE ASSUNTO(
    CODIGO INTEGER NOT NULL,
    ASSUNTO CHAR(4096),
    PRIMARY KEY (CODIGO)
);

CREATE TABLE ASSUNTOPOST(
    CODIGOASSUNTO INTEGER NOT NULL,
    CODIGOPOST INTEGER NOT NULL,
    FOREIGN KEY (CODIGOASSUNTO) REFERENCES ASSUNTO(CODIGO),
    FOREIGN KEY (CODIGOPOST) REFERENCES POST(CODIGO),
    PRIMARY KEY (CODIGOASSUNTO, CODIGOPOST)
);

CREATE TABLE CITACAO(
    CODIGO INTEGER NOT NULL,
    COD_POST INTEGER NOT NULL,
    EMAIL_USUARIO CHAR (100) NOT NULL,
    FOREIGN KEY (EMAIL_USUARIO) REFERENCES USUARIO(EMAIL),
    FOREIGN KEY (COD_POST) REFERENCES POST(CODIGO),
    PRIMARY KEY (CODIGO, COD_POST, EMAIL_USUARIO)
);

CREATE TABLE REACAO(
    CODIGO INTEGER NOT NULL,
    EMAIL_USUARIO CHAR (100) NOT NULL,
    TIPOREACAO CHAR(10) NOT NULL,
    COD_POST INTEGER NOT NULL,
    CIDADE CHAR(100) NOT NULL,
    UF CHAR(2) NOT NULL,
    PAIS CHAR(100) NOT NULL,
    DATAREACAO DATETIME,
    FOREIGN KEY (EMAIL_USUARIO) REFERENCES USUARIO(EMAIL),
    FOREIGN KEY (COD_POST) REFERENCES POST(CODIGO),
    PRIMARY KEY (CODIGO)
);

CREATE TABLE COMPARTILHAMENTO(
    CODIGO INTEGER NOT NULL,
    EMAIL_USUARIO CHAR (100) NOT NULL,
    COD_POST INTEGER NOT NULL,
    CIDADE CHAR(100) NOT NULL,
    UF CHAR(2) NOT NULL,
    DATACOMPARTILHAMENTO DATETIME,
    FOREIGN KEY (EMAIL_USUARIO) REFERENCES USUARIO(EMAIL),
    FOREIGN KEY (COD_POST) REFERENCES POST(CODIGO),
    PRIMARY KEY (CODIGO)
);

CREATE TABLE POST(
    CODIGO INTEGER NOT NULL,
    EMAIL_USUARIO CHAR (100) NOT NULL,
    POST CHAR(1000) NOT NULL,
    CIDADE CHAR (100) NOT NULL,
    UF CHAR (100) NOT NULL,
    PAIS CHAR (100) NOT NULL,
    DATAPOST DATETIME,
    CODPOSTREFERENCIA INTEGER,
CODIGOGRUPO INTEGER,
CLASSIFICACAO CHAR (100),
    FOREIGN KEY (EMAIL_USUARIO) REFERENCES USUARIO(EMAIL),
    FOREIGN KEY (CODPOSTREFERENCIA) REFERENCES POST(CODIGO),
    FOREIGN KEY (CODIGOGRUPO) REFERENCES GRUPO(CODIGO),
    PRIMARY KEY (CODIGO)
);

INSERT INTO 
PAISES (
    CODIGO, 
    NOME
)VALUES ( '1', 'Afeganistão')
, ( '2', 'África do Sul')
, ( '3', 'Åland, Ilhas')
, ( '4', 'Albânia')
, ( '5', 'Alemanha')
, ( '6', 'Andorra')
, ( '7', 'Angola')
, ( '8', 'Anguilla')
, ( '9', 'Antárctida')
, ( '11', 'Antigua e Barbuda')
, ( '12', 'Antilhas Holandesas')
, ( '13', 'Arábia Saudita')
, ( '14', 'Argélia')
, ( '15', 'Argentina')
, ( '16', 'Arménia')
, ( '17', 'Aruba')
, ( '18', 'Austrália')
, ( '19', 'Áustria')
, ( '20', 'Azerbeijão')
, ( '21', 'Bahamas')
, ( '22', 'Bahrain')
, ( '23', 'Bangladesh')
, ( '24', 'Barbados')
, ( '25', 'Bélgica')
, ( '26', 'Belize')
, ( '27', 'Benin')
, ( '28', 'Bermuda')
, ( '29', 'Bielo-Rússia')
, ( '30', 'Bolívia')
, ( '31', 'Bósnia-Herzegovina')
, ( '32', 'Botswana')
, ( '33', 'Bouvet, Ilha')
, ( '34', 'Brasil')
, ( '35', 'Brunei')
, ( '36', 'Bulgária')
, ( '37', 'Burkina Faso')
, ( '38', 'Burundi')
, ( '39', 'Butão')
, ( '40', 'Cabo Verde')
, ( '41', 'Cambodja')
, ( '42', 'Camarões')
, ( '43', 'Canadá')
, ( '44', 'Cayman, Ilhas')
, ( '45', 'Cazaquistão')
, ( '46', 'Centro-africana, República')
, ( '47', 'Chade')
, ( '48', 'Checa, República')
, ( '49', 'Chile')
, ( '50', 'China')
, ( '51', 'Chipre')
, ( '52', 'Christmas, Ilha')
, ( '53', 'Cocos, Ilhas')
, ( '54', 'Colômbia')
, ( '55', 'Comores')
, ( '56', 'Congo, República do')
, ( '57', 'Congo, República Democrática do (antigo Zaire)')
, ( '58', 'Cook, Ilhas')
, ( '59', 'Coreia do Sul')
, ( '60', 'Coreia, República Democrática da (Coreia do Norte)')
, ( '61', 'Costa do Marfim')
, ( '62', 'Costa Rica')
, ( '63', 'Croácia')
, ( '64', 'Cuba')
, ( '65', 'Dinamarca')
, ( '66', 'Djibouti')
, ( '67', 'Dominica')
, ( '68', 'Dominicana, República')
, ( '69', 'Egipto')
, ( '70', 'El Salvador')
, ( '71', 'Emiratos Árabes Unidos')
, ( '72', 'Equador')
, ( '73', 'Eritreia')
, ( '74', 'Eslováquia')
, ( '75', 'Eslovénia')
, ( '76', 'Espanha')
, ( '77', 'Estados Unidos da América')
, ( '78', 'Estónia')
, ( '79', 'Etiópia')
, ( '80', 'Faroe, Ilhas')
, ( '81', 'Fiji')
, ( '82', 'Filipinas')
, ( '83', 'Finlândia')
, ( '84', 'França')
, ( '85', 'Gabão')
, ( '86', 'Gâmbia')
, ( '87', 'Gana')
, ( '88', 'Geórgia')
, ( '89', 'Geórgia do Sul e Sandwich do Sul, Ilhas')
, ( '90', 'Gibraltar')
, ( '91', 'Grécia')
, ( '92', 'Grenada')
, ( '93', 'Gronelândia')
, ( '94', 'Guadeloupe')
, ( '95', 'Guam')
, ( '96', 'Guatemala')
, ( '97', 'Guernsey')
, ( '98', 'Guiana')
, ( '99', 'Guiana Francesa')
, ( '100', 'Guiné-Bissau')
, ( '101', 'Guiné-Conacri')
, ( '102', 'Guiné Equatorial')
, ( '103', 'Haiti')
, ( '104', 'Heard e Ilhas McDonald, Ilha')
, ( '105', 'Honduras')
, ( '106', 'Hong Kong')
, ( '107', 'Hungria')
, ( '108', 'Iémen')
, ( '109', 'Índia')
, ( '110', 'Indonésia')
, ( '111', 'Iraque')
, ( '112', 'Irão')
, ( '113', 'Irlanda')
, ( '114', 'Islândia')
, ( '115', 'Israel')
, ( '116', 'Itália')
, ( '117', 'Jamaica')
, ( '118', 'Japão')
, ( '119', 'Jersey')
, ( '120', 'Jordânia')
, ( '121', 'Kiribati')
, ( '122', 'Kuwait')
, ( '123', 'Laos')
, ( '124', 'Lesoto')
, ( '125', 'Letónia')
, ( '126', 'Líbano')
, ( '127', 'Libéria')
, ( '128', 'Líbia')
, ( '129', 'Liechtenstein')
, ( '130', 'Lituânia')
, ( '131', 'Luxemburgo')
, ( '132', 'Macau')
, ( '133', 'Macedónia, República da')
, ( '134', 'Madagáscar')
, ( '135', 'Malásia')
, ( '136', 'Malawi')
, ( '137', 'Maldivas')
, ( '138', 'Mali')
, ( '139', 'Malta')
, ( '140', 'Malvinas, Ilhas (Falkland)')
, ( '141', 'Man, Ilha de')
, ( '142', 'Marianas Setentrionais')
, ( '143', 'Marrocos')
, ( '144', 'Marshall, Ilhas')
, ( '145', 'Martinica')
, ( '146', 'Maurícia')
, ( '147', 'Mauritânia')
, ( '148', 'Mayotte')
, ( '149', 'Menores Distantes dos Estados Unidos, Ilhas')
, ( '150', 'México')
, ( '151', 'Myanmar (antiga Birmânia)')
, ( '152', 'Micronésia, Estados Federados da')
, ( '153', 'Moçambique')
, ( '154', 'Moldávia')
, ( '155', 'Mónaco')
, ( '156', 'Mongólia')
, ( '157', 'Montenegro')
, ( '158', 'Montserrat')
, ( '159', 'Namíbia')
, ( '160', 'Nauru')
, ( '161', 'Nepal')
, ( '162', 'Nicarágua')
, ( '163', 'Níger')
, ( '164', 'Nigéria')
, ( '165', 'Niue')
, ( '166', 'Norfolk, Ilha')
, ( '167', 'Noruega')
, ( '168', 'Nova Caledónia')
, ( '169', 'Nova Zelândia (Aotearoa)')
, ( '170', 'Oman')
, ( '171', 'Países Baixos (Holanda)')
, ( '172', 'Palau')
, ( '173', 'Palestina')
, ( '174', 'Panamá')
, ( '175', 'Papua-Nova Guiné')
, ( '176', 'Paquistão')
, ( '177', 'Paraguai')
, ( '178', 'Peru')
, ( '179', 'Pitcairn')
, ( '180', 'Polinésia Francesa')
, ( '181', 'Polónia')
, ( '182', 'Porto Rico')
, ( '183', 'Portugal')
, ( '184', 'Qatar')
, ( '185', 'Quénia')
, ( '186', 'Quirguistão')
, ( '187', 'Reino Unido da Grã-Bretanha e Irlanda do Norte')
, ( '188', 'Reunião')
, ( '189', 'Roménia')
, ( '190', 'Ruanda')
, ( '191', 'Rússia')
, ( '192', 'Saara Ocidental')
, ( '193', 'Samoa Americana')
, ( '194', 'Samoa (Samoa Ocidental)')
, ( '195', 'Saint Pierre et Miquelon')
, ( '196', 'Salomão, Ilhas')
, ( '197', 'São Cristóvão e Névis (Saint Kitts e Nevis)')
, ( '198', 'San Marino')
, ( '199', 'São Tomé e Príncipe')
, ( '200', 'São Vicente e Granadinas')
, ( '201', 'Santa Helena')
, ( '202', 'Santa Lúcia')
, ( '203', 'Senegal')
, ( '204', 'Serra Leoa')
, ( '205', 'Sérvia')
, ( '206', 'Seychelles')
, ( '207', 'Singapura')
, ( '208', 'Síria')
, ( '209', 'Somália')
, ( '210', 'Sri Lanka')
, ( '211', 'Suazilândia')
, ( '212', 'Sudão')
, ( '213', 'Suécia')
, ( '214', 'Suíça')
, ( '215', 'Suriname')
, ( '216', 'Svalbard e Jan Mayen')
, ( '217', 'Tailândia')
, ( '218', 'Taiwan')
, ( '219', 'Tajiquistão')
, ( '220', 'Tanzânia')
, ( '221', 'Terras Austrais e Antárticas Francesas (TAAF)')
, ( '222', 'Território Britânico do Oceano Índico')
, ( '223', 'Timor-Leste')
, ( '224', 'Togo')
, ( '225', 'Toquelau')
, ( '226', 'Tonga')
, ( '227', 'Trindade e Tobago')
, ( '228', 'Tunísia')
, ( '229', 'Turks e Caicos')
, ( '230', 'Turquemenistão')
, ( '231', 'Turquia')
, ( '232', 'Tuvalu')
, ( '233', 'Ucrânia')
, ( '234', 'Uganda')
, ( '235', 'Uruguai')
, ( '236', 'Usbequistão')
, ( '237', 'Vanuatu')
, ( '238', 'Vaticano')
, ( '239', 'Venezuela')
, ( '240', 'Vietname')
, ( '241', 'Virgens Americanas, Ilhas')
, ( '242', 'Virgens Britânicas, Ilhas')
, ( '243', 'Wallis e Futuna')
, ( '244', 'Zâmbia')
, ( '245', 'Zimbabwe');


    INSERT INTO 
    GRUPO(
        CODIGO,
        NOMEGRUPO
    )
    VALUES
    (
        1,
        'SQLite'
    ),
    (
        2,
        'Banco de Dados-IFRS-2021'
    ),
    (
        3,
        'IFRS-Campus Rio Grande'
    )
    ;

INSERT INTO
    USUARIO(
        EMAIL,
        NOME,
        DATACADASTRO,
        CIDADE,
        PAIS,
        UF,
        GENERO,
        NASCIMENTO,
        ATIVO
    )
VALUES
    (
        'joaosbras@mymail.com',
        'João Silva Brasil',
        '2020-01-01 13:00:00',
        'Rio Grande',
        'Brasil',
        'RS',
        'M',
        '1998-02-02',
        true
    ),
    (
        'pmartinssilva90@mymail.com',
        'Paulo Martins Silva',
        null,
        null,
        null,
        null,
        'M',
        '2003-05-23',
        true
    ),
    (
        'mcalbuq@mymail.com',
        'Maria Cruz Albuquerque',
        '2020-01-01 13:10:00',
        'Rio Grande',
        'Brasil',
        'RS',
        'F',
        '2002-11-04',
        true
    ),
    (
        'jorosamed@mymail.com',
        'Joana Rosa Medeiros',
        '2020-01-01 13:15:00',
        'Rio Grande',
        'Brasil',
        'RS',
        'N',
        '1974-02-05',
        true
    ),
    (
        'pxramos@mymail.com',
        'Paulo Xavier Ramos',
        '2020-01-01 13:20:00',
        'Rio Grande',
        'Brasil',
        'RS',
        'N',
        '1966-03-30',
        true
    ),
    (
        'pele@cbf.com.br',
        'Edson Arantes do Nascimento',
        null,
        'Três Corações',
        'Brasil',
        'MG',
        'M',
        '1940-10-23',
        true
    ),
    (
        'alice@mail.com.br',
        'Alice Da Cunha',
        null,
        'Três Corações',
        'Brasil',
        'MG',
        'F',
        '2001-07-04',
        true
    );

INSERT INTO
    AMIZADE(EMAIL_USUARIO1, EMAIL_USUARIO2, DATAAMIZADE)
VALUES
    ('pxramos@mymail.com','jorosamed@mymail.com', '2021-05-17 10:15:00'),
    ('jorosamed@mymail.com', 'pele@cbf.com.br', '2021-05-17 10:15:00'),
    ('mcalbuq@mymail.com', 'pele@cbf.com.br', '2021-05-17 10:20:00' ),
    ( 'jorosamed@mymail.com','mcalbuq@mymail.com','2021-05-17 10:20:00' ),
    ('joaosbras@mymail.com', 'pele@cbf.com.br', '2021-05-20 20:27:00' );
INSERT INTO
    POST(
        CODIGO,
        EMAIL_USUARIO,
        POST,
        CIDADE,
        UF,
        PAIS,
        DATAPOST,
        CODPOSTREFERENCIA,
        CODIGOGRUPO,
        CLASSIFICACAO
    )
VALUES
    (
        1,
        'joaosbras@mymail.com',
        'Hoje eu aprendi como inserir dados no SQLite no IFRS',
        'Rio Grande',
        'RS',
        'Brasil',
        '2015-06-02 15:00:00',
        null,
        null,
        null
    ),
    (
        2,
        'joaosbras@mymail.com',
        'Hoje eu aprendi como inserir dados no SQLite no IFRS',
        'Rio Grande',
        'RS',
        'Brasil',
        '2021-07-15 15:00:00',
        null,
        3,
        'odio'
    ),
    (
        3,
        'jorosamed@mymail.com',
        'Alguém mais ficou com dúvida no comando INSERT?',
        'Rio Grande',
        'RS',
        'Brasil',
        '2021-06-02 15:15:00',
        1,
        1,
        null
    ),
    (
        4,
        'pxramos@mymail.com',
        'Eu também',
        'Rio Grande',
        'RS',
        'Brasil',
        '2021-06-02 15:20:00',
        3,
        null,
        null
    ),
    (
        5,
        'joaosbras@mymail.com',
        'Já agendaste horário de atendimento com o professor?',
        'Rio Grande',
        'RS',
        'Brasil',
        '2021-06-02 15:30:00',
        4,
        null,
        null
    ),
    (
        6,
        'pmartinssilva90@mymail.com',
        'Ontem aprendi sobre joins no SQLite na disciplina de banco de dados do IFRS.',
        'Rio Grande',
        'RS',
        'Brasil',
        '2021-06-08 18:30:00',
        null,
        2,
        null
    ),
    (
        7,
        'pele@cbf.com.br',
        'Show!',
        'Rio Grande',
        'RS',
        'Brasil',
        '2021-06-08 20:34:02',
        6,
        2,
        null
    ),
     (
        8,
        'joaosbras@mymail.com',
        'Hoje eu aprendi como inserir dados no SQLite no IFRS',
        'Rio Grande',
        'RS',
        'Brasil',
        '2021-06-02 15:00:00',
        null,
        null,
        null
    ),
     (
        9,
        'joaosbras@mymail.com',
        'Hoje eu aprendi como inserir dados no SQLite no IFRS',
        'a',
        'b',
        'EUA',
        '2021-06-02 15:00:00',
        null,
        null, 
        null
    ),
     (
        10,
        'joaosbras@mymail.com',
        'Hoje eu aprendi como inserir dados no SQLite no IFRS',
        'a',
        'b',
        'EUA',
        '2021-06-02 15:00:00',
        null,
        null,
        null
    ),
     (
        11,
        'joaosbras@mymail.com',
        'Hoje eu aprendi como inserir dados no SQLite no IFRS',
        'c',
        'd',
        'Cuba',
        '2021-06-02 15:00:00',
        null,
        null,
        null
    ),
     (
        12,
        'pele@cbf.com.br',
        'SHOW!',
        'Rio de Janeiro',
        'RJ',
        'Brasil',
        '2021-06-02 15:00:00',
        10,
        null,
        null
    ),
    (
        13,
        'pele@cbf.com.br',
        'Brasil: 20 medalhas nas Olimpíadas 2020/2021 em Tóquio',
        'Rio de Janeiro',
        'RJ',
        'Brasil',
        '2021-08-05 15:00:00',
        null,
        null,
        null
    ),
    (
        14,
        'joaosbras@mymail.com',
        'Boa tarde galera, vai começar o recesso!',
        'Rio Grande',
        'RS',
        'Brasil',
        '2021-08-21 15:00:00',
        null,
        3,
        null
    ), 
    (
        15,
        'joaosbras@mymail.com',
        'Boa noite faces',
        'Rio Grande',
        'RS',
        'Brasil',
        '2021-08-19 21:00:00',
        null,
        3,
        null
    ),
    (
        16,
        'mcalbuq@mymail.com',
        'Boa noite!!!',
        'Rio Grande',
        'RS',
        'Brasil',
        '2021-08-19 23:00:00',
        15,
        3,
        null
    );

INSERT INTO
    ASSUNTO(CODIGO, ASSUNTO)
VALUES
    (1, 'BD'),
    (2, 'SQLite'),
    (3, 'INSERT'),
    (4, 'atendimento'),
    (5, 'SELECT');

INSERT INTO
    ASSUNTOPOST (CODIGOPOST, CODIGOASSUNTO)
VALUES
    (1, 1),
    (1, 2),
    (3, 1),
    (3, 2),
    (3, 3),
    (5, 4),
    (5, 1),
    (6, 1),
    (6, 2),
    (8, 5),
    (9, 1),
    (10, 2),
    (11, 1);

INSERT INTO
    REACAO(
        CODIGO,
        TIPOREACAO,
        EMAIL_USUARIO,
        CIDADE,
        UF,
        PAIS,
        COD_POST,
        DATAREACAO
    )
values
    (
        2,
        'Amei',
        'mcalbuq@mymail.com',
        'Rio Grande',
        'RS',
        'Brasil',
        1,
        '2021-06-02 15:10:00'
    ),
    (
        3,
        'Curtida',
        'pxramos@mymail.com',
        'Rio Grande',
        'RS',
        'Brasil',
        3,
        '2021-06-02 15:20:00'
    ),
        (
        4,
        'Curtida',
        'pxramos@mymail.com',
        'Rio Grande',
        'RS',
        'Brasil',
        3,
        '2021-06-03 15:21:00'
    ),
    (
        5,
        'Triste',
        'joaosbras@mymail.com',
        'Rio Grande',
        'RS',
        'Brasil',
        3,
        '2021-06-02 15:50:00'
    ),
    (
        6,
        'Amei',
        'mcalbuq@mymail.com',
        'Rio Grande',
        'RS',
        'Brasil',
        15,
        '2021-08-20 15:10:00'
    ),
    (
        7,
        'Amei',
        'mcalbuq@mymail.com',
        'Rio Grande',
        'RS',
        'Brasil',
        16,
        '2021-08-20 15:13:10'
    );


INSERT INTO
    GRUPOUSUARIO(
        CODIGOGRUPO,
        EMAIL_USUARIO
    )
values
    (2,
    'pxramos@mymail.com'),
    (2,
    'mcalbuq@mymail.com'),
    (1, 
    'joaosbras@mymail.com'), 
    (1, 
    'pxramos@mymail.com'),
    (3, 'pxramos@mymail.com'),
    (3, 'joaosbras@mymail.com'),
    (3,
    'mcalbuq@mymail.com'),
    (3, 'pmartinssilva90@mymail.com');
    

INSERT INTO
    GRUPOUSUARIO(
        CODIGOGRUPO,
        EMAIL_USUARIO
    )
values
    (2,
    'pxramos@mymail.com'),
    (2,
    'mcalbuq@mymail.com'),
    (1, 
    'joaosbras@mymail.com'), 
    (1, 
    'pxramos@mymail.com');


INSERT INTO COMPARTILHAMENTO(
    CODIGO,
    EMAIL_USUARIO,
    COD_POST,
    CIDADE,
    UF,
    DATACOMPARTILHAMENTO
) VALUES
(
    1, 
    'joaosbras@mymail.com',
    6,
    'Rio Grande',
    'RS', 
    '2021-06-10 13:00:00'
);

CREATE TABLE SELO(
    EMAIL_USUARIO CHAR (100) NOT NULL,
    CODIGOGRUPO INTEGER NOT NULL,
    DATAINICIO DATETIME NOT NULL,
    DATAFINAL DATETIME NOT NULL,
    TIPOSELO CHAR(20) NOT NULL,
    FOREIGN KEY (EMAIL_USUARIO) REFERENCES USUARIO(EMAIL),
    FOREIGN KEY (CODIGOGRUPO) REFERENCES GRUPO(CODIGO),
    PRIMARY KEY (EMAIL_USUARIO, CODIGOGRUPO, DATAINICIO)
);