$(document).ready(function(){
    $(".searchTerm").keyup(function(){
        var text = $(this).val();
        $.ajax({
            type: "POST",
            url: "search_host.php",
            data: 'text='+text,
            dataType: "html",
            async: false,
            success: function(text){
                $('.search_host_box').html(text);
            }

        });
    });
});
