<?php
/**
 * BankKz Preloader Settings Page
 *
 * @package BankKz_Finance
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Get current settings
$preloader_enabled = get_option('bankz_preloader_enabled', 1);
$preloader_background = get_option('bankz_preloader_background', 'linear-gradient(135deg, #6b4226, #8b4513)');
$preloader_text = get_option('bankz_preloader_text', 'ФинансБлог');
$loading_text = get_option('bankz_loading_text', 'Загружаем финансовые данные...');
$preloader_icons = get_option('bankz_preloader_icons', array('$', '%', '₸', '€', '£'));

// Ensure we have 5 icons
while (count($preloader_icons) < 5) {
    $preloader_icons[] = '$';
}
?>

<div class="wrap bankz-admin-page">
    <div class="bankz-admin-header">
        <h1>🎬 Настройки прелоадера</h1>
        <p class="description">Управляйте экраном загрузки сайта. Настройте внешний вид, анимации и текстовые сообщения для создания профессионального первого впечатления.</p>
    </div>

    <div class="bankz-dashboard-content">
        <form method="post" action="">
            <?php wp_nonce_field('bankz_preloader_settings'); ?>

            <!-- Enable/Disable Preloader -->
            <div class="bankz-settings-section">
                <div class="section-header">
                    <h3>⚡ Основные настройки</h3>
                </div>
                <div class="section-content">
                    <div class="bankz-form-group">
                        <label><?php _e('Прелоадер:', 'bankz-finance'); ?></label>
                        <div class="toggle-container main-toggle">
                            <label class="bankz-toggle">
                                <input type="checkbox" name="preloader_enabled" value="1" <?php checked($preloader_enabled, 1); ?>>
                                <span class="bankz-toggle-slider"></span>
                            </label>
                            <div class="toggle-info">
                                <span class="toggle-label"><?php _e('Включить прелоадер на главной странице', 'bankz-finance'); ?></span>
                                <p class="toggle-description"><?php _e('Показывает анимированный экран загрузки при первом посещении сайта', 'bankz-finance'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Preloader Settings (shown when enabled) -->
            <div id="preloader-settings" style="<?php echo !$preloader_enabled ? 'display: none;' : ''; ?>">

                <!-- Visual Design Settings -->
                <div class="bankz-settings-section">
                    <div class="section-header">
                        <h3>🎨 Внешний вид</h3>
                    </div>
                    <div class="section-content">
                        <div class="settings-row">
                            <div class="bankz-form-group">
                                <label for="preloader_text"><?php _e('Заголовок:', 'bankz-finance'); ?></label>
                                <input type="text"
                                       id="preloader_text"
                                       name="preloader_text"
                                       value="<?php echo esc_attr($preloader_text); ?>"
                                       class="bankz-form-control"
                                       placeholder="ФинансБлог">
                                <small><?php _e('Основной текст, отображаемый на прелоадере', 'bankz-finance'); ?></small>
                            </div>

                            <div class="bankz-form-group">
                                <label for="loading_text"><?php _e('Текст загрузки:', 'bankz-finance'); ?></label>
                                <input type="text"
                                       id="loading_text"
                                       name="loading_text"
                                       value="<?php echo esc_attr($loading_text); ?>"
                                       class="bankz-form-control"
                                       placeholder="Загружаем финансовые данные...">
                                <small><?php _e('Текст под прогресс-баром', 'bankz-finance'); ?></small>
                            </div>
                        </div>

                        <div class="bankz-form-group">
                            <label for="preloader_background"><?php _e('Фон прелоадера:', 'bankz-finance'); ?></label>
                            <div class="background-controls">
                                <input type="text"
                                       id="preloader_background"
                                       name="preloader_background"
                                       value="<?php echo esc_attr($preloader_background); ?>"
                                       class="bankz-form-control background-input">
                                <div class="background-presets">
                                    <div class="preset-title"><?php _e('Готовые варианты:', 'bankz-finance'); ?></div>
                                    <div class="presets-grid">
                                        <button type="button" class="preset-btn" data-bg="linear-gradient(135deg, #6b4226, #8b4513)">
                                            <div class="preset-preview" style="background: linear-gradient(135deg, #6b4226, #8b4513);"></div>
                                            <span><?php _e('Классический', 'bankz-finance'); ?></span>
                                        </button>
                                        <button type="button" class="preset-btn" data-bg="linear-gradient(135deg, #4a2e1a, #6b4226)">
                                            <div class="preset-preview" style="background: linear-gradient(135deg, #4a2e1a, #6b4226);"></div>
                                            <span><?php _e('Темный', 'bankz-finance'); ?></span>
                                        </button>
                                        <button type="button" class="preset-btn" data-bg="linear-gradient(135deg, #8b5a3a, #a0522d)">
                                            <div class="preset-preview" style="background: linear-gradient(135deg, #8b5a3a, #a0522d);"></div>
                                            <span><?php _e('Светлый', 'bankz-finance'); ?></span>
                                        </button>
                                        <button type="button" class="preset-btn" data-bg="#6b4226">
                                            <div class="preset-preview" style="background: #6b4226;"></div>
                                            <span><?php _e('Сплошной', 'bankz-finance'); ?></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <small><?php _e('CSS значение для фона (цвет или градиент)', 'bankz-finance'); ?></small>
                        </div>
                    </div>
                </div>

                <!-- Icons Settings -->
                <div class="bankz-settings-section">
                    <div class="section-header">
                        <h3>💰 Финансовые иконки</h3>
                    </div>
                    <div class="section-content">
                        <p class="section-description"><?php _e('Настройте 5 анимированных иконок, которые отображаются во время загрузки', 'bankz-finance'); ?></p>

                        <div class="icons-grid">
                            <?php for ($i = 0; $i < 5; $i++) : ?>
                                <div class="icon-input-group">
                                    <label><?php printf(__('Иконка %d:', 'bankz-finance'), $i + 1); ?></label>
                                    <div class="icon-input-container">
                                        <input type="text"
                                               name="preloader_icons[<?php echo $i; ?>]"
                                               value="<?php echo esc_attr($preloader_icons[$i] ?? ''); ?>"
                                               class="bankz-form-control icon-input"
                                               maxlength="2"
                                               placeholder="$">
                                        <div class="icon-suggestions">
                                            <button type="button" class="icon-suggestion" data-icon="$">$</button>
                                            <button type="button" class="icon-suggestion" data-icon="€">€</button>
                                            <button type="button" class="icon-suggestion" data-icon="₸">₸</button>
                                            <button type="button" class="icon-suggestion" data-icon="£">£</button>
                                            <button type="button" class="icon-suggestion" data-icon="%">%</button>
                                            <button type="button" class="icon-suggestion" data-icon="₽">₽</button>
                                            <button type="button" class="icon-suggestion" data-icon="¥">¥</button>
                                            <button type="button" class="icon-suggestion" data-icon="₿">₿</button>
                                        </div>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>

                <!-- Preview Section -->
                <div class="bankz-settings-section">
                    <div class="section-header">
                        <h3>👁️ Предпросмотр</h3>
                    </div>
                    <div class="section-content">
                        <div class="preloader-preview" id="preloader-preview">
                            <div class="preview-preloader" style="background: <?php echo esc_attr($preloader_background); ?>;">
                                <!-- Animated falling coins -->
                                <div class="preview-coins-animation">$</div>
                                <div class="preview-coins-animation">€</div>
                                <div class="preview-coins-animation">₸</div>

                                <div class="preview-preloader-content">
                                    <div class="preview-preloader-logo"><?php echo esc_html($preloader_text); ?></div>

                                    <div class="preview-finance-icons">
                                        <?php foreach ($preloader_icons as $icon) : ?>
                                            <div class="preview-finance-icon"><?php echo esc_html($icon); ?></div>
                                        <?php endforeach; ?>
                                    </div>

                                    <div class="preview-loading-bar">
                                        <div class="preview-loading-progress"></div>
                                    </div>

                                    <div class="preview-loading-text"><?php echo esc_html($loading_text); ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="preview-controls">
                            <button type="button" id="play-preview" class="bankz-btn secondary">
                                ▶️ <?php _e('Воспроизвести анимацию', 'bankz-finance'); ?>
                            </button>
                            <button type="button" id="refresh-preview" class="bankz-btn secondary">
                                🔄 <?php _e('Обновить предпросмотр', 'bankz-finance'); ?>
                            </button>
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
            </div>
        </form>
    </div>
</div>

<style>
/* Preloader Settings Styles */
.main-toggle .toggle-container {
    align-items: flex-start;
    gap: 16px;
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
}

.background-controls {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.background-presets {
    background: var(--bankz-cream);
    padding: 16px;
    border-radius: 8px;
    border: 1px solid var(--bankz-border);
}

.preset-title {
    font-weight: 600;
    color: var(--bankz-text);
    margin-bottom: 12px;
}

.presets-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 12px;
}

.preset-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    padding: 12px;
    background: white;
    border: 2px solid var(--bankz-border);
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.preset-btn:hover {
    border-color: var(--bankz-primary);
    transform: translateY(-2px);
    box-shadow: var(--shadow-sm);
}

.preset-btn.active {
    border-color: var(--bankz-primary);
    background: var(--bankz-cream-secondary);
}

.preset-preview {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.preset-btn span {
    font-size: 12px;
    color: var(--bankz-text);
    font-weight: 500;
}

.section-description {
    color: var(--bankz-text-light);
    margin-bottom: 24px;
    padding: 12px;
    background: var(--bankz-cream);
    border-radius: 6px;
    border-left: 4px solid var(--bankz-primary);
}

.icons-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.icon-input-group {
    background: var(--bankz-cream);
    padding: 16px;
    border-radius: 8px;
    border: 1px solid var(--bankz-border);
}

.icon-input-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: var(--bankz-text);
}

.icon-input-container {
    position: relative;
}

.icon-input {
    text-align: center;
    font-size: 24px;
    font-weight: bold;
    padding: 12px;
    margin-bottom: 8px;
}

.icon-suggestions {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
    justify-content: center;
}

.icon-suggestion {
    width: 32px;
    height: 32px;
    background: white;
    border: 1px solid var(--bankz-border);
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.icon-suggestion:hover {
    background: var(--bankz-primary);
    color: white;
    border-color: var(--bankz-primary);
    transform: scale(1.1);
}

/* Preloader Preview */
.preloader-preview {
    background: #f0f0f0;
    border-radius: 12px;
    margin-bottom: 16px;
    overflow: hidden;
    border: 2px solid var(--bankz-border);
}

.preview-preloader {
    height: 300px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

.preview-coins-animation {
    position: absolute;
    font-size: 18px;
    color: rgba(255, 255, 255, 0.6);
    font-weight: bold;
    animation: preview-coin-fall 3s linear infinite;
}

.preview-coins-animation:nth-child(1) {
    top: -20px;
    left: 20%;
    animation-delay: 0s;
}

.preview-coins-animation:nth-child(2) {
    top: -20px;
    left: 70%;
    animation-delay: 1s;
}

.preview-coins-animation:nth-child(3) {
    top: -20px;
    left: 45%;
    animation-delay: 2s;
}

@keyframes preview-coin-fall {
    0% {
        transform: translateY(-30px) rotate(0deg);
        opacity: 0;
    }
    20% {
        opacity: 0.6;
    }
    80% {
        opacity: 0.6;
    }
    100% {
        transform: translateY(340px) rotate(360deg);
        opacity: 0;
    }
}

.preview-preloader-content {
    text-align: center;
    color: white;
    position: relative;
    z-index: 2;
}

.preview-preloader-logo {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 16px;
    letter-spacing: 1px;
}

.preview-finance-icons {
    display: flex;
    justify-content: center;
    gap: 16px;
    margin-bottom: 20px;
}

.preview-finance-icon {
    font-size: 20px;
    animation: preview-float 1.5s ease-in-out infinite;
    opacity: 0.95;
    font-weight: bold;
}

.preview-finance-icon:nth-child(1) { animation-delay: 0s; }
.preview-finance-icon:nth-child(2) { animation-delay: 0.2s; }
.preview-finance-icon:nth-child(3) { animation-delay: 0.4s; }
.preview-finance-icon:nth-child(4) { animation-delay: 0.6s; }
.preview-finance-icon:nth-child(5) { animation-delay: 0.8s; }

@keyframes preview-float {
    0%, 100% {
        transform: translateY(0px) scale(1);
        opacity: 0.95;
    }
    50% {
        transform: translateY(-8px) scale(1.05);
        opacity: 1;
    }
}

.preview-loading-bar {
    width: 150px;
    height: 3px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 2px;
    margin: 0 auto 12px;
    overflow: hidden;
}

.preview-loading-progress {
    width: 0%;
    height: 100%;
    background: linear-gradient(90deg, rgba(255,255,255,0.8), rgba(255,255,255,0.6));
    border-radius: 2px;
    transition: width 0.3s ease;
}

.preview-loading-text {
    font-size: 12px;
    opacity: 0.9;
}

.preview-controls {
    display: flex;
    gap: 12px;
    justify-content: center;
}

@media (max-width: 768px) {
    .icons-grid {
        grid-template-columns: 1fr;
    }

    .presets-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .preview-controls {
        flex-direction: column;
        align-items: stretch;
    }
}
</style>

<script>
jQuery(document).ready(function($) {
    // Show/hide preloader settings based on enable toggle
    $('input[name="preloader_enabled"]').on('change', function() {
        if ($(this).is(':checked')) {
            $('#preloader-settings').fadeIn();
        } else {
            $('#preloader-settings').fadeOut();
        }
    });

    // Background preset selection
    $('.preset-btn').on('click', function() {
        var bg = $(this).data('bg');
        $('#preloader_background').val(bg);
        $('.preset-btn').removeClass('active');
        $(this).addClass('active');
        updatePreview();
    });

    // Icon suggestion selection
    $('.icon-suggestion').on('click', function() {
        var icon = $(this).data('icon');
        $(this).closest('.icon-input-group').find('.icon-input').val(icon);
        updatePreview();
    });

    // Update preview on input change
    $('#preloader_text, #loading_text, #preloader_background').on('input', function() {
        updatePreview();
    });

    $('.icon-input').on('input', function() {
        updatePreview();
    });

    // Play preview animation
    $('#play-preview').on('click', function() {
        playPreviewAnimation();
    });

    // Refresh preview
    $('#refresh-preview').on('click', function() {
        updatePreview();
    });

    // Function to update preview
    function updatePreview() {
        var background = $('#preloader_background').val();
        var text = $('#preloader_text').val();
        var loadingText = $('#loading_text').val();
        var icons = [];

        $('.icon-input').each(function() {
            icons.push($(this).val() || '$');
        });

        // Update preview background
        $('.preview-preloader').css('background', background);

        // Update preview text
        $('.preview-preloader-logo').text(text);
        $('.preview-loading-text').text(loadingText);

        // Update preview icons
        $('.preview-finance-icon').each(function(index) {
            if (icons[index]) {
                $(this).text(icons[index]);
            }
        });

        // Update active preset
        $('.preset-btn').removeClass('active');
        $('.preset-btn[data-bg="' + background + '"]').addClass('active');
    }

    // Function to play preview animation
    function playPreviewAnimation() {
        var $progress = $('.preview-loading-progress');
        var $button = $('#play-preview');

        $button.prop('disabled', true).text('⏳ Воспроизведение...');
        $progress.css('width', '0%');

        // Animate progress bar
        $progress.animate({width: '100%'}, 2000, function() {
            setTimeout(function() {
                $progress.css('width', '0%');
                $button.prop('disabled', false).text('▶️ Воспроизвести анимацию');
            }, 500);
        });
    }

    // Initial preview update
    updatePreview();
});
</script>