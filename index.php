<?php

/**
 * Plugin Name: Students Result Management System
 * Description: Simple But Powerful Students Result Management System.
 * Version: 1.0
 * Author: BMS
 * Requires at least: 3.8
 * Tested Up to: 5.9.2
 * Stable Tag: 2.0
 * License: GPL v2
 * Shortname: jsrms or jsrms_
 */

include_once('boxes/functions.php');

/* ====================================
  Define plugin url ==================
====================================== */


define('JP_SRMS_PATH', WP_PLUGIN_URL . '/' . plugin_basename(dirname(__FILE__)) . '/');

/* Add style and script */

function jsrms_frontend_style()
{
	wp_register_style('jsrms_fstyle', plugin_dir_url(__FILE__) . 'css/style.css', false, '1.5');
	wp_enqueue_style('jsrms_fstyle');

	wp_register_script('jsrms_fscript', plugin_dir_url(__FILE__) . 'js/scripts.js', array('jquery'), '1.5');

	$jsrms_data = array(
		'ajaxUrl' => admin_url('admin-ajax.php'),
	);
	wp_localize_script('jsrms_fscript', 'jsrms_object', $jsrms_data);

	wp_enqueue_script('jsrms_fscript');
}
add_action('wp_enqueue_scripts', 'jsrms_frontend_style');

function jsrms_add_jquery()
{
	wp_enqueue_script('jquery');
}
add_action('init', 'jsrms_add_jquery');

/* --------------------------------------------------------------
-------------- Change custom post type title placeholder --------
--------------------------------------------------------------- */

function jsrms_change_default_title($title)
{
	$screen = get_current_screen();
	if ('jp_students_result' == $screen->post_type) {
		$title = 'Enter student name here';
	}
	return $title;
}

add_filter('enter_title_here', 'jsrms_change_default_title');

/* -----------------------------------------------------------------
---------------- Register new post type Result ---------------------
------------------------------------------------------------------- */

function jsrms_students_result_reg()
{
	$labels = array(
		'name' => _x('Students Result', 'post type general name'),
		'singular_name' => _x('Students Result', 'post type singular name'),
		'add_new' => _x('Add New', 'result'),
		'add_new_item' => __('Add New Result'),
		'edit_item' => __('Edit Result'),
		'new_item' => __('New Result'),
		'all_items' => __('All Students Result'),
		'view_item' => __('View Result'),
		'search_items' => __('Search Results'),
		'not_found' => __('No result found'),
		'not_found_in_trash' => __('No result found in the Trash'),
		'parent_item_colon' => '',
		'menu_name' => 'Students Result'
	);
	$args = array(
		'labels' => $labels,
		'description' => 'Add new custom post type students result',
		'public' => true,
		'menu_position' => 5,
		'supports' => array('thumbnail', 'title', ),
		'taxonomies' => array('classes'),
		'has_archive' => true,
		'menu_icon' => 'dashicons-database'
	);
	register_post_type('jp_students_result', $args);
}
add_action('init', 'jsrms_students_result_reg');

/* ---------------------------------------------
------------ Add Students Classes --------------
---------------------------------------------- */
/*

add_action( 'init', 'jsrms_students_classes_reg', 0 );

function jsrms_students_classes_reg() {
	// Classes taxonomy
	$labels = array(
		'name'              => _x( 'Classes', 'taxonomy general name' ),
		'singular_name'     => _x( 'Class', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Class' ),
		'all_items'         => __( 'All Class' ),
		'parent_item'       => __( 'Parent Class' ),
		'parent_item_colon' => __( 'Parent Class:' ),
		'edit_item'         => __( 'Edit Class' ),
		'update_item'       => __( 'Update Class' ),
		'add_new_item'      => __( 'Add New Class' ),
		'new_item_name'     => __( 'New Class' ),
		'menu_name'         => __( 'Classes' ),
	);
	
	register_taxonomy( 'classes', 'jp_students_result', array(
		'hierarchical' => true,
		'labels' => $labels,
		'query_var' => true,
		'rewrite' => true,
		'show_admin_column' => true	
	) );
	
}
*/

/* ---------------------------------------
------- Add students result year ---------
--------------------------------------- */

/*

add_action( 'init', 'jsrms_students_result_year_reg', 0 );

function jsrms_students_result_year_reg() {
	// Years taxonomy
	$labels = array(
		'name'              => _x( 'Years', 'taxonomy general name' ),
		'singular_name'     => _x( 'year', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Year' ),
		'all_items'         => __( 'All Year' ),
		'parent_item'       => __( 'Parent Year' ),
		'parent_item_colon' => __( 'Parent Year:' ),
		'edit_item'         => __( 'Edit Year' ),
		'update_item'       => __( 'Update Year' ),
		'add_new_item'      => __( 'Add New Year' ),
		'new_item_name'     => __( 'New Year' ),
		'menu_name'         => __( 'Years' ),
	);
	
	register_taxonomy( 'years', 'jp_students_result', array(
		'hierarchical' => true,
		'labels' => $labels,
		'query_var' => true,
		'rewrite' => true,
		'show_admin_column' => true	
	) );
	
}

*/

/* ----------------------------------------------------
------- Change student result upadate message ---------
----------------------------------------------------- */

function jsrms_students_result_update_message($messages)
{
	global $post, $post_ID;
	$messages['jp_students_result'] = array(
		0 => '',
		1 => sprintf(__('Result updated. <a href="%s">View result</a>'), esc_url(get_permalink($post_ID))),
		2 => __('Custom field updated.'),
		3 => __('Custom field deleted.'),
		4 => __('Result updated.'),
		5 => isset($_GET['revision']) ? sprintf(__('Result restored to revision from %s'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
		6 => sprintf(__('Result published. <a href="%s">View result</a>'), esc_url(get_permalink($post_ID))),
		7 => __('Result saved.'),
		8 => sprintf(__('Result submitted. <a target="_blank" href="%s">Preview result</a>'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
		9 => sprintf(__('Result scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview result</a>'), date_i18n(__('M j, Y @ G:i'), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
		10 => sprintf(__('Result draft updated. <a target="_blank" href="%s">Preview result</a>'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
	);
	return $messages;
}
add_filter('post_updated_messages', 'jsrms_students_result_update_message');

/* ---------------------------------------------
------------ Result search & view ------------
--------------------------------------------- */

function jsrms_result_search_and_view()
{
	ob_start();
	?>

	<div class="result-search-form">
		<form action="" id="result-form" method="post">
			<div class="form-row">
				<label for="exam-reg">Certificate No.</label>
				<input type="text" id="exam-reg" name="exam_reg" required placeholder="Enter certificate number" />
			</div>
			<div class="form-row">
				<input type="submit" value="Result" class="result-submit-btn" name="exam_result" />
				<img class="loader" src="<?php echo plugin_dir_url(__FILE__) . 'images/spinner.gif' ?>" alt="Loading..."
					style="display: none;" />
			</div>
		</form>
	</div>

	<div class="jsrms-result"></div>

	<?php
	return ob_get_clean();
}

add_shortcode('jp_students_result_sc', 'jsrms_result_search_and_view');

/*--------------------------------------------------*/
/* Result using ajax------------------------------- */
/*-------------------------------------------------*/

function jsrms_result_using_ajax()
{
	$exam_reg = sanitize_text_field($_POST['exam_reg']);

	if (!empty($exam_reg)) {
		$args = array(
			'post_type' => 'jp_students_result',
			'meta_key' => '_jp_student_reg',
			'meta_query' => array(
				array(
					'key' => '_jp_student_reg',
					'value' => $exam_reg,
					'compare' => '='
				)
			),
			'posts_per_page' => 1
		);

		$query = new WP_Query($args);

		if ($query->have_posts()):
			while ($query->have_posts()):
				$query->the_post();
				$post_id = get_the_ID();
				?>
				<div class="student-result">
					<table cellpadding="5" class="student-info">
						<tbody>
							<tr>
								<td>Name</td>
								<td><?php the_title(); ?></td>
							</tr>
							<tr>
								<td>Care of</td>
								<td><?php echo esc_html(get_post_meta($post_id, '_jp_student_father_name', true)); ?></td>
							</tr>
							<tr>
								<td>Session</td>
								<td><?php echo esc_html(get_post_meta($post_id, '_jp_student_mother_name', true)); ?></td>
							</tr>
							<tr>
								<td>Course</td>
								<td><?php echo esc_html(get_post_meta($post_id, '_jp_student_type', true)); ?></td>
							</tr>
							<tr>
								<td>Certificate No.</td>
								<td><?php echo esc_html(get_post_meta($post_id, '_jp_student_reg', true)); ?></td>
							</tr>
							<tr>
								<td>Percentage</td>
								<td><?php echo esc_html(get_post_meta($post_id, '_jp_total_gpa', true)); ?></td>
							</tr>
						</tbody>
					</table>
				</div>
				<?php
			endwhile;
			wp_reset_postdata();
		else: ?>
			<div class="student-result">
				<div class="result-error">
					<span>Result not found or not published yet.</span>
				</div>
			</div>
			<?php
		endif;
	}
	die();
}

add_action('wp_ajax_jsrms_student_result_view', 'jsrms_result_using_ajax');
add_action('wp_ajax_nopriv_jsrms_student_result_view', 'jsrms_result_using_ajax');

/*-------------------------------
 Shortcode menu------------------
--------------------------------*/

function jsrms_shortcode_menu()
{

	add_submenu_page('edit.php?post_type=jp_students_result', 'Shortcode', 'Shortcode', 'manage_options', 'jsrms_shortcode_menu', 'jsrms_shortcode_admin_page');

}

add_action('admin_menu', 'jsrms_shortcode_menu');

function jsrms_shortcode_admin_page()
{ ?>

	<div class="wrap">
		<!-- Some inline style -->
		<style type="text/css">
			h2.jsrmsp-main-title {
				text-align: left;
				background: #ddd;
				padding: 10px;
				margin-top: 0;
			}

			h3.jsrmsp-m-title {
				margin: 0 !important;
				padding: 8px 12px !important;
			}

			div.jsupnsuc {
				background: #ededed none repeat scroll 0 0;
				border-left: 1px solid lime;
				border-right: 1px solid #00E400;
				padding: 5px;
			}

			div.jsvardlnins {
				overflow: hidden;
			}

			a.jsnvardl {
				color: #fff;
				float: left;
				text-align: center;
				padding: 5px 0;
				width: 50%;
			}

			a#ddl {
				background: #00ff00 none repeat scroll 0 0;
				color: #222;
			}

			a#ddn {
				background: #00e400 none repeat scroll 0 0;
			}
		</style>
		<div id="dashboard-widgets-wrap">
			<div class="metabox-holder" id="dashboard-widgets">
				<div id="postbox-container" class="postbox-container">
					<div id="side-sortables" class="meta-box-sortables ui-sortable">
						<div style="display: block;" id="dashboard_quick_press" class="postbox ">
							<h2 class="jsrmsp-main-title"><?php _e('Shortcode'); ?></h2>
							<h3 class="hndle jsrmsp-m-title" style="cursor: default;"><span><span class="hide-if-no-js">Use
										shortcode <input type="text" value="[jp_students_result_sc]" /> inside post or page
										to show the Result Search Form</span></span></h3>
							<div style="overflow: hidden; padding-bottom: 10px;" class="inside">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php }

/*-------------------------------
 Premium Features menu------------------
--------------------------------*/

/*
function jsrms_premium_features_menu(){

	add_submenu_page( 'edit.php?post_type=jp_students_result', 'Premium Version Features', 'Get Premium', 'manage_options', 'jsrms_premium_features_page', 'jsrms_premium_features_admin_page' );

}

add_action('admin_menu','jsrms_premium_features_menu');

function jsrms_premium_features_admin_page() { ?>
	
	<div class="wrap">
		<!-- Some inline style -->
		<style type="text/css">
			h2.jsrmsp-main-title {
				text-align: left;
				background: #ddd;
				padding: 10px;
				margin-top: 0;
			}
			h3.jsrmsp-m-title {
			  margin: 0 !important;
			  padding: 8px 12px !important;
			}
			div.jsupnsuc {
				background: #ededed none repeat scroll 0 0;
				border-left: 1px solid lime;
				border-right: 1px solid #00E400;
				padding: 5px;
			}
			div.jsvardlnins {
				overflow: hidden;
			}
			a.jsnvardl {
			  color: #fff;
			  float: left;
			  text-align: center;
			  padding: 5px 0;
			  width: 50%;
			}
			a#ddl {
			  background: #00ff00 none repeat scroll 0 0;
			  color: #222;
			}
			a#ddn {
			  background: #00e400 none repeat scroll 0 0;
			}
		</style>
		<div id="dashboard-widgets-wrap">
			<div class="metabox-holder" id="dashboard-widgets">
				<div id="postbox-container" class="postbox-container">
					<div id="side-sortables" class="meta-box-sortables ui-sortable"><div style="display: block;" id="dashboard_quick_press" class="postbox ">
						<h2 class="jsrmsp-main-title"><?php _e('Premium Features'); ?></h2>
						<h3 class="hndle jsrmsp-m-title" style="cursor: default;"><span><span class="hide-if-no-js">Why you need premium version?</span></span></h3>
					<div style="overflow: hidden; padding-bottom: 10px;" class="inside">
						<ul style="list-style: square; margin-left: 35px">
							<li>Subject wise result adding facility.</li>
							<li>Certificate adding facility.</li>
							<li>Unlimited subject, class, year, group and section.</li>
							<li>Result adding facility from CSV file.</li>
							<li>Multiple result adding facility from CSV file.</li>
							<li>Result export (backup) facility to CSV file.</li>
							<li>Advanced result search form.</li>
							<li>Seven different result search form.</li>
							<li>Full customizable result search form.</li>
							<li>Ajax powered result search form.</li>
							<li>Responsive and customizable custom page template.</li>
							<li>Result print facility.</li>
							<li>Certificate view and download facility.</li>
							<li>Plugin’s own update engine.</li>
							<li>Translation support.</li>
							<li>Shortcode system.</li>
							<li>WordPress multisite support.</li>
							<li>Setting panel and many more.</li>
							<li>Android app for result search.</li>
							<li>Both online &amp; offline documentation.</li>
						</ul>
						<p style="margin: 10px 14px;"><a title="More detail & Live Demo" target="_blank" href="https://skjoy.info/shop/jp-students-result-management-system-premium" class="button button-primary">Watch Demo & Buy</a></p>
					</div>
					</div>
					</div>	
				</div>
			</div>
		</div>
	</div>
	
<?php }

function jsrms_activate() {

	$url = get_site_url();
	$message = "Your Result System Plugin has activated on $url ";
	$message = wordwrap($message, 70, "\r\n");

	wp_mail('joy2012bd@gmail.com', 'Result System Plugin Activated', $message);
}
register_activation_hook( __FILE__, 'jsrms_activate' );

*/

?>