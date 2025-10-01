<?php
/**
 * BankKz Analytics Page
 *
 * @package BankKz_Finance
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Get analytics data
global $wpdb;

$total_posts = wp_count_posts()->publish;
$total_pages = wp_count_posts('page')->publish;
$total_comments = wp_count_comments()->approved;

// Get analytics from custom table
$table_name = $wpdb->prefix . 'bankz_analytics';
$analytics_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name;

$today_views = 0;
$week_views = 0;
$month_views = 0;
$total_analytics_views = 0;

if ($analytics_exists) {
    $today_views = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE DATE(visit_date) = CURDATE()");
    $week_views = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE visit_date >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
    $month_views = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE visit_date >= DATE_SUB(NOW(), INTERVAL 30 DAY)");
    $total_analytics_views = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
}

// Get top posts by views
$top_posts = $wpdb->get_results("
    SELECT p.ID, p.post_title,
           COALESCE(m1.meta_value, 0) + COALESCE(m2.meta_value, 0) as total_views
    FROM {$wpdb->posts} p
    LEFT JOIN {$wpdb->postmeta} m1 ON (p.ID = m1.post_id AND m1.meta_key = '_bankz_manual_views')
    LEFT JOIN {$wpdb->postmeta} m2 ON (p.ID = m2.post_id AND m2.meta_key = '_bankz_auto_views')
    WHERE p.post_status = 'publish' AND p.post_type = 'post'
    ORDER BY total_views DESC
    LIMIT 10
");

// Get popular categories
$popular_categories = $wpdb->get_results("
    SELECT t.name, t.slug, tt.count, tt.term_taxonomy_id
    FROM {$wpdb->terms} t
    INNER JOIN {$wpdb->term_taxonomy} tt ON t.term_id = tt.term_id
    WHERE tt.taxonomy = 'category' AND tt.count > 0
    ORDER BY tt.count DESC
    LIMIT 8
");
?>

<div class="wrap bankz-admin-page">
    <div class="bankz-admin-header">
        <h1>📈 Детальная аналитика</h1>
        <p class="description">Подробная статистика посещений, популярности контента и поведения пользователей на вашем финансовом блоге.</p>
    </div>

    <div class="bankz-dashboard-content">

        <!-- Analytics Overview -->
        <div class="bankz-stats-grid">
            <div class="bankz-stat-card">
                <div class="stat-icon">👁️</div>
                <div class="stat-content">
                    <div class="stat-number"><?php echo number_format($today_views); ?></div>
                    <div class="stat-label"><?php _e('Просмотры сегодня', 'bankz-finance'); ?></div>
                </div>
            </div>

            <div class="bankz-stat-card">
                <div class="stat-icon">📅</div>
                <div class="stat-content">
                    <div class="stat-number"><?php echo number_format($week_views); ?></div>
                    <div class="stat-label"><?php _e('Просмотры за неделю', 'bankz-finance'); ?></div>
                </div>
            </div>

            <div class="bankz-stat-card">
                <div class="stat-icon">📊</div>
                <div class="stat-content">
                    <div class="stat-number"><?php echo number_format($month_views); ?></div>
                    <div class="stat-label"><?php _e('Просмотры за месяц', 'bankz-finance'); ?></div>
                </div>
            </div>

            <div class="bankz-stat-card">
                <div class="stat-icon">🎯</div>
                <div class="stat-content">
                    <div class="stat-number"><?php echo number_format($total_analytics_views); ?></div>
                    <div class="stat-label"><?php _e('Всего просмотров', 'bankz-finance'); ?></div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="bankz-dashboard-row">
            <!-- Traffic Chart -->
            <div class="bankz-dashboard-widget bankz-chart-widget">
                <div class="widget-header">
                    <h3>📈 <?php _e('Динамика трафика', 'bankz-finance'); ?></h3>
                    <div class="widget-actions">
                        <select id="traffic-period">
                            <option value="7"><?php _e('7 дней', 'bankz-finance'); ?></option>
                            <option value="30"><?php _e('30 дней', 'bankz-finance'); ?></option>
                            <option value="90"><?php _e('90 дней', 'bankz-finance'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="widget-content">
                    <div id="traffic-chart" class="bankz-chart">
                        <?php if ($analytics_exists) : ?>
                            <div class="chart-placeholder">
                                <p><?php _e('График загружается...', 'bankz-finance'); ?></p>
                            </div>
                        <?php else : ?>
                            <div class="no-data">
                                <p><?php _e('Таблица аналитики не создана. Данные будут отображаться после активации отслеживания.', 'bankz-finance'); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Content Performance -->
            <div class="bankz-dashboard-widget">
                <div class="widget-header">
                    <h3>🏆 <?php _e('Эффективность контента', 'bankz-finance'); ?></h3>
                </div>
                <div class="widget-content">
                    <div class="content-stats">
                        <div class="content-stat-item">
                            <div class="stat-label"><?php _e('Всего статей:', 'bankz-finance'); ?></div>
                            <div class="stat-value"><?php echo $total_posts; ?></div>
                        </div>
                        <div class="content-stat-item">
                            <div class="stat-label"><?php _e('Всего страниц:', 'bankz-finance'); ?></div>
                            <div class="stat-value"><?php echo $total_pages; ?></div>
                        </div>
                        <div class="content-stat-item">
                            <div class="stat-label"><?php _e('Комментариев:', 'bankz-finance'); ?></div>
                            <div class="stat-value"><?php echo $total_comments; ?></div>
                        </div>
                        <div class="content-stat-item">
                            <div class="stat-label"><?php _e('Средние просмотры:', 'bankz-finance'); ?></div>
                            <div class="stat-value">
                                <?php echo $total_posts > 0 ? number_format($total_analytics_views / $total_posts) : '0'; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Content Row -->
        <div class="bankz-dashboard-row">
            <!-- Top Posts -->
            <div class="bankz-dashboard-widget">
                <div class="widget-header">
                    <h3>🔥 <?php _e('Популярные статьи', 'bankz-finance'); ?></h3>
                </div>
                <div class="widget-content">
                    <?php if (!empty($top_posts)) : ?>
                        <div class="top-posts-list">
                            <?php foreach ($top_posts as $index => $post) : ?>
                                <div class="top-post-item">
                                    <div class="post-rank">#<?php echo $index + 1; ?></div>
                                    <div class="post-info">
                                        <h4 class="post-title">
                                            <a href="<?php echo get_edit_post_link($post->ID); ?>">
                                                <?php echo esc_html($post->post_title); ?>
                                            </a>
                                        </h4>
                                        <div class="post-stats">
                                            <span class="post-views"><?php echo number_format($post->total_views); ?> просмотров</span>
                                            <a href="<?php echo get_permalink($post->ID); ?>" target="_blank">Посмотреть →</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <div class="no-data">
                            <p><?php _e('Данные о популярных статьях пока отсутствуют.', 'bankz-finance'); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Categories Performance -->
            <div class="bankz-dashboard-widget">
                <div class="widget-header">
                    <h3>🏷️ <?php _e('Эффективность категорий', 'bankz-finance'); ?></h3>
                </div>
                <div class="widget-content">
                    <?php if (!empty($popular_categories)) : ?>
                        <div class="categories-performance">
                            <?php foreach ($popular_categories as $category) : ?>
                                <div class="category-performance-item">
                                    <div class="category-info">
                                        <h4 class="category-name">
                                            <a href="<?php echo get_category_link($category->term_taxonomy_id); ?>" target="_blank">
                                                <?php echo esc_html($category->name); ?>
                                            </a>
                                        </h4>
                                        <div class="category-stats">
                                            <span class="post-count"><?php echo $category->count; ?> статей</span>
                                            <a href="<?php echo admin_url('edit.php?category_name=' . $category->slug); ?>">Управлять →</a>
                                        </div>
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
                        <div class="no-data">
                            <p><?php _e('Категории не найдены.', 'bankz-finance'); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Export and Actions -->
        <div class="bankz-dashboard-widget bankz-full-width">
            <div class="widget-header">
                <h3>📤 <?php _e('Экспорт и действия', 'bankz-finance'); ?></h3>
            </div>
            <div class="widget-content">
                <div class="export-actions">
                    <div class="action-group">
                        <h4><?php _e('Экспорт данных', 'bankz-finance'); ?></h4>
                        <p><?php _e('Скачать аналитические данные в различных форматах', 'bankz-finance'); ?></p>
                        <div class="action-buttons">
                            <button class="bankz-btn" id="export-csv">📄 <?php _e('Экспорт CSV', 'bankz-finance'); ?></button>
                            <button class="bankz-btn secondary" id="export-json">📋 <?php _e('Экспорт JSON', 'bankz-finance'); ?></button>
                        </div>
                    </div>

                    <div class="action-group">
                        <h4><?php _e('Управление данными', 'bankz-finance'); ?></h4>
                        <p><?php _e('Очистка и управление аналитическими данными', 'bankz-finance'); ?></p>
                        <div class="action-buttons">
                            <button class="bankz-btn secondary" id="clear-old-data">🗑️ <?php _e('Очистить старые данные', 'bankz-finance'); ?></button>
                            <button class="bankz-btn secondary confirm-action" data-confirm="Вы уверены, что хотите сбросить всю аналитику?" id="reset-analytics">
                                ⚠️ <?php _e('Сбросить аналитику', 'bankz-finance'); ?>
                            </button>
                        </div>
                    </div>

                    <div class="action-group">
                        <h4><?php _e('Настройки отслеживания', 'bankz-finance'); ?></h4>
                        <p><?php _e('Управление системой аналитики', 'bankz-finance'); ?></p>
                        <div class="action-buttons">
                            <a href="<?php echo admin_url('admin.php?page=bankz-general'); ?>" class="bankz-btn">
                                ⚙️ <?php _e('Настройки аналитики', 'bankz-finance'); ?>
                            </a>
                            <button class="bankz-btn secondary" id="rebuild-analytics">
                                🔄 <?php _e('Пересчитать данные', 'bankz-finance'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.content-stats {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
}

.content-stat-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px;
    background: var(--bankz-cream);
    border-radius: 6px;
}

.stat-label {
    color: var(--bankz-text-light);
    font-size: 14px;
}

.stat-value {
    color: var(--bankz-primary);
    font-weight: 600;
    font-size: 16px;
}

.top-posts-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.top-post-item {
    display: flex;
    gap: 12px;
    padding: 12px;
    background: var(--bankz-cream);
    border-radius: 8px;
    border-left: 4px solid var(--bankz-primary);
}

.post-rank {
    font-size: 18px;
    font-weight: bold;
    color: var(--bankz-primary);
    min-width: 30px;
}

.post-info {
    flex: 1;
}

.post-title {
    margin: 0 0 8px;
    font-size: 14px;
}

.post-title a {
    color: var(--bankz-text);
    text-decoration: none;
}

.post-title a:hover {
    color: var(--bankz-primary);
}

.post-stats {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 12px;
}

.post-views {
    color: var(--bankz-text-light);
}

.categories-performance {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.category-performance-item {
    background: var(--bankz-cream);
    padding: 12px;
    border-radius: 8px;
}

.category-name {
    margin: 0 0 8px;
    font-size: 14px;
}

.category-name a {
    color: var(--bankz-text);
    text-decoration: none;
}

.category-stats {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
    font-size: 12px;
}

.export-actions {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 24px;
}

.action-group h4 {
    color: var(--bankz-primary);
    margin-bottom: 8px;
}

.action-group p {
    color: var(--bankz-text-light);
    font-size: 14px;
    margin-bottom: 16px;
}

.action-buttons {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

@media (max-width: 768px) {
    .content-stats {
        grid-template-columns: 1fr;
    }

    .post-stats {
        flex-direction: column;
        align-items: flex-start;
        gap: 4px;
    }

    .action-buttons {
        flex-direction: column;
    }
}
</style>

<script>
jQuery(document).ready(function($) {
    // Traffic chart period change
    $('#traffic-period').on('change', function() {
        var period = $(this).val();
        // Load traffic data for selected period
        loadTrafficChart(period);
    });

    function loadTrafficChart(period) {
        $.ajax({
            url: bankz_admin_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'bankz_get_traffic_data',
                period: period,
                nonce: bankz_admin_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    renderTrafficChart(response.data);
                }
            }
        });
    }

    // Export functions
    $('#export-csv').on('click', function() {
        window.location.href = '<?php echo admin_url('admin-ajax.php?action=bankz_export_analytics&format=csv&nonce=' . wp_create_nonce('bankz_export')); ?>';
    });

    $('#export-json').on('click', function() {
        window.location.href = '<?php echo admin_url('admin-ajax.php?action=bankz_export_analytics&format=json&nonce=' . wp_create_nonce('bankz_export')); ?>';
    });

    // Data management
    $('#clear-old-data').on('click', function() {
        if (confirm('Удалить данные старше 90 дней?')) {
            // Clear old analytics data
            $.post(bankz_admin_ajax.ajax_url, {
                action: 'bankz_clear_old_data',
                nonce: bankz_admin_ajax.nonce
            }, function(response) {
                if (response.success) {
                    location.reload();
                }
            });
        }
    });

    $('#rebuild-analytics').on('click', function() {
        $(this).prop('disabled', true).text('Пересчитываем...');

        $.post(bankz_admin_ajax.ajax_url, {
            action: 'bankz_rebuild_analytics',
            nonce: bankz_admin_ajax.nonce
        }, function(response) {
            location.reload();
        });
    });
});
</script>