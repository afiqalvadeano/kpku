<?php
// /**
//  * Custom auth for requests to read entries of form with ID CF60ae8484c7aae
//  *
//  * For API endpoint that powers front-end entry viewer.
//  */
// add_filter( 'caldera_forms_api_allow_entry_view', function( $allowed, $form_id, WP_REST_Request $request ){
//     if( 'CF60ae8484c7aae' === $form_id ){
//         //Create your own system for checking authorization, using current request.
//         $allowed = some_custom_auth_function( $request );
//     }
//     return $allowed;
// }, 10, 3 );
$form = Caldera_Forms_Forms::get_form( 'CF60ae8484c7aae' );
if ( is_array( $form ) ) {
    echo Caldera_Forms_Entry_Viewer::form_entry_viewer_2($form);
}