<!DOCTYPE html>
<html lang="en" ng-app="mainApp">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Ventas</title>

	<!--<link href="{{ asset('/css/app.css') }}" rel="stylesheet">-->
	<!-- styles -->
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="/css/styles.css" />

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<!-- Scripts -->
	<script src="/libs/jquery.js"></script>
    <script src="/libs/bootstrap.min.js"></script>
	<script src="/libs/angular.min.js"></script>
	<script src="/libs/angular-route.min.js"></script>
</head>
<body>
	@yield('content')

	<!-- custom scripts -->
    <script src="/app/app.js"></script>
    <script src="/app/ajax.js"></script>
    <script src="/app/controllers/home_controller.js"></script>
    <script src="/app/controllers/base_controller.js"></script>
    <script src="/app/controllers/customers_controller.js"></script>
    <script src="/app/controllers/vendors_controller.js"></script>
    <script src="/app/controllers/products_controller.js"></script>
</body>
</html>
