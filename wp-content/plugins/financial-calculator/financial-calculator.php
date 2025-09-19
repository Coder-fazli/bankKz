<?php
/**
 * Plugin Name: Financial Calculator
 * Plugin URI: https://github.com/Coder-fazli/bankKz
 * Description: A comprehensive financial calculator plugin with credit, mortgage, and deposit calculators for Kazakhstan banking websites.
 * Version: 1.0.0
 * Author: Victor Fazli
 * Author URI: https://coder-fazli.github.io
 * License: GPL v2 or later
 * Text Domain: financial-calculator
 * Domain Path: /languages
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('FINANCIAL_CALC_VERSION', '1.0.0');
define('FINANCIAL_CALC_PLUGIN_URL', plugin_dir_url(__FILE__));
define('FINANCIAL_CALC_PLUGIN_PATH', plugin_dir_path(__FILE__));

/**
 * Main Financial Calculator Plugin Class
 */
class FinancialCalculatorPlugin {

    /**
     * Constructor
     */
    public function __construct() {
        add_action('init', array($this, 'init'));
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));
    }

    /**
     * Initialize the plugin
     */
    public function init() {
        // Load plugin textdomain for translations
        load_plugin_textdomain('financial-calculator', false, dirname(plugin_basename(__FILE__)) . '/languages');

        // Include required files
        $this->includes();

        // Initialize shortcodes
        $this->init_shortcodes();

        // Enqueue scripts and styles
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));

        // Add admin menu
        add_action('admin_menu', array($this, 'add_admin_menu'));
    }

    /**
     * Include required files
     */
    private function includes() {
        require_once FINANCIAL_CALC_PLUGIN_PATH . 'includes/shortcodes.php';
        require_once FINANCIAL_CALC_PLUGIN_PATH . 'includes/admin.php';
    }

    /**
     * Initialize shortcodes
     */
    private function init_shortcodes() {
        new FinancialCalculatorShortcodes();
    }

    /**
     * Enqueue scripts and styles
     */
    public function enqueue_scripts() {
        wp_enqueue_style(
            'financial-calculator-style',
            FINANCIAL_CALC_PLUGIN_URL . 'assets/financial-calculator.css',
            array(),
            FINANCIAL_CALC_VERSION
        );

        wp_enqueue_script(
            'financial-calculator-script',
            FINANCIAL_CALC_PLUGIN_URL . 'assets/financial-calculator.js',
            array('jquery'),
            FINANCIAL_CALC_VERSION,
            true
        );

        // Localize script for AJAX if needed
        wp_localize_script('financial-calculator-script', 'financial_calc_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('financial_calc_nonce')
        ));
    }

    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_options_page(
            __('Financial Calculator', 'financial-calculator'),
            __('Financial Calculator', 'financial-calculator'),
            'manage_options',
            'financial-calculator',
            array($this, 'admin_page')
        );
    }

    /**
     * Admin page callback
     */
    public function admin_page() {
        include FINANCIAL_CALC_PLUGIN_PATH . 'includes/admin.php';
        financial_calculator_admin_page();
    }

    /**
     * Plugin activation
     */
    public function activate() {
        // Set default options
        add_option('financial_calc_version', FINANCIAL_CALC_VERSION);

        // Flush rewrite rules
        flush_rewrite_rules();
    }

    /**
     * Plugin deactivation
     */
    public function deactivate() {
        // Clean up if needed
        flush_rewrite_rules();
    }
}

// Initialize the plugin
new FinancialCalculatorPlugin();