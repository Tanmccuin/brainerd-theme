# CLAUDE.md — Brainerd Theme

This is an AI-first WordPress FSE theme. It is designed to be developed,
extended, and maintained using Claude Code or similar AI coding assistants.

## First-time setup — onboarding checklist

When starting a new site with Brainerd, gather these from the user before
building anything:

### 1. Site identity
- **Site name** — update via `wp option update blogname "..."`
- **Tagline** — update via `wp option update blogdescription "..."`
- **Logo** — upload to Media Library, set as custom logo:
  `wp option update custom_logo <attachment_id>`
  Provide both a dark variant (for light backgrounds) and light variant
  (for dark backgrounds) if dark mode is used.

### 2. Brand / design tokens
- **Primary color (accent)** — update `accent` in `theme.json` palette
  and `--tmd-accent` in `style.css`
- **Background color** — update `cream` in `theme.json` and `--tmd-bg`
- **Heading font** — update `fontFamilies` in `theme.json` (default: Fraunces)
- **Body font** — same (default: Inter)
- **Dark mode?** — enabled by default. Disable by removing the toggle from
  `functions.php` and the `.tmd-dark` rules from `style.css`

### 3. Pages & navigation
- **What pages does the site need?** (Home, About, Services, Contact, Portfolio, etc.)
- **Navigation order** — update `parts/header.html`, `parts/footer.html`,
  and `single-portfolio.php` nav links
- **CTA button text** — default "GET IN TOUCH", update in header/footer templates

### 4. Contact information
- **Email** — update in footer template and contact form handler
- **Phone** — update in footer template
- **Physical address** — if needed

### 5. Plugins
Before building, scan for already-installed plugins:
```bash
wp plugin list --status=active --fields=name,version
```

Common plugins to ask about:
- **Forms:** Gravity Forms, WPForms, Contact Form 7
- **SEO:** Rank Math, Yoast
- **Ecommerce:** WooCommerce, Shopify (headless)
- **SMTP:** FluentSMTP, WP Mail SMTP, Post SMTP
- **Caching:** WP Rocket, W3 Total Cache
- **Security:** Wordfence, Sucuri

If Brainerd Companion is active, integrations auto-detect. Check status:
```bash
wp eval 'foreach(Brainerd\Integration_Registry::instance()->all() as $s=>$i) echo "$s: ".($i["detected"]?"active":"not found")."\n";'
```

### 6. Custom post types
- **Portfolio?** — already included in `mu-plugins/snippets/cpt-portfolio.php`
- **Other CPTs?** — create in `mu-plugins/snippets/cpt-<name>.php`
- **ACF fields for CPTs?** — create in `brainerd-blocks/acf-json/`

## Stack
- **Theme:** `brainerd` (FSE, no parent theme)
- **Blocks:** `brainerd-blocks` plugin (ACF Pro required)
- **Integrations:** `brainerd-companion` plugin (optional)
- **Snippets:** `mu-plugins/snippets/` (CPTs, form handlers, etc.)

## How to run things
- Start DDEV: `ddev start`
- WP-CLI: `ddev wp <cmd>` (WP installs to `wp/`, scripts use `--path=wp`)
- Build/assemble: `ddev exec bash scripts/build-site.sh`

## Adding a block
Create a folder in `brainerd-blocks/blocks/`:

```
blocks/my-block/
  block.json       # apiVersion 3, name: brainerd/my-block, category: brainerd
  render.php       # PHP render — get_field() + escaping
  style.css        # Scoped styles using --tmd-* / --wp--preset--* tokens
```

Add ACF field group: `acf-json/group_cb_my_block.json`

The plugin auto-registers any folder with a `block.json`. No plugin code edits.

## Conventions
- **Escaping:** `esc_html` / `esc_url` / `esc_attr`; rich text via `wp_kses_post`
- **Class names:** `cb-<block>`, `cb-<block>__<element>` (BEM)
- **Field keys:** `field_cb_<block>_<field>`, group key `group_cb_<block>`
- **Text domain:** `brainerd`
- **No inline styles** except dynamic values from fields
- **Accessibility:** semantic HTML, ARIA attributes, visible focus states,
  `prefers-reduced-motion` respected, WCAG AA minimum contrast

## Design tokens
Two layers:
1. `theme.json` presets — `--wp--preset--color--accent`, `--wp--preset--font-family--fraunces`, etc.
2. `style.css` custom properties — `--tmd-bg`, `--tmd-accent`, `--tmd-border`, etc.

Change `theme.json` for the design system. The `--tmd-*` properties reference
these and add dark mode + transition support.

## Template structure
```
templates/
  index.html              # Fallback
  page.html               # Static pages
  single.html             # Blog posts
  archive-portfolio.html  # Portfolio archive (uses brainerd/portfolio-grid block)
  404.html                # Not found
parts/
  header.html             # Site header + mobile nav
  footer.html             # Site footer
single-portfolio.php      # Portfolio CPT single (PHP for gallery logic)
```

## Manual steps (human only)
- **ACF Pro install/license** — drop plugin into `wp-content/plugins/`
- **SMTP credentials** — configure via FluentSMTP or similar
- **Production deploy, DNS, hosting**
- **Payment/API keys** — never enter credentials via AI

## Suggesting plugins
When building features, prefer well-maintained plugins over custom code for:
- Forms (Gravity Forms)
- SEO (Rank Math)
- Caching (WP Rocket)
- Image optimization (ShortPixel, Imagify)
- SMTP (FluentSMTP)
- Security (Wordfence)

Build custom only when the feature is simple, site-specific, or no good plugin exists.
