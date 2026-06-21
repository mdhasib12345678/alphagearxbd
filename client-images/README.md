# AlphaGearX BD — Client Image Pack & AI Prompts

This pack lists **every image location** on the website and gives you a ready‑to‑use **AI prompt**
for each one — in **two versions: Desktop + Mobile**. Your client appears in the images.

Generate each image (e.g. in ChatGPT / Midjourney / your AI tool) using the prompt, then **drop the
file into the matching `desktop/` or `mobile/` folder**. When you've filled the folders, send them
back and I'll wire them into the live site (replacing the temporary placeholders) with proper
desktop/mobile switching.

---

## How to use (quick)
1. Open a section folder (e.g. `01-hero-slider/slide-1-train-beyond-limits/`).
2. Read its `PROMPTS.md` → copy the **Desktop** prompt → generate → save the file in `desktop/`.
3. Copy the **Mobile** prompt → generate → save in `mobile/`.
4. Use the **exact filename** given in the prompt (so I can map it automatically).
5. Repeat for every folder. Send me the filled `client-images/` folder.

> Tip: to keep your client's face/identity consistent across all images, attach the **same
> reference photo of your client** to every generation, and keep the wardrobe/look consistent.

---

## ⭐ GLOBAL STYLE — paste this at the TOP of every prompt
> *Photorealistic premium e‑commerce lifestyle photography for a Bangladeshi yoga & gym gear brand
> called "AlphaGearX BD". Cinematic, clean, aspirational and modern. Warm moody lighting with soft
> shadows, shallow depth of field, tasteful negative space. The subject is **[MY CLIENT]** — a real,
> fit, confident Bangladeshi person (use the attached reference photo for face/identity). Natural,
> healthy, modest and positive. Cohesive dark‑premium colour grading that pairs well with a
> dark violet website UI. Ultra high resolution, sharp, professional studio quality.*
>
> *AVOID: any on‑image text, captions, watermarks or logos; clutter; extra people; distorted hands
> or warped equipment; medical, injury, bandage or wound imagery; anything sad, scary or
> inappropriate. Keep it brand‑safe and uplifting.*

After the global style, add the **per‑image scene** (from each `PROMPTS.md`) and the **aspect ratio**.

---

## 📐 Size reference (Desktop vs Mobile)

| Section | Desktop size (px) | Mobile size (px) | Why two framings |
|---|---|---|---|
| 01 Hero slider | **1920 × 820** (wide cinematic) | **1080 × 1400** (tall) | Desktop is a wide banner; mobile is near full‑screen vertical. Re‑frame, don't just resize. |
| 02 Shop by Goal | **700 × 860** (portrait) | **720 × 720** (square) | Tall card on desktop; 2‑up square tiles on phones. |
| 03 Featured tile | **560 × 400** | *(none — hidden on mobile)* | Small tile inside the Shop menu (desktop only). |
| 04 Products | **1200 × 1200** (1:1) | **800 × 800** (1:1) | Same square; mobile is a lighter‑weight copy. |
| 05 Category banners | **1600 × 520** (wide) | **1000 × 700** | Wide hero strip on desktop; shorter on phones. |

**Format:** JPG (or PNG). Keep mobile files lighter (≈ < 300 KB) for fast loading.

---

## 🗺️ Where each image appears on the site
- **01 Hero slider** → the big rotating banner at the top of the **Home** page (3 slides).
- **02 Shop by Goal** → the 4 "Shop by Your Goal" tiles on the **Home** page.
- **03 Featured tile** → the small image inside the **Shop ▾** dropdown menu.
- **04 Products** → each product's main photo (shop grid + single product page). 14 products.
- **05 Category banners** → top banner of each category page (Strength, Yoga, Recovery, Home, Accessories, Kits). *Optional but recommended — makes category pages feel rich.*

---

## 🎬 Framing rules (important for the two versions)
- **Desktop / wide:** place your client to one side (usually right), leaving open negative space on
  the other side — the website overlays headlines/buttons there. Landscape composition.
- **Mobile / tall:** centre or lower‑centre the client with clear headroom at the top — text sits
  over the top third. Vertical composition.

---

## 📁 Folder index
```
client-images/
├── 01-hero-slider/        (3 slides — each: desktop/ + mobile/)
├── 02-shop-by-goal/       (4 goals — each: desktop/ + mobile/)
├── 03-shop-featured-tile/ (1 — desktop only)
├── 04-products/           (14 products — each: desktop/ + mobile/)
└── 05-category-banners/   (6 categories — each: desktop/ + mobile/)
```
Each section folder has its own **`PROMPTS.md`** with the exact prompts + filenames.

---

### Note from me (optional pro tip)
For the **product grid** thumbnails, a clean studio shot of *just the product* (no person) usually
reads clearer at small sizes. So for section 04 I give you a **client‑lifestyle** prompt (as you
asked) **and** a quick **clean product‑only** alternative — pick whichever you prefer per product.
Hero (01), Goals (02) and Category banners (05) are where your client should really shine.
