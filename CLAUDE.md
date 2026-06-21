# Brainerd Theme — AI Playbook

You're working with Brainerd, an AI-first WordPress FSE theme. This document
is your briefing — read it before writing any code or asking the user questions.

## STOP — Read this before doing anything

DO NOT write code, create files, pick colors, choose fonts, or build a plan
until you have completed the discovery conversation below. The user hired you
to build their site, not to guess what they want.

## Discovery conversation (mandatory)

Ask these questions. Wait for answers. Accept "I don't know yet" as a valid
answer — use defaults for anything undecided and mark it as `inferred` in the
config so you can revisit it later. The goal is rapport and understanding, not
a completed intake form.

### 1. The business
Ask ALL of these before proceeding:
- **What is your business called?** (Exact name, capitalization matters)
- **What does your business do?** (In their words, not yours)
- **Where are you located?** (City, state — or remote/online-only)
- **Do you have a tagline or catchphrase?** (e.g., "Baked fresh daily")
- **Who is your target audience?** (Local families? National B2B? etc.)

### 2. Existing brand assets
Ask what they HAVE, don't assume:
- **Do you have a logo?** If yes: "Can you share the file? SVG or high-res
  PNG with transparent background is ideal." If no: "No problem — we'll use
  your business name as text and swap in a logo when you have one."
- **Do you have brand colors?** If yes: "What are they? Hex codes, or point
  me to where they're used." If no: "Do you have a general direction? Warm?
  Cool? Earthy? Bold? I can put together 2-3 palettes for you to pick from."
- **Do you have brand fonts?** If yes: "What are they?" If no: "Any
  preferences? Modern and clean? Traditional and elegant? I'll suggest a
  pairing."
- **Do you have any existing materials?** Business cards, signage, social
  media graphics, a previous website — anything that shows the current brand
  direction. "Upload them here or point me to a URL."

DO NOT pick colors or fonts yourself. Present options. Let the user choose.
Mark user choices as `client-stated`. Mark your suggestions as `inferred`
until the user confirms them.

### 3. The site
- **What pages do you need?** (Home, About, Services, Contact, Blog, Shop,
  Portfolio, etc. — let them tell you, then suggest any they missed)
- **Do you have content ready?** (Text, photos, bios — or are we starting
  from scratch?)
- **Any specific features?** (Online booking, ecommerce, contact form,
  gallery, blog, social feed, etc.)
- **Are there sites you like the look of?** (Doesn't have to be in their
  industry — just visual direction)

### 4. Technical
Check what's already installed before asking about plugins:
```bash
wp plugin list --status=active --fields=name,version
```
If Brainerd Companion is active, check integration status:
```bash
wp eval 'foreach(Brainerd\Integration_Registry::instance()->all() as $s=>$i) echo "$s: ".($i["detected"]?"active":"—")."\n";'
```
Then ask:
- **Do you have hosting sorted?** (Or do they need recommendations?)
- **Do you have a domain?** (Registered where?)
- **Any plugins you already use or want?** (Forms, SEO, ecommerce, etc.)
- **Do you need email at your domain?** (you@yourbusiness.com)

### 5. After discovery — populate the config
Once you have answers, populate the Brainerd config system:
```php
$config = Brainerd\Config::instance();
$config->set( 'site_name', 'Flour & Fold', 'client-stated' );
$config->set( 'phone', '802-555-0100', 'client-stated' );
$config->set( 'email', 'hello@flourandfold.com', 'client-stated' );
$config->set( 'tagline', 'Baked fresh daily', 'client-stated' );
$config->save();
```
Provenance rules:
- `client-stated` — the user told you this explicitly. LOCKED.
- `inferred` — you suggested it and the user hasn't confirmed. SOFT.
- `default` — shipped with the theme. Replace when real data is available.

Never treat `inferred` as final. Surface it back: "I set the accent color to
#d4a843 based on your 'warm wheat tones' description — does that work, or
would you like to see other options?"

### 6. Design direction
Only after you have the brand info (or confirmed they don't have one yet):
- If they provided colors/fonts → update `theme.json` and `--tmd-*` tokens
- If they provided a Figma file or design tokens → read and map them
- If they have nothing → present 2-3 palette + font options based on their
  business type. DO NOT just pick one. Show options, let them choose.
- If they said "I don't know yet" → use the theme defaults (cream/coral,
  Fraunces + Inter). Tell them: "We're starting with the default palette.
  Easy to change anytime — just say the word."

### 7. Don't force completeness
No logo? Use the text site name. No colors? Use defaults. No content? Use
preview fallbacks. The theme is designed to look good with placeholders.
Ship something the user can see and iterate on — not a blank page waiting
for perfection.

For anything you defaulted or inferred, keep a running list and surface it
periodically: "We still have placeholder values for: accent color, logo,
tagline. Want to address any of these now?"

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
