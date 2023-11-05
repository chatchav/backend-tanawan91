
$( document ).ready(function() {
    const href = window.location.href;
    const tab = href.split('#');
    const nevTab = $('ul.nav-tabs');
    const id = $('#id').val() | "";
    const ele = $('#type');
    console.log(ele,"e");
    if(ele != ""){
        if(tab.length == 2){
                ele.val(tab[1]);
        }else{
            ele.val("design");
        }
    }
        
    if(id != ""){
        getDataEdit(id);
    }

    if(tab.length == 2){
        setActive(tab[1]);
    }else{
        setActive("design");
    }

    $(document)
        .on("click", ".nav-item", activeTap)
        .on("click","#add-service",create)

    function create(){
        // setFlag("add");
        const h = window.location.href;
        const t = h.split('#');
        let type = "design";
        if(t.length == 2){
            type = t[1];
        }
        console.log(h,t);
        window.location.href = "/services/create.php#"+type;
        
        // const ele = $('#type');
        // if(t.length == 2){
        //     //if(t[1] == "build"){
        //         ele.val(t[1]);
        //     // }else{
        //     //     ele.val("build");
        //     // }
        // }else{
        //     ele.val("design");
        // }
        // $('#title').val('');
        // $('#desc').text('');
        // console.log(t);
    }

    function activeTap (){
        var ele = $(this).find('a');
        var tab = ele.attr('href').replace('#','');
        setActive(tab);
    }

    function setActive(tab){
        $(nevTab).find('.nav-item').each(function() {
            var el = $(this).find('a');
            var h = el.attr('href').replace('#','');
            if(h != tab){
                $('#'+h).hide();
                el.removeClass("active");
            }else{
                $('#'+h).show();
                el.addClass("active");
            } 
        }); 
    }


    $('.btn-sort').on("click",function(){
        const e = $(this);
        const sort = e.attr("data-sort");
        const id = e.attr("data-id");
        let type = "";
        if(tab.length == 2){
            type = tab[1];
        }else{
            type = "design";
        }

        const rows = e.parents('table > tbody').find("tr").length;
        console.log(rows);
        //console.log($(this).parent().parent(),$(this).attr("data-sort"),$(this).attr("data-id"));
        var tr = e.parents("tr:first");
        var index = tr.attr("data-index");
        // var index = table.row(row).index();
        $.ajax({
            type:"POST",
            url:"../assets/query/services.php",
            data:"flagAction=sort"+sort+"&id="+id+"&type="+type,
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
        $.each(e.parents('#table > tbody').find("tr"),function(){
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

    function getDataEdit(id){
        setFlag("update");
        // const id = $(this).attr('data-id');
        // $('#id').val(id);
        $.ajax({
            type:"POST",
            url:"../assets/query/services.php",
            data:"flagAction=edit&id="+id,
            dataType: "json",
            success: function(res){
                const data = res[0];
                $('#title').val(data[1]);
                $('#type').val(data[2]);
                $('#desc').text(data[3]);
            }
        });
    };

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
                    url:"../assets/query/services.php",
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

        if(chkErr != '1'){
            $.ajax({
                type:"POST",
                url:"../assets/query/services.php",
                data:form.serialize(),
                success: function(res){
                    console.log(res);
                    const eleErr = $('#txtErrtitle');
                    if(res == "Success"){
                       // $('#exampleModal').modal('toggle');
                        Swal.fire({
                            icon: 'success',
                            title: 'saved',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = "/services";
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