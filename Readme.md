# VescaCloud Custom Website Theme

VescaCloud is a custom WordPress theme built for VescaCloud LLC, a modern consulting website. It includes a polished front page, custom admin panel, careers flow, consultation form, and styled email notifications.

## Overview

- **Theme name:** `VescaCloud Custom Website Theme`
- **Theme URI:** `https://vescacloud.com`
- **Author:** `Ismail Oni (VescaCloud)`
- **Version:** `1.3.0`
- **Text domain:** `vescacloud`

The theme is designed for a consulting business focused on Salesforce, HubSpot, CRM, ERP, and integration services.

## Features

- **Modern homepage:** Hero section, services, featured technology carousel, and strong calls to action.
- **Consultation flow:** Dedicated consultation page with form handling and styled email notifications.
- **Careers flow:** Job listings, application modal, and application emails for admins and applicants.
- **About page contact:** Styled contact/email workflow with separate admin notification handling.
- **Admin panel:** Front-end dashboard for blog posts, job listings, certifications, consultation requests, and settings.
- **Toast notifications:** Reusable toast UI for success and error feedback.
- **Responsive design:** Mobile-friendly layouts across the public site and admin views.

## Folder Structure

```text
omni-solutions-theme/
├── assets/
│   ├── css/
│   │   ├── main.css
│   │   ├── pages.css
│   │   ├── login.css
│   │   └── admin.css
│   ├── js/
│   │   └── main.js
│   ├── icons/
│   └── images/
├── template-parts/
│   ├── about.php
│   ├── admin-panel.php
│   ├── blog.php
│   ├── blog-post.php
│   ├── careers.php
│   ├── consultation.php
│   └── privacy.php
├── functions.php
├── front-page.php
├── header.php
├── footer.php
├── page.php
├── single.php
├── archive.php
├── search.php
├── 404.php
├── index.php
├── style.css
└── theme.json
```

## Installation

1. Copy the theme folder into:
	`wp-content/themes/omni-solutions-theme`
2. Log in to WordPress admin.
3. Go to **Appearance → Themes**.
4. Activate **VescaCloud Custom Website Theme**.
5. Visit **Settings → Permalinks** and save once to refresh rewrite rules if needed.

## Recommended Pages

Create and assign these pages for the full experience:

- Home
- About
- Blog
- Careers
- Consultation
- Privacy Policy

## Admin Panel

The theme includes a custom front-end admin page at `/admin-panel` with tabs for:

- Dashboard
- Blog Posts
- Job Listings
- Certifications
- Consultation Requests
- Settings

The Settings section lets the admin configure separate notification emails for:

- Consultation requests
- Job applications
- Contact/about messages

## Email Notifications

The theme sends styled HTML emails for:

- Consultation form submissions
- About/contact form submissions
- Job applications

Each email includes a branded layout, clean spacing, and readable content blocks.

## Development Notes

- Main theme styles are loaded from `assets/css/main.css` and `assets/css/pages.css`.
- Login and admin styling live in `assets/css/login.css` and `assets/css/admin.css`.
- Theme-wide functionality is registered in `functions.php`.
- Custom templates live in `template-parts/` and are used by the main page templates.

## Customization Tips

- Update branding, colors, and layout in `assets/css/`.
- Adjust homepage content in `front-page.php`.
- Edit form handling and admin settings in `functions.php` and `template-parts/admin-panel.php`.
- Replace placeholder images and icons in `assets/images/` and `assets/icons/`.

## Notes

- The theme uses the `vescacloud` text domain for translations.
- Some internal file/folder names still reflect the original theme namespace, even though the public brand is VescaCloud.

