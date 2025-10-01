<?php
/**
 * BankKz Calculator Widget Settings Page
 *
 * @package BankKz_Finance
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Get current settings
$calc_widget_image = get_option('bankz_calc_widget_image', 'https://play-lh.googleusercontent.com/D3o9LNipiqxFL3YPtFMd_7lLeOWF2P6gzA0YKfYKj8S-krTEdttUS-GGyQHQ0_7xcGQ');
$calc_widget_url = get_option('bankz_calc_widget_url', '#');
$calc_widget_title = get_option('bankz_calc_widget_title', 'Кредитный калькулятор');
$calc_widget_description = get_option('bankz_calc_widget_description', 'Рассчитайте ежемесячный платеж по кредиту');
?>

<div class="wrap bankz-admin-page">
    <div class="bankz-admin-header">
        <h1>🧮 Настройки калькулятора</h1>
        <p class="description">Настройте виджет калькулятора в сайдбаре. Загрузите изображение, установите ссылку на страницу калькулятора и настройте текстовые элементы.</p>
    </div>

    <div class="bankz-dashboard-content">
        <form method="post" action="">
            <?php wp_nonce_field('bankz_calculator_settings'); ?>

            <!-- Calculator Image -->
            <div class="bankz-settings-section">
                <div class="section-header">
                    <h3>🖼️ Изображение калькулятора</h3>
                </div>
                <div class="section-content">
                    <div class="image-upload-section">
                        <div class="current-image">
                            <img id="calc-image-preview" src="<?php echo esc_url($calc_widget_image); ?>" alt="Calculator Image" style="max-width: 150px; height: 150px; object-fit: cover; border-radius: 50%;">
                        </div>
                        <div class="image-controls">
                            <div class="bankz-form-group">
                                <label for="calc_widget_image"><?php _e('URL изображения:', 'bankz-finance'); ?></label>
                                <input type="url"
                                       id="calc_widget_image"
                                       name="calc_widget_image"
                                       value="<?php echo esc_url($calc_widget_image); ?>"
                                       class="bankz-form-control"
                                       placeholder="https://example.com/calculator-icon.png">
                            </div>
                            <div class="upload-buttons">
                                <button type="button" id="upload-calc-image" class="bankz-btn">
                                    📁 <?php _e('Выбрать изображение', 'bankz-finance'); ?>
                                </button>
                                <button type="button" id="remove-calc-image" class="bankz-btn secondary">
                                    🗑️ <?php _e('Удалить', 'bankz-finance'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                    <p class="image-requirements">
                        <strong><?php _e('Рекомендации:', 'bankz-finance'); ?></strong> <?php _e('Квадратное изображение размером минимум 150x150px. Лучше всего подходят иконки калькуляторов или финансовые символы.', 'bankz-finance'); ?>
                    </p>
                </div>
            </div>

            <!-- Calculator Link -->
            <div class="bankz-settings-section">
                <div class="section-header">
                    <h3>🔗 Ссылка на калькулятор</h3>
                </div>
                <div class="section-content">
                    <div class="bankz-form-group">
                        <label for="calc_widget_url"><?php _e('URL страницы калькулятора:', 'bankz-finance'); ?></label>
                        <input type="url"
                               id="calc_widget_url"
                               name="calc_widget_url"
                               value="<?php echo esc_url($calc_widget_url); ?>"
                               class="bankz-form-control"
                               placeholder="https://yoursite.com/calculator">
                        <small><?php _e('Введите полный URL страницы с калькулятором. При клике на кнопку виджета пользователь попадет на эту страницу.', 'bankz-finance'); ?></small>
                    </div>

                    <div class="url-suggestions">
                        <div class="suggestion-title"><?php _e('Популярные варианты:', 'bankz-finance'); ?></div>
                        <div class="suggestions-list">
                            <button type="button" class="url-suggestion" data-url="/calculator">
                                📊 <?php _e('Внутренняя страница: /calculator', 'bankz-finance'); ?>
                            </button>
                            <button type="button" class="url-suggestion" data-url="/loan-calculator">
                                🏠 <?php _e('Кредитный калькулятор: /loan-calculator', 'bankz-finance'); ?>
                            </button>
                            <button type="button" class="url-suggestion" data-url="#calculator-modal">
                                💬 <?php _e('Модальное окно: #calculator-modal', 'bankz-finance'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Text Settings -->
            <div class="bankz-settings-section">
                <div class="section-header">
                    <h3>✏️ Текстовое содержание</h3>
                </div>
                <div class="section-content">
                    <div class="settings-row">
                        <div class="bankz-form-group">
                            <label for="calc_widget_title"><?php _e('Заголовок виджета:', 'bankz-finance'); ?></label>
                            <input type="text"
                                   id="calc_widget_title"
                                   name="calc_widget_title"
                                   value="<?php echo esc_attr($calc_widget_title); ?>"
                                   class="bankz-form-control"
                                   placeholder="Кредитный калькулятор">
                            <small><?php _e('Основной заголовок, отображаемый в виджете', 'bankz-finance'); ?></small>
                        </div>

                        <div class="bankz-form-group">
                            <label for="calc_widget_description"><?php _e('Описание:', 'bankz-finance'); ?></label>
                            <textarea id="calc_widget_description"
                                      name="calc_widget_description"
                                      class="bankz-form-control"
                                      rows="3"
                                      placeholder="Рассчитайте ежемесячный платеж по кредиту"><?php echo esc_textarea($calc_widget_description); ?></textarea>
                            <small><?php _e('Краткое описание функции калькулятора', 'bankz-finance'); ?></small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Widget Preview -->
            <div class="bankz-settings-section">
                <div class="section-header">
                    <h3>👁️ Предпросмотр виджета</h3>
                </div>
                <div class="section-content">
                    <div class="widget-preview">
                        <div class="preview-calculator-widget">
                            <div class="preview-widget-body">
                                <div class="preview-calc-logo">
                                    <img id="preview-calc-image" src="<?php echo esc_url($calc_widget_image); ?>" alt="Calculator Logo" class="preview-calc-logo-img">
                                </div>
                                <h3 id="preview-calc-title" class="preview-widget-title"><?php echo esc_html($calc_widget_title); ?></h3>
                                <p id="preview-calc-description"><?php echo esc_html($calc_widget_description); ?></p>
                                <button class="preview-calc-button">
                                    <?php _e('Открыть калькулятор', 'bankz-finance'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                    <p class="preview-note">
                        <strong><?php _e('Примечание:', 'bankz-finance'); ?></strong> <?php _e('Это предпросмотр того, как виджет будет выглядеть в боковой панели сайта.', 'bankz-finance'); ?>
                    </p>
                </div>
            </div>

            <!-- Advanced Settings -->
            <div class="bankz-settings-section">
                <div class="section-header">
                    <h3>⚙️ Дополнительные настройки</h3>
                </div>
                <div class="section-content">
                    <div class="advanced-options">
                        <div class="option-group">
                            <h4><?php _e('Поведение ссылки:', 'bankz-finance'); ?></h4>
                            <label class="checkbox-option">
                                <input type="checkbox" name="calc_widget_new_tab" value="1" <?php checked(get_option('bankz_calc_widget_new_tab'), 1); ?>>
                                <span><?php _e('Открывать калькулятор в новой вкладке', 'bankz-finance'); ?></span>
                            </label>
                        </div>

                        <div class="option-group">
                            <h4><?php _e('Дополнительный CSS класс:', 'bankz-finance'); ?></h4>
                            <input type="text"
                                   name="calc_widget_css_class"
                                   value="<?php echo esc_attr(get_option('bankz_calc_widget_css_class', '')); ?>"
                                   class="bankz-form-control"
                                   placeholder="custom-calculator-style">
                            <small><?php _e('Добавьте CSS класс для дополнительной стилизации', 'bankz-finance'); ?></small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="form-actions">
                <button type="submit" name="submit" class="bankz-btn">
                    💾 <?php _e('Сохранить настройки', 'bankz-finance'); ?>
                </button>
                <a href="<?php echo admin_url('admin.php?page=bankz-settings'); ?>" class="bankz-btn secondary">
                    ← <?php _e('Вернуться к панели', 'bankz-finance'); ?>
                </a>
                <a href="<?php echo admin_url('widgets.php'); ?>" class="bankz-btn secondary">
                    🎛️ <?php _e('Управление виджетами', 'bankz-finance'); ?>
                </a>
            </div>
        </form>
    </div>
</div>

<style>
/* Calculator Settings Styles */
.image-upload-section {
    display: flex;
    gap: 24px;
    align-items: flex-start;
    margin-bottom: 16px;
}

.current-image {
    flex-shrink: 0;
}

.current-image img {
    border: 2px solid var(--bankz-border);
    box-shadow: var(--shadow-sm);
}

.image-controls {
    flex: 1;
}

.upload-buttons {
    display: flex;
    gap: 12px;
    margin-top: 12px;
}

.image-requirements {
    background: var(--bankz-cream);
    padding: 12px;
    border-radius: 6px;
    border-left: 4px solid var(--bankz-primary);
    margin: 0;
    font-size: 14px;
    color: var(--bankz-text-light);
}

.url-suggestions {
    margin-top: 16px;
    padding: 16px;
    background: var(--bankz-cream);
    border-radius: 8px;
    border: 1px solid var(--bankz-border);
}

.suggestion-title {
    font-weight: 600;
    color: var(--bankz-text);
    margin-bottom: 12px;
}

.suggestions-list {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.url-suggestion {
    text-align: left;
    padding: 8px 12px;
    background: white;
    border: 1px solid var(--bankz-border);
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.3s ease;
}

.url-suggestion:hover {
    background: var(--bankz-cream-secondary);
    border-color: var(--bankz-primary);
}

/* Widget Preview */
.widget-preview {
    display: flex;
    justify-content: center;
    margin-bottom: 16px;
}

.preview-calculator-widget {
    background: linear-gradient(135deg, var(--bankz-primary), var(--bankz-secondary));
    color: white;
    text-align: center;
    position: relative;
    overflow: hidden;
    border-radius: 12px;
    width: 300px;
    box-shadow: var(--shadow-lg);
}

.preview-calculator-widget::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    pointer-events: none;
}

.preview-widget-body {
    padding: 24px;
    position: relative;
    z-index: 2;
}

.preview-calc-logo {
    margin-bottom: 16px;
    display: flex;
    justify-content: center;
    position: relative;
    z-index: 2;
}

.preview-calc-logo-img {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.9);
    padding: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.preview-widget-title {
    color: white;
    position: relative;
    z-index: 2;
    font-size: 18px;
    margin: 0 0 12px;
}

.preview-calculator-widget p {
    position: relative;
    z-index: 2;
    opacity: 0.9;
    margin-bottom: 20px;
    font-size: 14px;
}

.preview-calc-button {
    background: var(--bankz-cream);
    color: var(--bankz-primary);
    border: none;
    padding: 12px 20px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    width: 100%;
    transition: all 0.3s ease;
    font-size: 14px;
    position: relative;
    z-index: 2;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.preview-calc-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
    background: var(--bankz-cream-secondary);
}

.preview-note {
    text-align: center;
    color: var(--bankz-text-light);
    font-style: italic;
    margin: 0;
}

.advanced-options {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 24px;
}

.option-group h4 {
    color: var(--bankz-primary);
    margin-bottom: 12px;
    font-size: 16px;
}

.checkbox-option {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
}

.checkbox-option input[type="checkbox"] {
    margin: 0;
}

@media (max-width: 768px) {
    .image-upload-section {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .upload-buttons {
        flex-direction: column;
    }

    .suggestions-list {
        display: grid;
        grid-template-columns: 1fr;
        gap: 8px;
    }

    .advanced-options {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
jQuery(document).ready(function($) {
    var mediaUploader;

    // Upload image button
    $('#upload-calc-image').on('click', function(e) {
        e.preventDefault();

        if (mediaUploader) {
            mediaUploader.open();
            return;
        }

        mediaUploader = wp.media({
            title: 'Выберите изображение для калькулятора',
            button: {
                text: 'Выбрать изображение'
            },
            multiple: false
        });

        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#calc_widget_image').val(attachment.url);
            updateImagePreview(attachment.url);
        });

        mediaUploader.open();
    });

    // Remove image button
    $('#remove-calc-image').on('click', function() {
        var defaultImage = 'https://play-lh.googleusercontent.com/D3o9LNipiqxFL3YPtFMd_7lLeOWF2P6gzA0YKfYKj8S-krTEdttUS-GGyQHQ0_7xcGQ';
        $('#calc_widget_image').val(defaultImage);
        updateImagePreview(defaultImage);
    });

    // URL suggestions
    $('.url-suggestion').on('click', function() {
        var url = $(this).data('url');
        var currentSite = window.location.origin;
        var fullUrl = url.startsWith('/') ? currentSite + url : url;
        $('#calc_widget_url').val(fullUrl);
    });

    // Update preview on input change
    $('#calc_widget_image').on('input', function() {
        updateImagePreview($(this).val());
    });

    $('#calc_widget_title').on('input', function() {
        $('#preview-calc-title').text($(this).val());
    });

    $('#calc_widget_description').on('input', function() {
        $('#preview-calc-description').text($(this).val());
    });

    // Function to update image preview
    function updateImagePreview(url) {
        if (url) {
            $('#calc-image-preview, #preview-calc-image').attr('src', url);
        }
    }

    // Validate URL on blur
    $('#calc_widget_url').on('blur', function() {
        var url = $(this).val();
        if (url && !isValidUrl(url) && !url.startsWith('/') && !url.startsWith('#')) {
            $(this).css('border-color', '#dc3232');
            if (!$('.url-error').length) {
                $(this).after('<small class="url-error" style="color: #dc3232;">Пожалуйста, введите корректный URL</small>');
            }
        } else {
            $(this).css('border-color', '');
            $('.url-error').remove();
        }
    });

    function isValidUrl(string) {
        try {
            new URL(string);
            return true;
        } catch (_) {
            return false;
        }
    }
});
</script>