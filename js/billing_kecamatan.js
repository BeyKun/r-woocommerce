 
(function($){
	billing_kecamatan = function(){
			 $('#billing_city').on('change',function(){
						$('#div_epeken_popup').css('display','block');
                                                $.get(PT_Ajax_Bill_Kec.ajaxurl, 
                                                                {
                                                                        action: 'get_list_kecamatan',
                                                                        nextNonce: PT_Ajax_Bill_Kec.nextNonce,
                                                                        kota: this.value        
                                                                },
                                                                function(data,status){
                                                                        
                                                                $('#billing_address_2').empty();
                                                                        var arr = data.split(';');
                                                                           $('#billing_address_2').append('<option value="">Please Select Kecamatan</option>'); 
                                                                        $.each(arr, function (i,valu) {
                                                                         if (valu != '' && valu != '0') {    
                                                                           var kab = valu.split('.');
                                                                           $('#billing_address_2').append('<option value="'+kab[0]+'">'+kab[1]+'</option>'); 
                                                                            
                                                                         }
                                                                        });
                                                                $('#billing_address_2').trigger('chosen:updated');
                                                });
						$('#div_epeken_popup').css('display','none');
                                        });
	}
})(jQuery);
