$(document).ready(function(){

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


     $("#reset").click(function(e){
            $('#returnmessage').empty();
            $('#sendPassForm').closest('form').find("input[type=email]").val("");
      });

});
// JavaScript Document