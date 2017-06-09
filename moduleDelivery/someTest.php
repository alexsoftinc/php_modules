<!DOCTYPE html>
<html>
<head>
	<title>Расчёт стоимости доставки в различные регионы</title>
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
	<meta charset="utf-8">
	<link type="text/css" href="assets/js/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
	<script src="assets/js/jquery-1.7.2.min.js" type="text/javascript"></script>
	<script src="assets/js/jquery-ui-1.8.21.custom.min.js" type="text/javascript"></script>
	<!-- другие стили -->
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
</head>
<body>
<div class="ui-widget" style="display: inline-block;">
	  <input id="city" />
	  <br />
	</div>
<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Some E-Shop</a>
        </div>
    </div>
</nav>
 		<div class="home" style="margin-top: 40px;">
			<div class="container">
				<div class="row" style="min-height: 100vh;">
					
					<div class="col-md-12" style="color: #000; padding-top: 10px; padding-bottom: 10px;">
						<p>Добрый день! 
						Мы рады представить Вам наш новый удобный калькулятор расчета доставки посылок, созданный благодаря сотрудничеству с транспортной компанией СДЭК!</p><hr/>
						<p>Чтобы узнать стоимость доставки в Ваш город начните вводить его название в поле внизу, а затем выберите нужный из выпадающего списка.</p>
						
					</div>
					
					<form method="post" id="cdek" action="formControl.php">
						<input name="receiverCityId" id="receiverCityId" value="" hidden />
						<!-- <input name="tariffId" value="137" hidden /> --> 
						<!-- id тарифа, Посылка склад-дверь -->
						<input name="tariffList1" value="10" hidden />
						<input name="tariffList2" value="137" hidden />
						
						<input name="modeId" value="3" hidden /> <!-- режим доставки, склад-дверь -->
						<input name="dateExecute" value="2017-06-12" hidden /> <!-- Дата доставки -->
						
						<input name="weight1" value="8" hidden /> <!-- Вес места, кг.  -->
						<input name="length1" value="55" hidden /> <!-- Длина места, см. -->
						<input name="width1" value="45" hidden /> <!-- Ширина места, см. -->
						<input name="height1" value="22" hidden /> <!-- Высота места, см. -->			
						
						<input name="weight2" value="12" hidden /> <!-- Вес места, кг.--> 
						<input name="volume2" value="22" hidden /> <!-- объём места, длина*ширина*высота. -->
						<div class="col-md-12">
							
						<input class="form-control" style="width: 100%;" name="senderCityId" id="city" placeholder="Название населённого пункта" />
							
						</div>
						<div class="col-md-12" style="margin: 20px 0px;">
							<input type="submit" class="form-control button-calc" value="Рассчитать" />
						</div>
					</form>
					
				</div>
			</div>
		</div>

</body>
</html>
