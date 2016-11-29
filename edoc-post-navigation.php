<?php
/*
Plugin Name: eDoc Post Navigation Sliders
Plugin URI: https://edocintelligence.com/
Description: Engage users with Post Navigation Fly-ins for Next and Previous posts in specific categories. Select the categories for the plugin to use, and Next and Previous side slide-in animations will draw readers deeper.
Author: eDoc Intelligence LLC
Version: 1.2
Text Domain: edoc-post-navigation-sliders
Author URI: https://profiles.wordpress.org/jerodmoore/
License: GNU General Public License v3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

This plugin is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program. If not, see http://www.gnu.org/licenses/

You can contact us at info@edocintelligence.com

*/

if ( ! defined( 'ABSPATH' ) ) exit;
function edoc_wppns_create_menu() {
	$page_hook_suffix = add_menu_page('eDoc Post Navigation Sliders', 'eDoc Post Slider', 'administrator', 'edoc-post-navigation','edoc_wppns_main_tables_page',plugins_url( 'images/logoNewSquare.png' , __FILE__));
	add_action('admin_print_scripts-' . $page_hook_suffix, 'edoc_wppns_manager_scripts');
	add_action( 'admin_init', 'edoc_post_navigation_mysettings' );

}
add_action('admin_menu', 'edoc_wppns_create_menu');
function edoc_wppns_manager_scripts() {   
	wp_enqueue_style( 'edoc-wppns-style', plugins_url('css/styles.css', __FILE__) );
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker-alpha', plugins_url( '/js/wp-color-picker-alpha.min.js',  __FILE__ ), array( 'wp-color-picker' ), '1.0.0', true );
	wp_enqueue_script( 'edoc-wppns-function', plugins_url('js/functions.js', __FILE__), array( 'wp-color-picker' ), false, true );
	
}
function edoc_wppns_main_tables_page(){
	
	global $title;
	$post_nav_class = apply_filters( 'post_nav_class', '');

echo '<div class="wrap post-nav-wrapper'.$post_nav_class.'">';
?>
<div id="wppns_main_body">
<div class="content_table">
<div class="create_panel">
<h2><?php echo $title;?></h2>
<form method="post" action="options.php">
    <?php settings_fields( 'edoc-post-navigation-group' ); ?>
    <?php do_settings_sections( 'edoc-post-navigation-group' );
		  $list_selected = get_option('navigation_categories');
     ?>
    <table class="form-table">
        <tr valign="top">
        	<td width="50%">
	        	<label>
			        <span class="label_title" scope="row">Slider Background Color</span>
			        
			        <input type="text" name="navigation_color" class='edoc-post-nav-color-field' data-alpha="true" data-default-color="rgba(0,0,0,0.85)" value="<?php echo get_option('navigation_color'); ?>" />
			    </label>
			    <label>
		        	<span class="label_title"  scope="row">Slider Border Color</span>
					<input type="text" name="navigation_border_color" class='edoc-post-nav-color-field' data-alpha="true" data-default-color="rgba(0,0,0,0.85)" value="<?php echo get_option('navigation_border_color'); ?>" />
				</label>
			</td>
			<td>
					<div class="preview"><span class="meta-nav">&lt; </span><a href="">The post title</a></div>
			</td>
        </tr>

        <tr valign="top">
        	<td colspan="2">
        		<label>
			        <span class="label_title"  scope="row">Slider Border Radius</span>
			        <input type="text" name="navigation_border_radius" class='edoc-post-nav-text-field' value="<?php echo get_option('navigation_border_radius'); ?>" />
			    </label>
	    	</td>

        </tr>
         
        <tr valign="top">
        	<td colspan="2">
        		<label>
	        		<span class="label_title"  scope="row">Select Category(s)</span>

		        
					<select name="navigation_categories[]" multiple> 
					 <option value=""><?php echo esc_attr(__('Select category')); ?></option> 
					 <?php 
					  $categories = get_categories('hide_empty=0'); 
					  $select = '';

					  foreach ($categories as $category) {
					  	if(in_array($category->term_id,$list_selected)){
					  		$select = "selected";
					  	}else{
					  		$select = '';
					  	}
					  	$option = '<option value="'.$category->term_id.'" '.$select.'>';
						$option .= $category->cat_name;
						$option .= ' ('.$category->category_count.')';
						$option .= '</option>';
						echo $option;
				  }
				 ?>
				</select>
				</label>
	        </td>
        </tr>
        <tr valign="top">

        	<td colspan="2">
        		<label>
		        	<span class="label_title"  scope="row">Enable AutoShow</span>
		        	<input type="checkbox" name="auto_show" class='edoc-post-nav-text-field' data-alpha="true" <?php if(get_option('auto_show') == "true"){echo "checked";} ; ?> value="true" />
		        </laebl>
	        </td>	
        </tr>
        <tr valign="top">
        	<td colspan="2">
	        	<label>
	        		<span class="label_title edoc-post-nav-text-field"  scope="row">AutoShow Percent (%)</span> 
					<input type="number" name="auto_next" class='edoc-post-nav-text-field' value="<?php echo get_option('auto_next'); ?>" />
				</label>
			</td>
        </tr>
    </table>
    <?php submit_button(); ?>
    <style>
    	.preview{
    		background-color: <?php echo get_option('navigation_color');?>;
    		border:1px solid <?php echo get_option('navigation_border_color');?>;
    		border-radius: <?php echo get_option('navigation_border_radius'); ?>;
    	}
    </style>
</form>
</div>
</div>

<div id="wppns_sidebar">
	<div class="sidebarTitle">
        <h2>Quick Steps</h2>
    </div>
	<div class="sidebarWrapper">
		<div class="sidebarVideo">
			<iframe width="100%" height="100%" src="https://www.youtube.com/embed/2nSlzs9Kaus" frameborder="0" allowfullscreen></iframe>
		</div>
			<hr>
		<div="sidebarText">
		    
		    <br><a href="https://wordpress.org/support/plugin/edoc-post-navigation-sliders/reviews/"><b>Like Us? Review Us!</b></a>
		    <br><a href="https://wordpress.org/support/plugin/edoc-post-navigation-sliders">Need Help? Got an Idea? Post a Question!</a>
		    <br><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=care%40edocintelligence%2ecom&item_name=eDoc%20Post%20Navigation%20Sliders&item_number=Support%20Open%20Source&no_shipping=0&no_note=1&tax=0&currency_code=USD&lc=US&bn=PP%2dDonationsBF&charset=UTF%2d8">Keep Us Coding, Donate a Buck.</a>
		    
	</div>
</div>

</div>
</div>
	<?php
}
function edoc_post_navigation_mysettings(){
	register_setting( 'edoc-post-navigation-group', 'navigation_color' );
	register_setting( 'edoc-post-navigation-group', 'navigation_border_color' );
	register_setting( 'edoc-post-navigation-group', 'navigation_border_radius' );
	register_setting( 'edoc-post-navigation-group', 'auto_show' );
	register_setting( 'edoc-post-navigation-group', 'auto_next' );
	register_setting( 'edoc-post-navigation-group', 'navigation_categories' );
}

if ( ! function_exists( 'edoc_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @since Twenty Fourteen 1.0
 */
function edoc_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	wp_enqueue_style( 'edoc-post-navigation-animate', plugins_url('css/animate.css', __FILE__) );
	wp_enqueue_style( 'edoc-post-navigation-style', plugins_url('css/post-navigation.css', __FILE__) );
	wp_enqueue_script( 'edoc-post-navigation-function', plugins_url('js/post-navigation.js', __FILE__), array( 'jquery' ), false, true );	
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );
	if ( ! $next && ! $previous ) {
		return;
	}
	$nextThumb = $previousThumb = "";
	if ($next){
		$nextThumb  = get_the_post_thumbnail( $next->ID, 'thumbnail' );
	}
	if ($previous){
		$previousThumb  = get_the_post_thumbnail( $previous->ID, 'thumbnail' );
	}

	?>
	<style type="text/css">
		.previousPost,.nextPost {
			background-color: <?php echo get_option('navigation_color'); ?>;
			border: 1px solid <?php echo get_option('navigation_border_color'); ?>;
			border-radius: <?php echo get_option('navigation_border_radius'); ?>;
		}
	</style>
	<script>
		var position_auto = <?php $data=  get_option('auto_show') == 'true' && get_option('auto_next') != '' ? get_option('auto_next') :  'false' ; echo $data; ?>;
	</script>
		<div class="post-nav-links" id="post-nav-links">
			<?php
				previous_post_link( '%link', __( '<strong  class="previousPost"><span class="meta-nav">< </span>%title'.$previousThumb.'</strong>'));
				next_post_link( '%link', __( '<strong class="nextPost">'.$nextThumb.' %title<span class="meta-nav"> ></span></strong>'));
			?>
		</div><!-- .nav-links -->
	<?php
}
endif;
add_filter( 'the_content', 'edoc_post_navigation_hook' );
function edoc_post_navigation_hook($content){
	global $post;
	$na_ca = get_option('navigation_categories');
	if(is_single($post->ID)){
		if($na_ca != ""){
			$terms = get_the_category( $post->ID);
			foreach($terms as $term){
				if(in_array($term->term_id,$na_ca)){
					return  edoc_post_nav().$content;
				}
			}	
			return  $content;	
		}else{
			return  edoc_post_nav().$content;
		}		
	}
	return  $content;
	
}
add_filter( "post_nav_class", "post_navi_filter", 12);function post_navi_filter(){return "-good";}