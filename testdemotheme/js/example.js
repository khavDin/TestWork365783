var el = document.getElementById('emptyBtn');
if(el){
    el.addEventListener('click', function(){
      document.getElementById("_custom_product_select_field").value = "Product Type";
      document.getElementById("_custom_product_date").value = "mm/dd/yyyy";
      document.getElementById("customThumbnail").src = "";
      document.getElementById("_custom_product_image_filed").value = "";
    })
};

_custom_product_image_filed.onchange = evt => {
  const [file] = _custom_product_image_filed.files
  if (file) {
    customThumbnail.src = URL.createObjectURL(file)
  }
}

var delbtn = document.getElementById('_custom_product_delete_img');
if(delbtn){
  delbtn.addEventListener('click', function(){
      document.getElementById("customThumbnail").src = "";
      document.getElementById("_custom_product_image_filed").value = "";
    })
};

