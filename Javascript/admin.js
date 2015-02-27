$(document).ready(function(){

    $('#btnSearch').click(function(){
       makeAjaxRequest();
    });

    $('#DeleteUserButton2').click(function(){
        deleteUser();     
    });

    $('#ApproveUserButton2').click(function(){
        approveUser();
    });

     $('#MakeAdminButton2').click(function(){
        makeUserAdmin();     
    });
     
    $('#searchForm').submit(function(e){
        e.preventDefault();
        makeAjaxRequest();
        return false;
    });

    $('#DeleteUserForm2').submit(function(e){
        e.preventDefault();
        deleteUser();
        return false;
    });
    $('#ApproveUserForm2').submit(function(e){
        e.preventDefault();
        approveUser();
        return false;
    });
    $('#MakeAdminForm2').submit(function(e){
        e.preventDefault();
        makeUserAdmin();
        return false;
    });

    $("#reset").click(function(e){
            $('#result').empty();
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

    function deleteUser() {
        //var name = $('input#email').val();
                var del = $('#DeleteUserForm2').serialize();
                $.ajax({
                  type: 'post',
                  url: 'PHP/AdminSearchAcc.php',
                  data: del,
                  success: function(data) {
                    $('div#result').html(data);
                  },
                });
    }

    function approveUser() {
           //var name = $('input#email').val();
                var app = $('#ApproveUserForm2').serialize();
                $.ajax({
                  type: 'post',
                  url: 'PHP/AdminSearchAcc.php',
                  data: app,
                  success: function(data) {
                    $('div#result').html(data);
                  },
                });
    }

   
    function makeUserAdmin() {
        //var name = $('input#email').val();
                var make = $('#MakeAdminForm2').serialize();
                $.ajax({
                  type: 'post',
                  url: 'PHP/AdminSearchAcc.php',
                  data: make,
                  success: function(data) {
                    $('div#result').html(data);
                  },
                });
    }      

           


            


});
// JavaScript Document