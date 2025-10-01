<?php
/**
 * BankKz General Settings Page
 *
 * @package BankKz_Finance
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Form processing is handled in the admin panel class

// Get current settings
$footer_tagline = get_option('bankz_footer_tagline', 'Финансовые советы и новости Казахстана');
$enable_analytics = get_option('bankz_enable_analytics', 1);
$enable_view_tracking = get_option('bankz_enable_view_tracking', 1);
$google_analytics_id = get_option('bankz_google_analytics_id', '');
$enable_comments = get_option('bankz_enable_comments', 1);
$posts_per_page = get_option('bankz_posts_per_page', 6);
$excerpt_length = get_option('bankz_excerpt_length', 25);
?>

<div class="wrap bankz-admin-page">
    <div class="bankz-admin-header">
        <h1>⚙️ Общие настройки</h1>
        <p class="description">Основные настройки темы BankKz Finance. Управляйте аналитикой, внешним видом и функциональностью вашего финансового блога.</p>
    </div>

    <div class="bankz-dashboard-content">
        <form method="post" action="">
            <?php wp_nonce_field('bankz_general_settings'); ?>

            <!-- Site Information -->
            <div class="bankz-settings-section">
                <div class="section-header">
                    <h3>🏠 Информация о сайте</h3>
                </div>
                <div class="section-content">
                    <div class="settings-row">
                        <div class="bankz-form-group">
                            <label for="footer_tagline"><?php _e('Слоган в подвале:', 'bankz-finance'); ?></label>
                            <input type="text"
                                   id="footer_tagline"
                                   name="footer_tagline"
                                   value="<?php echo esc_attr($footer_tagline); ?>"
                                   class="bankz-form-control"
                                   placeholder="Финансовые советы и новости Казахстана">
                            <small><?php _e('Отображается в нижней части всех страниц сайта', 'bankz-finance'); ?></small>
                        </div>

                        <div class="bankz-form-group">
                            <label for="posts_per_page"><?php _e('Статей на странице:', 'bankz-finance'); ?></label>
                            <input type="number"
                                   id="posts_per_page"
                                   name="posts_per_page"
                                   value="<?php echo esc_attr($posts_per_page); ?>"
                                   class="bankz-form-control small"
                                   min="1"
                                   max="20">
                            <small><?php _e('Количество статей в сетке на главной странице', 'bankz-finance'); ?></small>
                        </div>
                    </div>

                    <div class="bankz-form-group">
                        <label for="excerpt_length"><?php _e('Длина отрывка статьи:', 'bankz-finance'); ?></label>
                        <input type="number"
                               id="excerpt_length"
                               name="excerpt_length"
                               value="<?php echo esc_attr($excerpt_length); ?>"
                               class="bankz-form-control small"
                               min="10"
                               max="100">
                        <small><?php _e('Количество слов в превью статьи (от 10 до 100)', 'bankz-finance'); ?></small>
                    </div>
                </div>
            </div>

            <!-- Analytics Settings -->
            <div class="bankz-settings-section">
                <div class="section-header">
                    <h3>📊 Настройки аналитики</h3>
                </div>
                <div class="section-content">
                    <div class="analytics-toggles">
                        <div class="toggle-group">
                            <label class="bankz-toggle">
                                <input type="checkbox" name="enable_analytics" value="1" <?php checked($enable_analytics, 1); ?>>
                                <span class="bankz-toggle-slider"></span>
                            </label>
                            <div class="toggle-info">
                                <span class="toggle-label"><?php _e('Включить внутреннюю аналитику', 'bankz-finance'); ?></span>
                                <p class="toggle-description"><?php _e('Собирает данные о посещениях и популярности контента', 'bankz-finance'); ?></p>
                            </div>
                        </div>

                        <div class="toggle-group">
                            <label class="bankz-toggle">
                                <input type="checkbox" name="enable_view_tracking" value="1" <?php checked($enable_view_tracking, 1); ?>>
                                <span class="bankz-toggle-slider"></span>
                            </label>
                            <div class="toggle-info">
                                <span class="toggle-label"><?php _e('Отслеживание просмотров статей', 'bankz-finance'); ?></span>
                                <p class="toggle-description"><?php _e('Автоматически подсчитывает количество просмотров каждой статьи', 'bankz-finance'); ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="bankz-form-group">
                        <label for="google_analytics_id"><?php _e('Google Analytics ID:', 'bankz-finance'); ?></label>
                        <input type="text"
                               id="google_analytics_id"
                               name="google_analytics_id"
                               value="<?php echo esc_attr($google_analytics_id); ?>"
                               class="bankz-form-control"
                               placeholder="G-XXXXXXXXXX или UA-XXXXXXXX-X">
                        <small><?php _e('Введите ваш Google Analytics Measurement ID или Universal Analytics ID', 'bankz-finance'); ?></small>
                    </div>
                </div>
            </div>

            <!-- Content Settings -->
            <div class="bankz-settings-section">
                <div class="section-header">
                    <h3>📝 Настройки контента</h3>
                </div>
                <div class="section-content">
                    <div class="content-toggles">
                        <div class="toggle-group">
                            <label class="bankz-toggle">
                                <input type="checkbox" name="enable_comments" value="1" <?php checked($enable_comments, 1); ?>>
                                <span class="bankz-toggle-slider"></span>
                            </label>
                            <div class="toggle-info">
                                <span class="toggle-label"><?php _e('Включить комментарии', 'bankz-finance'); ?></span>
                                <p class="toggle-description"><?php _e('Позволяет пользователям комментировать статьи', 'bankz-finance'); ?></p>
                            </div>
                        </div>

                        <div class="toggle-group">
                            <label class="bankz-toggle">
                                <input type="checkbox" name="enable_social_sharing" value="1" <?php checked(get_option('bankz_enable_social_sharing', 1), 1); ?>>
                                <span class="bankz-toggle-slider"></span>
                            </label>
                            <div class="toggle-info">
                                <span class="toggle-label"><?php _e('Кнопки социальных сетей', 'bankz-finance'); ?></span>
                                <p class="toggle-description"><?php _e('Отображает кнопки "Поделиться" в статьях', 'bankz-finance'); ?></p>
                            </div>
                        </div>

                        <div class="toggle-group">
                            <label class="bankz-toggle">
                                <input type="checkbox" name="enable_related_posts" value="1" <?php checked(get_option('bankz_enable_related_posts', 1), 1); ?>>
                                <span class="bankz-toggle-slider"></span>
                            </label>
                            <div class="toggle-info">
                                <span class="toggle-label"><?php _e('Похожие статьи', 'bankz-finance'); ?></span>
                                <p class="toggle-description"><?php _e('Показывает связанные статьи в конце каждой публикации', 'bankz-finance'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Settings -->
            <div class="bankz-settings-section">
                <div class="section-header">
                    <h3>⚡ Настройки производительности</h3>
                </div>
                <div class="section-content">
                    <div class="performance-options">
                        <div class="toggle-group">
                            <label class="bankz-toggle">
                                <input type="checkbox" name="enable_lazy_loading" value="1" <?php checked(get_option('bankz_enable_lazy_loading', 1), 1); ?>>
                                <span class="bankz-toggle-slider"></span>
                            </label>
                            <div class="toggle-info">
                                <span class="toggle-label"><?php _e('Ленивая загрузка изображений', 'bankz-finance'); ?></span>
                                <p class="toggle-description"><?php _e('Изображения загружаются только при просмотре', 'bankz-finance'); ?></p>
                            </div>
                        </div>

                        <div class="toggle-group">
                            <label class="bankz-toggle">
                                <input type="checkbox" name="minify_css_js" value="1" <?php checked(get_option('bankz_minify_css_js', 0), 1); ?>>
                                <span class="bankz-toggle-slider"></span>
                            </label>
                            <div class="toggle-info">
                                <span class="toggle-label"><?php _e('Минификация CSS и JS', 'bankz-finance'); ?></span>
                                <p class="toggle-description"><?php _e('Сжимает файлы стилей и скриптов для быстрой загрузки', 'bankz-finance'); ?></p>
                            </div>
                        </div>

                        <div class="toggle-group">
                            <label class="bankz-toggle">
                                <input type="checkbox" name="enable_caching" value="1" <?php checked(get_option('bankz_enable_caching', 0), 1); ?>>
                                <span class="bankz-toggle-slider"></span>
                            </label>
                            <div class="toggle-info">
                                <span class="toggle-label"><?php _e('Кеширование страниц', 'bankz-finance'); ?></span>
                                <p class="toggle-description"><?php _e('Сохраняет готовые страницы для быстрого отображения', 'bankz-finance'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEO Settings -->
            <div class="bankz-settings-section">
                <div class="section-header">
                    <h3>🔍 SEO настройки</h3>
                </div>
                <div class="section-content">
                    <div class="seo-options">
                        <div class="bankz-form-group">
                            <label for="meta_description"><?php _e('Мета-описание сайта:', 'bankz-finance'); ?></label>
                            <textarea id="meta_description"
                                      name="meta_description"
                                      class="bankz-form-control"
                                      rows="3"
                                      placeholder="Профессиональный финансовый блог с советами по банкингу, инвестициям и экономике Казахстана"><?php echo esc_textarea(get_option('bankz_meta_description', '')); ?></textarea>
                            <small><?php _e('Описание для поисковых систем (рекомендуется 150-160 символов)', 'bankz-finance'); ?></small>
                        </div>

                        <div class="seo-toggles">
                            <div class="toggle-group">
                                <label class="bankz-toggle">
                                    <input type="checkbox" name="enable_structured_data" value="1" <?php checked(get_option('bankz_enable_structured_data', 1), 1); ?>>
                                    <span class="bankz-toggle-slider"></span>
                                </label>
                                <div class="toggle-info">
                                    <span class="toggle-label"><?php _e('Структурированные данные', 'bankz-finance'); ?></span>
                                    <p class="toggle-description"><?php _e('Добавляет разметку Schema.org для поисковых систем', 'bankz-finance'); ?></p>
                                </div>
                            </div>

                            <div class="toggle-group">
                                <label class="bankz-toggle">
                                    <input type="checkbox" name="enable_sitemap" value="1" <?php checked(get_option('bankz_enable_sitemap', 1), 1); ?>>
                                    <span class="bankz-toggle-slider"></span>
                                </label>
                                <div class="toggle-info">
                                    <span class="toggle-label"><?php _e('XML Sitemap', 'bankz-finance'); ?></span>
                                    <p class="toggle-description"><?php _e('Автоматически генерирует карту сайта для поисковиков', 'bankz-finance'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Advanced Settings -->
            <div class="bankz-settings-section">
                <div class="section-header">
                    <h3>🔧 Расширенные настройки</h3>
                </div>
                <div class="section-content">
                    <div class="advanced-options">
                        <div class="bankz-form-group">
                            <label for="custom_css"><?php _e('Дополнительный CSS:', 'bankz-finance'); ?></label>
                            <textarea id="custom_css"
                                      name="custom_css"
                                      class="bankz-form-control code-editor"
                                      rows="8"
                                      placeholder="/* Ваш дополнительный CSS код */"><?php echo esc_textarea(get_option('bankz_custom_css', '')); ?></textarea>
                            <small><?php _e('Добавьте свои CSS стили, которые будут загружаться на всех страницах', 'bankz-finance'); ?></small>
                        </div>

                        <div class="bankz-form-group">
                            <label for="custom_js"><?php _e('Дополнительный JavaScript:', 'bankz-finance'); ?></label>
                            <textarea id="custom_js"
                                      name="custom_js"
                                      class="bankz-form-control code-editor"
                                      rows="8"
                                      placeholder="// Ваш дополнительный JS код"><?php echo esc_textarea(get_option('bankz_custom_js', '')); ?></textarea>
                            <small><?php _e('JavaScript код, который будет выполняться на всех страницах', 'bankz-finance'); ?></small>
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
                <button type="button" id="reset-settings" class="bankz-btn secondary confirm-action" data-confirm="Сбросить все настройки к значениям по умолчанию?">
                    🔄 <?php _e('Сбросить настройки', 'bankz-finance'); ?>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
/* General Settings Styles */
.analytics-toggles,
.content-toggles,
.performance-options,
.seo-toggles {
    display: flex;
    flex-direction: column;
    gap: 20px;
    margin-bottom: 24px;
}

.toggle-group {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    padding: 16px;
    background: var(--bankz-cream);
    border-radius: 8px;
    border: 1px solid var(--bankz-border);
}

.toggle-info {
    flex: 1;
}

.toggle-label {
    font-weight: 600;
    color: var(--bankz-text);
    display: block;
    margin-bottom: 4px;
}

.toggle-description {
    color: var(--bankz-text-light);
    font-size: 13px;
    margin: 0;
    line-height: 1.4;
}

.seo-options {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.advanced-options {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.code-editor {
    font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
    font-size: 13px;
    line-height: 1.4;
    background: #f8f8f8;
    border: 1px solid var(--bankz-border);
    border-radius: 4px;
    padding: 12px;
}

.code-editor:focus {
    background: white;
    border-color: var(--bankz-primary);
}

.form-actions {
    display: flex;
    gap: 16px;
    align-items: center;
    padding: 24px;
    background: var(--bankz-card-bg);
    border-radius: 8px;
    border: 1px solid var(--bankz-border);
    margin-top: 24px;
}

@media (max-width: 768px) {
    .form-actions {
        flex-direction: column;
        align-items: stretch;
    }

    .toggle-group {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
}

/* Success/Error Messages */
.settings-notice {
    padding: 12px 16px;
    border-radius: 4px;
    margin-bottom: 20px;
    border-left: 4px solid;
}

.settings-notice.success {
    background: #f0f8f0;
    border-left-color: #46b450;
    color: #155724;
}

.settings-notice.error {
    background: #fdf2f2;
    border-left-color: #dc3232;
    color: #721c24;
}

/* Collapsible Sections */
.section-toggle {
    cursor: pointer;
    user-select: none;
}

.section-toggle:hover {
    background: var(--bankz-cream-secondary);
}

.section-toggle::after {
    content: '▼';
    float: right;
    transition: transform 0.3s ease;
}

.section-toggle.collapsed::after {
    transform: rotate(-90deg);
}
</style>

<script>
jQuery(document).ready(function($) {
    // Code editor enhancements
    if (typeof CodeMirror !== 'undefined') {
        // Initialize CodeMirror if available
        var cssEditor = CodeMirror.fromTextArea(document.getElementById('custom_css'), {
            mode: 'css',
            lineNumbers: true,
            theme: 'default'
        });

        var jsEditor = CodeMirror.fromTextArea(document.getElementById('custom_js'), {
            mode: 'javascript',
            lineNumbers: true,
            theme: 'default'
        });
    }

    // Settings validation
    $('#posts_per_page, #excerpt_length').on('input', function() {
        var value = parseInt($(this).val());
        var min = parseInt($(this).attr('min'));
        var max = parseInt($(this).attr('max'));

        if (value < min || value > max) {
            $(this).addClass('error');
        } else {
            $(this).removeClass('error');
        }
    });

    // Google Analytics ID validation
    $('#google_analytics_id').on('blur', function() {
        var value = $(this).val().trim();
        var pattern = /^(G-[A-Z0-9]+|UA-\d+-\d+)$/;

        if (value && !pattern.test(value)) {
            $(this).addClass('error');
            if (!$(this).next('.field-error').length) {
                $(this).after('<span class="field-error">Неверный формат ID Google Analytics</span>');
            }
        } else {
            $(this).removeClass('error');
            $(this).next('.field-error').remove();
        }
    });

    // Reset settings
    $('#reset-settings').on('click', function() {
        if (confirm('Это действие сбросит все настройки к значениям по умолчанию. Продолжить?')) {
            $.post(ajaxurl, {
                action: 'bankz_reset_settings',
                nonce: '<?php echo wp_create_nonce('bankz_reset_settings'); ?>'
            }, function(response) {
                if (response.success) {
                    location.reload();
                }
            });
        }
    });

    // Auto-save for code editors
    let autoSaveTimer;
    $('.code-editor').on('input', function() {
        clearTimeout(autoSaveTimer);
        autoSaveTimer = setTimeout(function() {
            // Auto-save indication
            if (!$('.auto-save-indicator').length) {
                $('body').append('<div class="auto-save-indicator">💾 Автосохранение...</div>');
                setTimeout(function() {
                    $('.auto-save-indicator').remove();
                }, 2000);
            }
        }, 3000);
    });

    // Collapsible sections
    $('.section-toggle').on('click', function() {
        var target = $(this).next('.section-content');
        $(this).toggleClass('collapsed');
        target.slideToggle(300);
    });
});
</script>