<?php
function jal_install() {
	global $wpdb;
	
	$table_name1 = $wpdb->prefix . 'users';

	$table_name2 = $wpdb->prefix . 'Questions';
	
	$table_name3 = $wpdb->prefix . 'Company_answer';
	
	$table_name4 = $wpdb->prefix . 'School_answer';
	
	$charset_collate = $wpdb->get_charset_collate();
	
	
	$sql = "CREATE TABLE IF NOT EXISTS $table_name2(
		question_id INT(3) NOT NULL AUTO_INCREMENT,
		question_set INT(1) NOT NULL,
		question VARCHAR(100) NOT NULL,
		theme VARCHAR(50),
		PRIMARY KEY (question_id)
		)$charset_collate;";

	$sql1 = "CREATE TABLE IF NOT EXISTS $table_name3(
		company_answer_id INT(3) NOT NULL AUTO_INCREMENT,
		wpuser_id BIGINT(20) UNSIGNED NOT NULL,
		question_id INT(3) NOT NULL,
		answer_max INT(1) NOT NULL,
		answer_min INT(1) NOT NULL,
		answer_priority INT(1),
		FOREIGN KEY (wpuser_id) REFERENCES $table_name1 (ID),
		FOREIGN KEY (question_id) REFERENCES $table_name2 (question_id),
		PRIMARY KEY (company_answer_id)
		)$charset_collate;";

	$sql2 =	"CREATE TABLE IF NOT EXISTS $table_name4(
		school_answer_id INT(3) NOT NULL AUTO_INCREMENT,
		wpuser_id BIGINT(20) UNSIGNED NOT NULL,
		question_id INT(3) NOT NULL,
		company_answer_id INT(3) NOT NULL,
		answer_val INT(1) NOT NULL,
		comment VARCHAR(300),
		FOREIGN KEY (wpuser_id) REFERENCES $table_name1 (ID),
		FOREIGN KEY (question_id) REFERENCES $table_name2 (question_id),
		FOREIGN KEY (company_answer_id) REFERENCES $table_name3 (company_answer_id), 
		PRIMARY KEY (school_answer_id)
		)$charset_collate;";
		
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
	dbDelta( $sql1 );
	dbDelta( $sql2 );

	// Test if questions already exist in (old version of) Questions table
	$test = $wpdb->get_results("SELECT * FROM $table_name2");
	if(count($test) == 0){
		$wpdb->query(
		  "INSERT INTO wp_Questions VALUES
		  (NULL, 1, 'Opettajilla on käsitys opetusta tukevista sovelluksista ja teknologioista', 'Ihmiset ja organisaatio'),
		  (NULL, 1, 'Opettajat toimivat käyttäjinä ja sisällöntuottajina', 'Ihmiset ja organisaatio'),
		  (NULL, 1, 'Opettajat saavat tukea sovellusten käyttöön', 'Ihmiset ja organisaatio'),
		  (NULL, 1, 'Opetusteknologian rooli on ymmärretty', 'Ihmiset ja organisaatio'),
		  (NULL, 1, 'Opettajat haluavat kokeilla uusia työkaluja', 'Ihmiset ja organisaatio'),
		  (NULL, 2, 'Koulussa on riittävät laitteet käytössä', 'Teknologia'),
		  (NULL, 2, 'Sovellus sopii hyvin IT-intraan', 'Teknologia'),
		  (NULL, 2, 'Opettajat voivat ottaa käyttöön sovelluksia', 'Teknologia'),
		  (NULL, 2, 'Opettajat ovat mukana sähköisten opetusympäristöjen kehittämisessä', 'Teknologia'),
		  (NULL, 2, 'Koulussa käytetään oppilaiden omia laitteita', 'Teknologia'),
		  (NULL, 3, 'Koulun johto tukee sähköisen opetusympäristön kehittämistä', 'Johtaminen ja arviointi'),
		  (NULL, 3, 'Tietoturvaan liittyvät ongelmat on koulun arvion mukaan ratkaistu', 'Johtaminen ja arviointi'),
		  (NULL, 3, 'Opettajilla on resursseja kehittää sähköistä opetusympäristöä', 'Johtaminen ja arviointi'),
		  (NULL, 4, 'Implementointi sopii opetusssuunnitelmaan', 'Prosessit'),
		  (NULL, 4, 'Opettajien ja oppilaiden osaamistarpeet on tunnistettu', 'Prosessit'),
		  (NULL, 4, 'Oppilaat voivat käyttää sovellusta', 'Prosessit'),
		  (NULL, 4, 'Implementointi tuo lisäarvoa opetukseen', 'Prosessit'),
		  (NULL, 4, 'Implementointi tukee oppilaiden kehittymisen arviointia', 'Prosessit'),
		  (NULL, 5, 'Koululla on kehittämisstrategia', 'Strategia'),
		  (NULL, 5, 'Kehittämisen tavoitteet on kommunikoitu', 'Strategia'),
		  (NULL, 5, 'Kehittämisstrategia on linjassa opetussuunnitelman kanssa', 'Strategia'),
		  (NULL, 5, 'Kehittämisstrategian toteuttamisella on koulun johdon tuki', 'Strategia'),
		  (NULL, 5, 'Koululla on toimintasuunnitelma sähköisen opetusympäristön kehittämiseen', 'Strategia')
		  "
		);
	}
}
?>
