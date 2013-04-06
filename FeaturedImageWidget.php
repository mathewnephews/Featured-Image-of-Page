<?php
/*
Plugin Name: Featured Image
Plugin URI: http://mathewnephews.wordpress.com/
Description: Featured Image Widget shows the featured image of a certain page in the sidebar
Author: Mathie Neven
Version: 1
Author URI: http://mathewnephews.wordpress.com/
extra comment line added
*/
class FeaturedImageWidget extends WP_Widget
{
  function FeaturedImageWidget()
  {
    $widget_ops = array('classname' => 'FeaturedImageWidget', 'description' => 'Displays the featured image of a post' );
    $this->WP_Widget('FeaturedImageWidget', 'Featured Image', $widget_ops);
  }
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
<?php
  }
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
 
    if (!empty($title))
		//echo '<div id="leesonline">';
    	echo $before_title . $title . $after_title;;
		?>
		<a href="http://www.concentra.be/jetlimburg/lees-jet-magazine-online/">
        <img id="ontdek" src="<?php bloginfo('stylesheet_directory'); ?>/images/bol.png">
        </a>
 <?php
    // WIDGET CODE
	?>  
	<?php
	$page = get_page_by_title( $title );
	query_posts( array( 'post_type' => 'page', 'page_id' => $page->ID , 'posts_per_page' => 1, 'orderby' => 'date', 'order' => 'DESC' ) );	
	// query_posts( array( 'category__and' => $category_ID, 'posts_per_page' => 1, 'orderby' => 'date', 'order' => 'DESC' ) );
	if (have_posts()) : 
		while (have_posts()) : the_post(); 
			echo '<div id="coverfoto">';
			echo '<a href="' . get_permalink() . '">';
			// echo '<a href="jetlimburg/lees-jet-magazine-online/">';
			echo the_post_thumbnail('medium');	
			echo '</a>';
			
			echo '</div>';	 
		endwhile;
	endif; 
	
	wp_reset_query();
	//echo '</div>'; // end of lees online
//end of code 
    echo $after_widget;
  }
}
add_action( 'widgets_init', create_function('', 'return register_widget("FeaturedImageWidget");') );?>