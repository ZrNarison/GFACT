$(document).ready(function(){
	$('#new').on('click',function(){
		$('#newid').show();
	});
	$('#view').on('dblclick',function(){
		$('#viewid').hide();		
	}); 
});
$(document).ready(function(){
	var ch =$("#checkbox");
	var psw =$("#passwordlogin");
	
	ch.click(function(){
	   if(ch.prop("checked")){
		  psw.attr("type","text");
	   }else{
		  psw.attr("type","password");
	   }
	}),
	$(document).ready(function(){
	   
	})
 });