# Financial Calculator WordPress Plugin

A comprehensive financial calculator plugin designed for Kazakhstan banking websites with support for credit, mortgage, and deposit calculations.

## Features

- **Multiple Calculator Types**:
  - Credit Calculator (Personal loans)
  - Mortgage Calculator (Ipoteka)
  - Deposit Calculator (Emanet)
  - Combined calculator with tabs

- **Kazakhstan Localization**:
  - Kazakh language interface
  - Kazakhstan Tenge (₸) currency
  - Local banking rates and terms

- **User Experience**:
  - Interactive sliders with real-time calculations
  - Responsive design for mobile devices
  - Modern UI with smooth animations
  - Support for multiple calculators on same page

## Installation

1. Upload the `financial-calculator` folder to `/wp-content/plugins/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Use shortcodes to display calculators on your pages

## Shortcodes

| Shortcode | Description |
|-----------|-------------|
| `[financial_calculator]` | Combined calculator with tabs |
| `[kredit_calculator]` | Credit calculator only |
| `[ipoteka_calculator]` | Mortgage calculator only |
| `[emanet_calculator]` | Deposit calculator only |

## Calculator Specifications

### Credit Calculator
- **Amount**: 100,000 - 10,000,000 ₸
- **Interest Rate**: 5% - 35% annually
- **Term**: 3 - 360 months
- **Output**: Monthly payment amount

### Mortgage Calculator
- **Property Value**: 5,000,000 - 100,000,000 ₸
- **Down Payment**: 10% - 50%
- **Term**: 5 - 25 years
- **Interest Rate**: 16.5% (fixed, typical for Kazakhstan)
- **Output**: Minimum down payment, monthly payment, loan amount

### Deposit Calculator
- **Amount**: 50,000 - 50,000,000 ₸
- **Interest Rate**: 5% - 20% annually
- **Term**: 3 - 60 months
- **Output**: Monthly interest income, total interest

## Technical Details

- **Version**: 1.0.0
- **WordPress Version**: 5.0+
- **PHP Version**: 7.4+
- **Dependencies**: jQuery (included with WordPress)

## File Structure

```
financial-calculator/
├── financial-calculator.php    # Main plugin file
├── README.md                  # This file
├── assets/
│   ├── financial-calculator.css    # Plugin styles
│   └── financial-calculator.js     # Plugin JavaScript
├── includes/
│   ├── shortcodes.php        # Shortcode implementations
│   └── admin.php             # Admin interface
└── templates/                # Template files (future use)
```

## Development

This plugin was created for the BankKz project (https://github.com/Coder-fazli/bankKz) and adapted from the Budgedostu calculator system.

### Customization

To customize calculator parameters, edit the shortcode functions in `includes/shortcodes.php`:
- Adjust min/max values for sliders
- Modify default values
- Change interest rates
- Update currency symbols or formatting

### Styling

Custom styles can be added to your theme or child theme to override plugin styles. All calculator elements use the `.financial-calculator-widget` class namespace.

## Support

For support and bug reports:
- GitHub Issues: https://github.com/Coder-fazli/bankKz/issues
- Developer: Victor Fazli - https://coder-fazli.github.io

## License

GPL v2 or later

## Changelog

### 1.0.0
- Initial release
- Credit, mortgage, and deposit calculators
- Kazakh localization
- Mobile responsive design
- WordPress admin integration