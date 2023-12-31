$(document).ready(function(){
    //getData();
    $('#add-service').on("click",function(){
        setFlag("add");
        $('#title').val('');
        $('#title_th').val('');
    })

    $('.btn-edit-data').on('click',function(){
        setFlag("update");
        const id = $(this).attr('data-id');
        $('#id').val(id);
        $.ajax({
            type:"POST",
            url:"../assets/query/project-status.php",
            data:"flagAction=edit&id="+id,
            dataType: "json",
            success: function(res){
                const data = res[0];
                $('#title').val(data[1]);
                $('#title_th').val(data[2]);
            }
        });
    });

    $('.btn-del-data').on('click',function(){
        const id = $(this).attr('data-id');
        Swal.fire({
            title: 'Are you sure to delete this?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Yes',
            denyButtonText: `No`,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type:"POST",
                    url:"../assets/query/project-status.php",
                    data:"flagAction=del&id="+id,
                    async:false,
                    success: function(res){
                        console.log(res)
                        if(res == "Success"){
                            Swal.fire({
                                icon: 'success',
                                title: 'saved',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                window.location.reload();
                            })
                        }
                    }
                });
            } else if (result.isDenied) {
            }
        })
        
    });

    function setFlag(action){
        $('#flagAction').val(action);
    }

    $( "#frm-data" ).on( "submit", function( event ) {
        event.preventDefault();
        const form = $( this );
        
        Swal.fire({
            title: 'Processing...',
            allowEscapeKey: false,
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
              swal.showLoading();
            }
        });

        form.find('input').each(function(i, o){
            const v = $(this).val();
            const eleId = $(this).attr('id');
            const txt = $(this).attr('placeholder');
            const eleErr = $('#txtErr'+eleId);
            if(v == ""){
                eleErr.show();
                eleErr.text('Please enter your '+txt);
                return false;
            }else{
                eleErr.hide();
            }
        })
        $.ajax({
            type:"POST",
            url:"../assets/query/project-status.php",
            data:form.serialize(),
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
    });
});
