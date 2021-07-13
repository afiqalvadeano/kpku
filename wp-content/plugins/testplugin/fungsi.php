<?php
function testmenuadmin() {
    add_menu_page('Setting Plugin View Caldera Forms','View Caldera Forms',' ','testmenu','fungsi_testmenu','dashicons-welcome-learn-more');
    add_submenu_page('testmenu','Sub Menu Setting','Sub Setting','manage_options','subtestmenu','fungsi_testmenu');
    add_submenu_page('testmenu','Tambah Member Baru','View','manage_options','tambahmember','tambahmember');
}
function fungsi_testmenu() {
    if ($_POST['pesan'] != ''){
        update_option('wa_pesan',$_POST['pesan']);
        echo 'Update Berhasil';
    }
    echo '<h2> Setting Plugin View Caldera Forms </h2>
    
    <form action="" method="post">
    Pesan Default : <input type="text" name="pesan" value="'.get_option('wa_pesan').'"/><br>

    <input type="submit" value ="Update Data"/>
    </form>';
}

function tambahmember() {
    global $wpdb;
    include('tambahmember.php');
}

function submenupertama(){
    echo '<h2>Setting Sub Menu</h2>';
    echo '<p>Ini adalah contoh sub menu</p>';
}

add_action('admin_menu','testmenuadmin');

function fungsi_iklan(){
    $show = 'Ini adalah iklan';
    return $show;
   
}
add_shortcode('iklan','fungsi_iklan');
// function prefix_enqueue() 
// {       
//     // JS
//     wp_register_script('prefix_bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js');
//     wp_enqueue_script('prefix_bootstrap');

//     // CSS
//     wp_register_style('prefix_bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css');
//     wp_enqueue_style('prefix_bootstrap');


// }

function assets(){
    // wp_enqueue_style( 'my-css', plugins_url( 'style.css'.__FILE__ ) );
    // wp_enqueue_script( 'my-js', plugins_url( 'script,js'.__FILE__ ) );

    // Bootstrap 5
    wp_register_style('prefix_bootstrap5', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css');
    wp_enqueue_style('prefix_bootstrap5');

    // Ajax 
    wp_register_script('prefix_jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js');
    wp_enqueue_script('prefix_jquery');

    // // Select 2 CSS
    // wp_register_style('prefix_selectcss', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css');
    // wp_enqueue_style('prefix_selectcss');

    // // Select 2 JS
    // wp_register_script('prefix_selectjs', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js');
    // wp_enqueue_script('prefix_selectjs');

}
add_action( 'admin_init', 'assets' );


function whatsapp($atts){
    $pesan = get_option('wa_pesan');
    $var = shortcode_atts(['pesan' => $pesan], $atts);
    return '<a href="https://wa.me/'.$var['nohp'].'?text='.urlencode($var['pesan']).'" target="_blank">'.$var['text'].'</a>';
}
add_shortcode('whatsapp','whatsapp');
// add_action('wp_head','head_code');

// function head_code() {
//     $output = '<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>';    
//     $output .= '<script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>'; 
//     $output .= '<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>';
//     echo $output;
// }