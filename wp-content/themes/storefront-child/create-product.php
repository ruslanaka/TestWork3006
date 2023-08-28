<?php
/*
Template Name: Create product
*/
get_header(); // include header.php 

?>
<form id="add-product-form">
    <p class="form-field">
    <label for="product-title">Название товара</label>
    <input type="text" id="product_title" name="product_title" required>
    </p>
    
    <p class="form-field">
    <label for="product-price">Цена</label>
    <input type="number" id="product_price" name="product_price" required>
    </p>

    <p class="form-field">
    <label for="custom_date_field">Дата добавления</label>
    <input type="date" name="custom_date_field" id="custom_date_field">
    </p>

    <p class="form-field">
        <label for="custom_select_field">Выпадающий список</label>
        <select name="custom_select_field" id="custom_select_field">
            <option>Выбрать</option>
            <option value="rare">rare</option>
            <option value="frequent">frequent</option>
            <option value="unusual">unusual</option>
        </select>
    </p>

    <p class="form-field">
        <label for="product_image">Product Image</label>

        <input type="file" name="product_image" id="product_image">
    </p>
    
    <button type="submit">Добавить товар</button>
</form>

<script>
    jQuery(function($) {
    $('#add-product-form').submit(function(e) {
        e.preventDefault();

        //var formData = $(this).serialize();

        var formData = new FormData();
        formData.append('product_image', $("#product_image")[0].files[0]);
        formData.append('product_title', $("#product_title").val());
        formData.append('product_price', $("#product_price").val());
        formData.append('custom_date_field', $("#custom_date_field").val());
        formData.append('custom_select_field', $("#custom_select_field").val());   
        formData.append( "action", 'add_product');  

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert(response.success);
                    // Выполните другие действия в случае успеха добавления товара
                } else {
                    alert(response.error);
                    // Выполните другие действия в случае ошибки добавления товара
                }
            },
        });
    });
});


</script>
<?php get_footer(); // include footer.php ?>