<?php


/**
 * reactor_add_image_attachment_fields_to_edit function.
 *
 * @access public
 * @param mixed $form_fields
 * @param mixed $post
 * @return $form_fields
 */
function reactor_add_image_attachment_fields_to_edit( $form_fields, $post ) {

	$chkd = get_post_meta( $post->ID, '_app_image' );

	$form_fields['appp_gallery_category'] = array(
		'label' => __('App Gallery'),
		'input' => 'text',
		'value' => get_post_meta( $post->ID, "_app_image_category", true ),
		'helps' => __('Add a category to filter your app image gallery.'),

	);

	return $form_fields;

}
add_filter( 'attachment_fields_to_edit', 'reactor_add_image_attachment_fields_to_edit', null, 2 );


/**
 * reactor_add_image_attachment_fields_to_save function.
 *
 * @access public
 * @param mixed $post
 * @param mixed $attachment
 * @return $post
 */
function reactor_add_image_attachment_fields_to_save( $post, $attachment ) {

	if( isset( $attachment['appp'] ) ){
		//update_post_meta( $post['ID'], '_app_image', $attachment['appp'] );
	}
	if( isset( $attachment['appp_gallery_category'] ) ){
		update_post_meta( $post['ID'], '_app_image_category', $attachment['appp_gallery_category'] );
	}

	return $post;
}
add_filter( 'attachment_fields_to_save', 'reactor_add_image_attachment_fields_to_save', null , 2 );
