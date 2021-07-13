<?php
/**
 * Load Caldera Forms API client
 *
 * Requires Caldera Forms 1.5 or later
 *
 * With support for a lower user role
 */
add_action( 'wp_enqueue_scripts', function(){
	//change this to your form ID
	$form_id = 'CF60a2be590b5be';
	//load api client JavaScript
	Caldera_Forms_Render_Assets::enqueue_script(  '03f803abd00eebdde61258a04487c81c' );
	//Print useful info to DOM
	$config = new Caldera_Forms_API_JsConfig( Caldera_Forms_Forms::get_form( $form_id ) );
	$data = $config->toArray();

	//Will allow for viewing by a user of editor role or higher
	$data[ 'api' ][ 'token' ] = Caldera_Forms_API_Token::make_token( 'editor', $form_id );
	wp_localize_script( Caldera_Forms_Render_Assets::make_slug( '03f803abd00eebdde61258a04487c81c' ), 'MYOBJ', $data );
});
