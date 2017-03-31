<?php 
function ed_sidebar(){
	$categories = get_categories(array(
		'orderby' => 'name',
		'order' => 'ASC',
		'exclude' => '46,1'
	));

	//format sidebar wrap
	print "<div id='ed_sidebar'><ul>";
	print "<li id='featured' name='featured'><a href='" . esc_url( get_category_link("46")) . "'>*Featured*</a></li>";
	print "<hr>";
	print"<p>Select by Category</p>";
	foreach ($categories as $category) {
		if($category->term_id != 47 && $category->parent != 47){
			$cat_link = "<a href='" . esc_url( get_category_link( $category->term_id ) ) . "'>". $category->name;
			if($category->parent == 0){
				$cat_class = "ed_cat_parent";
			}	else {
				$cat_class = "ed_cat_child";
			}
			print "<li class='" . $cat_class . "'' name='" . $category->term_id . "'	>" . $cat_link . "</a></li>";
		}
	}
	//close wrap
	print "</ul>";

	//add menu break and title
	print "<hr>Select by Type<p></p>";
	print "<ul id='types'>";

	foreach ($categories as $category) {
		if( $category->parent == 47 && $category->term_id != 21){
			$cat_link = "<a href='" . esc_url( get_category_link( $category->term_id ) ) . "'>". $category->name;
			if($category->parent == 0){
				$cat_class = "ed_cat_parent";
			}	else {
				$cat_class = "ed_cat_child";
			}
			print "<li class='" . $cat_class . "'' name='" . $category->term_id . "'	>" . $cat_link . "</a></li>";
		}	
	}
	//close ul

	//close div
	print"</div>";

}

 ?>