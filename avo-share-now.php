<?php
/*
Plugin Name: AvoShare Now
Plugin URI: https://github.com/avocadowebservices/Avo-Share-Now
Description: Lightweight social sharing for WordPress with zero bloat. Share to Twitter, Facebook, WhatsApp, LinkedIn, and Email. No tracking, no ads, no external dependencies.
Version: 1.1
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
    $encoded_message = urlencode($post_title . ' ' . $post_url);
    
    // Build share links
    $twitter_url = 'https://twitter.com/intent/tweet?text=' . $encoded_title . '&url=' . $encoded_url;
    $facebook_url = 'https://www.facebook.com/sharer/sharer.php?u=' . $encoded_url;
    $whatsapp_url = 'https://api.whatsapp.com/send?text=' . $encoded_message;
    $linkedin_url = 'https://www.linkedin.com/sharing/share-offsite/?url=' . $encoded_url;
    $email_url = 'mailto:?subject=' . $encoded_title . '&body=' . $encoded_url;
    
    // Build HTML for share buttons
    $share_html = '<div class="avo-share-container">';
    $share_html .= '<p class="avo-share-label">Share this post:</p>';
    $share_html .= '<div class="avo-share-buttons">';
    $share_html .= '<a href="' . esc_url($twitter_url) . '" class="avo-share-btn avo-twitter" target="_blank" rel="noopener noreferrer">Twitter</a>';
    $share_html .= '<a href="' . esc_url($facebook_url) . '" class="avo-share-btn avo-facebook" target="_blank" rel="noopener noreferrer">Facebook</a>';
    $share_html .= '<a href="' . esc_url($whatsapp_url) . '" class="avo-share-btn avo-whatsapp" target="_blank" rel="noopener noreferrer">WhatsApp</a>';
    $share_html .= '<a href="' . esc_url($linkedin_url) . '" class="avo-share-btn avo-linkedin" target="_blank" rel="noopener noreferrer">LinkedIn</a>';
    $share_html .= '<a href="' . esc_url($email_url) . '" class="avo-share-btn avo-email">Email</a>';
    $share_html .= '</div>';
    $share_html .= '</div>';
    
    // Return content with share buttons appended at the end
    return $content . $share_html;
}

// Add CSS styling
add_action('wp_head', 'avo_share_styles');

function avo_share_styles() {
    ?>
    <style>
    .avo-share-container {
        margin: 30px 0;
        padding: 20px;
        background: #f9f9f9;
        border-left: 4px solid #333;
        border-radius: 4px;
    }
    
    .avo-share-label {
        margin: 0 0 12px 0;
        font-weight: 600;
        font-size: 14px;
        color: #333;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .avo-share-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    
    .avo-share-btn {
        display: inline-block;
        padding: 10px 18px;
        border-radius: 3px;
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.2s ease;
        cursor: pointer;
        border: none;
    }
    
    .avo-share-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    .avo-twitter {
        background: #1DA1F2;
        color: white;
    }
    
    .avo-twitter:hover {
        background: #1a91da;
    }
    
    .avo-facebook {
        background: #1877F2;
        color: white;
    }
    
    .avo-facebook:hover {
        background: #165ec5;
    }
    
    .avo-whatsapp {
        background: #25D366;
        color: white;
    }
    
    .avo-whatsapp:hover {
        background: #1fb554;
    }
    
    .avo-linkedin {
        background: #0A66C2;
        color: white;
    }
    
    .avo-linkedin:hover {
        background: #084fa0;
    }
    
    .avo-email {
        background: #666;
        color: white;
    }
    
    .avo-email:hover {
        background: #555;
    }
    
    /* Mobile responsiveness */
    @media (max-width: 600px) {
        .avo-share-container {
            margin: 20px 0;
            padding: 15px;
        }
        
        .avo-share-buttons {
            gap: 8px;
        }
        
        .avo-share-btn {
            padding: 9px 14px;
            font-size: 12px;
        }
    }
    </style>
    <?php
}

// Add plugin activation message (optional)
register_activation_hook(__FILE__, 'avo_share_activated');

function avo_share_activated() {
    // Could add setup code here if needed
    // For now, just a simple activation function
}
?>
