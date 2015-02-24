$(document).ready(function(){
	$('#RegisterButton').click(function(){
		var first_name=$('#FirstName').val();
		var last_name=$('#LastName').val();
		var email=$('#Email').val();
		var password=$('#Password').val();
		var passwordC=$('#PasswordConfirm').val();
		var lang=$('#Language').val();
		var url=$('#Url').val();
		var title=$('#Title').val();
		var descr=$('#Description').val();
		var pic=$('#PreviewPicture').val();
		
		$('#returnmessage').empty();
		
		if(first_name =='', email=='', password=='', password1=='', lang=='',url=='', title=='', descr=='')
				{
				   alert("Please Fill Required Fields");
				}

		$.ajax({
			type: "POST",
			url: "PHP/reg.php",
			data:  {
					first_name1: first_name,
					last_name1: last_name,
					email1: email,
					password1: password,
					passwordC1: passwordC,
					lang1: lang,
					url1: url,
					title1: title,
					descr1: descr,
					pic1: pic,			
					 },
			success: function(data){
				$('#returnmessage').append(data);
				console.log(data);
    			alert("Done!" . data);
				
				if(data=="Your Query has been received, We will contact you soon."){
					$('#RegisterForm')[0].reset();
				}
			},
			error: function(data){
				$('#returnmessage').append(data);
				console.log(data);
    			alert("Error!" . data);
				
				if(data=="Something is wrong"){
					$('#RegisterForm')[0].reset();
				}
			}
		});
		return false;
		
	});
});