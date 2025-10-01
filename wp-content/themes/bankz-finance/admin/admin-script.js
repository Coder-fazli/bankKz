/**
 * BankKz Admin Panel JavaScript
 *
 * @package BankKz_Finance
 */

jQuery(document).ready(function($) {

    // Initialize color picker
    if ($.fn.wpColorPicker) {
        $('.color-picker').wpColorPicker();
    }

    // Dashboard Analytics Chart
    function initAnalyticsChart() {
        const chartContainer = $('#analytics-chart');
        if (!chartContainer.length) return;

        // Chart period selector
        $('#analytics-period').on('change', function() {
            const period = $(this).val();
            loadAnalyticsData(period);
        });

        // Load initial data
        loadAnalyticsData(7);
    }

    function loadAnalyticsData(period) {
        $.ajax({
            url: bankz_admin_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'bankz_get_analytics_data',
                period: period,
                nonce: bankz_admin_ajax.nonce
            },
            beforeSend: function() {
                $('#analytics-chart').html('<div class="loading-spinner"></div>');
            },
            success: function(response) {
                if (response.success && response.data.length > 0) {
                    renderChart(response.data);
                } else {
                    $('#analytics-chart').html('<div class="no-data"><p>Нет данных для отображения</p></div>');
                }
            },
            error: function() {
                $('#analytics-chart').html('<div class="no-data"><p>Ошибка загрузки данных</p></div>');
            }
        });
    }

    function renderChart(data) {
        const maxValue = Math.max(...data.map(item => parseInt(item.views)));

        let chartHTML = '<div class="chart-bars">';

        data.forEach(function(item) {
            const percentage = maxValue > 0 ? (parseInt(item.views) / maxValue) * 100 : 0;
            const date = new Date(item.date);
            const formattedDate = date.toLocaleDateString('ru-RU', { month: 'short', day: 'numeric' });

            chartHTML += `
                <div class="chart-bar" data-value="${item.views}">
                    <div class="bar-fill" style="height: ${Math.max(percentage, 5)}%"></div>
                    <div class="bar-label">${formattedDate}</div>
                    <div class="bar-value">${item.views}</div>
                </div>
            `;
        });

        chartHTML += '</div>';

        $('#analytics-chart').html(chartHTML);
    }

    // Settings Form Handler
    function initSettingsForm() {
        $('.bankz-settings-form').on('submit', function(e) {
            e.preventDefault();

            const form = $(this);
            const submitButton = form.find('button[type="submit"]');
            const originalText = submitButton.text();

            // Disable form and show loading
            submitButton.prop('disabled', true).text('Сохранение...');

            const formData = new FormData(this);
            formData.append('action', 'bankz_save_settings');
            formData.append('nonce', bankz_admin_ajax.nonce);

            $.ajax({
                url: bankz_admin_ajax.ajax_url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        showNotice('success', response.data);
                    } else {
                        showNotice('error', response.data || 'Ошибка сохранения');
                    }
                },
                error: function() {
                    showNotice('error', 'Ошибка соединения с сервером');
                },
                complete: function() {
                    submitButton.prop('disabled', false).text(originalText);
                }
            });
        });
    }

    // Slider Preview
    function initSliderPreview() {
        if (!$('#slider-preview').length) return;

        $('#refresh-preview').on('click', function() {
            loadSliderPreview();
        });

        // Load preview on settings change
        $('input[name="slider_source"], input[name="slider_categories[]"], #slider_count').on('change', function() {
            loadSliderPreview();
        });

        // Initial load
        loadSliderPreview();
    }

    function loadSliderPreview() {
        const source = $('input[name="slider_source"]:checked').val();
        const categories = $('input[name="slider_categories[]"]:checked').map(function() {
            return this.value;
        }).get();
        const count = $('#slider_count').val();

        $.ajax({
            url: bankz_admin_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'bankz_get_slider_preview',
                source: source,
                categories: categories,
                count: count,
                nonce: bankz_admin_ajax.nonce
            },
            beforeSend: function() {
                $('#slider-preview').html('<div class="preview-loading"><div class="loading-spinner"></div><p>Загружаем предпросмотр...</p></div>');
            },
            success: function(response) {
                if (response.success) {
                    $('#slider-preview').html(response.data);
                } else {
                    $('#slider-preview').html('<div class="no-data"><p>Не удалось загрузить предпросмотр</p></div>');
                }
            },
            error: function() {
                $('#slider-preview').html('<div class="no-data"><p>Ошибка загрузки</p></div>');
            }
        });
    }

    // Preloader Preview
    function initPreloaderPreview() {
        if (!$('#preloader-preview').length) return;

        // Update preview on input changes
        $('#preloader_text, #loading_text, #preloader_background').on('input', updatePreloaderPreview);
        $('.icon-input').on('input', updatePreloaderPreview);

        // Background presets
        $('.preset-btn').on('click', function() {
            const bg = $(this).data('bg');
            $('#preloader_background').val(bg);
            updatePreloaderPreview();
        });

        // Icon suggestions
        $('.icon-suggestion').on('click', function() {
            const icon = $(this).data('icon');
            const input = $(this).closest('.icon-input-group').find('.icon-input');
            input.val(icon);
            updatePreloaderPreview();
        });

        // Play animation
        $('#play-preview').on('click', playPreloaderAnimation);

        // Initial preview
        updatePreloaderPreview();
    }

    function updatePreloaderPreview() {
        const background = $('#preloader_background').val();
        const text = $('#preloader_text').val();
        const loadingText = $('#loading_text').val();
        const icons = [];

        $('.icon-input').each(function() {
            icons.push($(this).val() || '$');
        });

        // Update preview elements
        $('.preview-preloader').css('background', background);
        $('.preview-preloader-logo').text(text);
        $('.preview-loading-text').text(loadingText);

        $('.preview-finance-icon').each(function(index) {
            if (icons[index]) {
                $(this).text(icons[index]);
            }
        });

        // Update active preset
        $('.preset-btn').removeClass('active');
        $(`.preset-btn[data-bg="${background}"]`).addClass('active');
    }

    function playPreloaderAnimation() {
        const $progress = $('.preview-loading-progress');
        const $button = $('#play-preview');
        const originalText = $button.text();

        $button.prop('disabled', true).text('⏳ Воспроизведение...');
        $progress.css('width', '0%');

        $progress.animate({width: '100%'}, 2500, function() {
            setTimeout(function() {
                $progress.css('width', '0%');
                $button.prop('disabled', false).text(originalText);
            }, 500);
        });
    }

    // Media Uploader
    function initMediaUploader() {
        let mediaUploader;

        $(document).on('click', '.upload-media-btn', function(e) {
            e.preventDefault();

            const button = $(this);
            const targetInput = button.data('target');

            if (mediaUploader) {
                mediaUploader.open();
                return;
            }

            mediaUploader = wp.media({
                title: button.data('title') || 'Выберите изображение',
                button: {
                    text: button.data('button-text') || 'Выбрать'
                },
                multiple: false
            });

            mediaUploader.on('select', function() {
                const attachment = mediaUploader.state().get('selection').first().toJSON();
                $(targetInput).val(attachment.url);

                // Update preview if exists
                const preview = $(targetInput + '-preview');
                if (preview.length) {
                    if (preview.is('img')) {
                        preview.attr('src', attachment.url);
                    } else {
                        preview.css('background-image', `url(${attachment.url})`);
                    }
                }

                // Trigger change event
                $(targetInput).trigger('change');
            });

            mediaUploader.open();
        });
    }

    // Tab Navigation
    function initTabNavigation() {
        $('.bankz-tab-nav').on('click', 'a', function(e) {
            e.preventDefault();

            const tab = $(this);
            const targetId = tab.attr('href');

            // Update active tab
            tab.closest('.bankz-tab-nav').find('a').removeClass('active');
            tab.addClass('active');

            // Show target content
            $('.bankz-tab-content').hide();
            $(targetId).show();
        });
    }

    // Toggle Sections
    function initToggleSections() {
        $('.section-toggle').on('click', function() {
            const target = $(this).data('target');
            const section = $(target);

            if (section.is(':visible')) {
                section.slideUp();
                $(this).removeClass('active');
            } else {
                section.slideDown();
                $(this).addClass('active');
            }
        });
    }

    // Auto-save functionality
    function initAutoSave() {
        let autoSaveTimer;

        $('.auto-save-form input, .auto-save-form textarea, .auto-save-form select').on('change input', function() {
            clearTimeout(autoSaveTimer);

            autoSaveTimer = setTimeout(function() {
                autoSaveSettings();
            }, 2000); // Save after 2 seconds of inactivity
        });
    }

    function autoSaveSettings() {
        const form = $('.auto-save-form');
        if (!form.length) return;

        const formData = form.serialize();

        $.ajax({
            url: bankz_admin_ajax.ajax_url,
            type: 'POST',
            data: formData + '&action=bankz_auto_save&nonce=' + bankz_admin_ajax.nonce,
            success: function(response) {
                if (response.success) {
                    showAutoSaveIndicator();
                }
            }
        });
    }

    function showAutoSaveIndicator() {
        if ($('.auto-save-indicator').length) return;

        $('body').append('<div class="auto-save-indicator">✓ Автосохранение</div>');

        setTimeout(function() {
            $('.auto-save-indicator').fadeOut(function() {
                $(this).remove();
            });
        }, 2000);
    }

    // Notification System
    function showNotice(type, message) {
        const notice = $(`
            <div class="bankz-notice ${type}">
                <p>${message}</p>
                <button type="button" class="notice-dismiss">×</button>
            </div>
        `);

        $('.bankz-admin-page').prepend(notice);

        // Auto-dismiss after 5 seconds
        setTimeout(function() {
            notice.fadeOut(function() {
                notice.remove();
            });
        }, 5000);

        // Manual dismiss
        notice.find('.notice-dismiss').on('click', function() {
            notice.fadeOut(function() {
                notice.remove();
            });
        });
    }

    // Form Validation
    function initFormValidation() {
        $('.bankz-required').on('blur', function() {
            const field = $(this);
            const value = field.val().trim();

            if (!value) {
                field.addClass('error');
                if (!field.next('.field-error').length) {
                    field.after('<span class="field-error">Это поле обязательно для заполнения</span>');
                }
            } else {
                field.removeClass('error');
                field.next('.field-error').remove();
            }
        });

        $('.bankz-url').on('blur', function() {
            const field = $(this);
            const value = field.val().trim();

            if (value && !isValidUrl(value) && !value.startsWith('/') && !value.startsWith('#')) {
                field.addClass('error');
                if (!field.next('.field-error').length) {
                    field.after('<span class="field-error">Введите корректный URL</span>');
                }
            } else {
                field.removeClass('error');
                field.next('.field-error').remove();
            }
        });
    }

    function isValidUrl(string) {
        try {
            new URL(string);
            return true;
        } catch (_) {
            return false;
        }
    }

    // Confirm Dialog
    function initConfirmDialogs() {
        $('.confirm-action').on('click', function(e) {
            const message = $(this).data('confirm') || 'Вы уверены?';

            if (!confirm(message)) {
                e.preventDefault();
                return false;
            }
        });
    }

    // Search Functionality
    function initSearch() {
        $('.bankz-search').on('input', function() {
            const query = $(this).val().toLowerCase();
            const target = $(this).data('target');

            $(target).each(function() {
                const text = $(this).text().toLowerCase();
                if (text.includes(query)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    }

    // Copy to Clipboard
    function initClipboard() {
        $('.copy-to-clipboard').on('click', function(e) {
            e.preventDefault();

            const text = $(this).data('copy') || $(this).text();

            navigator.clipboard.writeText(text).then(function() {
                showNotice('success', 'Скопировано в буфер обмена');
            });
        });
    }

    // Drag & Drop Sorting
    function initDragDrop() {
        if (!$.fn.sortable) return;

        $('.sortable-list').sortable({
            handle: '.drag-handle',
            placeholder: 'sortable-placeholder',
            update: function(event, ui) {
                const order = $(this).sortable('toArray', {attribute: 'data-id'});

                $.ajax({
                    url: bankz_admin_ajax.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'bankz_update_order',
                        order: order,
                        nonce: bankz_admin_ajax.nonce
                    },
                    success: function(response) {
                        if (response.success) {
                            showNotice('success', 'Порядок обновлен');
                        }
                    }
                });
            }
        });
    }

    // Progressive Enhancement
    function initProgressiveEnhancement() {
        // Add loading states
        $('form').on('submit', function() {
            const submitBtn = $(this).find('button[type="submit"]');
            submitBtn.prop('disabled', true).addClass('loading');
        });

        // Enhanced checkboxes and radios
        $('.enhanced-checkbox, .enhanced-radio').each(function() {
            const input = $(this).find('input');
            const label = $(this);

            input.on('change', function() {
                if (this.checked) {
                    label.addClass('checked');
                } else {
                    label.removeClass('checked');
                }
            });
        });

        // Smooth animations
        $('.slide-toggle').on('click', function() {
            const target = $($(this).data('target'));
            target.slideToggle(300);
        });
    }

    // Initialize all components
    function init() {
        initAnalyticsChart();
        initSettingsForm();
        initSliderPreview();
        initPreloaderPreview();
        initMediaUploader();
        initTabNavigation();
        initToggleSections();
        initAutoSave();
        initFormValidation();
        initConfirmDialogs();
        initSearch();
        initClipboard();
        initDragDrop();
        initProgressiveEnhancement();

        // Add loading class removal
        setTimeout(function() {
            $('.bankz-admin-page').removeClass('loading');
        }, 100);
    }

    // Initialize when DOM is ready
    init();

    // Re-initialize on AJAX content load
    $(document).on('bankz-content-loaded', function() {
        init();
    });
});

// CSS for additional functionality
const additionalCSS = `
    .loading-spinner {
        width: 20px;
        height: 20px;
        border: 2px solid #f3f3f3;
        border-top: 2px solid #6b4226;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 20px auto;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .auto-save-indicator {
        position: fixed;
        top: 32px;
        right: 20px;
        background: #46b450;
        color: white;
        padding: 8px 16px;
        border-radius: 4px;
        font-size: 12px;
        z-index: 10000;
    }

    .field-error {
        color: #dc3232;
        font-size: 12px;
        display: block;
        margin-top: 4px;
    }

    .bankz-form-control.error {
        border-color: #dc3232;
    }

    .notice-dismiss {
        background: transparent;
        border: none;
        color: inherit;
        cursor: pointer;
        float: right;
        font-size: 18px;
        line-height: 1;
        margin: -8px 0;
        padding: 8px;
    }
`;

// Inject additional CSS
jQuery('<style>').prop('type', 'text/css').html(additionalCSS).appendTo('head');