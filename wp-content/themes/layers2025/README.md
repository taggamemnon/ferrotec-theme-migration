# Layers 2025 Theme

Modern unified WordPress theme for Ferrotec product lines.

## Description

Layers 2025 replaces the legacy layers2 parent theme and five child themes with a single, maintainable solution. This theme features:

- Bootstrap 4 grid system
- WooCommerce support
- Advanced Custom Fields integration
- Responsive design
- Modern WordPress best practices

## Installation

1. Upload the `layers2025` folder to `/wp-content/themes/`
2. Activate the theme through the 'Themes' menu in WordPress
3. Install and activate required plugins:
   - Advanced Custom Fields Pro
   - WooCommerce
   - Relevanssi (for enhanced search)

## Required Plugins

- **Advanced Custom Fields Pro** - For custom field management
- **WooCommerce** - For e-commerce functionality
- **Relevanssi** (optional) - For enhanced search capabilities

## Recommended Plugins

- **Ferrotec WooCommerce** - Custom WooCommerce functionality plugin (companion plugin)

## Theme Structure

```
layers2025/
├── assets/              # CSS, JS, fonts, images
├── inc/                 # Theme setup and helper functions
├── page-templates/      # Custom page templates
├── template-parts/      # Reusable template parts
├── functions.php        # Theme setup
└── style.css            # Main stylesheet
```

## Customization

### Child Theme

If you need to customize this theme, create a child theme rather than editing the theme files directly.

### CSS Customization

Custom CSS can be added through:
1. Appearance → Customize → Additional CSS
2. A child theme's style.css
3. Custom CSS plugin

### PHP Customization

Use a child theme for any PHP customizations to preserve changes during theme updates.

## Navigation Menus

The theme supports three menu locations:

1. **Primary Menu** - Main site navigation
2. **Mobile Menu** - Mobile-optimized navigation
3. **Footer Menu** - Footer links

Configure menus at: Appearance → Menus

## Widget Areas

The theme includes four widget areas:

1. **Sidebar** - Main sidebar area
2. **Footer 1** - First footer column
3. **Footer 2** - Second footer column
4. **Footer 3** - Third footer column

## Development

### Building Assets

If you're developing the theme, you may need to compile assets:

```bash
# Install dependencies (if using build tools)
npm install

# Compile assets (if using build tools)
npm run build
```

### Coding Standards

This theme follows WordPress Coding Standards:
- [PHP Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/)
- [CSS Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/css/)
- [JavaScript Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/javascript/)

## Support

For support, please contact the Ferrotec development team.

## Changelog

### 1.0.0
- Initial release
- Unified theme replacing layers2 parent + 5 child themes
- Bootstrap 4 grid integration
- WooCommerce support
- ACF integration

## License

This theme is licensed under the GPL v2 or later.

## Credits

- Developed by Ferrotec
- Based on WordPress best practices
- Bootstrap 4 grid system
