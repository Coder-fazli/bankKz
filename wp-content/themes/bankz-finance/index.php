<?php
/**
 * The main template file
 *
 * @package BankKz_Finance
 */

get_header(); ?>

<!-- Main Content -->
<main class="main-content">
    <!-- Content with Slider -->
    <div class="content-wrapper">

        <?php if (is_front_page()) : ?>
            <!-- Main Slider Section - Only on homepage -->
            <section class="main-slider">
                <div class="slider-container">
                    <div class="slider" id="mainSlider">
                        <?php
                        // Get slider settings
                        $slider_source = get_option('bankz_slider_source', 'featured');
                        $slider_categories = get_option('bankz_slider_categories', array());
                        $slider_count = get_option('bankz_slider_count', 3);

                        // Query for slider posts
                        if ($slider_source === 'featured') {
                            $slider_query = new WP_Query(array(
                                'posts_per_page' => $slider_count,
                                'meta_key' => '_bankz_featured_slider',
                                'meta_value' => '1',
                                'post_status' => 'publish'
                            ));
                        } else {
                            $slider_query = new WP_Query(array(
                                'posts_per_page' => $slider_count,
                                'category__in' => $slider_categories,
                                'post_status' => 'publish'
                            ));
                        }

                        if ($slider_query->have_posts()) :
                            while ($slider_query->have_posts()) : $slider_query->the_post();
                                $category = get_the_category();
                                $cat_name = $category ? $category[0]->name : 'Новости';

                                // Get background image
                                $bg_image = '';
                                if (has_post_thumbnail()) {
                                    $bg_image = 'style="background-image: url(' . esc_url(get_the_post_thumbnail_url(get_the_ID(), 'bankz-slider')) . ');"';
                                }
                        ?>
                                <div class="slide">
                                    <?php if ($bg_image) : ?>
                                        <div class="slide-background" <?php echo $bg_image; ?>></div>
                                    <?php endif; ?>
                                    <div class="slide-content">
                                        <div class="slide-category"><?php echo esc_html($cat_name); ?></div>
                                        <h3 class="slide-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h3>
                                    </div>
                                </div>
                        <?php
                            endwhile;
                            wp_reset_postdata();
                        else :
                            // Fallback slides if no posts found
                        ?>
                            <div class="slide">
                                <div class="slide-content">
                                    <div class="slide-category">Кредиты</div>
                                    <h3 class="slide-title">Добро пожаловать в ФинансБлог</h3>
                                </div>
                            </div>
                            <div class="slide">
                                <div class="slide-content">
                                    <div class="slide-category">Инвестиции</div>
                                    <h3 class="slide-title">Инвестиции для начинающих</h3>
                                </div>
                            </div>
                            <div class="slide">
                                <div class="slide-content">
                                    <div class="slide-category">Банки</div>
                                    <h3 class="slide-title">Обзор банковских депозитов</h3>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="slider-controls">
                        <button class="slider-btn" id="prevBtn">‹</button>
                        <button class="slider-btn" id="nextBtn">›</button>
                    </div>

                    <div class="slider-dots" id="sliderDots"></div>
                </div>
            </section>
        <?php endif; ?>

        <!-- Articles Grid Section -->
        <section class="articles-section">
            <h2><?php echo is_front_page() ? __('Последние новости', 'bankz-finance') : wp_title('', false); ?></h2>
            <div class="articles-grid">
                <?php
                // Main query for posts
                if (is_front_page()) {
                    // For homepage, limit to 6 posts initially
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    $posts_query = new WP_Query(array(
                        'post_type' => 'post',
                        'post_status' => 'publish',
                        'posts_per_page' => 6,
                        'paged' => $paged,
                        'orderby' => 'date',
                        'order' => 'DESC'
                    ));

                    if ($posts_query->have_posts()) :
                        while ($posts_query->have_posts()) : $posts_query->the_post();
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
                        wp_reset_postdata();
                    else :
                ?>
                    <div class="no-posts">
                        <p><?php _e('Статьи не найдены.', 'bankz-finance'); ?></p>
                    </div>
                <?php
                    endif;
                } else {
                    // For other pages, use default query
                    if (have_posts()) :
                        while (have_posts()) : the_post();
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
                    else :
                ?>
                    <div class="no-posts">
                        <p><?php _e('Статьи не найдены.', 'bankz-finance'); ?></p>
                    </div>
                <?php
                    endif;
                } ?>
            </div>

            <?php if (is_front_page()) : ?>
                <!-- Load More Button - Only on homepage -->
                <?php if ($posts_query->max_num_pages > 1) : ?>
                    <div class="load-more-container">
                        <button class="load-more-btn" id="loadMoreBtn">
                            <?php _e('Загрузить еще статьи', 'bankz-finance'); ?>
                        </button>
                    </div>
                <?php endif; ?>
            <?php else : ?>
                <!-- Pagination for other pages -->
                <div class="pagination">
                    <?php
                    the_posts_pagination(array(
                        'prev_text' => __('← Предыдущие', 'bankz-finance'),
                        'next_text' => __('Следующие →', 'bankz-finance'),
                    ));
                    ?>
                </div>
            <?php endif; ?>
        </section>
    </div>

    <!-- Sidebar -->
    <?php get_sidebar(); ?>
</main>

<?php get_footer(); ?>