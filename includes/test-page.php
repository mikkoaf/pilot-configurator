<?php
// All-purpose test page
function pilot_test_page_html() {

  if ( ! current_user_can( 'administrator' ) ) {
    return;
  }

  ?>
  <div class="wrap">
    <h1>testing</h1>
      <?php
      // button press checks and function calls
      if(isset($_POST['des_data'])){
        unset($_POST['des_data']);
        destroy_data();
        echo 'All dummy data destroyed and database recreated, refresh page to create new base dummy data';
      }

      else if(data_exist() == true){
        if(isset($_POST['special_test'])){
          $company = get_user_by('id', $_POST['company_id']);
          $school = get_user_by('id', $_POST['school_id']);
          echo  'SPECIAL QUERY FOR USERS ' . $_POST['company_id'] . ' AND ' . $_POST['school_id'] . ' QUESTIONS ' . $_POST['question_id_first'] . ' TO ' . $_POST['question_id_last'].
                '<br>Company: "' . $company->data->user_login . 
                '" has match for school: "' . $school->data->user_login .
                '" with the result: ' . match_alg_test($_POST['company_id'], $_POST['school_id'], $_POST['question_id_first'], $_POST['question_id_last']) . '% <br>';
        }
        else{
          if(isset($_POST['gen_data'])){
            unset($_POST['gen_data']);
            create_data_dynamic();
          }
          else if(isset($_POST['gen_data_x10'])){
            unset($_POST['gen_data_10']);
            for($i=0; $i<10; $i++)
              create_data_dynamic();
          }

          // Show result for match alg on every existing school-company pair
          $companies = get_users( array('role' => 'company') );
          $schools = get_users( array('role' => 'school') );
          for($i=0; $i<count($companies); $i++){
            $yritys_id = $companies[$i]->ID;
            if(company_answers_exist($yritys_id)){
              for($ii=0; $ii<count($schools); $ii++){
                $koulu_id = $schools[$ii]->ID;
                if(school_answers_exist($koulu_id, $yritys_id)){
                  //echo ' Result for match_alg_test(' . $yritys_id . ', ' . $koulu_id . '): ' . match_alg_test($yritys_id, $koulu_id) . '% <br>';
                  echo  'Company: "' . $companies[$i]->data->user_login . '" has match for school: "' . $schools[$ii]->data->user_login .
                          '" with the result: ' . match_alg_test($yritys_id, $koulu_id) . '% <br>';
                }
              }
              echo '<br>';
            }
          }
        }

        // buttons
        $school_id = 1;
        $company_id = 1;
        $question_id_first = 1;
        $question_id_last = 23;
        if(isset($_POST['special_test'])){
          $school_id = $_POST['school_id'];
          $company_id = $_POST['company_id'];
          $question_id_first = $_POST['question_id_first'];
          $question_id_last = $_POST['question_id_last'];
          unset($_POST['special_test']);
        }
        echo '<form name="post" action="' . admin_url( 'admin.php?page=pilot_test' ) . '" method="post">
          <input type="hidden" name="special_test" value="true">
          <br>Company id<input type="number" name="company_id" value="' . $company_id . '">
          <br>School id<input type="number" name="school_id" value="' . $school_id . '">
          <br>First question id<input type="number" name="question_id_first" value="' . $question_id_first . '">
          <br>Last question id<input type="number" name="question_id_last" value="' . $question_id_last . '">
          <input type="submit" value="Special test" ></form>';
        echo '<form name="post" action="' . admin_url( 'admin.php?page=pilot_test' ) . '" method="post"> <input type="hidden" name="gen_data" value="true"> <input type="submit" value="Generate dynamic data" ></form>';
        echo '<form name="post" action="' . admin_url( 'admin.php?page=pilot_test' ) . '" method="post"> <input type="hidden" name="gen_data_x10" value="true"> <input type="submit" value="Generate dynamic data x10" ></form>';
        echo '<form name="post" action="' . admin_url( 'admin.php?page=pilot_test' ) . '" method="post"> <input type="hidden" name="des_data" value="true"> <input type="submit" value="Reset db and destroy all dummy data including users" ></form>';
      }
      else{
        create_data_base();
        echo ' Creating the base dummy data, refresh page to see tests';
      }
    ?>
    </div>
    <?php
}

// exist function to check if base data exists in db
function data_exist(){
  global $wpdb;
  $table_name = $wpdb->prefix . 'School_answer';
  $result = $wpdb->get_results("SELECT * FROM $table_name");
  if(count($result) == 0)
    return false;
  else
    return true;
}
// exist functions to check right data exist before trying to calculate match
function school_answers_exist($school_id, $company_id){
  global $wpdb;
  $table_name = $wpdb->prefix . 'School_answer';
  $result = $wpdb->get_results("SELECT * FROM $table_name WHERE school_id=$school_id AND company_id=$company_id");
  if(count($result) == 23)
    return true;
  else
    return false;
}
function company_answers_exist($company_id){
  global $wpdb;
  $table_name = $wpdb->prefix . 'Company_answer';
  $result = $wpdb->get_results("SELECT * FROM $table_name WHERE company_id=$company_id");
  if(count($result) == 23)
    return true;
  else
    return false;
}

// hardcoded base data - users created here are not removed anywhere
// yritys3 and koulu4 have no answers set to them
function create_data_base(){
  
  $userdata = array(
    'user_login' => 'yritys',
    'user_pass' => 'yritys',
    'user_email' => 'yritys@yritys.com',
    'role' => 'company',
    'description' => 'Olen yrityksen tiedot!'
  );
  wp_insert_user($userdata);

  $userdata = array(
    'user_login' => 'yritys2',
    'user_pass' => 'yritys',
    'user_email' => 'yritys2@yritys2.com',
    'role' => 'company',
    'description' => 'Olen yrityksen yritys2 tiedot!'
  );
  wp_insert_user($userdata);

  $userdata = array(
    'user_login' => 'yritys3',
    'user_pass' => 'yritys',
    'user_email' => 'yritys3@yritys3.com',
    'role' => 'company',
    'description' => 'Olen yrityksen yritys3 tiedot!'
  );
  wp_insert_user($userdata);

  $userdata = array(
    'user_login' => 'koulu1',
    'user_pass' => 'koulu',
    'user_email' => 'koulu1@koulu1.com',
    'role' => 'school',
    'description' => 'Olen koulun koulu1 tiedot!'
  );
  wp_insert_user($userdata);

  $userdata = array(
    'user_login' => 'koulu2',
    'user_pass' => 'koulu',
    'user_email' => 'koulu2@koulu2.com',
    'role' => 'school',
    'description' => 'Olen koulun koulu2 tiedot!'
  );
  wp_insert_user($userdata);

  $userdata = array(
    'user_login' => 'koulu3',
    'user_pass' => 'koulu',
    'user_email' => 'koulu3@koulu3.com',
    'role' => 'school',
    'description' => 'Olen koulun koulu3 tiedot!'
  );
  wp_insert_user($userdata);

  $userdata = array(
    'user_login' => 'koulu4',
    'user_pass' => 'koulu',
    'user_email' => 'koulu4@koulu4.com',
    'role' => 'school',
    'description' => 'Olen koulun koulu4 tiedot!'
  );
  wp_insert_user($userdata);


  $userinfo = get_user_by('login', 'yritys');
  $yritys_id = $userinfo->ID;
  $userinfo = get_user_by('login', 'yritys2');
  $yritys2_id = $userinfo->ID;
  $userinfo = get_user_by('login', 'koulu1');
  $koulu1_id = $userinfo->ID;
  $userinfo = get_user_by('login', 'koulu2');
  $koulu2_id = $userinfo->ID;
  $userinfo = get_user_by('login', 'koulu3');
  $koulu3_id = $userinfo->ID;
  
  global $wpdb;
  $company_answer_table = $wpdb->prefix . 'Company_answer';
  $school_answer_table = $wpdb->prefix . 'School_answer';
  $wpdb->query(
    "INSERT INTO $company_answer_table VALUES
    (NULL, $yritys_id, 1, 4, 3, 1),
    (NULL, $yritys_id, 2, 4, 3, 1),
    (NULL, $yritys_id, 3, 4, 3, 1),
    (NULL, $yritys_id, 4, 4, 3, 1),
    (NULL, $yritys_id, 5, 4, 3, 1),
    (NULL, $yritys_id, 6, 4, 3, 1),
    (NULL, $yritys_id, 7, 4, 3, 1),
    (NULL, $yritys_id, 8, 4, 3, 1),
    (NULL, $yritys_id, 9, 4, 3, 1),
    (NULL, $yritys_id, 10, 4, 3, 1),
    (NULL, $yritys_id, 11, 4, 3, 1),
    (NULL, $yritys_id, 12, 4, 3, 1),
    (NULL, $yritys_id, 13, 4, 3, 1),
    (NULL, $yritys_id, 14, 4, 3, 1),
    (NULL, $yritys_id, 15, 4, 3, 1),
    (NULL, $yritys_id, 16, 4, 3, 1),
    (NULL, $yritys_id, 17, 4, 3, 1),
    (NULL, $yritys_id, 18, 4, 3, 1),
    (NULL, $yritys_id, 19, 4, 3, 1),
    (NULL, $yritys_id, 20, 4, 3, 1),
    (NULL, $yritys_id, 21, 4, 3, 1),
    (NULL, $yritys_id, 22, 4, 3, 1),
    (NULL, $yritys_id, 23, 4, 3, 1),
    
    (NULL, $yritys2_id, 1, 4, 3, 1),
    (NULL, $yritys2_id, 2, 5, 3, 2),
    (NULL, $yritys2_id, 3, 4, 2, 3),
    (NULL, $yritys2_id, 4, 4, 2, 1),
    (NULL, $yritys2_id, 5, 4, 3, 2),
    (NULL, $yritys2_id, 6, 4, 3, 3),
    (NULL, $yritys2_id, 7, 3, 2, 1),
    (NULL, $yritys2_id, 8, 3, 2, 2),
    (NULL, $yritys2_id, 9, 5, 3, 3),
    (NULL, $yritys2_id, 10, 4, 3, 1),
    (NULL, $yritys2_id, 11, 3, 2, 2),
    (NULL, $yritys2_id, 12, 3, 2, 3),
    (NULL, $yritys2_id, 13, 4, 3, 1),
    (NULL, $yritys2_id, 14, 5, 3, 2),
    (NULL, $yritys2_id, 15, 4, 2, 3),
    (NULL, $yritys2_id, 16, 4, 2, 1),
    (NULL, $yritys2_id, 17, 4, 3, 2),
    (NULL, $yritys2_id, 18, 4, 3, 3),
    (NULL, $yritys2_id, 19, 3, 2, 1),
    (NULL, $yritys2_id, 20, 3, 2, 2),
    (NULL, $yritys2_id, 21, 4, 3, 3),
    (NULL, $yritys2_id, 22, 5, 3, 1),
    (NULL, $yritys2_id, 23, 4, 2, 2)
    "
  );
    
  $wpdb->query(
    "INSERT INTO $school_answer_table VALUES
    (NULL, $koulu1_id, 1, $yritys_id, 4, 'kommentti1'),
    (NULL, $koulu1_id, 2, $yritys_id, 4, 'kommentti2'),
    (NULL, $koulu1_id, 3, $yritys_id, 4, 'kommentti3'),
    (NULL, $koulu1_id, 4, $yritys_id, 4, 'kommentti4'),
    (NULL, $koulu1_id, 5, $yritys_id, 4, 'kommentti5'),
    (NULL, $koulu1_id, 6, $yritys_id, 4, 'kommentti6'),
    (NULL, $koulu1_id, 7, $yritys_id, 4, 'kommentti7'),
    (NULL, $koulu1_id, 8, $yritys_id, 4, 'kommentti8'),
    (NULL, $koulu1_id, 9, $yritys_id, 4, 'kommentti9'),
    (NULL, $koulu1_id, 10, $yritys_id, 4, 'kommentti10'),
    (NULL, $koulu1_id, 11, $yritys_id, 4, 'kommentti11'),
    (NULL, $koulu1_id, 12, $yritys_id, 4, 'kommentti12'),
    (NULL, $koulu1_id, 13, $yritys_id, 4, 'kommentti13'),
    (NULL, $koulu1_id, 14, $yritys_id, 4, 'kommentti14'),
    (NULL, $koulu1_id, 15, $yritys_id, 4, 'kommentti15'),
    (NULL, $koulu1_id, 16, $yritys_id, 4, 'kommentti16'),
    (NULL, $koulu1_id, 17, $yritys_id, 4, 'kommentti17'),
    (NULL, $koulu1_id, 18, $yritys_id, 4, 'kommentti18'),
    (NULL, $koulu1_id, 19, $yritys_id, 4, 'kommentti19'),
    (NULL, $koulu1_id, 20, $yritys_id, 4, 'kommentti20'),
    (NULL, $koulu1_id, 21, $yritys_id, 4, 'kommentti21'),
    (NULL, $koulu1_id, 22, $yritys_id, 4, 'kommentti22'),
    (NULL, $koulu1_id, 23, $yritys_id, 4, 'kommentti23'),
    
    (NULL, $koulu2_id, 1, $yritys_id, 1, 'kommentti1'),
    (NULL, $koulu2_id, 2, $yritys_id, 2, 'kommentti2'),
    (NULL, $koulu2_id, 3, $yritys_id, 3, 'kommentti3'),
    (NULL, $koulu2_id, 4, $yritys_id, 4, 'kommentti4'),
    (NULL, $koulu2_id, 5, $yritys_id, 5, 'kommentti5'),
    (NULL, $koulu2_id, 6, $yritys_id, 1, 'kommentti6'),
    (NULL, $koulu2_id, 7, $yritys_id, 2, 'kommentti7'),
    (NULL, $koulu2_id, 8, $yritys_id, 3, 'kommentti8'),
    (NULL, $koulu2_id, 9, $yritys_id, 4, 'kommentti9'),
    (NULL, $koulu2_id, 10, $yritys_id, 5, 'kommentti10'),
    (NULL, $koulu2_id, 11, $yritys_id, 1, 'kommentti11'),
    (NULL, $koulu2_id, 12, $yritys_id, 2, 'kommentti12'),
    (NULL, $koulu2_id, 13, $yritys_id, 3, 'kommentti13'),
    (NULL, $koulu2_id, 14, $yritys_id, 4, 'kommentti14'),
    (NULL, $koulu2_id, 15, $yritys_id, 5, 'kommentti15'),
    (NULL, $koulu2_id, 16, $yritys_id, 1, 'kommentti16'),
    (NULL, $koulu2_id, 17, $yritys_id, 2, 'kommentti17'),
    (NULL, $koulu2_id, 18, $yritys_id, 3, 'kommentti18'),
    (NULL, $koulu2_id, 19, $yritys_id, 4, 'kommentti19'),
    (NULL, $koulu2_id, 20, $yritys_id, 5, 'kommentti20'),
    (NULL, $koulu2_id, 21, $yritys_id, 1, 'kommentti21'),
    (NULL, $koulu2_id, 22, $yritys_id, 2, 'kommentti22'),
    (NULL, $koulu2_id, 23, $yritys_id, 3, 'kommentti23'),
    
    (NULL, $koulu3_id, 1, $yritys_id, 3, 'kommentti1'),
    (NULL, $koulu3_id, 2, $yritys_id, 2, 'kommentti2'),
    (NULL, $koulu3_id, 3, $yritys_id, 3, 'kommentti3'),
    (NULL, $koulu3_id, 4, $yritys_id, 4, 'kommentti4'),
    (NULL, $koulu3_id, 5, $yritys_id, 5, 'kommentti5'),
    (NULL, $koulu3_id, 6, $yritys_id, 1, 'kommentti6'),
    (NULL, $koulu3_id, 7, $yritys_id, 3, 'kommentti7'),
    (NULL, $koulu3_id, 8, $yritys_id, 3, 'kommentti8'),
    (NULL, $koulu3_id, 9, $yritys_id, 4, 'kommentti9'),
    (NULL, $koulu3_id, 10, $yritys_id, 5, 'kommentti10'),
    (NULL, $koulu3_id, 11, $yritys_id, 1, 'kommentti11'),
    (NULL, $koulu3_id, 12, $yritys_id, 2, 'kommentti12'),
    (NULL, $koulu3_id, 13, $yritys_id, 3, 'kommentti13'),
    (NULL, $koulu3_id, 14, $yritys_id, 4, 'kommentti14'),
    (NULL, $koulu3_id, 15, $yritys_id, 3, 'kommentti15'),
    (NULL, $koulu3_id, 16, $yritys_id, 1, 'kommentti16'),
    (NULL, $koulu3_id, 17, $yritys_id, 2, 'kommentti17'),
    (NULL, $koulu3_id, 18, $yritys_id, 3, 'kommentti18'),
    (NULL, $koulu3_id, 19, $yritys_id, 4, 'kommentti19'),
    (NULL, $koulu3_id, 20, $yritys_id, 4, 'kommentti20'),
    (NULL, $koulu3_id, 21, $yritys_id, 1, 'kommentti21'),
    (NULL, $koulu3_id, 22, $yritys_id, 2, 'kommentti22'),
    (NULL, $koulu3_id, 23, $yritys_id, 3, 'kommentti23'),
    
    
    
    
    (NULL, $koulu1_id, 1, $yritys2_id, 4, 'kommentti1'),
    (NULL, $koulu1_id, 2, $yritys2_id, 4, 'kommentti2'),
    (NULL, $koulu1_id, 3, $yritys2_id, 4, 'kommentti3'),
    (NULL, $koulu1_id, 4, $yritys2_id, 4, 'kommentti4'),
    (NULL, $koulu1_id, 5, $yritys2_id, 4, 'kommentti5'),
    (NULL, $koulu1_id, 6, $yritys2_id, 4, 'kommentti6'),
    (NULL, $koulu1_id, 7, $yritys2_id, 4, 'kommentti7'),
    (NULL, $koulu1_id, 8, $yritys2_id, 4, 'kommentti8'),
    (NULL, $koulu1_id, 9, $yritys2_id, 4, 'kommentti9'),
    (NULL, $koulu1_id, 10, $yritys2_id, 4, 'kommentti10'),
    (NULL, $koulu1_id, 11, $yritys2_id, 4, 'kommentti11'),
    (NULL, $koulu1_id, 12, $yritys2_id, 4, 'kommentti12'),
    (NULL, $koulu1_id, 13, $yritys2_id, 4, 'kommentti13'),
    (NULL, $koulu1_id, 14, $yritys2_id, 4, 'kommentti14'),
    (NULL, $koulu1_id, 15, $yritys2_id, 4, 'kommentti15'),
    (NULL, $koulu1_id, 16, $yritys2_id, 4, 'kommentti16'),
    (NULL, $koulu1_id, 17, $yritys2_id, 4, 'kommentti17'),
    (NULL, $koulu1_id, 18, $yritys2_id, 4, 'kommentti18'),
    (NULL, $koulu1_id, 19, $yritys2_id, 4, 'kommentti19'),
    (NULL, $koulu1_id, 20, $yritys2_id, 4, 'kommentti20'),
    (NULL, $koulu1_id, 21, $yritys2_id, 4, 'kommentti21'),
    (NULL, $koulu1_id, 22, $yritys2_id, 4, 'kommentti22'),
    (NULL, $koulu1_id, 23, $yritys2_id, 4, 'kommentti23'),
    
    (NULL, $koulu2_id, 1, $yritys2_id, 1, 'kommentti1'),
    (NULL, $koulu2_id, 2, $yritys2_id, 2, 'kommentti2'),
    (NULL, $koulu2_id, 3, $yritys2_id, 3, 'kommentti3'),
    (NULL, $koulu2_id, 4, $yritys2_id, 4, 'kommentti4'),
    (NULL, $koulu2_id, 5, $yritys2_id, 5, 'kommentti5'),
    (NULL, $koulu2_id, 6, $yritys2_id, 1, 'kommentti6'),
    (NULL, $koulu2_id, 7, $yritys2_id, 2, 'kommentti7'),
    (NULL, $koulu2_id, 8, $yritys2_id, 3, 'kommentti8'),
    (NULL, $koulu2_id, 9, $yritys2_id, 4, 'kommentti9'),
    (NULL, $koulu2_id, 10, $yritys2_id, 5, 'kommentti10'),
    (NULL, $koulu2_id, 11, $yritys2_id, 1, 'kommentti11'),
    (NULL, $koulu2_id, 12, $yritys2_id, 2, 'kommentti12'),
    (NULL, $koulu2_id, 13, $yritys2_id, 3, 'kommentti13'),
    (NULL, $koulu2_id, 14, $yritys2_id, 4, 'kommentti14'),
    (NULL, $koulu2_id, 15, $yritys2_id, 5, 'kommentti15'),
    (NULL, $koulu2_id, 16, $yritys2_id, 1, 'kommentti16'),
    (NULL, $koulu2_id, 17, $yritys2_id, 2, 'kommentti17'),
    (NULL, $koulu2_id, 18, $yritys2_id, 3, 'kommentti18'),
    (NULL, $koulu2_id, 19, $yritys2_id, 4, 'kommentti19'),
    (NULL, $koulu2_id, 20, $yritys2_id, 5, 'kommentti20'),
    (NULL, $koulu2_id, 21, $yritys2_id, 1, 'kommentti21'),
    (NULL, $koulu2_id, 22, $yritys2_id, 2, 'kommentti22'),
    (NULL, $koulu2_id, 23, $yritys2_id, 3, 'kommentti23'),
    
    (NULL, $koulu3_id, 1, $yritys2_id, 3, 'kommentti1'),
    (NULL, $koulu3_id, 2, $yritys2_id, 2, 'kommentti2'),
    (NULL, $koulu3_id, 3, $yritys2_id, 3, 'kommentti3'),
    (NULL, $koulu3_id, 4, $yritys2_id, 4, 'kommentti4'),
    (NULL, $koulu3_id, 5, $yritys2_id, 5, 'kommentti5'),
    (NULL, $koulu3_id, 6, $yritys2_id, 1, 'kommentti6'),
    (NULL, $koulu3_id, 7, $yritys2_id, 3, 'kommentti7'),
    (NULL, $koulu3_id, 8, $yritys2_id, 3, 'kommentti8'),
    (NULL, $koulu3_id, 9, $yritys2_id, 4, 'kommentti9'),
    (NULL, $koulu3_id, 10, $yritys2_id, 5, 'kommentti10'),
    (NULL, $koulu3_id, 11, $yritys2_id, 1, 'kommentti11'),
    (NULL, $koulu3_id, 12, $yritys2_id, 2, 'kommentti12'),
    (NULL, $koulu3_id, 13, $yritys2_id, 3, 'kommentti13'),
    (NULL, $koulu3_id, 14, $yritys2_id, 4, 'kommentti14'),
    (NULL, $koulu3_id, 15, $yritys2_id, 3, 'kommentti15'),
    (NULL, $koulu3_id, 16, $yritys2_id, 1, 'kommentti16'),
    (NULL, $koulu3_id, 17, $yritys2_id, 2, 'kommentti17'),
    (NULL, $koulu3_id, 18, $yritys2_id, 3, 'kommentti18'),
    (NULL, $koulu3_id, 19, $yritys2_id, 4, 'kommentti19'),
    (NULL, $koulu3_id, 20, $yritys2_id, 4, 'kommentti20'),
    (NULL, $koulu3_id, 21, $yritys2_id, 1, 'kommentti21'),
    (NULL, $koulu3_id, 22, $yritys2_id, 2, 'kommentti22'),
    (NULL, $koulu3_id, 23, $yritys2_id, 3, 'kommentti23')
    "
  );
}

function create_data_dynamic(){
  // create new company and school
  $user_count = count_users();
  $user_1_num = $user_count['total_users'] + 1;
  $user_2_num = $user_count['total_users'] + 2;
  $user_1_name = 'yritys_gen_' . $user_1_num;
  $user_2_name = 'koulu_gen_' . $user_2_num;

  $userdata = array(
    'user_login' => $user_1_name,
    'user_pass' => 'yritys',
    'user_email' => $user_1_name . '@yritys.com',
    'role' => 'company',
    'description' => 'Olen yrityksen ' . $user_1_name . ' tiedot!'
  );
  wp_insert_user($userdata);

  $userdata = array(
    'user_login' => $user_2_name,
    'user_pass' => 'koulu',
    'user_email' => $user_2_name . '@koulu.com',
    'role' => 'school',
    'description' => 'Olen koulun ' . $user_2_name . ' tiedot!'
  );
  wp_insert_user($userdata);

  $userinfo = get_user_by('login', $user_1_name);
  $yritys_id = $userinfo->ID;
  $userinfo = get_user_by('login', $user_2_name);
  $koulu_id = $userinfo->ID;
  
  // create new company answers for new company
  $val_set_1 = array();
  $val_set_2 = array();
  $val_set_3 = array();

  $val_set_1[] = 1;
  $val_set_2[] = 1;
  $val_set_3[] = 1;

  // different company "personalities"
  // $val_set_#: 1= max, 2= min, 3= priority
  $dyn_val_type = rand(0, 4);
  switch($dyn_val_type){
    case 0:
    // high max
      for($i=0; $i<23; $i++){
        $val_set_1[] = rand(3, 5);
        $val_set_2[] = rand(1, 3);
        $val_set_3[] = rand(1, 3);
      }
      break;
    case 1:
    // somewhat low requirements
      for($i=0; $i<23; $i++){
        $val_set_1[] = rand(2, 4);
        $val_set_2[] = rand(1, 2);
        $val_set_3[] = rand(1, 3);
      }
      break;
    case 2:
      // always very low max and min 
        for($i=0; $i<23; $i++){
          $val_set_1[] = rand(2, 3);
          $val_set_2[] = rand(1, 2);
          $val_set_3[] = rand(1, 3);
        }
        break;
    case 3:
    // very high max score and potentially high min
      for($i=0; $i<23; $i++){
        $val_set_1[] = 5;
        $val_set_2[] = rand(1, 4);
        $val_set_3[] = rand(1, 3);
      }
      break;
    case 4:
    // "medium" requirements
      for($i=0; $i<23; $i++){
        $val_set_1[] = rand(3, 4);
        $val_set_2[] = rand(1, 3);
        $val_set_3[] = rand(1, 3);
      }
      break;
  }

  global $wpdb;
  $company_answer_table = $wpdb->prefix . 'Company_answer';
  $school_answer_table = $wpdb->prefix . 'School_answer';
  $wpdb->query( "INSERT INTO $company_answer_table VALUES
  (NULL, $yritys_id, 1, $val_set_1[1], $val_set_2[1], $val_set_3[1]),
  (NULL, $yritys_id, 2, $val_set_1[2], $val_set_2[2], $val_set_3[2]),
  (NULL, $yritys_id, 3, $val_set_1[3], $val_set_2[3], $val_set_3[3]),
  (NULL, $yritys_id, 4, $val_set_1[4], $val_set_2[4], $val_set_3[4]),
  (NULL, $yritys_id, 5, $val_set_1[5], $val_set_2[5], $val_set_3[5]),
  (NULL, $yritys_id, 6, $val_set_1[6], $val_set_2[6], $val_set_3[6]),
  (NULL, $yritys_id, 7, $val_set_1[7], $val_set_2[7], $val_set_3[7]),
  (NULL, $yritys_id, 8, $val_set_1[8], $val_set_2[8], $val_set_3[8]),
  (NULL, $yritys_id, 9, $val_set_1[9], $val_set_2[9], $val_set_3[9]),
  (NULL, $yritys_id, 10, $val_set_1[10], $val_set_2[10], $val_set_3[10]),
  (NULL, $yritys_id, 11, $val_set_1[11], $val_set_2[11], $val_set_3[11]),
  (NULL, $yritys_id, 12, $val_set_1[12], $val_set_2[12], $val_set_3[12]),
  (NULL, $yritys_id, 13, $val_set_1[13], $val_set_2[13], $val_set_3[13]),
  (NULL, $yritys_id, 14, $val_set_1[14], $val_set_2[14], $val_set_3[14]),
  (NULL, $yritys_id, 15, $val_set_1[15], $val_set_2[15], $val_set_3[15]),
  (NULL, $yritys_id, 16, $val_set_1[16], $val_set_2[16], $val_set_3[16]),
  (NULL, $yritys_id, 17, $val_set_1[17], $val_set_2[17], $val_set_3[17]),
  (NULL, $yritys_id, 18, $val_set_1[18], $val_set_2[18], $val_set_3[18]),
  (NULL, $yritys_id, 19, $val_set_1[19], $val_set_2[19], $val_set_3[19]),
  (NULL, $yritys_id, 20, $val_set_1[20], $val_set_2[20], $val_set_3[20]),
  (NULL, $yritys_id, 21, $val_set_1[21], $val_set_2[21], $val_set_3[21]),
  (NULL, $yritys_id, 22, $val_set_1[22], $val_set_2[22], $val_set_3[22]),
  (NULL, $yritys_id, 23, $val_set_1[23], $val_set_2[23], $val_set_3[23])
  "
  );

  // create new users reviews for all companies (by the new school)
  $companies = get_users( array('role' => 'company') );
  for($ii=0; $ii<count($companies); $ii++){
    $yritys_id = $companies[$ii]->ID;
    $val_set = array();
    $val_set[] = 0;

    // different scoring "personalities" on every review
    $dyn_val_type = rand(0, 6);
    switch($dyn_val_type){
      case 0:
      // completely random scores
        for($i=0; $i<23; $i++){
          $val_set[] = rand(1, 5);
        }
        break;
      case 1:
      // mainly bad scores
        for($i=0; $i<23; $i++){
          if(rand(0, 2) < 2)
            $val_set[] = rand(1, 2);
          else
            $val_set[] = rand(1, 5);
        }
        break;
      case 2:
      // mainly good scores
        for($i=0; $i<23; $i++){
          if(rand(0, 2) < 2)
            $val_set[] = rand(4, 5);
          else
            $val_set[] = rand(1, 5);
        }
        break;
      case 3:
      // mainly the score 3
        for($i=0; $i<23; $i++){
          if(rand(0, 2) < 2)
            $val_set[] = 3;
          else
            $val_set[] = rand(1, 5);
        }
        break;
      case 4:
      // always bad scores
        for($i=0; $i<23; $i++){
          $val_set[] = rand(1, 2);
        }
        break;
      case 5:
      // always good scores
        for($i=0; $i<23; $i++){
          $val_set[] = rand(4, 5);
        }
        break;
      case 6:
      // always max scores
        for($i=0; $i<23; $i++){
          $val_set[] = 5;
        }
        break;
    }

    $wpdb->query(
      "INSERT INTO $school_answer_table VALUES
      (NULL, $koulu_id, 1, $yritys_id, $val_set[1], 'kommentti1'),
      (NULL, $koulu_id, 2, $yritys_id, $val_set[2], 'kommentti2'),
      (NULL, $koulu_id, 3, $yritys_id, $val_set[3], 'kommentti3'),
      (NULL, $koulu_id, 4, $yritys_id, $val_set[4], 'kommentti4'),
      (NULL, $koulu_id, 5, $yritys_id, $val_set[5], 'kommentti5'),
      (NULL, $koulu_id, 6, $yritys_id, $val_set[6], 'kommentti6'),
      (NULL, $koulu_id, 7, $yritys_id, $val_set[7], 'kommentti7'),
      (NULL, $koulu_id, 8, $yritys_id, $val_set[8], 'kommentti8'),
      (NULL, $koulu_id, 9, $yritys_id, $val_set[9], 'kommentti9'),
      (NULL, $koulu_id, 10, $yritys_id, $val_set[10], 'kommentti10'),
      (NULL, $koulu_id, 11, $yritys_id, $val_set[11], 'kommentti11'),
      (NULL, $koulu_id, 12, $yritys_id, $val_set[12], 'kommentti12'),
      (NULL, $koulu_id, 13, $yritys_id, $val_set[13], 'kommentti13'),
      (NULL, $koulu_id, 14, $yritys_id, $val_set[14], 'kommentti14'),
      (NULL, $koulu_id, 15, $yritys_id, $val_set[15], 'kommentti15'),
      (NULL, $koulu_id, 16, $yritys_id, $val_set[16], 'kommentti16'),
      (NULL, $koulu_id, 17, $yritys_id, $val_set[17], 'kommentti17'),
      (NULL, $koulu_id, 18, $yritys_id, $val_set[18], 'kommentti18'),
      (NULL, $koulu_id, 19, $yritys_id, $val_set[19], 'kommentti19'),
      (NULL, $koulu_id, 20, $yritys_id, $val_set[20], 'kommentti20'),
      (NULL, $koulu_id, 21, $yritys_id, $val_set[21], 'kommentti21'),
      (NULL, $koulu_id, 22, $yritys_id, $val_set[22], 'kommentti22'),
      (NULL, $koulu_id, 23, $yritys_id, $val_set[23], 'kommentti23')
    "
    );
  }
}

function destroy_data(){
  // go through usual db clear
  jal_uninstall();
  jal_install();

  // destroy dummy school accounts
  $schools = get_users( array('role' => 'school') );
  for($i=0; $i<count($schools); $i++){
    $school_name = explode('_', $schools[$i]->data->user_login);
    if(count($school_name)>2 && $school_name[0] == 'koulu' && $school_name[1] == 'gen'){
      wp_delete_user($schools[$i]->ID);
    }
    else if($school_name[0] == 'koulu1' || $school_name[0] == 'koulu2' || $school_name[0] == 'koulu3' || $school_name[0] == 'koulu4'){
      wp_delete_user($schools[$i]->ID);
    }
  }

  // destroy dummy company accounts
  $companies = get_users( array('role' => 'company') );
  for($i=0; $i<count($companies); $i++){
    $company_name = explode('_', $companies[$i]->data->user_login);
    if(count($company_name)>2 && $company_name[0] == 'yritys' && $company_name[1] == 'gen'){
      wp_delete_user($companies[$i]->ID);
    }
    else if($company_name[0] == 'yritys' || $company_name[0] == 'yritys2' || $company_name[0] == 'yritys3'){
      wp_delete_user($companies[$i]->ID);
    }
  }
}