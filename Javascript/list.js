$(document).ready(function(){
	var autoUpdate = function()
	{
		$.ajax({
          url: "",
          context: document.body,
          success: function(s,x){
              $(this).html(s);
          }
      });
	}

	setInterval(autoUpdate(), 20000);
});