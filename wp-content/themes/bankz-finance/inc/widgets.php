<?php
/**
 * Custom Widgets for BankKz Finance Theme
 *
 * @package BankKz_Finance
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * BankKz Calculator Widget
 */
class BankKz_Calculator_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'bankz_calculator_widget',
            __('BankKz Calculator', 'bankz-finance'),
            array(
                'description' => __('Display calculator widget with custom image and URL', 'bankz-finance'),
                'classname' => 'bankz-calculator-widget',
            )
        );
    }

    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Кредитный калькулятор', 'bankz-finance');
        $description = !empty($instance['description']) ? $instance['description'] : __('Рассчитайте ежемесячный платеж по кредиту', 'bankz-finance');
        $image_url = !empty($instance['image_url']) ? $instance['image_url'] : 'https://play-lh.googleusercontent.com/D3o9LNipiqxFL3YPtFMd_7lLeOWF2P6gzA0YKfYKj8S-krTEdttUS-GGyQHQ0_7xcGQ';
        $calc_url = !empty($instance['calc_url']) ? $instance['calc_url'] : '#';

        echo $args['before_widget'];
        ?>
        <div class="widget-body">
            <div class="calc-logo">
                <img src="<?php echo esc_url($image_url); ?>" alt="Calculator Logo" class="calc-logo-img">
            </div>
            <h3 class="widget-title"><?php echo esc_html($title); ?></h3>
            <p><?php echo esc_html($description); ?></p>
            <button class="calc-button" data-calc-url="<?php echo esc_url($calc_url); ?>">
                <?php _e('Открыть калькулятор', 'bankz-finance'); ?>
            </button>
        </div>
        <?php
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Кредитный калькулятор', 'bankz-finance');
        $description = !empty($instance['description']) ? $instance['description'] : __('Рассчитайте ежемесячный платеж по кредиту', 'bankz-finance');
        $image_url = !empty($instance['image_url']) ? $instance['image_url'] : '';
        $calc_url = !empty($instance['calc_url']) ? $instance['calc_url'] : '';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'bankz-finance'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('description')); ?>"><?php _e('Description:', 'bankz-finance'); ?></label>
            <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('description')); ?>"
                      name="<?php echo esc_attr($this->get_field_name('description')); ?>" rows="3"><?php echo esc_textarea($description); ?></textarea>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('image_url')); ?>"><?php _e('Image URL:', 'bankz-finance'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('image_url')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('image_url')); ?>" type="url"
                   value="<?php echo esc_url($image_url); ?>">
            <button type="button" class="button bankz-upload-image" data-target="<?php echo esc_attr($this->get_field_id('image_url')); ?>">
                <?php _e('Upload Image', 'bankz-finance'); ?>
            </button>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('calc_url')); ?>"><?php _e('Calculator URL:', 'bankz-finance'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('calc_url')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('calc_url')); ?>" type="url"
                   value="<?php echo esc_url($calc_url); ?>">
        </p>

        <script>
        jQuery(document).ready(function($) {
            $('.bankz-upload-image').click(function(e) {
                e.preventDefault();
                var target = $(this).data('target');
                var mediaUploader = wp.media({
                    title: '<?php _e('Choose Image', 'bankz-finance'); ?>',
                    button: {
                        text: '<?php _e('Choose Image', 'bankz-finance'); ?>'
                    },
                    multiple: false
                });

                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#' + target).val(attachment.url);
                });

                mediaUploader.open();
            });
        });
        </script>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['description'] = (!empty($new_instance['description'])) ? sanitize_text_field($new_instance['description']) : '';
        $instance['image_url'] = (!empty($new_instance['image_url'])) ? esc_url_raw($new_instance['image_url']) : '';
        $instance['calc_url'] = (!empty($new_instance['calc_url'])) ? esc_url_raw($new_instance['calc_url']) : '';

        return $instance;
    }
}

/**
 * BankKz Popular Posts Widget
 */
class BankKz_Popular_Posts_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'bankz_popular_posts_widget',
            __('BankKz Popular Posts', 'bankz-finance'),
            array(
                'description' => __('Display most viewed posts', 'bankz-finance'),
                'classname' => 'bankz-popular-posts-widget',
            )
        );
    }

    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Популярные статьи', 'bankz-finance');
        $count = !empty($instance['count']) ? intval($instance['count']) : 5;

        echo $args['before_widget'];
        echo $args['before_title'] . esc_html($title) . $args['after_title'];

        $popular_posts = new WP_Query(array(
            'posts_per_page' => $count,
            'meta_key' => '_bankz_auto_views',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
            'post_status' => 'publish'
        ));

        if ($popular_posts->have_posts()) : ?>
            <ul class="widget-list">
                <?php while ($popular_posts->have_posts()) : $popular_posts->the_post(); ?>
                    <li>
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        <span class="post-views">(<?php echo number_format(bankz_get_view_count()); ?> просмотров)</span>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php
            wp_reset_postdata();
        endif;

        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Популярные статьи', 'bankz-finance');
        $count = !empty($instance['count']) ? intval($instance['count']) : 5;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'bankz-finance'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('count')); ?>"><?php _e('Number of posts:', 'bankz-finance'); ?></label>
            <input class="tiny-text" id="<?php echo esc_attr($this->get_field_id('count')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('count')); ?>" type="number"
                   value="<?php echo esc_attr($count); ?>" min="1" max="10">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['count'] = (!empty($new_instance['count'])) ? intval($new_instance['count']) : 5;

        return $instance;
    }
}

/**
 * BankKz Financial News Widget
 */
class BankKz_Financial_News_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'bankz_financial_news_widget',
            __('BankKz Financial News', 'bankz-finance'),
            array(
                'description' => __('Display recent financial news posts', 'bankz-finance'),
                'classname' => 'bankz-financial-news-widget',
            )
        );
    }

    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Финансовые новости', 'bankz-finance');
        $count = !empty($instance['count']) ? intval($instance['count']) : 4;
        $category = !empty($instance['category']) ? $instance['category'] : '';

        echo $args['before_widget'];
        echo $args['before_title'] . esc_html($title) . $args['after_title'];

        $query_args = array(
            'posts_per_page' => $count,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC'
        );

        if (!empty($category)) {
            $query_args['category_name'] = $category;
        }

        $news_posts = new WP_Query($query_args);

        if ($news_posts->have_posts()) : ?>
            <ul class="widget-list">
                <?php while ($news_posts->have_posts()) : $news_posts->the_post(); ?>
                    <li>
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        <span class="post-date"><?php echo get_the_date('j M'); ?></span>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php
            wp_reset_postdata();
        endif;

        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Финансовые новости', 'bankz-finance');
        $count = !empty($instance['count']) ? intval($instance['count']) : 4;
        $category = !empty($instance['category']) ? $instance['category'] : '';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'bankz-finance'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('count')); ?>"><?php _e('Number of posts:', 'bankz-finance'); ?></label>
            <input class="tiny-text" id="<?php echo esc_attr($this->get_field_id('count')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('count')); ?>" type="number"
                   value="<?php echo esc_attr($count); ?>" min="1" max="10">
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('category')); ?>"><?php _e('Category (optional):', 'bankz-finance'); ?></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('category')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('category')); ?>">
                <option value=""><?php _e('All Categories', 'bankz-finance'); ?></option>
                <?php
                $categories = get_categories();
                foreach ($categories as $cat) {
                    printf(
                        '<option value="%s" %s>%s</option>',
                        $cat->slug,
                        selected($category, $cat->slug, false),
                        $cat->name
                    );
                }
                ?>
            </select>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['count'] = (!empty($new_instance['count'])) ? intval($new_instance['count']) : 4;
        $instance['category'] = (!empty($new_instance['category'])) ? sanitize_text_field($new_instance['category']) : '';

        return $instance;
    }
}

/**
 * Register custom widgets
 */
function bankz_register_widgets() {
    register_widget('BankKz_Calculator_Widget');
    register_widget('BankKz_Popular_Posts_Widget');
    register_widget('BankKz_Financial_News_Widget');
}
add_action('widgets_init', 'bankz_register_widgets');

/**
 * Enqueue media uploader for widgets
 */
function bankz_widgets_admin_enqueue($hook) {
    if ('widgets.php' == $hook) {
        wp_enqueue_media();
    }
}
add_action('admin_enqueue_scripts', 'bankz_widgets_admin_enqueue');
?>