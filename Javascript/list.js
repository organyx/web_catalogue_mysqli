$(document).ready(function(){
	// var autoUpdate = function()
	// {
	// 	$.ajax({
 //          url: "",
 //          context: document.body,
 //          success: function(s,x){
 //              $(this).html(s);
 //          }
 //      });
	// }

	// setInterval(autoUpdate(), 20000);

      //   function loadlink(){
      //     $('#contentRight').load('PHP/list.php',function () {
      //          $(this).unwrap();
      //     });
      // }

      // loadlink(); // This will run on page load
      // setInterval(function(){
      //     loadlink() // this will run after every 5 seconds
      // }, 10000);


    var autoLoad = setInterval(
       function ()
       {
          $('#contentRight').load('PHP/list.php').fadeIn("slow");
       }, 10000);
    
});