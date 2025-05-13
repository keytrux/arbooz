(function($){
	 
	 $(document).on('change', '[data-setting="rkd_acf_field_parent_category"][data-name="taxonomy"] .acf-input select', function( e ){
		e.preventDefault();
		var $val = $(this).val();
		$('[data-setting="rkd_acf_field_parent_category"][data-name="taxonomy_parent_cat"] .acf-input select').html('<option>Loading...</option>');
		$.ajax({
		  url  : rkd.ajax_url,
		  type : "POST",
		  data : {
				action : 'acf/fields/rkd_acf_field_parent_category/query',
				taxonomy : $val
			},
		  dataType: "json",
		  success:function(data){  
		  
			var select_ = $('[data-setting="rkd_acf_field_parent_category"][data-name="taxonomy_parent_cat"] .acf-input select');
			 
			var options = "";
			$.each(data, function( index, value ) {
				options+= "<option value='"+value[0]+"'>"+value[1]+"</option>";
			});
			select_.html(options);
		  },
		  error:function(xhr){
			alert('Ajax request fail');
		  }
		});
			
	});
	
	// taxonomy
	//acf.fields.taxonomy = acf.field.extend({	});
	
})(jQuery);