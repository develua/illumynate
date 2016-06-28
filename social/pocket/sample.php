<script type="text/javascript" src="../js/lib/jquery-1.10.1.min.js"></script>

	<!-- Add mousewheel plugin (this is optional) -->
	<script type="text/javascript" src="../js/lib/jquery.mousewheel-3.0.6.pack.js"></script>

	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="../js/source/jquery.fancybox.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="../js/source/jquery.fancybox.css?v=2.1.5" media="screen" />

	<!-- Add Button helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="../js/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
	<script type="text/javascript" src="../js/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>

	<!-- Add Thumbnail helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="../js/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
	<script type="text/javascript" src="../js/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

	<!-- Add Media helper (this is optional) -->
	<script type="text/javascript" src="../js/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
    <script type="text/javascript">
    			$('.fancybox').fancybox();

    $('.fancybox-buttons').fancybox({
				openEffect  : 'none',
				closeEffect : 'none',

				prevEffect : 'none',
				nextEffect : 'none',

				closeBtn  : false,

				helpers : {
					title : {
						type : 'inside'
					},
					buttons	: {}
				},

				afterLoad : function() {
					this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
				}
			});

    </script>
    
	<style type="text/css">
		.fancybox-custom .fancybox-skin {
			box-shadow: 0 0 50px #222;
		}

		 
	</style>

<?php
ini_set('display_errors', '1');

//const NEWLINE = '<br /><br />';
require('Pocket.php');

$params = array(
	'consumerKey' => '55636-09ccf0459a039ab2bb5a861b' // fill in your Pocket App Consumer Key
);

if (empty($params['consumerKey'])) {
	die('Please fill in your Pocket App Consumer Key');
}

$pocket = new Pocket($params);
echo "<pre>";
if (isset($_GET['authorized'])) {
		$user = $pocket->convertToken($_GET['authorized']);
	/*
		$user['access_token']	the user's access token for calls to Pocket
		$user['username']	the user's pocket username
	*/
//	print_r($user);

	// Set the user's access token to be used for all subsequent calls to the Pocket API
	$pocket->setAccessToken($user['access_token']);

//	echo NEWLINE;

/*	
	$params = array(
		'url' => 'https://github.com/gleek/', // required
		'tags' => 'github'
	);
	print_r($pocket->add($params, $user['access_token']));
*/
//	echo NEWLINE;

	// Retrieve the user's list of unread items (limit 5)
	// http://getpocket.com/developer/docs/v3/retrieve for a list of params
	$params = array( 
            'state'=>'all',
            'detailType'=>'complete',
			'count' => 50
	);
	$items = $pocket->retrieve($params, $user['access_token']);
	print_r($items);
    
    foreach($items['list'] as $item)
    {
        echo '<iframe src="'.$item['resolved_url'].'" height="200px" width="25%"><a onclick="javascript:window.parent.location.href="http://www.google.com"; return false;">link</a></iframe>';
        echo $item['resolved_title'].'<br/>';
        echo $item['resolved_url'].'<br/>';
    }
    echo '<iframe src="https://www.upwork.com/ab/find-work/"></iframe>';
} else {
	// Attempt to detect the url of the current page to redirect back to
	// Normally you wouldn't do this
	$redirect = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 'https' : 'http') . '://'  . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?authorized=';

	// Request a token from Pocket
	$result = $pocket->requestToken($redirect);
	/*
		$result['redirect_uri']		this is the URL to send the user to getpocket.com to authorize your app
		$result['request_token']	this is the request_token which you will need to use to
						obtain the user's access token after they have authorized your app
	Normally you should save the 'request_token' in a session so it can be
	retrieved when the user is redirected back to you
	*/
	$result['redirect_uri'] = str_replace(
		urlencode('?authorized='),
		urlencode('?authorized=' . $result['request_token']),
		$result['redirect_uri']
	);
	// To redirect back to us.
echo "</pre>";
	header('Location: ' . $result['redirect_uri']);
}
