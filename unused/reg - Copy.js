$(document).ready(function(){
$(function () {
    $('#form').w2form({ 
        name  : 'form',
        url   : 'server/post',
        fields: [
            { field: 'first_name', type: 'text', required: true },
			{ field: 'last_name', type: 'text', required: false },
			{ field: 'email', type: 'email', required: true },
			{ field: 'password', type: 'password', required: true },
			{ field: 'password_confirm', type: 'password', required: true },
			{ field: 'title', type: 'text', required: true },
			{ field: 'language', type: 'text', required: true },
			{ field: 'url', type: 'text', required: true },
			{ field: 'description', type: 'textarea', required: true },
			{ field: 'picture', type: 'file', required: false },
			{ field: 'MM_insert', type: 'hidden', required: false }
        ],
        actions: {
			reset: function () {
                this.clear();
            },
            register: function () {
					var first_name = $('#first_name').val();
					var last_name = $('#last_name').val();
					var email = $('#email').val();
					var password = $('#password').val();
					var password_confirm = $('#password_confirm').val();
					var title = $('#title').val();
					var language = $('#language').val();
					var url = $('#url').val();
					var description = $('#description').val();
					var picture = $('#picture').val();
					var hidden = $('#hidden').val();
				
					$('#returnmessage').empty(); //To empty previous error/success message.
				//checking for blank fields
				if(first_name=='' || email=='' || password=='' || password_confirm=='' || title=='' || language=='' || url=='' || description=='')
				{
				   alert("Please Fill Required Fields");
				}
				else{
				// Returns successful data submission message when the entered information is stored in database.
				$.post('PHP/reg.php',{
					first_name1: first_name, 
					last_name1: last_name, 
					email1: email, 
					password1: password, 
					password_confirm1: password_confirm, 
					title1: title, 
					language1: language, 
					url1: url, 
					description1: description, 
					picture1: picture,
					hidden1: hidden
					},
				   function(data) {
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
// JavaScript Document// JavaScript Document