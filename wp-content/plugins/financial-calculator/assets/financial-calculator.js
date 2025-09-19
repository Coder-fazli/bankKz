/**
 * Financial Calculator Plugin JavaScript
 *
 * @package FinancialCalculator
 * @version 1.0.0
 */

jQuery(document).ready(function($) {
    'use strict';

    // Initialize all calculators on page
    $('.financial-calculator-widget').each(function() {
        initializeCalculator($(this));
    });

    function initializeCalculator($widget) {
        const uniqueId = $widget.attr('id');

        // Calculator switching functionality
        $widget.find('.type-btn').on('click', function() {
            const calcType = $(this).data('calc');

            // Update button states within this widget
            $widget.find('.type-btn').removeClass('active');
            $widget.find('[data-calc="' + calcType + '"]').addClass('active');

            // Show/hide calculators within this widget
            $widget.find('.calculator').removeClass('active');
            $widget.find('.' + calcType + '-calculator').addClass('active');

            // Update slider fills for the active calculator
            setTimeout(function() {
                $widget.find('.' + calcType + '-calculator .slider').each(function() {
                    updateSliderFill(this);
                });

                // Run the appropriate calculation
                if (calcType === 'credit') updateCreditCalculator(uniqueId);
                else if (calcType === 'mortgage') updateMortgageCalculator(uniqueId);
                else if (calcType === 'deposit') updateDepositCalculator(uniqueId);
            }, 50);
        });

        // Initialize all calculators
        initializeCreditCalculator(uniqueId);
        initializeMortgageCalculator(uniqueId);
        initializeDepositCalculator(uniqueId);

        // Initialize all slider fills on page load
        $widget.find('.slider').each(function() {
            updateSliderFill(this);
        });

        // Initial calculations
        updateCreditCalculator(uniqueId);
        updateMortgageCalculator(uniqueId);
        updateDepositCalculator(uniqueId);
    }

    // Credit Calculator
    function initializeCreditCalculator(uniqueId) {
        syncInputs('credit-amount', 'credit-amount-slider', 'credit-amount-display', function() {
            updateCreditCalculator(uniqueId);
        }, uniqueId);
        syncInputs('credit-rate', 'credit-rate-slider', 'credit-rate-display', function() {
            updateCreditCalculator(uniqueId);
        }, uniqueId);
        syncInputs('credit-term', 'credit-term-slider', 'credit-term-display', function() {
            updateCreditCalculator(uniqueId);
        }, uniqueId);
    }

    function updateCreditCalculator(uniqueId) {
        const amount = parseFloat($('#credit-amount-' + uniqueId).val() || 0);
        const rate = parseFloat($('#credit-rate-' + uniqueId).val() || 0) / 100 / 12;
        const term = parseInt($('#credit-term-' + uniqueId).val() || 0);

        if (amount > 0 && rate > 0 && term > 0) {
            const payment = (amount * rate * Math.pow(1 + rate, term)) / (Math.pow(1 + rate, term) - 1);
            $('#credit-payment-' + uniqueId).text(formatNumber(payment.toFixed(0)));
        }
    }

    // Mortgage Calculator
    function initializeMortgageCalculator(uniqueId) {
        syncInputs('home-value', 'home-value-slider', 'home-value-display', function() {
            updateMortgageCalculator(uniqueId);
        }, uniqueId);
        syncInputs('down-payment-percent', 'down-payment-percent-slider', 'down-payment-percent-display', function() {
            updateMortgageCalculator(uniqueId);
        }, uniqueId);
        syncInputs('mortgage-term-years', 'mortgage-term-years-slider', 'mortgage-term-years-display', function() {
            updateMortgageCalculator(uniqueId);
        }, uniqueId);
    }

    function updateMortgageCalculator(uniqueId) {
        const homeValue = parseFloat($('#home-value-' + uniqueId).val() || 0);
        const downPaymentPercent = parseFloat($('#down-payment-percent-' + uniqueId).val() || 0);
        const termYears = parseInt($('#mortgage-term-years-' + uniqueId).val() || 0);
        const annualRate = 16.5; // Kazakhstan mortgage rate

        if (homeValue > 0 && downPaymentPercent > 0 && termYears > 0) {
            const minDownPayment = homeValue * (downPaymentPercent / 100);
            const loanAmount = homeValue - minDownPayment;
            const monthlyRate = annualRate / 100 / 12;
            const termMonths = termYears * 12;

            const monthlyPayment = (loanAmount * monthlyRate * Math.pow(1 + monthlyRate, termMonths)) / (Math.pow(1 + monthlyRate, termMonths) - 1);

            $('#min-down-payment-' + uniqueId).text(formatNumber(minDownPayment.toFixed(0)));
            $('#mortgage-payment-' + uniqueId).text(formatNumber(monthlyPayment.toFixed(0)));
            $('#loan-amount-' + uniqueId).text(formatNumber(loanAmount.toFixed(0)));
            $('#annual-rate-' + uniqueId).text(annualRate.toFixed(2));
        }
    }

    // Deposit Calculator
    function initializeDepositCalculator(uniqueId) {
        syncInputs('deposit-amount', 'deposit-amount-slider', 'deposit-amount-display', function() {
            updateDepositCalculator(uniqueId);
        }, uniqueId);
        syncInputs('deposit-rate', 'deposit-rate-slider', 'deposit-rate-display', function() {
            updateDepositCalculator(uniqueId);
        }, uniqueId);
        syncInputs('deposit-term', 'deposit-term-slider', 'deposit-term-display', function() {
            updateDepositCalculator(uniqueId);
        }, uniqueId);
    }

    function updateDepositCalculator(uniqueId) {
        const amount = parseFloat($('#deposit-amount-' + uniqueId).val() || 0);
        const annualRate = parseFloat($('#deposit-rate-' + uniqueId).val() || 0);
        const termMonths = parseInt($('#deposit-term-' + uniqueId).val() || 0);

        if (amount > 0 && annualRate > 0 && termMonths > 0) {
            const monthlyInterest = (amount * annualRate / 100) / 12;
            const totalInterest = monthlyInterest * termMonths;

            $('#monthly-interest-' + uniqueId).text(formatNumber(monthlyInterest.toFixed(0)));
            $('#total-interest-' + uniqueId).text(formatNumber(totalInterest.toFixed(0)));
        }
    }

    // Update slider fill based on value
    function updateSliderFill(slider) {
        const $slider = $(slider);
        const value = (($slider.val() - $slider.attr('min')) / ($slider.attr('max') - $slider.attr('min'))) * 100;
        $slider.css('--fill-percent', value + '%');
    }

    // Format number with spaces (Kazakhstan format)
    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    // Sync inputs with sliders and displays
    function syncInputs(inputId, sliderId, displayId, updateFunction, uniqueId) {
        const input = $('#' + inputId + '-' + uniqueId);
        const slider = $('#' + sliderId + '-' + uniqueId);
        const display = $('#' + displayId + '-' + uniqueId);

        if (input.length && slider.length && display.length) {
            // Initialize fill
            updateSliderFill(slider[0]);

            slider.on('input', function() {
                input.val(this.value);
                display.text(formatNumber(this.value));
                updateSliderFill(this);
                updateFunction();
            });
        }
    }

    // Handle widget initialization for dynamically loaded content
    $(document).on('DOMNodeInserted', function(e) {
        const $target = $(e.target);
        if ($target.hasClass('financial-calculator-widget') && !$target.data('initialized')) {
            $target.data('initialized', true);
            initializeCalculator($target);
        }
    });
});