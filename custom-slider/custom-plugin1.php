<?php
/**
 * Plugin Name: Custom Service Carousel
 * Plugin URI:  https://example.com/
 * Description: Elementor custom widget for service carousel
 * Version:     1.0.0
 * Author:      Sujar Khanal
 * Text Domain: custom-service-carousel
 */

if (!defined('ABSPATH')) exit;

/**
 * Register widget
 */
function cus_register_service_carousel_widget($widgets_manager) {
    require_once(__DIR__ . '/widgets/custom-widget.php');
    $widgets_manager->register(new \Cus_Service_Carousel_Widget());
}
add_action('elementor/widgets/register', 'cus_register_service_carousel_widget');

/**
 * Register assets
 */
function cus_register_service_carousel_assets() {
    $css_path = plugin_dir_path(__FILE__) . 'assets/css/style.css';
    $js_path  = plugin_dir_path(__FILE__) . 'assets/js/init.js';

    // Swiper CSS
    wp_register_style(
        'swiper-css',
        'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css',
        [],
        null
    );

    // Swiper JS
    wp_register_script(
        'swiper-js',
        'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js',
        [],
        null,
        true
    );

    // Font Awesome
    wp_register_style(
        'cus-font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css',
        [],
        null
    );

    // Google Font - Barlow
    wp_register_style(
        'cus-barlow-font',
        'https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600&display=swap',
        [],
        null
    );

    // Custom CSS
    wp_register_style(
        'custom-plugin1-style',
        plugins_url('assets/css/style.css', __FILE__),
        ['swiper-css', 'cus-barlow-font', 'cus-font-awesome'],
        file_exists($css_path) ? filemtime($css_path) : null
    );

    // Custom JS
    wp_register_script(
        'custom-plugin1-init',
        plugins_url('assets/js/init.js', __FILE__),
        ['jquery', 'swiper-js'],
        file_exists($js_path) ? filemtime($js_path) : null,
        true
    );
}
add_action('wp_enqueue_scripts', 'cus_register_service_carousel_assets');
add_action('elementor/frontend/after_register_styles', 'cus_register_service_carousel_assets');
add_action('elementor/frontend/after_register_scripts', 'cus_register_service_carousel_assets');
