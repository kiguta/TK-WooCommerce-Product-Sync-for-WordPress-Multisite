=== TK WooCommerce Product Sync for Multisite ===
Contributors: toniekiguta
Tags: woocommerce, multisite, product-sync, network, sync
Requires at least: 5.8
Tested up to: 7.0
Stable tag: 1.1.1
Requires PHP: 7.4
Requires Plugins: woocommerce
WC requires at least: 5.0
WC tested up to: 10.9.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Automatically sync WooCommerce products from your master site to all other sites in a WordPress Multisite network.

== Description ==

Managing products across multiple WordPress sites can quickly become a headache. If you run a WordPress Multisite network — where several shops live under one WordPress installation — you would normally have to add or update each product on every site individually. This plugin solves that.

**TK WooCommerce Product Sync** lets you manage all your products in one place — your main (master) site — and automatically copies every change to all other sites on your network. Update a price, swap an image, or add a new variation on the master site, and every other site reflects that change instantly without you lifting another finger.

= What gets synced =

* Product name, description, and short description
* Regular price and sale price
* Product status (published, draft, etc.) and catalogue visibility
* Featured image and gallery images
* Product categories and tags (including nested categories and category images)
* Product variations with individual prices, SKUs, and stock levels
* Any additional product data set by WooCommerce or other plugins

= How it works =

Every time you save a product on the master site, the plugin automatically pushes the full product data to every other site on your network. If the product already exists on a subsite it gets updated. If it does not exist yet it gets created automatically.

A **Sync to All Subsites** bulk action is also available on the Products screen for manually re-syncing products in the background. A **DELETE from All Subsites** bulk action permanently removes selected products from every subsite.

= Important notes =

* Only products saved on the **first site in your network (Blog ID 1)** are synced outward. Other sites are destinations only.
* Image syncing requires all sites to share the same server filesystem. See the FAQ for setup guidance.
* Deleting a product via bulk action is permanent — products are not moved to trash.

== Installation ==

1. Download the plugin and upload the `tk-woocommerce-product-sync` folder to your `/wp-content/plugins/` directory.
2. Log in to your **Network Admin** dashboard.
3. Go to **Plugins** and find **TK WooCommerce Product Sync**.
4. Click **Network Activate**.
5. No configuration needed — sync begins automatically when you save a product on the master site.

== Frequently Asked Questions ==

= Does this work with Variable products? =

Yes. Product variations are fully synced including individual prices, sale prices, SKUs, stock quantities, and attributes such as size or colour. Variations removed from the master are also removed from all subsites.

= Do I need to configure anything after installing? =

No. The plugin works out of the box once network-activated. Just save or update a product on your master site and it will be pushed to all other sites automatically.

= Why are images not syncing to some subsites? =

Image sync requires that all sites on your network share the same server filesystem — meaning they are hosted on the same server and your hosting account can copy files between site upload folders. This typically works on standard shared hosting and self-managed servers running WordPress Multisite. On managed WordPress hosting platforms (such as WP Engine, Kinsta, or Flywheel) sites are often isolated from each other, and you may need to contact your host to enable cross-site file access. When an image fails to sync, the rest of the product data still syncs successfully.

= How do I monitor background sync jobs? =

After using the **Sync to All Subsites** bulk action, a notice appears at the top of the Products screen with a link to **WooCommerce > Status > Scheduled Actions**. You can track the progress of each queued sync job there.

= Will synced products be removed if I deactivate the plugin? =

No. Deactivating the plugin stops future syncs but leaves all existing synced products in place on each subsite. If you delete the plugin entirely, the sync relationship data (internal tracking information) is removed from the database, but the products, images, categories, and tags remain on each subsite.

= Can I sync products from a subsite back to the master? =

No. The sync is one-directional — from the master site (Blog ID 1) outward to all subsites. Editing a product directly on a subsite will not trigger a sync.

= What happens if a subsite fails during sync? =

The plugin logs the error to your server's PHP error log and continues syncing to the remaining subsites. A failure on one subsite does not prevent the others from being updated.

== Screenshots ==

1. The Sync to All Subsites and DELETE from All Subsites bulk actions on the master site Products screen.
2. The background sync progress notice linking to WooCommerce Scheduled Actions.
3. The confirmation prompt shown when deleting the plugin, listing what data will be removed.

== Changelog ==

= 1.1.1 =
* Declared HPOS (High-Performance Order Storage) compatibility to resolve the WooCommerce incompatible plugins notice.
* Bumped tested-up-to version to WooCommerce 10.9.1.

= 1.1.0 =
* Bulk sync now runs in the background via a queue — the page no longer freezes while syncing large numbers of products.
* A progress notice is shown after bulk sync with a link to monitor the queue in WooCommerce Scheduled Actions.
* Deleting a category or tag on the master site now removes it from all subsites.
* Category images are now synced alongside the category.
* Added WooCommerce active check on plugin activation with a clear error message if WooCommerce is not installed.
* Added persistent admin notice if WooCommerce is deactivated while the plugin is still active.
* Security: added capability checks, output escaping, and input sanitisation to admin-facing code.

= 1.0.0 =
* Initial release.
* Auto-sync on product save.
* Bulk sync and bulk delete actions on the master site.
* Simple and Variable product support.
* Image, category, tag, variation, and custom field sync.
* Nested category handling with parent-child hierarchy preservation.
* Orphaned variation cleanup.

== Upgrade Notice ==

= 1.1.0 =
Bulk sync is now asynchronous. Jobs run in the background via WooCommerce's built-in Action Scheduler — no timeout issues on large catalogues.
