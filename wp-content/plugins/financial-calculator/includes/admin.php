<?php
/**
 * Financial Calculator Admin Interface
 *
 * @package FinancialCalculator
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Admin page callback function
 */
function financial_calculator_admin_page() {
    // Handle form submission
    if (isset($_POST['submit']) && check_admin_referer('financial_calc_settings', 'financial_calc_nonce')) {
        // Save settings here if needed
        echo '<div class="notice notice-success is-dismissible"><p>' . __('Settings saved successfully!', 'financial-calculator') . '</p></div>';
    }
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

        <div class="card" style="max-width: 800px;">
            <h2><?php _e('How to Use', 'financial-calculator'); ?></h2>
            <p><?php _e('Use the following shortcodes to display calculators on your pages or posts:', 'financial-calculator'); ?></p>

            <h3><?php _e('Available Shortcodes', 'financial-calculator'); ?></h3>
            <table class="widefat">
                <thead>
                    <tr>
                        <th><?php _e('Shortcode', 'financial-calculator'); ?></th>
                        <th><?php _e('Description', 'financial-calculator'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><code>[financial_calculator]</code></td>
                        <td><?php _e('Combined calculator with tabs for Credit, Mortgage, and Deposit calculations', 'financial-calculator'); ?></td>
                    </tr>
                    <tr>
                        <td><code>[kredit_calculator]</code></td>
                        <td><?php _e('Credit calculator only', 'financial-calculator'); ?></td>
                    </tr>
                    <tr>
                        <td><code>[ipoteka_calculator]</code></td>
                        <td><?php _e('Mortgage calculator only', 'financial-calculator'); ?></td>
                    </tr>
                    <tr>
                        <td><code>[emanet_calculator]</code></td>
                        <td><?php _e('Deposit calculator only', 'financial-calculator'); ?></td>
                    </tr>
                </tbody>
            </table>

            <h3><?php _e('Calculator Features', 'financial-calculator'); ?></h3>
            <ul>
                <li><?php _e('Interactive sliders with real-time calculations', 'financial-calculator'); ?></li>
                <li><?php _e('Responsive design for mobile devices', 'financial-calculator'); ?></li>
                <li><?php _e('Kazakh language interface', 'financial-calculator'); ?></li>
                <li><?php _e('Kazakhstan Tenge (₸) currency support', 'financial-calculator'); ?></li>
                <li><?php _e('Modern UI with hover effects', 'financial-calculator'); ?></li>
                <li><?php _e('Support for multiple calculators on same page', 'financial-calculator'); ?></li>
            </ul>

            <h3><?php _e('Calculator Types', 'financial-calculator'); ?></h3>
            <div style="margin: 20px 0;">
                <h4><?php _e('Credit Calculator', 'financial-calculator'); ?></h4>
                <p><?php _e('Calculate monthly payments for personal loans with customizable amount (100,000 - 10,000,000 ₸), interest rate (5-35%), and term (3-360 months).', 'financial-calculator'); ?></p>

                <h4><?php _e('Mortgage Calculator', 'financial-calculator'); ?></h4>
                <p><?php _e('Calculate mortgage payments with down payment percentage (10-50%), property value (5,000,000 - 100,000,000 ₸), and loan term (5-25 years). Uses 16.5% fixed annual rate typical for Kazakhstan.', 'financial-calculator'); ?></p>

                <h4><?php _e('Deposit Calculator', 'financial-calculator'); ?></h4>
                <p><?php _e('Calculate deposit returns with initial amount (50,000 - 50,000,000 ₸), interest rate (5-20%), and term (3-60 months).', 'financial-calculator'); ?></p>
            </div>
        </div>

        <div class="card" style="max-width: 800px; margin-top: 20px;">
            <h2><?php _e('Plugin Information', 'financial-calculator'); ?></h2>
            <table class="form-table">
                <tr>
                    <th scope="row"><?php _e('Plugin Version', 'financial-calculator'); ?></th>
                    <td><?php echo esc_html(FINANCIAL_CALC_VERSION); ?></td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Developer', 'financial-calculator'); ?></th>
                    <td>Victor Fazli - <a href="https://coder-fazli.github.io" target="_blank">coder-fazli.github.io</a></td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('GitHub Repository', 'financial-calculator'); ?></th>
                    <td><a href="https://github.com/Coder-fazli/bankKz" target="_blank">github.com/Coder-fazli/bankKz</a></td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Support', 'financial-calculator'); ?></th>
                    <td><?php _e('For support, please create an issue on the GitHub repository.', 'financial-calculator'); ?></td>
                </tr>
            </table>
        </div>

        <div class="card" style="max-width: 800px; margin-top: 20px;">
            <h2><?php _e('Demo', 'financial-calculator'); ?></h2>
            <p><?php _e('Here is a preview of the combined financial calculator:', 'financial-calculator'); ?></p>
            <div style="border: 1px solid #ddd; padding: 20px; background: #f9f9f9; border-radius: 5px;">
                <?php echo do_shortcode('[financial_calculator]'); ?>
            </div>
        </div>
    </div>

    <style>
    .wrap .card {
        background: #fff;
        border: 1px solid #ccd0d4;
        border-radius: 4px;
        padding: 20px;
        margin: 20px 0;
        box-shadow: 0 1px 1px rgba(0,0,0,.04);
    }
    .wrap .card h2 {
        margin-top: 0;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }
    .wrap .card code {
        background: #f1f1f1;
        padding: 2px 6px;
        border-radius: 3px;
        font-family: Consolas, Monaco, monospace;
    }
    .wrap .card table.widefat {
        margin: 15px 0;
    }
    .wrap .card ul {
        list-style-type: disc;
        margin-left: 20px;
    }
    .wrap .card ul li {
        margin: 5px 0;
    }
    </style>
    <?php
}