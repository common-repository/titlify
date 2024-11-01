var titlify;
(function(a){
	titlify = 
	{
		init: function()
		{ 
			this.methods.pickcolor();
		},
		methods:
		{
			pickcolor : function(){
				if( jQuery('.pickcolor').length > 0 )
					jQuery('.pickcolor').wpColorPicker();
			}
		}
	}

})(jQuery); 
	
jQuery(document).ready(function(){
	titlify.init();
});