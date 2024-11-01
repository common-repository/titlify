<?php 
/**
 * @package Titlify
 * @version 1.0
 */
/*
Plugin Name: Titlify
Plugin URI: http://www.diascodes.com/
Description: a tiny solution to colorise the title of each post.
Author: SAID ASSEMLAL
Version: 1.0
Author URI: http://www.diascodes.com
*/


if (!defined('TITLIFY_VERSION'))
    define('TITLIFY_VERSION', '1.0');

if (!defined('TITLIFY_URL'))
    define('TITLIFY_URL', plugins_url( '/', __FILE__ ) );

if (!defined('TITLIFY_VIEWS'))
    define('TITLIFY_VIEWS', WP_PLUGIN_DIR . '/Titlify/views/' );


if( !class_exists('titlify') ){

	class titlify{

		function titlify(){

			register_activation_hook( __FILE__, array( $this, 'titlifyActivation' ) );

			add_action( 'admin_enqueue_scripts', array( $this, 'titlifyLibs' ) );
			add_action( 'add_meta_boxes', array( $this, 'titlifyMetaboxInit' ) );
			add_filter( 'the_title', array( $this, 'the_titlify' ) );
			add_filter( 'get_the_title', array( $this, 'the_titlify' ) );
			add_action( 'wp_head', array( $this, 'initStylesforTitle' ) );
			add_action( 'save_post', array( $this, 'savePostandAddColor' ) );
			add_action('admin_menu', array( $this, 'titlifySettingsPage' ));

		}

		function titlifyActivation(){
			
			$defaults = array(
				'post_types' => array('post', 'page')
			);

			$tfOptions = get_option( 'titlify-options' );

			if( !is_array( $tfOptions['post_types'] ) ) :
				update_option( 'titlify-options', $defaults );
			endif;
		}

		function titlifyLibs(){
			wp_enqueue_style( 'TitlifyAdditionalCSS', TITLIFY_URL . 'css/titlify.css' );
			wp_enqueue_style('wp-color-picker');
			wp_enqueue_script( 'TitlifyJS', TITLIFY_URL . 'js/titlify.js' , array( 'jquery', 'wp-color-picker' ), '3.5.2', true );
		}

		function titlifyMetaboxInit(){

			$tfOptions = get_option( 'titlify-options' );

			$activatedOn = $tfOptions['post_types'];

		    $that = $this;
		    foreach( $activatedOn as $type ) :
				add_meta_box(
					        'titlify-metabox', 
					        __( 'Titlify' ), 
					        array( $that, 'titlifyMetabox' ) , 
					        $type, 
					        'side', 
					        'high'
				);
		    endforeach;
		}

		function titlifyMetabox(){
			global $post, $typenow;
			
			include_once TITLIFY_VIEWS . '/colorise.php';
		}

		function the_titlify($title){
			global $post;
			$tfOptions = get_option( 'titlify-options' );
			$activatedOn = $tfOptions['post_types'];	

			$color = ( get_post_meta( $post->ID, 'tf-color', true ) ) ? get_post_meta( $post->ID, 'tf-color', true ) : '';
			if( in_array( get_post_type($post->ID), $activatedOn ) && substr($color, 0, 1) == '#' && strlen( $color ) > 3 ) :
				return '<span style="color : '. $color .';" class="tf-colored">'. $title .'</span>';
			else :
				return $title;
			endif;
		}

		function initStylesforTitle(){

			wp_enqueue_style( 'initStyles', TITLIFY_URL . 'css/init.css' );
		}

		function savePostandAddColor(){
			global $post;

			if( isset( $_POST['tf-color'] ) && !empty( $_POST['tf-color'] ) )
				update_post_meta( $post->ID, 'tf-color', $_POST['tf-color'] );
		}

		function titlifySettingsPage(){

			add_submenu_page( 'options-general.php', 'Titlify settings', 'Titlify settings', 'manage_options', 'titlify-settings', array( $this, 'titlifySettings' ) ); 
		}

		function titlifySettings(){

			include_once TITLIFY_VIEWS . '/settings.php';
		}

	}

}

global $titlifyInit;
$titlifyInit = new titlify;

?>