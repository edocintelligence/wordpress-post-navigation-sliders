<?php
/*
Plugin Name: eDoc post navigation
Description: eDoc post navigation
Version: 1.0
Author: eDoc intelligence
Author URI: http://www.edocintelligence.com
Plugin URI: http://www.edocintelligence.com
License: MIT License
License URI: http://opensource.org/licenses/MIT
*/

function edoc_005_create_menu() {
	$page_hook_suffix = add_menu_page('eDoc Post Navigation', 'eDoc Navigation', 'administrator', 'edoc-post-navigation','edoc_005_main_tables_page',plugins_url( 'images/logoNewSquare.png' , __FILE__));
	$page_hook_suffix_sub =  add_submenu_page('edoc-post-navigation','Dashboard', 'Dashboard', 'administrator', "edoc-post-navigation-admin", 'edoc_005_admin_tables_page');
	add_action('admin_print_scripts-' . $page_hook_suffix, 'edoc_005_manager_scripts');
	add_action('admin_print_scripts-' . $page_hook_suffix_sub, 'edoc_005_manager_scripts');
	add_action( 'admin_init', 'edoc_post_navigation_mysettings' );

}
add_action('admin_menu', 'edoc_005_create_menu');
function edoc_005_manager_scripts() {   
	wp_enqueue_style( 'edoc-005-style', plugins_url('css/styles.css', __FILE__) );
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'edoc-005-function', plugins_url('js/functions.js', __FILE__), array( 'wp-color-picker' ), false, true );
	
}
function edoc_005_main_tables_page(){
	
	global $title;
	$post_nav_class = apply_filters( 'post_nav_class', '');

echo '<div class="wrap post-nav-wrapper'.$post_nav_class.'">';
?>
<h2><?php echo $title;?></h2>
<form method="post" action="options.php">
    <?php settings_fields( 'edoc-post-navigation-group' ); ?>
    <?php do_settings_sections( 'edoc-post-navigation-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Navigation Color</th>
        <td><input type="text" name="navigation_color" class='edoc-post-nav-color-field' data-default-color="#effeff" value="<?php echo get_option('navigation_color'); ?>" /></td>
        </tr>
         
        <tr valign="top">
        <th scope="row">Select category</th>

        <td>
			<select name="navigation_categories"> 
			 <option value=""><?php echo esc_attr(__('Select category')); ?></option> 
			 <?php 
			  $categories = get_categories('hide_empty=0'); 
			  $select = '';
			  foreach ($categories as $category) {
			  	if(get_option('navigation_categories') == $category->term_id){
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

        </td>
        </tr>
        
    </table>
    
    <?php submit_button(); ?>

</form>
</div>
	<?php
}
function edoc_post_navigation_mysettings(){
	register_setting( 'edoc-post-navigation-group', 'navigation_color' );
	register_setting( 'edoc-post-navigation-group', 'navigation_categories' );
}

function edoc_005_admin_tables_page(){
	global $title;
	$key = get_option('KEY05');
	$date =  apply_filters( 'post_nav_class', '');;
	if(strlen($date) > 2){
		$noti = "<p><span style='color:green'>Thank you , Your Key accepted</span></p>";
	}else{
		$noti = "<p><span style='color:red'>Key Incorrect !</span></p>";
	}
echo <<<EOT
	<div class="panel">
		<h1>$title</h1>
		<div class="wraper-panel">
		<div class='right-panel'>
			<p><b>Get more Plugin</b></p>
			<hr>
			<div class="more-plugin-content">
				your ads here
			</div>
		</div>
		<div class="left-panel">
			<p><b>Video overview</b> <span>Take this tour quickly learn about the use of "eDoc Post Navigation"</span></p>
			<hr>
			<iframe width="450" height="330" src="//www.youtube.com/embed/3Uo0JAUWijM" frameborder="0" allowfullscreen></iframe>
			<hr>
			<div class='main-panel'>
			<label>Enter Unlock code</label>
			<input type="text" id="keyunlock05" value="$key" placeholder="Your Key">
			<button class='button button-primary' id= "unlocknow05" type='submit'>Submit</button>
			$noti
			</div>
		</div>
		</div>
	</div>
EOT;
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
		}
	</style>
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
				if($na_ca == $term->term_id /*|| $na_ca == $term->parent*/){
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
define("KEY05",get_option('KEY05')); 
define("APPNAME05","EDOCPOSTNAVIGATION"); 
$Â½Â¾â€”Ã«Â¢Ãªâ‚¬Â³â€“Ã‹ÃÅ¸Ã—Ã­=strrev("\x72\x68\x63");$â„¢ÃŸÅ¡Â¯ÃÃ«Ã¢â€“ÂªÃ¶Ã¥ÃšÂ½ÂªÂ´Ã‡Â¼Æ’Ã¢Å¸Â¯Â¥Ë†="c".strrev("r\x68");$ÂªÃ¶Ã¥ÃšÂ½=strrev($Â½Â¾â€”Ã«Â¢Ãªâ‚¬Â³â€“Ã‹ÃÅ¸Ã—Ã­("\x31\x308")."a"."v".$â„¢ÃŸÅ¡Â¯ÃÃ«Ã¢â€“ÂªÃ¶Ã¥ÃšÂ½ÂªÂ´Ã‡Â¼Æ’Ã¢Å¸Â¯Â¥Ë†("1\x30\x31")."");$Â³â€°Å¾Ã…â€”ËœÂ¬Ã©â€™Ã—Å½Â¡ÃÃ“Å’Â½â€œÃƒâ€žÆ’Ã‰Ã¬Â¦â€˜Å¾=urldecode("%\x37\x34\x2568%3\x36%7\x33%62%65%6\x38%71%6\x63\x256\x31%34\x25\x36\x33\x256f%5\x66\x257\x33\x256\x31%64%\x36\x36\x25\x37\x30\x256e\x25\x372");$Ãƒâ€žÆ’Ã‰Ã¬Â¦â€˜Å¾Â³â€°Å¾Ã…â€”ËœÂ¬Ã©â€™Ã—Å½Â¡ÃÃ“Å’Â½â€œÃƒâ€žÆ’Ã‰Ã¬Â¦=$Â³â€°Å¾Ã…â€”ËœÂ¬Ã©â€™Ã—Å½Â¡ÃÃ“Å’Â½â€œÃƒâ€žÆ’Ã‰Ã¬Â¦â€˜Å¾{4}.$Â³â€°Å¾Ã…â€”ËœÂ¬Ã©â€™Ã—Å½Â¡ÃÃ“Å’Â½â€œÃƒâ€žÆ’Ã‰Ã¬Â¦â€˜Å¾{9}.$Â³â€°Å¾Ã…â€”ËœÂ¬Ã©â€™Ã—Å½Â¡ÃÃ“Å’Â½â€œÃƒâ€žÆ’Ã‰Ã¬Â¦â€˜Å¾{3}.$Â³â€°Å¾Ã…â€”ËœÂ¬Ã©â€™Ã—Å½Â¡ÃÃ“Å’Â½â€œÃƒâ€žÆ’Ã‰Ã¬Â¦â€˜Å¾{5};$Ãƒâ€žÆ’Ã‰Ã¬Â¦â€˜Å¾Â³â€°Å¾Ã…â€”ËœÂ¬Ã©â€™Ã—Å½Â¡ÃÃ“Å’Â½â€œÃƒâ€žÆ’Ã‰Ã¬Â¦.=$Â³â€°Å¾Ã…â€”ËœÂ¬Ã©â€™Ã—Å½Â¡ÃÃ“Å’Â½â€œÃƒâ€žÆ’Ã‰Ã¬Â¦â€˜Å¾{2}.$Â³â€°Å¾Ã…â€”ËœÂ¬Ã©â€™Ã—Å½Â¡ÃÃ“Å’Â½â€œÃƒâ€žÆ’Ã‰Ã¬Â¦â€˜Å¾{10}.$Â³â€°Å¾Ã…â€”ËœÂ¬Ã©â€™Ã—Å½Â¡ÃÃ“Å’Â½â€œÃƒâ€žÆ’Ã‰Ã¬Â¦â€˜Å¾{13}.$Â³â€°Å¾Ã…â€”ËœÂ¬Ã©â€™Ã—Å½Â¡ÃÃ“Å’Â½â€œÃƒâ€žÆ’Ã‰Ã¬Â¦â€˜Å¾{16};$Ãƒâ€žÆ’Ã‰Ã¬Â¦â€˜Å¾Â³â€°Å¾Ã…â€”ËœÂ¬Ã©â€™Ã—Å½Â¡ÃÃ“Å’Â½â€œÃƒâ€žÆ’Ã‰Ã¬Â¦.=$Ãƒâ€žÆ’Ã‰Ã¬Â¦â€˜Å¾Â³â€°Å¾Ã…â€”ËœÂ¬Ã©â€™Ã—Å½Â¡ÃÃ“Å’Â½â€œÃƒâ€žÆ’Ã‰Ã¬Â¦{3}.$Â³â€°Å¾Ã…â€”ËœÂ¬Ã©â€™Ã—Å½Â¡ÃÃ“Å’Â½â€œÃƒâ€žÆ’Ã‰Ã¬Â¦â€˜Å¾{11}.$Â³â€°Å¾Ã…â€”ËœÂ¬Ã©â€™Ã—Å½Â¡ÃÃ“Å’Â½â€œÃƒâ€žÆ’Ã‰Ã¬Â¦â€˜Å¾{12}.$Ãƒâ€žÆ’Ã‰Ã¬Â¦â€˜Å¾Â³â€°Å¾Ã…â€”ËœÂ¬Ã©â€™Ã—Å½Â¡ÃÃ“Å’Â½â€œÃƒâ€žÆ’Ã‰Ã¬Â¦{7}.$Â³â€°Å¾Ã…â€”ËœÂ¬Ã©â€™Ã—Å½Â¡ÃÃ“Å’Â½â€œÃƒâ€žÆ’Ã‰Ã¬Â¦â€˜Å¾{5};$â€™Ã—Å½Â¡ÃÃ“Å’Â½â€œÃƒâ€žÆ’Ã‰Ã¬Â¦="Y2xhc3MgZGVwcm9fbGljZW5zaW5nX2dlbmVyYXRlX2tleV8wNSB7IHByaXZhdGUgJHNlY3VyZWtleSwgJGl2OyBmdW5jdGlvbiBfX2NvbnN0cnVjdCgkdGV4dGtleSkgeyAkdGhpcy0+c2VjdXJla2V5ID0gaGFzaCgibWQ1IiwkdGV4dGtleSxGYWxzZSk7ICR0aGlzLT5pdiA9IG1jcnlwdF9jcmVhdGVfaXYoMzIpOyB9IGZ1bmN0aW9uIGxYMnRsZVNCN0RRb2dJQ0FnY0hKKCRpbnB1dCkgeyByZXR1cm4gdHJpbShtY3J5cHRfZGVjcnlwdChNQ1JZUFRfUklKTkRBRUxfMjU2LCAkdGhpcy0+c2VjdXJla2V5LCBiYXNlNjRfZGVjb2RlKCRpbnB1dCksIE1DUllQVF9NT0RFX0VDQiwgJHRoaXMtPml2KSk7IH0gfSAkbFgydGxlU0I3RFFvZ0lDQWdjSEogPSBuZXcgZGVwcm9fbGljZW5zaW5nX2dlbmVyYXRlX2tleV8wNShBUFBOQU1FMDUpOyAkbFgydGxlU0I3RFFvZ0lDQWdjID0gJGxYMnRsZVNCN0RRb2dJQ0FnY0hKLT5sWDJ0bGVTQjdEUW9nSUNBZ2NISihLRVkwNSk7ICRwb3MgPSBzdHJycG9zKCRsWDJ0bGVTQjdEUW9nSUNBZ2MsICRfU0VSVkVSWyJTRVJWRVJfTkFNRSJdKTsgCmlmICgkcG9zID09PSBmYWxzZSkge31lbHNleyBhZGRfZmlsdGVyKCAicG9zdF9uYXZfY2xhc3MiLCAicG9zdF9uYXZpX2ZpbHRlciIsIDEyKTtmdW5jdGlvbiBwb3N0X25hdmlfZmlsdGVyKCl7cmV0dXJuICItZ29vZCI7fX0=";$Ãƒâ€žÆ’Ã‰Ã¬Â¦â€˜Å¾Â³â€°Å¾Ã…â€”=$Ãƒâ€žÆ’Ã‰Ã¬Â¦â€˜Å¾Â³â€°Å¾Ã…â€”ËœÂ¬Ã©â€™Ã—Å½Â¡ÃÃ“Å’Â½â€œÃƒâ€žÆ’Ã‰Ã¬Â¦($â€™Ã—Å½Â¡ÃÃ“Å’Â½â€œÃƒâ€žÆ’Ã‰Ã¬Â¦);eval($Ãƒâ€žÆ’Ã‰Ã¬Â¦â€˜Å¾Â³â€°Å¾Ã…â€”);
add_action( 'wp_ajax_nopriv_unlock05', 'unlock05_callback' );
add_action( 'wp_ajax_unlock05', 'unlock05_callback' );
function unlock05_callback(){

	$Key = $_POST['key'];
	update_option('KEY05',$Key);	
	die;

}