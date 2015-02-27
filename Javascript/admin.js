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
});
// JavaScript Document