(function($){
	billing_courier = function(){
			 $('#billing_address_2').on('change',function(){
						$('#div_epeken_popup').css('display','block');
                                                $.get(PT_Ajax_Bill_Courier.ajaxurl, 
                                                                {
                                                                        action: 'get_list_courier',
                                                                        nextNonce: PT_Ajax_Bill_Courier.nextNonce,
                                                                        kecamatan: this.value        
                                                                },
                                                                function(data,status){
                                                                        
                                                                $('#billing_address_4').empty();
                                                                        var arr = data.split(';');
                                                                           $('#billing_address_4').append('<option value="">Please Select Courier</option>'); 
                                                                        $.each(arr, function (i,valu) {
                                                                         if (valu != '' && valu != '0') {    
                                                                           var kab = valu.split('.');
                                                                           $('#billing_address_4').append('<option value="'+kab[1]+'">'+kab[0].toUpperCase() + ' ' + kab[1]  +'</option>'); 
                                                                            
                                                                         }
                                                                        });
                                                                $('#billing_address_4').trigger('chosen:updated');
                                                });
						$('#div_epeken_popup').css('display','none');
                                        });
	}
})(jQuery);