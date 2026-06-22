# Br*ai*nerd Theme

An AI-first WordPress Full Site Editing theme. Minimal tooling, zero framework dependencies, built to be developed directly with [Claude Code](https://claude.ai/claude-code).

> **Status:** Pre-alpha (v0.1.0-alpha). Under active development. Not yet recommended for production use.

## What this is

Brainerd is a blank-slate FSE theme designed for a specific workflow: you and an AI build the site together. Instead of a page builder UI or a library of pre-built layouts, Brainerd gives you:

- **`theme.json`** — your entire design system (colors, fonts, spacing, radii) in one file
- **FSE templates** — header, footer, page, single, archive, 404 as editable HTML template parts
- **CSS custom properties** — `--tmd-*` tokens that cascade through every block and component
- **Dark mode** — built-in light/dark toggle with `localStorage` persistence
- **Modern CSS reset** — Andy Bell + Josh Comeau reset baked in
- **Zero build step** — no Node, no PostCSS, no Webpack. Edit a file, reload the page.

Everything that matters is a file. Nothing lives only in the database. The entire site is reproducible from code via `scripts/build-site.sh`.

## The ecosystem

Brainerd is three pieces that work together but stay independent:

### Brainerd Theme
The shell. Design tokens, templates, base styles, dark mode, CSS reset. This repo.

### [Brainerd Blocks](https://github.com/tanmccuin/brainerd-blocks)
Companion plugin. ACF-powered Gutenberg blocks — hero, service pillars, portfolio grid, pricing grid, CTA band, contact form. Each block is a self-contained folder (`block.json` + `render.php` + `style.css` + ACF JSON). Drop in a folder, get a block. No plugin code edits needed.

### [Brainerd Companion](https://github.com/tanmccuin/brainerd-companion)
Plugin detection and integration manager. Auto-detects third-party plugins (Gravity Forms, WooCommerce, Rank Math, etc.) and loads matching style overrides. Dashboard widget shows ecosystem status. Adding an integration = dropping a single PHP file.

## Requirements

- WordPress 6.4+ (tested up to 7.0)
- PHP 8.0+
- [ACF Pro](https://www.advancedcustomfields.com/pro/) (required for Brainerd Blocks)

## Starting a project with AI

When you open a new Claude Code session (or any AI assistant) pointed at a
Brainerd install, paste this as your first message:

```
I want to build a new website using the Brainerd theme. Before exploring
any code or proposing a plan, read the CLAUDE.md file in the theme
directory and follow the discovery conversation process. Ask me about my
business, brand, and goals before making any technical decisions. Do not
pick colors, fonts, or layouts until we've talked.
```

Then describe your project naturally:

```
The site is for [business name], a [type of business] in [location].
They need [pages you know about]. [Any other context you have.]
```

The AI will ask you questions about your brand, assets, and goals before
building anything. You don't need to have everything ready — the theme
is designed to work with placeholders while you figure things out.

## Quick start (manual)

```bash
# Clone into your themes directory
cd wp-content/themes/
git clone https://github.com/tanmccuin/brainerd-theme.git brainerd

# Activate
wp theme activate brainerd
```

Customize the design system by editing `theme.json` — colors, fonts, spacing, and layout widths. Override individual tokens in `style.css` via the `--tmd-*` custom properties.

## Design tokens

The theme uses a dual-layer token system:

1. **`theme.json` presets** — WordPress-native tokens (`--wp--preset--color--accent`, etc.) that integrate with the block editor
2. **`--tmd-*` CSS properties** — runtime tokens in `style.css` that handle dark mode, transitions, and component-level styling

Changing a color in `theme.json` updates the editor and the frontend. Changing a `--tmd-*` variable updates the frontend instantly. Both are just files.

## Dark mode

Light mode is the default. A floating toggle button (bottom-right) switches to dark mode. The preference persists via `localStorage` across pages and sessions. The toggle respects `prefers-reduced-motion` — transitions are disabled when the user prefers reduced motion.

All components use `--tmd-*` tokens that swap values under the `.tmd-dark` class. No separate dark stylesheet needed.

## Adding a block (via Brainerd Blocks)

```
wp-content/plugins/brainerd-blocks/blocks/
  my-block/
    block.json       # apiVersion 3, name: brainerd/my-block
    render.php       # PHP template — get_field() + escaping
    style.css        # Scoped styles using --tmd-* tokens
```

Plus an ACF field group JSON in `acf-json/group_cb_my_block.json`.

The plugin auto-registers any folder containing a `block.json`. No plugin code edits needed.

## Accessibility

This theme is built for an accessibility consulting business. Every component meets or exceeds WCAG 2.2 AA:

- Semantic HTML (`<nav>`, `<main>`, `<article>`, `<section>`)
- Visible focus states on all interactive elements
- Logical heading hierarchy
- `prefers-reduced-motion` respected throughout
- ARIA attributes on all interactive components
- Color contrast meets AA minimum, AAA for body text where feasible
- Full keyboard navigation — no mouse-only interactions

## AI-first workflow

This theme is designed to be built, extended, and maintained by AI coding assistants — primarily Claude Code. The architecture decisions reflect this:

- **Files over database** — everything reproducible from code
- **No build step** — AI can edit CSS/PHP directly without toolchain knowledge
- **Self-contained blocks** — each block is one folder, no cross-dependencies
- **Convention over configuration** — naming patterns (`cb-*` classes, `field_cb_*` keys) that AI can follow consistently
- **`theme.json` as the design API** — a structured format AI can read and modify reliably

## License

GPL-2.0-or-later

## Credits

Built by [Tannermooredesign](https://tannermooredesign.com) — a Br*ai*nerd Street Picture Co.
