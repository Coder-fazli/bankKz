<?php
/**
 * Financial Calculator Uninstall
 *
 * @package FinancialCalculator
 */

// If uninstall not called from WordPress, then exit
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Delete plugin options
delete_option('financial_calc_version');

// Clear any cached data that has been removed
wp_cache_flush();