@extends('app')

@section('content')
<nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle Navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#/">Ventas App</a>
		</div>

		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						Catálogos <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="#/customers">Clientes</a></li>
						<li><a href="#/vendors">Proveedores</a></li>
						<li><a href="#/products">Productos</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						Reportes <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="#/products-compare">Comparativo de Productos</a></li>
						<!--<li><a href="#/products-history">Historial de Productos</a></li>-->
					</ul>
				</li>
				<li><a href="#/purchase-orders">Ordenes de Compra</a></li>
			</ul>

			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->getShortName() }} <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="{{ url('/auth/logout') }}">Cerrar Sesión</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>

<div class="container cls-main-container">
  <div data-ng-view></div>
</div>

@endsection
