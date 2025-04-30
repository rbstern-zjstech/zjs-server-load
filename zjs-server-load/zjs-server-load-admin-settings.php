<?php

function zjs_server_load_add_settings_page() {
    add_options_page( 'ZJS Server Load', 'ZJS Server Load', 'manage_options', 'zjs_server_load', 'zjs_server_loadrender_plugin_settings_page' );
}
add_action( 'admin_menu', 'zjs_server_load_add_settings_page' );


function zjs_server_load_plugin_options() {
?>
	<label for='zjs-server-load-ajax-enable'>Update server loads via Ajax?</label>
	<input name='zjs-server-load-ajax-enable' type='checkbox' value=1>
<?php
}


function zjs_server_load_register_settings() {

	add_settings_field('zjs_server_load_setting-use-ajax',
	'Use Ajax',
 	'myprefix_setting_callback_function',
	'general',
	'myprefix_settings-section-name',
	array( 'label_for' => 'myprefix_setting-id' ) );


    register_setting( 'dbi_example_plugin_options', 'dbi_example_plugin_options', 'dbi_example_plugin_options_validate' );
    add_settings_section( 'api_settings', 'API Settings', 'dbi_plugin_section_text', 'dbi_example_plugin' );

    add_settings_field( 'zjs_server_load_setting_use_ajax', 'use_ajax', 'dbi_plugin_setting_api_key', 'dbi_example_plugin', 'api_settings' );
    add_settings_field( 'dbi_plugin_setting_results_limit', 'Results Limit', 'dbi_plugin_setting_results_limit', 'dbi_example_plugin', 'api_settings' );
    add_settings_field( 'dbi_plugin_setting_start_date', 'Start Date', 'dbi_plugin_setting_start_date', 'dbi_example_plugin', 'api_settings' );
}
add_action( 'admin_init', 'dbi_register_settings' );


function zjs_server_loadrender_plugin_settings_page() {
?>
	<h2>ZJS Server Load Settings</h2>
	<form action="options.php" method="post">
<?php 
		settings_fields('zjs_server_load_plugin_options');
		do_settings_sections('zjs_server_load_plugin'); 
?>
	<input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e( 'Save' ); ?>" />
	</form>
<?php
}