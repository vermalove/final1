<!DOCTYPE html>
<html lang="en">

<head>
  <title>FACEBOOK</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<style> 
input[type=text] {
    width: 330px;
    box-sizing: border-box;
    border: 2px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    background-color: white;
    background-image: url('searchicon.png');
    background-position: 10px 10px; 
    background-repeat: no-repeat;
    padding: 12px 20px 12px 40px;
    -webkit-transition: width 0.4s ease-in-out;
    transition: width 0.4s ease-in-out;
}

input[type=text]:focus {
    width: 70%;
}
</style>
<script>
    window.fbAsyncInit = function() {
      FB.init({
        appId      : '{your-app-id}',
        xfbml      : true,
        version    : 'v2.5'
      });
    
      // Get Embedded Video Player API Instance
      var my_video_player;
      FB.Event.subscribe('xfbml.ready', function(msg) {
        if (msg.type === 'video') {
          my_video_player = msg.instance;
        }
      });
    };

    (function(d, s, id){
       var js, fjs = d.getElementsByTagName(s)[0];
       if (d.getElementById(id)) {return;}
       js = d.createElement(s); js.id = id;
       js.src = "//connect.facebook.net/en_US/sdk.js";
       fjs.parentNode.insertBefore(js, fjs);
     }(document, 'script', 'facebook-jssdk'));
  </script>
<body>

<div class="jumbotron text-center"style=" background-color: #4169E1" >
  <h1> SEARCH FACEBOOK PAGE</h1>
  <form action = "<?php $_SERVER['PHP_SELF'] ?>" method ="POST">
 
    <input type="text" name="location" placeholder="ENTER PAGE ID">
	
      </form> 
	 <b> ACCESS TOKEN VALID FOR 
	  <?php

$json = @file_get_contents('https://graph.facebook.com/oauth/access_token?client_id=305385669938448&client_secret=b1e701cfba9ce9087b12d4f1dbd901e5&grant_type=fb_exchange_token&fb_exchange_token=EAAEVvyRgTRABANOK7lIkU3DSCxCVQKVYWHZAHkLdaQyZCIu4JJFKP5caW0EbJ8lHE6d7dVYQCC7ekQDRNgDneoqrDql7Qwlyic7Bc1mJeCce3D6jzesn7RKIgmnmXMWtEEkELgtF0q48puQrVeI3fRRh1YAsAZD');
$token = json_decode($json);
$access_token=$token->access_token;

  echo (($token->expires_in)/(24*60*60));
  ?>
  <b>
	DAYS
</div>
  
<div class="container">
  <div class="row">
    <div class="col-sm-4">
      <h3>POST</h3>
<?php
		
    error_reporting(1);
$page_id = $_POST["location"];
$json_object = @file_get_contents('https://graph.facebook.com/' . $page_id . '/posts?access_token=' . $access_token);
//Interpret data
$fbdata = json_decode($json_object);
$Acount=0;
foreach ($fbdata->data as $post )
{	
  if($Acount<2){
  $posts .= '<p>' . $post->id . '</p>';

$pi  =  $post->id;
$pid = explode("_", $pi);

echo '<div class="fb-post" data-href="https://www.facebook.com/'. $page_id .'/posts/'. $pid[1] .'" 
data-width="300" data-show-text="true"></div><br>';
$Acount++;
}}
?>

    </div>
    <div class="col-sm-4">
      <h3>PHOTO</h3>
	  
<?php

//Get the JSON
$json_object = @file_get_contents('https://graph.facebook.com/' . $page_id . '/photos?access_token=' . $access_token);
//Interpret data
$fbdata = json_decode($json_object);
$bcount=0;
foreach ($fbdata->data as $post )
{if($bcount<2){
$posts .= '<p>' . $post->id . '</p>';

//Display the posts

echo '<div class="fb-post" data-href="https://www.facebook.com/'. $page_id .'/posts/'. $post->id .'" 
data-width="300" data-show-text="true"></div>';
$bcount++;

}
}
?>
    </div>
    <div class="col-sm-4">
	 <h3>Videos</h3>
      <?php

//Get the JSON
$json_object = @file_get_contents('https://graph.facebook.com/' . $page_id . '/videos?access_token=' . $access_token);
//Interpret data
$fbdata = json_decode($json_object);
$ccount=0;
foreach ($fbdata->data as $post )
{	if($ccount<2){
$posts .= '<p>' . $post->id . '</p>';

echo' <div  
    class="fb-video" 
    data-href="https://www.facebook.com/'. $page_id .'/videos/'. $post->id .'/" 
    data-width="300" 
    data-allowfullscreen="true"></div><br><br><br>';
echo '<p>' . $post->description. '</p>';
$ccount++;
}}
?>
    </div>

  </div>
</div>

</body>
</html>
