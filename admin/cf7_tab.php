<?php
function calendlycf7_tab_panels ( $panels ) {

	$new_page = array(
		'ccf7' => array(
			'title' => __( 'Calendly Integration', 'cf7rl' ),
			'callback' => 'calendlycf7_tab_panels_tab_data'
		)
	);
	$panels = array_merge($panels, $new_page);
	return $panels;
}
add_filter( 'wpcf7_editor_panels', 'calendlycf7_tab_panels' );

function calendlycf7_tab_panels_tab_data(){
    $post_id = sanitize_text_field($_GET['post']);
    $active =  sanitize_text_field(get_post_meta($post_id, "cf7rl_active", true));
    $meetingurl =  sanitize_text_field(get_post_meta($post_id, "cf7rl_urls", true));
	$selecttype =  sanitize_text_field(get_post_meta($post_id, "cf7rl_type", true));
    $sendemail  =  sanitize_text_field(get_post_meta($post_id, "cf7rl_sendemail", true));
    $name  =  sanitize_text_field(get_post_meta($post_id, "cf7rl_name", true));
    $email  =  sanitize_text_field(get_post_meta($post_id, "cf7rl_emai", true));
	$redirectmethod  =  sanitize_text_field(get_post_meta($post_id, "cf7rl_redirectmethod", true));
    if(!empty($active)){  $ifactive = "checked"; }else{$ifactive = "";   }
    if(!empty($meetingurl)){  $meetingurl = $meetingurl; }else{$meetingurl = "put url";   }
    $meetingurl = str_replace(' ', "&nbsp;", $meetingurl);
    $cc7 = "<h2 class='tablehead'>Calendly Meeting Setup</h2>";
    $cc7 .= "<table id='datatable'><tr><td><label>Active</label></td>";
    $cc7 .= "<td><input type='checkbox' ".$ifactive." value='active' name='activef'/></td></tr>";
    $cc7 .= "<tr><td><label>Meeting Url (Make sure use url with http://)</label></td>";
    $cc7 .= "<td><input type='text' value=".esc_html($meetingurl)." name='meetingurls'></tr></td>";
    
	$cc7 .= "<tr><td><label>Method</label></td>";
    $cc7 .= "<td>";
    $cc7 .= "<select name='selecttype'>";
    $cc7 .= "<option"; 
    if ($selecttype == '1') { $cc7 .= ' selected="selected"'; } 
    $cc7 .= " value='1'>Redirect</option>";
    $cc7 .= "<option"; 
    if ($selecttype == '2') { $cc7 .= ' selected="selected"'; } 
    $cc7 .= " value='2' disabled>Popup</option>";
    $cc7 .= "</select></td></tr>";
	
	$cc7 .= "<tr><td><label>Redirect Method</label></td>";
    $cc7 .= "<td>";
    $cc7 .= "<select name='redirectmethod'>";
    $cc7 .= "<option"; 
    if ($redirectmethod == '1') { $cc7 .= ' selected="selected"'; } 
    $cc7 .= " value='1'>Same Tab</option>";
    $cc7 .= "<option"; 
    if ($redirectmethod == '2') { $cc7 .= ' selected="selected"'; } 
    $cc7 .= " value='2' >New Tab</option>";
    $cc7 .= "</select></td></tr>";	
	
	
    $cc7 .= "<tr><td><label>Send Email to admin from cf7</label></td>";
    $cc7 .= "<td>";
    $cc7 .= "<select name='sendemail'>";
    $cc7 .= "<option";
    if ($sendemail == 'Yes') { $cc7 .= ' selected="selected"'; } 
    $cc7 .= " value='Yes'>Yes</option>";
    $cc7 .= "<option"; 
    if ($sendemail == 'No') { $cc7 .= ' selected="selected"'; } 
    $cc7 .= " value='No'>No</option>";
    $cc7 .= "</select></tr></td></table>";
    $cc7 .= "<h2 class='tablehead'>Data Sent to Calendly</h2>";     
    $cc7 .="<table id='datatable'>";
     $cc7 .= "<tr>";
         $cc7 .= "<td>";
         $cc7 .= "<label>Name<label>";
         $cc7 .= "</td>";
         $cc7 .= "<td>";
         $cc7 .= "<select name='ccf7_name'>";
         $cond = null; 
         $result = wpcf7_scan_form_tags($cond); 
            foreach($result as $item) {
            
                $cc7 .= "<option";
                if ($name == $item['name']) { $cc7 .= ' selected="selected"'; } 
                $cc7 .= " value=".$item['name'].">";
                $cc7 .= $item['name']."</option>";
         }
         $cc7 .= "</select>";
         $cc7 .= "</td>";
     $cc7 .= "</tr>";
    $cc7 .= "<tr>";
        $cc7 .= "<td>";
        $cc7 .= "<label>Email<label>";
        $cc7 .= "</td>";
        $cc7 .= "<td>";
        $cc7 .= "<select name='ccf7_email'>";
        $cond = null; 
        $result = wpcf7_scan_form_tags($cond); 
           foreach($result as $item) {
            $cc7 .= "<option";
            if ($email == $item['name']) { $cc7 .= ' selected="selected"'; } 
            $cc7 .= " value=".$item['name'].">";
            $cc7 .= $item['name']."</option>";
        }
        $cc7 .= "</select>";
        $cc7 .= "</td>";
    $cc7 .= "</tr>";
   $cc7 .= "</table>";
    $cc7 .= "<input type='hidden' name='ccf7_id' value='$post_id'>";
    echo $cc7;
}
// CF7 Save admin data
add_action('wpcf7_after_save', 'calendlycf7_save_form');
function calendlycf7_save_form( $cf7 ) {
    $post_id = sanitize_text_field($_POST['ccf7_id']);
    $active = sanitize_text_field($_POST['activef']);
    $meetingurl = sanitize_text_field($_POST['meetingurls']);
    $selecttype = sanitize_text_field($_POST['selecttype']);
    $sendemail = sanitize_text_field($_POST['sendemail']);
    $ccf7_name = sanitize_text_field($_POST['ccf7_name']);
    $ccf7_email = sanitize_text_field($_POST['ccf7_email']);
	$redirectmethod = sanitize_text_field($_POST['redirectmethod']);
    if (isset($active)){
        update_post_meta($post_id, "cf7rl_active", $active);
        update_post_meta($post_id, "cf7rl_urls", $meetingurl);
        update_post_meta($post_id, "cf7rl_type", $selecttype);
        update_post_meta($post_id, "cf7rl_sendemail", $sendemail);
        update_post_meta($post_id, "cf7rl_name", $ccf7_name);
        update_post_meta($post_id, "cf7rl_emai", $ccf7_email);
		update_post_meta($post_id, "cf7rl_redirectmethod", $redirectmethod);
    }
}