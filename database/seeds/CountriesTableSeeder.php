<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run()
    {
        /*$countries['1'] = ['AF','AFGHANISTAN','Afghanistan','AFG','4','93'];
        $countries['2'] = ['AL','ALBANIA','Albania','ALB','8','355'];
        $countries['3'] = ['DZ','ALGERIA','Algeria','DZA','12','213'];
        $countries['4'] = ['AS','AMERICAN SAMOA','American Samoa','ASM','16','1684'];
        $countries['5'] = ['AD','ANDORRA','Andorra','AND','20','376'];
        $countries['6'] = ['AO','ANGOLA','Angola','AGO','24','244'];
        $countries['7'] = ['AI','ANGUILLA','Anguilla','AIA','660','1264'];
        $countries['8'] = ['AQ','ANTARCTICA','Antarctica',NULL,NULL,'0'];
        $countries['9'] = ['AG','ANTIGUA AND BARBUDA','Antigua and Barbuda','ATG','28','1268'];
        $countries['10'] = ['AR','ARGENTINA','Argentina','ARG','32','54'];
        $countries['11'] = ['AM','ARMENIA','Armenia','ARM','51','374'];
        $countries['12'] = ['AW','ARUBA','Aruba','ABW','533','297'];
        $countries['13'] = ['AU','AUSTRALIA','Australia','AUS','36','61'];
        $countries['14'] = ['AT','AUSTRIA','Austria','AUT','40','43'];
        $countries['15'] = ['AZ','AZERBAIJAN','Azerbaijan','AZE','31','994'];
        $countries['16'] = ['BS','BAHAMAS','Bahamas','BHS','44','1242'];
        $countries['17'] = ['BH','BAHRAIN','Bahrain','BHR','48','973'];
        $countries['18'] = ['BD','BANGLADESH','Bangladesh','BGD','50','880'];
        $countries['19'] = ['BB','BARBADOS','Barbados','BRB','52','1246'];
        $countries['20'] = ['BY','BELARUS','Belarus','BLR','112','375'];
        $countries['21'] = ['BE','BELGIUM','Belgium','BEL','56','32'];
        $countries['22'] = ['BZ','BELIZE','Belize','BLZ','84','501'];
        $countries['23'] = ['BJ','BENIN','Benin','BEN','204','229'];
        $countries['24'] = ['BM','BERMUDA','Bermuda','BMU','60','1441'];
        $countries['25'] = ['BT','BHUTAN','Bhutan','BTN','64','975'];
        $countries['26'] = ['BO','BOLIVIA','Bolivia','BOL','68','591'];
        $countries['27'] = ['BA','BOSNIA AND HERZEGOVINA','Bosnia and Herzegovina','BIH','70','387'];
        $countries['28'] = ['BW','BOTSWANA','Botswana','BWA','72','267'];
        $countries['29'] = ['BV','BOUVET ISLAND','Bouvet Island',NULL,NULL,'0'];
        $countries['30'] = ['BR','BRAZIL','Brazil','BRA','76','55'];
        $countries['31'] = ['IO','BRITISH INDIAN OCEAN TERRITORY','British Indian Ocean Territory',NULL,NULL,'246'];
        $countries['32'] = ['BN','BRUNEI DARUSSALAM','Brunei Darussalam','BRN','96','673'];
        $countries['33'] = ['BG','BULGARIA','Bulgaria','BGR','100','359'];
        $countries['34'] = ['BF','BURKINA FASO','Burkina Faso','BFA','854','226'];
        $countries['35'] = ['BI','BURUNDI','Burundi','BDI','108','257'];
        $countries['36'] = ['KH','CAMBODIA','Cambodia','KHM','116','855'];
        $countries['37'] = ['CM','CAMEROON','Cameroon','CMR','120','237'];
        $countries['38'] = ['CA','CANADA','Canada','CAN','124','1'];
        $countries['39'] = ['CV','CAPE VERDE','Cape Verde','CPV','132','238'];
        $countries['40'] = ['KY','CAYMAN ISLANDS','Cayman Islands','CYM','136','1345'];
        $countries['41'] = ['CF','CENTRAL AFRICAN REPUBLIC','Central African Republic','CAF','140','236'];
        $countries['42'] = ['TD','CHAD','Chad','TCD','148','235'];
        $countries['43'] = ['CL','CHILE','Chile','CHL','152','56'];
        $countries['44'] = ['CN','CHINA','China','CHN','156','86'];
        $countries['45'] = ['CX','CHRISTMAS ISLAND','Christmas Island',NULL,NULL,'61'];
        $countries['46'] = ['CC','COCOS (KEELING) ISLANDS','Cocos (Keeling) Islands',NULL,NULL,'672'];
        $countries['47'] = ['CO','COLOMBIA','Colombia','COL','170','57'];
        $countries['48'] = ['KM','COMOROS','Comoros','COM','174','269'];
        $countries['49'] = ['CG','CONGO','Congo','COG','178','242'];
        $countries['50'] = ['CD','CONGO, THE DEMOCRATIC REPUBLIC OF THE','Congo, the Democratic Republic of the','COD','180','242'];
        $countries['51'] = ['CK','COOK ISLANDS','Cook Islands','COK','184','682'];
        $countries['52'] = ['CR','COSTA RICA','Costa Rica','CRI','188','506'];
        $countries['53'] = ['CI','COTE D\'IVOIRE','Cote D\'Ivoire','CIV','384','225'];
        $countries['54'] = ['HR','CROATIA','Croatia','HRV','191','385'];
        $countries['55'] = ['CU','CUBA','Cuba','CUB','192','53'];
        $countries['56'] = ['CY','CYPRUS','Cyprus','CYP','196','357'];
        $countries['57'] = ['CZ','CZECH REPUBLIC','Czech Republic','CZE','203','420'];
        $countries['58'] = ['DK','DENMARK','Denmark','DNK','208','45'];
        $countries['59'] = ['DJ','DJIBOUTI','Djibouti','DJI','262','253'];
        $countries['60'] = ['DM','DOMINICA','Dominica','DMA','212','1767'];
        $countries['61'] = ['DO','DOMINICAN REPUBLIC','Dominican Republic','DOM','214','1809'];
        $countries['62'] = ['EC','ECUADOR','Ecuador','ECU','218','593'];
        $countries['63'] = ['EG','EGYPT','Egypt','EGY','818','20'];
        $countries['64'] = ['SV','EL SALVADOR','El Salvador','SLV','222','503'];
        $countries['65'] = ['GQ','EQUATORIAL GUINEA','Equatorial Guinea','GNQ','226','240'];
        $countries['66'] = ['ER','ERITREA','Eritrea','ERI','232','291'];
        $countries['67'] = ['EE','ESTONIA','Estonia','EST','233','372'];
        $countries['68'] = ['ET','ETHIOPIA','Ethiopia','ETH','231','251'];
        $countries['69'] = ['FK','FALKLAND ISLANDS (MALVINAS)','Falkland Islands (Malvinas)','FLK','238','500'];
        $countries['70'] = ['FO','FAROE ISLANDS','Faroe Islands','FRO','234','298'];
        $countries['71'] = ['FJ','FIJI','Fiji','FJI','242','679'];
        $countries['72'] = ['FI','FINLAND','Finland','FIN','246','358'];
        $countries['73'] = ['FR','FRANCE','France','FRA','250','33'];
        $countries['74'] = ['GF','FRENCH GUIANA','French Guiana','GUF','254','594'];
        $countries['75'] = ['PF','FRENCH POLYNESIA','French Polynesia','PYF','258','689'];
        $countries['76'] = ['TF','FRENCH SOUTHERN TERRITORIES','French Southern Territories',NULL,NULL,'0'];
        $countries['77'] = ['GA','GABON','Gabon','GAB','266','241'];
        $countries['78'] = ['GM','GAMBIA','Gambia','GMB','270','220'];
        $countries['79'] = ['GE','GEORGIA','Georgia','GEO','268','995'];
        $countries['80'] = ['DE','GERMANY','Germany','DEU','276','49'];
        $countries['81'] = ['GH','GHANA','Ghana','GHA','288','233'];
        $countries['82'] = ['GI','GIBRALTAR','Gibraltar','GIB','292','350'];
        $countries['83'] = ['GR','GREECE','Greece','GRC','300','30'];
        $countries['84'] = ['GL','GREENLAND','Greenland','GRL','304','299'];
        $countries['85'] = ['GD','GRENADA','Grenada','GRD','308','1473'];
        $countries['86'] = ['GP','GUADELOUPE','Guadeloupe','GLP','312','590'];
        $countries['87'] = ['GU','GUAM','Guam','GUM','316','1671'];
        $countries['88'] = ['GT','GUATEMALA','Guatemala','GTM','320','502'];
        $countries['89'] = ['GN','GUINEA','Guinea','GIN','324','224'];
        $countries['90'] = ['GW','GUINEA-BISSAU','Guinea-Bissau','GNB','624','245'];
        $countries['91'] = ['GY','GUYANA','Guyana','GUY','328','592'];
        $countries['92'] = ['HT','HAITI','Haiti','HTI','332','509'];
        $countries['93'] = ['HM','HEARD ISLAND AND MCDONALD ISLANDS','Heard Island and Mcdonald Islands',NULL,NULL,'0'];
        $countries['94'] = ['VA','HOLY SEE (VATICAN CITY STATE)','Holy See (Vatican City State)','VAT','336','39'];
        $countries['95'] = ['HN','HONDURAS','Honduras','HND','340','504'];
        $countries['96'] = ['HK','HONG KONG','Hong Kong','HKG','344','852'];
        $countries['97'] = ['HU','HUNGARY','Hungary','HUN','348','36'];
        $countries['98'] = ['IS','ICELAND','Iceland','ISL','352','354'];
        $countries['99'] = ['IN','INDIA','India','IND','356','91'];
        $countries['100'] = ['ID','INDONESIA','Indonesia','IDN','360','62'];
        $countries['101'] = ['IR','IRAN, ISLAMIC REPUBLIC OF','Iran, Islamic Republic of','IRN','364','98'];
        $countries['102'] = ['IQ','IRAQ','Iraq','IRQ','368','964'];
        $countries['103'] = ['IE','IRELAND','Ireland','IRL','372','353'];
        $countries['104'] = ['IL','ISRAEL','Israel','ISR','376','972'];
        $countries['105'] = ['IT','ITALY','Italy','ITA','380','39'];
        $countries['106'] = ['JM','JAMAICA','Jamaica','JAM','388','1876'];
        $countries['107'] = ['JP','JAPAN','Japan','JPN','392','81'];
        $countries['108'] = ['JO','JORDAN','Jordan','JOR','400','962'];
        $countries['109'] = ['KZ','KAZAKHSTAN','Kazakhstan','KAZ','398','7'];
        $countries['110'] = ['KE','KENYA','Kenya','KEN','404','254'];
        $countries['111'] = ['KI','KIRIBATI','Kiribati','KIR','296','686'];
        $countries['112'] = ['KP','KOREA, DEMOCRATIC PEOPLE\'S REPUBLIC OF','Korea, Democratic People\'s Republic of','PRK','408','850'];
        $countries['113'] = ['KR','KOREA, REPUBLIC OF','Korea, Republic of','KOR','410','82'];
        $countries['114'] = ['KW','KUWAIT','Kuwait','KWT','414','965'];
        $countries['115'] = ['KG','KYRGYZSTAN','Kyrgyzstan','KGZ','417','996'];
        $countries['116'] = ['LA','LAO PEOPLE\'S DEMOCRATIC REPUBLIC','Lao People\'s Democratic Republic','LAO','418','856'];
        $countries['117'] = ['LV','LATVIA','Latvia','LVA','428','371'];
        $countries['118'] = ['LB','LEBANON','Lebanon','LBN','422','961'];
        $countries['119'] = ['LS','LESOTHO','Lesotho','LSO','426','266'];
        $countries['120'] = ['LR','LIBERIA','Liberia','LBR','430','231'];
        $countries['121'] = ['LY','LIBYAN ARAB JAMAHIRIYA','Libyan Arab Jamahiriya','LBY','434','218'];
        $countries['122'] = ['LI','LIECHTENSTEIN','Liechtenstein','LIE','438','423'];
        $countries['123'] = ['LT','LITHUANIA','Lithuania','LTU','440','370'];
        $countries['124'] = ['LU','LUXEMBOURG','Luxembourg','LUX','442','352'];
        $countries['125'] = ['MO','MACAO','Macao','MAC','446','853'];
        $countries['126'] = ['MK','MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF','Macedonia, the Former Yugoslav Republic of','MKD','807','389'];
        $countries['127'] = ['MG','MADAGASCAR','Madagascar','MDG','450','261'];
        $countries['128'] = ['MW','MALAWI','Malawi','MWI','454','265'];
        $countries['129'] = ['MY','MALAYSIA','Malaysia','MYS','458','60'];
        $countries['130'] = ['MV','MALDIVES','Maldives','MDV','462','960'];
        $countries['131'] = ['ML','MALI','Mali','MLI','466','223'];
        $countries['132'] = ['MT','MALTA','Malta','MLT','470','356'];
        $countries['133'] = ['MH','MARSHALL ISLANDS','Marshall Islands','MHL','584','692'];
        $countries['134'] = ['MQ','MARTINIQUE','Martinique','MTQ','474','596'];
        $countries['135'] = ['MR','MAURITANIA','Mauritania','MRT','478','222'];
        $countries['136'] = ['MU','MAURITIUS','Mauritius','MUS','480','230'];
        $countries['137'] = ['YT','MAYOTTE','Mayotte',NULL,NULL,'269'];
        $countries['138'] = ['MX','MEXICO','Mexico','MEX','484','52'];
        $countries['139'] = ['FM','MICRONESIA, FEDERATED STATES OF','Micronesia, Federated States of','FSM','583','691'];
        $countries['140'] = ['MD','MOLDOVA, REPUBLIC OF','Moldova, Republic of','MDA','498','373'];
        $countries['141'] = ['MC','MONACO','Monaco','MCO','492','377'];
        $countries['142'] = ['MN','MONGOLIA','Mongolia','MNG','496','976'];
        $countries['143'] = ['MS','MONTSERRAT','Montserrat','MSR','500','1664'];
        $countries['144'] = ['MA','MOROCCO','Morocco','MAR','504','212'];
        $countries['145'] = ['MZ','MOZAMBIQUE','Mozambique','MOZ','508','258'];
        $countries['146'] = ['MM','MYANMAR','Myanmar','MMR','104','95'];
        $countries['147'] = ['NA','NAMIBIA','Namibia','NAM','516','264'];
        $countries['148'] = ['NR','NAURU','Nauru','NRU','520','674'];
        $countries['149'] = ['NP','NEPAL','Nepal','NPL','524','977'];
        $countries['150'] = ['NL','NETHERLANDS','Netherlands','NLD','528','31'];
        $countries['151'] = ['AN','NETHERLANDS ANTILLES','Netherlands Antilles','ANT','530','599'];
        $countries['152'] = ['NC','NEW CALEDONIA','New Caledonia','NCL','540','687'];
        $countries['153'] = ['NZ','NEW ZEALAND','New Zealand','NZL','554','64'];
        $countries['154'] = ['NI','NICARAGUA','Nicaragua','NIC','558','505'];
        $countries['155'] = ['NE','NIGER','Niger','NER','562','227'];
        $countries['156'] = ['NG','NIGERIA','Nigeria','NGA','566','234'];
        $countries['157'] = ['NU','NIUE','Niue','NIU','570','683'];
        $countries['158'] = ['NF','NORFOLK ISLAND','Norfolk Island','NFK','574','672'];
        $countries['159'] = ['MP','NORTHERN MARIANA ISLANDS','Northern Mariana Islands','MNP','580','1670'];
        $countries['160'] = ['NO','NORWAY','Norway','NOR','578','47'];
        $countries['161'] = ['OM','OMAN','Oman','OMN','512','968'];
        $countries['162'] = ['PK','PAKISTAN','Pakistan','PAK','586','92'];
        $countries['163'] = ['PW','PALAU','Palau','PLW','585','680'];
        $countries['164'] = ['PS','PALESTINIAN TERRITORY, OCCUPIED','Palestinian Territory, Occupied',NULL,NULL,'970'];
        $countries['165'] = ['PA','PANAMA','Panama','PAN','591','507'];
        $countries['166'] = ['PG','PAPUA NEW GUINEA','Papua New Guinea','PNG','598','675'];
        $countries['167'] = ['PY','PARAGUAY','Paraguay','PRY','600','595'];
        $countries['168'] = ['PE','PERU','Peru','PER','604','51'];
        $countries['169'] = ['PH','PHILIPPINES','Philippines','PHL','608','63'];
        $countries['170'] = ['PN','PITCAIRN','Pitcairn','PCN','612','0'];
        $countries['171'] = ['PL','POLAND','Poland','POL','616','48'];
        $countries['172'] = ['PT','PORTUGAL','Portugal','PRT','620','351'];
        $countries['173'] = ['PR','PUERTO RICO','Puerto Rico','PRI','630','1787'];
        $countries['174'] = ['QA','QATAR','Qatar','QAT','634','974'];
        $countries['175'] = ['RE','REUNION','Reunion','REU','638','262'];
        $countries['176'] = ['RO','ROMANIA','Romania','ROM','642','40'];
        $countries['177'] = ['RU','RUSSIAN FEDERATION','Russian Federation','RUS','643','70'];
        $countries['178'] = ['RW','RWANDA','Rwanda','RWA','646','250'];
        $countries['179'] = ['SH','SAINT HELENA','Saint Helena','SHN','654','290'];
        $countries['180'] = ['KN','SAINT KITTS AND NEVIS','Saint Kitts and Nevis','KNA','659','1869'];
        $countries['181'] = ['LC','SAINT LUCIA','Saint Lucia','LCA','662','1758'];
        $countries['182'] = ['PM','SAINT PIERRE AND MIQUELON','Saint Pierre and Miquelon','SPM','666','508'];
        $countries['183'] = ['VC','SAINT VINCENT AND THE GRENADINES','Saint Vincent and the Grenadines','VCT','670','1784'];
        $countries['184'] = ['WS','SAMOA','Samoa','WSM','882','684'];
        $countries['185'] = ['SM','SAN MARINO','San Marino','SMR','674','378'];
        $countries['186'] = ['ST','SAO TOME AND PRINCIPE','Sao Tome and Principe','STP','678','239'];
        $countries['187'] = ['SA','SAUDI ARABIA','Saudi Arabia','SAU','682','966'];
        $countries['188'] = ['SN','SENEGAL','Senegal','SEN','686','221'];
        $countries['189'] = ['CS','SERBIA AND MONTENEGRO','Serbia and Montenegro',NULL,NULL,'381'];
        $countries['190'] = ['SC','SEYCHELLES','Seychelles','SYC','690','248'];
        $countries['191'] = ['SL','SIERRA LEONE','Sierra Leone','SLE','694','232'];
        $countries['192'] = ['SG','SINGAPORE','Singapore','SGP','702','65'];
        $countries['193'] = ['SK','SLOVAKIA','Slovakia','SVK','703','421'];
        $countries['194'] = ['SI','SLOVENIA','Slovenia','SVN','705','386'];
        $countries['195'] = ['SB','SOLOMON ISLANDS','Solomon Islands','SLB','90','677'];
        $countries['196'] = ['SO','SOMALIA','Somalia','SOM','706','252'];
        $countries['197'] = ['ZA','SOUTH AFRICA','South Africa','ZAF','710','27'];
        $countries['198'] = ['GS','SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS','South Georgia and the South Sandwich Islands',NULL,NULL,'0'];
        $countries['199'] = ['ES','SPAIN','Spain','ESP','724','34'];
        $countries['200'] = ['LK','SRI LANKA','Sri Lanka','LKA','144','94'];
        $countries['201'] = ['SD','SUDAN','Sudan','SDN','736','249'];
        $countries['202'] = ['SR','SURINAME','Suriname','SUR','740','597'];
        $countries['203'] = ['SJ','SVALBARD AND JAN MAYEN','Svalbard and Jan Mayen','SJM','744','47'];
        $countries['204'] = ['SZ','SWAZILAND','Swaziland','SWZ','748','268'];
        $countries['205'] = ['SE','SWEDEN','Sweden','SWE','752','46'];
        $countries['206'] = ['CH','SWITZERLAND','Switzerland','CHE','756','41'];
        $countries['207'] = ['SY','SYRIAN ARAB REPUBLIC','Syrian Arab Republic','SYR','760','963'];
        $countries['208'] = ['TW','TAIWAN, PROVINCE OF CHINA','Taiwan, Province of China','TWN','158','886'];
        $countries['209'] = ['TJ','TAJIKISTAN','Tajikistan','TJK','762','992'];
        $countries['210'] = ['TZ','TANZANIA, UNITED REPUBLIC OF','Tanzania, United Republic of','TZA','834','255'];
        $countries['211'] = ['TH','THAILAND','Thailand','THA','764','66'];
        $countries['212'] = ['TL','TIMOR-LESTE','Timor-Leste',NULL,NULL,'670'];
        $countries['213'] = ['TG','TOGO','Togo','TGO','768','228'];
        $countries['214'] = ['TK','TOKELAU','Tokelau','TKL','772','690'];
        $countries['215'] = ['TO','TONGA','Tonga','TON','776','676'];
        $countries['216'] = ['TT','TRINIDAD AND TOBAGO','Trinidad and Tobago','TTO','780','1868'];
        $countries['217'] = ['TN','TUNISIA','Tunisia','TUN','788','216'];
        $countries['218'] = ['TR','TURKEY','Turkey','TUR','792','90'];
        $countries['219'] = ['TM','TURKMENISTAN','Turkmenistan','TKM','795','7370'];
        $countries['220'] = ['TC','TURKS AND CAICOS ISLANDS','Turks and Caicos Islands','TCA','796','1649'];
        $countries['221'] = ['TV','TUVALU','Tuvalu','TUV','798','688'];
        $countries['222'] = ['UG','UGANDA','Uganda','UGA','800','256'];
        $countries['223'] = ['UA','UKRAINE','Ukraine','UKR','804','380'];
        $countries['224'] = ['AE','UNITED ARAB EMIRATES','United Arab Emirates','ARE','784','971'];
        $countries['225'] = ['GB','UNITED KINGDOM','United Kingdom','GBR','826','44'];
        $countries['226'] = ['US','UNITED STATES','United States','USA','840','1'];
        $countries['227'] = ['UM','UNITED STATES MINOR OUTLYING ISLANDS','United States Minor Outlying Islands',NULL,NULL,'1'];
        $countries['228'] = ['UY','URUGUAY','Uruguay','URY','858','598'];
        $countries['229'] = ['UZ','UZBEKISTAN','Uzbekistan','UZB','860','998'];
        $countries['230'] = ['VU','VANUATU','Vanuatu','VUT','548','678'];
        $countries['231'] = ['VE','VENEZUELA','Venezuela','VEN','862','58'];
        $countries['232'] = ['VN','VIET NAM','Viet Nam','VNM','704','84'];
        $countries['233'] = ['VG','VIRGIN ISLANDS, BRITISH','Virgin Islands, British','VGB','92','1284'];
        $countries['234'] = ['VI','VIRGIN ISLANDS, U.S.','Virgin Islands, U.s.','VIR','850','1340'];
        $countries['235'] = ['WF','WALLIS AND FUTUNA','Wallis and Futuna','WLF','876','681'];
        $countries['236'] = ['EH','WESTERN SAHARA','Western Sahara','ESH','732','212'];
        $countries['237'] = ['YE','YEMEN','Yemen','YEM','887','967'];
        $countries['238'] = ['ZM','ZAMBIA','Zambia','ZMB','894','260'];
        $countries['239'] = ['ZW','ZIMBABWE','Zimbabwe','ZWE','716','263'];

        for($i=1;$i<=239;$i++){
            DB::table('countries')->insert([
                'iso'       => $countries[$i][0],
                'name'      => $countries[$i][1],
                'nicename'  => $countries[$i][2],
                'iso3'      => $countries[$i][3],
                'numcode'   => $countries[$i][4],
                'phonecode' => $countries[$i][5],
                'created_at'=> date('Y-m-d H:i:s', time())
            ]);
        }*/
        $db     = \Config::get('database.connections.mysql.database');
        $user   = \Config::get('database.connections.mysql.username');
        $pass   = \Config::get('database.connections.mysql.password');
        $file = __DIR__ . DIRECTORY_SEPARATOR . "../Countries.sql";
        // $this->command->info($db);
        // $this->command->info($user);
        // $this->command->info($pass);

        exec("mysql -u " . $user . " -p" . $pass . " " . $db . " < ".$file);
    }
}
