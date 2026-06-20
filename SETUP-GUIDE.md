# AlphaGearX BD — WordPress Setup Guide

A minimal dark‑violet WooCommerce storefront delivered as an **Astra child theme**.
This guide installs and configures it on your WordPress (local/staging) site.

---

## 0) What you received
- `alphagearx-bd-child/` — the child theme (zip it, or use the provided `alphagearx-bd-child.zip`).
- `sample-products.csv` — 14 clean sample products (importable into WooCommerce).
- Clean branded placeholder images are **bundled in the theme** (`assets/products/`, `assets/img/`) — swap with your real photos anytime.

## 1) Requirements
- WordPress **6.0+**, PHP **7.4+**
- **Astra** theme (free, the parent)
- **WooCommerce** plugin

## 2) Install the theme
1. **Appearance → Themes → Add New** → search **Astra** → **Install** (do not delete it; it's the parent).
2. **Appearance → Themes → Add New → Upload Theme** → choose **`alphagearx-bd-child.zip`** → **Install** → **Activate**.

## 3) Install WooCommerce
- **Plugins → Add New** → search **WooCommerce** → **Install → Activate**.
- Run the setup wizard (or set manually in step 4).

## 4) WooCommerce settings
**WooCommerce → Settings → General**
- **Selling location(s):** *Sell to specific countries* → **Bangladesh**.
- **Currency:** **Bangladeshi Taka (৳)**.

**WooCommerce → Settings → Payments**
- Enable **Cash on Delivery**. (Optionally disable others.)

**WooCommerce → Settings → Shipping → Add shipping zone**
- Zone name: **Bangladesh**, Region: **Bangladesh**.
- Add method **Flat rate** → cost **60**.
- Add method **Free shipping** → requirement **A minimum order amount** → **2000**.
  (This matches the on‑site message "Free delivery over ৳2000".)

## 5) Permalinks
**Settings → Permalinks → Post name → Save Changes** (flushes rewrite rules so shop/category/product URLs work).

## 6) Import the sample products
**WooCommerce → Products → Import** → upload **`sample-products.csv`** → *Continue* → column mapping is automatic → **Run the importer**.
- Categories (Strength Training, Yoga & Flexibility, Recovery & Support, Home Workout, Gym Accessories, Complete Kits) are created automatically.
- Product images are pulled from public URLs in the CSV (your server needs outbound internet during import).
  - **If your host blocks remote image import:** the same images live in the theme at `assets/products/`. Upload them to **Media** and set each product's **Featured image** manually.

## 7) Pages
WooCommerce auto‑creates **Shop, Cart, Checkout, My Account**. Now create these (Pages → Add New), using the **exact slugs**:
| Page | Slug | Notes |
|---|---|---|
| Home | `home` | Leave content empty — the homepage layout is built by the theme. |
| Learn | `learn` | Uses the theme's Learn template automatically. |
| About | `about` | Uses the About template automatically. |
| Contact | `contact` | Uses the Contact template. (Optional: paste a Contact Form 7 / WPForms shortcode into the page to make the form send.) |

**Settings → Reading → Your homepage displays → A static page → Homepage: Home.**

> The header navigation (Shop dropdown + categories + cart) is built by the theme automatically — you do **not** need to create a WP menu for it to work.

## 8) Branding & hero
- **Logo (optional):** Appearance → Customize → **Site Identity → Logo** (upload the AlphaGearX BD logo). If none, an "AG" monogram is shown.
- **Hero slider:** Appearance → Customize → **Hero Slider**.
  - 3 desktop banners are pre‑loaded.
  - Add a **Mobile image** per slide when ready (separate mobile art), plus optional heading/subheading/button.

## 9) (You're done) — the shop filter rail (Category / Price / On Sale) and sorting work out of the box, no extra plugin needed.

---

## ✅ Test checklist (on your staging site)
- **Home:** hero slider auto‑rotates + swipes on mobile; Shop‑by‑Goal row; Bestsellers grid; trust strip; footer.
- **Header:** hover **Shop** → category dropdown; add a product → **cart count** updates.
- **Shop page:** filter rail (Category, Price ranges, On Sale) + **Sort by** + product grid.
- **Category page** (e.g. Strength Training): shows only that category.
- **Single product:** image + price + **quantity −/+** + **Add to Bag** + "Cash on Delivery" line + related products.
- **Cart:** add/update quantity; **Free shipping over ৳2000**, else **৳60**.
- **Checkout:** simplified BD fields (Name, Mobile, Address, Area/Thana, District) + **Cash on Delivery** → **Place order** → order‑received page.
- **Learn / About / Contact** pages render with the dark‑violet design.
- **Mobile:** hamburger menu, slider swipe, 2‑up product grid.

## 🎨 Swapping placeholders for real content (later)
- **Product photos:** Products → edit a product → set a clean **Featured image** (and gallery images).
- **Mobile hero art:** Customize → Hero Slider → Slide *n* → Mobile image.
- **Prices/stock:** edit each product.
- **Contact details / socials:** edit the Contact page + footer links.

## Notes
- **Theme colours** stay dark‑violet (per the brief). Your logo/banners use orange/black — if you ever want the UI accent to match the logo, it's a one‑variable change (`--kit-solid` / accent) — just ask.
- This child theme keeps the **animated neon background** and the **product‑card design** unchanged from the approved prototype.
