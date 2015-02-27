$(document).ready(function(){
// $(function () {
//     $('#form').w2form({ 
//         name  : 'form',
//         url   : 'server/post',
//         fields: [
//             { field: 'email', type: 'email', required: true }
//         ],
//         actions: {
//             send: function () {
// 					var email = $("#email").val();
				
// 					$('#returnmessage').empty(); //To empty previous error/success message.
// 				//checking for blank fields
// 				if(email=='')
// 				{
// 				   alert("Please Fill Required Fields");
// 				}
// 				else{
// 				// Returns successful data submission message when the entered information is stored in database.
// 				$.post("Helpers/EMPW-Script.php",{ email1: email},
// 				   function(data) {
// 					   console.log(data);
// 								$('#returnmessage').append(data);//Append returned message to message paragraph
// 									if(data=="Your Query has been received, We will contact you soon."){
// 										$('#form')[0].reset();//To reset form fields on success
// 									}
// 							});
// 						 }

//             }
//         }
//     });
// });

function sendPass() {
	      var msg   = $('#sendPassForm').serialize();
	        $.ajax({
	          type: 'POST',
	          url: 'Helpers/EMPW-Script.php',
	          data: msg,
	          success: function(data) {
	            $('#returnmessage').html(data);
	          },
	          error:  function(xhr, str){
	                alert('Error: ' + xhr.responseCode);
	            }
	        });
	 
	    }



     $("#sendPass").click(function(e){
  			sendPass();
      });
});
// JavaScript Document