<!DOCTYPE html>
<html>
	<head>
		<title>Компонент расчёта стоимости доставки CdeK</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link type="text/css" href="assets/js/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
		<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
		<script src="assets/js/jquery-1.7.2.min.js" type="text/javascript"></script>
		<script src="assets/js/jquery-ui-1.8.21.custom.min.js" type="text/javascript"></script>
	<style type="text/css">
	.ui-autocomplete-loading {
	  background: #FFF right center no-repeat;
	}
	#city { width: 25em; }
	#log { height: 200px; width: 600px; overflow: auto; }
	</style>
	<script type="text/javascript">
	/**
	 * подтягиваем список городов ajax`ом, данные jsonp в зависмости от введённых символов
	 */
	$(function() {
	  $("#city").autocomplete({
	    source: function(request,response) {
	      $.ajax({
	        url: "http://api.cdek.ru/city/getListByTerm/jsonp.php?callback=?",
	        dataType: "jsonp",
	        data: {
	        	q: function () { return $("#city").val() },
	        	name_startsWith: function () { return $("#city").val() }
	        },
	        success: function(data) {
	          response($.map(data.geonames, function(item) {
	            return {
	              label: item.name,
	              value: item.name,
	              id: item.id
	            }
	          }));
	        }
	      });
	    },
	    minLength: 1,
	    select: function(event,ui) {
	    	//console.log("Yep!");
	    	$('#receiverCityId').val(ui.item.id);
	    }
	  });
	  
	});
	</script>
		<style type="text/css">
		body { font-family: 'Tahoma'; font-size: 12pt; }
		
		.stripe-accent { background-color: #507299; padding-top: 10px; padding-bottom: 10px; color: white; }
		
		.button-calc { background-color: #507299; color: #fff; }
		
		.button-calc:hover { background-color: #406188; }

		.ui-autocomplete-loading {
  			background: #FFF right center no-repeat;
		}
		#city { width: 25em; }
		#log { height: 200px; width: 600px; overflow: auto; }

	</style>
	</head>
	<body>
	<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">Some E-Shop</a>
        </div>
    </div>
</nav>
 		<div class="home" style="margin-top: 40px;">
			<div class="container">
				<div class="row" style="min-height: 100vh;">
			<h3>Результат скрипта</h3>
		

	
