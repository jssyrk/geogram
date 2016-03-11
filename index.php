<?php
error_reporting(0);

if (!empty($_GET['location'])){
  /**
   * Here we build the url we'll be using to access the google maps api
   */
  $maps_url = 'https://'.
  'maps.googleapis.com/'.
  'maps/api/geocode/json'.
  '?address=' . urlencode($_GET['location']);
  $maps_json = file_get_contents($maps_url);
  $maps_array = json_decode($maps_json, true);
  $lat = $maps_array['results'][0]['geometry']['location']['lat'];
  $lng = $maps_array['results'][0]['geometry']['location']['lng'];
  /**
   * Time to make our Instagram api request. We'll build the url using the
   * coordinate values returned by the google maps api
   */
  $instagram_url = 'https://'.
    'api.instagram.com/v1/media/search' .
    '?lat=' . $lat .
    '&lng=' . $lng .
    '&client_id=7b0aa5e522ee4445845fefa307277146'; //replace "CLIENT-ID"
  $instagram_json = file_get_contents($instagram_url);
  $instagram_array = json_decode($instagram_json, true);
}
?>

<!doctype html>
<html>

<head>
    
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">
    <meta name="viewport" content="width=device-width, minimal-ui">

	<title>GeoGram • Geo Locational Search for Instagram</title>

    <link rel="shortcut icon" href="images/icon.png">
    <link rel="apple-touch-icon" href="images/icon.png">
    <link rel="stylesheet"  href="css/base.css">

    <!-- Fallback Font -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>

    <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>

</head>

<body>

    <div id="wrapper">

        <header>
            <div class="sectioncontent">
                <div id="logo">
                    <img src="images/logo.png">
                    <p>search for an image based on geographical location</p>
                </div>

                <div id="form">
                    <form action="index.php" method="get">
                        <input id="searchbar" type="text" name="location" placeholder="Try something like London, New York, Facebook, Five Guys"/>
                    </form>
                </div>

            </div>
        </header>

        <section id="results">
             <?php
        if(!empty($instagram_array)){
          foreach($instagram_array['data'] as $key=>$image){
            echo '<img class="searchresult" src="'.$image['images']['standard_resolution']['url'].'" alt=""/>';
          }
        }
        ?>
        </section>

        <footer>
            <h1>This project was made using the Google Maps and Instagram API.</h1>
            <h2>Made using HTML, SCSS, and PHP. Compiled using Compass. Coded by <a href="http://jssyrk.co/">JSSYRK</a></h2>
        </footer>
       
    </div>

</body>
</html>






