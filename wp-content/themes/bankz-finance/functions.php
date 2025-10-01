<?php
/**
 * BankKz Finance Theme Functions
 *
 * @package BankKz_Finance
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Theme constants
define('BANKZ_THEME_VERSION', '1.0.0');
define('BANKZ_THEME_DIR', get_template_directory());
define('BANKZ_THEME_URL', get_template_directory_uri());

/**
 * Theme Setup
 */
function bankz_theme_setup() {
    // Add theme support for various features
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('post-formats', array(
        'aside',
        'gallery',
        'link',
        'image',
        'quote',
        'status',
        'video',
        'audio',
        'chat'
    ));

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'bankz-finance'),
        'footer' => __('Footer Menu', 'bankz-finance'),
    ));

    // Set content width
    global $content_width;
    if (!isset($content_width)) {
        $content_width = 1200;
    }

    // Add custom image sizes
    add_image_size('bankz-slider', 1200, 450, true);
    add_image_size('bankz-article', 600, 250, true);
    add_image_size('bankz-widget', 150, 150, true);
}
add_action('after_setup_theme', 'bankz_theme_setup');

/**
 * Enqueue Scripts and Styles
 */
function bankz_enqueue_scripts() {
    // Main stylesheet
    wp_enqueue_style(
        'bankz-main-style',
        BANKZ_THEME_URL . '/assets/css/main.css',
        array(),
        BANKZ_THEME_VERSION
    );

    // Main JavaScript
    wp_enqueue_script(
        'bankz-main-script',
        BANKZ_THEME_URL . '/assets/js/main.js',
        array('jquery'),
        BANKZ_THEME_VERSION,
        true
    );

    // Localize script for AJAX
    wp_localize_script('bankz-main-script', 'bankz_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('bankz_nonce'),
        'post_id' => get_the_ID(),
    ));

    // Load comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'bankz_enqueue_scripts');

/**
 * Register Widget Areas
 */
function bankz_register_sidebars() {
    // Main sidebar
    register_sidebar(array(
        'name' => __('Main Sidebar', 'bankz-finance'),
        'id' => 'sidebar-main',
        'description' => __('Main sidebar for articles, categories, and popular posts', 'bankz-finance'),
        'before_widget' => '<div class="sidebar-widget border-radius">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    // Calculator widget area
    register_sidebar(array(
        'name' => __('Calculator Widget', 'bankz-finance'),
        'id' => 'calculator-widget',
        'description' => __('Special area for calculator widget', 'bankz-finance'),
        'before_widget' => '<div class="sidebar-widget calculator-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    // Footer widgets
    register_sidebar(array(
        'name' => __('Footer Widgets', 'bankz-finance'),
        'id' => 'footer-widgets',
        'description' => __('Footer widget area', 'bankz-finance'),
        'before_widget' => '<div class="footer-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="footer-widget-title">',
        'after_title' => '</h4>',
    ));
}
add_action('widgets_init', 'bankz_register_sidebars');

/**
 * Custom Post Meta for View Counter
 */
function bankz_add_view_meta_box() {
    add_meta_box(
        'bankz_view_counter',
        __('BankKz View Counter', 'bankz-finance'),
        'bankz_view_counter_callback',
        'post',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'bankz_add_view_meta_box');

function bankz_view_counter_callback($post) {
    wp_nonce_field(basename(__FILE__), 'bankz_view_counter_nonce');

    $manual_views = get_post_meta($post->ID, '_bankz_manual_views', true);
    $auto_views = get_post_meta($post->ID, '_bankz_auto_views', true);
    $featured_slider = get_post_meta($post->ID, '_bankz_featured_slider', true);

    echo '<table class="form-table">';
    echo '<tr>';
    echo '<td><label for="bankz_manual_views">' . __('Manual View Count:', 'bankz-finance') . '</label></td>';
    echo '<td><input type="number" id="bankz_manual_views" name="bankz_manual_views" value="' . esc_attr($manual_views) . '" min="0" /></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td><label>' . __('Auto View Count:', 'bankz-finance') . '</label></td>';
    echo '<td><strong>' . intval($auto_views) . '</strong> <em>(automatically counted)</em></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td><label>' . __('Total Views:', 'bankz-finance') . '</label></td>';
    echo '<td><strong>' . (intval($manual_views) + intval($auto_views)) . '</strong></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td><label for="bankz_featured_slider">' . __('Featured in Slider:', 'bankz-finance') . '</label></td>';
    echo '<td><input type="checkbox" id="bankz_featured_slider" name="bankz_featured_slider" value="1" ' . checked(1, $featured_slider, false) . ' /></td>';
    echo '</tr>';
    echo '</table>';
}

function bankz_save_view_counter($post_id) {
    if (!isset($_POST['bankz_view_counter_nonce']) || !wp_verify_nonce($_POST['bankz_view_counter_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    if ('post' == $_POST['post_type']) {
        if (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }
    }

    // Save manual view count
    if (isset($_POST['bankz_manual_views'])) {
        update_post_meta($post_id, '_bankz_manual_views', intval($_POST['bankz_manual_views']));
    }

    // Save featured slider status
    if (isset($_POST['bankz_featured_slider'])) {
        update_post_meta($post_id, '_bankz_featured_slider', 1);
    } else {
        delete_post_meta($post_id, '_bankz_featured_slider');
    }
}
add_action('save_post', 'bankz_save_view_counter');

/**
 * AJAX Handler for View Tracking
 */
function bankz_track_view() {
    check_ajax_referer('bankz_nonce', 'nonce');

    $post_id = intval($_POST['post_id']);
    if ($post_id) {
        $current_views = intval(get_post_meta($post_id, '_bankz_auto_views', true));
        update_post_meta($post_id, '_bankz_auto_views', $current_views + 1);

        wp_send_json_success('View tracked');
    }

    wp_send_json_error('Invalid post ID');
}
add_action('wp_ajax_bankz_track_view', 'bankz_track_view');
add_action('wp_ajax_nopriv_bankz_track_view', 'bankz_track_view');

/**
 * Get Total View Count
 */
function bankz_get_view_count($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $manual_views = intval(get_post_meta($post_id, '_bankz_manual_views', true));
    $auto_views = intval(get_post_meta($post_id, '_bankz_auto_views', true));

    return $manual_views + $auto_views;
}

/**
 * Include custom files
 */
require_once BANKZ_THEME_DIR . '/inc/customizer.php';
require_once BANKZ_THEME_DIR . '/inc/widgets.php';

// Load admin panel only in admin
if (is_admin()) {
    // Add a debug notice to verify admin is loading
    add_action('admin_notices', function() {
        echo '<div class="notice notice-warning"><p><strong>🚨 FUNCTIONS.PHP DEBUG:</strong> Admin detected, loading BankKz admin panel...</p></div>';
    });

    require_once BANKZ_THEME_DIR . '/inc/bankz-admin-panel.php';

    // Verify file was loaded
    add_action('admin_notices', function() {
        if (class_exists('BankKz_Admin_Panel')) {
            echo '<div class="notice notice-success"><p><strong>✅ SUCCESS:</strong> BankKz_Admin_Panel class loaded!</p></div>';
        } else {
            echo '<div class="notice notice-error"><p><strong>❌ ERROR:</strong> BankKz_Admin_Panel class NOT loaded!</p></div>';
        }
    });
}

/**
 * Theme activation hook
 */
function bankz_theme_activation() {
    // Create database tables for analytics if needed
    global $wpdb;

    $table_name = $wpdb->prefix . 'bankz_analytics';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        post_id bigint(20) NOT NULL,
        user_ip varchar(45) NOT NULL,
        visit_date datetime DEFAULT CURRENT_TIMESTAMP,
        user_agent text,
        PRIMARY KEY (id),
        INDEX post_id (post_id),
        INDEX visit_date (visit_date)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    // Set default theme options
    if (!get_option('bankz_preloader_enabled')) {
        add_option('bankz_preloader_enabled', 1);
    }
}

// Hook into theme switch
add_action('after_switch_theme', 'bankz_theme_activation');

/**
 * Admin notice for successful activation
 */
function bankz_activation_notice() {
    if (get_transient('bankz_activated')) {
        echo '<div class="notice notice-success is-dismissible">';
        echo '<p><strong>BankKz Finance Theme activated!</strong> Visit <a href="' . admin_url('admin.php?page=bankz-settings') . '">BankKz Settings</a> to configure your theme.</p>';
        echo '</div>';
        delete_transient('bankz_activated');
    }
}
add_action('admin_notices', 'bankz_activation_notice');

// Set activation transient
if (is_admin() && isset($_GET['activated'])) {
    set_transient('bankz_activated', true, 30);
}

/**
 * Custom excerpt length
 */
function bankz_excerpt_length($length) {
    return 15; // Reduced to fit ~90 characters
}
add_filter('excerpt_length', 'bankz_excerpt_length');

/**
 * Get trimmed excerpt with character limit
 */
function bankz_get_excerpt($limit = 90) {
    $excerpt = get_the_excerpt();
    if (strlen($excerpt) > $limit) {
        $excerpt = substr($excerpt, 0, $limit);
        // Find last space to avoid cutting words
        $last_space = strrpos($excerpt, ' ');
        if ($last_space !== false) {
            $excerpt = substr($excerpt, 0, $last_space);
        }
        $excerpt .= '...';
    }
    return $excerpt;
}

/**
 * Custom excerpt more
 */
function bankz_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'bankz_excerpt_more');

/**
 * AJAX Load More Posts
 */
function bankz_load_more_posts() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'bankz_load_more_nonce')) {
        wp_die('Security check failed');
    }

    $page = intval($_POST['page']);
    $posts_per_page = intval($_POST['posts_per_page']) ?: 6;

    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => $posts_per_page,
        'paged' => $page,
        'orderby' => 'date',
        'order' => 'DESC'
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        ob_start();

        while ($query->have_posts()) : $query->the_post();
            $view_count = bankz_get_view_count();
            $category = get_the_category();
            $cat_name = $category ? $category[0]->name : 'Общее';
            $post_date = get_the_date('j F Y');

            // Get featured image
            $featured_image = '';
            $image_style = '';
            if (has_post_thumbnail()) {
                $featured_image = get_the_post_thumbnail_url(get_the_ID(), 'bankz-article');
                $image_style = 'style="background-image: url(' . esc_url($featured_image) . ');"';
            }
        ?>
            <article class="article-card">
                <div class="article-image" <?php echo $image_style; ?>>
                    <?php if (!has_post_thumbnail()) : ?>
                        <?php
                        // Default emoji based on category
                        $default_emojis = array(
                            'ипотека' => '🏠',
                            'страхование' => '🛡️',
                            'налоги' => '📊',
                            'криптовалюты' => '₿',
                            'планирование' => '💰',
                            'валюта' => '💱',
                            'кредиты' => '💳',
                            'инвестиции' => '📈',
                            'банки' => '🏦'
                        );

                        $emoji = '📰'; // default
                        foreach ($default_emojis as $key => $value) {
                            if (stripos($cat_name, $key) !== false) {
                                $emoji = $value;
                                break;
                            }
                        }
                        echo $emoji;
                        ?>
                    <?php endif; ?>
                </div>
                <div class="article-content">
                    <div class="article-meta">
                        <div class="article-date"><?php echo esc_html($post_date); ?> • <?php echo esc_html($cat_name); ?></div>
                        <div class="view-count">
                            <span class="view-icon">👁</span>
                            <span><?php echo number_format($view_count); ?></span>
                        </div>
                    </div>
                    <h3 class="article-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                    <p class="article-excerpt"><?php echo bankz_get_excerpt(90); ?></p>
                    <a href="<?php the_permalink(); ?>" class="read-more"><?php _e('Читать далее', 'bankz-finance'); ?> →</a>
                </div>
            </article>
        <?php
        endwhile;

        $posts_html = ob_get_clean();
        wp_reset_postdata();

        wp_send_json_success(array(
            'html' => $posts_html,
            'has_more' => ($query->max_num_pages > $page)
        ));
    } else {
        wp_send_json_error('No more posts found');
    }
}

add_action('wp_ajax_bankz_load_more_posts', 'bankz_load_more_posts');
add_action('wp_ajax_nopriv_bankz_load_more_posts', 'bankz_load_more_posts');

/**
 * Localize AJAX script data
 */
function bankz_localize_script() {
    if (is_front_page()) {
        wp_localize_script('bankz-main-script', 'bankz_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('bankz_load_more_nonce'),
            'loading_text' => __('Загружаем...', 'bankz-finance'),
            'load_more_text' => __('Загрузить еще статьи', 'bankz-finance'),
            'no_more_text' => __('Больше статей нет', 'bankz-finance')
        ));
    }
}
add_action('wp_enqueue_scripts', 'bankz_localize_script', 20);
?>