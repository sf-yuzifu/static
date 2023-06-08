<?php
    $test = pathinfo(@$_GET['userid'],PATHINFO_BASENAME);
    $str = file_get_contents('https://api.codemao.cn/creation-tools/v1/user/center/honor?user_id='.$test);
    $data = json_decode($str);
    $imgpath = $data -> {'avatar_url'};
    if ($imgpath) {
        header('Location:' . $imgpath);
        exit();
    } else {
        header('Location:' . "https://cdn-community.codemao.cn/community_frontend/asset/default_guest_3f731.png");
        exit('error');
    }
?>