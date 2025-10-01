<?php
/**
 * BankKz Slider Settings Page
 *
 * @package BankKz_Finance
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// BASIC TEST - This should ALWAYS show if page loads
echo '<div style="background: yellow; padding: 10px; margin: 10px; border: 2px solid red;">
<h2>🚨 BASIC TEST: This page is loading!</h2>
<p>Current time: ' . date('Y-m-d H:i:s') . '</p>
<p>WordPress loaded: ' . (defined('ABSPATH') ? 'YES' : 'NO') . '</p>
<p>POST data: ' . print_r($_POST, true) . '</p>
</div>';

// DIRECT form processing for testing
if ($_POST && check_admin_referer('bankz_slider_settings')) {
    echo '<div class="notice notice-success"><p><strong>FORM SUBMITTED!</strong> Direct processing successful!</p></div>';

    if (isset($_POST['slider_source'])) {
        update_option('bankz_slider_source', sanitize_text_field($_POST['slider_source']));
        echo '<div class="notice notice-info"><p>Updated slider_source to: ' . $_POST['slider_source'] . '</p></div>';
    }

    if (isset($_POST['slider_categories'])) {
        update_option('bankz_slider_categories', array_map('intval', $_POST['slider_categories']));
        echo '<div class="notice notice-info"><p>Updated categories: ' . print_r($_POST['slider_categories'], true) . '</p></div>';
    }

    if (isset($_POST['slider_count'])) {
        update_option('bankz_slider_count', intval($_POST['slider_count']));
        echo '<div class="notice notice-info"><p>Updated count to: ' . $_POST['slider_count'] . '</p></div>';
    }

    if (isset($_POST['slider_autoplay'])) {
        update_option('bankz_slider_autoplay', 1);
        echo '<div class="notice notice-info"><p>Autoplay enabled</p></div>';
    } else {
        update_option('bankz_slider_autoplay', 0);
        echo '<div class="notice notice-info"><p>Autoplay disabled</p></div>';
    }

    if (isset($_POST['slider_interval'])) {
        update_option('bankz_slider_interval', intval($_POST['slider_interval']));
        echo '<div class="notice notice-info"><p>Updated interval to: ' . $_POST['slider_interval'] . '</p></div>';
    }
}

// Get current settings
$slider_source = get_option('bankz_slider_source', 'featured');
$slider_categories = get_option('bankz_slider_categories', array());
$slider_count = get_option('bankz_slider_count', 3);
$slider_autoplay = get_option('bankz_slider_autoplay', 1);
$slider_interval = get_option('bankz_slider_interval', 6000);

// Get available categories
$categories = get_categories(array('hide_empty' => false));

// Get featured posts count
$featured_posts_count = get_posts(array(
    'meta_key' => '_bankz_featured_slider',
    'meta_value' => '1',
    'posts_per_page' => -1,
    'fields' => 'ids'
));
$featured_count = count($featured_posts_count);
?>

<div class="wrap bankz-admin-page">
    <div class="bankz-admin-header">
        <h1>🎚️ Настройки слайдера</h1>
        <p class="description">Управляйте главным слайдером на домашней странице. Выберите источник контента, количество слайдов и настройки автопрокрутки.</p>
    </div>

    <div class="bankz-dashboard-content">
        <form method="post" action="">
            <?php wp_nonce_field('bankz_slider_settings'); ?>

            <!-- Slider Source Settings -->
            <div class="bankz-settings-section">
                <div class="section-header">
                    <h3>📝 Источник контента</h3>
                </div>
                <div class="section-content">
                    <div class="bankz-form-group">
                        <label><?php _e('Выберите источник статей для слайдера:', 'bankz-finance'); ?></label>
                        <div class="radio-options">
                            <label class="radio-option">
                                <input type="radio" name="slider_source" value="featured" <?php checked($slider_source, 'featured'); ?>>
                                <div class="radio-content">
                                    <strong>📌 Рекомендуемые статьи</strong>
                                    <p>Статьи, отмеченные как "Рекомендуемые в слайдере" в редакторе</p>
                                    <small class="stats"><?php printf(__('Текущее количество: %d статей', 'bankz-finance'), $featured_count); ?></small>
                                </div>
                            </label>

                            <label class="radio-option">
                                <input type="radio" name="slider_source" value="category" <?php checked($slider_source, 'category'); ?>>
                                <div class="radio-content">
                                    <strong>🏷️ По категориям</strong>
                                    <p>Последние статьи из выбранных категорий</p>
                                </div>
                            </label>

                            <label class="radio-option">
                                <input type="radio" name="slider_source" value="recent" <?php checked($slider_source, 'recent'); ?>>
                                <div class="radio-content">
                                    <strong>🆕 Последние статьи</strong>
                                    <p>Самые новые опубликованные статьи</p>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Categories Selection (shown when category source is selected) -->
            <div class="bankz-settings-section category-selection" style="<?php echo $slider_source !== 'category' ? 'display: none;' : ''; ?>">
                <div class="section-header">
                    <h3>🏷️ Выбор категорий</h3>
                </div>
                <div class="section-content">
                    <div class="bankz-form-group">
                        <label><?php _e('Выберите категории для слайдера:', 'bankz-finance'); ?></label>
                        <div class="categories-grid">
                            <?php foreach ($categories as $category) : ?>
                                <label class="category-checkbox">
                                    <input type="checkbox"
                                           name="slider_categories[]"
                                           value="<?php echo $category->term_id; ?>"
                                           <?php checked(in_array($category->term_id, $slider_categories)); ?>>
                                    <div class="checkbox-content">
                                        <strong><?php echo esc_html($category->name); ?></strong>
                                        <small><?php printf(__('%d статей', 'bankz-finance'), $category->count); ?></small>
                                    </div>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slider Behavior Settings -->
            <div class="bankz-settings-section">
                <div class="section-header">
                    <h3>⚙️ Настройки поведения</h3>
                </div>
                <div class="section-content">
                    <div class="settings-row">
                        <div class="bankz-form-group">
                            <label for="slider_count"><?php _e('Количество слайдов:', 'bankz-finance'); ?></label>
                            <input type="number"
                                   id="slider_count"
                                   name="slider_count"
                                   value="<?php echo esc_attr($slider_count); ?>"
                                   min="1"
                                   max="8"
                                   class="bankz-form-control small">
                            <small><?php _e('От 1 до 8 слайдов', 'bankz-finance'); ?></small>
                        </div>

                        <div class="bankz-form-group">
                            <label><?php _e('Автопрокрутка:', 'bankz-finance'); ?></label>
                            <div class="toggle-container">
                                <label class="bankz-toggle">
                                    <input type="checkbox" name="slider_autoplay" value="1" <?php checked($slider_autoplay, 1); ?>>
                                    <span class="bankz-toggle-slider"></span>
                                </label>
                                <span class="toggle-label"><?php _e('Включить автоматическую прокрутку', 'bankz-finance'); ?></span>
                            </div>
                        </div>

                        <div class="bankz-form-group" id="interval-setting" style="<?php echo !$slider_autoplay ? 'display: none;' : ''; ?>">
                            <label for="slider_interval"><?php _e('Интервал прокрутки (мс):', 'bankz-finance'); ?></label>
                            <input type="number"
                                   id="slider_interval"
                                   name="slider_interval"
                                   value="<?php echo esc_attr($slider_interval); ?>"
                                   min="2000"
                                   max="15000"
                                   step="500"
                                   class="bankz-form-control small">
                            <small><?php _e('От 2000мс (2 сек) до 15000мс (15 сек)', 'bankz-finance'); ?></small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Preview Section -->
            <div class="bankz-settings-section">
                <div class="section-header">
                    <h3>👁️ Предпросмотр слайдов</h3>
                </div>
                <div class="section-content">
                    <div id="slider-preview" class="slider-preview">
                        <div class="preview-loading">
                            <div class="loading-spinner"></div>
                            <p><?php _e('Загружаем предпросмотр...', 'bankz-finance'); ?></p>
                        </div>
                    </div>
                    <button type="button" id="refresh-preview" class="bankz-btn secondary">
                        🔄 <?php _e('Обновить предпросмотр', 'bankz-finance'); ?>
                    </button>
                </div>
            </div>

            <!-- Save Button -->
            <div class="form-actions">
                <button type="submit" name="submit" class="bankz-btn">
                    💾 <?php _e('Сохранить настройки', 'bankz-finance'); ?>
                </button>
                <button type="submit" name="submit_test" class="bankz-btn" style="background: red; margin-left: 10px;">
                    🧪 TEST SUBMIT
                </button>
                <a href="<?php echo admin_url('admin.php?page=bankz-settings'); ?>" class="bankz-btn secondary">
                    ← <?php _e('Вернуться к панели', 'bankz-finance'); ?>
                </a>
            </div>
        </form>
    </div>
</div>

<style>
/* Additional styles for slider settings */
.radio-options {
    display: flex;
    flex-direction: column;
    gap: 16px;
    margin-top: 12px;
}

.radio-option {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 16px;
    background: var(--bankz-cream);
    border-radius: 8px;
    border: 2px solid transparent;
    cursor: pointer;
    transition: all 0.3s ease;
}

.radio-option:hover {
    background: var(--bankz-cream-secondary);
    border-color: var(--bankz-primary);
}

.radio-option input[type="radio"] {
    margin: 0;
    margin-top: 2px;
}

.radio-option input[type="radio"]:checked + .radio-content {
    color: var(--bankz-primary);
}

.radio-content h4 {
    margin: 0 0 8px;
    font-size: 16px;
}

.radio-content p {
    margin: 0 0 8px;
    color: var(--bankz-text-light);
    font-size: 14px;
}

.radio-content .stats {
    color: var(--bankz-secondary);
    font-weight: 600;
}

.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 12px;
    margin-top: 12px;
}

.category-checkbox {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px;
    background: var(--bankz-cream);
    border-radius: 6px;
    border: 1px solid var(--bankz-border);
    cursor: pointer;
    transition: all 0.3s ease;
}

.category-checkbox:hover {
    background: var(--bankz-cream-secondary);
    border-color: var(--bankz-primary);
}

.category-checkbox input[type="checkbox"] {
    margin: 0;
}

.checkbox-content strong {
    display: block;
    color: var(--bankz-text);
}

.checkbox-content small {
    color: var(--bankz-text-light);
}

.settings-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 24px;
}

.bankz-form-control.small {
    width: 120px;
}

.toggle-container {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-top: 8px;
}

.toggle-label {
    color: var(--bankz-text);
    font-size: 14px;
}

.slider-preview {
    background: var(--bankz-cream);
    border-radius: 8px;
    padding: 24px;
    margin-bottom: 16px;
    min-height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.preview-loading {
    text-align: center;
    color: var(--bankz-text-light);
}

.loading-spinner {
    width: 32px;
    height: 32px;
    border: 3px solid var(--bankz-border);
    border-top: 3px solid var(--bankz-primary);
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto 12px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.preview-slides {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    width: 100%;
}

.preview-slide {
    background: linear-gradient(135deg, var(--bankz-primary), var(--bankz-secondary));
    color: white;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.preview-slide::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    pointer-events: none;
}

.preview-slide-content {
    position: relative;
    z-index: 2;
}

.preview-slide-category {
    font-size: 12px;
    opacity: 0.8;
    margin-bottom: 8px;
}

.preview-slide-title {
    font-size: 14px;
    font-weight: 600;
    margin: 0;
}

.form-actions {
    padding: 24px;
    background: var(--bankz-card-bg);
    border-radius: 8px;
    border: 1px solid var(--bankz-border);
    display: flex;
    gap: 16px;
    align-items: center;
}

@media (max-width: 768px) {
    .settings-row {
        grid-template-columns: 1fr;
    }

    .categories-grid {
        grid-template-columns: 1fr;
    }

    .form-actions {
        flex-direction: column;
        align-items: stretch;
    }
}
</style>

<script>
jQuery(document).ready(function($) {
    // Show/hide category selection based on source
    $('input[name="slider_source"]').on('change', function() {
        if ($(this).val() === 'category') {
            $('.category-selection').fadeIn();
        } else {
            $('.category-selection').fadeOut();
        }
        refreshPreview();
    });

    // Show/hide interval setting based on autoplay
    $('input[name="slider_autoplay"]').on('change', function() {
        if ($(this).is(':checked')) {
            $('#interval-setting').fadeIn();
        } else {
            $('#interval-setting').fadeOut();
        }
    });

    // Refresh preview on settings change
    $('input[name="slider_count"], input[name="slider_categories[]"]').on('change', function() {
        refreshPreview();
    });

    // Refresh preview button
    $('#refresh-preview').on('click', function() {
        refreshPreview();
    });

    // Function to refresh preview
    function refreshPreview() {
        var source = $('input[name="slider_source"]:checked').val();
        var categories = [];
        $('input[name="slider_categories[]"]:checked').each(function() {
            categories.push($(this).val());
        });
        var count = $('#slider_count').val();

        $('#slider-preview').html('<div class="preview-loading"><div class="loading-spinner"></div><p>Загружаем предпросмотр...</p></div>');

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'bankz_get_slider_preview',
                source: source,
                categories: categories,
                count: count,
                nonce: '<?php echo wp_create_nonce('bankz_slider_preview'); ?>'
            },
            success: function(response) {
                if (response.success) {
                    $('#slider-preview').html(response.data);
                } else {
                    $('#slider-preview').html('<div class="no-data"><p>Не удалось загрузить предпросмотр.</p></div>');
                }
            },
            error: function() {
                $('#slider-preview').html('<div class="no-data"><p>Ошибка загрузки предпросмотра.</p></div>');
            }
        });
    }

    // Initial preview load
    refreshPreview();
});
</script>