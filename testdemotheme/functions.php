<?php


add_action('wp_enqueue_scripts', 'tutsplus_enqueue_custom_js');
function tutsplus_enqueue_custom_js() {
    wp_enqueue_script('custom', get_stylesheet_directory_uri().'/js/custom_script.js', 
    array(), false, true);
}

add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles', 11 );
function my_theme_enqueue_styles() {
    wp_enqueue_style( 'child-style', get_stylesheet_uri());
}

add_action( 'admin_enqueue_scripts', 'sunset_load_admin_scripts' );
function sunset_load_admin_scripts(){ 
    wp_enqueue_script('custom' , get_stylesheet_directory_uri() .'/js/example.js', array(), false, true);
    //wp_enqueue_script('sunset-admin-script'); 
    wp_enqueue_style( 'child-style', get_stylesheet_uri());
}



// The code for displaying WooCommerce Product Custom Fields
add_action( 'woocommerce_product_options_general_product_data', 'woocommerce_product_custom_fields' ); 
// Following code Saves  WooCommerce Product Custom Fields
add_action( 'woocommerce_process_product_meta', 'woocommerce_product_custom_fields_save' );

function woocommerce_product_custom_fields () {
    global $woocommerce, $post;
    echo '<div class=" product_custom_field ">';

    // Publishing Date
    woocommerce_wp_text_input(
        array(
            'id' => '_custom_product_date',
            'label' => __('Custom Publishing Date', 'woocommerce'),
            'desc_tip' => 'true',
            'value' => date("Y-m-d"),
            'custom_attributes' => ['readonly' => true],
            'type' => 'date'
        )
    );
    // Select Product Type
    woocommerce_wp_select(
        array(
            'id' => '_custom_product_select_field',
            'label' => __('Custom Product Type', 'woocommerce'),
            'options' => array('productType' => __('Product Type', 'woocommerce'),
            'rare' => __('Rare', 'woocommerce'),
            'frequent' => __('Frequent', 'woocommerce'),
            'unusual' => __('Unusual', 'woocommerce'))
        )
    );
    
    // Choosing Image to the product
    if($_GET['_custom_product_image_filed']) {
        echo'<img id="customThumbnail" src="#" alt="your image" width="256" height="176" />';
    }
    else{
        echo'
        <form runat="server">
            <input accept="image/*" type="file" id="_custom_product_image_filed" />
            <img id="customThumbnail" src="#" alt="your image" width="256" height="176" />
        </form>';
    }
    

    // Delete chosen Image of the product
    echo '<button type="button" id="_custom_product_delete_img">Delete choosen image</button>';

    // Clear all custom fields button
    echo '<button type="button" class="empty-custom" id="emptyBtn">Empty Custom fields</button>';

    echo '</div>';
    }
    
    
    // Saving the data in custom fields
    function woocommerce_product_custom_fields_save($post_id) {
        // Custom Product Image
        set_post_thumbnail( $post_id, '_custom_product_image_filed' );
        /*$woocommerce_custom_product_text_field = $_POST['_custom_product_image_filed'];
        if (!empty($woocommerce_custom_product_text_field))
            update_post_meta($post_id, '_custom_product_image_filed', esc_attr($woocommerce_custom_product_text_field));*/
        
        // Custom Product Date 
        $woocommerce_custom_product_text_field = $_POST['_custom_product_date'];
        if (!empty($woocommerce_custom_product_text_field))
            update_post_meta($post_id, '_custom_product_date', esc_attr($woocommerce_custom_product_text_field));
        
        // Custom Product Textarea Field
        $woocommerce_custom_product_text_field = $_POST['_custom_product_select_field'];
        if (!empty($woocommerce_custom_product_text_field))
            update_post_meta($post_id, '_custom_product_select_field', esc_html($woocommerce_custom_product_text_field));
    }

    //Display custom fields on Woocommerce Product Details Page
    add_action( 'woocommerce_single_product_summary', 'ci_woo_product_detail', 5 );
    function ci_woo_product_detail() {
        global $product;
        
        echo '<div>';
	    echo '<span> <strong>Custom publishing date: </strong>' . get_post_meta( $product->id, '_custom_product_date', true ) . '</span>';
		echo '</div>';
        
        echo '<div>';
	    echo '<span> <strong>Custom product type :</strong> ' . get_post_meta( $product->id, '_custom_product_select_field', true ) . '</span>';
		echo '</div>';
        
	}

    add_action( 'post_submitbox_start', function() {
        print '<button class="new-custom-publish">Custom button publish</button>';
    });

    ob_start(); ?>
    <script>window.addEventListener('load', function() {
    jQuery('input#submitbox-custom-button').click(function(event) {
      event.preventDefault();
      alert('You\'re editing <?php echo $post->post_type . " " . $post->ID; ?>');
      return true;
    });
  });
</script>
<?php $html .= ob_get_clean();

?>