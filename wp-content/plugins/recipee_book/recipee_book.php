<?php

/**
 * Plugin Name:       Recipee Plugin
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       A plugin which create the options for adding Recipee.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Abu Shaim
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       recipee
 */

 defined('ABSPATH') or die('You can\'t access this page');
 if (!defined('BOOK_PLUGIN_URL')) {
    define('BOOK_PLUGIN_URL', plugins_url(). '/recipee_book');
}
 if (!defined('BOOK_PLUGIN_dir_path')) {
    define('BOOK_PLUGIN_dir_path', plugin_dir_path(__FILE__));
}
// scripts

// add styles & scripts
function recipee_add_scripts(){

    // add css
    wp_enqueue_style('recipee-main-css', plugins_url(). '/recipee_book/css/style.css');

    
}

add_action('wp_enqueue_scripts', 'recipee_add_scripts');


/**
 * Register a custom post type called "book".
 *
 * @see get_post_type_labels() for label keys.
 */
function wpdocs_kantbtrue_init() {
    $labels = array(
        'name'                  => _x( 'Recipes', 'Post type general name', 'recipe' ),
        'singular_name'         => _x( 'Recipe', 'Post type singular name', 'recipe' ),
        'menu_name'             => _x( 'Recipes', 'Admin Menu text', 'recipe' ),
        'name_admin_bar'        => _x( 'Recipe', 'Add New on Toolbar', 'recipe' ),
        'add_new'               => __( 'Add New', 'recipe' ),
        'add_new_item'          => __( 'Add New recipe', 'recipe' ),
        'new_item'              => __( 'New recipe', 'recipe' ),
        'edit_item'             => __( 'Edit recipe', 'recipe' ),
        'view_item'             => __( 'View recipe', 'recipe' ),
        'all_items'             => __( 'All recipes', 'recipe' ),
        'search_items'          => __( 'Search recipes', 'recipe' ),
        'parent_item_colon'     => __( 'Parent recipes:', 'recipe' ),
        'not_found'             => __( 'No recipes found.', 'recipe' ),
        'not_found_in_trash'    => __( 'No recipes found in Trash.', 'recipe' ),
        'featured_image'        => _x( 'Recipe Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'recipe' ),
        'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'recipe' ),
        'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'recipe' ),
        'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'recipe' ),
        'archives'              => _x( 'Recipe archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'recipe' ),
        'insert_into_item'      => _x( 'Insert into recipe', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'recipe' ),
        'uploaded_to_this_item' => _x( 'Uploaded to this recipe', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'recipe' ),
        'filter_items_list'     => _x( 'Filter recipes list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'recipe' ),
        'items_list_navigation' => _x( 'Recipes list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'recipe' ),
        'items_list'            => _x( 'Recipes list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'recipe' ),
    );     
    $args = array(
        'labels'             => $labels,
        'description'        => 'Recipe custom post type.',
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_icon'       => 'dashicons-food',
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'recipe' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail' ),
        'taxonomies'         => array( 'category', 'post_tag' ),
        'show_in_rest'       => true
    );
      
    register_post_type( 'Recipe', $args );
}
add_action( 'init', 'wpdocs_kantbtrue_init' );


register_activation_hook( __FILE__, 'book_store_custom_post' );
function book_store_custom_post(){
    wpdocs_kantbtrue_init();
}



//  Create Shortcode to Display recipee Post Types
  
function wp_create_shortcode_recipee_post_type(){
  
    $args = array(
                    'post_type'      => 'Recipe',
                    'posts_per_page' => '3',
                    'publish_status' => 'published',
                 );
  
    $query = new WP_Query($args);
  
    if($query->have_posts()) :
  
        while($query->have_posts()) :
  
            $query->the_post() ;
                      
        $result .= '<div class="col-lg-4 col-md-6 col-12">';
        $result .= '<div class="blog-box">';
        $result .= '<div class="blog-img-box">'. the_post_thumbnail( array(350, 350) , ['class' => 'img-fluid blog-img', 'title' => 'Feature image']).'</div>';
        $result .= '<div class="single-blog">' ;
        $result .= '<div class="blog-content"><h6>'.get_the_date('d F Y'). '</h6>' ;
        $result .= '<h3 class="card-title">' .get_the_title(). '</h3>' ;
        $result .= '<p>' . get_the_content(). '</p>'; 
        $result .= '<a href="" class="read-more">Read More</a>'; 
        $result .= '</div></div>'; 
        $result .= '</div>';
        $result .= '</div>';
  
        endwhile;
  
        wp_reset_postdata();
  
    endif;    
  
    return $result;            
}
  
add_shortcode( 'recipee-list', 'wp_create_shortcode_recipee_post_type' ); 