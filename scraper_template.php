<?php

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$fetch_url = get_field('acfetch_url', $master_post_id);


if (empty($fetch_url)){
setcookie( 'ac_admin_notices', 'No import url input', time() + 120, COOKIEPATH, COOKIE_DOMAIN );
return;
}

if (stripos($fetch_url, 'email=t') === false){
	if (stripos($fetch_url, '?') !== false){
		$fetch_url .= '&email=t';
	}
	else{
		$fetch_url .= '?email=t';
	}
	update_post_meta( $master_post_id, 'acfetch_url', $fetch_url);
}

$html = wp_remote_get($fetch_url);

$email_message = ! empty($html['body']) ? $html['body'] : '';