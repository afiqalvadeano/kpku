<?php
function prefix_enqueue() 
{       
    // JS
    wp_register_script('prefix_bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js');
    wp_enqueue_script('prefix_bootstrap');

    // CSS
    wp_register_style('prefix_bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css');
    wp_enqueue_style('prefix_bootstrap');
}

    $data = $wpdb->get_results("SELECT * FROM wp_cf_form_entry_values where slug='nama'||slug='nomor_whatsapp'||slug='email'");
    function wpbc_custom_admin_styles() {
        wp_enqueue_style('custom-styles', plugins_url('/style.css', __FILE__ ));
        }

function whatsapp($atts){
    $nohp = get_option('wa_nohp');
    $pesan = get_option('wa_pesan');
    $text = get_option('wa_text');
    $var = shortcode_atts(
        array(
            'nohp' => $nohp,
            'pesan' => $pesan,
            'text' => $text
        ),$atts
    );
    return '<a href="https://wa.me/'.$var['nohp'].'?text='.urlencode($var['pesan']).'" target="_blank">'.$var['text'].'</a>';
}
add_shortcode('whatsapp','whatsapp');
add_action('wp_head','head_code');
function head_code()
{

$output = '<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>';    
$output .= '<script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>'; 
$output .= '<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>';

echo $output;

}