<!--include('global.header')-->
<!-- Секция контента -->
<!DOCTYPE html>
<html>
<head>
	<title>Test</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/public/style/main.css">
<link rel="stylesheet" href="/public/bootstrap-select/css/bootstrap-select.min.css">


<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="/public/style/chartist.min.css">

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>


 	


<script language="javascript" type="text/javascript" src="https://rawgithub.com/AMKohn/flot/master/jquery.flot.js"></script>
<script language="javascript" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.time.min.js"></script>



   <script src="/public/script.js"></script>


<!--<script src="/public/script.js"></script>-->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="/public/bootstrap-select/js/bootstrap-select.min.js"></script>

</head>
<body>

	<div class="container col-md-10 col-xs-10 col-sm-10 col-md-offset-1 col-xs-offset-1">

		<div class="row">
		<h1>@yield('h1')</h1>
		  @yield('pagination')
		  @yield('breadcrumb')
	      @yield('content')
		</div>
	</div>
</body>
</html>