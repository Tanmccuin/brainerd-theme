# Br*ai*nerd Theme

An AI-first WordPress Full Site Editing theme. Minimal tooling, zero framework dependencies, designed to be developed with [Claude Code](https://claude.ai/claude-code) or any AI coding assistant.

> **Pre-alpha** — under active development.

## What it is

A blank-slate FSE theme where you and an AI build the site together. No page builder, no pre-built layouts — just a clean design system and the tools to build fast.

- **`theme.json`** — colors, fonts, spacing, radii in one file
- **FSE templates** — header, footer, page, single, blog, archive, search, 404
- **`--tmd-*` CSS tokens** — cascade through every block, swap in dark mode
- **Dark mode** — toggle with `localStorage` persistence
- **Mobile nav** — full-screen overlay, focus trap, Escape key, accessible
- **Modern CSS reset** — box-sizing, text-wrap, font-smoothing, overflow protection
- **Zero build step** — edit a file, reload the page

## The ecosystem

| Package | What it does | Repo |
|---------|-------------|------|
| **Brainerd Theme** | FSE shell — tokens, templates, dark mode, mobile nav | This repo |
| **Brainerd Blocks** | 13 ACF Gutenberg blocks — hero, pricing, FAQ, etc. | [brainerd-blocks](https://github.com/tanmccuin/brainerd-blocks) |
| **Brainerd Companion** | Config system, plugin detection, integrations | [brainerd-companion](https://github.com/tanmccuin/brainerd-companion) |

Each is independent. Theme works without blocks. Blocks work with any theme. Companion enhances both.

## Requirements

- WordPress 6.4+
- PHP 8.0+
- [ACF Pro](https://www.advancedcustomfields.com/pro/) (for Brainerd Blocks)

## Getting started

See [GETTING-STARTED.md](GETTING-STARTED.md) for the full onboarding guide with copy-paste AI prompt.

**Quick start:**
```bash
cd wp-content/themes/
git clone https://github.com/tanmccuin/brainerd-theme.git brainerd
wp theme activate brainerd
```

## Design tokens

Two layers that work together:

1. **`theme.json`** — WordPress-native presets (`--wp--preset--color--accent`, etc.)
2. **`style.css`** — runtime tokens (`--tmd-bg`, `--tmd-accent`, etc.) for dark mode + transitions

Change `theme.json` for the design system. `--tmd-*` properties handle the runtime behavior.

## Templates

```
templates/
  index.html              # Fallback
  page.html               # Static pages
  single.html             # Blog posts (date, categories, prev/next)
  home.html               # Blog index
  archive.html            # Category/tag archives
  archive-portfolio.html  # Portfolio CPT archive
  search.html             # Search results
  404.html                # Not found (with search)
parts/
  header.html             # Header + mobile nav
  footer.html             # Structured footer
single-portfolio.php      # Portfolio single (PHP for gallery logic)
```

## Accessibility

Every component targets WCAG 2.2 AA or better:

- Semantic HTML throughout
- Visible focus states on all interactive elements
- `prefers-reduced-motion` respected for all animations
- ARIA attributes on interactive components
- Color contrast validated via built-in `check_contrast()` method
- Full keyboard navigation

## Key docs

| File | Purpose |
|------|---------|
| `CLAUDE.md` | AI playbook — discovery process, build rules, block reference |
| `GETTING-STARTED.md` | User onboarding guide with copy-paste prompt |
| `MOBILE-NAV.md` | Mobile nav integration guide — how to replace or extend |

## License

GPL-2.0-or-later

## Credits

A Br*ai*nerd Street Picture Co. project — [tannermooredesign.com](https://tannermooredesign.com)
