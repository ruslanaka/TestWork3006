<?php
/**
 * Functions of your template (function.php)
 * @package WordPress
 * @subpackage your-clean-template
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Создаем новый таб для своих полей
function abelo_added_tabs( array $tabs ): array {

	$tabs['special_panel'] = [
		'label'    => 'Abelo test', // название вкладки.
		'target'   => 'special_panel_product_data', // идентификатор вкладки.
		'priority' => 0, // приоритет вывода.
	];

	return $tabs;
}

add_filter( 'woocommerce_product_data_tabs', 'abelo_added_tabs', 10, 1 );



// Custom fields
function abelo_add_custom_fields() {

	global $product, $post;

	?>
	<div id="special_panel_product_data" class="panel woocommerce_options_panel">
	<? 
	//Выпадающий список
	$custom_select_field = get_post_meta($post->ID, 'custom_select_field', true);
	?>
	<p class="form-field">
		<label for="custom_select_field">Выпадающий список</label>
		<select name="custom_select_field" id="custom_select_field">
			<option>Выбрать</option>
			<option <?php if ($custom_select_field == 'rare') { ?> selected<?php } ?> value="rare">rare</option>
			<option <?php if ($custom_select_field == 'frequent') { ?> selected<?php } ?> value="frequent">frequent</option>
			<option <?php if ($custom_select_field == 'unusual') { ?> selected<?php } ?> value="unusual">unusual</option>
		</select>
	</p>
	<p class="form-field">
    <?
	//Поле типа Date
	$custom_date_field = get_post_meta($post->ID, 'custom_date_field', true);
    ?>
    	<label for="custom_date_field">Дата добавления</label>
    	<input type="date" name="custom_date_field" id="custom_date_field" value="<?php echo esc_attr($custom_date_field); ?>">
    </p>
	<?	
	//Фото
	$image = get_post_meta($post->ID, 'product_image', true);
    ?>
    <p class="form-field">
	    <label for="product_image">Product Image</label>

	    <span class="product-image-container">
	        <?php if ($image) : ?>
	            <img src="<?php echo esc_url($image); ?>" alt="Product Image" width="100">
	        <?php endif; ?>
	    </span>
	    <br>
	    <input type="hidden" name="product_image" id="product_image" width="100" value="<?php echo esc_attr($image); ?>">
	    <button type="button" class="button upload-image button-primary">Upload Image</button>

	    <button type="button" class="button remove-image">Remove Image</button>
	</p>
	<br>
	<p class="form-field">
		<button type="button" class="button remove-all-image">Удалить все custom fields</button>
		<button type="button" class="button save-btn button-primary">Сохранить</button>
	</p>
	</div>
    <script>
    	
		jQuery(document).ready(function($) {
		    // Загрузка
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

		    // Удаление
		    $('.remove-image').click(function(e) {
		        e.preventDefault();
		        $('.product-image-container').html('');
		        $('#product_image').val('');
		    });

		    // Удаление всех полей
		    $('.remove-all-image').click(function(e) {
		        e.preventDefault();
		        $('.product-image-container').html('');
		        $('#product_image').val('');
		        $('#custom_date_field').val('');
		        $('#custom_select_field').val('');

		    });

		    $('.save-btn').click(function(e) {
		        e.preventDefault();
		        $('#publish').trigger('click');
		    });
		    
		});
    </script>
	
	<?php
}
	
add_action( 'woocommerce_product_data_panels', 'abelo_add_custom_fields' );

add_action( 'woocommerce_process_product_meta', 'abelo_custom_fields_save', 10 );

function abelo_custom_fields_save( $post_id ) {

	$product = wc_get_product( $post_id );

	// Сохранение image
	$product_image = isset( $_POST['product_image'] ) ? sanitize_text_field( $_POST['product_image'] ) : '';
	$product->update_meta_data( 'product_image', $product_image );

	// Сохранение поля date
	$date_field = isset( $_POST['custom_date_field'] ) ? sanitize_text_field( $_POST['custom_date_field'] ) : '';
	$product->update_meta_data( 'custom_date_field', $date_field );

	// Сохранение выпадающего списка
	$select_field = isset( $_POST['custom_select_field'] ) ? sanitize_text_field( $_POST['custom_select_field'] ) : '';
	$product->update_meta_data( 'custom_select_field', $select_field );



	// Сохраняем все значения
	$product->save();

}


// Удаляем родную колонку картинки
add_filter('manage_edit-product_columns', 'remove_product_image_column');
function remove_product_image_column($columns) {
    unset($columns['thumb']);
    return $columns;
}


// Добавляем новую колонку
function custom_product_image_column($columns) {
    $columns['custom_image'] = 'Image';
    return $columns;
}
add_filter('manage_product_posts_columns', 'custom_product_image_column');

// Заполняем новую колонку данными
function custom_product_image_column_content($column, $post_id) {
    if ($column == 'custom_image') {
        $custom_image = get_post_meta($post_id, 'product_image', true);
        if (!empty($custom_image)) {
            echo '<img src="' . esc_attr($custom_image) . '" width="50" height="50" />';
        }
    }
}
add_action('manage_product_posts_custom_column', 'custom_product_image_column_content', 1, 2);

// Удаляем колонку артикул, чтобы освободить место
add_filter('manage_edit-product_columns', 'remove_product_sku_column');
function remove_product_sku_column($columns) {
    unset($columns['sku']);
    return $columns;
}



// Передвигаем колонку картинок на нужное место
function move_product_customimage_column($columns) {
    $tags_column = $columns['custom_image'];
    unset($columns['custom_image']);
    $columns = array_slice( $columns, 0, 1, true ) + array( 'custom_image' => $tags_column ) + array_slice( $columns, 1, null, true );
    return $columns;
}
add_filter('manage_edit-product_columns', 'move_product_customimage_column');





// подключаем ajax front
add_action('wp_head', 'myplugin_ajaxurl');

function myplugin_ajaxurl() {

   echo '<script type="text/javascript">
           var ajaxurl = "' . admin_url('admin-ajax.php') . '";
         </script>';
}

// Создание товара front
add_action('wp_ajax_add_product', 'ajax_add_product');
add_action('wp_ajax_nopriv_add_product', 'ajax_add_product');

function ajax_add_product() {
    if (isset($_POST['product_title']) && isset($_POST['product_price'])) {
        $title = sanitize_text_field($_POST['product_title']);
        $price = floatval($_POST['product_price']);
        $custom_select_field = sanitize_text_field($_POST['custom_select_field']);
        $custom_date_field = sanitize_text_field($_POST['custom_date_field']);

        if (empty($title) || empty($price)) {
            echo json_encode(array('error' => 'Заполните все обязательные поля!'));
            wp_die();
        }

 

        // Функция для загрузки изображения товара
		function upload_product_image( $file_input_name ) {

		    if ( isset( $_FILES[ $file_input_name ] ) && ! empty( $_FILES[ $file_input_name ]['tmp_name'] ) ) {

		        $file = $_FILES[ $file_input_name ];
		        $upload_override = array( 'test_form' => false );


		        $image_type = exif_imagetype($_FILES[ $file_input_name ]['tmp_name']);
				  if ($image_type === false) {
				    echo json_encode(array('error' => 'Проблема с файлом картинки'));
            		wp_die();
				  }

		        require_once ABSPATH . 'wp-admin/includes/file.php';
		        $uploaded_file = wp_handle_upload( $file, $upload_override );
		        if ( isset( $uploaded_file['file'] ) ) {

		            $file_name = basename( $uploaded_file['file'] );
		            $file_type = wp_check_filetype( $file_name );

		            $attachment_data = array(
		                'guid'           => $uploaded_file['url'],
		                'post_mime_type' => $file_type['type'],
		                'post_title'     => preg_replace( '/\.[^.]+$/', '', $file_name ),
		                'post_content'   => '',
		                'post_status'    => 'inherit',
		            );
		            $attachment_id = wp_insert_attachment( $attachment_data, $uploaded_file['file'] );
		            if ( ! is_wp_error( $attachment_id ) ) {
		                require_once ABSPATH . 'wp-admin/includes/image.php';
		                $attachment_data = wp_generate_attachment_metadata( $attachment_id, $uploaded_file['file'] );
		                wp_update_attachment_metadata( $attachment_id, $attachment_data );

		                return $attachment_id;
		            }
		        }
		    }

		    return false;
		}

		$image_id = upload_product_image('product_image'); // Функция для загрузки изображения товара
        if ( ! $image_id ) {
        	echo json_encode(array('error' => 'Проблема с файлом картинки'));
            wp_die();
        }


        $new_product = array(
            'post_title' => $title,
            'post_status' => 'publish',
            'post_type' => 'product',
            'meta_input' => array(
                '_regular_price' => $price,
                'custom_select_field' => $custom_select_field,
                'custom_date_field' => $custom_date_field,
                'product_image' => wp_get_attachment_url($image_id),
            ),
        );

        $product_id = wp_insert_post($new_product);

        if (!is_wp_error($product_id)) {
            echo json_encode(array('success' => 'Товар успешно добавлен'));
        } else {
            echo json_encode(array('error' => 'Товар не добавлен'));
        }
    } else {
        echo json_encode(array('error' => 'Поля название товара и цена обязательны'));
    }

    wp_die();
}



?>
