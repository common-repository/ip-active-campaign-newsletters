<?php

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$debug = '';
if (! empty(filter_input(INPUT_GET, 'manualdebug'))) $debug = '1';

		setcookie( 'ipacn_admin_success', ' ', time() - 120, COOKIEPATH, COOKIE_DOMAIN );
		setcookie( 'ipacn_admin_notices', ' ', time() - 120, COOKIEPATH, COOKIE_DOMAIN );

$logging = get_option('ac_logging');
if ($logging == 'disabled') $logging = '';

$logfile = ABSPATH . '/wp-content/plugins/ip-activenewsletters/logs/active_campaign_mailing_'.gmdate('m-d-Y').'.txt';

if (empty($preview)) $preview = false;
if (! empty(filter_input(INPUT_GET, 'preview_id', FILTER_SANITIZE_ENCODED)) || (! empty(filter_input(INPUT_GET, 'preview', FILTER_SANITIZE_ENCODED)) && filter_input(INPUT_GET, 'preview', FILTER_SANITIZE_ENCODED) == 'true')){
	$preview = true;
}
if (! empty(filter_input(INPUT_GET, 'preview_id', FILTER_SANITIZE_ENCODED))) {
	$post_id = esc_html(sanitize_text_field(filter_input(INPUT_GET, 'preview_id', FILTER_SANITIZE_ENCODED)));
	$preview = true;
}

if (empty($post_id) && ! empty(filter_input(INPUT_GET, 'post_id', FILTER_SANITIZE_ENCODED))) $post_id = esc_html(sanitize_text_field(filter_input(INPUT_GET, 'post_id', FILTER_SANITIZE_ENCODED)));
if (empty($post_id) && ! empty(filter_input(INPUT_POST, 'post_id', FILTER_SANITIZE_ENCODED))) $post_id = esc_html(sanitize_text_field(filter_input(INPUT_POST, 'post_id', FILTER_SANITIZE_ENCODED)));
if (empty($post_id) && ! empty($post->ID)) $post_id = $post->ID;
if (empty($post_id) && ! empty($_SERVER['SCRIPT_URI'])) $post_id = url_to_postid(esc_html(sanitize_text_field(wp_unslash($_SERVER['SCRIPT_URI']))));
if (empty($post_id) && ! empty($_SERVER['REQUEST_URI'])) $post_id = url_to_postid(esc_html(sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI']))));
if (empty($post_id) && ! empty($_SERVER['SCRIPT_URL'])) $post_id = url_to_postid(esc_html(sanitize_text_field(wp_unslash($_SERVER['SCRIPT_URL']))));

$master_post_id = $post_id;

if (empty($master_post_id)){
	global $wp;
	if (! empty($wp->request)){
		$url = home_url( $wp->request );
		if (! empty($url)) $master_post_id = url_to_postid($url);
	}
}

if (empty($master_post_id)){
	$ref = ! empty(wp_unslash($_SERVER['HTTP_REFERER'])) ? esc_html(sanitize_text_field(wp_unslash($_SERVER['HTTP_REFERER']))) : '';
	if (! empty($ref)){
		$qstr = explode('?', $ref);
		$qstr = ! empty($qstr[1]) ? $qstr[1] : '';
		if (! empty($qstr)){
			$vars = explode('&', $qstr);
			if (! empty($vars) && is_array($vars)){
				foreach($vars as $var){
					$v = explode('=', $var);
					if (! empty($v[0]) && ! empty($v[1]) && $v[0] == 'post' && is_numeric($v[1])) $master_post_id = $v[1];
				}
			}
		}
	}
}

if ($debug && empty($master_post_id)) die();
if (empty($master_post_id)) return;


$preheader_text = get_field('acpreheader_text', $master_post_id);

$_categories = get_the_category($master_post_id);

# get data from mailing post type

$ac_stage_mailing = ! empty(filter_input(INPUT_POST, 'ac_stage_mailing')) ? esc_html(sanitize_text_field(filter_input(INPUT_POST, 'ac_stage_mailing'))) : '';
$test_recipient = ! empty(filter_input(INPUT_POST, 'test_recipient')) ? esc_html(sanitize_text_field(filter_input(INPUT_POST, 'test_recipient'))) : '';
$ac_send_test = ! empty(filter_input(INPUT_POST, 'ac_send_test')) ? esc_html(sanitize_text_field(filter_input(INPUT_POST, 'ac_send_test'))) : '';
$ac_cancel_mailing = ! empty(filter_input(INPUT_POST, 'ac_cancel_mailing')) ? esc_html(sanitize_text_field(filter_input(INPUT_POST, 'ac_cancel_mailing'))) : '';
$ac_deployment_date = ! empty(filter_input(INPUT_POST, 'ac_deployment_date')) ? esc_html(sanitize_text_field(filter_input(INPUT_POST, 'ac_deployment_date'))) : '';


if ($preview || $ac_deployment_date) {
	$ac_deployment_date = ! empty(filter_input(INPUT_POST, 'ac_deployment_date')) ? esc_html(sanitize_text_field(filter_input(INPUT_POST, 'ac_deployment_date'))) : get_post_meta($master_post_id, 'ac_deployment_date', true);
	$hh = ! empty(filter_input(INPUT_POST, 'ac_hh')) ? esc_html(sanitize_text_field(filter_input(INPUT_POST, 'ac_hh'))) : get_post_meta($master_post_id, 'ac_hh', true);
	$mm = ! empty(filter_input(INPUT_POST, 'ac_mm')) ? esc_html(sanitize_text_field(filter_input(INPUT_POST, 'ac_mm'))) : get_post_meta($master_post_id, 'ac_mm', true);
	$ampm = ! empty(filter_input(INPUT_POST, 'ac_ampm')) ? esc_html(sanitize_text_field(filter_input(INPUT_POST, 'ac_ampm'))) : get_post_meta($master_post_id, 'ac_ampm', true);

	if ($ampm == 'PM') $hh += 12;
	if ($hh == 24) $hh = '00';
	if (strlen($hh) == 1) $hh = '0'.$hh;

	if ($test_recipient) update_post_meta( $master_post_id, 'test_recipient', $test_recipient );
	if ($hh) update_post_meta( $master_post_id, 'ac_hh', $hh, $hh );
	if ($mm) update_post_meta( $master_post_id, 'ac_mm', $mm, $mm );
	if ($ampm) update_post_meta( $master_post_id, 'ac_ampm', $ampm, $ampm );
	if ($ac_deployment_date) update_post_meta( $master_post_id, 'ac_deployment_date', $ac_deployment_date );

	$ac_deployment_date = $ac_deployment_date . " $hh:$mm:00";

}


$message_id = get_post_meta($master_post_id, 'message_id', true);
$campaign_id = get_post_meta($master_post_id, 'campaign_id', true);

$mailing_type = get_field('ipacnmailing_type', $master_post_id);


$logline = "ac_stage_mailing=$ac_stage_mailing|
test_recipient=$test_recipient|
ac_send_test=$ac_send_test|
ac_cancel_mailing=$ac_cancel_mailing|
ac_deployment_date=$ac_deployment_date|
message_id=$message_id|
campaign_id=$campaign_id|
mailing_type=$mailing_type|
";

		require_once('mailing.php');

		if (empty($email_message) || is_array($email_message)) $email_message = '';


if ($preview){
$email_message = str_replace('<!--','',$email_message);
$email_message = str_replace('-->','',$email_message);
$email_message = str_replace('[if mso]','',$email_message);
$email_message = str_replace('![endif]','',$email_message);
echo wp_kses(str_replace('&lt;!--','',$email_message), ipacn_allowed_html);
die();
}

if ($debug) die();

### exit if in the past
if (strtotime($ac_deployment_date) < strtotime("-20 days")) return;

if (empty($ac_stage_mailing) && empty($ac_cancel_mailing) && ! $preview) return;
		

	require_once('IPACNAPI.php');
	
	$IPACNAPI = new IPACNAPI;

		
		if ($ac_cancel_mailing && $campaign_id){
			$_message = array();
			$_message['id'] = $campaign_id;
			$_message['status'] = 0;
			
			$_result = $IPACNAPI->campaign_status($_message);
			
			$campaign_id = ! empty($_result['id']) ? $_result['id'] : '';
			$result_message = ! empty($_result['result_message']) ? $_result['result_message'] : '';

			if (! empty($_result['result_code']) && $_result['result_code'] == 1){
				setcookie( 'ipacn_admin_success', 'Mailing Cancelled at Active Campaign', time() + 120, COOKIEPATH, COOKIE_DOMAIN );
				return;
			}
			else{
				setcookie( 'ipacn_admin_notices', 'Mailing Cancellation failed ' . $result_message, time() + 120, COOKIEPATH, COOKIE_DOMAIN );
				return;
			}
		}
		
		if ($message_id){
			$_message = array();
			$_message['message']['id'] = $message_id;
			$_message['message']['format'] = 'html';
			$_message['message']['priority'] = '1';
			$_message['message']['charset'] = 'utf-8';
			$_message['message']['encoding'] = 'quoted-printable';
			$_message['message']['htmlconstructor'] = 'editor';
			$_message['message']['subject'] = $mailing_subject;
			if ($preheader_text) $_message['message']['preheader_text'] = $preheader_text;
			$_message['message']['html'] = $email_message;
			$_message['message']['p['.$mailing_list_id.']'] = $mailing_list_id;
			
			$_result = $IPACNAPI->message_edit($_message);
			
			$message_id = ! empty($_result['message']['id']) ? $_result['message']['id'] : '';
			$result_message = ! empty($_result['result_message']) ? $_result['result_message'] : '';
			
				
				$_log = $_message;
				unset($_log['message']['html']);

			if (empty($message_id)){
				setcookie( 'ipacn_admin_notices', 'Mailing Message update failed. ' . $result_message, time() + 120, COOKIEPATH, COOKIE_DOMAIN );
				if ($debug) die();
				return;
			}
		}
		else{		
			$_message = array();
			$_message['message']['format'] = 'html';
			$_message['message']['priority'] = '1';
			$_message['message']['charset'] = 'utf-8';
			$_message['message']['encoding'] = 'quoted-printable';
			$_message['message']['htmlconstructor'] = 'editor';
			$_message['message']['subject'] = $mailing_subject;
			if ($preheader_text) $_message['message']['preheader_text'] = $preheader_text;
			$_message['message']['html'] = $email_message;
			$_message['message']['p['.$mailing_list_id.']'] = $mailing_list_id;

			$_result = $IPACNAPI->message_add($_message);
			
			$message_id = ! empty($_result['id']) ? $_result['id'] : '';
			$message_id = ! empty($_result['message']['id']) ? $_result['message']['id'] : '';
			$result_message = ! empty($_result['result_message']) ? $_result['result_message'] : '';
			
			
				$_log = $_message;
				unset($_log['message']['html']);
				
			if ($debug) die();
			
			if (empty($message_id)){
					setcookie( 'ipacn_admin_notices', 'Mailing Message creation failed. ' .$result_message, time() + 120, COOKIEPATH, COOKIE_DOMAIN );
				return;
			}
		}
		
		update_post_meta( $master_post_id, 'message_id', $message_id );
	
		if (empty($campaign_id)){	
			$_message = array();
			$_message['type'] = 'single';
			$_message['segmentid'] = 0;
			$_message['bounceid'] = -1;
			$_message['name'] = ! empty($post->post_title) ? $post->post_title : $mailing_subject;
			$_message['sdate'] = $ac_deployment_date;
			$_message['status'] = 0;
			$_message['public'] = 1;
			$_message['tracklinks'] = 'all';
			$_message['htmlunsub'] = 1;
			$_message['p['.$mailing_list_id.']'] = $mailing_list_id;
			$_message['m['.$message_id.']'] = 100;	
			
			$_result = $IPACNAPI->campaign_create($_message);
			
			$campaign_id = ! empty($_result['id']) ? $_result['id'] : '';
			$result_message = ! empty($_result['result_message']) ? $_result['result_message'] : '';

			if (empty($campaign_id)){
				setcookie( 'ipacn_admin_notices', 'Mailing Campaign Creation failed ' .$result_message, time() + 120, COOKIEPATH, COOKIE_DOMAIN );
				return;
			}
		
			update_post_meta( $master_post_id, 'campaign_id', $campaign_id );
		}	
		
		### include here any new pickers created in mailing config
		if (! empty($articles) && is_array($articles)){
			foreach($articles as $postid){
				update_post_meta( $postid, 'ipacn_deployment_date', $ac_deployment_date );
			}
		}
		
		if (empty($ac_schedule_mailing) && empty($ac_send_test)){
			setcookie( 'ipacn_admin_success', 'Mailing Staged at Active Campaign', time() + 120, COOKIEPATH, COOKIE_DOMAIN );
			return;
		}
		
		if ($ac_send_test && $test_recipient){
			$test_recipients = explode(',', $test_recipient);
			foreach($test_recipients as $rec){
				
				$rec = sanitize_email($rec);
				
				$_message = array();
				$_message['email'] = $rec;
				$_message['campaignid'] = $campaign_id;
				$_message['messageid'] = 0;
				$_message['type'] = 'mime';
				$_message['action'] = 'test';

				$_result = $IPACNAPI->campaign_send($_message);
				
			}
			
			$result_code = ! empty($_result['result_code']) ? $_result['result_code'] : '';
			$result_message = ! empty($_result['result_message']) ? $_result['result_message'] : '';
			
			if (! empty($_result['result_code']) && $_result['result_code'] == 1){
				setcookie( 'ipacn_admin_success', 'Test sent through Active Campaign', time() + 120, COOKIEPATH, COOKIE_DOMAIN );
			}
			else{
				setcookie( 'ipacn_admin_notices', 'Test send failed. ' . $result_message, time() + 120, COOKIEPATH, COOKIE_DOMAIN );
			}
			
		}
		
		if ($debug) die();
	
	
		
		
function ipacn_make_excerpt($post, $length = 20){

        $text = $post->post_content;
        $text = str_ireplace('<!-- wp:paragraph -->', '', $text);
        $text = str_ireplace('<!-- /wp:paragraph -->', '', $text);
 
        $text = strip_shortcodes( $text );
        $text = excerpt_remove_blocks( $text );
 
        /** This filter is documented in wp-includes/post-template.php */
        $text = apply_filters( 'the_content', $text );
        $text = str_replace( ']]>', ']]&gt;', $text );
 
        /**
         * Filters the number of words in an excerpt.
         *
         * @since 2.7.0
         *
         * @param int $number The number of words. Default 55.
         */
        $excerpt_length = apply_filters( 'excerpt_length', $length );
        /**
         * Filters the string in the "more" link displayed after a trimmed excerpt.
         *
         * @since 2.9.0
         *
         * @param string $more_string The string shown within the more link.
         */
        $excerpt_more = apply_filters( 'excerpt_more', ' ' . '[&hellip;]' );
        $text         = wp_trim_words( $text, $excerpt_length, $excerpt_more );
        
		$cap = stripos($text, '[caption');
		
        if (stripos($text, '[caption') !== false){
        		$c = stripos($text, '[caption');
        		$length = 0;
        		while(substr($text, $c, 1) != ']'){
        			$c++;
        			$length++;

        		}
	        $t = substr($text, 0, $cap);
	        $t .= substr($text, $cap + $length + 1); 		
        	$text = $t;
        }
        
        $text = str_ireplace('[/caption]','', $text);

		return $text;
}

function ipacn_make_excerptp($post, $length = 4){

    $content = $post->post_content;
 		$content = str_ireplace('<!-- wp:paragraph -->', '', $content);
    $content = str_ireplace('<!-- /wp:paragraph -->', '', $content);
        
		$closing_p = '</p>';
		$paragraphs = explode( $closing_p, wpautop( $content ) );
		$_output = array();
		foreach ($paragraphs as $index => $paragraph) {
			if ($index < $length){
				if ( trim( $paragraph ) ) {
					$_output[] .= $paragraph . $closing_p;
				}
			}
		}
		
		$text = implode( '', $_output );
		$cap = stripos($text, '[caption');
		
        if (stripos($text, '[caption') !== false){
        		$c = stripos($text, '[caption');
        		$length = 0;
        		while(substr($text, $c, 1) != ']'){
        			$c++;
        			$length++;

        		}
	        $t = substr($text, 0, $cap);
	        $t .= substr($text, $cap + $length + 1); 
        	$text = $t;
        }
        
        $text = str_ireplace('[/caption]','', $text);

		return $text;
}
