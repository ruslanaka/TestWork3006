<?php
/*
Template Name: Create product
*/
get_header(); // include header.php ?>
<form method="post" enctype="multipart/form-data">
    <label for="product_title">Название товара:</label>
    <input type="text" name="product_title" id="product_title" required>

    <label for="product_description">Описание товара:</label>
    <textarea name="product_description" id="product_description" required></textarea>

    <label for="product_price">Цена:</label>
    <input type="number" name="product_price" id="product_price" required>

    <label for="product_image">Изображение товара:</label>
    <input type="file" name="product_image" id="product_image" required>

    <input type="submit" name="product_submit" value="Добавить товар">
</form>
<?php get_footer(); // include footer.php ?>