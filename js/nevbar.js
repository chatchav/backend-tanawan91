$(document).ready(function(){
    $( ".lang" ).on( "click", function() {
        const lang = $(this).attr("data-lang")
        console.log($(this).attr("data-lang"));
        $.ajax({
            type:"POST",
            url:"../assets/query/nevbar.php",
            data:"lang="+lang,
            async:false,
            success: function(res){
                console.log(res)
                if(res == "Success"){
                    $('#navbarDropdownLang').text(lang);
                    window.location.reload();
                }
            }
        });
    });

    var url = window.location.pathname;
    var menu = $(".nav").find(".nav-link");
    console.log(url,menu);

    $.each( menu, function( key, value ) {
        var ele = $(value);
        var href = ele.attr("href");
        ele.removeClass( "active" );
        if(href.search(url) != -1){
            var id = ele.parent().parent().attr("id");
            console.log(id);
            if(id != undefined){
                $('a[data-bs-target="#'+id+'"]').removeClass("collapsed").attr("aria-expanded","true");
                $('#'+id).addClass("show");
                console.log($('a[data-bs-target="#'+id+'"]'));
            }
            ele.addClass( "active" );
        }
        //console.log(ele.parent().parent().attr("id"), ele.find(".nav-link") ,href.search(url) );
      });
});
