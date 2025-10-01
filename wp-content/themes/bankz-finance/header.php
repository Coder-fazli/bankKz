<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php
// Check if preloader is enabled
$preloader_enabled = get_option('bankz_preloader_enabled', 1);
$preloader_bg = get_option('bankz_preloader_background', 'linear-gradient(135deg, #6b4226, #8b4513)');
$preloader_icons = get_option('bankz_preloader_icons', array('$', '%', '₸', '€', '£'));

if ($preloader_enabled && is_front_page()) : ?>
    <!-- Preloader -->
    <div class="preloader" id="preloader" style="background: <?php echo esc_attr($preloader_bg); ?>">
        <div class="coins-animation"><?php echo esc_html($preloader_icons[0] ?? '$'); ?></div>
        <div class="coins-animation"><?php echo esc_html($preloader_icons[1] ?? '€'); ?></div>
        <div class="coins-animation"><?php echo esc_html($preloader_icons[2] ?? '₸'); ?></div>

        <div class="preloader-content">
            <div class="preloader-logo"><?php echo esc_html(get_option('bankz_preloader_text', 'ФинансБлог')); ?></div>

            <div class="finance-icons">
                <?php foreach ($preloader_icons as $icon) : ?>
                    <div class="finance-icon"><?php echo esc_html($icon); ?></div>
                <?php endforeach; ?>
            </div>

            <div class="loading-bar">
                <div class="loading-progress" id="loadingProgress"></div>
            </div>

            <div class="loading-text"><?php echo esc_html(get_option('bankz_loading_text', 'Загружаем финансовые данные...')); ?></div>
        </div>
    </div>
<?php endif; ?>

<!-- Header -->
<header class="header">
    <div class="header-container">
        <div class="logo">
            <?php if (has_custom_logo()) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <?php echo esc_html(get_bloginfo('name')); ?>
                </a>
            <?php endif; ?>
        </div>

        <nav class="nav">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_class' => '',
                'container' => false,
                'fallback_cb' => 'bankz_fallback_menu',
            ));
            ?>
        </nav>
    </div>
</header>

<?php
/**
 * Fallback menu if no menu is assigned
 */
function bankz_fallback_menu() {
    echo '<ul>';
    echo '<li><a href="' . esc_url(home_url('/')) . '">' . __('Главная', 'bankz-finance') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/blog/')) . '">' . __('Статьи', 'bankz-finance') . '</a></li>';
    echo '<li><a href="#calculator">' . __('Калькулятор', 'bankz-finance') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/category/news/')) . '">' . __('Новости', 'bankz-finance') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/about/')) . '">' . __('О нас', 'bankz-finance') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/contact/')) . '">' . __('Контакты', 'bankz-finance') . '</a></li>';
    echo '</ul>';
}
?>