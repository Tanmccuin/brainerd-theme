# Brainerd Mobile Navigation — Integration Guide

## How the built-in mobile nav works

The Brainerd theme includes a full-screen overlay mobile nav that activates at
viewports ≤900px. It consists of three pieces:

### 1. CSS (`style.css`)
- `.brainerd-header__toggle` — hamburger button, hidden above 900px
- `.brainerd-header__nav` / `.brainerd-header__cta` — hidden below 900px
- `.brainerd-mobile-nav` — fixed overlay, opacity/visibility toggled via `data-open`

### 2. HTML (`parts/header.html` + `single-portfolio.php`)
- Hamburger `<button>` with open/close SVG icons
- `<div class="brainerd-mobile-nav" id="brainerd-mobile-nav">` overlay panel
- Contains: nav links, CTA button, contact info

### 3. JS (`functions.php` → `wp_footer`)
- Click toggle opens/closes the overlay
- Sets `aria-expanded` on the toggle button
- Locks body scroll when open (`overflow: hidden`)
- Focus trap — Tab cycles within the overlay
- Escape key closes the overlay
- Clicking any nav link closes the overlay
- Returns focus to the toggle button on close

## Accessibility features

- `role="dialog"` + `aria-modal="true"` on the overlay
- `aria-expanded` toggled on the hamburger button
- `aria-label` on the button and nav landmarks
- Focus trapped inside the overlay while open
- Escape key dismissal
- Focus returned to trigger element on close

## Disabling the built-in nav

If you want to use a third-party mobile nav plugin (Responsive Menu, UberMenu,
etc.) or build your own:

1. Install and activate **Brainerd Companion**
2. Go to **Settings → Brainerd**
3. Toggle **Built-in Mobile Nav** off
4. Save

This sets `brainerd_companion_disabled_mobile_nav` in the database. The theme
checks this option before outputting the mobile nav JS. The CSS for the hamburger
button and overlay remains in the stylesheet but has no effect without the JS.

## Replacing with a custom implementation

### Option A: Third-party plugin
Most mobile nav plugins (Responsive Menu, UberMenu, SlidePanel) work by:
1. Targeting an existing `<nav>` element or WordPress menu
2. Injecting their own toggle button and panel

After disabling the built-in nav via the companion:
- The hamburger button and overlay markup stay in the HTML but are inert
- You may want to hide the built-in hamburger via CSS:
  ```css
  .brainerd-header__toggle { display: none !important; }
  .brainerd-mobile-nav { display: none !important; }
  ```
- The plugin will inject its own button and panel

### Option B: Custom AI-built replacement
If using Claude Code or another AI to build a custom mobile nav:

**Key selectors to target:**
- `.brainerd-header__toggle` — the hamburger button (replace or restyle)
- `.brainerd-mobile-nav` — the overlay panel (replace content/layout)
- `#brainerd-mobile-nav` — JS target for the toggle

**Required accessibility:**
- `aria-expanded` on the toggle button
- `role="dialog"` + `aria-modal="true"` on the panel
- Focus trap while panel is open
- Escape key to close
- Body scroll lock while open
- Return focus to trigger on close

**CSS tokens available:**
All `--tmd-*` tokens work inside the mobile nav:
- `--tmd-bg` / `--tmd-surf` for backgrounds
- `--tmd-heading` / `--tmd-body` for text
- `--tmd-accent` for interactive elements
- `--tmd-transition` for animations
- Dark mode adapts automatically via `.tmd-dark` class

**Breakpoint:** The built-in nav uses 900px. Match this in your replacement
or update `@media (max-width: 900px)` in `style.css` to your preferred
breakpoint.

### Option C: Brainerd Companion integration
Create a file in `brainerd-companion/integrations/` that:
1. Detects your nav plugin
2. Loads any CSS overrides
3. Optionally disables the built-in nav via the `init` callable:
   ```php
   'init' => function() {
       update_option('brainerd_companion_disabled_mobile_nav', true);
   },
   ```

## File locations

| File | What it does |
|------|-------------|
| `themes/brainerd/style.css` | CSS for hamburger, overlay, mobile breakpoint |
| `themes/brainerd/functions.php` | JS output via `wp_footer` (toggle, focus trap) |
| `themes/brainerd/parts/header.html` | Hamburger button + overlay HTML (FSE pages) |
| `themes/brainerd/single-portfolio.php` | Same markup for PHP template pages |
| `brainerd-companion/integrations/mobile-nav.php` | Companion toggle integration |
