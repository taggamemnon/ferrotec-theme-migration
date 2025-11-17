# Development Workflow for Ferrotec Theme Migration

## Current State (Post-Merge)

✅ **Branch:** `claude/create-new-theme-014uYE7TqikuUKSQF1zt6WpW` (up to date with main)
✅ **Theme:** `wp-content/themes/layers2025/` (27 files scaffolded)
✅ **Documentation:** Complete (README.md, claude.md, FILE_ANALYSIS.md)

---

## Git Workflow Strategy

### Branch Naming Convention
All Claude Code session branches follow this pattern:
```
claude/<task-name>-<session-id>
```

**Examples:**
- `claude/create-new-theme-014uYE7TqikuUKSQF1zt6WpW` (this session)
- `claude/create-layers2025-theme-01VbQjf8sACrrdQUNBq4omTW` (previous)
- `claude/update-bootstrap-5-01Vp36HVieRQkSpRn6EGHhob` (unmerged)

### Recommended Workflow

#### **Option A: Feature Branch Workflow** (Recommended for collaboration)
```bash
# Start each Claude session
1. Fetch latest from main
   git fetch origin
   git checkout main
   git pull origin main

2. Claude creates session branch automatically
   claude/task-name-sessionID

3. Work on feature
   (Claude makes commits)

4. Push to remote
   git push -u origin claude/task-name-sessionID

5. Create Pull Request on GitHub
   - Review changes
   - Merge to main
   - Delete branch

6. Next session starts from updated main
```

#### **Option B: Direct to Main** (Faster for solo work)
```bash
# Work directly on main for rapid iteration
git checkout main
git pull origin main
# Make changes
git add .
git commit -m "message"
git push origin main
```

#### **Option C: Hybrid Approach** (Best of both worlds)
```bash
# Small changes → Direct to main
# Large features → Feature branches with PR

Small changes (documentation, minor fixes):
- Work on main
- Commit and push

Large features (new functionality):
- Create feature branch
- Develop and test
- PR review
- Merge to main
```

---

## Handling Multiple Claude Sessions

### Problem
Each new Claude Code session creates a new branch from a snapshot of the repo. If main has advanced, the new session branch will be behind.

### Solution: Start Each Session with Sync
```bash
# At the beginning of each Claude session:
1. Check current branch
   git status

2. If behind main, merge main
   git fetch origin
   git merge main
   # OR rebase for cleaner history
   git rebase main

3. Resolve any conflicts
   git status
   git add <resolved-files>
   git commit

4. Continue working
```

### Claude Code Automation
Add this to the **`.claude.md`** file so Claude automatically syncs:

```markdown
## Session Startup Protocol
At the start of each session:
1. Run `git fetch origin`
2. Check if current branch is behind main: `git status`
3. If behind, run `git merge main` and resolve conflicts
4. Proceed with the requested task
```

---

## Protecting the Old Themes

### `.claudeignore` Configuration
```
/old-themes/
```

This prevents Claude from:
- ❌ Modifying files in `old-themes/`
- ❌ Suggesting edits to old theme files
- ❌ Accidentally breaking reference code

Claude CAN still:
- ✅ Read old theme files for reference
- ✅ Copy patterns from old themes
- ✅ Analyze old theme structure

### Verification
```bash
# Ensure old-themes hasn't changed
git status old-themes/
# Should show: nothing to commit
```

---

## Project Structure Rules

### ✅ WHERE TO WRITE CODE

#### New Theme
```
wp-content/themes/layers2025/
├── *.php                    # Template files
├── style.css               # Main stylesheet
├── functions.php           # Theme functions
├── assets/                 # All assets
│   ├── css/               # Stylesheets
│   ├── js/                # JavaScript
│   ├── fonts/             # Web fonts
│   └── images/            # Theme images
├── inc/                   # PHP includes
├── template-parts/        # Reusable template parts
└── page-templates/        # Custom page templates
```

#### Future Plugin (Phase 2)
```
wp-content/plugins/ferrotec-woocommerce/
├── ferrotec-woocommerce.php    # Main plugin file
├── includes/                    # PHP classes
├── templates/                   # Template overrides
└── assets/                      # Plugin assets
```

### ❌ WHERE NOT TO WRITE CODE
```
old-themes/                 # READ-ONLY reference
```

---

## Development Phases

### Phase 1: Core Theme (Current)
**Location:** `wp-content/themes/layers2025/`

**Tasks:**
- [x] Create theme structure
- [x] Add base template files
- [x] Integrate Bootstrap grid
- [ ] Migrate custom fonts
- [ ] Create navigation menus
- [ ] Set up WooCommerce support
- [ ] Create page templates (products, resources, events)
- [ ] Migrate ACF field groups

### Phase 2: WooCommerce Plugin
**Location:** `wp-content/plugins/ferrotec-woocommerce/`

**Tasks:**
- [ ] Extract WooCommerce customizations from old themes
- [ ] Create plugin structure
- [ ] Implement custom product tabs
- [ ] Build attribute table system
- [ ] Create shortcodes for product listings
- [ ] Add ACF integration

### Phase 3: Testing & Refinement
**Tasks:**
- [ ] Test all product categories
- [ ] Verify template hierarchy
- [ ] Cross-browser testing
- [ ] Mobile responsiveness
- [ ] Performance optimization
- [ ] SEO verification

---

## Commit Message Standards

### Format
```
<type>: <short summary>

<optional detailed description>
<optional list of changes>
```

### Types
- `feat:` - New feature
- `fix:` - Bug fix
- `docs:` - Documentation update
- `style:` - Code style/formatting
- `refactor:` - Code refactoring
- `test:` - Test additions
- `chore:` - Maintenance tasks

### Examples
```bash
feat: Add custom product listing template for MEI VAC products

- Create page-templates/products/meivac-listing.php
- Integrate ACF fields for product specifications
- Add table sorting JavaScript
- Style product grid with Bootstrap classes

---

fix: Resolve merge conflict in style.css

Accepted main branch version which includes complete CSS structure.

---

docs: Update README with Phase 2 plugin requirements
```

---

## File Naming Conventions

### PHP Files
```
template-parts/content/content-page.php    # Template parts
page-templates/products/te-products.php    # Custom page templates
inc/theme-setup.php                        # Includes (function files)
woocommerce/single-product.php             # WooCommerce overrides
```

### CSS Files
```
assets/css/main.css              # Main styles
assets/css/bootstrap-grid.css    # Bootstrap grid only
assets/css/components.css        # Reusable components
assets/css/woocommerce.css       # WooCommerce specific
```

### JavaScript Files
```
assets/js/navigation.js          # Navigation functionality
assets/js/scripts.js             # General site scripts
assets/js/product-filters.js     # Product filtering
assets/js/vendor/                # Third-party libraries
```

---

## Code Standards

### PHP
- Follow [WordPress PHP Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/)
- Prefix all functions: `ft_` or `ferrotec_`
- Use proper escaping: `esc_html()`, `esc_attr()`, `esc_url()`
- Sanitize inputs: `sanitize_text_field()`, `sanitize_email()`, etc.

### JavaScript
- Follow [WordPress JavaScript Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/javascript/)
- Use modern ES6+ where appropriate
- Enqueue scripts properly via `wp_enqueue_script()`

### CSS
- Follow [WordPress CSS Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/css/)
- Use BEM methodology for class names: `.block__element--modifier`
- Prefix custom classes: `.ft-` or `.ferrotec-`
- Mobile-first responsive design

---

## Testing Checklist

Before pushing to main:
- [ ] PHP syntax check: `php -l file.php`
- [ ] WordPress theme check (if testing locally)
- [ ] Cross-browser test (Chrome, Firefox, Safari, Edge)
- [ ] Mobile responsive test
- [ ] Accessibility check (keyboard navigation, screen reader)
- [ ] WooCommerce integration test (if applicable)
- [ ] Git status clean: `git status`

---

## Quick Reference Commands

### Git Operations
```bash
# Check status
git status

# Fetch updates
git fetch origin

# Sync with main
git merge main

# View branches
git branch -a

# View commit history
git log --oneline --graph -10

# Push current branch
git push -u origin $(git branch --show-current)
```

### Theme Development
```bash
# View theme files
ls -la wp-content/themes/layers2025/

# Count theme files
find wp-content/themes/layers2025/ -type f | wc -l

# Search for function usage
grep -r "function_name" wp-content/themes/layers2025/

# Find TODO comments
grep -r "TODO" wp-content/themes/layers2025/
```

---

## Documentation Files

| File | Purpose | Lines |
|------|---------|-------|
| `README.md` | Complete project overview | 439 |
| `claude.md` | Detailed Claude Code instructions | 1000 |
| `FILE_ANALYSIS.md` | Old theme file analysis | 370 |
| `.claude.md` | Session-specific instructions | ~30 |
| `PROJECT_PLAN.md` | Original planning document | ~80 |
| `WORKFLOW.md` | This file - workflow guide | ~400 |

**Recommendation:** Consolidate `.claude.md` and `PROJECT_PLAN.md` into `claude.md` to reduce duplication.

---

## Session Handoff Protocol

When ending a Claude session:
1. Commit all work: `git commit -am "Session summary"`
2. Push to remote: `git push`
3. Document progress in relevant `.md` files
4. Update checklist in `README.md`
5. Note any blockers or next steps

When starting a new Claude session:
1. Sync with main (see above)
2. Review `README.md` checklist
3. Check `claude.md` for any specific instructions
4. Continue from last documented state

---

## Troubleshooting

### "Branch is behind main"
```bash
git fetch origin
git merge main
# Resolve conflicts
git commit
```

### "Modified files in old-themes/"
```bash
# Check what changed
git status old-themes/

# Reset if accidental
git checkout -- old-themes/
```

### "Merge conflicts"
```bash
# View conflicted files
git status

# Edit conflicts manually or use:
git checkout --theirs <file>  # Accept their version
git checkout --ours <file>    # Accept our version

# Mark resolved
git add <file>
git commit
```

### "Lost commits"
```bash
# View all commits
git reflog

# Recover lost commit
git cherry-pick <commit-hash>
```

---

## Summary

✅ **Always start sessions by syncing with main**
✅ **Never modify `old-themes/` directory**
✅ **All new code goes in `wp-content/themes/layers2025/`**
✅ **Use feature branches for large changes**
✅ **Create PRs for review before merging to main**
✅ **Follow WordPress coding standards**
✅ **Document all significant changes**

This workflow ensures clean git history, prevents conflicts, and maintains project organization across multiple Claude Code sessions.
