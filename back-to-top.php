<?php
/*
Plugin Name: Back 2 Top
Description: Adds a back-to-top button to your website, allowing users to effortlessly return to the top of the page anytime, anywhere.
Version: 1.1
Author: Eetu Karttunen
License: GPL2
*/

// Plugin URL and path constants
define('B2T_PLUGIN_URL', plugin_dir_url(__FILE__)); // URL for assets (CSS, JS)
define('B2T_PLUGIN_DIR', plugin_dir_path(__FILE__)); // Path for PHP files

// Connecting JS and CSS files
function back2top_assets() {
    wp_enqueue_style('back2top-style', B2T_PLUGIN_URL . 'assets/back-to-top.css');
    wp_enqueue_script('back2top-script', B2T_PLUGIN_URL . 'assets/back-to-top.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'back2top_assets');

// Display the button on the footer
function back2top_button() {
    echo '<div id="back2top">↑</div>';
}
add_action('wp_footer', 'back2top_button');

// Add settings page to admin menu
function back2top_menu() {
    add_options_page(
        'Back 2 Top settings',
        'Back 2 Top',
        'manage_options',
        'back2top',
        'back2top_settings_page'
    );
}
add_action('admin_menu', 'back2top_menu');

// Settings page callback function
function back2top_settings_page() {
    ?>
    <div class="wrap">
        <h1>Back to Top Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('back2top_settings');
            do_settings_sections('back2top');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register the settings
function back2top_register_settings() {
    // Register settings for the color, size, position, border radius, and hover color
    register_setting('back2top_settings', 'back2top_color');
    register_setting('back2top_settings', 'back2top_size');
    register_setting('back2top_settings', 'back2top_position');
    register_setting('back2top_settings', 'back2top_border_radius'); // Register the border radius setting
    register_setting('back2top_settings', 'back2top_hover_color'); // Register the hover color setting

    // Add settings section for customization
    add_settings_section(
        'back2top_section', 
        'Button Customization', 
        null, 
        'back2top'
    );

    // Add individual settings fields
    add_settings_field(
        'back2top_color', 
        'Button Color', 
        'back2top_color_field', 
        'back2top', 
        'back2top_section'
    );
    add_settings_field(
        'back2top_size', 
        'Button Size (px)', 
        'back2top_size_field', 
        'back2top', 
        'back2top_section'
    );
    add_settings_field(
        'back2top_position', 
        'Button Position', 
        'back2top_position_field', 
        'back2top', 
        'back2top_section'
    );
    add_settings_field(
        'back2top_border_radius', 
        'Button Border Radius (px)', 
        'back2top_border_radius_field', 
        'back2top', 
        'back2top_section'
    );
    add_settings_field(
        'back2top_hover_color', 
        'Button Hover Color', 
        'back2top_hover_color_field', 
        'back2top', 
        'back2top_section'
    );
}
add_action('admin_init', 'back2top_register_settings');

// Button Color field callback
function back2top_color_field() {
    $color = get_option('back2top_color', '#0073aa');
    echo '<input type="color" name="back2top_color" value="' . esc_attr($color) . '">';
}

// Button Size field callback
function back2top_size_field() {
    $size = get_option('back2top_size', '50');
    echo '<input type="number" name="back2top_size" value="' . esc_attr($size) . '" min="20" max="200"> px';
}

// Button Position field callback
function back2top_position_field() {
    $position = get_option('back2top_position', 'right');
    echo '<select name="back2top_position">
        <option value="right" ' . selected($position, 'right', false) . '>Bottom Right</option>
        <option value="left" ' . selected($position, 'left', false) . '>Bottom Left</option>
    </select>';
}

// Button Border Radius field callback
function back2top_border_radius_field() {
    $radius = get_option('back2top_border_radius', '50');
    echo '<input type="number" name="back2top_border_radius" value="' . esc_attr($radius) . '" min="0" max="100"> px';
}

// Button Hover Color field callback
function back2top_hover_color_field() {
    $hover_color = get_option('back2top_hover_color', '#005177');
    echo '<input type="color" name="back2top_hover_color" value="' . esc_attr($hover_color) . '">';
}

// Dynamic styling based on user settings
function back2top_dynamic_styles() {
    $color = get_option('back2top_color', '#0073aa');
    $size = get_option('back2top_size', '50');
    $position = get_option('back2top_position', 'right');
    $radius = get_option('back2top_border_radius', '50');
    $hover_color = get_option('back2top_hover_color', '#005177'); // Get the hover color setting

    $position_style = ($position === 'right') ? 'right:20px;' : 'left:20px;';

    // Output the dynamic CSS
    echo '<style>
        #back2top {
            position: fixed;
            bottom: 20px; /* Fixed to the bottom */
            ' . esc_attr($position_style) . ' /* Dynamically place left or right */
            background-color: ' . esc_attr($color) . ';
            width: ' . esc_attr($size) . 'px;
            height: ' . esc_attr($size) . 'px;
            line-height: ' . esc_attr($size) . 'px;
            color: white;
            text-align: center;
            border-radius: ' . esc_attr($radius) . 'px; /* Apply dynamic border radius */
            cursor: pointer;
            z-index: 1000;
            transition: background-color 0.3s ease;
        }
        #back2top:hover {
            background-color: ' . esc_attr($hover_color) . '; /* Apply dynamic hover color */
        }
    </style>';
}
add_action('wp_head', 'back2top_dynamic_styles');