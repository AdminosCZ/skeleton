# Branding assets

Logo soubory, které admin panel čte přes `->brandLogo(asset('branding/adminos-logo.png'))` v [`AdminPanelProvider`](../../app/Providers/Filament/AdminPanelProvider.php).

## Soubory

| Soubor | Použití |
|--------|---------|
| `adminos-logo.png` | Default (light mode) — tmavý text na světlém pozadí |
| `adminos-logo-dark.png` | Dark mode varianta — světlý text na tmavém pozadí |

PNG i SVG fungují stejně. Pokud nahradíš souborem s jinou příponou, uprav cestu v `AdminPanelProvider.php`.

## Výměna loga

Nahraď oba soubory svou verzí. Zachovej:

- **Poměr stran ~4:1** (např. 320×80, 480×120, 640×160 pro PNG; libovolný viewBox v poměru pro SVG). Filament render height = 1.85rem (~30px), zbytek se proporcionálně dopočítá.
- **Barva textu:** light varianta tmavá (`#111827`/`#232934`), dark varianta světlá (`#F1F1F1`). Symbol/ikona může být v obou stejná (typicky brand color).
- **Pro PNG:** doporučení 2× DPI (= např. 480×120 pro výsledných 240×60 fyzicky) kvůli ostrosti na retina displays. Transparentní pozadí.

## Per-client branding

Tohle je **výchozí ADMINOS brand** out-of-the-box. V dalším PR přidáme Settings page, kde si klient nahraje **vlastní logo** (uloží se do `storage/app/public/branding/`) a přebije tento default.

## Favicon

Favicon je v [`../favicon.svg`](../favicon.svg) (na rootu `public/`). Malá čtvercová verze loga, bez wordmarku.
