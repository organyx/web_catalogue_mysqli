$(document).ready(function() {

	function update() {
	      var msg   = $('#updateForm').serialize();
	        $.ajax({
	          type: 'POST',
	          url: 'PHP/UpdateUserAction.php',
	          data: msg,
	          success: function(data) {
	            $('#returnmessage').html(data);
	          },
	          error:  function(xhr, str){
	                alert('Error: ' + xhr.responseCode);
	            }
	        });
	 
	    }



     $("#update").click(function(e){
  			update();
      });

});
// JavaScript Document