# AvoShare Now

A lightweight WordPress plugin for social sharing buttons with zero bloat, no tracking, and no external dependencies.

## Overview

AvoShare Now adds simple, fast social sharing buttons to your WordPress posts. Readers can share your content to Twitter, Facebook, WhatsApp, LinkedIn, or email with a single click.

Built for performance. Built for clarity. Built for DR2028.

## Features

- **Lightweight** - Single file, ~150 lines of code
- **No bloat** - No tracking, no ads, no external dependencies
- **Fast** - Minimal CSS, zero JavaScript overhead
- **Privacy-focused** - No data collection, no third-party requests
- **Mobile responsive** - Works perfectly on phones and tablets
- **Easy to customize** - Modify colors and styling directly in the plugin file
- **No admin interface** - Install and it just works

## What It Does

When someone visits a post on your WordPress site:

1. They read your article
2. At the bottom, they see "Share this post:" with 5 buttons
3. They click Twitter, Facebook, WhatsApp, LinkedIn, or Email
4. That platform opens with your post title and URL pre-filled
5. They post it to their network

No copy-pasting. No manual work. Just one click to share.

## Installation

### Method 1: Manual Installation

1. Download `avo-share-now.php`
2. Create folder: `/wp-content/plugins/avo-share-now/`
3. Upload `avo-share-now.php` to that folder
4. Go to WordPress admin > Plugins
5. Find "AvoShare Now" and click "Activate"
6. Done. Share buttons will appear on all posts

### Method 2: WordPress Plugin Directory

1. Go to WordPress admin > Plugins > Add New
2. Search for "AvoShare Now"
3. Click "Install Now"
4. Click "Activate"
5. Done

## Usage

Once activated, share buttons automatically appear at the bottom of every blog post. No configuration needed.

The buttons link to:
- **Twitter** - Opens Twitter share dialog
- **Facebook** - Opens Facebook share dialog
- **WhatsApp** - Opens WhatsApp with the link ready to send
- **LinkedIn** - Opens LinkedIn share dialog
- **Email** - Opens email client with subject and body pre-filled

Readers can customize the message before posting on any platform.

## Customization

### Change Button Colors

Edit the CSS in `avo-share-now.php`. Find the color definitions:

```css
.avo-twitter {
    background: #1DA1F2;  /* Twitter blue - change this */
}

.avo-facebook {
    background: #1877F2;  /* Facebook blue - change this */
}

.avo-whatsapp {
    background: #25D366;  /* WhatsApp green - change this */
}

.avo-linkedin {
    background: #0A66C2;  /* LinkedIn blue - change this */
}

.avo-email {
    background: #666;  /* Gray - change this */
}
```

### Change Button Text

Find this section and edit the button labels:

```php
echo '<a href="' . esc_url($twitter_url) . '">Twitter</a>';
echo '<a href="' . esc_url($facebook_url) . '">Facebook</a>';
```

Change "Twitter" to "Tweet This" or whatever you want.

### Change Label Text

Find this line and modify it:

```php
echo '<p class="avo-share-label">Share this post:</p>';
```

Change to "Share this article:" or any other text.

### Add More Platforms

To add another platform (like Reddit or Telegram), add a new link:

```php
$reddit_url = 'https://reddit.com/submit?url=' . $encoded_url . '&title=' . $encoded_title;
echo '<a href="' . esc_url($reddit_url) . '" class="avo-share-btn avo-reddit">Reddit</a>';
```

Then add CSS styling for it:

```css
.avo-reddit {
    background: #FF4500;
    color: white;
}

.avo-reddit:hover {
    background: #cc3700;
}
```

### Show on Pages Too

By default, share buttons only appear on blog posts. To show them on pages as well, find this line:

```php
if (!is_singular('post') || is_feed() || is_admin()) {
```

Change to:

```php
if (!is_singular(array('post', 'page')) || is_feed() || is_admin()) {
```

### Show on Everything

To show share buttons on all content types (posts, pages, custom post types), find this line:

```php
if (!is_singular('post') || is_feed() || is_admin()) {
```

Change to:

```php
if (is_feed() || is_admin()) {
```

### Change Spacing and Styling

Adjust these CSS properties to customize look and feel:

```css
.avo-share-container {
    margin: 30px 0;      /* Space above and below */
    padding: 20px;       /* Space inside the box */
    background: #f9f9f9; /* Background color */
    border-left: 4px solid #333; /* Left border */
}

.avo-share-btn {
    padding: 10px 18px;  /* Space inside buttons */
    margin: 5px;         /* Space between buttons */
    border-radius: 3px;  /* Corner roundness */
    font-size: 13px;     /* Button text size */
}
```

## How It Works

### No JavaScript

The plugin uses pure HTML links. When someone clicks a button, it opens a standard share URL for that platform. No JavaScript running in the background, no tracking pixels, no external requests.

### No Database

All share button configuration is in the CSS. No settings stored in the database. No options table entries. Clean and lightweight.

### No External Dependencies

The plugin only uses native WordPress functions. No jQuery, no Bootstrap, no third-party libraries. Just WordPress core functionality.

### How Sharing Actually Works

When someone clicks "Twitter":

1. The browser opens `https://twitter.com/intent/tweet?text=[post title]&url=[post URL]`
2. Twitter's website shows a compose dialog with the title and URL pre-filled
3. They can edit the message and post it
4. Their followers see the post with a link to your article

Same process for all platforms - direct to the platform's share endpoint, no middleman.

## Performance

AvoShare Now adds approximately:

- **2KB** of code
- **0.5KB** of CSS
- **0 JavaScript** files
- **0 external requests** per page load
- **0 database queries**

Compare to bloated sharing plugins which add 200KB+ of code, multiple JavaScript files, external service requests, and database overhead.

## Privacy

AvoShare Now:

- Collects no data about your readers
- Makes no external requests to tracking services
- Stores no analytics or statistics
- Does not use cookies
- Does not integrate with third-party analytics

Your readers' privacy is protected.

## Browser Support

Works on all modern browsers:
- Chrome/Edge (latest)
- Firefox (latest)
- Safari (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## License

MIT License - Use freely, modify freely, distribute freely.

See LICENSE file for full details.

## Support

For issues, questions, or contributions:

- GitHub: [github.com/avocadowebservices/Avo-Share-Now](https://github.com/avocadowebservices/Avo-Share-Now)
- Website: [AvocadoWeb.net](https://avocadoweb.net)
- Contact: [avocadoweb.net/contact](https://avocadoweb.net/contact)
- Twitter/X: [@AvocadoWebServices](https://www.x.com/avocadowebnet)
- DR2028: [dr2028.org](https://dr2028.org)

## Changelog

### Version 1.1
- Fixed share buttons to display at bottom of post content, not in footer
- Uses `the_content` filter instead of `wp_footer` hook
- Improved reliability across different WordPress themes

### Version 1.0
- Initial release
- Basic social sharing to Twitter, Facebook, WhatsApp, LinkedIn, Email
- Mobile responsive design
- Minimal CSS styling

## About AvocadoWeb Services LLC

AvoShare Now is built by AvocadoWeb Services LLC, a company focused on building clean, efficient tools for governance, communication, and community development.

Learn more about DR2028 governance reform at [dr2028.org](https://dr2028.org)

## Contact & Resources

- 🌐 [AvocadoWeb.net](https://avocadoweb.net)
- 📧 [Contact Us](https://avocadoweb.net/contact)
- 🐦 Twitter/X: [@AvocadoWebServices](https://www.x.com/avocadowebnet)
- 💼 LinkedIn: [AvocadoWebServices](https://www.linkedin.com/company/avocadoweb-services)
- 💼 LinkedIn: [Joseph Brzezowski](https://www.linkedin.com/in/joseph-brzezowski/)

---

**Built with clarity. Built for performance. Built for people.**
