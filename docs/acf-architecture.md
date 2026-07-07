# ACF Architecture

## Field Group: Homepage
Location: Front page.

### Flexible Content: `homepage_sections`
The homepage is managed as ordered modules. Editors can reorder sections without editing markup.

#### Layout: `hero`
- `eyebrow` text
- `title` textarea
- `highlight` text
- `description` textarea
- `background_image` image
- `background_image_mobile` image, falls back to `background_image`
- `primary_button` clone: link field
- `secondary_button` clone: link field

#### Layout: `statistics`
- `items` repeater
  - `icon` select: chart, users, shield, document
  - `number` text
  - `suffix` text
  - `label` text

#### Layout: `services`
- `heading` text
- `subtitle` text
- `archive_link` link
- `items` repeater
  - `title` text
  - `tagline` text
  - `image` image
  - `features` repeater text
  - `link` link

#### Layout: `featured_projects`
- `heading` text
- `archive_link` link
- `items` relationship to project CPT, with manual card fallback fields if needed

#### Layout: `home_audit_cta`
- `image` image
- `label` text
- `heading` text
- `description` textarea
- `benefits` repeater
  - `icon` select
  - `label` text
- `button` link

#### Layout: `work_process`
- `heading` text
- `steps` repeater
  - `icon` select
  - `number` text
  - `title` text
  - `description` text

#### Layout: `testimonials`
- `heading` text
- `archive_link` link
- `items` relationship to testimonial CPT

#### Layout: `partner_logos`
- `items` repeater
  - `logo` image
  - `name` text
  - `url` url

## Field Group: Project Details
Location: Project post type.
- `area` text
- `style` text
- `budget` text
- `timeline` text
- `location` text
- `gallery` gallery
- `featured_on_home` true/false

## Field Group: Service Details
Location: Service post type.
- `short_tagline` text
- `features` repeater text
- `starting_scope` textarea
- `service_icon` select

## Field Group: Testimonial Details
Location: Testimonial post type.
- `rating` number, min 1, max 5
- `client_role` text
- `project_context` text
- `avatar` image

## Options Page: Theme Settings
Used for global content that appears across templates.

### Brand
- `brand_logo_text`
- `brand_tagline`
- `footer_description`

### Header
- `header_cta` link

### Footer Menus
Menus remain native WordPress menus for editor familiarity.

### Contact
- `phone`
- `email`
- `address`
- `map_image`
- `map_url`

### Social Links
- `social_links` repeater
  - `platform` select
  - `url` url

### SEO / Sharing
- `default_og_image`

## Implementation Notes
- PHP registers field groups with `acf_add_local_field_group` so the base theme is portable.
- Each template part provides robust defaults when ACF PRO is inactive or fields are empty.
- Images use WordPress attachment IDs when available and fall back to local SVG placeholders.
- Links are rendered through a helper that escapes URL, label, target, and rel consistently.
