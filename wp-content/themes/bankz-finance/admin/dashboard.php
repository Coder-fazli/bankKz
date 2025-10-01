<?php
/**
 * BankKz Dashboard Page
 *
 * @package BankKz_Finance
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="wrap bankz-admin-page">
    <div class="bankz-admin-header">
        <h1>🏦 BankKz Finance Dashboard</h1>
        <p class="description">Добро пожаловать в панель управления темой BankKz Finance. Здесь вы можете просматривать аналитику, управлять настройками и контролировать все аспекты вашего финансового блога.</p>
    </div>

    <div class="bankz-dashboard-content">

        <!-- Stats Cards -->
        <div class="bankz-stats-grid">
            <div class="bankz-stat-card">
                <div class="stat-icon">📝</div>
                <div class="stat-content">
                    <div class="stat-number"><?php echo number_format($total_posts); ?></div>
                    <div class="stat-label"><?php _e('Всего статей', 'bankz-finance'); ?></div>
                </div>
            </div>

            <div class="bankz-stat-card">
                <div class="stat-icon">👁️</div>
                <div class="stat-content">
                    <div class="stat-number"><?php echo number_format($total_views); ?></div>
                    <div class="stat-label"><?php _e('Всего просмотров', 'bankz-finance'); ?></div>
                </div>
            </div>

            <div class="bankz-stat-card">
                <div class="stat-icon">📊</div>
                <div class="stat-content">
                    <div class="stat-number"><?php echo count($popular_categories); ?></div>
                    <div class="stat-label"><?php _e('Активных категорий', 'bankz-finance'); ?></div>
                </div>
            </div>

            <div class="bankz-stat-card">
                <div class="stat-icon">🎯</div>
                <div class="stat-content">
                    <?php
                    $avg_views = $total_posts > 0 ? round($total_views / $total_posts) : 0;
                    ?>
                    <div class="stat-number"><?php echo number_format($avg_views); ?></div>
                    <div class="stat-label"><?php _e('Средние просмотры', 'bankz-finance'); ?></div>
                </div>
            </div>
        </div>

        <!-- Charts and Analytics -->
        <div class="bankz-dashboard-row">

            <!-- Recent Analytics Chart -->
            <div class="bankz-dashboard-widget bankz-chart-widget">
                <div class="widget-header">
                    <h3>📈 <?php _e('Аналитика за неделю', 'bankz-finance'); ?></h3>
                    <div class="widget-actions">
                        <select id="analytics-period">
                            <option value="7"><?php _e('7 дней', 'bankz-finance'); ?></option>
                            <option value="30"><?php _e('30 дней', 'bankz-finance'); ?></option>
                            <option value="90"><?php _e('90 дней', 'bankz-finance'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="widget-content">
                    <div id="analytics-chart" class="bankz-chart">
                        <?php if (!empty($recent_analytics)) : ?>
                            <div class="chart-bars">
                                <?php foreach (array_reverse($recent_analytics) as $data) : ?>
                                    <div class="chart-bar" data-value="<?php echo $data->views; ?>">
                                        <div class="bar-fill" style="height: <?php echo min(100, ($data->views / max(array_column($recent_analytics, 'views')) * 100)); ?>%"></div>
                                        <div class="bar-label"><?php echo date('j M', strtotime($data->date)); ?></div>
                                        <div class="bar-value"><?php echo $data->views; ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else : ?>
                            <div class="no-data">
                                <p><?php _e('Пока нет данных аналитики. Данные будут появляться по мере посещения сайта.', 'bankz-finance'); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Popular Categories -->
            <div class="bankz-dashboard-widget">
                <div class="widget-header">
                    <h3>🏷️ <?php _e('Популярные категории', 'bankz-finance'); ?></h3>
                </div>
                <div class="widget-content">
                    <?php if (!empty($popular_categories)) : ?>
                        <div class="categories-list">
                            <?php foreach ($popular_categories as $category) : ?>
                                <div class="category-item">
                                    <div class="category-info">
                                        <span class="category-name"><?php echo esc_html($category->name); ?></span>
                                        <span class="category-count"><?php echo $category->count; ?> статей</span>
                                    </div>
                                    <div class="category-progress">
                                        <?php
                                        $max_count = max(array_map(function($cat) { return $cat->count; }, $popular_categories));
                                        $percentage = $max_count > 0 ? ($category->count / $max_count) * 100 : 0;
                                        ?>
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: <?php echo $percentage; ?>%"></div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <p><?php _e('Категории не найдены.', 'bankz-finance'); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Quick Actions and Recent Activity -->
        <div class="bankz-dashboard-row">

            <!-- Quick Actions -->
            <div class="bankz-dashboard-widget">
                <div class="widget-header">
                    <h3>⚡ <?php _e('Быстрые действия', 'bankz-finance'); ?></h3>
                </div>
                <div class="widget-content">
                    <div class="quick-actions">
                        <a href="<?php echo admin_url('post-new.php'); ?>" class="quick-action">
                            <span class="action-icon">📝</span>
                            <span class="action-label"><?php _e('Новая статья', 'bankz-finance'); ?></span>
                        </a>
                        <a href="<?php echo admin_url('admin.php?page=bankz-slider'); ?>" class="quick-action">
                            <span class="action-icon">🎚️</span>
                            <span class="action-label"><?php _e('Настроить слайдер', 'bankz-finance'); ?></span>
                        </a>
                        <a href="<?php echo admin_url('admin.php?page=bankz-preloader'); ?>" class="quick-action">
                            <span class="action-icon">🎬</span>
                            <span class="action-label"><?php _e('Настроить прелоадер', 'bankz-finance'); ?></span>
                        </a>
                        <a href="<?php echo admin_url('admin.php?page=bankz-calculator'); ?>" class="quick-action">
                            <span class="action-icon">🧮</span>
                            <span class="action-label"><?php _e('Виджет калькулятора', 'bankz-finance'); ?></span>
                        </a>
                        <a href="<?php echo admin_url('widgets.php'); ?>" class="quick-action">
                            <span class="action-icon">🎛️</span>
                            <span class="action-label"><?php _e('Управление виджетами', 'bankz-finance'); ?></span>
                        </a>
                        <a href="<?php echo admin_url('admin.php?page=bankz-analytics'); ?>" class="quick-action">
                            <span class="action-icon">📊</span>
                            <span class="action-label"><?php _e('Подробная аналитика', 'bankz-finance'); ?></span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- System Status -->
            <div class="bankz-dashboard-widget">
                <div class="widget-header">
                    <h3>🔧 <?php _e('Статус системы', 'bankz-finance'); ?></h3>
                </div>
                <div class="widget-content">
                    <div class="system-status">
                        <div class="status-item">
                            <span class="status-label"><?php _e('Версия темы:', 'bankz-finance'); ?></span>
                            <span class="status-value"><?php echo BANKZ_THEME_VERSION; ?></span>
                            <span class="status-indicator success">✅</span>
                        </div>
                        <div class="status-item">
                            <span class="status-label"><?php _e('Прелоадер:', 'bankz-finance'); ?></span>
                            <span class="status-value">
                                <?php echo get_option('bankz_preloader_enabled', 1) ? __('Включен', 'bankz-finance') : __('Отключен', 'bankz-finance'); ?>
                            </span>
                            <span class="status-indicator <?php echo get_option('bankz_preloader_enabled', 1) ? 'success' : 'warning'; ?>">
                                <?php echo get_option('bankz_preloader_enabled', 1) ? '✅' : '⚠️'; ?>
                            </span>
                        </div>
                        <div class="status-item">
                            <span class="status-label"><?php _e('Аналитика:', 'bankz-finance'); ?></span>
                            <span class="status-value">
                                <?php echo get_option('bankz_enable_analytics', 1) ? __('Активна', 'bankz-finance') : __('Отключена', 'bankz-finance'); ?>
                            </span>
                            <span class="status-indicator <?php echo get_option('bankz_enable_analytics', 1) ? 'success' : 'warning'; ?>">
                                <?php echo get_option('bankz_enable_analytics', 1) ? '✅' : '⚠️'; ?>
                            </span>
                        </div>
                        <div class="status-item">
                            <span class="status-label"><?php _e('Калькулятор виджет:', 'bankz-finance'); ?></span>
                            <span class="status-value">
                                <?php
                                $calc_url = get_option('bankz_calc_widget_url', '#');
                                echo ($calc_url && $calc_url !== '#') ? __('Настроен', 'bankz-finance') : __('Требует настройки', 'bankz-finance');
                                ?>
                            </span>
                            <span class="status-indicator <?php echo ($calc_url && $calc_url !== '#') ? 'success' : 'warning'; ?>">
                                <?php echo ($calc_url && $calc_url !== '#') ? '✅' : '⚠️'; ?>
                            </span>
                        </div>
                    </div>

                    <div class="system-info">
                        <h4><?php _e('Информация о теме', 'bankz-finance'); ?></h4>
                        <p><strong><?php _e('Активная тема:', 'bankz-finance'); ?></strong> BankKz Finance</p>
                        <p><strong><?php _e('Версия WordPress:', 'bankz-finance'); ?></strong> <?php echo get_bloginfo('version'); ?></p>
                        <p><strong><?php _e('Всего постов:', 'bankz-finance'); ?></strong> <?php echo wp_count_posts()->publish; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Theme Documentation -->
        <div class="bankz-dashboard-widget bankz-full-width">
            <div class="widget-header">
                <h3>📚 <?php _e('Документация и поддержка', 'bankz-finance'); ?></h3>
            </div>
            <div class="widget-content">
                <div class="documentation-grid">
                    <div class="doc-item">
                        <h4>🚀 <?php _e('Начало работы', 'bankz-finance'); ?></h4>
                        <p><?php _e('Узнайте как настроить тему, создать первые статьи и настроить слайдер.', 'bankz-finance'); ?></p>
                    </div>
                    <div class="doc-item">
                        <h4>🎨 <?php _e('Настройка дизайна', 'bankz-finance'); ?></h4>
                        <p><?php _e('Кастомизируйте цвета, шрифты и расположение элементов под ваш бренд.', 'bankz-finance'); ?></p>
                    </div>
                    <div class="doc-item">
                        <h4>📊 <?php _e('Аналитика и метрики', 'bankz-finance'); ?></h4>
                        <p><?php _e('Отслеживайте просмотры, популярные статьи и поведение пользователей.', 'bankz-finance'); ?></p>
                    </div>
                    <div class="doc-item">
                        <h4>🔧 <?php _e('Расширенные настройки', 'bankz-finance'); ?></h4>
                        <p><?php _e('Настройте прелоадер, виджеты и интеграции с внешними сервисами.', 'bankz-finance'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    // Analytics period change
    $('#analytics-period').on('change', function() {
        var period = $(this).val();

        $.ajax({
            url: bankz_admin_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'bankz_get_analytics_data',
                period: period,
                nonce: bankz_admin_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    // Update chart with new data
                    updateAnalyticsChart(response.data);
                }
            }
        });
    });

    function updateAnalyticsChart(data) {
        // Chart update logic would go here
        console.log('Updating chart with data:', data);
    }
});
</script>