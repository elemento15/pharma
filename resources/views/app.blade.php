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
    <link rel="stylesheet" type="text/css" href="/css/angular-toastr.min.css" />
    <link rel="stylesheet" type="text/css" href="/css/angular-confirm.min.css" />
    <link rel="stylesheet" type="text/css" href="/css/ui-bootstrap-2.5.0-csp.css" />
    <link rel="stylesheet" type="text/css" href="/css/select.min.css" />
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
	<!-- https://github.com/Foxandxss/angular-toastr -->
	<script src="/libs/angular-toastr.tpls.min.js"></script>
	<!-- https://craftpip.github.io/angular-confirm/ -->
	<script src="/libs/angular-confirm.min.js"></script>
	<!-- https://github.com/angular-ui/ui-select/wiki -->
	<script src="/libs/select.min.js"></script>
	<!-- -->
	<!--<script src="/libs/ui-bootstrap-2.5.0.min.js"></script>-->
	<script src="/libs/ui-bootstrap-tpls-2.5.0.min.js"></script>

</head>
<body>
	@yield('content')

	<!-- general scripts -->
    <script src="/app/app.js"></script>
    <script src="/app/ajax.js"></script>

	<!-- components -->
    <script src="/app/components/modal_products_search.js"></script>
    <script src="/app/components/modal_change_status.js"></script>
    
	<!-- controllers -->
    <script src="/app/controllers/home_controller.js"></script>
    <script src="/app/controllers/base_controller.js"></script>
    <script src="/app/controllers/customers_controller.js"></script>
    <script src="/app/controllers/vendors_controller.js"></script>
    <script src="/app/controllers/vendors_prices_controller.js"></script>
    <script src="/app/controllers/products_controller.js"></script>
    <script src="/app/controllers/products_history_controller.js"></script>
    <script src="/app/controllers/products_compare_controller.js"></script>
    <script src="/app/controllers/purchase_orders_controller.js"></script>
    <script src="/app/controllers/cotizations_controller.js"></script>
</body>
</html>
