
$( document ).ready(function() {
    ClassicEditor
        .create(document.querySelector('#desc'), {
            simpleUpload: {
                uploadUrl: '../upload-ck.php',
                withCredentials: false,
              }
        })
        .then(editor => {
            console.log('Editor was initialized', editor);
        })
        .catch(error => {
            console.error('There was a problem initializing the editor.', error);
        });

    $( "#frm-data" ).on( "submit", function( event ) {
        event.preventDefault();
        const form = $( this );
        var formData = new FormData(this);
        let chkErr = "0"
        form.find('input').each(function(i, o){
            const v = $(this).val();
            const eleId = $(this).attr('id');
            const txt = $(this).attr('placeholder');
            const eleErr = $('#txtErr'+eleId);
            console.log(eleId,txt);
            if(v == "" && txt != undefined){
                eleErr.show();
                eleErr.text('Please enter your '+txt);
                chkErr = '1';
            }else{
                eleErr.hide();
            }
        });
        console.log(chkErr);
        if(chkErr != '1'){
            $.ajax({
                type:"POST",
                url:"../assets/query/contact.php",
                data:formData,
                contentType: false,
                cache: false,
                processData:false,
                success: function(res){
                    console.log(res);
                    const eleErr = $('#txtErrtitle');
                    if(res == "Success"){
                        $('#exampleModal').modal('toggle');
                        Swal.fire({
                            icon: 'success',
                            title: 'saved',
                            showConfirmButton: false,
                            timer: 1500
                            }).then(() => {
                            window.location.reload();
                        })
                    }else{
                        eleErr.show();
                        eleErr.text(res);
                        return false;
                    }
                }
            });
        }
    });
});