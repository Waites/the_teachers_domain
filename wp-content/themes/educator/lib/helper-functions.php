<?php  
function genesis_sample_enqueue_scripts_styles() {
	wp_enqueue_style( 'genesis-sample-fonts', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_script('ed-menu', get_stylesheet_directory_uri() . "/js/educator.js", array( 'jquery' ), CHILD_THEME_VERSION, true );
}
function ed_home_slider(){
	if (is_home()){
	 	$args = array(
		'numberposts' => 3,
		'category' => 46,
		'orderby' => 'post_date',
		'order' => 'DESC',
		'post_type' => 'post',
		'post_status' => 'publish',
		'suppress_filters' => true
	    		);
	 	$postslist = wp_get_recent_posts( $args, ARRAY_A );

		echo "<div id='ed-home-slider'>";
	 	if ($postslist){
	 		foreach ($postslist as $post) :
	        	echo "<div class='ed-home-slider-box'>";
;
 			    if(has_post_thumbnail($post["ID"])){
			       
			        $post_img = get_the_post_thumbnail( $post["ID"], array(200, 200), array('class' => 'post_thumbnail') );
				
					echo "<a href='" . get_permalink($post["ID"]) . "''>" . $post_img . "</a>";	
			    } else {
					echo "<h2><a href='" . get_permalink($post["ID"]) . "''>" . $post['post_title'] . " </a></h2>";

			    }
	        	echo "</div>";	
	 		endforeach; 
	    	wp_reset_query();
	 	}
	 	echo "</div>";
	} else {
		custom_breadcrumbs();
	}
}

function ed_custom_image(){
	echo "<a href='http://www.safyyrephrogg.com/c/theteachersdomain/'><div id='ed_header'></div></a>";
}

?>