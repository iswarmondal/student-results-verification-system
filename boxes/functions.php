<?php

/* Metaboxes */

add_filter( 'cmb_meta_boxes', 'jp_student_informations' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function jp_student_informations( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_jp_';

	/**
	 * Information
	 */
	$meta_boxes['student_information'] = array(
		'id'         => 'student_information',
		'title'      => __( 'Student Information', 'cmb' ),
		'pages'      => array( 'jp_students_result', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
		'fields'     => array(
			
			array(
				'name' => __( 'Care of', 'cmb' ),
				'desc' => __( 'Care of is (required)', 'cmb' ),
				'id'   => $prefix . 'student_father_name',
				'type' => 'text_medium',
				// 'repeatable' => true,
			),
			
			array(
				'name' => __( 'Session', 'cmb' ),
				'desc' => __( 'Session of study in year (required)', 'cmb' ),
				'id'   => $prefix . 'student_mother_name',
				'type' => 'text_medium',
				// 'repeatable' => true,
			),
			
			array(
				'name' => __( 'Course', 'cmb' ),
				'desc' => __( 'Enter the course name (required)', 'cmb' ),
				'id'   => $prefix . 'student_type',
				'type'    => 'text_medium',
				'options' => array(
					'Regular' => __( 'Regular', 'cmb' ),
					'Irregular'   => __( 'Irregular', 'cmb' ),
				),
				// 'repeatable' => true,
			),
			
// 			array(
// 				'name' => __( 'Date OF Birth', 'cmb' ),
// 				'desc' => __( 'student date of birth (required)', 'cmb' ),
// 				'id'   => $prefix . 'student_birth_date',
// 				'type' => 'text_date',
// 				// 'repeatable' => true,
// 			),
			
// 			array(
// 				'name'    => __( 'Sex', 'cmb' ),
// 				'desc'    => __( 'Selet student sex (required)', 'cmb' ),
// 				'id'      => $prefix . 'student_sex',
// 				'type'    => 'select',
// 				'options' => array(
// 					'Male' => __( 'Male', 'cmb' ),
// 					'Female'   => __( 'Female', 'cmb' ),
// 					'Other'   => __( 'Other', 'cmb' ),
// 					'Prefer not to say'   => __( 'Prefer not to say', 'cmb' ),
// 				),
// 			),
			
			// array(
			// 	'name'    => __( 'Religion', 'cmb' ),
			// 	'desc'    => __( 'Selet student religion (required)', 'cmb' ),
			// 	'id'      => $prefix . 'student_religion',
			// 	'type'    => 'select',
			// 	'options' => array(
			// 		'Hindu' => __( 'Hindu', 'cmb' ),
			// 		'Muslim'   => __( 'Muslim', 'cmb' ),
			// 		'Other'   => __( 'Other', 'cmb' ),
			// 	),
			// ),
			
			// array(
			// 	'name' => __( 'Roll No', 'cmb' ),
			// 	'desc' => __( 'student roll no (required)', 'cmb' ),
			// 	'id'   => $prefix . 'student_roll',
			// 	'type' => 'text_medium',
			// 	// 'repeatable' => true,
			// ),
			
			array(
				'name' => __( 'Reg No', 'cmb' ),
				'desc' => __( 'student registration no (required)', 'cmb' ),
				'id'   => $prefix . 'student_reg',
				'type' => 'text_medium',
				// 'repeatable' => true,
			),
			
			
			
			array(
				'name' => __( 'Percentage', 'cmb' ),
				'desc' => __( 'Percentage (required)', 'cmb' ),
				'id'   => $prefix . 'total_gpa',
				'type' => 'text_medium',
				// 'repeatable' => true,
			),
			
		),
	);
	

	// Add other metaboxes as needed

	return $meta_boxes;
}

add_action( 'init', 'student_info_initialize', 9999 );
/**
 * Initialize the metabox class.
 */
function student_info_initialize() {

	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once 'init.php';

}
