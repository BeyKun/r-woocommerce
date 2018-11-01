(function($){
  plugin_register = function(){
                                                        $.get(PT_Ajax.ajaxurl, 
                                                        {
                                                                action: 'roketin_plugin_register',
                                                        }, 
                                                        function(data,status){
                                                            //do nothing
                                                        });
                                               }
})(jQuery);
