<?php
/**
 * BankKz Finance Theme Customizer
 *
 * @package BankKz_Finance
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add postMessage support for site title and description for the Theme Customizer
 */
function bankz_customize_register($wp_customize) {

    // Remove default sections we don't need
    $wp_customize->remove_section('colors');
    $wp_customize->remove_section('background_image');

    // Theme Options Panel
    $wp_customize->add_panel('bankz_theme_options', array(
        'title' => __('BankKz Theme Options', 'bankz-finance'),
        'description' => __('Customize your BankKz Finance theme', 'bankz-finance'),
        'priority' => 10,
    ));

    // ===== GENERAL SETTINGS =====
    $wp_customize->add_section('bankz_general', array(
        'title' => __('General Settings', 'bankz-finance'),
        'panel' => 'bankz_theme_options',
        'priority' => 10,
    ));

    // Site Logo
    $wp_customize->add_setting('custom_logo');
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'custom_logo', array(
        'label' => __('Site Logo', 'bankz-finance'),
        'section' => 'bankz_general',
        'mime_type' => 'image',
    )));

    // Footer Tagline
    $wp_customize->add_setting('bankz_footer_tagline', array(
        'default' => 'Финансовые советы и новости Казахстана',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('bankz_footer_tagline', array(
        'type' => 'text',
        'label' => __('Footer Tagline', 'bankz-finance'),
        'section' => 'bankz_general',
    ));

    // ===== PRELOADER SETTINGS =====
    $wp_customize->add_section('bankz_preloader', array(
        'title' => __('Preloader Settings', 'bankz-finance'),
        'panel' => 'bankz_theme_options',
        'priority' => 20,
    ));

    // Enable Preloader
    $wp_customize->add_setting('bankz_preloader_enabled', array(
        'default' => 1,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('bankz_preloader_enabled', array(
        'type' => 'checkbox',
        'label' => __('Enable Preloader', 'bankz-finance'),
        'section' => 'bankz_preloader',
    ));

    // Preloader Background
    $wp_customize->add_setting('bankz_preloader_background', array(
        'default' => 'linear-gradient(135deg, #6b4226, #8b4513)',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('bankz_preloader_background', array(
        'type' => 'text',
        'label' => __('Preloader Background (CSS)', 'bankz-finance'),
        'description' => __('Use CSS background values like colors or gradients', 'bankz-finance'),
        'section' => 'bankz_preloader',
    ));

    // Preloader Text
    $wp_customize->add_setting('bankz_preloader_text', array(
        'default' => 'ФинансБлог',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('bankz_preloader_text', array(
        'type' => 'text',
        'label' => __('Preloader Title', 'bankz-finance'),
        'section' => 'bankz_preloader',
    ));

    // Loading Text
    $wp_customize->add_setting('bankz_loading_text', array(
        'default' => 'Загружаем финансовые данные...',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('bankz_loading_text', array(
        'type' => 'text',
        'label' => __('Loading Text', 'bankz-finance'),
        'section' => 'bankz_preloader',
    ));

    // ===== SLIDER SETTINGS =====
    $wp_customize->add_section('bankz_slider', array(
        'title' => __('Homepage Slider', 'bankz-finance'),
        'panel' => 'bankz_theme_options',
        'priority' => 30,
    ));

    // Slider Source
    $wp_customize->add_setting('bankz_slider_source', array(
        'default' => 'featured',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('bankz_slider_source', array(
        'type' => 'radio',
        'label' => __('Slider Source', 'bankz-finance'),
        'section' => 'bankz_slider',
        'choices' => array(
            'featured' => __('Featured Posts (marked in post editor)', 'bankz-finance'),
            'category' => __('Posts from Categories', 'bankz-finance'),
            'recent' => __('Recent Posts', 'bankz-finance'),
        ),
    ));

    // Slider Count
    $wp_customize->add_setting('bankz_slider_count', array(
        'default' => 3,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('bankz_slider_count', array(
        'type' => 'number',
        'label' => __('Number of Slides', 'bankz-finance'),
        'section' => 'bankz_slider',
        'input_attrs' => array(
            'min' => 1,
            'max' => 8,
        ),
    ));

    // ===== CALCULATOR WIDGET =====
    $wp_customize->add_section('bankz_calculator', array(
        'title' => __('Calculator Widget', 'bankz-finance'),
        'panel' => 'bankz_theme_options',
        'priority' => 40,
    ));

    // Calculator Image
    $wp_customize->add_setting('bankz_calc_widget_image', array(
        'default' => 'https://play-lh.googleusercontent.com/D3o9LNipiqxFL3YPtFMd_7lLeOWF2P6gzA0YKfYKj8S-krTEdttUS-GGyQHQ0_7xcGQ',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'bankz_calc_widget_image', array(
        'label' => __('Calculator Icon/Image', 'bankz-finance'),
        'section' => 'bankz_calculator',
        'mime_type' => 'image',
    )));

    // Calculator URL
    $wp_customize->add_setting('bankz_calc_widget_url', array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('bankz_calc_widget_url', array(
        'type' => 'url',
        'label' => __('Calculator Page URL', 'bankz-finance'),
        'section' => 'bankz_calculator',
    ));

    // Calculator Title
    $wp_customize->add_setting('bankz_calc_widget_title', array(
        'default' => 'Кредитный калькулятор',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('bankz_calc_widget_title', array(
        'type' => 'text',
        'label' => __('Calculator Title', 'bankz-finance'),
        'section' => 'bankz_calculator',
    ));

    // Calculator Description
    $wp_customize->add_setting('bankz_calc_widget_description', array(
        'default' => 'Рассчитайте ежемесячный платеж по кредиту',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('bankz_calc_widget_description', array(
        'type' => 'textarea',
        'label' => __('Calculator Description', 'bankz-finance'),
        'section' => 'bankz_calculator',
    ));
}
add_action('customize_register', 'bankz_customize_register');

/**
 * Render the site title for the selective refresh partial
 */
function bankz_customize_partial_blogname() {
    bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial
 */
function bankz_customize_partial_blogdescription() {
    bloginfo('description');
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously
 */
function bankz_customize_preview_js() {
    wp_enqueue_script(
        'bankz-customizer',
        BANKZ_THEME_URL . '/assets/js/customizer.js',
        array('customize-preview'),
        BANKZ_THEME_VERSION,
        true
    );
}
add_action('customize_preview_init', 'bankz_customize_preview_js');
?>