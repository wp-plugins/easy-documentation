<?php

/**
 * Plugin Name: Easy-Documentation
 * Description: Plugin for fast documentation creating process.
 * Version: 0.1
 * Author: WP Geeks
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

add_action( 'admin_init', 'wpg_settings_init' );
add_action('admin_menu', 'add_menu_pages');
add_action('admin_enqueue_scripts', 'wpg_docs_load_files');
add_action('admin_print_footer_scripts','rc_quicktags');

/* Adds menu pages*/
function add_menu_pages() {
	add_menu_page( 'Documentation', 'Documentation', 'manage_options', 'wpg-docs', 'show_docs_view', 'dashicons-media-text', 3 );
	add_submenu_page( 'wpg-docs', 'Documentation', 'Settings', 'manage_options', 'wpg-docs-settings', 'show_docs_settings_view');
}

/* Enqueue CSS and JS*/
function wpg_docs_load_files() {
	wp_enqueue_style( 'wpg_docs_styles', plugins_url( '/css/style.css	', __FILE__ ) );
    wp_enqueue_style( 'nyroModal_style', plugins_url( '/nyroModal/styles/nyroModal.css	', __FILE__ ) );

	wp_register_script( 'wpg_docs_js', plugins_url( '/js/functions.js', __FILE__ ) );
    wp_register_script( 'nyroModal', plugins_url( '/nyroModal/js/jquery.nyroModal.custom.js', __FILE__ ) );
    wp_register_script( 'nyroInit', plugins_url( '/nyroModal/js/nyroInit.js', __FILE__ ) );
	wp_register_script( 'cookies', plugins_url( '/js/jquery.cookie.js', __FILE__ ) );


	wp_enqueue_script('wpg_docs_js');
    wp_enqueue_script('nyroModal');
    wp_enqueue_script('nyroInit');
    wp_enqueue_script('cookies');
}

function wpg_settings_init() {

	add_settings_section(
		'eg_setting_section',
		'How to use?',
		'wpg_setting_section_callback',
		'wpg-docs-settings'
	);

	add_settings_field(
		'eg_setting_name',
		'Documentation editor',
		'wpg_setting_callback',
		'wpg-docs-settings',
		'eg_setting_section'
	);

    add_settings_field(
        'docs_page_header',
        'Documentation header',
        'docs_page_header_callback',
        'wpg-docs-settings',
        'eg_setting_section'
    );

	register_setting( 'wpg-docs-settings', 'eg_setting_name' );
    register_setting( 'wpg-docs-settings', 'docs_page_header' );

}

/* Adding Quicktag buttons to wp_editor */

function rc_quicktags() { ?>
	<script language="javascript" type="text/javascript">
		if(typeof(QTags) == 'function') {
			QTags.addButton( 'instructions', 'instructions', '<div class="instructions">', '</div>');
			QTags.addButton( 'headline', 'headline', '<p class="headline">', '</p>');
			QTags.addButton( 'p', 'p', '<p>', '</p>');
			QTags.addButton( 'h3', 'h3', '<h3>', '</h3>');
			QTags.addButton( 'figure', 'figure', '<figure>', '</figure>');
			QTags.addButton( 'add_lightbox', 'add_lightbox', ' class="nyroModal" title=" "');
			QTags.addButton( 'figcaption', 'figcaption', '<figcaption>', '</figcaption>');
			QTags.addButton( 'hover_enlarge', 'hover_enlarge', '<span class="text_enlarge">', '</span>');
		}
	</script>
<?php
}
/*  Function that fills the section with the desired content. The function should echo its output. */
function wpg_setting_section_callback() {
	?>
	<div class="docs_manual">
		<ul>
			<li><p>1. Use Text mode in the editor</p></li>
			<li><p>2. Each documentation topic should be contained in li tag</p></li>
            <li><p>3. Documentation Header is editable via text input below text editor</p></li>
			<li><p>4. There is a short guide how to create documentation HTML in the picture below (click to zoom)</p>
                <a href="<?php echo plugins_url( '/img/instructions.jpg' ,  __FILE__); ?>"  class="nyroModal" title="Tags description"'>
                    <img class="wpg-manual-img" src=<?php echo plugins_url( '/img/instructions.jpg' ,  __FILE__); ?> >
				</a>
			</li>
		</ul>
	</div>

	<?php
}

function wpg_setting_callback() {
	wp_editor( get_option( 'eg_setting_name' ), 'settings_editor', array('textarea_name' => 'eg_setting_name'));
}

function docs_page_header_callback(){
    echo '<input name="docs_page_header" size="30" type="text" value="' . get_option('docs_page_header') . '"/>';
}
/* Plugin view */
function show_docs_view() {
?>

	<div class="wpg_docs_wrapper">
		<div class="wpg_docs_header">
			<h2><?php echo get_option( 'docs_page_header' ) ?></h2>
		</div>
		<div class="wpg_docs_content">
			<ol>
				<?php echo get_option( 'eg_setting_name' ) ?>
			</ol>
		</div>
	</div>

<?php
}
/* Plugin settings view */
function show_docs_settings_view() {
	?>
	<div class="wpg_docs_wrapper">
		<div class="wpg-row">

			<?php
			//if cookie is set - display the warning box with warning button
			$cookie_name = "button_clicked";
			if(!isset($_COOKIE[$cookie_name])){
				?>
				<div class="warning_box">
					<h2>Warning!</h2>
					<p>This page is intended only for developers. It is strongly recommended not to enter unless you are an advanced user.</p>
					<div class="button_center">
						<button id="warning_button" class="button button-primary">Enter</button>
					</div>

				</div>
			<?php
			}
			?>


			<div class="wpg_docs_header settings-header">
				<h2>Easy-Documentation Settings</h2>
			</div>

			<div class="wpg_docs_content">

				<form method="post" action="options.php">
					<?php
					settings_fields('wpg-docs-settings');
					do_settings_sections('wpg-docs-settings');

					submit_button();
					?>
				</form>
			</div>

		</div>

	</div>

<?php
}

?>