jQuery(document).ready(function($){
                $(".post").on("click",function(){
                    $.ajax({
                        url: "http://www.yourwebsite.com/page.php",
                        type: "POST",
                        data: { name: "John", location: "Boston" },
                        success: function(response){
                              //do action  
                        },
                        error: function(){
                              // do action
                        }
                    });
                });
            });// JavaScript Document