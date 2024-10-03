<?php

function hos_custom_post_types(){
	// SAMPLE
	register_post_type( 'projects', array(
		'labels'          => array(
			'name'          => __( 'Projects' ),
			'singular_name' => __( 'Projects' )
		),
		'public'            => true,
		'has_archive'       => false,
		'show_in_menu'      => true,
		'supports'          => array('title', 'editor', 'author', 'thumbnail'),
		'menu_icon' 		=> 'dashicons-portfolio',
	));

}
add_action('init','hos_custom_post_types');


function hos_unregister_cpt() {
    unregister_post_type( 'projects' );
	// Clear the permalinks to remove our post type's rules from the database.
	flush_rewrite_rules();
}