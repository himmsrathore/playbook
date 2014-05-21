(function($) {
	function intval (mixed_var, base) {   
		var tmp;
		var type = typeof( mixed_var );
	
		if (type === 'boolean') { return (mixed_var) ? 1 : 0; } 
		else if (type === 'string') { tmp = parseInt(mixed_var, base || 10); return (isNaN(tmp) || !isFinite(tmp)) ? 0 : tmp;} 
		else if (type === 'number' && isFinite(mixed_var) ) { return Math.floor(mixed_var); } 
		else { return 0; }
	}
 $.fn.seb_imagefix = function(cb)
  {	
  
  		callback = cb || function(){};
		
  		this.hide();
		
  	  /* bilder in array laden */	  
		var pic_arr = Array();
		
		function seb_imagefix_f(obj){
			obj.seb_imagefix(); 
			
		}	  
		
		function get_picdata(obj){				
			var temp_arr = Array();						 
			temp_arr['w']	= jQuery(obj).width();	
			temp_arr['h']	= jQuery(obj).height();
			
			return temp_arr;			
		}
		
		this.each(function(i){				
				pic_arr[i] = get_picdata(this);			
		});
		
		var maxwidth_arr = Array();		
		this.each(function(i){	
			
			var obj = jQuery(this);			
			var borderwidth = 0;
			
			do
			{
				borderwidth += obj.outerWidth(true) - obj.width();					
				obj = obj.parent();
			}while(obj.css('display') == 'inline' || obj.css('float') == 'left' || obj.css('float') == 'right');
			
			var maxwidthtmp = obj.width() - borderwidth;
			
			/*if(maxwidthtmp > jQuery('body').width())
			{maxwidthtmp = jQuery('body').width();}*/
				   
			maxwidth_arr[i] = maxwidthtmp;
		});
		
		this.each(function(i){
			var obj = jQuery(this);	
			var borderwidth = 0;
			do
			{				
				borderwidth += obj.outerWidth(true) - obj.width();					
				obj = obj.parent();				
			}while(obj.css('display') == 'inline' || obj.css('float') == 'left' || obj.css('float') == 'right');			   
						   
			var width = pic_arr[i]['w'];
			var maxwidth = jQuery(this).attr('rel') ;
			
			maxwidth = intval(maxwidth);
									
			if(maxwidth >= 0){
				maxwidth -= borderwidth;
				
				if(maxwidth < 1 || maxwidth > maxwidth_arr[i]){ 										
					maxwidth = maxwidth_arr[i];					
				}				
							
				if(width >= maxwidth){	
					var faktor = width/(maxwidth);
					
					jQuery(this).width(maxwidth); 
					jQuery(this).height(pic_arr[i]['h']/faktor); 
				}				
			}			
		});
		this.show(0,callback);		
	  /* ------------------------------- */
    return this;
  };  
})(jQuery);

jQuery(document).ready(function(){
	//jQuery('.pic').seb_imagefix();
	/*
	jQuery('.pic').each(function(i){
		jQuery(this).load(function(){
			// alert(jQuery(this).attr('src'));	
			var obj = jQuery(this);
			obj.seb_imagefix();					
		});
	});	
	*/
	/*	
	jQuery('img').ready(function(){		
		jQuery('img').seb_imagefix();		
	});
	*/	
});