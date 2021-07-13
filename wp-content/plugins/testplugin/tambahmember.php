<!-- <h2>Tambah Member </h2> -->
<!-- <?php
// if (isset($_POST) && $_POST['nama'] != '' && $_POST['email'] != '') {
//     $wpdb->query("INSERT INTO 'anggota' ('id_wp','tgl_pendaftaran','nama','email','tgl_lahir','no_hp','alamat','kota','provinsi') 
//     VALUES (1,
//     NOW(),
//     '".$_POST['nama']."',
//     '".$_POST['email']."',
//     '".$_POST['tgl_lahir']."',
//     '".$_POST['no_hp']."',
//     '".$_POST['alamat']."',
//     '".$_POST['kota']."',
//     '".$_POST['provinsi']."')"); //CRUD
//     echo 'Tambah Member Berhasil';
// }
    //?>
<form action="" method="post">
    Nama: <input type="text" name="nama"/><br/>
    Email: <input type="text" name="email"/><br/>
    Tanggal Lahir: <input type="txt" name="tgl_lahir"/><br/>
    Nomor HP: <input type="text" name="no_hp"/><br/>
    Alamat: <input type="text" name="alamat"/><br/>
    Kota: <input type="text" name="kota"/><br/>
    Provinsi: <input type="text" name="provinsi"/><br/>
    <input type="submit" value="Tambah Member"/>
</form>  -->
<?php
get_header();?>

<?php
    $slug = $wpdb->get_results("SELECT DISTINCT slug FROM wp_cf_form_entry_values");
    $data = $wpdb->get_results("SELECT * FROM wp_cf_form_entry_values where slug='nama'||slug='nomor_whatsapp'||slug='email'");
    // function wpbc_custom_admin_styles() {
    //     wp_enqueue_style('custom-styles', plugins_url('/style.css', __FILE__ ));
    //     }
?>
  <?php

//load script
function theme_wp_scripts(){
	// bootstrap
	wp_enqueue_style('bootstrap-style', get_template_directory_uri() . '/css/bootstrap.min.css');
	// style.css
	wp_enqueue_style('style', get_stylesheet_uri());

	// javascript
	// jquery plugin
	//wp_enqueue_script('jquery-script', get_template_directory_uri() . '/js/1.8.2.jquery.min', array(), '', true);
	//wp_enqueue_script('bootstrap-script', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '', true);
}

add_action('wp_enqueue_scripts', 'theme_wp_scripts');


?> 

<button id="hai">haiii</button>

<table class="table tes">
    <thead>
        <tr>

            <th border=10>Nama</th>
            <th>Email</th>
            <th>No Whatsapp</th>
            <th> </th>
        <tr>
    </thead>
    <tbody>
         <?php
        //  var_dump(sizeof($data));
        //  die;
            for($i=0; $i<count($data); $i++) { 
                $e = 1;
                if($data[$i]->slug == "nomor_whatsapp") { ?>
                        <td><?= $data[$i]->value ?></td>
                        <td>
                        <a class="btn btn-primary" href="https://wa.me/<?= $data[$i]->value ?>?text=<?=get_option('wa_pesan');?>"><button>Whatsapp</button></a>
                        </td>
                    <tr>
                <?php } else { 
                    if($data[$i]->value != "") { ?>
                        <td><?= $data[$i]->value?></td>
                        
                    <?php }?>
                <?php } ?>
        <?php } ?>
    </tbody>
</table>


<script>
    $(document).ready(function() {
        $('#date').click(function() {
            alert( "Halo afiq!" );
		})
    })
</script>


