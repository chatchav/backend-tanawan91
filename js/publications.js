
$( document ).ready(function() {
    var myEditor;
    const id = $('#id').val() | "";
    if(id != ""){
        getDataEdit(id);
    }
    // ClassicEditor
    //     .create(document.querySelector("#desc"), {
    //         extraPlugins:[getPlugin],
    //         ckfinder:
    //         {
    //          uploadUrl:'../fileupload.php'
    //         },  
    //         image: {
    //             toolbar: [
    //                 'imageStyle:inline', 'imageStyle:wrapText', 'imageStyle:breakText', '|',
    //                 'toggleImageCaption', 'imageTextAlternative'
    //             ]
    //         }
    //     })
    //     .then(editor => {
    //         myEditor = editor;
    //         console.log(Array.from(editor.ui.componentFactory.names()).join(', '));
    //     })
    //     .catch(error => {
    //         console.error(error);
    //     });
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
            url:"../assets/query/publications.php",
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

    class MyUploadAdapter {
        constructor(loader) {
            this.loader = loader;
        }

        upload() {
            return this.loader.file
                .then(file => new Promise((resolve, reject) => {
                    this._initRequest();
                    this._initListeners(resolve, reject, file);
                    this._sendRequest(file);
                }));
        }
        abort() {
            if (this.xhr) {
                this.xhr.abort();
            }
        }
        _initRequest() {
            const xhr = this.xhr = new XMLHttpRequest();
            xhr.open('POST', '../fileupload.php', true);
            xhr.responseType = 'json';
        }
        _initListeners(resolve, reject, file) {
            const xhr = this.xhr;
            const loader = this.loader;
            const genericErrorText = `Couldn't upload file: ${file.name}.`;

            xhr.addEventListener('error', () => reject(genericErrorText));
            xhr.addEventListener('abort', () => reject());
            xhr.addEventListener('load', () => {
                const response = xhr.response;
                if (!response || response.error) {
                    return reject(response && response.error ? response.error.message : genericErrorText);
                }
                resolve({
                    default: response.url
                });
            });
            if (xhr.upload) {
                xhr.upload.addEventListener('progress', evt => {
                    if (evt.lengthComputable) {
                        loader.uploadTotal = evt.total;
                        loader.uploaded = evt.loaded;
                    }
                });
            }
        }
        _sendRequest(file) {
            const data = new FormData();
            data.append('upload', file);
            this.xhr.send(data);
        }
    }

    function MyCustomUploadAdapterPlugin(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
            // Configure the URL to the upload script in your back-end here!
            return new MyUploadAdapter(loader);
        };
    }
    document.querySelectorAll("#desc").forEach(function (val) {
        ClassicEditor
            .create(val, {
                extraPlugins: [MyCustomUploadAdapterPlugin],
                image: {
                    toolbar: [
                        'imageStyle:inline', 'imageStyle:wrapText', 'imageStyle:breakText', '|',
                        'toggleImageCaption', 'imageTextAlternative'
                    ]
                }
                
            })
            .then(editor => {
                myEditor = editor;
                window.editor = editor;
                
            })
            .catch(error => {
                console.error(error);
            });
    });

    $('#add-service').on("click",function(){
        window.location.href = "/publications/create.php";
        // setFlag("add");
        // $('#img-cover').hide();
        // $('#img-temp').attr('src','');
        // $('#img-old').val('');
        
        // $('#title').val('');
        // $('#keyword').val('');
        // $('#shortdesc').text('');
        // myEditor.data.set('');
    })

    function getDataEdit(id){
        setFlag("update");
        
        $.ajax({
            type:"POST",
            url:"../assets/query/publications.php",
            data:"flagAction=edit&id="+id,
            dataType: "json",
            success: function(res){
                const data = res[0];
                console.log(data);
                if(data[0]){
                    $('#img-cover').show();
                    $('#img-temp').attr('src','/assets/img/user-upload/'+data[0]);
                    $('#img-old').val(data[0]);
                }
                $('#title').val(data[1]);
                $('#keyword').val(data[2]);
                $('#shortdesc').text(data[3]);
                myEditor.data.set(data[4]);
                
                //CKEDITOR.instances['desc'].setData(data[4])
                // $('#title_th').val(data[2]);
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
                    url:"../assets/query/publications.php",
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
        var formData = new FormData(this);
        let chkErr = "0"

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
                url:"../assets/query/publications.php",
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
                            window.location.href = "/publications";
                        })
                    }else{
                        eleErr.show();
                        eleErr.text(res);
                        return false;
                    }
                }
            });
        }else{
            Swal.close();
        }
    });
});