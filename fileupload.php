<?php
$data =array();
if(isset($_FILES['upload']['name']))
{
$file_name= $_FILES['upload']['name'];
$file_path='upload/'.$file_name;
$target ='upload/';
$file_extension = strtolower(pathinfo($file_path,PATHINFO_EXTENSION));
if($file_extension=='jpg' || $file_extension=='jpeg'|| $file_extension=='png')
{
    if(move_uploaded_file($_FILES['upload']['tmp_name'],$file_path))
    {
        $data['file']=$file_name;
        $data['url']= "https://tanawan91.ddlcoding.com/".$file_path;
        $data['uploaded']=1;
    }
    else{
        $data['uploaded']=0;
        $data['error']['message']='erorr';
        
    }
}
    else{
        $data['uploaded']=0;
        $data['error']['message']='invalid img';
        
    }
}
echo json_encode($data);
?>

