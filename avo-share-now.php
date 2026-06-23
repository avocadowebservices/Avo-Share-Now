<?php
/*
Plugin Name: AvoShare Now (Niche Tech Edition)
Plugin URI: https://github.com/avocadowebservices/Avo-Share-Now
Description: Ultra-lightweight social sharing optimized for tech, B2B, and modern blogs. Includes X, LinkedIn, Threads, WhatsApp, and a native Copy Link button. Zero dependencies.
Version: 1.2
Author: AvocadoWeb Services LLC
Author URI: https://avocadoweb.net
License: MIT
GitHub: https://github.com/avocadowebservices/Avo-Share-Now
*/

// Prevent direct file access
if (!defined('ABSPATH')) {
    exit;
}

// Add share buttons to bottom of post content
add_filter('the_content', 'avo_share_display');

function avo_share_display($content) {
    // Only show on single posts, not in feeds or admin
    if (!is_singular('post') || is_feed() || is_admin()) {
        return $content;
    }
    
    $post_url = get_permalink();
    $post_title = get_the_title();
    
    // URL encode for share links
    $encoded_url = urlencode($post_url);
    $encoded_title = urlencode($post_title);
    
    // Build modernized share links
    $x_url        = 'https://x.com/intent/tweet?text=' . $encoded_title . '&url=' . $encoded_url;
    $linkedin_url = 'https://www.linkedin.com/sharing/share-offsite/?url=' . $encoded_url;
    $threads_url  = 'https://www.threads.net/intent/post?text=' . urlencode($post_title . ' ' . $post_url);
    $whatsapp_url = 'https://api.whatsapp.com/send?text=' . urlencode($post_title . ' ' . $post_url);
    
    // Build HTML for share buttons
    $share_html = '<div class="avo-share-container">';
    $share_html .= '<span class="avo-share-label">Share Insights:</span>';
    $share_html .= '<div class="avo-share-buttons">';
    $share_html .= '<a href="' . esc_url($x_url) . '" class="avo-share-btn avo-x" target="_blank" rel="noopener noreferrer">X</a>';
    $share_html .= '<a href="' . esc_url($linkedin_url) . '" class="avo-share-btn avo-linkedin" target="_blank" rel="noopener noreferrer">LinkedIn</a>';
    $share_html .= '<a href="' . esc_url($threads_url) . '" class="avo-share-btn avo-threads" target="_blank" rel="noopener noreferrer">Threads</a>';
    $share_html .= '<a href="' . esc_url($whatsapp_url) . '" class="avo-share-btn avo-whatsapp" target="_blank" rel="noopener noreferrer">WhatsApp</a>';
    // Native Copy Link Button (Uses HTML5 Clipboard API in JS below)
    $share_html .= '<button onclick="avoCopyLink(this, \'' . esc_url($post_url) . '\')" class="avo-share-btn avo-copy">Copy Link</button>';
    $share_html .= '</div>';
    $share_html .= '</div>';
    
    return $content . $share_html;
}

// Add CSS styling and minimal vanilla JS to footer/head safely
add_action('wp_head', 'avo_share_assets');

function avo_share_assets() {
    ?>
    <style>
    .avo-share-container {
        margin: 35px 0;
        padding: 20px;
        background: #fafafa;
        border: 1px solid #eaeaea;
        border-radius: 6px;
    }
    
    .avo-share-label {
        display: block;
        margin: 0 0 12px 0;
        font-weight: 700;
        font-size: 13px;
        color: #1a1a1a;
        text-transform: uppercase;
        letter-spacing: 0.8px;
    }
    
    .avo-share-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    
    .avo-share-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 16px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        line-height: 1.4;
        transition: background-color 0.15s ease, transform 0.1s ease;
        cursor: pointer;
        border: none;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }
    
    .avo-share-btn:hover {
        transform: translateY(-1px);
    }
    
    /* Modernized, sleeker brand color pallet */
    .avo-x { background: #000000; color: #ffffff; }
    .avo-x:hover { background: #222222; }
    
    .avo-linkedin { background: #0A66C2; color: #ffffff; }
    .avo-linkedin:hover { background: #084fa0; }
    
    .avo-threads { background: #000000; color: #ffffff; border: 1px solid #333; }
    .avo-threads:hover { background: #111111; }
    
    .avo-whatsapp { background: #25D366; color: #ffffff; }
    .avo-whatsapp:hover { background: #1fb554; }
    
    .avo-copy { background: #f0f0f0; color: #333333; }
    .avo-copy:hover { background: #e4e4e4; }
    
    /* Mobile responsiveness */
    @media (max-width: 600px) {
        .avo-share-container { margin: 25px 0; padding: 15px; }
        .avo-share-buttons { gap: 6px; }
        .avo-share-btn { padding: 8px 12px; font-size: 12px; flex-grow: 1; text-align: center; }
    }
    </style>

    <script>
    function avoCopyLink(button, url) {
        navigator.clipboard.writeText(url).then(function() {
            var originalText = button.innerHTML;
            button.innerHTML = "Copied!";
            button.style.background = "#25D366";
            button.style.color = "#ffffff";
            setTimeout(function() {
                button.innerHTML = originalText;
                button.style.background = "";
                button.style.color = "";
            }, 2000);
        }).catch(function(err) {
            console.error('Could not copy text: ', err);
        });
    }
    </script>
    <?php
}
