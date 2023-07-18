$(document).ready(function(){
	$('#factureDropdownlink').on('click',function(){
		$('#new').hide();
		$('#list').hide();
	});
	$('#newDropdownlink').on('mouseover',function(){
		$('#new').show();
		$('#list').hide();
		$('#dm').hide();
	});
	$('#listDropdownlink').on('mouseover',function(){
		$('#list').show();
		$('#new').hide();
		$('#dm').hide();
	});
	var ch =$("#checkbox");
	var psw =$("#passwordlogin");
	
	ch.click(function(){
	   if(ch.prop("checked")){
		  psw.attr("type","text");
	   }else{
		  psw.attr("type","password");
	   }
	});
	$("#formlogin").validate({
		rules:{
		   _username:{
			  required:true,
			  minlength:4,
			  maxlength:255
		   },
		   _password:{
			  required:true,
			  minlength:6,
			  maxlength:20
		   }
		},
		messages:{
		   _username:{
			  required:"Veuillez entrer le nom d'Utilisateur !",
			  minlength:"Le nom d'utilisateur n'existe pas, nom trop court",
			  maxlength:"C'est inacceptable,Utilisateur trop"
		   },
		   _password:{
			  required:"Veuillez entrer votre mot de pass SVP !",
			  // required:"Veuillez entrer votre mot de pass" + _username + " SVP !",
			  minlength:"Mot de pass trop court ",
			  maxlength:"Mot de pass trop long "
		   }
		}
	}); 
	$("cmd").validate({
		rules:{
		   	Qte:{
			  required:true,
			  number:true,
			  maxlength:5
		   },
		   	Pu:{
			  required:true,
			  number:true,
			  minlength:3,
			  maxlength:20
		   }
		},
		messages:{
		   	Qte:{
			  required:"Veuillez entrer la quantité du commande !",
			  number:"La quantité doit toujours en nombre !",
			  maxlength:"Vérifier la quantité du commande SVP !"
		   },
		   	Pu:{
			  required:"Veuillez entrer votre mot de pass SVP !",
			  number:"Le prix unitaire sont toujours de nombre !",
			  minlength:"Prix trop faible, merci d'y vérifier !",
			  maxlength:"Prix incorrect "
		   }
		}
	});
	// $("#client").validate({
	// 	rules:{
	// 		client_Dos:{
	// 			required:false,
	// 			number:true
	// 		}
	// 	},
	// 	messages:{
	// 		client_Dos:{
	// 			required:"",
	// 			number:"Veuillez saisir une numero de "
	// 		}
	// 	}
	// })
}); 