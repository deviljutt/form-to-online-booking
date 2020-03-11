<?php


function calendlycf7_forms_enabled() {
	$enabled = array();
	$args = array(
		'posts_per_page'   => -1,
		'post_type'        => 'wpcf7_contact_form',
	);
	$posts_array = get_posts($args);
	foreach($posts_array as $post) {
		$post_id = $post->ID;
		$enable = get_post_meta( $post_id, "_ccf7_active", true);
			
			if ($enable == "active") {	
			$meetingurls = get_post_meta( $post_id, "cf7rl_urls", true);
			$selecttype = get_post_meta( $post_id, "cf7rl_type", true);
			$sendemail = get_post_meta( $post_id, "cf7rl_sendemail", true);
			$ccf7_name = get_post_meta( $post_id, "cf7rl_name", true);
			$ccf7_email = get_post_meta( $post_id, "cf7rl_emai", true);
			$redirectmethod = get_post_meta( $post_id, "cf7rl_redirectmethod", true);
			

			$enabled[] = '|'.$post_id.'|'.$meetingurls.'|'.$selecttype.'|'.$sendemail.'|'.$ccf7_name.'|'.$ccf7_email.'|'.$redirectmethod.'|';
			}
	}
	return json_encode($enabled,JSON_UNESCAPED_SLASHES);
}


function calendlycf7_public_enqueue() {

	// redirect method js
	wp_enqueue_script('cf7rl-redirect_method',plugins_url('./redirect_method.js',__FILE__),array('jquery'),null);
	wp_localize_script('cf7rl-redirect_method', 'cf7rl_ajax_object',
		array (
			'cf7rl_ajax_url' 		=> admin_url('admin-ajax.php'),
			'cf7rl_forms' 			=> calendlycf7_forms_enabled(),
		)
	);

}
add_action('wp_enqueue_scripts','calendlycf7_public_enqueue',10);
