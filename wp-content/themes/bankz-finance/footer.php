    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <?php if (is_active_sidebar('footer-widgets')) : ?>
                <div class="footer-widgets">
                    <?php dynamic_sidebar('footer-widgets'); ?>
                </div>
            <?php endif; ?>

            <div class="footer-content">
                <p>&copy; <?php echo date('Y'); ?> <?php echo esc_html(get_bloginfo('name')); ?>. <?php _e('Все права защищены.', 'bankz-finance'); ?></p>
                <p><?php echo esc_html(get_option('bankz_footer_tagline', 'Финансовые советы и новости Казахстана')); ?></p>
            </div>

            <?php
            // Footer menu if set
            if (has_nav_menu('footer')) {
                wp_nav_menu(array(
                    'theme_location' => 'footer',
                    'menu_class' => 'footer-menu',
                    'container' => 'nav',
                    'container_class' => 'footer-navigation',
                ));
            }
            ?>
        </div>
    </footer>

<?php wp_footer(); ?>
</body>
</html>