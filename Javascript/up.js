$(document).ready(function(){
$(function () {
    $('#upForm').w2form({ 
        name  : 'upForm',
        url   : 'server/post',
        
        actions: {
            update: function () {
					var password = $("#password").val();
					var passwordwc = $("#passwordwc").val();
					var lang = $("#lang").val();
					var url = $("#url").val();
					var title = $("#title").val();
					var descr = $("#descr").val();
					var userID = $("#UserIDhiddenField").val();
					var MM_update = $("#MM_update").val();
					
					$('#returnmessage').empty(); //To empty previous error/success message.
				//checking for blank fields
				/*if(email=='', password=='')
				{
				   alert("Please Fill Required Fields");
				}
				else{*/
				// Returns successful data submission message when the entered information is stored in database.
				$.post("PHP/UpdateUserAction.php",{ password1: password, passwordwc1: passwordwc, lang1: lang, url1: url, title1: title, descr1: descr, userID1: userID, mm_up: MM_update},
				   function(data) {
					   console.log(data);
								$('#returnmessage').append(data);//Append returned message to message paragraph
									if(data=="Your Query has been received, We will contact you soon."){
										$('#form')[0].reset();//To reset form fields on success
									}
							});
						 //}

            },
            reset: function() {
            		$('#returnmessage').empty();
					this.clear();
            }
        }
    });
});
});
// JavaScript Document