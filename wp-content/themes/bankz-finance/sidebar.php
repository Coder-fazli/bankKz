<?php
/**
 * The sidebar containing the main widget area
 *
 * @package BankKz_Finance
 */

if (!is_active_sidebar('sidebar-main') && !is_active_sidebar('calculator-widget')) {
    return;
}
?>

<aside class="sidebar">

    <!-- Calculator Widget Area -->
    <?php if (is_active_sidebar('calculator-widget')) : ?>
        <?php dynamic_sidebar('calculator-widget'); ?>
    <?php else : ?>
        <!-- Default Calculator Widget if no widget is set -->
        <div class="sidebar-widget calculator-widget">
            <div class="widget-body">
                <div class="calc-logo">
                    <?php
                    $calc_image = get_option('bankz_calc_widget_image', 'https://play-lh.googleusercontent.com/D3o9LNipiqxFL3YPtFMd_7lLeOWF2P6gzA0YKfYKj8S-krTEdttUS-GGyQHQ0_7xcGQ');
                    $calc_url = get_option('bankz_calc_widget_url', '#');
                    $calc_title = get_option('bankz_calc_widget_title', 'Кредитный калькулятор');
                    $calc_description = get_option('bankz_calc_widget_description', 'Рассчитайте ежемесячный платеж по кредиту');
                    ?>
                    <img src="<?php echo esc_url($calc_image); ?>" alt="Calculator Logo" class="calc-logo-img">
                </div>
                <h3 class="widget-title"><?php echo esc_html($calc_title); ?></h3>
                <p><?php echo esc_html($calc_description); ?></p>
                <button class="calc-button" data-calc-url="<?php echo esc_url($calc_url); ?>">
                    <?php _e('Открыть калькулятор', 'bankz-finance'); ?>
                </button>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Sidebar Widgets - Using Custom Design -->
    <?php if (false) : ?>
        <?php dynamic_sidebar('sidebar-main'); ?>
    <?php else : ?>
        <!-- Default widgets if no widgets are set -->

        <!-- Popular Articles Widget -->
        <div class="border-radius">
            <div class="sidebar-widget">
                <h3 class="widget-title"><?php _e('Популярные статьи', 'bankz-finance'); ?></h3>
            <ul class="widget-list">
                <?php
                $popular_posts = new WP_Query(array(
                    'posts_per_page' => 5,
                    'meta_key' => '_bankz_auto_views',
                    'orderby' => 'meta_value_num',
                    'order' => 'DESC',
                    'post_status' => 'publish'
                ));

                if ($popular_posts->have_posts()) :
                    while ($popular_posts->have_posts()) : $popular_posts->the_post();
                ?>
                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    // Default popular articles
                ?>
                    <li><a href="#">Как накопить на первоначальный взнос</a></li>
                    <li><a href="#">Налоговые льготы для ИП</a></li>
                    <li><a href="#">Страхование жизни: нужно ли?</a></li>
                    <li><a href="#">Криптовалюта в Казахстане</a></li>
                    <li><a href="#">Планирование семейного бюджета</a></li>
                <?php endif; ?>
            </ul>
            </div>
        </div>

        <!-- Categories Widget -->
        <div class="border-radius">
            <div class="sidebar-widget">
                <h3 class="widget-title"><?php _e('Категории', 'bankz-finance'); ?></h3>
            <ul class="widget-list">
                <?php
                $categories = get_categories(array(
                    'orderby' => 'count',
                    'order' => 'DESC',
                    'hide_empty' => false,
                    'number' => 6
                ));

                if ($categories) :
                    foreach ($categories as $category) :
                ?>
                        <li>
                            <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                                <?php echo esc_html($category->name); ?> (<?php echo $category->count; ?>)
                            </a>
                        </li>
                <?php
                    endforeach;
                else :
                    // Default categories
                ?>
                    <li><a href="#">Кредиты (24)</a></li>
                    <li><a href="#">Инвестиции (18)</a></li>
                    <li><a href="#">Банки (15)</a></li>
                    <li><a href="#">Ипотека (12)</a></li>
                    <li><a href="#">Страхование (8)</a></li>
                    <li><a href="#">Налоги (6)</a></li>
                <?php endif; ?>
            </ul>
            </div>
        </div>

        <!-- Recent News Widget -->
        <div class="border-radius">
            <div class="sidebar-widget">
                <h3 class="widget-title"><?php _e('Финансовые новости', 'bankz-finance'); ?></h3>
            <ul class="widget-list">
                <?php
                // Try to get posts from 'news' category, otherwise recent posts
                $news_category = get_category_by_slug('news');
                $news_query = new WP_Query(array(
                    'posts_per_page' => 4,
                    'category_name' => $news_category ? 'news' : '',
                    'post_status' => 'publish',
                    'orderby' => 'date',
                    'order' => 'DESC'
                ));

                if ($news_query->have_posts()) :
                    while ($news_query->have_posts()) : $news_query->the_post();
                ?>
                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    // Default news items
                ?>
                    <li><a href="#">НБ РК повысил базовую ставку</a></li>
                    <li><a href="#">Новые правила валютного законодательства</a></li>
                    <li><a href="#">Изменения в программе "Баспана Хит"</a></li>
                    <li><a href="#">Рост курса доллара</a></li>
                <?php endif; ?>
            </ul>
            </div>
        </div>

    <?php endif; ?>

</aside>