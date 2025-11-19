# Gutenberg ACF Blocks Refactor Plan
## Incremental Migration from Repeater Fields to Gutenberg Blocks

**Created:** November 19, 2025
**Goal:** Migrate page content from ACF repeater fields to Gutenberg ACF blocks
**Approach:** Incremental refactor with new theme and migration script

---

## Executive Summary

This plan outlines a conservative, step-by-step approach to migrate from the legacy ACF repeater field system to modern Gutenberg ACF blocks. We will:

1. Create a new theme `layers-gutenberg` (copy of `layers2025`)
2. Ensure it properly handles Gutenberg block content
3. Create a migration script to convert existing repeater data to Gutenberg blocks
4. Test thoroughly before broader rollout

This approach keeps the original theme intact and allows for safe testing and rollback.

---

## Current State Analysis

### Old Theme: `layers2`

**ACF Field Structure:**
- **Field Group:** "Rows" (group_54b84d6c6b5e1)
- **Field Type:** Repeater
- **Field Name:** `rows`
- **Location:** All pages (post_type == page)

**Sub-fields:**
1. `background-class` (text) - CSS class for styling
2. `background-color` (color_picker) - Background color value
3. `content` (wysiwyg) - HTML content

**Display Location:**
- Template: `old-themes/layers2/content-page.php` (lines 43-62)
- Rendering logic:
  ```php
  <?php if (have_rows('rows')): ?>
      <?php while (have_rows('rows')): the_row();
          $content  = get_sub_field( 'content' );
          $bk_color = get_sub_field('background-color');
          $bk_class = get_sub_field('background-class');
      ?>
          <div class="container-wrapper content-padding <?php echo $bk_class ?>">
              <div class="container">
                  <?php echo $content; ?>
              </div>
          </div>
      <?php endwhile; ?>
  <?php endif; ?>
  ```

**Data Storage:**
- Stored in postmeta table as serialized arrays
- Each row is a separate meta entry with indexed keys
- Example keys: `rows_0_content`, `rows_0_background-class`, `rows_0_background-color`, `rows_1_content`, etc.

### New Theme: `layers2025`

**ACF Block Structure:**
- **Block Name:** `content-section`
- **Block Type:** ACF Gutenberg Block
- **Registration:** `functions.php` (lines 74-112)
- **Template:** `blocks/content-section/content-section.php`

**Block Fields:**
- **Field Group:** "Content Section Block" (group_content_section_block)
- Fields:
  1. `content` (wysiwyg) - HTML content
  2. `background_class` (text) - CSS class (note: underscore)
  3. `background_color` (color_picker) - Color value (note: underscore)

**Display Location:**
- Rendered via Gutenberg block system
- Template: `blocks/content-section/content-section.php`
- Supports block features: align (wide, full), anchor, custom class

**Data Storage:**
- Stored in post_content as HTML comments (Gutenberg block syntax)
- Example:
  ```html
  <!-- wp:acf/content-section {"id":"block_abc123","name":"acf/content-section","data":{"content":"<p>Hello</p>","background_class":"bkg-gradient-green","_background_class":"field_content_section_bg_class","background_color":"#ffffff","_background_color":"field_content_section_bg_color"},"mode":"preview"} /-->
  ```

---

## Phase 1: Create `layers-gutenberg` Theme

### Step 1.1: Copy Theme Structure

**Action:** Create new theme folder as a copy of `layers2025`

**Commands:**
```bash
cd /home/user/ferrotec-theme-migration/wp-content/themes/
cp -r layers2025 layers-gutenberg
```

**Files to Copy:** All files and directories from `layers2025/`

### Step 1.2: Update Theme Metadata

**File:** `layers-gutenberg/style.css`

**Changes:**
```css
/*
Theme Name: Layers Gutenberg
Theme URI: https://ferrotec.com
Author: AUC
Author URI: https://ferrotec.com
Description: Gutenberg block-based theme for Ferrotec (migration step from layers2025)
Version: 1.0.0
Requires at least: 6.0
Tested up to: 6.4
Requires PHP: 7.4
License: GNU General Public License v2 or later
License URI: LICENSE
Text Domain: layers-gutenberg
Tags: gutenberg, blocks, woocommerce, bootstrap
*/
```

### Step 1.3: Update Theme Constants

**File:** `layers-gutenberg/functions.php`

**Changes:**
```php
// Update line 17-19
define( 'LAYERS_GUTENBERG_VERSION', '1.0.0' );
define( 'LAYERS_GUTENBERG_DIR', get_template_directory() );
define( 'LAYERS_GUTENBERG_URI', get_template_directory_uri() );
```

**Find and replace throughout:**
- `LAYERS2025_` → `LAYERS_GUTENBERG_`
- `layers2025` → `layers-gutenberg`
- Text domain: `'layers2025'` → `'layers-gutenberg'`

### Step 1.4: Update ACF JSON Path

**File:** `layers-gutenberg/functions.php`

**Changes:**
```php
// Update lines 133-145
function layers_gutenberg_acf_json_save_point( $path ) {
    return LAYERS_GUTENBERG_DIR . '/acf-json';
}
add_filter( 'acf/settings/save_json', 'layers_gutenberg_acf_json_save_point', 5 );

function layers_gutenberg_acf_json_load_point( $paths ) {
    $paths[] = LAYERS_GUTENBERG_DIR . '/acf-json';
    return $paths;
}
add_filter( 'acf/settings/load_json', 'layers_gutenberg_acf_json_load_point', 5 );
```

### Step 1.5: Update Block Registration

**File:** `layers-gutenberg/functions.php`

**Changes:**
```php
// Update line 74
function layers_gutenberg_register_acf_blocks() {
    // ... rest of function stays the same
}
add_action( 'acf/init', 'layers_gutenberg_register_acf_blocks' );
```

### Step 1.6: Verify Template Files

**Files to check:**
- `page.php` - Should render Gutenberg blocks via `the_content()`
- `single.php` - Should render Gutenberg blocks
- `template-parts/content/content-page.php` - Should use `the_content()`

**Expected:** All templates should call `the_content()` which will render Gutenberg blocks

---

## Phase 2: Create Migration Script

### Step 2.1: Create Migration Plugin Structure

**Directory:** `/home/user/ferrotec-theme-migration/wp-content/plugins/acf-repeater-to-blocks/`

**Files to create:**
```
acf-repeater-to-blocks/
├── acf-repeater-to-blocks.php (main plugin file)
├── includes/
│   ├── class-migration-engine.php
│   ├── class-migration-logger.php
│   └── class-backup-manager.php
├── admin/
│   ├── class-admin-page.php
│   └── views/
│       └── migration-dashboard.php
└── README.md
```

### Step 2.2: Main Plugin File

**File:** `acf-repeater-to-blocks/acf-repeater-to-blocks.php`

**Contents:**
```php
<?php
/**
 * Plugin Name: ACF Repeater to Blocks Migration
 * Plugin URI: https://ferrotec.com
 * Description: Migrates ACF repeater field data to Gutenberg blocks
 * Version: 1.0.0
 * Author: AUC
 * License: GPL v2 or later
 * Text Domain: acf-repeater-to-blocks
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define plugin constants
define( 'ACF_R2B_VERSION', '1.0.0' );
define( 'ACF_R2B_DIR', plugin_dir_path( __FILE__ ) );
define( 'ACF_R2B_URL', plugin_dir_url( __FILE__ ) );

// Load dependencies
require_once ACF_R2B_DIR . 'includes/class-migration-engine.php';
require_once ACF_R2B_DIR . 'includes/class-migration-logger.php';
require_once ACF_R2B_DIR . 'includes/class-backup-manager.php';

// Load admin interface if in admin
if ( is_admin() ) {
    require_once ACF_R2B_DIR . 'admin/class-admin-page.php';
    new ACF_R2B_Admin_Page();
}
```

### Step 2.3: Migration Engine Class

**File:** `acf-repeater-to-blocks/includes/class-migration-engine.php`

**Key Functionality:**

```php
class ACF_R2B_Migration_Engine {

    /**
     * Migrate a single page from repeater to blocks
     *
     * @param int $post_id The post ID to migrate
     * @return array Result with success/error information
     */
    public function migrate_page( $post_id ) {
        // 1. Validate post exists and has 'rows' repeater data
        // 2. Create backup of post_content and postmeta
        // 3. Get all repeater rows
        // 4. Convert each row to Gutenberg block
        // 5. Update post_content with blocks
        // 6. Log results
        // 7. Return success/error
    }

    /**
     * Convert repeater row to Gutenberg block
     *
     * @param array $row The repeater row data
     * @return string The Gutenberg block HTML comment
     */
    private function convert_row_to_block( $row ) {
        // Extract data
        $content     = $row['content'];
        $bg_class    = $row['background-class'];
        $bg_color    = $row['background-color'];

        // Create block attributes
        $block_id    = 'block_' . wp_generate_uuid4();
        $attrs       = array(
            'id'         => $block_id,
            'name'       => 'acf/content-section',
            'data'       => array(
                'content'           => $content,
                '_content'          => 'field_content_section_content',
                'background_class'  => $bg_class,
                '_background_class' => 'field_content_section_bg_class',
                'background_color'  => $bg_color,
                '_background_color' => 'field_content_section_bg_color',
            ),
            'mode'       => 'preview',
        );

        // Generate block comment
        return '<!-- wp:acf/content-section ' . wp_json_encode( $attrs ) . ' /-->';
    }

    /**
     * Batch migrate multiple pages
     *
     * @param array $post_ids Array of post IDs
     * @param int $batch_size Number of posts per batch
     * @return array Results
     */
    public function batch_migrate( $post_ids, $batch_size = 10 ) {
        // Process in batches to avoid timeouts
        // Return results for each batch
    }
}
```

### Step 2.4: Migration Logger

**File:** `acf-repeater-to-blocks/includes/class-migration-logger.php`

**Purpose:**
- Log all migration operations
- Track success/failure
- Store backups references
- Enable rollback

**Key Methods:**
- `log_migration_start( $post_id )`
- `log_migration_success( $post_id, $data )`
- `log_migration_error( $post_id, $error )`
- `get_migration_log( $post_id )`
- `export_log_csv()`

### Step 2.5: Backup Manager

**File:** `acf-repeater-to-blocks/includes/class-backup-manager.php`

**Purpose:**
- Create backups before migration
- Store post_content and postmeta
- Enable rollback to original state

**Key Methods:**
- `backup_post( $post_id )` - Backup before migration
- `restore_post( $post_id )` - Rollback to backup
- `delete_backup( $post_id )` - Clean up old backups
- `get_backup_info( $post_id )` - Get backup metadata

**Storage:**
- Custom table: `wp_acf_migration_backups`
- Columns: `id`, `post_id`, `post_content_backup`, `postmeta_backup`, `created_at`

### Step 2.6: Admin Interface

**File:** `acf-repeater-to-blocks/admin/class-admin-page.php`

**Features:**
1. **Dashboard Overview:**
   - Total pages with 'rows' repeater data
   - Migration status (pending, migrated, failed)
   - Backup status

2. **Migration Controls:**
   - Select pages to migrate (individual or bulk)
   - Preview migration (dry-run mode)
   - Execute migration
   - Rollback option

3. **Log Viewer:**
   - View migration history
   - Export logs as CSV
   - Filter by status/date

**Menu Location:** Tools > Repeater to Blocks Migration

---

## Phase 3: Data Migration Process

### Step 3.1: Pre-Migration Checklist

**Before running migration:**

1. ✅ Backup entire database
2. ✅ Backup uploads directory
3. ✅ Test migration on staging/local first
4. ✅ Verify ACF is active and updated
5. ✅ Verify `layers-gutenberg` theme is active
6. ✅ Verify content-section block is registered
7. ✅ Test creating a manual content-section block

### Step 3.2: Migration Execution Plan

**Phased Rollout:**

1. **Test Phase:** Migrate 1-2 test pages
   - Review output
   - Check block rendering
   - Verify styling matches
   - Test editing in Gutenberg

2. **Pilot Phase:** Migrate 10-20 pages
   - Monitor for issues
   - Gather feedback
   - Refine process

3. **Full Migration:** Migrate all remaining pages
   - Use batch processing
   - Monitor server load
   - Log all results

### Step 3.3: Migration Algorithm

**For each page:**

```
1. Get post ID and verify it exists
2. Check if page has 'rows' repeater data
   - If no: Skip (nothing to migrate)
   - If yes: Continue

3. Create backup:
   - Backup current post_content
   - Backup all postmeta (rows_* keys)
   - Store in backup table

4. Get all repeater rows:
   - rows_0_content, rows_0_background-class, rows_0_background-color
   - rows_1_content, rows_1_background-class, rows_1_background-color
   - ... etc

5. Convert each row to Gutenberg block:
   - Generate unique block ID
   - Map fields:
     • 'content' → 'content'
     • 'background-class' → 'background_class'
     • 'background-color' → 'background_color'
   - Create block comment syntax

6. Build new post_content:
   - Preserve existing content (if any)
   - Append Gutenberg blocks

7. Update post:
   - Update post_content with blocks
   - Keep original repeater meta (for rollback)
   - Update post_modified

8. Log result:
   - Log success with row count
   - Log any errors
   - Store backup reference

9. Verify:
   - Load post in editor
   - Confirm blocks render
   - Check frontend display
```

### Step 3.4: Block Syntax Format

**Example conversion:**

**Before (Repeater Data):**
```
postmeta:
  rows_0_content = "<h2>Welcome</h2><p>Content here</p>"
  rows_0_background-class = "bkg-gradient-green"
  rows_0_background-color = "#f0f0f0"
```

**After (Gutenberg Block):**
```html
<!-- wp:acf/content-section {"id":"block_64f2a1b3c4d5e","name":"acf/content-section","data":{"content":"<h2>Welcome<\/h2><p>Content here<\/p>","_content":"field_content_section_content","background_class":"bkg-gradient-green","_background_class":"field_content_section_bg_class","background_color":"#f0f0f0","_background_color":"field_content_section_bg_color"},"mode":"preview"} /-->
```

**Note:** Field reference keys (`_content`, `_background_class`, `_background_color`) must match the ACF field keys from `group_content_section_block.json`

---

## Phase 4: Testing & Validation

### Step 4.1: Pre-Migration Tests

**Test on staging/local first:**

1. Create test page with 'rows' repeater
2. Add 3-4 rows with varied content
3. Run migration on test page
4. Verify output

**Expected Results:**
- Post content contains Gutenberg blocks
- Blocks render in editor
- Blocks render on frontend
- Styling matches original
- Background colors/classes apply correctly

### Step 4.2: Post-Migration Tests

**For each migrated page:**

1. **Editor Test:**
   - Open page in Gutenberg editor
   - Verify blocks appear
   - Verify block settings editable
   - Test saving changes

2. **Frontend Test:**
   - View page on frontend
   - Compare to original (use screenshots)
   - Verify styling matches
   - Check responsive behavior

3. **Rollback Test:**
   - Test rollback function
   - Verify original data restored
   - Re-migrate if needed

### Step 4.3: Validation Checklist

**Per-page validation:**

- [ ] Page loads without errors
- [ ] Content displays correctly
- [ ] Background colors/classes applied
- [ ] Images/media render
- [ ] Links functional
- [ ] Mobile responsive
- [ ] No console errors
- [ ] SEO metadata intact

---

## Phase 5: Rollback & Recovery

### Step 5.1: Rollback Process

**If migration fails or issues found:**

1. Use plugin's rollback feature:
   - Select page(s) to rollback
   - Click "Restore from Backup"
   - Verify restoration

2. Manual rollback (if needed):
   ```sql
   -- Restore post_content
   UPDATE wp_posts
   SET post_content = (SELECT post_content_backup FROM wp_acf_migration_backups WHERE post_id = X)
   WHERE ID = X;

   -- Postmeta is preserved, no action needed
   ```

3. Switch back to `layers2` theme temporarily

### Step 5.2: Backup Retention

**Backup storage:**
- Keep backups for 30 days post-migration
- Export backups to external storage
- Document backup locations

**Cleanup:**
- After 30 days of successful operation
- Run cleanup script to remove old backups
- Keep migration logs permanently

---

## Phase 6: Configuration & Deployment

### Step 6.1: WordPress Configuration

**Required plugins:**
- Advanced Custom Fields PRO (latest version)
- ACF Repeater to Blocks Migration (our custom plugin)

**Optional but recommended:**
- Classic Editor (for emergency fallback)
- Revision Control (limit post revisions)

### Step 6.2: Theme Activation

**Steps:**
1. Upload `layers-gutenberg` theme
2. In WP Admin: Appearance > Themes
3. Activate `Layers Gutenberg` theme
4. Verify theme loads correctly
5. Check menus and widgets

### Step 6.3: Migration Plugin Activation

**Steps:**
1. Upload `acf-repeater-to-blocks` plugin
2. In WP Admin: Plugins > Installed Plugins
3. Activate "ACF Repeater to Blocks Migration"
4. Navigate to Tools > Repeater to Blocks Migration
5. Review dashboard

### Step 6.4: ACF Field Synchronization

**Important:** Ensure ACF fields are in sync

1. Go to Custom Fields > Tools > Import Field Groups
2. Import `group_content_section_block.json` if needed
3. Verify field group is active
4. Test creating a block manually

---

## Phase 7: Documentation & Training

### Step 7.1: User Documentation

**Create documentation for:**
- How to add Content Section blocks
- How to edit existing blocks
- How to use background classes
- Common styling options
- Troubleshooting guide

### Step 7.2: Developer Documentation

**Document:**
- Migration script usage
- Rollback procedures
- Block template customization
- Adding new blocks
- Debugging block issues

---

## Success Criteria

**Migration is successful when:**

1. ✅ All pages migrated without data loss
2. ✅ Frontend display matches original
3. ✅ Blocks editable in Gutenberg
4. ✅ No performance degradation
5. ✅ All tests passing
6. ✅ Backups created and verified
7. ✅ Rollback tested and working
8. ✅ Documentation complete
9. ✅ Team trained on new system
10. ✅ Original theme can be deactivated

---

## Timeline Estimate

**Estimated time per phase:**

| Phase | Description | Estimated Time |
|-------|-------------|----------------|
| 1 | Create `layers-gutenberg` theme | 2-3 hours |
| 2 | Create migration plugin | 8-12 hours |
| 3 | Data migration (100 pages) | 4-6 hours |
| 4 | Testing & validation | 6-8 hours |
| 5 | Documentation | 3-4 hours |
| **Total** | | **23-33 hours** |

**Recommended schedule:**
- Week 1: Phases 1-2 (create theme and plugin)
- Week 2: Phase 3-4 (migrate and test on staging)
- Week 3: Phase 5-7 (production migration and docs)

---

## Risk Mitigation

**Potential Risks:**

1. **Data Loss**
   - Mitigation: Comprehensive backups before any migration
   - Multiple backup layers (plugin backup + full DB backup)

2. **Performance Issues**
   - Mitigation: Batch processing, server monitoring
   - Test on staging first

3. **Styling Differences**
   - Mitigation: CSS audit before migration
   - Compare screenshots before/after

4. **Plugin Conflicts**
   - Mitigation: Test on staging with all plugins active
   - Document plugin versions

5. **User Training**
   - Mitigation: Create video tutorials
   - Offer hands-on training sessions

---

## Next Steps

**Immediate actions:**

1. Review this plan with stakeholders
2. Set up staging environment
3. Create `layers-gutenberg` theme
4. Begin migration plugin development
5. Create test pages with repeater data
6. Schedule team training

**Questions to resolve:**

1. Which pages should be migrated first?
2. What is the maintenance window for production migration?
3. Who will be responsible for testing?
4. What is the rollback decision timeline?

---

## Appendix A: Field Mapping Reference

| Old Repeater Field | New Block Field | Notes |
|-------------------|-----------------|-------|
| `rows` (repeater) | N/A (converted to blocks) | One block per row |
| `content` | `content` | Direct mapping |
| `background-class` | `background_class` | Hyphen → underscore |
| `background-color` | `background_color` | Hyphen → underscore |

---

## Appendix B: Database Schema

**Backup Table Schema:**
```sql
CREATE TABLE wp_acf_migration_backups (
    id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    post_id BIGINT(20) UNSIGNED NOT NULL,
    post_content_backup LONGTEXT NOT NULL,
    postmeta_backup LONGTEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY post_id (post_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

**Migration Log Table:**
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## Appendix C: File Reference

**Theme Files:**
```
layers-gutenberg/
├── style.css (theme metadata)
├── functions.php (block registration, ACF settings)
├── page.php (renders blocks via the_content)
├── blocks/
│   └── content-section/
│       └── content-section.php (block template)
├── acf-json/
│   └── group_content_section_block.json (field definitions)
└── inc/ (theme functions)
```

**Plugin Files:**
```
acf-repeater-to-blocks/
├── acf-repeater-to-blocks.php
├── includes/
│   ├── class-migration-engine.php
│   ├── class-migration-logger.php
│   └── class-backup-manager.php
├── admin/
│   ├── class-admin-page.php
│   └── views/
│       └── migration-dashboard.php
└── README.md
```

---

**Document Version:** 1.0
**Last Updated:** November 19, 2025
**Author:** AUC Development Team
**Status:** Ready for Review
