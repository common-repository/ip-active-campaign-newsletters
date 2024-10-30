<?php

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class for managing API calls
 *
 */
class IPACNAPI {

	private $debug = '';
	private $api_key = '';
  private $api_url = '';
	private $omeda_staging = '';
	private $ac_from_name = '';
	private $ac_from_email = '';
	private $ac_reply_to = '';
	private $log_file = '';
	private $license_key = '';
	private $endpoint = '';
	
	/**
	 * @method __construct The constructor.
	 */
	function __construct() {
		$this->debug = '';
		$this->api_key = get_option('ipacn_api_key');
		$this->api_url = get_option('ipacn_api_url');
		$this->ac_from_name = get_option('ipacn_from_name');
		$this->ac_from_email = get_option('ipacn_from_email');
		$this->ac_reply_to = get_option('ipacn_reply_to');
		$this->license_key = 'freeversion';
		$this->endpoint = 'https://www.iproduction.com/wp-content/plugins/ip-active-campaign-newsletters/active_campaign_endpoint.php';
		$this->ac_logging = get_option('ipacn_logging');
	}
	
    public function campaign_status($_message) {
			$this->log_file = '';
			if (empty($this->api_key)){
				$this->logging('', '', 'api_key not set');
				return false;
			}
			if (empty($this->api_url)){
				$this->logging('', '', 'api_url not set');
				return false;
			}

			
			if (empty($this->license_key)){
				$this->logging('', '', 'license key not set');
				return false;
			}
			
			$_message['domain'] = get_site_url();
			$_message['license_key'] = $this->license_key;
			$_message['action'] = 'campaign_status';
			$_message['api_key'] = $this->api_key;
			$_message['api_url'] = $this->api_url;
			
foreach($_message as $key => $item){
	$_message[$key] = str_ireplace('<', '&lt;', $item);
	$_message[$key] = str_ireplace('>', '&gt;', $item);
}

$args = array(
	'body'        => wp_json_encode($_message),
	'timeout'     => '60',
	'redirection' => '60',
	'httpversion' => '1.1',
	'blocking'    => true,
	'headers'     => array(
					'POST',
					'HTTP/1.1',
					'Content-type: application/json',
			),
	'cookies'     => array(),
);

$result = wp_remote_post( $this->endpoint, $args );
$result = ! empty($result['body']) ? json_decode($result['body'], true) : '';
$headers = ! empty($result['headers']) ? $result['response'] : '';
$response = ! empty($result['response']) ? $result['response'] : '';
		
			
			if (! empty($result['result_code']) && $result['result_code'] == 1){
				$this->logging($_message, $result, 'campaign_status success');
				return $result;
			}
			else{
				$this->logging($_message, $result, 'campaign_status failure');
				return $result;	
			}
	}
	
    public function message_edit($_message) {
			$this->log_file = '';
			if (empty($this->api_key)){
				$this->logging('', '', 'api_key not set');
				return false;
			}
			if (empty($this->api_url)){
				$this->logging('', '', 'api_url not set');
				return false;
			}
			if (empty($this->ac_from_name)){
				$this->logging('', '', 'ac_from_name not set');
				return false;
			}
			if (empty($this->ac_from_email)){
				$this->logging('', '', 'ac_from_email not set');
				return false;
			}

			
			if (empty($this->license_key)){
				$this->logging('', '', 'license key not set');
				return false;
			}
			
			$_message['domain'] = get_site_url();
			$_message['license_key'] = $this->license_key;
			$_message['action'] = 'message_edit';
			$_message['api_key'] = $this->api_key;
			$_message['api_url'] = $this->api_url;
			$_message['message']['fromname'] = $this->ac_from_name;
			$_message['message']['fromemail'] = $this->ac_from_email;
			$_message['message']['reply2'] = $this->ac_reply_to;
			
foreach($_message as $key => $item){
	$_message[$key] = str_ireplace('<', '&lt;', $item);
	$_message[$key] = str_ireplace('>', '&gt;', $item);
}

$args = array(
	'body'        => wp_json_encode($_message),
	'timeout'     => '60',
	'redirection' => '60',
	'httpversion' => '1.1',
	'blocking'    => true,
	'headers'     => array(
					'POST',
					'HTTP/1.1',
					'Content-type: application/json',
			),
	'cookies'     => array(),
);

$result = wp_remote_post( $this->endpoint, $args );
$result = ! empty($result['body']) ? json_decode($result['body'], true) : '';
$headers = ! empty($result['headers']) ? $result['response'] : '';
$response = ! empty($result['response']) ? $result['response'] : '';
		

			
			if (! empty($result['result_code']) && $result['result_code'] == 1){
				$this->logging($_message, $result, 'edit success');
				return $result;
			}
			else{
				$this->logging($_message, $result, 'edit failure');
				return $result;	
			}
	}
	
    public function message_add($_message) {
			$this->log_file = '';
			if (empty($this->api_key)){
				$this->logging('', '', 'api_key not set');
				return false;
			}
			if (empty($this->api_url)){
				$this->logging('', '', 'api_url not set');
				return false;
			}
			if (empty($this->ac_from_name)){
				$this->logging('', '', 'ac_from_name not set');
				return false;
			}
			if (empty($this->ac_from_email)){
				$this->logging('', '', 'ac_from_email not set');
				return false;
			}


			
			if (empty($this->license_key)){
				$this->logging('', '', 'license key not set');
				return false;
			}
			
			$_message['domain'] = get_site_url();
			$_message['license_key'] = $this->license_key;
			$_message['action'] = 'message_add';
			$_message['api_key'] = $this->api_key;
			$_message['api_url'] = $this->api_url;
			$_message['message']['fromname'] = $this->ac_from_name;
			$_message['message']['fromemail'] = $this->ac_from_email;
			$_message['message']['reply2'] = $this->ac_reply_to;
			
foreach($_message as $key => $item){
	$_message[$key] = str_ireplace('<', '&lt;', $item);
	$_message[$key] = str_ireplace('>', '&gt;', $item);
}

$args = array(
	'body'        => wp_json_encode($_message),
	'timeout'     => '60',
	'redirection' => '60',
	'httpversion' => '1.1',
	'blocking'    => true,
	'headers'     => array(
					'POST',
					'HTTP/1.1',
					'Content-type: application/json',
			),
	'cookies'     => array(),
);

$result = wp_remote_post( $this->endpoint, $args );
$result = ! empty($result['body']) ? json_decode($result['body'], true) : '';
$headers = ! empty($result['headers']) ? $result['response'] : '';
$response = ! empty($result['response']) ? $result['response'] : '';
		

			
			if (! empty($result['result_code']) && $result['result_code'] == 1){
				$this->logging($_message, $result, 'Insert success');
				return $result;
			}
			else{
				$this->logging($_message, $result, 'Insert failure');
				return $result;	
			}
	}

    public function campaign_create($_message) {
			$this->log_file = '';
			if (empty($this->api_key)){
				$this->logging('', '', 'api_key not set');
				return false;
			}
			if (empty($this->api_url)){
				$this->logging('', '', 'api_url not set');
				return false;
			}
			if (empty($this->ac_from_name)){
				$this->logging('', '', 'ac_from_name not set');
				return false;
			}
			if (empty($this->ac_from_email)){
				$this->logging('', '', 'ac_from_email not set');
				return false;
			}

			
			if (empty($this->license_key)){
				$this->logging('', '', 'license key not set');
				return false;
			}
			
			$_message['domain'] = get_site_url();
			$_message['license_key'] = $this->license_key;
			$_message['action'] = 'campaign_create';
			$_message['api_key'] = $this->api_key;
			$_message['api_url'] = $this->api_url;
			
foreach($_message as $key => $item){
	$_message[$key] = str_ireplace('<', '&lt;', $item);
	$_message[$key] = str_ireplace('>', '&gt;', $item);
}

$args = array(
	'body'        => wp_json_encode($_message),
	'timeout'     => '60',
	'redirection' => '60',
	'httpversion' => '1.1',
	'blocking'    => true,
	'headers'     => array(
					'POST',
					'HTTP/1.1',
					'Content-type: application/json',
			),
	'cookies'     => array(),
);

$result = wp_remote_post( $this->endpoint, $args );
$result = ! empty($result['body']) ? json_decode($result['body'], true) : '';
$headers = ! empty($result['headers']) ? $result['response'] : '';
$response = ! empty($result['response']) ? $result['response'] : '';
		

			
			if (! empty($result['result_code']) && $result['result_code'] == 1){
				$this->logging($_message, $result, 'Insert success');
				return $result;
			}
			else{
				$this->logging($_message, $result, 'Insert failure');
				return $result;	
			}
	}

    public function campaign_send($_message) {
			$this->log_file = '';
			if (empty($this->api_key)){
				$this->logging('', '', 'api_key not set');
				return false;
			}
			if (empty($this->api_url)){
				$this->logging('', '', 'api_url not set');
				return false;
			}
			if (empty($this->ac_from_name)){
				$this->logging('', '', 'ac_from_name not set');
				return false;
			}
			if (empty($this->ac_from_email)){
				$this->logging('', '', 'ac_from_email not set');
				return false;
			}

			
			if (empty($this->license_key)){
				$this->logging('', '', 'license key not set');
				return false;
			}
			
			$_message['domain'] = get_site_url();
			$_message['license_key'] = $this->license_key;
			$_message['action'] = 'campaign_send';
			$_message['api_key'] = $this->api_key;
			$_message['api_url'] = $this->api_url;
			
foreach($_message as $key => $item){
	$_message[$key] = str_ireplace('<', '&lt;', $item);
	$_message[$key] = str_ireplace('>', '&gt;', $item);
}

$args = array(
	'body'        => wp_json_encode($_message),
	'timeout'     => '60',
	'redirection' => '60',
	'httpversion' => '1.1',
	'blocking'    => true,
	'headers'     => array(
					'POST',
					'HTTP/1.1',
					'Content-type: application/json',
			),
	'cookies'     => array(),
);

$result = wp_remote_post( $this->endpoint, $args );
$result = ! empty($result['body']) ? json_decode($result['body'], true) : '';
$headers = ! empty($result['headers']) ? $result['response'] : '';
$response = ! empty($result['response']) ? $result['response'] : '';
		

			
			if (! empty($result['result_code']) && $result['result_code'] == 1){
				$this->logging($_message, $result, 'Campaign successfully scheduled');
				return $result;
			}
			else{
				$this->logging($_message, $result, 'Campaign schedule failed');
				return $result;	
			}
	}	
	
    public function campaign_delete($_message) {
			$this->log_file = '';
			if (empty($this->api_key)){
				$this->logging('', '', 'api_key not set');
				return false;
			}
			if (empty($this->api_url)){
				$this->logging('', '', 'api_url not set');
				return false;
			}


			
			if (empty($this->license_key)){
				$this->logging('', '', 'license key not set');
				return false;
			}
			
			$_message['domain'] = get_site_url();
			$_message['license_key'] = $this->license_key;
			$_message['action'] = 'campaign_delete';
			$_message['api_key'] = $this->api_key;
			$_message['api_url'] = $this->api_url;
			
foreach($_message as $key => $item){
	$_message[$key] = str_ireplace('<', '&lt;', $item);
	$_message[$key] = str_ireplace('>', '&gt;', $item);
}

$args = array(
	'body'        => wp_json_encode($_message),
	'timeout'     => '60',
	'redirection' => '60',
	'httpversion' => '1.1',
	'blocking'    => true,
	'headers'     => array(
					'POST',
					'HTTP/1.1',
					'Content-type: application/json',
			),
	'cookies'     => array(),
);

$result = wp_remote_post( $this->endpoint, $args );
$result = ! empty($result['body']) ? json_decode($result['body'], true) : '';
$headers = ! empty($result['headers']) ? $result['response'] : '';
$response = ! empty($result['response']) ? $result['response'] : '';
		

			
			if (! empty($result['result_code']) && $result['result_code'] == 1){
				$this->logging($_message, $result, 'campaign_delete success');
				return $result;
			}
			else{
				$this->logging($_message, $result, 'campaign_delete failure');
				return $result;	
			}
	}
    
	public function logging($data, $response, $label) {
		#if (! empty($data['message']['html'])) unset($data['message']['html']);
		if (! empty($data['api_key'])) unset($data['api_key']);
		if (! empty($data['license_key'])) unset($data['license_key']);
	}
	
}
