<?php
/**
 * The remote host file to process update requests
 *
 */
if ( isset( $_POST['action'] ) ) {
		//set up the properties common to both requests 
		$obj = new stdClass();
		$obj->slug = 'superhero.php';  
		$obj->name = 'Super Hero';
		$obj->plugin_name = 'superhero.php';
		$obj->new_version = '0.2.0';
		// the url for the plugin homepage
		$obj->url = 'https://heimerwp.com/superhero/';
		//the download location for the plugin zip file (can be any internet host)
		$obj->package = 'https://heimerwp.com/superhero.zip';

		switch ( $_POST['action'] ) {

		case 'version':  
			//echo serialize( $obj );
			echo json_encode( $obj );
			break;  
		case 'info':   
			$obj->requires = '0.1.9';  
			$obj->tested = '0.1.8';  
			$obj->downloaded = 12540;  
			$obj->last_updated = '2021-03-29';  
			$obj->sections = array(  
				'description' => 'The new version of the superheroes plugin shortcode',  
				'another_section' => 'Dashboard plugin to include token',  
				'changelog' => 'Dashboard included to seeting up the shortcode on text edit, Implementation system versioning', 
			);
			$obj->download_link = $obj->package;  
			//echo serialize($obj);  
			echo json_encode( $obj );
			break;  
}  
}else {
			header('Cache-Control: public');
			header('Content-Description: File Transfer');
			header('Content-Type: application/zip');
			readfile('superhero.zip');
}



?>
