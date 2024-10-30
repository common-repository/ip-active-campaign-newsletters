<?php
/**
* Adds a settings page in admin.
*
*/
if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define('ipacn_SETTINGS_FIELD_PREFIX', 'ipacn_');
define('ipacn_OPTIONS_PAGE_ID', 'ipacn');

add_action('admin_menu', 'ipacn_add_options_page');
function ipacn_add_options_page() {
	add_options_page('ActiveCampaign Newsletters Options', 'ActiveCampaign Newsletters', 'manage_options', ipacn_OPTIONS_PAGE_ID, 'ipacn_options_page');
} 
function ipacn_options_page() {
	?>
	<div class="wrap">
	<form method="post" action="options.php">
	<?php
	settings_fields('ipacn_options');
	do_settings_sections(ipacn_OPTIONS_PAGE_ID);
	submit_button();
	?>
	</form>
	</div>
<?php
}

add_action('admin_init', 'ipacn_admin_init');
function ipacn_admin_init() {
	# the settings def is organized into sections at the top level
	foreach (ipacn_settings_def() as $section_id => $section_def_ar) {
		$fully_qualified_section_id = ipacn_SETTINGS_FIELD_PREFIX . $section_id;
		$section_title = isset($section_def_ar['#title']) ? $section_def_ar['#title'] : $section_id;
		$section_description = isset($section_def_ar['#description']) ? $section_def_ar['#description'] : '';
		add_settings_section($fully_qualified_section_id, $section_title, 'ipacn_admin_section_text', ipacn_OPTIONS_PAGE_ID);

		# each section contains one or more settings
		foreach ($section_def_ar as $setting_id => $setting_def) {
			if ('#' == substr($setting_id, 0, 1)) {
				continue;
			}

			# each setting should be prefixed with a string to guarantee uniqueness
			$fully_qualified_field_id = ipacn_SETTINGS_FIELD_PREFIX . $setting_id;

			# register the setting with WordPress so it will save the field's value
			register_setting('ipacn_options', $fully_qualified_field_id);

			# the form element's id and name are always the same as the fully qualified setting id
			$setting_def['#id'] = $fully_qualified_field_id;
			$setting_def['#name'] = $fully_qualified_field_id;

			# add the field to the appropriate section
			add_settings_field($fully_qualified_field_id, $setting_def['#title'], 'ipacn_admin_setting', ipacn_OPTIONS_PAGE_ID, $fully_qualified_section_id, $setting_def);
		}
	}
}
function ipacn_admin_section_text($args) {
	$def_ar = ipacn_settings_def();
	$id = $args['id'];
	if (0 === strpos($id, ipacn_SETTINGS_FIELD_PREFIX)) {
		$id = substr($id, strlen(ipacn_SETTINGS_FIELD_PREFIX));
	}
	if (isset($def_ar[$id]['#description'])) {
		echo wp_kses("<p class=\"description\">{$def_ar[$id]['#description']}</p>", ipacn_allowed_html);
	}
}
function ipacn_admin_setting($args) {
	foreach (array(
		'type',
		'name',
		'size',
		'id',
		'rows',
		'cols') as $attr_name
	) {
		${$attr_name} = isset($args["#$attr_name"]) ? "$attr_name=\"{$args["#$attr_name"]}\"" : '';
	}

	$value = isset($args['#id']) ? sanitize_text_field('value="' . htmlspecialchars(esc_html(get_option($args['#id'])))) . '"' : '';

	$checked = '';
	if ('checkbox' == $args['#type']) {
		$value = 'value="1"';
		if (esc_html(get_option($args['#id']))) {
			$checked = sanitize_text_field('CHECKED="1"');
		}
	}

	switch ($args['#type']) {
		case 'select':
			echo wp_kses("<select $name $id>", ipacn_allowed_html);
			if (!empty($args['#options'])) {
				foreach ($args['#options'] as $k => $v) {
					$k_escaped = htmlspecialchars($k);
					$v_escaped = htmlspecialchars($v);
					$selected  = ($k == esc_html(sanitize_text_field(get_option($args['#id'])))) ? 'selected="1"' : '';
					echo wp_kses("<option value=\"$k_escaped\" $selected>$v_escaped</option>", ipacn_allowed_html);
				}
			}
			echo wp_kses("</select>", ipacn_allowed_html);
			break;
		case 'textarea':
			$value = isset($args['#id']) ? htmlspecialchars(esc_html(sanitize_text_field(get_option($args['#id'])))) : '';
			echo wp_kses("<textarea $rows $cols $name $id>$value</textarea>", ipacn_allowed_html);
			break;
		case 'textfield':
		case 'checkbox':
		default:
			echo wp_kses("<input $type $name $id $size $value $checked />", ipacn_allowed_html);
			break;
	}

	# if a value to use when the field is left empty is specified, add to the descriptive text to
	# indicate what value will be assumed when the field is left blank
	if (!empty($args['#empty_value'])) {
		if (!isset($args['#description'])) {
			$args['#description'] = '';
		}
		$args['#description'] .= sanitize_text_field(" Optional. Defaults to {$args['#empty_value']}.");
	}

	# display a description underneath the input if we have one to display
	if (!empty($args['#description'])) {
		echo wp_kses("<p class=\"description\">{$args['#description']}</p>", ipacn_allowed_html);
	}
}

/**
* Get the value of an option, heeding defaults that are present in the settings definition.
*/
function ipacn_get_option($option_id, $default = '') {

	# can't get an option identifier that is empty
	if (empty($option_id)) {
		return false;
	}

	# add a prefix if it is not present; all module options are stored using this prefix
	if (0 === strpos($option_id, ipacn_SETTINGS_FIELD_PREFIX)) {
		$prefixed_option_id = $option_id;
		$option_id = substr($option_id, strlen(ipacn_SETTINGS_FIELD_PREFIX));
	} else {
		$prefixed_option_id = ipacn_SETTINGS_FIELD_PREFIX . $option_id;
	}

	# get the default value of this setting
	$result = ipacn_get_option_default($option_id);
	if (false !== $result) {
		$default = $result;
	}

	# return the value of the requested option
	$result = get_option($prefixed_option_id, $default);
	if (empty($result)) {
		$result = $default;
	}
	return $result;
}

/**
* Retrieve the default value of a setting.
*/
function ipacn_get_option_default($option_id, $settings_def = '') {
	if (empty($settings_def)) {
		return ipacn_get_option_default($option_id, ipacn_settings_def());
	}
	
	foreach ($settings_def as $k => $v) {
		if ('#' == $k[0] || !is_array($v)) continue;
		if ($k == $option_id && isset($v['#empty_value'])) {
			return $v['#empty_value'];
		}
		$result = ipacn_get_option_default($option_id, $v);
		if (false !== $result) {
			return $result;
		}
	}

	return false;
}

/**
* Define all of the plug-in's settings.
*
* This controls how the settings are presented and organized in the plug-in's settings page.
*/
function ipacn_settings_def() {
	return array(
		'integration' => array(
			'#title' => 'ActiveCampaign Newsletters',
			'#description' => 'Send ActiveCampaign mailings through WordPress<br />',
	                       
                        
                        'api_key' => array(
                                '#title' => 'API key',
                                '#type' => 'textfield',
                                '#size' => 60,
                                '#description' => '<a href="https://www.iproduction.com/active-campaign-newsletters-wordpress-plugin">FAQ</a><br />'
                        ),
                        'from_name' => array(
                                '#title' => 'From Name',
                                '#type' => 'textfield',
                                '#size' => 60,
                        ),
                        'from_email' => array(
                                '#title' => 'From Email Address',
                                '#type' => 'textfield',
                                '#size' => 60,
                        ),

                        'reply_to' => array(
                                '#title' => 'Reply to',
                                '#type' => 'textfield',
                                '#size' => 60,
                        ),
												'api_url' => array(
                                '#title' => 'API url',
                                '#type' => 'textfield',
                                '#size' => 60,
                        ),
						
		),
	);
}
