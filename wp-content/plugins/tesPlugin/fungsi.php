<?php



// function testmenuadmin() {
//     add_menu_page('Setting Plugin View Caldera Forms','Setting Plugin','manage_options','testmenu','fungsi_testmenu','dashicons-welcome-learn-more');
// }
// function fungsi_testmenu() {
//     echo '<h2> Setting Plugin View Caldera Forms/<h2>';
// }

// add_action('admin_menu','testmenuadmin');


function fungsi_tampil(){
    
include('auth.php');

    
}
add_shortcode('tampil','fungsi_tampil');
