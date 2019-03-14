<?php
header('Content-Type:application/json');
$connect=mysqli_connect('127.0.0.1','root','','123');
if(!$connect){
    die("无法连接上数据库，请联系管理员");
}

$scholar_num=htmlspecialchars(trim($_POST['scholar_num']));
$search_info=$connect->prepare("SELECT * FROM signup WHERE scholar_num=?");
$search_info->bind_param("s",$scholar_num);
$search_info->execute();
$search_result=$search_info->get_result();
$result_array=mysqli_fetch_array($search_result);
if($result_array==NULL){
    $return_search=[
        'errcode'=>112,
        'errmsg'=>"亲亲，您输入的学号不存在，这边建议您检查或重新报名"
    ];
    echo json_encode($return_search);
}else{
    $return_search=[
        'get_result'=>$result_array,
        'name'=>$result_array[0],
        'scholar_num'=>$result_array[1],
        'sex'=>$result_array[2],
        'college'=>$result_array[3],
        'phone'=>$result_array[4],
        'first'=>$result_array[5],
        'second'=>$result_array[6],
        'adjust'=>$result_array[7],
        'introduction'=>$result_array[8],
        'grade'=>$result_array[10],
        'errode'=>0
    ];
    echo json_encode($return_search);
}
mysqli_close($connect);

