$(document).ready(function(){
    //getData();
    $('#add-service').on("click",function(){
        setFlag("add");
        $('#title').val('');
        $('#title_th').val('');
    })

    $('.btn-sort').on("click",function(){
        const rows = $('#table > tbody').find("tr").length;
        console.log(rows);
        const e = $(this);
        const sort = e.attr("data-sort");
        const id = e.attr("data-id");

        //console.log($(this).parent().parent(),$(this).attr("data-sort"),$(this).attr("data-id"));
        var tr = e.parents("tr:first");
        var index = tr.attr("data-index");
        // var index = table.row(row).index();
        $.ajax({
            type:"POST",
            url:"../assets/query/project-type.php",
            data:"flagAction=sort"+sort+"&id="+id,
            async:false,
            success: function(res){
                console.log(res)
                if(res == "Success"){
                    if(sort == "down"){
                        $("tr[data-index='"+(parseInt(index)+1)+"']").after(tr);
                    }else{
                        $("tr[data-index='"+(parseInt(index)-1)+"']").before(tr);
                    }
                }
            }
        });

        let i = 0;
        $.each($('#table > tbody').find("tr"),function(){
            $(this).attr("data-index",i);
            var btnup = $(this).find("button[data-sort='up']");
            var btndown = $(this).find("button[data-sort='down']");
            btnup.removeAttr("disabled");
            btndown.removeAttr("disabled");
            if(i == 0){
                btnup.attr("disabled","disabled");
            }
            if(i == (rows-1)){
                btndown.attr("disabled","disabled");
            }
            i++;
            // console.log($(this));
        });
    })

    $('.btn-edit-data').on('click',function(){
        setFlag("update");
        const id = $(this).attr('data-id');
        $('#id').val(id);
        $.ajax({
            type:"POST",
            url:"../assets/query/project-type.php",
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
                    url:"../assets/query/project-type.php",
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

    function getData(){
        $.ajax({
            type:"POST",
            url:"../assets/query/project-type.php",
            data:"flagAction=list",
            dataType: "json",
            success: function(res){
                console.log(res);
                let html = ``;
                $.each(res, function(i, d) {
                    console.log(i,d);
                    html += `
                        <tr>
                            <td>`+d[1]+`</td>
                            <td>`+d[2]+`</td>
                            <td>
                            <button type="button" id="add-service" className="mt-4 btn btn-primary">edit</button>
                            <button type="button" id="add-service" className="mt-4 btn btn-primary">delete</button>
                            </td>
                        </tr>
                    `;
                });
                const tbl = $('.datatable-table').find('tbody')[0]; 
                // console.log($('.datatable-table').find('tbody'));
                // tbl.append(html);
            }
        });
    }

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
            url:"../assets/query/project-type.php",
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
