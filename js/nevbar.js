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
});
