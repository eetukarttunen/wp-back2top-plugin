<?php
// Ensuring that this file is loaded only through WordPress
if (!defined('ABSPATH')) {
    exit;
}

function back2top_settings_page() {
    ?>
    <div class="wrap">
        <h1>Back2Top settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('back2top_settings');
            do_settings_sections('simple-back-to-top');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function back2top_register_settings() {
    // Registering the settings
    register_setting('back2top_settings', 'back2top_color');
    register_setting('back2top_settings', 'back2top_size');
    register_setting('back2top_settings', 'back2top_position');
    register_setting('back2top_settings', 'back2top_border_radius'); // Register border radius setting

    // Adding settings section
    add_settings_section(
        'back2top_section', 
        'Button Customization', 
        null, 
        'simple-back-to-top'
    );

    // Color Field
    add_settings_field(
        'back2top_color', 
        'Button Color', 
        'back2top_color_field', 
        'simple-back-to-top', 
        'back2top_section'
    );

    // Size Field
    add_settings_field(
        'back2top_size', 
        'Button Size (px)', 
        'back2top_size_field', 
        'simple-back-to-top', 
        'back2top_section'
    );

    // Position Field
    add_settings_field(
        'back2top_position', 
        'Button Position', 
        'back2top_position_field', 
        'simple-back-to-top', 
        'back2top_section'
    );

    // Border Radius Field
    add_settings_field(
        'back2top_border_radius', 
        'Button Border Radius (px)', 
        'back2top_border_radius_field', 
        'simple-back-to-top', 
        'back2top_section'
    );
}
add_action('admin_init', 'back2top_register_settings');

// Button Color Field
function back2top_color_field() {
    $color = get_option('back2top_color', '#0073aa');
    echo '<input type="color" name="back2top_color" value="' . esc_attr($color) . '">';
}

// Button Size Field
function back2top_size_field() {
    $size = get_option('back2top_size', '50');
    echo '<input type="number" name="back2top_size" value="' . esc_attr($size) . '" min="20" max="200"> px';
}

// Button Position Field
function back2top_position_field() {
    $position = get_option('back2top_position', 'right');
    echo '<select name="back2top_position">
        <option value="right" ' . selected($position, 'right', false) . '>Bottom Right</option>
        <option value="left" ' . selected($position, 'left', false) . '>Bottom Left</option>
    </select>';
}

// Button Border Radius Field
function back2top_border_radius_field() {
    // Get the value of border radius, default to 50px
    $radius = get_option('back2top_border_radius', '50');
    echo '<input type="number" name="back2top_border_radius" value="' . esc_attr($radius) . '" min="0" max="100"> px';
}

