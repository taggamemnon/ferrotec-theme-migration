# Ferrotec Theme Migration - Project Plan

## Overview
Migrating old Ferrotec theme structure to a modern WordPress theme.

## Directory Structure

### Reference Themes (DO NOT MODIFY)
- `old-themes/layers2/` - Parent theme based on Underscores starter theme
- `old-themes/child-corporate/` - Corporate child theme
- `old-themes/child-ferrofluid/` - Ferrofluid products child theme
- `old-themes/child-meivac/` - Meivac products child theme
- `old-themes/child-seals/` - Seals products child theme
- `old-themes/child-thermalelectric/` - Thermal Electric products child theme

### New Theme Location
- `wp-content/themes/layers2025/` - NEW unified theme

## Goals
<!-- TODO: Define specific migration goals -->
- [ ] Consolidate multiple child themes into single modern theme
- [ ] Modernize codebase (PHP 8.x compatibility, modern WordPress standards)
- [ ] Improve WooCommerce integration
- [ ] Clean up and organize CSS/JS assets
- [ ] Document custom functionality

## Key Features to Migrate
<!-- Based on old themes analysis -->
- Custom product templates (Thermal Electric, Vacuum Furnace, Ferrofluid)
- WooCommerce customizations
- Custom post types (Press, Resources)
- Product calculators and specification tables
- Multi-site/multi-brand support

## Technical Requirements
- WordPress 6.x+
- PHP 8.0+
- WooCommerce compatible
- ACF Pro (Advanced Custom Fields used extensively)

## Implementation Steps
<!-- TODO: Define step-by-step migration process -->

## Notes
- Original themes heavily customized from Underscores starter
- Uses Bootstrap framework
- Custom product listing/filtering functionality
- Multiple specialized product page templates
