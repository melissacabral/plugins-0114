<?php 
/*
Plugin Name: Latest Products Widget
Description: Combining our widget demo with WP_Query
Author: Melissa Cabral
Version: 0.1
License: GPLv3
*/

/**
 * Attach the stylesheet for the widget
 * @since 0.1
 */
add_action( 'wp_enqueue_scripts', 'rad_products_style' );
function rad_products_style(){
	$style_path = plugins_url( 'rad-products-style.css', __FILE__ );
	wp_register_style( 'rad-products-css', $style_path );
	wp_enqueue_style( 'rad-products-css' );
}


/**
 * Register the widget
 */
add_action( 'widgets_init', 'rad_register_products_widget' );
function rad_register_products_widget(){
	register_widget( 'Rad_Products_Widget' );
}

/**
 * Create the widget class
 */
class Rad_Products_Widget extends WP_Widget{
	//REQUIRED. initial settings for the widget
	function Rad_Products_Widget(){
		$widget_settings = array(
			'classname' => 'products-widget',
			'description' => 'Latest products with a thumbnail image',
		);
		$control_settings = array(
			'id-base' => 'products-widget',
			'width' => 300, //width of the form in the admin panel
		);
		//apply these settings to this widget class
		//(id-base, title, widget settings, control settings)
		$this->WP_Widget('products-widget', 'Latest Products Widget', 
			$widget_settings, $control_settings);
	}
	//REQUIRED. user-facing HTML output
	//$args = arguments from register_sidebar. $instance = array of current values for this instance
	function widget( $args, $instance ){
		extract($args);

		$title = $instance['title'];
		$number = $instance['number'];
		$show_excerpt = $instance['show_excerpt'];
		//more fields go here

		//make the title work with filter hooks
		$title = apply_filters( 'widget_title', $title );

		//Custom query - get the latest products
		$products_query = new WP_Query( array(
			'post_type' => 'product',
			'showposts' => $number,
			'ignore_sticky_posts' => 1,
		) );
		//custom loop
		if($products_query->have_posts()):
			//begin output
			echo $before_widget;
			echo $before_title . $title . $after_title;
			?>
			<ul>
				<?php while( $products_query->have_posts() ):
						$products_query->the_post(); ?>
					<li>
				<a href="<?php the_permalink(); ?>" class="product-link">
					<?php the_post_thumbnail( 'thumbnail' ); ?>
				
					<div class="product-info">
						<h3><?php the_title(); ?></h3>
						<?php //show the excerpt only if $show_excerpt is true 
						if( true == $show_excerpt ):?>
							<p><?php the_excerpt(); ?></p>
						<?php endif; ?>
					</div>
				</a>
			</li>
				<?php endwhile; ?>
			</ul>
			<?php
			echo $after_widget;
			//end output
		endif;
	}
	//REQUIRED. Sanitize all inputs
	function update( $new_instance, $old_instance ){
		$instance = array();

		//go through each field and sanitize the data
		$instance['title'] = wp_filter_nohtml_kses( $new_instance['title'] );
		$instance['number'] = wp_filter_nohtml_kses( $new_instance['number'] );
		$instance['show_excerpt'] = wp_filter_nohtml_kses( $new_instance['show_excerpt'] );

		//add more fields here

		//return the clean data. 
		return $instance;
	}
	//OPTIONAL. admin panel form inputs
	//$instance = array containing the current values for this instance
	function form( $instance ){
		$defaults = array( 
			'title' => 'Latest Products',
			'number' => 3,
			'show_excerpt' => 1,
			//add more field defaults here 
		);
		$instance = wp_parse_args( (array) $instance, $defaults );

		//HTML for the form
		?>
		<p>
			<label>Title:</label>
			<input type="text" 
			name="<?php echo $this->get_field_name('title'); ?>" 
			id="<?php echo $this->get_field_id('title'); ?>" 
			value="<?php echo $instance['title']; ?>">
		</p>
		<p>
			<label>Number of Products:</label>
			<input type="number" 
			name="<?php echo $this->get_field_name('number'); ?>" 
			id="<?php echo $this->get_field_id('number'); ?>" 
			value="<?php echo $instance['number']; ?>" >
		</p>
		<p>
			<input type="checkbox" 
			name="<?php echo $this->get_field_name('show_excerpt'); ?>" 
			id="<?php echo $this->get_field_id('show_excerpt'); ?>" 
			value="1" 
			<?php checked( $instance['show_excerpt'], true ); ?>>
			<label>Show an excerpt for each product</label>
		</p>
		<?php
	}
}
