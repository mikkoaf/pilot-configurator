<?php
// Deny direct access to this file
if ( ! defined( 'ABSPATH' ) ) {
  die( ' Access denied!' );
}

function add_inno_user_roles() {
  add_role( 'school', __( 'School' ),
            array(
              'read'       => true,
              'edit_posts' => false,
            )
          );
  add_role( 'company', __( 'Company' ),
            array(
              'read'       => true,
              'edit_posts' => false,
            )
          );
}

function remove_inno_user_roles() {
  remove_role( 'school' );
  remove_role( 'company' );
}
