<?php
/**
 * Language School page template (for React app)
 *
 * @since    1.0.0
 */ ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
 <head>
 	<meta charset="<?php bloginfo( 'charset' ); ?>">
 	<meta http-equiv="X-UA-Compatible" content="IE=edge">
 	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 	<meta name="mobile-web-app-capable" content="yes">
 	<meta name="apple-mobile-web-app-capable" content="yes">
 	<meta name="apple-mobile-web-app-title" content="<?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?>">
 	<link rel="profile" href="http://gmpg.org/xfn/11">
 	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <!-- <link href="https://fonts.googleapis.com/css?family=Fredoka+One" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet"> -->

    <!-- Font added for WNF --!>
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed&display=swap" rel="stylesheet">

  	<meta property="og:url" content="<?php global $wp; echo home_url( $wp->request ) ?>" />
  	<meta property="og:type" content="article" />
  	<meta property="og:title" content="<?php bloginfo( 'name' ); ?> - Language School" />
  	<meta property="og:description" content="Come and check out LearnDitidaht.ca, the official language learning site of the Ditidaht school. x̣uux̣takšƛ diid̓iitidq!" />
  	<meta property="og:image" content="http://learnditidaht.ca/wp-content/uploads/2018/04/ditidaht-share.png" />
 	<?php wp_head(); ?>
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous"> -->
  <!-- <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script> -->

 </head>

 <body <?php body_class(); ?>>
   <div id="root">
     <div id="loader" style="text-align:center;margin-top:20px;display:none;">
       <h4>If the page does not load after a few seconds, please reload.</h4>
     </div>
   </div>
 </body>

 <script>
 setTimeout(function() {
   if(document.getElementById('loader')) {
     document.getElementById('loader').style.display = 'block';
   }
 },2000);
 </script>

 <!-- <script src="http://localhost:3000/static/js/bundle.js"></script> -->

<?php wp_footer(); ?>
