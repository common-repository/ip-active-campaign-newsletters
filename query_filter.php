<?php

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function ipacn_acfquery_filter ( $args, $_field)  {
    // (maybe) modify $string
	
	$args['posts_per_page'] = 500;
	#$args['category__and'] = array(90227,90226,90225);
	#$args['category__in'] = array(90227,90226,90225);
	$args['date_query'] = array(
		'column' => 'post_date',
		'after' => '- 900 days'
	);
	$args['orderby'] = 'post_date';
	$args['order'] = 'DESC';	
	/*
	$args['tax_query'] = array(
		array(
			'taxonomy' => 'newsletter-issue',
			'terms' => $clients_terms,
			'field' => 'slug',
			'include_children' => true,
			'operator' => 'IN'
		)
	);
	*/
	
    return $args;
}
#add_filter( 'cfs_field_relationship_query_args', 'limit_cfs_loop', 10, 3 );
add_filter('acf/fields/relationship/query/name=articles', 'ipacn_acfquery_filter', 10, 3);

function ipacn_acfquery_filter2 ( $args, $_field)  {
	
	$args['posts_per_page'] = 500;
	$args['date_query'] = array(
		'column' => 'post_date',
		'after' => '- 500 days'
	);
	$args['orderby'] = 'post_date';
	$args['order'] = 'DESC';	

    return $args;
}
add_filter('acf/fields/relationship/query/name=top_stories', 'ipacn_acfquery_filter2', 10, 3);

function ipacn_acfquery_filter3 ( $args, $_field)  {
    // (maybe) modify $string
	
	$args['posts_per_page'] = 500;
	#$args['category__in'] = array(568);
	$args['date_query'] = array(
		'column' => 'post_date',
		'after' => '- 500 days'
	);
	$args['orderby'] = 'post_date';
	$args['order'] = 'DESC';	
	
    return $args;
}
add_filter('acf/fields/relationship/query/name=resources', 'ipacn_acfquery_filter3', 10, 3);




?>