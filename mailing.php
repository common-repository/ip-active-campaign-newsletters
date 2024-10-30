<?php

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $wp_query;
$deploymentdate = ! empty($wp_query->query_vars['ac_deployment_date']) ? sanitize_text_field($wp_query->query_vars['ac_deployment_date']) : get_post_meta($master_post_id, 'ac_deployment_date', true);
$nl_issue_date = gmdate("Ymd", strtotime($deploymentdate));

$header_image = get_field('acheader_image', $master_post_id);

$mailing_subject = get_field('ipacnmailing_subject', $master_post_id);

$preheader_text = get_field('acpreheader_text', $master_post_id);

$mailing_list_id = get_field('ipacnmailing_list', $master_post_id);

if (is_array($mailing_list_id)){
$mailing_list_id = key($mailing_list_id);
}

$append_tracking = get_field('append_tracking', $master_post_id);

$utm_source = get_field('utm_source', $master_post_id);
$utm_source = urlencode($utm_source);
$utm_medium = get_field('utm_medium', $master_post_id);
$utm_medium = urlencode($utm_medium);
$utm_content = get_field('utm_content', $master_post_id);
$utm_content = urlencode($utm_content);
$utm_campaign = get_field('utm_campaign', $master_post_id);
$utm_campaign = urlencode($utm_campaign);

if ($mailing_type == 'scraper'){
	require_once('scraper_template.php');
	
				$start = stripos($email_message, '<!DOCTYPE html');
				if ($start === 0) $email_message = substr($email_message, ($start + 14));
				$start = stripos($email_message, '<!DOCTYPE html');
				if ($start) {
					$email_message = substr($email_message, $start);
				}
				else{
					$email_message = '<!DOCTYPE html' . $email_message;
				}
				
				$start = stripos($email_message, '<head>');

				if ($start) {
					$email_message = substr($email_message, $start);
				}		
				
				if (stripos($email_message, '<html>') === false && stripos($email_message, '</html>')) $email_message = '<html>' . $email_message;				

				$email_message = str_ireplace('_t.e.s.t_@example.com', '%EMAIL%', $email_message);
				$message_orig = $email_message;
				
				
			# find the scripts
			$_scripts = array();
			$outerstop = false;
			$outersanity = 0;
			while(! $outerstop){
				$outersanity++;
				if ($outersanity > 50) $outerstop = true;
				$start = stripos($email_message, '<script');
				if ($start === false) $outerstop = true;

			
	      if ($start !== false) {

					$stop = false;
					$end = 0;
					$check = $start;
					$sanity = 0;
					while(! $stop){
						$sanity++;
						$end++;
						$check++;

						if ($sanity > 10000000) $stop = true;
						if (strtoupper(substr($email_message, $check, 7)) == "/SCRIPT") {
							$stop = true;
							$end += 8;
						}
					}
					$adurl = substr($email_message, $start, $end);

					$_scripts[] = $adurl;
					$email_message = substr($email_message, ($start + $end));
					$sanity = 0;
				}
			}
			
		$email_message = $message_orig;
			
		foreach($_scripts as $script){
			if (stripos($script, 'script') !== false){

				$email_message = str_ireplace($script, '', $email_message);
			}
		}
		
		$email_message = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $email_message) ? : $email_message;
		$message_orig = $email_message;
	
	$trackingcodes = '';
	if ($append_tracking) {
		
		#see if we already did this
		if (stripos($email_message, $utm_content) === false && stripos($email_message, $utm_campaign) === false){
		
			$trackingcodes = 'utm_source='. $utm_source . '&utm_medium=' .  $utm_medium . '&utm_content=' .  $utm_content . '&utm_campaign=' .  $utm_campaign;
	
			# find the links
			$_links = array();
			$outerstop = false;
			$outersanity = 0;
			while(! $outerstop){
				$outersanity++;
				if ($outersanity > 50) $outerstop = true;
				$start = stripos($email_message, '<a href=');
				if ($start < 11) $outerstop = true;
				$start = $start + 9;

			
	      if ($start > 8) {

					$stop = false;
					$end = 0;
					$check = $start;
					$sanity = 0;
					while(! $stop){
						$sanity++;
						$end++;
						$check++;

						if ($sanity > 1000) $stop = true;
						if (substr($email_message, $check, 1) == "'" || substr($email_message, $check, 1) == '"') {
							$stop = true;
						}
					}
					$adurl = substr($email_message, $start, $end);

					$_links[] = $adurl;
					$email_message = substr($email_message, ($start + $end));
					$sanity = 0;
				}
			}
			
			$email_message = $message_orig;
			
			# find the weird links
			$outerstop = false;
			$outersanity = 0;
			while(! $outerstop){
				$outersanity++;
				if ($outersanity > 50) $outerstop = true;
				$start = stripos($email_message, '<a');
				if ($start < 4) $outerstop = true;

			
	      if ($start > 4) {

					$stop = false;
					$end = 0;
					$check = $start;
					$sanity = 0;
					while(! $stop){
						$sanity++;
						$end++;
						$check++;

						if ($sanity > 2000) $stop = true;
						if (strtoupper(substr($email_message, $check, 1)) == ">") {
							$stop = true;
							$end;
						}
					}
					$adurl = substr($email_message, $start, $end);

					
					$linkstart = stripos($adurl, 'href=') + 5;
					$adurl = substr($adurl, $linkstart);
					$adurl = str_replace('"', '', $adurl);
					$adurl = str_replace("'", '', $adurl);
					$a = explode(' ', $adurl);
					$adurl = $a[0];

					
					$_links[] = $adurl;
					$email_message = substr($email_message, ($start + $end));
					$sanity = 0;
				}
			}
			
			$email_message = $message_orig;
			
			foreach($_links as $link){
				if (stripos($link, 'http') === 0){

					if (stripos($link, 'acemlnb') === false){
						$_l = explode('?', $link);

						$l = $_l[0];
						$l .= '?MailingID=%CAMPAIGNID%&' . urlencode($trackingcodes);

						if (stripos($link, '?') !== false){

							$email_message = str_ireplace($link, $l, $email_message);
						}
						else{
							#if (stripos($link, '/landing') !== false || stripos($link, '/subscribe') !== false){

							#	$email_message = str_replace($link, $l, $email_message);
							#}
							$link .= '"';
							$l .= '"';

							$email_message = str_ireplace($link, $l, $email_message);
						}
					}
				}
			}
			
		}
		
	}
			
	
}
elseif ($mailing_type == 'editorial'){
	require_once('editorial_template.php');
}
		
?>