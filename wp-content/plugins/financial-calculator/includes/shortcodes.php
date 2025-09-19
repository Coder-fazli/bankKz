<?php
/**
 * Financial Calculator Shortcodes
 *
 * @package FinancialCalculator
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Financial Calculator Shortcodes Class
 */
class FinancialCalculatorShortcodes {

    /**
     * Constructor
     */
    public function __construct() {
        add_shortcode('kredit_calculator', array($this, 'kredit_calculator_shortcode'));
        add_shortcode('ipoteka_calculator', array($this, 'ipoteka_calculator_shortcode'));
        add_shortcode('emanet_calculator', array($this, 'emanet_calculator_shortcode'));
        add_shortcode('financial_calculator', array($this, 'financial_calculator_shortcode'));
    }

    /**
     * Credit Calculator Shortcode - New Design
     */
    public function kredit_calculator_shortcode($atts) {
        $unique_id = uniqid('calc_');

        ob_start();
        ?>
        <div class="container-fluid">
            <div class="loan__calculate" id="<?php echo esc_attr($unique_id); ?>">
                <h2 class="section-title"><?php _e('Кредитный калькулятор', 'financial-calculator'); ?></h2>

                <div class="d-md-flex">
                    <div class="loan__calculate__item">
                        <div class="form-group">
                            <label><?php _e('Введите условия', 'financial-calculator'); ?></label>
                            <select class="form-control" id="loan-conditions-<?php echo esc_attr($unique_id); ?>">
                                <option value="0"><?php _e('Поручительство', 'financial-calculator'); ?></option>
                                <option value="1"><?php _e('Недвижимое имущество', 'financial-calculator'); ?></option>
                                <option value="2"><?php _e('Автомобиль', 'financial-calculator'); ?></option>
                            </select>
                        </div>

                        <div class="form-group form-group--range">
                            <label><?php _e('Сумма кредита', 'financial-calculator'); ?></label>
                            <div class="position-relative">
                                <input type="tel" placeholder="10 000" min="500" max="150000" value="12264" id="loan-price-<?php echo esc_attr($unique_id); ?>" class="form-control">
                                <input type="range" name="loan_amount" aria-label="Loan amount" class="loan-price-range irs-range-slider" min="500" max="150000" value="12264" data-target="loan-price-<?php echo esc_attr($unique_id); ?>">
                                <span class="form-group__label">AZN</span>
                            </div>
                        </div>

                        <div class="form-group form-group--range">
                            <label><?php _e('Срок кредита', 'financial-calculator'); ?></label>
                            <div class="position-relative">
                                <input type="tel" placeholder="25" id="loan-month-<?php echo esc_attr($unique_id); ?>" max="59" min="12" value="23" class="form-control">
                                <input type="range" name="loan_term" aria-label="Loan term" class="loan-term-range irs-range-slider" min="12" max="59" value="23" data-target="loan-month-<?php echo esc_attr($unique_id); ?>">
                                <span class="form-group__label"><?php _e('Мес', 'financial-calculator'); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="loan__calculate__terms">
                        <ul class="loan__calculate__terms__info">
                            <li>
                                <?php _e('Общая сумма', 'financial-calculator'); ?>
                                <span id="total-amount-<?php echo esc_attr($unique_id); ?>">13789.42<em> AZN </em></span>
                            </li>
                            <li>
                                <?php _e('Ежемесячная оплата', 'financial-calculator'); ?>
                                <span class="text-red" id="monthly-payment-<?php echo esc_attr($unique_id); ?>">599.54 <em>AZN</em></span>
                            </li>
                            <li>
                                <?php _e('Процентная ставка', 'financial-calculator'); ?>
                                <span id="interest-rate-<?php echo esc_attr($unique_id); ?>"> 12 <em>%</em></span>
                            </li>
                        </ul>
                        <div class="d-md-flex justify-content-between">
                            <p></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * Mortgage Calculator Shortcode
     */
    public function ipoteka_calculator_shortcode($atts) {
        $unique_id = uniqid('calc_');

        ob_start();
        ?>
        <div class="financial-calculator-widget ipoteka-calculator-widget" id="<?php echo esc_attr($unique_id); ?>">
            <div class="calculator-section">
                <div class="calculator mortgage-calculator active">
                    <div class="value-box">
                        <div class="value-label"><?php _e('Алғашқы жарна пайызы', 'financial-calculator'); ?></div>
                        <div class="value-display">
                            <span id="down-payment-percent-display-<?php echo esc_attr($unique_id); ?>">20</span>%
                        </div>
                        <input type="range" id="down-payment-percent-slider-<?php echo esc_attr($unique_id); ?>" min="10" max="50" value="20" step="0.1" class="slider">
                        <input type="hidden" id="down-payment-percent-<?php echo esc_attr($unique_id); ?>" value="20">
                    </div>

                    <div class="input-row">
                        <div class="value-box half">
                            <div class="value-label"><?php _e('Пәтер құны', 'financial-calculator'); ?></div>
                            <div class="value-display">
                                <span id="home-value-display-<?php echo esc_attr($unique_id); ?>">25,000,000</span>₸
                            </div>
                            <input type="range" id="home-value-slider-<?php echo esc_attr($unique_id); ?>" min="5000000" max="100000000" value="25000000" class="slider">
                            <input type="hidden" id="home-value-<?php echo esc_attr($unique_id); ?>" value="25000000">
                        </div>

                        <div class="value-box half">
                            <div class="value-label"><?php _e('Кредит мерзімі', 'financial-calculator'); ?></div>
                            <div class="value-display">
                                <span id="mortgage-term-years-display-<?php echo esc_attr($unique_id); ?>">15</span> <?php _e('жыл', 'financial-calculator'); ?>
                            </div>
                            <input type="range" id="mortgage-term-years-slider-<?php echo esc_attr($unique_id); ?>" min="5" max="25" value="15" class="slider">
                            <input type="hidden" id="mortgage-term-years-<?php echo esc_attr($unique_id); ?>" value="15">
                        </div>
                    </div>

                    <div class="results-grid">
                        <div class="result-item">
                            <div class="result-label"><?php _e('Минималды алғашқы жарна', 'financial-calculator'); ?></div>
                            <div class="result-value">
                                <span id="min-down-payment-<?php echo esc_attr($unique_id); ?>">5,000,000</span> ₸
                            </div>
                        </div>
                        <div class="result-item">
                            <div class="result-label"><?php _e('Айлық төлем', 'financial-calculator'); ?></div>
                            <div class="result-value">
                                <span id="mortgage-payment-<?php echo esc_attr($unique_id); ?>">285,432</span> ₸
                            </div>
                        </div>
                        <div class="result-item">
                            <div class="result-label"><?php _e('Кредит сомасы', 'financial-calculator'); ?></div>
                            <div class="result-value">
                                <span id="loan-amount-<?php echo esc_attr($unique_id); ?>">20,000,000</span> ₸
                            </div>
                        </div>
                        <div class="result-item">
                            <div class="result-label"><?php _e('Жылдық % мөлшерлемесі', 'financial-calculator'); ?></div>
                            <div class="result-value">
                                <span id="annual-rate-<?php echo esc_attr($unique_id); ?>">16.50</span> %
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * Deposit Calculator Shortcode
     */
    public function emanet_calculator_shortcode($atts) {
        $unique_id = uniqid('calc_');

        ob_start();
        ?>
        <div class="financial-calculator-widget emanet-calculator-widget" id="<?php echo esc_attr($unique_id); ?>">
            <div class="calculator-section">
                <div class="calculator deposit-calculator active">
                    <div class="value-box">
                        <div class="value-label"><?php _e('Алғашқы салым сомасы', 'financial-calculator'); ?></div>
                        <div class="value-display">
                            <span id="deposit-amount-display-<?php echo esc_attr($unique_id); ?>">1,000,000</span>₸
                        </div>
                        <input type="range" id="deposit-amount-slider-<?php echo esc_attr($unique_id); ?>" min="50000" max="50000000" value="1000000" class="slider">
                        <input type="hidden" id="deposit-amount-<?php echo esc_attr($unique_id); ?>" value="1000000">
                    </div>

                    <div class="input-row">
                        <div class="value-box half">
                            <div class="value-label"><?php _e('Жылдық пайыз мөлшерлемесі', 'financial-calculator'); ?></div>
                            <div class="value-display">
                                <span id="deposit-rate-display-<?php echo esc_attr($unique_id); ?>">14</span>%
                            </div>
                            <input type="range" id="deposit-rate-slider-<?php echo esc_attr($unique_id); ?>" min="5" max="20" value="14" step="0.1" class="slider">
                            <input type="hidden" id="deposit-rate-<?php echo esc_attr($unique_id); ?>" value="14">
                        </div>

                        <div class="value-box half">
                            <div class="value-label"><?php _e('Мерзімі', 'financial-calculator'); ?></div>
                            <div class="value-display">
                                <span id="deposit-term-display-<?php echo esc_attr($unique_id); ?>">12</span> <?php _e('ай', 'financial-calculator'); ?>
                            </div>
                            <input type="range" id="deposit-term-slider-<?php echo esc_attr($unique_id); ?>" min="3" max="60" value="12" class="slider">
                            <input type="hidden" id="deposit-term-<?php echo esc_attr($unique_id); ?>" value="12">
                        </div>
                    </div>

                    <div class="results-grid">
                        <div class="result-item">
                            <div class="result-label"><?php _e('Айлық пайыз табысы', 'financial-calculator'); ?></div>
                            <div class="result-value">
                                <span id="monthly-interest-<?php echo esc_attr($unique_id); ?>">11,667</span> ₸
                            </div>
                        </div>
                        <div class="result-item">
                            <div class="result-label"><?php _e('Мерзім аяғындағы пайыз табысы', 'financial-calculator'); ?></div>
                            <div class="result-value">
                                <span id="total-interest-<?php echo esc_attr($unique_id); ?>">140,000</span> ₸
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * Combined Financial Calculator Shortcode
     */
    public function financial_calculator_shortcode($atts) {
        $unique_id = uniqid('calc_');

        ob_start();
        ?>
        <div class="financial-calculator-widget" id="<?php echo esc_attr($unique_id); ?>">
            <!-- Calculator Type Selector -->
            <div class="calc-type-buttons">
                <button class="type-btn active" data-calc="credit"><?php _e('Кредит калькуляторы', 'financial-calculator'); ?></button>
                <button class="type-btn" data-calc="mortgage"><?php _e('Ипотека калькуляторы', 'financial-calculator'); ?></button>
                <button class="type-btn" data-calc="deposit"><?php _e('Салым калькуляторы', 'financial-calculator'); ?></button>
            </div>

            <!-- Credit Calculator -->
            <div class="calculator credit-calculator active">
                <div class="value-box">
                    <div class="value-label"><?php _e('Кредит сомасы', 'financial-calculator'); ?></div>
                    <div class="value-display">
                        <span id="credit-amount-display-<?php echo esc_attr($unique_id); ?>">2,500,000</span>₸
                    </div>
                    <input type="range" id="credit-amount-slider-<?php echo esc_attr($unique_id); ?>" min="100000" max="10000000" value="2500000" class="slider">
                    <input type="hidden" id="credit-amount-<?php echo esc_attr($unique_id); ?>" value="2500000">
                </div>

                <div class="input-row">
                    <div class="value-box half">
                        <div class="value-label"><?php _e('Жылдық пайыз мөлшерлемесі', 'financial-calculator'); ?></div>
                        <div class="value-display">
                            <span id="credit-rate-display-<?php echo esc_attr($unique_id); ?>">15</span>%
                        </div>
                        <input type="range" id="credit-rate-slider-<?php echo esc_attr($unique_id); ?>" min="5" max="35" value="15" step="0.1" class="slider">
                        <input type="hidden" id="credit-rate-<?php echo esc_attr($unique_id); ?>" value="15">
                    </div>

                    <div class="value-box half">
                        <div class="value-label"><?php _e('Кредит мерзімі', 'financial-calculator'); ?></div>
                        <div class="value-display">
                            <span id="credit-term-display-<?php echo esc_attr($unique_id); ?>">24</span> <?php _e('ай', 'financial-calculator'); ?>
                        </div>
                        <input type="range" id="credit-term-slider-<?php echo esc_attr($unique_id); ?>" min="3" max="360" value="24" class="slider">
                        <input type="hidden" id="credit-term-<?php echo esc_attr($unique_id); ?>" value="24">
                    </div>
                </div>

                <div class="result-box">
                    <div class="result-label"><?php _e('Айлық төлем', 'financial-calculator'); ?></div>
                    <div class="result-value">
                        <span id="credit-payment-<?php echo esc_attr($unique_id); ?>">120,543</span> ₸
                    </div>
                </div>
            </div>

            <!-- Mortgage Calculator -->
            <div class="calculator mortgage-calculator">
                <div class="value-box">
                    <div class="value-label"><?php _e('Алғашқы жарна пайызы', 'financial-calculator'); ?></div>
                    <div class="value-display">
                        <span id="down-payment-percent-display-<?php echo esc_attr($unique_id); ?>">20</span>%
                    </div>
                    <input type="range" id="down-payment-percent-slider-<?php echo esc_attr($unique_id); ?>" min="10" max="50" value="20" step="0.1" class="slider">
                    <input type="hidden" id="down-payment-percent-<?php echo esc_attr($unique_id); ?>" value="20">
                </div>

                <div class="input-row">
                    <div class="value-box half">
                        <div class="value-label"><?php _e('Пәтер құны', 'financial-calculator'); ?></div>
                        <div class="value-display">
                            <span id="home-value-display-<?php echo esc_attr($unique_id); ?>">25,000,000</span>₸
                        </div>
                        <input type="range" id="home-value-slider-<?php echo esc_attr($unique_id); ?>" min="5000000" max="100000000" value="25000000" class="slider">
                        <input type="hidden" id="home-value-<?php echo esc_attr($unique_id); ?>" value="25000000">
                    </div>

                    <div class="value-box half">
                        <div class="value-label"><?php _e('Кредит мерзімі', 'financial-calculator'); ?></div>
                        <div class="value-display">
                            <span id="mortgage-term-years-display-<?php echo esc_attr($unique_id); ?>">15</span> <?php _e('жыл', 'financial-calculator'); ?>
                        </div>
                        <input type="range" id="mortgage-term-years-slider-<?php echo esc_attr($unique_id); ?>" min="5" max="25" value="15" class="slider">
                        <input type="hidden" id="mortgage-term-years-<?php echo esc_attr($unique_id); ?>" value="15">
                    </div>
                </div>

                <div class="results-grid">
                    <div class="result-item">
                        <div class="result-label"><?php _e('Минималды алғашқы жарна', 'financial-calculator'); ?></div>
                        <div class="result-value">
                            <span id="min-down-payment-<?php echo esc_attr($unique_id); ?>">5,000,000</span> ₸
                        </div>
                    </div>
                    <div class="result-item">
                        <div class="result-label"><?php _e('Айлық төлем', 'financial-calculator'); ?></div>
                        <div class="result-value">
                            <span id="mortgage-payment-<?php echo esc_attr($unique_id); ?>">285,432</span> ₸
                        </div>
                    </div>
                    <div class="result-item">
                        <div class="result-label"><?php _e('Кредит сомасы', 'financial-calculator'); ?></div>
                        <div class="result-value">
                            <span id="loan-amount-<?php echo esc_attr($unique_id); ?>">20,000,000</span> ₸
                        </div>
                    </div>
                    <div class="result-item">
                        <div class="result-label"><?php _e('Жылдық % мөлшерлемесі', 'financial-calculator'); ?></div>
                        <div class="result-value">
                            <span id="annual-rate-<?php echo esc_attr($unique_id); ?>">16.50</span> %
                        </div>
                    </div>
                </div>
            </div>

            <!-- Deposit Calculator -->
            <div class="calculator deposit-calculator">
                <div class="value-box">
                    <div class="value-label"><?php _e('Алғашқы салым сомасы', 'financial-calculator'); ?></div>
                    <div class="value-display">
                        <span id="deposit-amount-display-<?php echo esc_attr($unique_id); ?>">1,000,000</span>₸
                    </div>
                    <input type="range" id="deposit-amount-slider-<?php echo esc_attr($unique_id); ?>" min="50000" max="50000000" value="1000000" class="slider">
                    <input type="hidden" id="deposit-amount-<?php echo esc_attr($unique_id); ?>" value="1000000">
                </div>

                <div class="input-row">
                    <div class="value-box half">
                        <div class="value-label"><?php _e('Жылдық пайыз мөлшерлемесі', 'financial-calculator'); ?></div>
                        <div class="value-display">
                            <span id="deposit-rate-display-<?php echo esc_attr($unique_id); ?>">14</span>%
                        </div>
                        <input type="range" id="deposit-rate-slider-<?php echo esc_attr($unique_id); ?>" min="5" max="20" value="14" step="0.1" class="slider">
                        <input type="hidden" id="deposit-rate-<?php echo esc_attr($unique_id); ?>" value="14">
                    </div>

                    <div class="value-box half">
                        <div class="value-label"><?php _e('Мерзімі', 'financial-calculator'); ?></div>
                        <div class="value-display">
                            <span id="deposit-term-display-<?php echo esc_attr($unique_id); ?>">12</span> <?php _e('ай', 'financial-calculator'); ?>
                        </div>
                        <input type="range" id="deposit-term-slider-<?php echo esc_attr($unique_id); ?>" min="3" max="60" value="12" class="slider">
                        <input type="hidden" id="deposit-term-<?php echo esc_attr($unique_id); ?>" value="12">
                    </div>
                </div>

                <div class="results-grid">
                    <div class="result-item">
                        <div class="result-label"><?php _e('Айлық пайыз табысы', 'financial-calculator'); ?></div>
                        <div class="result-value">
                            <span id="monthly-interest-<?php echo esc_attr($unique_id); ?>">11,667</span> ₸
                        </div>
                    </div>
                    <div class="result-item">
                        <div class="result-label"><?php _e('Мерзім аяғындағы пайыз табысы', 'financial-calculator'); ?></div>
                        <div class="result-value">
                            <span id="total-interest-<?php echo esc_attr($unique_id); ?>">140,000</span> ₸
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}