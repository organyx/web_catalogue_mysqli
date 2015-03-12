$(document).ready(function ()
{
    $("#update").click(function ()
    {
        update();
        refresh();
    });


    function update()
    {
        //var msg   = $('#registrationForm').serialize();
        var formData = new FormData($('#updateForm')[0]);
        $.ajax(
        {
            type: 'POST',
            url: 'PHP/UpdateUserAction.php',
            data: formData,
            async: false,
            success: function (data)
            {
                $('#returnmessage').html(data);
            },
            error: function (xhr, str)
            {
                alert('Error: ' + xhr.responseCode);
            },
            cache: false,
            contentType: false,
            processData: false
        });

        return false;
    }

    $('#updateForm').submit(function (e)
    {
        e.preventDefault();
        update();
        refresh();
        return false;
    });


    function refresh()
    {
        //$('#Content').load('PHP/Update_include.php');
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

});
// JavaScript Document 