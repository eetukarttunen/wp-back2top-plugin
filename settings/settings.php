<?php
// Ensuring that this file is loaded only through WordPress
if (!defined('ABSPATH')) {
    exit;
}

function back2top_settings_page() {
    ?>
    <div class="wrap">
        <h1>Back 2 Top -plugin settings</h1>
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
    register_setting('back2top_settings', 'back2top_color');
    register_setting('back2top_settings', 'back2top_size');
    register_setting('back2top_settings', 'back2top_position');

    add_settings_section(
        'back2top_section', 
        'Button Customization', 
        null, 
        'simple-back-to-top'
    );

    // Color
    add_settings_field(
        'back2top_color', 
        'Button Color', 
        'back2top_color_field', 
        'simple-back-to-top', 
        'back2top_section'
    );

    // Size
    add_settings_field(
        'back2top_size', 
        'Button Size (px)', 
        'back2top_size_field', 
        'simple-back-to-top', 
        'back2top_section'
    );

    // Position
    add_settings_field(
        'back2top_position', 
        'Button Position', 
        'back2top_position_field', 
        'simple-back-to-top', 
        'back2top_section'
    );
}
add_action('admin_init', 'back2top_register_settings');

// Button Color
function back2top_color_field() {
    $color = get_option('back2top_color', '#0073aa');
    echo '<input type="color" name="back2top_color" value="' . esc_attr($color) . '">';
}

// Button Size
function back2top_size_field() {
    $size = get_option('back2top_size', '50');
    echo '<input type="number" name="back2top_size" value="' . esc_attr($size) . '" min="20" max="200"> px';
}

// Button Position
function back2top_position_field() {
    $position = get_option('back2top_position', 'right');
    echo '<select name="back2top_position">
        <option value="right" ' . selected($position, 'right', false) . '>Bottom Right</option>
    </select>';
}
