<?php
/**
* Plugin Name: WA Rotator by Pesan.link
* Description: Plugins WA Rotator Gratis
* Version:     1.1.3
* Plugin URI: https://jogjaitclinic.com/warotator-plugin
* Author: Development Team Pesan.Link (Akli-Fiqup)
* Author URI:  https://pesan.link/
* License:     GPLv2 or later
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain: wpbc
* Domain Path: /languages
*/

defined( 'ABSPATH' ) or die( '¡Sin trampas!' );

function rotatorinit(){
    if(isset($_GET['warotator'])) {
        loading1();
        wa_link_page();
      }

}

add_action('init', 'rotatorinit');


require plugin_dir_path( __FILE__ ) . 'includes/metabox-p1.php';    

function wpbc_custom_admin_styles() {
    wp_enqueue_style('custom-styles', plugins_url('/css/styles.css', __FILE__ ));
    }
add_action('admin_enqueue_scripts', 'wpbc_custom_admin_styles');


function wpbc_plugin_load_textdomain() {
load_plugin_textdomain( 'wpbc', false, basename( dirname( __FILE__ ) ) . '/languages' ); 
}
add_action( 'plugins_loaded', 'wpbc_plugin_load_textdomain' );


global $wpbc_db_version;
$wpbc_db_version = '1.1.0'; 


function wpbc_install()
{
    global $wpdb;
    global $wpbc_db_version;

    $table_name = $wpdb->prefix . 'datacs'; 


    $sql = "CREATE TABLE " . $table_name . " (
      id int(11) NOT NULL,
      name VARCHAR (50) NOT NULL,
      phone VARCHAR(15) NOT NULL,
      click int(11) NOT NULL,
      note text NOT NULL,
      PRIMARY KEY  (phone)
    );";


    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    $table_name2 = $wpdb->prefix . 'data_performa'; 


    $sql = "CREATE TABLE " . $table_name2 . " (
        time DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
      phone VARCHAR(15) NOT NULL,
     // FOREIGN KEY (phone) REFERENCES ".$table_name."(phone)
        INDEX `phone` (`phone`),
        CONSTRAINT {$table_name2} FOREIGN KEY (`phone`)
        REFERENCES {$table_name} (`phone`) ON DELETE CASCADE ON UPDATE CASCADE
    );";


    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    add_option('wpbc_db_version', $wpbc_db_version);

    $installed_ver = get_option('wpbc_db_version');
    if ($installed_ver != $wpbc_db_version) {
        $sql = "CREATE TABLE " . $table_name . " (
          id int(11) NOT NULL,
          name VARCHAR (50) NOT NULL,
          phone VARCHAR(15) NOT NULL,
          PRIMARY KEY  (phone)
        );";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        $sql = "CREATE TABLE " . $table_name2 . " (
            time DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
          phone VARCHAR(15) NOT NULL,
          //FOREIGN KEY (phone) REFERENCES ".$table_name."(phone)
            INDEX `phone` (`phone`),
            CONSTRAINT {$table_name2} FOREIGN KEY (`phone`)
            REFERENCES {$table_name} (`phone`) ON DELETE CASCADE ON UPDATE CASCADE
        );";
    
    
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        update_option('wpbc_db_version', $wpbc_db_version);
    }
}

register_activation_hook(__FILE__, 'wpbc_install');


function wpbc_install_data()
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'datacs'; 
    $table_name2 = $wpdb->prefix . 'data_performa'; 

}

register_activation_hook(__FILE__, 'wpbc_install_data');


function wpbc_update_db_check()
{
    global $wpbc_db_version;
    if (get_site_option('wpbc_db_version') != $wpbc_db_version) {
        wpbc_install();
    }
}

add_action('plugins_loaded', 'wpbc_update_db_check');



if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}


class Custom_Table_Example_List_Table extends WP_List_Table
 { 
    function __construct()
    {
        global $status, $page;

        parent::__construct(array(
            'singular' => 'contact',
            'plural'   => 'contacts',
        ));
        wpbc_page_handler_link();
    }


    function column_default($item, $column_name)
    {
        return $item[$column_name];
    }


    function column_phone($item)
    {
        return '<em>' . $item['phone'] . '</em>';
    }

    function column_id($item)
    {
        

        return '</em>' . $item['id'] . '</em>';
    }

    function column_click($item)
    {
        

        return '</em>' . $item['click'] . '</em>';
    }


    function column_name($item)
    {

        $actions = array(
            'edit' => sprintf('<a href="?page=contacts_form&id=%s">%s</a>', $item['id'], __('Edit', 'wpbc')),
            'delete' => sprintf('<a href="?page=%s&action=delete&id=%s">%s</a>', $_REQUEST['page'], $item['id'], __('Delete', 'wpbc')),
        );

        return sprintf('%s %s',
            $item['name'],
            $this->row_actions($actions)
        );
    }


    function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="id[]" value="%s" />', 
            $item['id']
        );
    }

    function get_columns()
    {
        $columns = array(
            'cb' => '<input type="checkbox" />', 
            'id'     => __('Id', 'wpbc'),
            'name'      => __('Name', 'wpbc'),
            'phone'     => __('Phone', 'wpbc'),
            'click'     => __('Hits', 'wpbc'),


        );
        return $columns;
    }

    function get_sortable_columns()
    {
        $sortable_columns = array(
            'id'     => array('id', true),
            'name'      => array('name', true),
            'phone'     => array('phone', true),
            'click'     => array('click', true),
        );
        return $sortable_columns;
    }

    function get_bulk_actions()
    {
        $actions = array(
            'delete' => 'Delete'
        );
        return $actions;
    }

    function process_bulk_action()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'datacs'; 

        if ('delete' === $this->current_action()) {
            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
            $firstId=$ids[0];
            $lastId=$ids[0];
            if (is_array($ids)){ 
                $firstId= $ids[0];
                $lastId = end($ids);
                $ids = implode(',', $ids);
            };

            if (!empty($ids)) {
                $user_count = $wpdb->get_var( 
                    "SELECT COUNT(*) 
                    FROM {$wpdb->prefix}datacs" );
                $wpdb->query("DELETE FROM $table_name WHERE id IN($ids)");
                $j=$firstId;
                for ($i=$lastId; $i < $user_count ; $i++) {
                    $wpdb->query("UPDATE $table_name SET id = $j WHERE id = ".($i+1));
                    $j++;
                }
            }
        }
    }

    function prepare_items()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'datacs'; 

        $per_page = 10; 

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        
        $this->_column_headers = array($columns, $hidden, $sortable);
       
        $this->process_bulk_action();
        
        $total_items = $wpdb->get_var("SELECT COUNT(id) FROM $table_name");


        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'name';
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'asc';


        $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);


        $this->set_pagination_args(array(
            'total_items' => $total_items, 
            'per_page' => $per_page,
            'total_pages' => ceil($total_items / $per_page) 
        ));
    }
}

function wpbc_admin_menu()
{
    add_menu_page(__('WA Rotator', 'wpbc'), __('WA Rotator', 'wpbc'), 'activate_plugins', 'contacts', 'wpbc_contacts_page_handler');
    
    add_submenu_page('contacts', __('Contact ', 'wpbc'), __('Contact ', 'wpbc'), 'activate_plugins', 'contacts', 'wpbc_contacts_page_handler');
   
    add_submenu_page('contacts', __('Add new', 'wpbc'), __('Add new', 'wpbc'), 'activate_plugins', 'contacts_form', 'wpbc_contacts_form_page_handler');

    
}

add_action('admin_menu', 'wpbc_admin_menu');


function wpbc_validate_contact($item)
{
    $messages = array();

    if (empty($item['name'])) $messages[] = __('Name is required', 'wpbc');
    if(!empty($item['phone']) && !absint(intval($item['phone'])))  $messages[] = __('Phone can not be less than zero');
    if(!empty($item['phone']) && !preg_match('/[0-9]+/', $item['phone'])) $messages[] = __('Phone must be number');
    

    if (empty($messages)) return true;
    return implode('<br />', $messages);
}


function wpbc_languages()
{
    load_plugin_textdomain('wpbc', false, dirname(plugin_basename(__FILE__)));
}

add_action('init', 'wpbc_languages');

function wpbc_page_handler_link(){ 
    
    ?>
    <html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Copy Clipboard</title>
        <style type="text/css">
 
    h4 {
        font-size: 25px;
    }
    input[type="text"],
    button[type="button"] {
        padding: 10px 15px;
        font-size: 16px;
        border-radius: 5px;
    }
    input[type="text"] {
        width: 330px;
        border: 1px solid #bbb;
    }
      button[type="button"] {
        background: #A9A9A9;
        border: 1px solid #A9A9A9;
        color: #fff;
        cursor: pointer;
    }
</style>
    </head>
    

    <body>
        <h4>Wa Rotator</h4>
        <input type="text" value="<?php echo get_site_url();?>?warotator" id="pilih" readonly />
        <button type="button" onclick="copy_text()">Copy</button>
    </body>
</html>
<script type="text/javascript">
    function copy_text() {
        document.getElementById("pilih").select();
        document.execCommand("copy");
        alert("Text berhasil dicopy");
    }
</script>

    
 <br> <br> <?php
}

add_shortcode('whatsup-plugin', 'wa_link_page');

function wa_link_page(){
    $url = waUrl();
    echo "<meta content=1;url=".$url." http-equiv='refresh'/>" ;
    exit;
 
 }



function wpbc_page_handler_data(){

    global $wpdb;
    
    $results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}datacs as datacs LEFT JOIN {$wpdb->prefix}data_performa  as data_performa
                                    ON datacs.phone = data_performa.phone 
                                    ORDER BY data_performa.time DESC");
    table_users($results);
    return $results;
}

add_shortcode('data_statistik', 'wpbc_page_handler_data');


function waUrl(){
    
    global $konten; 
    global $nilai;
    global $wpdb;

    $user_count = $wpdb->get_var( 
    "SELECT COUNT(*) 
    FROM {$wpdb->prefix}datacs" );

    //jumlah total akun user
    $total=$user_count; 

    //dataklik
    $namaFile = 'data1.txt';
    $nilai = file_get_contents($namaFile);
        
    if($nilai >= $total){
        $konten = '1';
        
    }else{
        $konten = $nilai + 1;
    }

    $file = fopen($namaFile, 'w');
    fwrite($file, $konten);
    fclose($file);
    
    $id=$konten;
    $kontak = $wpdb->get_var( $wpdb->prepare
    ( "SELECT phone from {$wpdb->prefix}datacs 
    where id = %d", $id ) 
    );

    $pesan = $wpdb->get_var( $wpdb->prepare
    ( "SELECT note from {$wpdb->prefix}datacs 
    where id = %d", $id ) 
    );

    $click = $wpdb->get_var($wpdb-> prepare
    ( "SELECT click from {$wpdb->prefix}datacs 
    where id = %d", $id ) 
    );

    $data_performa = $wpdb->prefix . 'data_performa';
    $item['phone'] = $kontak;
    $result = $wpdb->insert($data_performa, $item);
  

    $wpdb->query("UPDATE {$wpdb->prefix}datacs SET 
         `click` = ($click + 1)
       WHERE `phone` = '$kontak'");
       
       $text_encode=urlencode("$pesan");

    return 'https://api.whatsapp.com/send?phone='.$kontak.'&text='.  $text_encode;
    
    
}


function loading1(){
    ?>
    
   
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-163101343-1"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'UA-163101343-1');
		</script>
		
        <title>Loading</title>
    </head>
    <body>

        <style>
        .container {
        height: 200px;
        position: relative;
        }

        .vertical-center {
        margin: 0;
        position: absolute;
        top: 50%;
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
        }
        </style>

        <div class="container">
        <div class="vertical-center">
            
        </div>
        </div>
        
        <div style="margin:0 auto; justify-content: center; align-items: center; display: flex; ">
        
            <div class="loadingio-spinner-bars-aettok4qpsb"><div class="ldio-vrxw6qn0iq">
            <div></div><div></div><div></div><div></div>
            </div></div>
            <style type="text/css">
            @keyframes ldio-vrxw6qn0iq {
            0% { opacity: 1 }
            50% { opacity: .5 }
            100% { opacity: 1 }
            }
            .ldio-vrxw6qn0iq div {
            position: absolute;
            width: 10px;
            height: 40px;
            top: 60px;
            animation: ldio-vrxw6qn0iq 1s cubic-bezier(0.5,0,0.5,1) infinite;
            }.ldio-vrxw6qn0iq div:nth-child(1) {
            transform: translate(30px,0);
            background: #157759;
            animation-delay: -0.6s;
            }.ldio-vrxw6qn0iq div:nth-child(2) {
            transform: translate(70px,0);
            background: #53ab8b;
            animation-delay: -0.4s;
            }.ldio-vrxw6qn0iq div:nth-child(3) {
            transform: translate(110px,0);
            background: #82dbb8;
            animation-delay: -0.2s;
            }.ldio-vrxw6qn0iq div:nth-child(4) {
            transform: translate(150px,0);
            background: #a2fdd9;
            animation-delay: -1s;
            }
            .loadingio-spinner-bars-aettok4qpsb {
            width: 200px;
            height: 200px;
            display: inline-block;
            overflow: hidden;
            background: none;
            }
            .ldio-vrxw6qn0iq {
            width: 100%;
            height: 100%;
            position: relative;
            transform: translateZ(0) scale(1);
            backface-visibility: hidden;
            transform-origin: 0 0; /* see note above */
            }
            .ldio-vrxw6qn0iq div { box-sizing: content-box; }
            /* generated by https://loading.io/ */
            </style>
            
        </div>

        <div style="margin:0 auto; justify-content: center; align-items: center; display: flex; ">
        <h3>loading...</h3>
        </div>

  

    </body>
    </html>
       
    <?php
}





















