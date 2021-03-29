<?php
/**
 * The remote host file to process update requests
 *
 */
if ( !isset( $_POST['action'] ) ) {
	echo '0';
	exit;
}

//set up the properties common to both requests 
$obj = new stdClass();
$obj->slug = 'plugin.php';  
$obj->name = 'Plugin';
$obj->plugin_name = 'plugin.php';
$obj->new_version = '0.2.0';
// the url for the plugin homepage
$obj->url = 'https://github.com/heimer79/superheroes';
//the download location for the plugin zip file (can be any internet host)
$obj->package = 'https://github.com/heimer79/superheroes/archive/refs/heads/master.zip';

switch ( $_POST['action'] ) {

case 'version':  
	//echo serialize( $obj );
	echo json_encode( $obj );
	break;  
case 'info':   
	$obj->requires = '0.1.0';  
	$obj->tested = '0.1.9';  
	$obj->downloaded = 12540;  
	$obj->last_updated = '2021-03-29';  
	$obj->sections = array(  
		'description' => 'The new version of the Auto-Update plugin',  
		'another_section' => 'This is another section',  
		'changelog' => 'Some new features'  
	);
	$obj->download_link = $obj->package;  
	//echo serialize($obj);  
	echo json_encode( $obj );
case 'license':  
	//echo serialize( $obj );
	echo json_encode( $obj );
	break;  
}  

?>
