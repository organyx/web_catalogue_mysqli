
$(document).ready(function ()
{

    $('#btnSearch').click(function ()
    {
        makeAjaxRequest();
    });


    $('#searchForm').submit(function (e)
    {
        e.preventDefault();
        makeAjaxRequest();
        return false;
    });

    $("#reset").click(function (e)
    {
        $('#result').empty();
        $('#searchForm').closest('#searchForm').find("input[type=text]").val("");
    });


    function makeAjaxRequest()
    {
        $.ajax(
        {
            url: 'PHP/AdminSearchAcc.php',
            type: 'post',
            data: {
                name: $('input#email').val()
            },
            success: function (response)
            {
                $('div#result').html(response);


                $('#DeleteUserButton2').click(function ()
                {
                    deleteUser();
                });

                $('#ApproveUserButton2').click(function ()
                {
                    approveUser();
                });

                $('#MakeAdminButton2').click(function ()
                {
                    makeUserAdmin();
                });
                $('#DeleteUserForm2').submit(function (e)
                {
                    e.preventDefault();
                    deleteUser();
                    update();
                    return false;
                });
                $('#ApproveUserForm2').submit(function (e)
                {
                    e.preventDefault();
                    approveUser();
                    update();
                    return false;
                });
                $('#MakeAdminForm2').submit(function (e)
                {
                    e.preventDefault();
                    makeUserAdmin();
                    update();
                    return false;
                });



            }
        });
    }
/*
    $.ajaxSetup({ cache: false });
    setInterval(function() {
    $('#list').load('PHP/adminUsers.php');
    }, 3000); 
    
*/
    function update(){
      //location.reload();
      $('#list').load('PHP/adminUsers.php');
      //Reload
      $.ajax({
          url: "",
          context: document.body,
          success: function(s,x){
              $(this).html(s);
          }
      });
    }

    function deleteUser()
    {
        //var name = $('input#email').val();
        var del = $('#DeleteUserForm2').serialize();
        $.ajax(
        {
            type: 'post',
            url: 'PHP/AdminSearchAcc.php',
            data: del,
            success: function (data)
            {
                $('div#result').html(data);
                //$('#list').load('PHP/adminUsers.php');
            }
        });
    }

    function approveUser()
    {
        //var name = $('input#email').val();
        var app = $('#ApproveUserForm2').serialize();
        $.ajax(
        {
            type: 'post',
            url: 'PHP/AdminSearchAcc.php',
            data: app,
            success: function (data)
            {
                $('div#result').html(data);
               // $('#list').load('PHP/adminUsers.php');
            }
        });
    }


    function makeUserAdmin()
    {
        //var name = $('input#email').val();
        var make = $('#MakeAdminForm2').serialize();
        $.ajax(
        {
            type: 'post',
            url: 'PHP/AdminSearchAcc.php',
            data: make,
            success: function (data)
            {
                $('div#result').html(data);
               // $('#list').load('PHP/adminUsers.php');
            }
        });
    }

});
// JavaScript Document  
