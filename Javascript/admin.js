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
            url: 'PHP/AdminSearchAccAction.php',
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
                // $('#MakeAdminButton2').click(function ()
                // {
                //     newAdmin();
                // });
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
                // $('#MakeAdminForm2').submit(function (e)
                // {
                //     e.preventDefault();
                //     newAdmin();
                //     update();
                //     return false;
                // });
            }
        });
    }
    // function refresh() {
    //   $.ajax({
    //       url: "",
    //       context: document.body,
    //       success: function(s){
    //           $(this).html(s);
    //       }
    //   });
    // }
/*
    $.ajaxSetup({ cache: false });
    setInterval(function() {
    $('#list').load('PHP/adminUsers.php');
    }, 3000); 
    
*/

    function update()
    {
        //location.reload();
        $('#list').load('PHP/AdminUsers_Include.php');
        //Reload
        $.ajax(
        {
            url: "",
            context: document.body,
            success: function (s, x)
            {
                $(this).html(s);
            }
        });
    }

    function deleteUser()
    {
        var del = $('#DeleteUserForm2').serialize();
        $.ajax(
        {
            type: 'post',
            url: 'PHP/AdminSearchAccAction.php',
            data: del,
            success: function (data)
            {
                $('div#result').html(data);
            }
        });
    }

    function approveUser()
    {
        var app = $('#ApproveUserForm2').serialize();
        $.ajax(
        {
            type: 'post',
            url: 'PHP/AdminSearchAccAction.php',
            data: app,
            success: function (data)
            {
                $('div#result').html(data);
            }
        });
    }

    // function newAdmin()
    // {
    //     var make = $('#MakeAdminForm2').serialize();
    //     $.ajax(
    //     {
    //         type: 'post',
    //         url: 'PHP/AdminSearchAccAction.php',
    //         data: make,
    //         success: function (data)
    //         {
    //             $('div#result').html(data);
    //         }
    //     });
    // }

    // var interval = 20000;
    // var autoRefresh = function()
    // {
    //   $.ajax({
    //         url: "",
    //         context: document.body,
    //         success: function(html) {
    //             $(this).html(html);
    //             setTimeout(function() {
    //                 autoRefresh();
    //             }, interval);
    //         }
    //     });
    // }
    // autoRefresh();
    
});
// JavaScript Document