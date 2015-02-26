$(document).ready(function(){
$(function () {
    $('#regForm').w2form({ 
        name  : 'regForm',
        url   : 'server/post',
        fields: [
            { field: 'first_name', type: 'text', required: true },
            { field: 'last_name', type: 'text', required: true },
            { field: 'email', type: 'email', required: true },
            { field: 'password', type: 'password', required: true },
            { field: 'passwordwc', type: 'password', required: true },
            { field: 'lang', type: 'text', required: true },
            { field: 'url', type: 'text', required: true },
            { field: 'title', type: 'text', required: true },
            { field: 'descr', type: 'text', required: true },
            { field: 'file', type: 'file', required: false, options: { max:1 } },

        ],
        actions: {
            register: function () {
            		var first_name = $("#first_name").val();
					var last_name = $("#last_name").val();
					var email = $("#email").val();
					var password = $("#password").val();
					var passwordwc = $("#passwordwc").val();
					var lang = $("#lang").val();
					var url = $("#url").val();
					var title = $("#title").val();
					var descr = $("#descr").val();
                    var file = $("#file").data('selected');
                    //var form = new FormData();
                   // form.append("file", $("#file")[0].files[0]);
                    //var pic = $("input:file").data('selected');
                    //var file = document.querySelector('#file');
                    //var formData = new FormData();
                   // formData.append('file', file.files[0]);
					var  MM_insert= $("#MM_insert").val();

                    //alert(file);
					
					$('#returnmessage').empty(); //To empty previous error/success message.
				//checking for blank fields
				if(first_name=='', email=='', password=='', passwordwc=='', lang=='', url=='', title=='', descr=='')
				{
				   alert("Please Fill Required Fields");
				}
				else{
				// Returns successful data submission message when the entered information is stored in database.
				$.post("PHP/RegisterFromAction.php", { 
					first_name1: first_name, 
					last_name1: last_name, 
					email1: email, 
					password1: password, 
					passwordwc1: passwordwc, 
					lang1: lang, 
					url1: url, 
					title1: title, 
					descr1: descr, 
                    file1: file,
					mm_in: MM_insert 
                },
				   function(data) {
					   console.log(data);
								$('#returnmessage').append(data);//Append returned message to message paragraph
									if(data=="Your Query has been received, We will contact you soon."){
										$('#form')[0].reset();//To reset form fields on success
									}
							});
						 }
                     
                    //this.save();
                    //this.validate();
            },
            reset: function() {
            		$('#returnmessage').empty();
					this.clear();
            }
        }
    });
});

/* $("#uploadform").on('click',function(){
  //$("#loader").show();
  var options={
   url     : "PHP/RegisterFromAction.php",
  };
  $(this).ajaxSubmit(options);
 return false;
 });*/


                   /*
                   
                    var form = document.querySelector("#upload");
                    var inputfile = document.querySelector("#file");
                    
                    
                    var request = new XMLHttpRequest();

                    request.upload.addEventListener('progress', function(e) {
                        document.querySelector('#progress').innerHTML = Math.round(e.loaded/e.total * 100) + "%";
                    }, false);

                    form.addEventListener('#register', function(e) { 
                        e.preventDefault(); 

                        var formData = new FormData();
                        formData.append('file', inputfile.files[0]);

                        request.open('post', 'PHP/RegisterFromAction.php');
                        request.send(formData);

                    }, false);

                   
*/

/*$("#register").on('click', function() {
    alert("IN");
    var form = document.querySelector("#uploadform");
    var inputfile = document.querySelector("#file");
    var request = new XMLHttpRequest();

    var formData = new FormData();
                        formData.append('file', inputfile.files[0]);

                        request.open('post', 'PHP/RegisterFromAction.php');
                        request.send(formData);

});*/

});
// JavaScript Document