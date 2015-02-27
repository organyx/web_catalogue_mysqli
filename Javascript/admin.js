$(document).ready(function(){
    $('#btnSearch').click(function(){
       makeAjaxRequest();
    });
     
    $('#searchForm').submit(function(e){
        e.preventDefault();
        makeAjaxRequest();
        return false;
    });

    $("#reset").click(function(e){
            $('#result').empty();
            //$('#returnmessa').empty();
            $('#searchForm').closest('#searchForm').find("input[type=text]").val("");
      });

    function makeAjaxRequest() {
    $.ajax({
        url: 'PHP/AdminSearchAcc.php',
        type: 'post',
        data: {name: $('input#email').val()},
        success: function(response) {
            $('div#result').html(response);
            }
        });
    }


            $('button#DeleteUserButton2').click(function(){
                var del = $('#DeleteUserForm2').serialize();
                $.ajax({
                  type: 'POST',
                  url: 'PHP/adminUsers.php',
                  data: del,
                  success: function(data) {
                    //$('#returnmessage').html(data);
                  },
                });
            });

            $('button#ApproveUserButton2').click(function(){
                var app = $('#ApproveUserForm2').serialize();
                $.ajax({
                  type: 'POST',
                  url: 'PHP/adminUsers.php',
                  data: app,
                  success: function(data) {
                    //$('#returnmessage').html(data);
                  },
                });
            });

            $('button#MakeAdminButton2').click(function(){
                var make = $('#MakeAdminForm2').serialize();
                $.ajax({
                  type: 'POST',
                  url: 'PHP/adminUsers.php',
                  data: make,
                  success: function(data) {
                    //$('#returnmessage').html(data);
                  },
                });
            });


});
// JavaScript Document