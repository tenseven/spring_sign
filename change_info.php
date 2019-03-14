<?php
header('Content-Type:application/json');
$connect=mysqli_connect('127.0.0.1','root','','123');
if(!$connect){
    die("无法连接上数据库，请联系管理员");
}

$name=htmlspecialchars(trim($_POST['name']));
$scholar_num=htmlspecialchars(trim($_POST['scholar_num']));
$sex=htmlspecialchars(trim($_POST['sex']));
$college=htmlspecialchars(trim($_POST['college']));
$phone=htmlspecialchars(trim($_POST['phone']));
$first=htmlspecialchars(trim($_POST['first']));
$second=htmlspecialchars(trim($_POST['second']));
$adjust=htmlspecialchars(trim($_POST['adjust']));
$introduction=htmlspecialchars(trim($_POST['introduction']));
$grade=htmlspecialchars(trim($_POST['grade']));
$info_array=array($name,$scholar_num,$sex,$college,$sex,$college,$phone,$first,
$second,$adjust,$introduction,$grade);
$caculate_null=0;
foreach($info_array as $value){
    if($value==NULL){
        $caculate_null++;
    }
}
$search_info=$connect->prepare("SELECT * FROM signup WHERE scholar_num=?");
$search_info->bind_param("s",$scholar_num);
$search_info->execute();
$search_result=$search_info->get_result();
$result_array=mysqli_fetch_array($search_result);
if($caculate_null==0){
    if($result_array==NULL){
        $insert_info=$connect->prepare("INSERT INTO signup VALUES (NULL,?,?,?,?,?,?,?,?,?,now(),?)");
        $insert_info->bind_param("ssssssssss",$name,$scholar_num,$sex,$college,$phone,$first,$second,$adjust,$introduction,$grade);
        $insert_info->execute();
        $return_result=[
            'errcode'=>0,
            'msg'=>"报名成功"
        ];
        echo json_encode($return_result);
    }else{
        $update_info=$connect->prepare("UPDATE signup SET id=NULL,name=?,scholar_num=?,sex=?,college=?,phone=?,first=?,second=?,adjust=?,introduction=?,createtime=now(),grade=? WHERE scholar_num=?");
        $update_info->bind_param("sssssssssss",$name,$scholar_num,$sex,$college,$phone,$first,$second,$adjust,$introduction,$grade,$scholar_num);
        $update_info->execute();
        $return_result=[
            'errcode'=>0,
            'msg'=>"报名成功"
        ];
        echo json_encode($return_result);
    }
}else{

    $return_erro=[
        'errocode'=>123,
        'msg'=>"信息未填完，亲亲请完善信息"
    ];
    echo json_encode($return_erro);

}

mysqli_close($connect);

