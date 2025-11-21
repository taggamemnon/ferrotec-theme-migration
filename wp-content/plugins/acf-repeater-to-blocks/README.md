# ACF Repeater to Blocks Migration Plugin

A WordPress plugin for safely migrating ACF repeater field data to Gutenberg ACF blocks with full backup and rollback capabilities.

## Overview

This plugin provides a complete solution for migrating content from legacy ACF repeater fields (`rows`) to modern Gutenberg ACF blocks (`acf/content-section`). It's specifically designed for the Layers Gutenberg theme migration but can be adapted for other ACF repeater to block migrations.

## Features

### 🔒 Safe Migration
- **Automatic Backups**: Creates complete backups of post content and metadata before any migration
- **One-Click Rollback**: Restore posts to their pre-migration state with a single click
- **Preview Mode**: See exactly what the migrated content will look like before committing
- **Dry Run**: Test migrations without making any changes to the database

### 📊 Comprehensive Logging
- **Migration Statistics**: Track total migrations, successes, errors, and rows migrated
- **Detailed Logs**: Every migration operation is logged with timestamps and messages
- **CSV Export**: Export migration logs for reporting and auditing
- **Recent Activity**: View the 10 most recent migration operations at a glance

### 🎯 Batch Processing
- **Multi-Page Migration**: Select and migrate multiple pages at once
- **Progress Tracking**: Monitor migration status for each page
- **Error Handling**: Gracefully handles errors and continues processing remaining pages
- **Performance**: Processes migrations efficiently without timeout issues

### 🖥️ User-Friendly Admin Interface
- **Visual Dashboard**: See migration statistics and page status at a glance
- **Easy Selection**: Checkbox interface for selecting pages to migrate
- **Smart Filtering**: Shows only unmigrated pages with repeater data
- **Direct Links**: Quick access to edit pages and view migration logs

## Installation

1. Upload the plugin folder to `/wp-content/plugins/acf-repeater-to-blocks/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Navigate to **Tools > ACF Migration** to access the dashboard

### Requirements

- WordPress 5.0 or higher
- PHP 7.4 or higher
- Advanced Custom Fields PRO 5.8 or higher
- Layers Gutenberg theme (or theme with `acf/content-section` block registered)

## Usage

### Basic Migration Workflow

1. **Review Statistics**
   - Navigate to Tools > ACF Migration
   - Review the dashboard statistics showing total pages with repeater data

2. **Preview Individual Pages**
   - Click the "Preview" button next to any page
   - Review the converted Gutenberg block markup
   - Verify field mappings are correct

3. **Migrate Pages**
   - Select one or more pages using checkboxes
   - Click "Migrate Selected Pages"
   - Wait for success confirmation

4. **Verify Results**
   - Edit the migrated page in WordPress
   - Confirm blocks appear correctly in the Gutenberg editor
   - Check frontend rendering

5. **Rollback if Needed**
   - If issues are found, click the "Rollback" button
   - Page will be restored to its pre-migration state
   - Make corrections and try again

### Field Mappings

The plugin automatically converts ACF repeater fields to block attributes:

| Repeater Field | Block Attribute | Description |
|----------------|----------------|-------------|
| `content` | `content` | HTML content for the section |
| `background-color` | `background_color` | Background color value |
| `background-class` | `background_class` | CSS class name |

## Technical Details

### Database Schema

#### Backups Table (`wp_acf_migration_backups`)
```sql
CREATE TABLE wp_acf_migration_backups (
    id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    post_id BIGINT(20) UNSIGNED NOT NULL,
    post_content_backup LONGTEXT NOT NULL,
    postmeta_backup LONGTEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY post_id (post_id)
);
```

#### Log Table (`wp_acf_migration_log`)
```sql
CREATE TABLE wp_acf_migration_log (
    id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    post_id BIGINT(20) UNSIGNED NOT NULL,
    status VARCHAR(20) NOT NULL,
    rows_migrated INT DEFAULT 0,
    message TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY post_id (post_id),
    KEY status (status)
);
```

### Plugin Architecture

```
acf-repeater-to-blocks/
├── acf-repeater-to-blocks.php           # Main plugin file, activation hooks
├── admin/
│   ├── class-admin-page.php             # Admin interface controller
│   └── views/
│       └── migration-dashboard.php      # Dashboard template
└── includes/
    ├── class-backup-manager.php         # Backup/restore operations
    ├── class-migration-logger.php       # Logging and statistics
    └── class-migration-engine.php       # Core migration logic
```

### Class Documentation

#### ACF_R2B_Backup_Manager

Handles all backup and restore operations.

**Methods:**
- `backup_post($post_id)` - Creates backup of post content and repeater metadata
- `restore_post($post_id)` - Restores post from most recent backup
- `delete_backup($post_id)` - Removes backup for a post
- `has_backup($post_id)` - Checks if backup exists
- `get_backup_info($post_id)` - Returns backup metadata
- `get_all_backups()` - Lists all available backups

**Example:**
```php
// Create backup before migration
$backup_id = ACF_R2B_Backup_Manager::backup_post(123);

// Restore if something goes wrong
ACF_R2B_Backup_Manager::restore_post(123);
```

#### ACF_R2B_Migration_Engine

Core migration logic for converting repeater fields to blocks.

**Methods:**
- `migrate_page($post_id, $dry_run = false)` - Migrates single page
- `batch_migrate($post_ids, $batch_size = 10)` - Migrates multiple pages
- `get_pages_with_repeater()` - Finds all pages with repeater data
- `get_unmigrated_pages()` - Finds pages not yet migrated
- `convert_row_to_block($row)` - Converts single row to block format

**Example:**
```php
$engine = new ACF_R2B_Migration_Engine();

// Preview migration (dry run)
$result = $engine->migrate_page(123, true);
echo $result['preview_content'];

// Actual migration
$result = $engine->migrate_page(123, false);
if ($result['success']) {
    echo "Migrated {$result['rows_migrated']} rows";
}
```

#### ACF_R2B_Migration_Logger

Tracks all migration operations and provides statistics.

**Methods:**
- `log_migration_start($post_id)` - Records migration start
- `log_migration_success($post_id, $data)` - Records successful migration
- `log_migration_error($post_id, $error)` - Records migration error
- `get_migration_log($post_id)` - Gets log for specific post
- `get_all_logs($args)` - Gets filtered log entries
- `get_statistics()` - Returns migration statistics
- `export_log_csv()` - Exports logs to CSV
- `clear_old_logs($days)` - Removes logs older than specified days

**Example:**
```php
// Log migration
ACF_R2B_Migration_Logger::log_migration_start(123);
ACF_R2B_Migration_Logger::log_migration_success(123, array(
    'rows_migrated' => 5
));

// Get statistics
$stats = ACF_R2B_Migration_Logger::get_statistics();
echo "Total migrations: {$stats['total_migrations']}";
echo "Success rate: {$stats['successful']}/{$stats['total_migrations']}";
```

### Gutenberg Block Format

The plugin converts repeater rows to Gutenberg block comments with JSON-encoded attributes:

**Input (ACF Repeater):**
```php
rows_0_content = "<h2>Hello World</h2>"
rows_0_background-color = "#f5f5f5"
rows_0_background-class = "gray-bg"
```

**Output (Gutenberg Block):**
```html
<!-- wp:acf/content-section {"id":"block_abc123","name":"acf/content-section","data":{"content":"<h2>Hello World<\/h2>","_content":"field_content_section_content","background_class":"gray-bg","_background_class":"field_content_section_bg_class","background_color":"#f5f5f5","_background_color":"field_content_section_bg_color"},"mode":"preview"} /-->
```

### Security Features

- **Nonce Verification**: All form submissions require valid nonces
- **Capability Checks**: Only users with `manage_options` can access migration tools
- **Input Sanitization**: All user inputs are sanitized and validated
- **SQL Injection Prevention**: Uses WordPress database API with prepared statements
- **XSS Protection**: Output is properly escaped

## Hooks and Filters

### Actions

- `acf_r2b_before_migrate` - Fires before migration starts
- `acf_r2b_after_migrate` - Fires after successful migration
- `acf_r2b_migration_error` - Fires when migration error occurs

**Example:**
```php
add_action('acf_r2b_after_migrate', function($post_id, $result) {
    error_log("Post {$post_id} migrated: {$result['rows_migrated']} rows");
}, 10, 2);
```

### Filters

- `acf_r2b_block_attributes` - Modify block attributes before saving
- `acf_r2b_batch_size` - Change batch processing size
- `acf_r2b_field_mapping` - Customize field name mappings

**Example:**
```php
add_filter('acf_r2b_field_mapping', function($mapping) {
    $mapping['custom-field'] = 'custom_attribute';
    return $mapping;
});
```

## Troubleshooting

### Migration Fails with Timeout

**Solution**: Reduce batch size or migrate pages individually
```php
add_filter('acf_r2b_batch_size', function() {
    return 5; // Reduce from default 10
});
```

### Blocks Not Appearing in Editor

**Possible Causes:**
1. ACF block not registered - Check theme's `functions.php`
2. ACF JSON files missing - Verify `acf-json/` directory
3. ACF PRO not activated - Ensure ACF PRO is active

### Rollback Not Working

**Check:**
1. Backup exists in database: `SELECT * FROM wp_acf_migration_backups WHERE post_id = X`
2. User has `manage_options` capability
3. Check error logs for specific error messages

### Preview Shows Incorrect Data

**Verify:**
1. Field mappings match your ACF repeater structure
2. Custom field names in repeater match plugin expectations
3. Check migration logs for warnings

## Development

### Running in Debug Mode

Enable WordPress debug mode to see detailed error messages:

```php
// In wp-config.php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```

### Testing Migrations

Always test on a staging site first:

1. Clone production site to staging
2. Activate Layers Gutenberg theme
3. Activate migration plugin
4. Test migration on sample pages
5. Verify frontend and editor rendering
6. Test rollback functionality

### Extending the Plugin

To add support for additional fields:

1. Modify `class-migration-engine.php:convert_row_to_block()`
2. Add field mappings in `$attrs['data']` array
3. Update block template to render new fields

## FAQ

**Q: Will this plugin work with other ACF repeater fields?**
A: It's specifically designed for the `rows` repeater and `acf/content-section` block, but can be adapted for other repeater-to-block migrations by modifying the field mappings.

**Q: Can I migrate content back to repeater fields?**
A: Not directly. Use the rollback feature to restore the original repeater data from backup.

**Q: What happens to the original repeater data after migration?**
A: The repeater metadata is preserved in the backup table. You can optionally delete it after confirming migration success.

**Q: Can I migrate custom post types?**
A: Currently supports pages only. Modify `get_pages_with_repeater()` to include custom post types.

**Q: How long are backups stored?**
A: Indefinitely. Use `ACF_R2B_Migration_Logger::clear_old_logs()` to remove old backups programmatically.

## Changelog

### Version 1.0.0 (2025)
- Initial release
- Backup and restore functionality
- Migration engine with dry run support
- Comprehensive logging and statistics
- Admin dashboard interface
- Batch processing support

## Support

For issues or feature requests, please contact the development team.

## License

This plugin is proprietary software developed for the Ferrotec website migration project.
