# TK Products Sync for Multisite

Managing products across multiple WordPress sites can quickly become a headache. If you run a WordPress Multisite network - where several shops live under one WordPress installation - you would normally have to add or update each product on every site individually. This plugin solves that.

**TK Products Sync for Multisite** lets you manage all your products in one place - your main (master) site - and automatically copies every change to all other sites on your network. Update a price, swap an image, or add a new variation on the master site, and every other site reflects that change instantly without you lifting another finger.

It supports both Simple products and Variable products (products with options like size or colour), and syncs everything: product details, prices, images, categories, tags, and stock information.

---

## Requirements

Before installing, make sure your setup meets the following:

- **WordPress Multisite** - your WordPress installation must be running in network/multisite mode
- **WooCommerce 5.0 or higher** - must be network-activated and active on all sites
- **PHP 7.4 or higher** - check with your hosting provider if unsure
- **A shared upload folder** - all sites on your network must be able to read and write to the same uploads location on the server (see [Setting Up a Shared Filesystem](#setting-up-a-shared-filesystem) below)

---

## Installation

1. Download the plugin and upload the `tk-products-sync-for-multisite` folder to your `/wp-content/plugins/` directory
2. Log in to your **Network Admin** dashboard (the top-level admin area of your multisite network)
3. Go to **Plugins** and find **TK Products Sync for Multisite**
4. Click **Network Activate**
5. That's it - no settings to configure. The plugin starts working immediately

> Only products saved on the **master site (the first site on your network, Blog ID 1)** are synced outward. The other sites on your network are destinations only - editing a product directly on a subsite will not trigger a sync.

---

## How It Works

### Automatic Sync on Save

Every time you save a product on the master site, the plugin automatically pushes the full product data to every other site on your network. If the product already exists on a subsite, it gets updated. If it does not exist yet, it gets created automatically.

You do not need to do anything extra - just save the product as you normally would in WooCommerce.

### Bulk Actions

On the master site's **Products** screen, two extra options appear when you select products and open the **Bulk Actions** dropdown:

| Action                       | What it does                                                                |
| ---------------------------- | --------------------------------------------------------------------------- |
| **Sync to All Subsites**     | Queues the selected products to be synced to all subsites in the background |
| **DELETE from All Subsites** | Permanently removes the selected products from every subsite                |

When you trigger a bulk sync, the products are added to a background queue and processed automatically - you don't have to wait. A message will appear at the top of the screen confirming how many products were queued, with a link to monitor the progress.

> **Warning:** Deletion via bulk action is permanent. Products are not moved to trash - they are removed immediately from all subsites.

---

## What Gets Synced

### Product Details

- Product name, full description, and short description
- Regular price and sale price
- Product status (published, draft, etc.)
- Whether the product is visible in the shop catalogue

### Images

- The main product image
- All additional gallery images
- Images are copied to each subsite and registered properly so they appear in the media library

### Categories and Tags

- All product categories and tags are created on each subsite if they don't already exist
- Nested categories (parent-child relationships) are handled correctly - parents are always created before their children
- Category images are also synced
- If you delete a category or tag on the master site, it is removed from all subsites too

### Variations (for Variable Products)

- All product variations and their individual prices, sale prices, and SKUs
- Stock quantity and stock status per variation
- Variation attributes (e.g. Size: Small / Medium / Large)
- If you remove a variation on the master site, it is deleted from all subsites too

### Extra Product Data

- Any additional product data fields set by WooCommerce or other plugins are synced automatically
- A small set of fields are intentionally excluded - things like ratings and review counts (which should be independent per site) and internal WordPress tracking fields

---

## Known Limitations

- The master site is always **the first site on your network** (Blog ID 1) - this is not configurable
- There is no settings page or dashboard - the plugin works silently in the background
- Any user who can edit products on the master site can trigger a sync - there are no extra permission controls
- If you deactivate or delete the plugin, product data and images that were already synced to subsites remain in place and must be cleaned up manually
- Sync errors are written to your server's PHP error log - there is no in-dashboard error display

---

## Setting Up a Shared Filesystem

When this plugin syncs product images, it physically copies the image files from your master site's upload folder to each subsite's upload folder. For this to work, both folders need to exist on the **same server** and your hosting account must have permission to copy files between them.

**If you are on shared hosting (e.g. cPanel, Plesk):**
This usually works out of the box because all your sites share the same server account. No extra setup is needed. Test it by syncing a product with an image and checking whether the image appears on a subsite.

**If you are on managed WordPress hosting (e.g. WP Engine, Kinsta, Flywheel):**
These hosts often isolate sites from each other for security. Contact their support and ask whether cross-site file access is possible within a multisite network, or whether a shared NFS/storage mount can be configured.

**If you manage your own server (VPS or dedicated):**
All sites in a WordPress Multisite network typically share the same `wp-content/uploads` directory by default, which means no extra configuration is needed. If your sites have been set up with separate upload paths, you will need to either consolidate them or configure a symbolic link so they point to the same location.

> If images fail to sync, the plugin will log an error to your server's PHP error log (usually accessible via your hosting control panel under **Error Logs**). Image sync failures do not stop the rest of the product data from syncing.

---

#### Donate

<a href="https://www.paypal.com/donate/?hosted_button_id=CSQFKDWQZVE4W" target="_blank">
  <img src="https://img.shields.io/badge/Donate-PayPal-green.svg" alt="Donate with PayPal">
</a>

##### MPesa Donation: 254725682556 or MPesa Till 5267627

## Changelog

### v1.1.2

- Gated all debug error_log() calls behind WP_DEBUG to comply with WordPress plugin coding standards.
- Added phpcs:ignore annotations on error_log() lines to satisfy static analysis checks.
- Fixed phpcs:ignore placement in uninstall.php so the meta_key slow query notice is correctly suppressed on the right line.

### v1.1.1

- Declared HPOS (High-Performance Order Storage) compatibility to resolve the WooCommerce incompatible plugins notice.
- Bumped tested-up-to version to WooCommerce 10.9.1.

### v1.1.0

- Bulk sync now runs in the background via a queue - the page no longer freezes while syncing large numbers of products
- A progress notice is shown after bulk sync with a link to monitor the queue
- Deleting a category or tag on the master site now removes it from all subsites
- Category images are now synced alongside the category itself

### v1.0.0

- Initial release
- Auto-sync on product save
- Bulk sync and bulk delete actions on master site
- Simple and Variable product support
- Image, category, tag, variation, and custom field sync
- Nested category handling
- Orphaned variation cleanup
