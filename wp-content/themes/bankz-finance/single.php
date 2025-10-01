<?php
/**
 * The template for displaying single posts
 *
 * @package BankKz_Finance
 */

get_header(); ?>

<main class="main-content">
    <div class="content-wrapper single-post">

        <?php while (have_posts()) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class('single-article'); ?>>

                <!-- Post Header -->
                <header class="article-header">
                    <?php
                    $category = get_the_category();
                    $cat_name = $category ? $category[0]->name : 'Общее';
                    $view_count = bankz_get_view_count();
                    ?>

                    <div class="article-meta">
                        <div class="article-date">
                            <?php echo get_the_date('j F Y'); ?> • <?php echo esc_html($cat_name); ?>
                        </div>
                        <div class="view-count">
                            <span class="view-icon">👁</span>
                            <span><?php echo number_format($view_count); ?></span>
                        </div>
                    </div>

                    <h1 class="article-title"><?php the_title(); ?></h1>

                    <?php if (has_post_thumbnail()) : ?>
                        <div class="article-featured-image">
                            <?php the_post_thumbnail('large', array('class' => 'featured-img')); ?>
                        </div>
                    <?php endif; ?>
                </header>

                <!-- Post Content -->
                <div class="article-content-full">
                    <?php
                    the_content();

                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . __('Страницы:', 'bankz-finance'),
                        'after' => '</div>',
                    ));
                    ?>
                </div>

                <!-- Post Footer -->
                <footer class="article-footer">

                    <!-- Tags -->
                    <?php if (has_tag()) : ?>
                        <div class="post-tags">
                            <strong><?php _e('Теги:', 'bankz-finance'); ?></strong>
                            <?php the_tags('', ', ', ''); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Share Buttons -->
                    <div class="share-buttons">
                        <strong><?php _e('Поделиться:', 'bankz-finance'); ?></strong>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>"
                           target="_blank" class="share-btn facebook">Facebook</a>
                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>"
                           target="_blank" class="share-btn twitter">Twitter</a>
                        <a href="https://api.whatsapp.com/send?text=<?php echo urlencode(get_the_title() . ' ' . get_permalink()); ?>"
                           target="_blank" class="share-btn whatsapp">WhatsApp</a>
                    </div>

                    <!-- Post Navigation -->
                    <div class="post-navigation">
                        <?php
                        $prev_post = get_previous_post();
                        $next_post = get_next_post();
                        ?>

                        <?php if ($prev_post) : ?>
                            <div class="nav-previous">
                                <a href="<?php echo get_permalink($prev_post->ID); ?>" class="nav-link">
                                    <span class="nav-direction">← <?php _e('Предыдущая статья', 'bankz-finance'); ?></span>
                                    <span class="nav-title"><?php echo esc_html($prev_post->post_title); ?></span>
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if ($next_post) : ?>
                            <div class="nav-next">
                                <a href="<?php echo get_permalink($next_post->ID); ?>" class="nav-link">
                                    <span class="nav-direction"><?php _e('Следующая статья', 'bankz-finance'); ?> →</span>
                                    <span class="nav-title"><?php echo esc_html($next_post->post_title); ?></span>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </footer>

            </article>

            <!-- Related Posts -->
            <section class="related-posts">
                <h3><?php _e('Похожие статьи', 'bankz-finance'); ?></h3>
                <div class="related-posts-grid">
                    <?php
                    // Get related posts from same category
                    $related_posts = new WP_Query(array(
                        'posts_per_page' => 3,
                        'post__not_in' => array(get_the_ID()),
                        'category__in' => wp_get_post_categories(get_the_ID()),
                        'orderby' => 'rand'
                    ));

                    if ($related_posts->have_posts()) :
                        while ($related_posts->have_posts()) : $related_posts->the_post();
                            $related_view_count = bankz_get_view_count();
                            $related_category = get_the_category();
                            $related_cat_name = $related_category ? $related_category[0]->name : 'Общее';
                    ?>
                            <article class="related-article">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="related-image">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('bankz-article'); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>

                                <div class="related-content">
                                    <div class="related-meta">
                                        <?php echo get_the_date('j M Y'); ?> • <?php echo esc_html($related_cat_name); ?>
                                    </div>
                                    <h4 class="related-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h4>
                                    <div class="related-excerpt">
                                        <?php echo wp_trim_words(get_the_excerpt(), 10); ?>
                                    </div>
                                </div>
                            </article>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </section>

            <!-- Comments Section -->
            <?php
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            ?>

        <?php endwhile; ?>

    </div>

    <!-- Sidebar -->
    <?php get_sidebar(); ?>
</main>

<?php get_footer(); ?>