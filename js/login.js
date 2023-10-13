$(document).ready(function(){
    $( "#frm-login" ).on( "submit", function( event ) {
        event.preventDefault();
        const eleErr = $("#txtErr");
        eleErr.hide();
        console.log( $( this ),$( this ).serialize() );
        const form = $( this );
        $.ajax({
            type:"POST",
            url:"../assets/query/login.php",
            data:form.serialize(),
    
            success: function(res){
                console.log(res);
                if(res == "Success"){
                    window.location.href = "/";
                }else{
                    eleErr.show();
                    eleErr.text(res);
                    return false;
                }
            }
        });
    });
});
