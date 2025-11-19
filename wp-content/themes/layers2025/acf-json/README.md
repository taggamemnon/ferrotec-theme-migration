# ACF Field Groups - Theme (Presentation Layer)

This directory contains ACF field groups for **theme-specific presentation fields** only.

## ⚠️ Important: Field Separation

**THEME fields (this directory):**
- Page banners (images, colors, text)
- Flexible content rows (page layout)
- Resource/event display fields
- Theme-specific presentation logic

**PLUGIN fields** (`/wp-content/plugins/ftc-product-ui/acf-json/`):
- Product specifications (thermal, seal, ferrofluid, meivac)
- Product files (CAD, datasheets)
- Performance data, dimensions
- All WooCommerce product-related fields

## Field Groups Stored Here

### `group_page_banner_fields.json`
Page banner configuration:
- `page_banner_image` - Desktop banner image
- `page_banner_mobile_image` - Mobile banner image
- `page_banner_color` - Background color
- `page_banner_text_color` - Text color
- `page_banner_text` - Banner content (WYSIWYG)
- `page_disable_banner` - Toggle banner on/off

**Location:** Pages and archive pages

### `group_page_content_rows.json`
Flexible content rows (replaces old "rows" repeater):
- `page_content_rows` (Repeater)
  - `content` (WYSIWYG) - Row content
  - `background_color` (Color Picker) - Background color
  - `background_class` (Text) - CSS class

**Location:** Pages

### `group_resource_fields.json`
Resources, events, and news:
- `resource_url` - Download URL
- `resource_category` - Type selection
- `resource_gated` - Require form fill
- `event_start_date` / `event_end_date` - Event dates
- `event_promotional_url` / `event_registration_url` - Event links
- `news_publication_name` - Publication name
- `news_subhead` - Article subheading
- `news_url` - External article link

**Location:** Resource, Event, Press post types

## Why Separate Theme & Plugin Fields?

### Advantages

1. **Portability**: Product data remains independent of theme
2. **Theme Swapping**: Change theme without affecting product structure
3. **Version Control**: Track presentation changes separately from data schema
4. **Deployment**: Update theme without touching product data
5. **Clarity**: Clear separation of concerns (presentation vs. business logic)

### How It Works

Both theme and plugin register ACF JSON save/load points:

```php
// THEME (functions.php) - Priority 5
add_filter( 'acf/settings/save_json', 'layers2025_acf_json_save_point', 5 );
add_filter( 'acf/settings/load_json', 'layers2025_acf_json_load_point', 5 );

// PLUGIN (ftc-product-ui.php) - Priority 10
add_filter( 'acf/settings/save_json', array( $this, 'acf_json_save_point' ), 10 );
add_filter( 'acf/settings/load_json', array( $this, 'acf_json_load_point' ), 10 );
```

**Result:** ACF loads field groups from BOTH locations with no conflicts.

## Gutenberg Blocks

The theme also uses ACF blocks to replace the old repeater pattern:

**Content Section Block** (`blocks/content-section/`)
- Modern Gutenberg editing experience
- Replaces old `rows` repeater field
- Built with ACF `acf_register_block_type()`
- Registered in `functions.php`

## Migration

Theme fields will be migrated in **Phase 3 (Week 5)** after product fields are complete.

See `ACF_UNIFIED_SCHEMA.md` for complete field documentation.

---

**Last Updated:** 2025-11-19
