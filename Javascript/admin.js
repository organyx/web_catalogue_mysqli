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
            }
        });
    }

    function update()
    {
        $('#list').load('PHP/AdminUsers_Include.php');

        setTimeout(function(){
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

        }, 5000 ); // 5 seconds
        
        
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
});
// JavaScript Document