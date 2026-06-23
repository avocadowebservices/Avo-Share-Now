<?php
/*
Plugin Name: AvoShare Now (Niche Tech Edition)
Plugin URI: https://github.com/avocadowebservices/Avo-Share-Now
Description: Ultra-lightweight social sharing optimized for tech, B2B, and modern blogs. Transparent container, pill-shaped buttons, modern networks (X, Threads, LinkedIn, WhatsApp), and a native Copy Link utility. Zero dependencies.
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

// Add CSS styling and minimal vanilla JS safely
add_action('wp_head', 'avo_share_assets');

function avo_share_assets() {
    ?>
    <style>
    .avo-share-container {
        margin: 40px 0;
        padding: 24px 0; /* Clear background padding, keeps text alignment precise */
        background: transparent; /* Completely see-through */
        border-top: 1px solid #e2e8f0; /* Ultra-subtle divider line instead of a heavy box */
        border-bottom: 1px solid #e2e8f0;
    }
    
    .avo-share-label {
        display: block;
        margin: 0 0 16px 0;
        font-weight: 600;
        font-size: 12px;
        color: #64748b; /* Muted slate gray for a premium look */
        text-transform: uppercase;
        letter-spacing: 1.5px; /* Elegant tracking */
    }
    
    .avo-share-buttons {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }
    
    .avo-share-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 22px;
        border-radius: 30px; /* Fully rounded, niche pill-shape */
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        line-height: 1;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); /* Smoother, snappier transition */
        cursor: pointer;
        border: none;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }
    
    .avo-share-btn:hover {
        transform: translateY(-2px); /* Gentle lift effect */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); /* Soft modern shadow */
    }
    
    /* Modernized brand palette */
    .avo-x { background: #000000; color: #ffffff; }
    .avo-x:hover { background: #1a1a1a; }
    
    .avo-linkedin { background: #0A66C2; color: #ffffff; }
    .avo-linkedin:hover { background: #0c73dc; }
    
    .avo-threads { background: #000000; color: #ffffff; }
    .avo-threads:hover { background: #1a1a1a; }
    
    .avo-whatsapp { background: #25D366; color: #ffffff; }
    .avo-whatsapp:hover { background: #22c35e; }
    
    /* Minimalist outlined button for the Copy action */
    .avo-copy { 
        background: transparent; 
        color: #0f172a; 
        border: 1px solid #cbd5e1;
    }
    .avo-copy:hover { 
        background: #f8fafc; 
        border-color: #94a3b8;
    }
    
    /* Mobile responsiveness */
    @media (max-width: 600px) {
        .avo-share-container { margin: 30px 0; padding: 20px 0; }
        .avo-share-buttons { gap: 8px; }
        .avo-share-btn { padding: 10px 16px; font-size: 12px; flex-grow: 1; text-align: center; }
    }
    </style>

    <script>
    function avoCopyLink(button, url) {
        navigator.clipboard.writeText(url).then(function() {
            var originalText = button.innerHTML;
            button.innerHTML = "Copied!";
            button.style.background = "#25D366";
            button.style.color = "#ffffff";
            button.style.borderColor = "#25D366";
            setTimeout(function() {
                button.innerHTML = originalText;
                button.style.background = "";
                button.style.color = "";
                button.style.borderColor = "";
            }, 2000);
        }).catch(function(err) {
            console.error('Could not copy text: ', err);
        });
    }
    </script>
    <?php
}

// Optional activation hook
register_activation_hook(__FILE__, 'avo_share_activated');
function avo_share_activated() {
    // Left open for future upgrades
}
?>
