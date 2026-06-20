# Brainerd Theme — AI Playbook

You're working with Brainerd, an AI-first WordPress FSE theme. This document
is your briefing — read it before writing any code or asking the user questions.

## Your first conversation

Don't run through a checklist. Have a conversation. The user may not have
everything ready — that's normal and fine. Your job is to meet them where they
are and fill gaps with sensible defaults.

### Start here
1. **What are we building?** Ask what kind of site this is. Portfolio? Service
   business? Blog? Ecommerce? The answer shapes everything — which blocks to
   use, which CPTs to register, which plugins to suggest.

2. **Check what's already installed.** Before asking about plugins, look:
   ```bash
   wp plugin list --status=active --fields=name,version
   ```
   If Brainerd Companion is active, check integration status:
   ```bash
   wp eval 'foreach(Brainerd\Integration_Registry::instance()->all() as $s=>$i) echo "$s: ".($i["detected"]?"active":"—")."\n";'
   ```

3. **Populate the config.** The Brainerd Companion has a config system for site
   chrome (name, phone, email, nav, CTA). Fill it in as you learn things:
   ```php
   $config = Brainerd\Config::instance();
   $config->set( 'phone', '555-0100', 'client-stated' );
   $config->set( 'email', 'hello@example.com', 'client-stated' );
   $config->save();
   ```
   Mark things the user told you as `client-stated`. Things you're guessing as
   `inferred`. Ship defaults as `default`. Never treat `inferred` as final —
   surface it back for confirmation.

4. **Design tokens.** If they have a brand (logo, colors, fonts), update
   `theme.json`. If they have a Figma file or design tokens export, read it and
   map the values. If they have nothing yet, the defaults work — cream/coral
   palette, Fraunces + Inter. Tell them it's easy to change later.

5. **Don't force completeness.** No logo yet? Use the text site name. No color
   scheme? Use the defaults. No content? Use preview fallbacks. The theme is
   designed to look good with placeholders — ship something the user can see
   and iterate on, not a blank page waiting for content.

## The ecosystem

Three repos, each independent:

| Package | What it is | Repo |
|---------|-----------|------|
| **Brainerd Theme** | FSE shell — templates, design tokens, dark mode, mobile nav | `wp-content/themes/brainerd/` |
| **Brainerd Blocks** | ACF Gutenberg blocks — 12 ready-to-use components | `wp-content/plugins/brainerd-blocks/` |
| **Brainerd Companion** | Config system, plugin detection, integration manager | `wp-content/plugins/brainerd-companion/` |

## How to build things

### Adding a page
Pages are assembled from block markup in post_content. Use the blocks:
```
<!-- wp:brainerd/hero {"data":{"heading":"..."}} /-->
<!-- wp:brainerd/service-pillars {"data":{...}} /-->
<!-- wp:brainerd/cta-band {"data":{...}} /-->
```
For editorial content, use core WordPress blocks (paragraphs, headings,
columns, lists, images).

### Adding a block
Copy any folder in `brainerd-blocks/blocks/` as a starting point. Read
`SYSTEM.md` in the blocks plugin for naming conventions, token usage, and
the accessibility checklist. A block = `block.json` + `render.php` + `style.css`
+ ACF JSON. The plugin auto-registers it.

### Adding a CPT
Create `mu-plugins/snippets/cpt-<name>.php`. Use `register_post_type()`.
If it needs ACF fields, add a group JSON in `brainerd-blocks/acf-json/`.

### Adding a plugin integration
Drop a PHP file in `brainerd-companion/integrations/`. See `INTEGRATIONS.md`
in the companion plugin. CSS overrides go in `integrations/css/` and should
use `--tmd-*` tokens.

## Design system (read SYSTEM.md for the full reference)

- **Colors:** `--tmd-bg`, `--tmd-surf`, `--tmd-heading`, `--tmd-body`,
  `--tmd-accent`, `--tmd-border`, `--tmd-muted` — all swap in dark mode
- **Fonts:** Fraunces (headings, 700), Inter (body, 400/500)
- **Spacing:** `--wp--preset--spacing--40` through `--80`
- **Radii:** `--tmd-radius-sm` (4px), `--tmd-radius-md` (8px), `--tmd-radius-lg` (10px)
- **Classes:** BEM — `cb-<block>`, `cb-<block>__<element>`
- **ACF keys:** `field_cb_<abbrev>_<field>`, group `group_cb_<abbrev>`

## Available blocks (12)

| Block | Slug | Good for |
|-------|------|----------|
| Hero | `brainerd/hero` | Page headers, mosaic + parallax |
| Service Pillars | `brainerd/service-pillars` | Icon + text cards |
| Portfolio Grid | `brainerd/portfolio-grid` | CPT query grid |
| Pricing Grid | `brainerd/pricing-grid` | Tier cards |
| CTA Band | `brainerd/cta-band` | Closing call to action |
| Contact Form | `brainerd/contact-form` | Simple HTML form |
| Testimonials | `brainerd/testimonials` | Quote cards |
| FAQ Accordion | `brainerd/faq-accordion` | Expandable Q&A |
| Stats | `brainerd/stats` | Metric cards |
| Logo Cloud | `brainerd/logo-cloud` | Client/partner logos |
| Team Grid | `brainerd/team-grid` | Team member cards |
| Feature List | `brainerd/feature-list` | Process steps, features |

## Rules

### Never do these (human-only)
- Enter ACF Pro license keys or any credentials
- Deploy to production, configure DNS or hosting
- Enter payment/API keys or SMTP credentials

### Always do these
- **Escape all output:** `esc_html`, `esc_url`, `esc_attr`, `wp_kses_post`
- **Semantic HTML:** `<nav>`, `<main>`, `<section>`, `<button>` — not divs
- **ARIA attributes** on interactive elements
- **Visible focus states** (inherited from theme)
- **`prefers-reduced-motion`** respected for any animation
- **WCAG AA contrast** minimum — check with `Brainerd\Config::check_contrast()`
- **Use tokens** — never hardcode colors, spacing, or font values

### Suggesting plugins
Prefer well-maintained plugins over custom code for: forms (Gravity Forms),
SEO (Rank Math), caching (WP Rocket), images (ShortPixel), SMTP (FluentSMTP),
security (Wordfence). Build custom only when simple, site-specific, or no
good plugin exists.

## Config system

The Brainerd Companion stores site chrome in `wp_options` via a config API:

```php
// Read
brainerd_config( 'phone' )
brainerd_config( 'cta_text', 'GET IN TOUCH' )

// Write (with provenance)
$config = Brainerd\Config::instance();
$config->set( 'phone', '555-0100', 'client-stated', 'conversation:' );
$config->save();

// Register a custom field
$config->register( 'business_hours', [
    'label'   => 'Business Hours',
    'type'    => 'text',
    'section' => 'extended',
    'group'   => 'contact',
] );
```

Users can also edit config values in WP Admin → Brainerd → Site Config.

## Running things
```bash
ddev start                           # Start the environment
ddev wp <command>                    # WP-CLI (WP is in wp/ subdirectory)
ddev exec bash scripts/build-site.sh # Rebuild from code
```
