<?php 
    ob_start();
    session_start();
    include_once('../src/facebook.php');
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Albums</title>
</head>
<body>
<?php

$params = array(
    'appId' => '1037512873011672',
    'secret' => '04ab1efbb316dcbd3ff226c287470d01',
);
$facebook = new Facebook($params);
$user = $facebook->getUser();
$log = null;

if ($user) {
    $log = $facebook->getLogoutUrl();
} else {
    $log = $facebook->getLoginUrl(array('scope' => 'user_photos'));
}
echo '<a href="'.$log.'">' . (($user) ? 'logout' : 'login') . '</a>';
    if ($user) {
        $data = $facebook->api(
            '/me/albums',
            'GET',
            array(
                'fields' => 'id,name,privacy,photos.fields(id,name,images)',
                'limit' => '300'
            )
        );

        foreach ($data['data'] as $album) {
            echo '<div>';
                echo '<h3>' . $album['name'] . ' ' . $album['privacy'] . '</h3>';
                echo '<textarea style="width: 800px; height: 500px;">';
                    foreach ($album['photos']['data'] as $photo) {
                                echo $photo['images'][0]['source'].'';
                    }
                echo '</textarea>';

                echo '<textarea style="width: 800px; height: 500px;">';
                    foreach ($album['photos']['data'] as $photo) {
                               echo $photo['images'][7]['source'].'';
                    }
                echo '</textarea>';
            echo '</div>';
            //break;
        }
    }

    ?>
</body>
</html>
<?php ob_flush(); ?>