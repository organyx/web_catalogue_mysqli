$(document).ready(function(){
$(function () {
    $('#LoginForm').w2form({ 
        name  : 'LoginForm',
        url   : 'server/post',
        fields: [
            { field: 'email', type: 'text', required: true },
            { field: 'password', type: 'password', required: true }
        ],
        actions: {
            login: function () {
					var email = $("#email").val();
					var password = $("#password").val();
					
					$('#returnmessage').empty(); //To empty previous error/success message.
				//checking for blank fields
				if(email=='', password=='')
				{
				   alert("Please Fill Required Fields");
				}
				else{
				// Returns successful data submission message when the entered information is stored in database.
				$.post("loginAction.php",{ email1: email, password1: password},
				   function(data) {
					   console.log(data);
								$('#returnmessage').append(data);//Append returned message to message paragraph
									if(data=="Your Query has been received, We will contact you soon."){
										$('#form')[0].reset();//To reset form fields on success
									}
							});
						 }

            }
        }
    });
});
});
// JavaScript Document