<?php
/**
 * BankKz Custom Admin Panel
 *
 * @package BankKz_Finance
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class BankKz_Admin_Panel {

    public function __construct() {
        // Add debug notice to confirm class is loaded
        add_action('admin_notices', function() {
            if (isset($_GET['page']) && strpos($_GET['page'], 'bankz') !== false) {
                echo '<div class="notice notice-info"><p>BankKz Admin Panel Class Loaded Successfully!</p></div>';
            }
        });

        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        add_action('wp_ajax_bankz_save_settings', array($this, 'save_settings'));
        add_action('wp_ajax_bankz_get_analytics_data', array($this, 'get_analytics_data'));
    }

    /**
     * Add BankKz admin menu
     */
    public function add_admin_menu() {
        // Main menu item
        add_menu_page(
            __('BankKz Settings', 'bankz-finance'),
            __('BankKz', 'bankz-finance'),
            'manage_options',
            'bankz-settings',
            array($this, 'dashboard_page'),
            'data:image/svg+xml;base64,' . base64_encode('<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>'),
            25
        );

        // Dashboard submenu
        add_submenu_page(
            'bankz-settings',
            __('Dashboard', 'bankz-finance'),
            __('📊 Dashboard', 'bankz-finance'),
            'manage_options',
            'bankz-settings',
            array($this, 'dashboard_page')
        );

        // Analytics submenu
        add_submenu_page(
            'bankz-settings',
            __('Analytics', 'bankz-finance'),
            __('📈 Analytics', 'bankz-finance'),
            'manage_options',
            'bankz-analytics',
            array($this, 'analytics_page')
        );

        // Slider Settings submenu
        add_submenu_page(
            'bankz-settings',
            __('Slider Settings', 'bankz-finance'),
            __('🎚️ Slider Settings', 'bankz-finance'),
            'manage_options',
            'bankz-slider',
            array($this, 'slider_page')
        );

        // Preloader Settings submenu
        add_submenu_page(
            'bankz-settings',
            __('Preloader Settings', 'bankz-finance'),
            __('🎬 Preloader Settings', 'bankz-finance'),
            'manage_options',
            'bankz-preloader',
            array($this, 'preloader_page')
        );

        // Calculator Widget submenu
        add_submenu_page(
            'bankz-settings',
            __('Calculator Widget', 'bankz-finance'),
            __('🧮 Calculator Widget', 'bankz-finance'),
            'manage_options',
            'bankz-calculator',
            array($this, 'calculator_page')
        );

        // General Settings submenu
        add_submenu_page(
            'bankz-settings',
            __('General Settings', 'bankz-finance'),
            __('⚙️ General Settings', 'bankz-finance'),
            'manage_options',
            'bankz-general',
            array($this, 'general_page')
        );
    }

    /**
     * Enqueue admin scripts and styles
     */
    public function enqueue_admin_scripts($hook) {
        // Only load on our admin pages
        if (strpos($hook, 'bankz-') === false) {
            return;
        }

        wp_enqueue_style(
            'bankz-admin-style',
            BANKZ_THEME_URL . '/admin/admin-style.css',
            array(),
            BANKZ_THEME_VERSION
        );

        wp_enqueue_script(
            'bankz-admin-script',
            BANKZ_THEME_URL . '/admin/admin-script.js',
            array('jquery', 'wp-color-picker'),
            BANKZ_THEME_VERSION,
            true
        );

        // Localize script for AJAX
        wp_localize_script('bankz-admin-script', 'bankz_admin_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('bankz_admin_nonce'),
        ));

        wp_enqueue_media();
        wp_enqueue_style('wp-color-picker');
    }

    /**
     * Dashboard Page
     */
    public function dashboard_page() {
        $total_posts = wp_count_posts()->publish;
        $total_views = $this->get_total_views();
        $popular_categories = $this->get_popular_categories();
        $recent_analytics = $this->get_recent_analytics();

        include BANKZ_THEME_DIR . '/admin/dashboard.php';
    }

    /**
     * Analytics Page
     */
    public function analytics_page() {
        include BANKZ_THEME_DIR . '/admin/analytics.php';
    }

    /**
     * Slider Settings Page
     */
    public function slider_page() {
        // Comprehensive debugging
        if ($_POST) {
            echo '<div class="notice notice-info"><p><strong>DEBUG INFO:</strong><br>';
            echo 'POST data received: ' . print_r($_POST, true) . '<br>';
            echo 'Submit button clicked: ' . (isset($_POST['submit']) ? 'YES' : 'NO') . '<br>';
            echo 'Nonce exists: ' . (isset($_POST['_wpnonce']) ? 'YES' : 'NO') . '<br>';
            if (isset($_POST['_wpnonce'])) {
                echo 'Nonce value: ' . $_POST['_wpnonce'] . '<br>';
                echo 'Nonce verification: ' . (wp_verify_nonce($_POST['_wpnonce'], 'bankz_slider_settings') ? 'PASS' : 'FAIL') . '<br>';
            }
            echo '</p></div>';
        }

        if ($_POST && check_admin_referer('bankz_slider_settings')) {
            echo '<div class="notice notice-warning"><p>Processing form data...</p></div>';

            update_option('bankz_slider_source', sanitize_text_field($_POST['slider_source']));
            update_option('bankz_slider_categories', array_map('intval', $_POST['slider_categories'] ?? array()));
            update_option('bankz_slider_count', intval($_POST['slider_count']));
            update_option('bankz_slider_autoplay', isset($_POST['slider_autoplay']) ? 1 : 0);
            update_option('bankz_slider_interval', intval($_POST['slider_interval']));

            echo '<div class="notice notice-success"><p>' . __('Slider settings saved successfully!', 'bankz-finance') . '</p></div>';
        }

        include BANKZ_THEME_DIR . '/admin/slider-settings.php';
    }

    /**
     * Preloader Settings Page
     */
    public function preloader_page() {
        if (isset($_POST['submit']) && wp_verify_nonce($_POST['_wpnonce'], 'bankz_preloader_settings')) {
            update_option('bankz_preloader_enabled', isset($_POST['preloader_enabled']) ? 1 : 0);
            update_option('bankz_preloader_background', sanitize_text_field($_POST['preloader_background']));
            update_option('bankz_preloader_text', sanitize_text_field($_POST['preloader_text']));
            update_option('bankz_loading_text', sanitize_text_field($_POST['loading_text']));
            update_option('bankz_preloader_icons', array_map('sanitize_text_field', $_POST['preloader_icons'] ?? array()));

            echo '<div class="notice notice-success"><p>' . __('Preloader settings saved!', 'bankz-finance') . '</p></div>';
        }

        include BANKZ_THEME_DIR . '/admin/preloader-settings.php';
    }

    /**
     * Calculator Widget Page
     */
    public function calculator_page() {
        if (isset($_POST['submit']) && wp_verify_nonce($_POST['_wpnonce'], 'bankz_calculator_settings')) {
            update_option('bankz_calc_widget_image', esc_url_raw($_POST['calc_widget_image']));
            update_option('bankz_calc_widget_url', esc_url_raw($_POST['calc_widget_url']));
            update_option('bankz_calc_widget_title', sanitize_text_field($_POST['calc_widget_title']));
            update_option('bankz_calc_widget_description', sanitize_text_field($_POST['calc_widget_description']));

            echo '<div class="notice notice-success"><p>' . __('Calculator widget settings saved!', 'bankz-finance') . '</p></div>';
        }

        include BANKZ_THEME_DIR . '/admin/calculator-settings.php';
    }

    /**
     * General Settings Page
     */
    public function general_page() {
        if ($_POST && check_admin_referer('bankz_general_settings')) {
            // Update all general settings
            update_option('bankz_footer_tagline', sanitize_text_field($_POST['footer_tagline'] ?? ''));
            update_option('bankz_enable_analytics', isset($_POST['enable_analytics']) ? 1 : 0);
            update_option('bankz_enable_view_tracking', isset($_POST['enable_view_tracking']) ? 1 : 0);
            update_option('bankz_google_analytics_id', sanitize_text_field($_POST['google_analytics_id'] ?? ''));
            update_option('bankz_enable_comments', isset($_POST['enable_comments']) ? 1 : 0);
            update_option('bankz_posts_per_page', intval($_POST['posts_per_page'] ?? 6));
            update_option('bankz_excerpt_length', intval($_POST['excerpt_length'] ?? 25));

            echo '<div class="notice notice-success"><p>' . __('General settings saved!', 'bankz-finance') . '</p></div>';
        }

        include BANKZ_THEME_DIR . '/admin/general-settings.php';
    }

    /**
     * Get total views across all posts
     */
    private function get_total_views() {
        global $wpdb;

        $total_manual = $wpdb->get_var("
            SELECT SUM(CAST(meta_value AS UNSIGNED))
            FROM {$wpdb->postmeta}
            WHERE meta_key = '_bankz_manual_views'
        ");

        $total_auto = $wpdb->get_var("
            SELECT SUM(CAST(meta_value AS UNSIGNED))
            FROM {$wpdb->postmeta}
            WHERE meta_key = '_bankz_auto_views'
        ");

        return intval($total_manual) + intval($total_auto);
    }

    /**
     * Get popular categories with post counts
     */
    private function get_popular_categories() {
        return get_categories(array(
            'orderby' => 'count',
            'order' => 'DESC',
            'hide_empty' => false,
            'number' => 5
        ));
    }

    /**
     * Get recent analytics data
     */
    private function get_recent_analytics() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'bankz_analytics';

        // Check if table exists
        if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
            return array();
        }

        return $wpdb->get_results("
            SELECT DATE(visit_date) as date, COUNT(*) as views
            FROM $table_name
            WHERE visit_date >= DATE_SUB(NOW(), INTERVAL 30 DAY)
            GROUP BY DATE(visit_date)
            ORDER BY visit_date DESC
            LIMIT 7
        ");
    }

    /**
     * AJAX handler to get analytics data
     */
    public function get_analytics_data() {
        check_ajax_referer('bankz_admin_nonce', 'nonce');

        $period = sanitize_text_field($_POST['period'] ?? '7');
        global $wpdb;

        $table_name = $wpdb->prefix . 'bankz_analytics';

        $data = $wpdb->get_results($wpdb->prepare("
            SELECT DATE(visit_date) as date, COUNT(*) as views
            FROM $table_name
            WHERE visit_date >= DATE_SUB(NOW(), INTERVAL %d DAY)
            GROUP BY DATE(visit_date)
            ORDER BY visit_date ASC
        ", intval($period)));

        wp_send_json_success($data);
    }

    /**
     * AJAX handler to save settings
     */
    public function save_settings() {
        check_ajax_referer('bankz_admin_nonce', 'nonce');

        $settings = $_POST['settings'] ?? array();

        foreach ($settings as $key => $value) {
            update_option('bankz_' . sanitize_key($key), sanitize_text_field($value));
        }

        wp_send_json_success(__('Settings saved successfully!', 'bankz-finance'));
    }
}

// Initialize the admin panel
new BankKz_Admin_Panel();
?>