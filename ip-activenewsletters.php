<?php
/*
Plugin Name: IP ActiveCampaign Newsletters
Text Domain: ip-activenewsletters
Version: 2.8.1
Description: Construct, preview, test and send ActiveCampaign mailings through WordPress
Author: John Laliberte
Requires at least: 4.7
Tested up to: 6.6
Stable tag: 2.8.1
Requires PHP: 6.0
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Copyright 2024 Internet Production, Inc.
*/

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

require_once 'activenewsletters_settings.php';

$_ipacn_allowed_html = wp_kses_allowed_html();
$_ipacn_allowed_html['input'] = array(
        'type'      => array(),
        'class'      => array(),
        'name'      => array(),
        'id'      => array(),
        'value'     => array(),
        'size'     => array(),
        'rows'     => array(),
        'cols'     => array(),
        'selected'     => array(),
        'style' => array(),
        'checked'   => array()
    );
$_ipacn_allowed_html['select'] = array(
        'type'      => array(),
        'class'      => array(),
        'name'      => array(),
        'id'      => array(),
        'value'     => array(),
        'size'     => array(),
        'rows'     => array(),
        'cols'     => array(),
        'selected'     => array(),
        'option'     => array(),
        'style' => array(),
        'checked'   => array()
    );
$_ipacn_allowed_html['option'] = array(
        'type'      => array(),
        'class'      => array(),
        'name'      => array(),
        'id'      => array(),
        'value'     => array(),
        'size'     => array(),
        'rows'     => array(),
        'cols'     => array(),
        'selected'     => array(),
        'style' => array(),
        'checked'   => array()
    );
$_ipacn_allowed_html['radio'] = array(
        'type'      => array(),
        'class'      => array(),
        'name'      => array(),
        'id'      => array(),
        'value'     => array(),
        'size'     => array(),
        'rows'     => array(),
        'cols'     => array(),
        'selected'     => array(),
        'style' => array(),
        'checked'   => array()
    );
$_ipacn_allowed_html['checkbox'] = array(
        'type'      => array(),
        'class'      => array(),
        'name'      => array(),
        'id'      => array(),
        'value'     => array(),
        'size'     => array(),
        'rows'     => array(),
        'cols'     => array(),
        'selected'     => array(),
        'style' => array(),
        'checked'   => array()
    );
$_ipacn_allowed_html['textarea'] = array(
        'type'      => array(),
        'class'      => array(),
        'name'      => array(),
        'id'      => array(),
        'value'     => array(),
        'size'     => array(),
        'rows'     => array(),
        'cols'     => array(),
        'selected'     => array(),
        'style' => array(),
        'checked'   => array()
    );
$_ipacn_allowed_html['div'] = array(
        'type'      => array(),
        'class'      => array(),
        'name'      => array(),
        'id'      => array(),
        'value'     => array(),
        'size'     => array(),
        'rows'     => array(),
        'cols'     => array(),
        'selected'     => array(),
        'style' => array(),
        'checked'   => array(),
        'align'   => array(),
        'valign'   => array(),
        'width'   => array(),
        'border'   => array(),
        'cellpadding'   => array(),
        'cellspacing'   => array(),
        'bgcolor'   => array(),
    );
$_ipacn_allowed_html['span'] = array(
        'type'      => array(),
        'class'      => array(),
        'name'      => array(),
        'id'      => array(),
        'value'     => array(),
        'size'     => array(),
        'rows'     => array(),
        'cols'     => array(),
        'selected'     => array(),
        'style' => array(),
        'checked'   => array(),
        'align'   => array(),
        'valign'   => array(),
        'width'   => array(),
        'border'   => array(),
        'cellpadding'   => array(),
        'cellspacing'   => array(),
        'bgcolor'   => array(),
    );
$_ipacn_allowed_html['p'] = array(
        'type'      => array(),
        'class'      => array(),
        'name'      => array(),
        'id'      => array(),
        'value'     => array(),
        'size'     => array(),
        'rows'     => array(),
        'cols'     => array(),
        'selected'     => array(),
        'style' => array(),
        'checked'   => array(),
        'align'   => array(),
        'valign'   => array(),
        'width'   => array(),
        'border'   => array(),
        'cellpadding'   => array(),
        'cellspacing'   => array(),
        'bgcolor'   => array(),
    );
$_ipacn_allowed_html['table'] = array(
        'type'      => array(),
        'class'      => array(),
        'name'      => array(),
        'id'      => array(),
        'value'     => array(),
        'size'     => array(),
        'rows'     => array(),
        'cols'     => array(),
        'selected'     => array(),
        'style' => array(),
        'checked'   => array(),
        'align'   => array(),
        'valign'   => array(),
        'width'   => array(),
        'border'   => array(),
        'cellpadding'   => array(),
        'cellspacing'   => array(),
        'bgcolor'   => array(),
    );
$_ipacn_allowed_html['tr'] = array(
        'type'      => array(),
        'class'      => array(),
        'name'      => array(),
        'id'      => array(),
        'value'     => array(),
        'size'     => array(),
        'rows'     => array(),
        'cols'     => array(),
        'selected'     => array(),
        'style' => array(),
        'checked'   => array(),
        'align'   => array(),
        'valign'   => array(),
        'width'   => array(),
        'border'   => array(),
        'cellpadding'   => array(),
        'cellspacing'   => array(),
        'bgcolor'   => array(),
    );
$_ipacn_allowed_html['td'] = array(
        'type'      => array(),
        'class'      => array(),
        'name'      => array(),
        'id'      => array(),
        'value'     => array(),
        'size'     => array(),
        'rows'     => array(),
        'cols'     => array(),
        'selected'     => array(),
        'style' => array(),
        'checked'   => array(),
        'align'   => array(),
        'valign'   => array(),
        'width'   => array(),
        'border'   => array(),
        'cellpadding'   => array(),
        'cellspacing'   => array(),
        'bgcolor'   => array(),
    );
$_ipacn_allowed_html['b'] = array(
        'type'      => array(),
        'class'      => array(),
        'name'      => array(),
        'id'      => array(),
        'value'     => array(),
        'size'     => array(),
        'rows'     => array(),
        'cols'     => array(),
        'selected'     => array(),
        'style' => array(),
        'checked'   => array(),
        'align'   => array(),
        'valign'   => array(),
        'width'   => array(),
        'border'   => array(),
        'cellpadding'   => array(),
        'cellspacing'   => array(),
        'bgcolor'   => array(),
    );
$_ipacn_allowed_html['strong'] = array(
        'type'      => array(),
        'class'      => array(),
        'name'      => array(),
        'id'      => array(),
        'value'     => array(),
        'size'     => array(),
        'rows'     => array(),
        'cols'     => array(),
        'selected'     => array(),
        'style' => array(),
        'checked'   => array(),
        'align'   => array(),
        'valign'   => array(),
        'width'   => array(),
        'border'   => array(),
        'cellpadding'   => array(),
        'cellspacing'   => array(),
        'bgcolor'   => array(),
    );
$_ipacn_allowed_html['i'] = array(
        'type'      => array(),
        'class'      => array(),
        'name'      => array(),
        'id'      => array(),
        'value'     => array(),
        'size'     => array(),
        'rows'     => array(),
        'cols'     => array(),
        'selected'     => array(),
        'style' => array(),
        'checked'   => array(),
        'align'   => array(),
        'valign'   => array(),
        'width'   => array(),
        'border'   => array(),
        'cellpadding'   => array(),
        'cellspacing'   => array(),
        'bgcolor'   => array(),
    );
$_ipacn_allowed_html['u'] = array(
        'type'      => array(),
        'class'      => array(),
        'name'      => array(),
        'id'      => array(),
        'value'     => array(),
        'size'     => array(),
        'rows'     => array(),
        'cols'     => array(),
        'selected'     => array(),
        'style' => array(),
        'checked'   => array(),
        'align'   => array(),
        'valign'   => array(),
        'width'   => array(),
        'border'   => array(),
        'cellpadding'   => array(),
        'cellspacing'   => array(),
        'bgcolor'   => array(),
    );
$_ipacn_allowed_html['style'] = array(
        'type'      => array(),
        'class'      => array(),
        'name'      => array(),
        'id'      => array(),
        'value'     => array(),
        'size'     => array(),
        'rows'     => array(),
        'cols'     => array(),
        'selected'     => array(),
        'style' => array(),
        'checked'   => array(),
        'align'   => array(),
        'valign'   => array(),
        'width'   => array(),
        'border'   => array(),
        'cellpadding'   => array(),
        'cellspacing'   => array(),
        'bgcolor'   => array(),
    );

$_ipacn_allowed_html['html'] = array(
        'type'      => array(),
        'class'      => array(),
        'name'      => array(),
        'id'      => array(),
        'value'     => array(),
        'size'     => array(),
        'rows'     => array(),
        'cols'     => array(),
        'selected'     => array(),
        'style' => array(),
        'checked'   => array(),
        'align'   => array(),
        'valign'   => array(),
        'width'   => array(),
        'border'   => array(),
        'cellpadding'   => array(),
        'cellspacing'   => array(),
        'bgcolor'   => array(),
    );
$_ipacn_allowed_html['head'] = array(
        'type'      => array(),
        'class'      => array(),
        'name'      => array(),
        'id'      => array(),
        'value'     => array(),
        'size'     => array(),
        'rows'     => array(),
        'cols'     => array(),
        'selected'     => array(),
        'style' => array(),
        'checked'   => array()
    );
$_ipacn_allowed_html['body'] = array(
        'type'      => array(),
        'class'      => array(),
        'name'      => array(),
        'id'      => array(),
        'value'     => array(),
        'size'     => array(),
        'rows'     => array(),
        'cols'     => array(),
        'selected'     => array(),
        'style' => array(),
        'checked'   => array(),
        'align'   => array(),
        'valign'   => array(),
        'width'   => array(),
        'border'   => array(),
        'cellpadding'   => array(),
        'cellspacing'   => array(),
        'bgcolor'   => array(),
    );
$_ipacn_allowed_html['img'] = array(
        'type'      => array(),
        'class'      => array(),
        'name'      => array(),
        'id'      => array(),
        'value'     => array(),
        'size'     => array(),
        'rows'     => array(),
        'cols'     => array(),
        'selected'     => array(),
        'style' => array(),
        'checked'   => array(),
        'align'   => array(),
        'valign'   => array(),
        'width'   => array(),
        'border'   => array(),
        'cellpadding'   => array(),
        'cellspacing'   => array(),
        'bgcolor'   => array(),
        'src'   => array(),
        'alt'   => array(),
        'target'   => array(),
    );
$_ipacn_allowed_html['center'] = array(
        'type'      => array(),
        'class'      => array(),
        'name'      => array(),
        'id'      => array(),
        'value'     => array(),
        'size'     => array(),
        'rows'     => array(),
        'cols'     => array(),
        'selected'     => array(),
        'style' => array(),
        'checked'   => array(),
        'align'   => array(),
        'valign'   => array(),
        'width'   => array(),
        'border'   => array(),
        'cellpadding'   => array(),
        'cellspacing'   => array(),
        'bgcolor'   => array(),
    );
$_ipacn_allowed_html['hr'] = array(
        'type'      => array(),
        'class'      => array(),
        'name'      => array(),
        'id'      => array(),
        'value'     => array(),
        'size'     => array(),
        'rows'     => array(),
        'cols'     => array(),
        'selected'     => array(),
        'style' => array(),
        'checked'   => array(),
        'align'   => array(),
        'valign'   => array(),
        'width'   => array(),
        'border'   => array(),
        'cellpadding'   => array(),
        'cellspacing'   => array(),
        'bgcolor'   => array(),
    );
$_ipacn_allowed_html['br'] = array(
        'type'      => array(),
        'class'      => array(),
        'name'      => array(),
        'id'      => array(),
        'value'     => array(),
        'size'     => array(),
        'rows'     => array(),
        'cols'     => array(),
        'selected'     => array(),
        'style' => array(),
        'checked'   => array(),
        'align'   => array(),
        'valign'   => array(),
        'width'   => array(),
        'border'   => array(),
        'cellpadding'   => array(),
        'cellspacing'   => array(),
        'bgcolor'   => array(),
    );
$_ipacn_allowed_html['meta'] = array(
        'type'      => array(),
        'class'      => array(),
        'name'      => array(),
        'id'      => array(),
        'value'     => array(),
        'size'     => array(),
        'rows'     => array(),
        'cols'     => array(),
        'selected'     => array(),
        'style' => array(),
        'checked'   => array()
    );
$_ipacn_allowed_html['a'] = array(
        'type'      => array(),
        'class'      => array(),
        'name'      => array(),
        'id'      => array(),
        'value'     => array(),
        'size'     => array(),
        'rows'     => array(),
        'cols'     => array(),
        'selected'     => array(),
        'style' => array(),
        'checked'   => array(),
        'align'   => array(),
        'valign'   => array(),
        'width'   => array(),
        'border'   => array(),
        'cellpadding'   => array(),
        'cellspacing'   => array(),
        'bgcolor'   => array(),
        'src'   => array(),
        'alt'   => array(),
        'target'   => array(),
        'href'   => array(),
    );

define('ipacn_allowed_html', $_ipacn_allowed_html);


	if (! is_dir( WP_PLUGIN_DIR . '/advanced-custom-fields' ) && ! is_dir( WP_PLUGIN_DIR . '/advanced-custom-fields-pro' )){
		$cookie = ! empty($_COOKIE['ipacn_admin_notices']) ? esc_html(sanitize_text_field(wp_unslash($_COOKIE['ipacn_admin_notices']))) : '';
		if (! $cookie) {
			setcookie( 'ipacn_admin_notices', 'Please install Advance Custom Fields to complete ActiveCampaign Newsletters installation: <a href="/wp-admin/plugin-install.php?s=ACF&tab=search&type=term">Install ACF</a>', time() + 3000, COOKIEPATH, COOKIE_DOMAIN );
			echo wp_kses('<div id="message" class="error"><p>'.esc_html(sanitize_text_field(wp_unslash($_COOKIE['ipacn_admin_notices']))).'</p></div>', ipacn_allowed_html);
			return;
		}
	}

add_action( 'init', 'ipacn_acfsetup');
function ipacn_acfsetup() {

	if (! function_exists('acf_get_field_group_post')){
		$cookie = ! empty($_COOKIE['ipacn_admin_notices']) ? esc_html(sanitize_text_field(wp_unslash($_COOKIE['ipacn_admin_notices']))) : '';
		if (! $cookie) {
			setcookie( 'ipacn_admin_notices', 'Please activate Advance Custom Fields to complete ActiveCampaign Newsletters installation: <a href="/wp-admin/plugin-install.php?s=ACF&tab=search&type=term">Activate ACF</a>', time() + 3000, COOKIEPATH, COOKIE_DOMAIN );
			echo wp_kses('<div id="message" class="error"><p>'.esc_html(sanitize_text_field(wp_unslash($_COOKIE['ipacn_admin_notices']))).'</p></div>', ipacn_allowed_html);
			return;
		}
	}
	
	$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_ENCODED);
	$acfp = filter_input(INPUT_GET, 'acfp', FILTER_SANITIZE_ENCODED);
	if (empty($action) && empty($acfp)){
		require_once('acf_setup.php');
	}
	
}

add_action( 'ipacn_logcleanup', 'ipacn_logcleanup' );
if ( ! wp_next_scheduled( 'ipacn_logcleanup' ) ) {
	wp_schedule_event( time(), 'daily', 'ipacn_logcleanup' );
}

function ipacn_logcleanup(){
	$_pluginstoscrub = array('ip-activenewsletters');
	$_checkdirs = array('logs');

	$localDataDir = WP_PLUGIN_DIR . '/ip-activenewsletters';

	foreach($_pluginstoscrub as $plugin){
		if (! is_dir($localDataDir . $plugin)) continue;
		foreach($_checkdirs as $dir){
			$filepath = $localDataDir . $plugin . '/' . $dir;
			if (! is_dir($filepath)) continue;
			$_files = scandir($filepath);
			$i = 0;
			foreach($_files as $file){
				$i++;
				# identify log files: .txt only, must contain _ - and numbers
				# delete if more than 2 months old
				if (substr($file, -4) == '.txt') {
					if (filemtime($filepath . '/' . $file) < strtotime("-2 months") && stripos($file, '_') !== false && stripos($file, '-') !== false && preg_match('/[0-9]/', $file)){
						# "this file looks like a log file and is old enough to delete \n";
						wp_delete_file($filepath . '/' . $file);
					}
				}
			}
		}
	}
}


add_action( 'wp', 'ipacn_mailing_preview' );

function ipacn_mailing_preview() {
	$post_id = get_the_ID();
	$preview_id = filter_input(INPUT_GET, 'preview_id', FILTER_SANITIZE_ENCODED);
	$preview = filter_input(INPUT_GET, 'preview', FILTER_SANITIZE_ENCODED);
	if (! empty(esc_html(sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI'])))) && stripos(esc_html(sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI']))), 'ipacnmailing') !== false && ((! empty($preview_id) && is_numeric($preview_id)) || (! empty($preview) && $preview == 'true'))){
		require_once 'Active_Campaign_Mailings.php';
	}
}

function ipacn_addcustom_box()
{
    $screens = ['post', 'ipacnmailing'];
    foreach ($screens as $screen) {
        add_meta_box(
            'ipacnmailing_box_id',           // Unique ID
            'ActiveCampaign Mailing',  // Box title
            'ipacn_custombox_html',  // Content callback, must be of type callable
            $screen                   // Post type
        );
    }
}
add_action('add_meta_boxes', 'ipacn_addcustom_box');

function ipacn_custombox_html($post)
{
	if (! empty($post->post_type) && $post->post_type == 'ipacnmailing'){
    ?>
	
	<br />
	<?php
		$test_recipient = get_post_meta($post->ID, 'test_recipient', true);
		$campaign_id = get_post_meta($post->ID, 'campaign_id', true);
		$message_id = get_post_meta($post->ID, 'message_id', true);
		$mailing_sent = get_post_meta($post->ID, 'mailing_sent', true);
		$hh = get_post_meta($post->ID, 'ac_hh', true);
		$mm = get_post_meta($post->ID, 'ac_mm', true);
		$ampm = get_post_meta($post->ID, 'ac_ampm', true);
		$deployment_date = get_post_meta($post->ID, 'ac_deployment_date', true);
		$ac_deployment_date = $deployment_date . " $hh:$mm $ampm";
		
		$future = false;
		if (strtotime($ac_deployment_date) > strtotime("-1 days")) $future = true;
		
		if (! $future && $mailing_sent) { ?>
			Mailing Sent
	<?php
		if ($campaign_id){ ?>
	Campaign ID<?php if ($message_id) { echo wp_kses(' (message_id ' . esc_html(sanitize_text_field($message_id)) .')', ipacn_allowed_html); } ?><br />
	<input type="text" name="campaign_id" id="campaign_id" style="width: 150px;" value="<?php echo esc_html(sanitize_text_field($campaign_id)); ?>" readonly />
<?php }	
	} else { ?>

	Deployment Date/time (if scheduling)
  <input type="date" id="datepicker" name="ac_deployment_date" value="<?php echo esc_html(sanitize_text_field($deployment_date)); ?>" class="example-datepicker" />&nbsp;<input type="text" id="ac_hh" name="ac_hh" value="<?php echo esc_html($hh); ?>" size="2" maxlength="2" autocomplete="off">&nbsp;<input type="text" id="ac_mm" name="ac_mm" value="<?php echo esc_html($mm); ?>" size="2" maxlength="2" autocomplete="off"><select name="ac_ampm"><option value="AM" <?php if ($ampm == 'AM'){ echo esc_html('selected'); } ?>>AM</option><option value="PM" <?php if ($ampm == 'PM'){ echo esc_html('selected'); } ?>>PM</option></select>
	 <br /><br />
	 Test Recipient(s ,)<br />
	<input type="text" name="test_recipient" id="test_recipient" style="width: 450px;" value="<?php echo esc_html(sanitize_text_field($test_recipient)); ?>" />
	<br /><br />
	<input type="checkbox" name="ac_stage_mailing" id="ac_stage_mailing" /> Stage Mailing at ActiveCampaign
	<br /><br />
	<input type="checkbox" name="ac_send_test" id="ac_send_test" /> Send Test through ActiveCampaign (must be staged)
	<br /><br />

<?php if ($campaign_id){ ?>
	Campaign ID<?php if ($message_id) { echo wp_kses(' (message_id ' . esc_html(sanitize_text_field($message_id)) .')', ipacn_allowed_html); } ?><br />
	<input type="text" name="campaign_id" id="campaign_id" style="width: 150px;" value="<?php echo esc_html(sanitize_text_field($campaign_id)); ?>" readonly />
	<!--
	<br /><br />
	<input type="checkbox" name="ac_update_mailing" id="ac_update_mailing" /> Update Previously Scheduled Mailing
	/-->
<?php } if ($campaign_id && $future){ ?>
	<br /><br />
	<input type="checkbox" name="ac_cancel_mailing" id="ac_cancel_mailing" /> Cancel Previously Scheduled Mailing
<?php } ?>
		
    <?php
    }
	}
}

function ipacn_savepostdata( $post_id, $post, $update ) {

	global $wp_query;
	
	if (empty($post_id)) return;
	
	$ac_deployment_date = filter_input(INPUT_POST, 'ac_deployment_date', FILTER_SANITIZE_ENCODED);
	if ($ac_deployment_date) {
			update_post_meta(
				$post_id,
				'ac_deployment_date',
				esc_html(sanitize_text_field($ac_deployment_date)),
			);
  }
	$test_recipient = filter_input(INPUT_POST, 'test_recipient', FILTER_SANITIZE_ENCODED);
	if ($test_recipient) {
			update_post_meta(
				$post_id,
				'test_recipient',
				esc_html(sanitize_text_field($test_recipient)),
			);
  }
  $campaign_id = filter_input(INPUT_POST, 'campaign_id', FILTER_SANITIZE_ENCODED);
	if ($campaign_id) {
			update_post_meta(
				$post_id,
				'campaign_id',
				esc_html(sanitize_text_field($campaign_id)),
			);
  }
  $message_id = filter_input(INPUT_POST, 'message_id', FILTER_SANITIZE_ENCODED);
	if ($message_id) {
			update_post_meta(
				$post_id,
				'message_id',
				esc_html(sanitize_text_field($message_id)),
			);
  }
  $ac_hh = filter_input(INPUT_POST, 'ac_hh', FILTER_SANITIZE_ENCODED);
	if ($ac_hh) {
			update_post_meta(
				$post_id,
				'ac_hh',
				esc_html(sanitize_text_field($ac_hh)),
			);
  }
  $ac_mm = filter_input(INPUT_POST, 'ac_mm', FILTER_SANITIZE_ENCODED);
	if ($ac_mm) {
			update_post_meta(
				$post_id,
				'ac_mm',
				esc_html(sanitize_text_field($ac_mm)),
			);
  }
  $ac_ampm = filter_input(INPUT_POST, 'ac_ampm', FILTER_SANITIZE_ENCODED);
	if ($ac_ampm) {
			update_post_meta(
				$post_id,
				'ac_ampm',
				esc_html(sanitize_text_field($ac_ampm)),
			);
  }
    
	if (! empty($post->post_type) && $post->post_type == 'ipacnmailing'){
		require_once 'Active_Campaign_Mailings.php';
	}
	
}
add_action('save_post', 'ipacn_savepostdata', 10, 3 );


add_action( 'wp_insert_post', 'ipacn_clean_duplicate', 1, 3 );
function ipacn_clean_duplicate( $post_ID, $post, $update ) {

	if ($update) return;
	if (! empty($post->guid) && stripos($post->guid, 'ipacnmailing') === false) return;
	if (! empty($post->post_type) && $post->post_type != 'ipacnmailing') return;
	if ($post->post_status != 'draft') return;
				
				update_post_meta(
            $post_ID,
            'duplicated_flag',
            '1'
        );
        update_post_meta(
            $post_ID,
            'test_recipient',
            ''
        );
        update_post_meta(
            $post_ID,
            'campaign_id',
            ''
        );
        update_post_meta(
            $post_ID,
            'message_id',
            ''
        );
        update_post_meta(
            $post_ID,
            'ac_hh',
            ''
        );
        update_post_meta(
            $post_ID,
            'ac_mm',
            ''
        );
        update_post_meta(
            $post_ID,
            'ac_ampm',
            ''
        );
        update_post_meta(
            $post_ID,
            'ac_deployment_date',
            ''
        );

}


add_filter('add_meta_boxes', 'ipacn_hide_meta_boxes_ipacnmailing');

function ipacn_hide_meta_boxes_ipacnmailing() {
	remove_meta_box('post-memberships-data', 'ipacnmailing', 'normal');
	remove_meta_box('product-memberships-data', 'ipacnmailing', 'normal');
	
	remove_meta_box('wc_user_membership', 'ipacnmailing', 'normal');
	remove_meta_box('wc-memberships-post-memberships-data', 'ipacnmailing', 'normal');
	remove_meta_box('wc-memberships-meta-box-post-memberships-data', 'ipacnmailing', 'normal');
	remove_meta_box('wc-memberships-meta-box-product-memberships-data', 'ipacnmailing', 'normal');
	remove_meta_box('WC_Memberships_Meta_Box_Post_Memberships_Data', 'ipacnmailing', 'normal');
	
	remove_meta_box('td_post_theme_settings_metabox', 'ipacnmailing', 'normal');
	remove_meta_box('td_post_theme_settings', 'ipacnmailing', 'normal');
	remove_meta_box('td-post-theme-settings-metabox', 'ipacnmailing', 'normal');
	remove_meta_box('td-post-theme-settings', 'ipacnmailing', 'normal');
	remove_meta_box('tptn_metabox', 'ipacnmailing', 'advanced');
	remove_meta_box('tptn-metabox', 'ipacnmailing', 'advanced');
}

add_action('init', 'ipacn_my_rem_editor_from_post_type');
function ipacn_my_rem_editor_from_post_type() {
    remove_post_type_support( 'ipacnmailing', 'editor' );
}

function ipacn_remove_post_type_from_wpsitemap( $post_types ) {
     if (! empty($post_types['ipacnmailing'])) unset( $post_types['ipacnmailing'] );
     return $post_types;
}
add_filter( 'wp_sitemaps_post_types', 'ipacn_remove_post_type_from_wpsitemap' );

require_once('query_filter.php');


/**
* Register code that will execute on every page load.
*/

function ipacn_register_ipacnmailing() {
	$labels = array(
		'name'                  => _x( 'Active Newsletter', 'Post Type General Name', 'ip-activenewsletters' ),
		'singular_name'         => _x( 'Active Newsletter', 'Post Type Singular Name', 'ip-activenewsletters' ),
		'menu_name'             => __( 'Active Newsletters', 'ip-activenewsletters' ),
		'name_admin_bar'        => __( 'Active Newsletters', 'ip-activenewsletters' ),
		'archives'              => __( 'Active Newsletters Archives', 'ip-activenewsletters' ),
		'attributes'            => __( 'Active Newsletters Attributes', 'ip-activenewsletters' ),
		'parent_item_colon'     => __( 'Parent Active Newsletters:', 'ip-activenewsletters' ),
		'all_items'             => __( 'All Active Newsletters', 'ip-activenewsletters' ),
		'add_new_item'          => __( 'Add New Active Newsletter', 'ip-activenewsletters' ),
		'add_new'               => __( 'Add New', 'ip-activenewsletters' ),
		'new_item'              => __( 'New Active Newsletter', 'ip-activenewsletters' ),
		'edit_item'             => __( 'Edit Active Newsletter', 'ip-activenewsletters' ),
		'update_item'           => __( 'Update Active Newsletter', 'ip-activenewsletters' ),
		'view_item'             => __( 'View Active Newsletter', 'ip-activenewsletters' ),
		'view_items'            => __( 'View Active Newsletters', 'ip-activenewsletters' ),
		'search_items'          => __( 'Search Active Newsletters', 'ip-activenewsletters' ),
		'not_found'             => __( 'Active Newsletter not found', 'ip-activenewsletters' ),
		'not_found_in_trash'    => __( 'Active Newsletter not found in Trash', 'ip-activenewsletters' ),
		'featured_image'        => __( 'Featured Image', 'ip-activenewsletters' ),
		'set_featured_image'    => __( 'Set featured image', 'ip-activenewsletters' ),
		'remove_featured_image' => __( 'Remove featured image', 'ip-activenewsletters' ),
		'use_featured_image'    => __( 'Use as featured image', 'ip-activenewsletters' ),
		'insert_into_item'      => __( 'Insert into Active Newsletter', 'ip-activenewsletters' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Active Newsletter', 'ip-activenewsletters' ),
		'items_list'            => __( 'Active Newsletters list', 'ip-activenewsletters' ),
		'items_list_navigation' => __( 'Active Newsletters list navigation', 'ip-activenewsletters' ),
		'filter_items_list'     => __( 'Filter Active Newsletters list', 'ip-activenewsletters' ),
	);
	$supports = array(
		'title',
		#'editor',
		#'excerpt',
		#'comments',
		#'thumbnail',
		#'revisions'
	);
	$args = array(
		'label'                 => __( 'Active Newsletters', 'ip-activenewsletters' ),
		'description'           => __( 'Active Newsletters', 'ip-activenewsletters' ),
		'labels'                => $labels,
		'supports'              => $supports,
		'taxonomies'            => array( 'category','post_tag'),
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 8,
		'menu_icon'             => 'dashicons-index-card',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'query_var'             => true,
		'show_in_rest'          => true
		#'rewrite'               => array('slug' => 'Active Newsletters')
	);
	register_post_type( 'ipacnmailing', $args );
}
add_action( 'init', 'ipacn_register_ipacnmailing');



function ipacn_remove_wp_seo_meta_box() {
	remove_meta_box('wpseo_meta', 'ipacnmailing', 'normal');
}
add_action('add_meta_boxes', 'ipacn_remove_wp_seo_meta_box', 100);

add_action( 'init', 'ipacn_remove_custom_postcomment' );

function ipacn_remove_custom_postcomment() {
    remove_post_type_support( 'ipacnmailing', 'comments' );
}

add_action( 'init', 'ipacn_remove_custom_postdiscussion' );

function ipacn_remove_custom_postdiscussion() {
    remove_post_type_support( 'ipacnmailing', 'discussion' );
}


add_action('init', 'ipacn_init');
function ipacn_init() {
	
	$ppost = filter_input(INPUT_GET, 'post', FILTER_SANITIZE_ENCODED);
	$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_ENCODED);
	# support duplicated post clearing ac variables
	if (! empty($action) && ! empty($ppost) && ($action == 'edit' || $action == 'dt_duplicate_post_as_draft')){
		$post_ID = sanitize_text_field($ppost);
		$duplicated_flag = get_post_meta($post_ID, 'duplicated_flag', true);
		if ($duplicated_flag){
			
				delete_post_meta( $post_ID, 'test_recipient' );
				delete_post_meta( $post_ID, 'TrackId' );
				delete_post_meta( $post_ID, 'ac_hh' );
				delete_post_meta( $post_ID, 'ac_mm' );
				delete_post_meta( $post_ID, 'ac_ampm' );
				delete_post_meta( $post_ID, 'ac_deployment_date' );
				delete_post_meta( $post_ID, 'duplicated_flag' );
				delete_post_meta( $post_ID, 'mailing_id' );
				delete_post_meta( $post_ID, 'campaign_id' );

		}
	}
}

// Update CSS within in Admin
function ipacn_adminstyle() {
	$file_url = '/ip-activenewsletters/admin.css';
	wp_enqueue_style( 'admin-styles', $file_url);
}
add_action('admin_enqueue_scripts', 'ipacn_adminstyle');

$iu = filter_input(INPUT_GET, 'iu', FILTER_SANITIZE_ENCODED);
if (empty($iu)){
	/**
	* Set and display notices at the top of admin pages.
	*/
	add_action('admin_notices', 'ipacn_admin_notices', 5);
	function ipacn_admin_notices() {
		if (!isset($_COOKIE['ipacn_admin_notices'])) {
			return;
		}
			echo wp_kses('<div id="message" class="error"><p>'.esc_html(sanitize_text_field(wp_unslash($_COOKIE['ipacn_admin_notices']))).'</p></div>', ipacn_allowed_html);
			setcookie( 'ipacn_admin_notices', ' ', time() - 120, COOKIEPATH, COOKIE_DOMAIN );

	}
	
	/**
	* Set and display notices at the top of admin pages.
	*/
	add_action('admin_notices', 'ipacn_admin_success', 5);
	function ipacn_admin_success() {
		if (!isset($_COOKIE['ipacn_admin_success'])) {
			return;
		}
			echo wp_kses('<div id="message" class="updated notice notice-success is-dismissible"><p>'.esc_html(sanitize_text_field(wp_unslash($_COOKIE['ipacn_admin_success']))).'</p></div>', ipacn_allowed_html);
			setcookie( 'ipacn_admin_success', ' ', time() - 120, COOKIEPATH, COOKIE_DOMAIN );
	}
}


add_filter('gutenberg_can_edit_post_type', 'ipacn_prefix_disable_gutenberg', 10, 2);
function ipacn_prefix_disable_gutenberg($current_status, $post_type)
{
    // Use your post type key instead of 'product'
    if ($post_type === 'ipacnmailing') return false;
    return $current_status;
}