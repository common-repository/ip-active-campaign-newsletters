<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if (! function_exists('acf_get_field_group_post')) return;

		$acfp = esc_html(sanitize_text_field(filter_input(INPUT_GET, 'acfp', FILTER_SANITIZE_ENCODED)));
		if (! empty($acfp)) return;
		
		$do_acf_update = esc_html(sanitize_text_field(filter_input(INPUT_GET, 'do_acf_update', FILTER_SANITIZE_ENCODED)));
		$do_acf_purge = esc_html(sanitize_text_field(filter_input(INPUT_GET, 'do_acf_purge', FILTER_SANITIZE_ENCODED)));
		
		if (! empty($do_acf_purge)){
			$post_parent = acf_get_field_group_post('group_ipacnmailing');
			if (! empty($post_parent->ID)){
				
				$post_meta = get_post_meta($post_parent->ID);
				foreach($post_meta as $key => $item){
					delete_post_meta( $post_parent->ID, $key );
				}
				
				$query_args = array();
				$query_args['post_type'] = 'acf-field';
				$query_args['post_status'] = 'any';
				$query_args['numberposts'] = '-1';
				$query_args['post_parent'] = $post_parent->ID;
				
				$_posts = get_posts( $query_args );
				foreach($_posts as $acf){
					if (! empty($acf->ID)){
						wp_delete_post( $acf->ID, true );
					}
				}
				wp_delete_post( $post_parent->ID, true );
			}

			header('Location: ' . get_site_url() . '/wp-admin/edit.php?post_type=acf-field-group&acfp=1');
			exit;
		}
		
		if (! empty($do_acf_purge)) exit;
		
		$update_parent = '';
		if (! empty($do_acf_update)){
			$post_parent = acf_get_field_group_post('group_ipacnmailing');
			$update_parent = ! empty($post_parent->ID) ? $post_parent->ID : '';
		}
		else{
			if (! empty(acf_get_field_group_post('group_ipacnmailing'))) return;
		}
		
		$_location = array();
		$_location['group_0']['rule_0']['param'] = 'post_type';
		$_location['group_0']['rule_0']['operator'] = '==';
		$_location['group_0']['rule_0']['value'] = 'ipacnmailing';
		
		$update_parent = '';
		if (! empty($do_acf_update)){
			$post_parent = acf_get_field_group_post('group_ipacnmailing');
			$update_parent = ! empty($post_parent->ID) ? $post_parent->ID : '';
		}

		$id = 0;
		if (! empty($update_parent)) $id = $update_parent;
		if (! $update_parent) {
			$field_group = array(
				'ID'					=> $id,
				'key'					=> 'group_ipacnmailing',
				'title'					=> 'Active Campaign Mailing',
				'fields'				=> array(),
				'location'				=> $_location,
				'menu_order'			=> 0,
				'position'				=> 'normal',
				'style'					=> 'default',
				'label_placement'		=> 'top',
				'instruction_placement'	=> 'label',
				'hide_on_screen'		=> array(),
				'active'				=> true,
				'description'			=> '',
			);
			acf_update_field_group( $field_group );
		}
		
		$parent = '';
		$post_parent = acf_get_field_group_post('group_ipacnmailing');
		$parent = ! empty($post_parent->ID) ? $post_parent->ID : '';

		if (empty($parent)) return;
		
		
		
		$id = 0;
		if (! empty($do_acf_update)){
			$post_parent = acf_get_field_post('field_ipacnmailing_type');
			$id = ! empty($post_parent->ID) ? $post_parent->ID : 0;
		}
		else{
			$post_parent = acf_get_field_post('field_ipacnmailing_type');
			$id = ! empty($post_parent->ID) ? $post_parent->ID : '';
			if ($id) return;
		}

		$field = array(
			'ID'				=> $id,
			'key'				=> 'field_ipacnmailing_type',
			'label'				=> 'Mailing Type',
			'name'				=> 'ipacnmailing_type',
			'prefix'			=> '',
			'type'				=> 'radio',
			'choices'				=> array('editorial' => 'Editorial', 'scraper' => 'HTML Import'),
			'value'				=> null,
			'menu_order'		=> 0,
			'instructions'		=> '',
			'required'			=> true,
			'id'				=> '',
			'class'				=> '',
			'conditional_logic'	=> false,
			'parent'			=> $parent,
			'wrapper'			=> array()
		);
		acf_update_field( $field );
		
		$id = 0;
		if (! empty($do_acf_update)){
			$post_parent = acf_get_field_post('field_ipacnmailing_subject');
			$id = ! empty($post_parent->ID) ? $post_parent->ID : 0;
		}
		
		$field = array(
			'ID'				=> $id,
			'key'				=> 'field_ipacnmailing_subject',
			'label'				=> 'Mailing Subject',
			'name'				=> 'ipacnmailing_subject',
			'prefix'			=> '',
			'type'				=> 'text',
			'value'				=> null,
			'menu_order'		=> 1,
			'instructions'		=> '',
			'required'			=> false,
			'id'				=> '',
			'class'				=> '',
			'conditional_logic'	=> false,
			'parent'			=> $parent,
			'wrapper'			=> array()
		);
		acf_update_field( $field );
		
		
		$id = 0;
		if (! empty($do_acf_update)){
			$post_parent = acf_get_field_post('field_ipacnmailing_list');
			$id = ! empty($post_parent->ID) ? $post_parent->ID : 0;
		}
		
		$field = array(
			'ID'				=> $id,
			'key'				=> 'field_ipacnmailing_list',
			'label'				=> 'Mailing List',
			'name'				=> 'ipacnmailing_list',
			'prefix'			=> '',
			'type'				=> 'number',
			'value'				=> null,
			'menu_order'		=> 2,
			'instructions'		=> 'Required.  Numeric Active Campaign list ID',
			'required'			=> false,
			'id'				=> '',
			'class'				=> '',
			'conditional_logic'	=> false,
			'parent'			=> $parent,
			'wrapper'			=> array()
		);
		$list = acf_update_field( $field );		
		
		$id = 0;
		if (! empty($do_acf_update)){
			$post_parent = acf_get_field_post('field_acpreheader_text');
			$id = ! empty($post_parent->ID) ? $post_parent->ID : 0;
		}
		
		$field = array(
			'ID'				=> $id,
			'key'				=> 'field_acpreheader_text',
			'label'				=> 'Preheader Text',
			'name'				=> 'acpreheader_text',
			'prefix'			=> '',
			'type'				=> 'text',
			'value'				=> null,
			'menu_order'		=> 3,
			'instructions'		=> '',
			'required'			=> false,
			'id'				=> '',
			'class'				=> '',
			'conditional_logic'	=> false,
			'parent'			=> $parent,
			'wrapper'			=> array()
		);
		acf_update_field( $field );		
		

		
/* scraper */	
		$id = 0;
		if (! empty($do_acf_update)){
			$post_parent = acf_get_field_post('field_acfetch_url');
			$id = ! empty($post_parent->ID) ? $post_parent->ID : 0;
		}
		
		$field = array(
			'ID'				=> $id,
			'key'				=> 'field_acfetch_url',
			'label'				=> 'url to fetch source html',
			'name'				=> 'acfetch_url',
			'prefix'			=> '',
			'type'				=> 'text',
			'value'				=> null,
			'menu_order'		=> 4,
			'instructions'		=> '',
			'required'			=> false,
			'id'				=> '',
			'class'				=> '',
			'conditional_logic'	=> array(0 => array(0 => array('field' => 'field_ipacnmailing_type', 'operator' => '==', 'value' => 'scraper'))),
			'parent'			=> $parent,
			'wrapper'			=> array()
		);
		acf_update_field( $field );
		
/* editorial */
		$id = 0;
		if (! empty($do_acf_update)){
			$post_parent = acf_get_field_post('field_acheader_image');
			$id = ! empty($post_parent->ID) ? $post_parent->ID : 0;
		}
		
		$field = array(
			'ID'				=> $id,
			'key'				=> 'field_acheader_image',
			'label'				=> 'Template Header Image',
			'name'				=> 'acheader_image',
			'prefix'			=> '',
			'type'				=> 'image',
			'value'				=> null,
			'menu_order'		=> 5,
			'instructions'		=> '500 to 600px width branded header image',
			'required'			=> false,
			'id'				=> '',
			'class'				=> '',
			'conditional_logic'	=> array(0 => array(0 => array('field' => 'field_ipacnmailing_type', 'operator' => '==', 'value' => 'editorial'))),
			'parent'			=> $parent,
			'wrapper'			=> array(),
			'return_format'			=> 'url',
		);
		acf_update_field( $field );
		
		$id = 0;
		if (! empty($do_acf_update)){
			$post_parent = acf_get_field_post('field_articles');
			$id = ! empty($post_parent->ID) ? $post_parent->ID : 0;
		}
		
		$field = array(
			'ID'				=> $id,
			'key'				=> 'field_articles',
			'label'				=> 'Articles',
			'name'				=> 'articles',
			'prefix'			=> '',
			'type'				=> 'relationship',
			'value'				=> null,
			'menu_order'		=> 6,
			'instructions'		=> '',
			'required'			=> false,
			'id'				=> '',
			'class'				=> '',
			'conditional_logic'	=> array(0 => array(0 => array('field' => 'field_ipacnmailing_type', 'operator' => '==', 'value' => 'editorial'))),
			'parent'			=> $parent,
			'wrapper'			=> array(),
			'filters'			=> array('search', 'post_type'),
			'return_format' => 'id'
		);
		acf_update_field( $field );
		
		$id = 0;
		if (! empty($do_acf_update)){
			$post_parent = acf_get_field_post('field_exceprt_paragraphs');
			$id = ! empty($post_parent->ID) ? $post_parent->ID : 0;
		}
		
		$field = array(
			'ID'				=> $id,
			'key'				=> 'field_exceprt_paragraphs',
			'label'				=> 'Number of Paragraphs',
			'name'				=> 'exceprt_paragraphs',
			'prefix'			=> '',
			'type'				=> 'number',
			'value'				=> null,
			'menu_order'		=> 7,
			'instructions'		=> 'Number of paragraphs to display from the selected Article(s).  Defaults to 1',
			'required'			=> false,
			'id'				=> '',
			'class'				=> '',
			'conditional_logic'	=> array(0 => array(0 => array('field' => 'field_ipacnmailing_type', 'operator' => '==', 'value' => 'editorial'))),
			'parent'			=> $parent,
			'wrapper'			=> array()
		);
		acf_update_field( $field );
		
		$id = 0;
		if (! empty($do_acf_update)){
			$post_parent = acf_get_field_post('field_ad_image');
			$id = ! empty($post_parent->ID) ? $post_parent->ID : 0;
		}
		
		$field = array(
			'ID'				=> $id,
			'key'				=> 'field_ad_image',
			'label'				=> 'Ad Image',
			'name'				=> 'ad_image',
			'prefix'			=> '',
			'type'				=> 'image',
			'value'				=> null,
			'menu_order'		=> 8,
			'instructions'		=> '',
			'required'			=> false,
			'id'				=> '',
			'class'				=> '',
			'conditional_logic'	=> array(0 => array(0 => array('field' => 'field_ipacnmailing_type', 'operator' => '==', 'value' => 'editorial'))),
			'parent'			=> $parent,
			'wrapper'			=> array(),
			'return_format'			=> 'url',
		);
		acf_update_field( $field );
		
		$id = 0;
		if (! empty($do_acf_update)){
			$post_parent = acf_get_field_post('field_ad_link');
			$id = ! empty($post_parent->ID) ? $post_parent->ID : 0;
		}
		
		$field = array(
			'ID'				=> $id,
			'key'				=> 'field_ad_link',
			'label'				=> 'Ad Link',
			'name'				=> 'ad_link',
			'prefix'			=> '',
			'type'				=> 'text',
			'value'				=> null,
			'menu_order'		=> 9,
			'instructions'		=> 'Surrounds the Ad Image if using',
			'required'			=> false,
			'id'				=> '',
			'class'				=> '',
			'conditional_logic'	=> array(0 => array(0 => array('field' => 'field_ipacnmailing_type', 'operator' => '==', 'value' => 'editorial'))),
			'parent'			=> $parent,
			'wrapper'			=> array()
		);
		acf_update_field( $field );
		
		$id = 0;
		if (! empty($do_acf_update)){
			$post_parent = acf_get_field_post('field_insert_after');
			$id = ! empty($post_parent->ID) ? $post_parent->ID : 0;
		}
		
		$field = array(
			'ID'				=> $id,
			'key'				=> 'field_insert_after',
			'label'				=> 'Insert Ad After',
			'name'				=> 'insert_after',
			'prefix'			=> '',
			'type'				=> 'number',
			'value'				=> null,
			'menu_order'		=> 10,
			'instructions'		=> 'Number of articles - if multiple - to display Ad after.  Defaults to 1',
			'required'			=> false,
			'id'				=> '',
			'class'				=> '',
			'conditional_logic'	=> array(0 => array(0 => array('field' => 'field_ipacnmailing_type', 'operator' => '==', 'value' => 'editorial'))),
			'parent'			=> $parent,
			'wrapper'			=> array()
		);
		acf_update_field( $field );
		
		$id = 0;
		if (! empty($do_acf_update)){
			$post_parent = acf_get_field_post('field_append_tracking');
			$id = ! empty($post_parent->ID) ? $post_parent->ID : 0;
		}		

		$field = array(
			'ID'				=> $id,
			'key'				=> 'field_append_tracking',
			'label'				=> 'Append Tracking codes to links',
			'name'				=> 'append_tracking',
			'prefix'			=> '',
			'type'				=> 'radio',
			'choices'				=> array('yes' => 'yes', 'no' => 'no'),
			'value'				=> null,
			'menu_order'		=> 11,
			'instructions'		=> '',
			'required'			=> true,
			'id'				=> '',
			'class'				=> '',
			'conditional_logic'	=> false,
			'parent'			=> $parent,
			'wrapper'			=> array()
		);
		acf_update_field( $field );
		
		$id = 0;
		if (! empty($do_acf_update)){
			$post_parent = acf_get_field_post('field_utm_source');
			$id = ! empty($post_parent->ID) ? $post_parent->ID : 0;
		}
		
		$field = array(
			'ID'				=> $id,
			'key'				=> 'field_utm_source',
			'label'				=> 'utm_source',
			'name'				=> 'utm_source',
			'prefix'			=> '',
			'type'				=> 'text',
			'value'				=> null,
			'menu_order'		=> 12,
			'instructions'		=> 'optional - if using append tracking',
			'required'			=> false,
			'id'				=> '',
			'class'				=> '',
			'conditional_logic'	=> false,
			'parent'			=> $parent,
			'wrapper'			=> array()
		);
		acf_update_field( $field );
		
		$id = 0;
		if (! empty($do_acf_update)){
			$post_parent = acf_get_field_post('field_utm_medium');
			$id = ! empty($post_parent->ID) ? $post_parent->ID : 0;
		}
		
		$field = array(
			'ID'				=> $id,
			'key'				=> 'field_utm_medium',
			'label'				=> 'utm_medium',
			'name'				=> 'utm_medium',
			'prefix'			=> '',
			'type'				=> 'text',
			'value'				=> null,
			'menu_order'		=> 13,
			'instructions'		=> 'optional - if using append tracking',
			'required'			=> false,
			'id'				=> '',
			'class'				=> '',
			'conditional_logic'	=> false,
			'parent'			=> $parent,
			'wrapper'			=> array()
		);
		acf_update_field( $field );
		
		$id = 0;
		if (! empty($do_acf_update)){
			$post_parent = acf_get_field_post('field_utm_content');
			$id = ! empty($post_parent->ID) ? $post_parent->ID : 0;
		}
		
		$field = array(
			'ID'				=> $id,
			'key'				=> 'field_utm_content',
			'label'				=> 'utm_content',
			'name'				=> 'utm_content',
			'prefix'			=> '',
			'type'				=> 'text',
			'value'				=> null,
			'menu_order'		=> 14,
			'instructions'		=> 'optional - if using append tracking',
			'required'			=> false,
			'id'				=> '',
			'class'				=> '',
			'conditional_logic'	=> false,
			'parent'			=> $parent,
			'wrapper'			=> array()
		);
		acf_update_field( $field );
		
		$id = 0;
		if (! empty($do_acf_update)){
			$post_parent = acf_get_field_post('field_utm_campaign');
			$id = ! empty($post_parent->ID) ? $post_parent->ID : 0;
		}
		
		$field = array(
			'ID'				=> $id,
			'key'				=> 'field_utm_campaign',
			'label'				=> 'utm_campaign',
			'name'				=> 'utm_campaign',
			'prefix'			=> '',
			'type'				=> 'text',
			'value'				=> null,
			'menu_order'		=> 15,
			'instructions'		=> 'optional - if using append tracking',
			'required'			=> false,
			'id'				=> '',
			'class'				=> '',
			'conditional_logic'	=> false,
			'parent'			=> $parent,
			'wrapper'			=> array()
		);
		acf_update_field( $field );
		
return;