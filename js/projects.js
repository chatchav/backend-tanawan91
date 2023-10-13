
$( document ).ready(function() {
    const href = window.location.href;
    const tab = href.split('#');
    const nevTab = $('ul.nav-tabs');
    if(tab.length == 2){
        setActive(tab[1]);
    }else{
        setActive("info");
    }
    var myEditor;

    $('#add-service').on("click",function(){
        setFlag("add");
        $('#img-cover').hide();
        $('#img-old').val("");
    
        $('#title').val("");
        $('#keyword').val("");
        $('#desc').text("");
        myEditor.data.set("");

        $('#metadesc').text("");
        $('#type').val("");
        $('#year').val("");
        $('#location').val("");
        $('#status').val("");
        $('#area').val("");
        $('#client').val("");
        $('#architect').val("");
        $('#contractor').val("");

        $("#form-albums").html("")
    })
    
    ClassicEditor
        .create(document.querySelector("#desc"), {
            toolbar: [
                'selectAll', 'undo', 'redo', 'bold', 'italic', 'blockQuote', 'link', 'ckfinder', 'uploadImage',
                'imageUpload', 'heading', 'imageTextAlternative', 'toggleImageCaption', 'Source',
                'indent', 'outdent', 'numberedList', 'bulletedList', 'mediaEmbed', 'insertTable', 'tableColumn', 'tableRow', 'mergeTableCells'
            ],
            height:'500'
        })
        .then(editor => {
            myEditor = editor;
        })
        .catch(error => {
            console.error(error);
        });

    $(document)
        .on("click", ".nav-item", activeTap)
        .on("click",".btn-choose-image",function(){
            $($(this).attr("data-target")).click();
        })
        $(document).on('change', '.form-chksize-album', function () {
            const file = this.files[0];
            if (file.name !== "") {
                const imgRef = $(this).attr('data-img-ref');
                $('img[data-img-ref="' + imgRef + '"]').attr("src", URL.createObjectURL(file));
                $('.form-restore-img[data-img-ref="'+ imgRef +'"]').show();
            }
        })
        .on("click",".btn-delete-image",function(){
            $(this).closest(".col-sm-4").remove();
            $("#form-albums .col-sm-4").each(function(i, o){
                $(this).find(".btn-delete-image").attr("data-seq", i);
                $(this).find(".img-fluid").attr("data-img-ref", i);
                $(this).find(".btn-choose-image").attr("data-target", "#new-image-"+i);
                $(this).find("input[type='file']").attr({"name": "albums["+i+"]","data-img-ref":i,"id":"new-image-"+i});
                $(this).find(".old-album").attr({"name": "albumOld["+i+"]"});
            })
        });

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
                el.removeClass("active");
                $('#'+h).hide();
            }else{
                el.addClass("active");
                $('#'+h).show();
            } 
        });
    }

    $("#add-image").on("click",function(){
        var seq = $("#form-albums .col-sm-4").length;
        var content = `
            <div class="col-sm-4 p-0">
                <div class="border rounded m-2 p-2 album-below-form-cover" style="background-color: #e9ecef;">
                    <div style="display: flex;align-items: center; justify-content: end;">
                        <button type="button" class="btn-close btn-delete-image" aria-label="Close" data-seq="`+seq+`"></button>
                    </div>
                    <div class="flex my-2 text-center">
                        <img src="../assets/img/img-default.jpg" data-img-default="" data-img-ref="`+seq+`" class="img-fluid mx-auto" style="width: 100%; max-width: 330px;"> 
                    </div>
                    <div class="flex text-center mt-2"> 
                        <button class="btn btn-primary btn-choose-image" type="button" data-target="#new-image-`+seq+`">Choose image</button>
                        <input type="file" class="form-control form-chksize-album" name="albums[`+seq+`]" style="display:none" data-img-ref="`+seq+`" id="new-image-`+seq+`" accept="image/*" />
                        <input type="hidden" class="old-album" name="albumOld[`+seq+`]" />
                    </div>
                </div> 
            </div>`;
        $("#form-albums").append(content)
    });

    function setFlag(action){
        $('#flagAction').val(action);
    }

    $('.btn-edit-data').on('click',function(){
        setFlag("update");
        const id = $(this).attr('data-id');
        $('#id').val(id);
        $.ajax({
            type:"POST",
            url:"../assets/query/projects.php",
            data:"flagAction=edit&id="+id,
            dataType: "json",
            success: function(res){
                console.log(res);
                const data = res.info;
                const dataAlbums = res.albums;

                if(data[0]){
                    $('#img-cover').show();
                    $('#img-temp').attr('src','/assets/img/user-upload/'+data[0]);
                    $('#img-old').val(data[0]);
                }
                $('#title').val(data[1]);
                $('#keyword').val(data[2]);
                $('#desc').text(data[3]);
                myEditor.data.set(data[3]);

                $('#metadesc').text(data[4]);
                $('#type').val(data[5]);
                $('#year').val(data[6]);
                $('#location').val(data[7]);
                $('#status').val(data[8]);
                $('#area').val(data[9]);
                $('#client').val(data[10]);
                $('#architect').val(data[11]);
                $('#contractor').val(data[12]);
                
                var content = ``;
                $.each(dataAlbums, function(i, d) {
                    console.log(i,d);
                    content += `
                    <div class="col-sm-4 p-0">
                        <div class="border rounded m-2 p-2 album-below-form-cover" style="background-color: #e9ecef;">
                            <div style="display: flex;align-items: center; justify-content: end;">
                                <button type="button" class="btn-close btn-delete-image" aria-label="Close" data-seq="`+i+`"></button>
                            </div>
                            <div class="flex my-2 text-center">
                                <img src="../assets/img/user-upload/`+d[0]+`" data-img-default="" data-img-ref="`+i+`" class="img-fluid mx-auto" style="width: 100%; max-width: 330px;"> 
                            </div>
                            <div class="flex text-center mt-2"> 
                                <button class="btn btn-primary btn-choose-image" type="button" data-target="#new-image-`+i+`">Choose image</button>
                                <input type="file" class="form-control form-chksize-album" name="albums[`+i+`]" style="display:none" data-img-ref="`+i+`" id="new-image-`+i+`" accept="image/*" />
                                <input type="hidden" class="old-album" name="albumOld[`+i+`]" value="`+d[0]+`" />
                            </div>
                        </div> 
                    </div>`;
                });
                $("#form-albums").append(content)
            }
        });
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
        if(chkErr != '1'){
            $.ajax({
                type:"POST",
                url:"../assets/query/projects.php",
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