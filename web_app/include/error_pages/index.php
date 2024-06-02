<!DOCTYPE html>
<html lang="en">
<?php error_reporting(0) ?>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>Error</title>

	<!-- Google font -->
	<link href="https://fonts.googleapis.com/css?family=Nunito:400,700" rel="stylesheet">

	<!-- Custom stlylesheet -->
	<link type="text/css" rel="stylesheet" href="css/style.css" />

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

</head>

<body>
	<div id="notfound">
		<div class="notfound">
			<div class="notfound-404"></div>
			<h1><?php echo $_GET['error'] ?>
                <?php
                    if ($_GET['error'] == '404'){

                    }
                    switch ($_GET['error']){
                        case '404':
                            echo '<h2>Oops! Page Not Found</h2>';
                            echo '
                            <p>Sorry but the page you are looking for does not exist, has been removed, or is temporarily unavailable</p>      
                        ';
                            break;
                        case '403':
                            echo '<h2>Oops! Are you lost? You are not supposed to be here!</h2>';
                            echo '
                            <p>Sorry but the page you are trying to access is restricted! 
                            If you think you should be able to access this page, contact an admin!</p>      
                        ';
                    }
                ?>
			<a href="/Boxcom/index.php?page=index&id=1">Back to homepage</a>
		</div>
	</div>

</body>

</html>
