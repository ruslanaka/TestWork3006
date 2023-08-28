<?php
/**
 * Functions of your template (function.php)
 * @package WordPress
 * @subpackage your-clean-template
 */



function abelo_added_tabs( array $tabs ): array {

	$tabs['special_panel'] = [
		'label'    => 'Abelo test', // название вкладки.
		'target'   => 'special_panel_product_data', // идентификатор вкладки.
		'priority' => 0, // приоритет вывода.
	];

	return $tabs;
}

add_filter( 'woocommerce_product_data_tabs', 'abelo_added_tabs', 10, 1 );


// Add custom meta box for date field
function custom_product_date_meta_box()
{
    add_meta_box(
        'custom_date_field',
        __('Product Date', 'textdomain'),
        'render_custom_date_field',
        'product',
        'normal',
        'default'
    );
}
add_action('woocommerce_product_options_general_product_data', 'custom_product_date_meta_box');

// Render custom date field
function render_custom_date_field($post)
{
    $date = get_post_meta($post->ID, 'custom_date_field', true);
    ?>
    <label for="custom_date_field"><?php esc_html_e('Product Date', 'textdomain'); ?></label>
    <input type="date" name="custom_date_field" id="custom_date_field" value="<?php echo esc_attr($date); ?>">
    <?php
}

// Save custom date field value
function save_custom_date_field($post_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (isset($_POST['custom_date_field'])) {
        update_post_meta($post_id, 'custom_date_field', sanitize_text_field($_POST['custom_date_field']));
    }
}
add_action('save_post_product', 'save_custom_date_field');






function art_woo_add_custom_fields() {

	global $product, $post;

	echo '<div id="special_panel_product_data" class="panel woocommerce_options_panel">'; 
	echo '<div class="options_group">'; 

	
	// Выбор значения.
	woocommerce_wp_select(
		[
			'id'      => '_select',
			'label'   => 'Выпадающий список',
			'options' => [
				'one'   => __( 'rare', 'woocommerce' ),
				'two'   => __( 'frequent', 'woocommerce' ),
				'three' => __( 'unusual', 'woocommerce' ),
			],
		]
	);

	echo '</div>'; 
	// Выбор товаров.

	 $image = get_post_meta($post->ID, 'product_image', true);
    ?>
    <label for="product_image"><?php esc_html_e('Product Image', 'textdomain'); ?></label>
    <div class="product-image-container">
        <?php if ($image) : ?>
            <img src="<?php echo esc_url($image); ?>" alt="Product Image1" width="100" style="width: 100px;">
        <?php endif; ?>
    </div>
    <input type="hidden" name="product_image" id="product_image" width="100" value="<?php echo esc_attr($image); ?>">
    <button type="button" class="button remove-image"><?php esc_html_e('Remove Image', 'textdomain'); ?></button>
    <button type="button" class="button upload-image"><?php esc_html_e('Upload Image', 'textdomain'); ?></button>
    <? echo '</div>'; ?>
    <script>
    	
jQuery(document).ready(function($) {
    // Upload button click event
    $('.upload-image').click(function(e) {
        e.preventDefault();
        var imageUploader = wp.media({
            title: 'Upload Image',
            button: { text: 'Use this Image' },
            multiple: false
        }).on('select', function() {
            var attachment = imageUploader.state().get('selection').first().toJSON();
            $('.product-image-container').html('<img width="100" src="' + attachment.url + '" alt="Product Image">');
            $('#product_image').val(attachment.url);
        }).open();
    });

    // Remove button click event
    $('.remove-image').click(function(e) {
        e.preventDefault();
        $('.product-image-container').html('');
        $('#product_image').val('');
    });
});
    </script>
	
	<?php
}
	
add_action( 'woocommerce_product_data_panels', 'art_woo_add_custom_fields' );



add_action( 'woocommerce_process_product_meta', 'art_woo_custom_fields_save', 10 );
function art_woo_custom_fields_save( $post_id ) {

	// Вызываем объект класса
	$product = wc_get_product( $post_id );

	// Сохранение текстового поля
	$text_field = isset( $_POST['product_image'] ) ? sanitize_text_field( $_POST['product_image'] ) : '';
	$product->update_meta_data( 'product_image', $text_field );

	// Сохранение цифрового поля
	$number_field = isset( $_POST['_number_field'] ) ? sanitize_text_field( $_POST['_number_field'] ) : '';
	$product->update_meta_data( '_number_field', $number_field );

	// Сохранение выпадающего списка
	$select_field = isset( $_POST['_select'] ) ? sanitize_text_field( $_POST['_select'] ) : '';
	$product->update_meta_data( '_textarea', $select_field );



	// Сохраняем все значения
	$product->save();

}

?>
