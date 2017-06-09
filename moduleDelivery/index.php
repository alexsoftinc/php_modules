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
          <a class="navbar-brand" href="http://lamzac.od.ua/">Some E-Shop</a>
        </div>
    </div>
</nav>
 		<div class="home" style="margin-top: 40px;">
			<div class="container">
				<div class="row" style="min-height: 100vh;">
					
					<div class="col-md-12" style="color: #000; padding-top: 10px; margin-top: 10px; padding-bottom: 10px;">
						<p>Добрый день! 
						Мы рады представить Вам наш новый удобный калькулятор расчета доставки посылок, созданный благодаря сотрудничеству с транспортной компанией СДЭК!</p><hr/>
						<p>Чтобы узнать стоимость доставки в Ваш город начните вводить его название в поле внизу, а затем выберите нужный из выпадающего списка.</p>
						
					</div>


		<form action="formControl.php" id="cdek" method="POST" />
			<input name="senderCityId" value="44" hidden /> <!-- Город-отправитель, Новосибирск -->
			<input name="receiverCityId" id="receiverCityId" value="" hidden /> <!-- Город-получатель -->
			
			<!-- <input name="tariffId" value="137" hidden /> --> <!-- id тарифа, Посылка склад-дверь -->
			<input name="tariffList1" value="10" hidden />
			<input name="tariffList2" value="137" hidden />
			
			<input name="modeId" value="3" hidden /> <!-- режим доставки, склад-дверь -->
			<input name="dateExecute" value="<?= date('Y-m-d') ?>" hidden /> <!-- Дата доставки -->
			
			<input name="weight1" value="8" hidden /> <!-- Вес места, кг.  -->
			<input name="length1" value="55" hidden /> <!-- Длина места, см. -->
			<input name="width1" value="45" hidden /> <!-- Ширина места, см. -->
			<input name="height1" value="22" hidden /> <!-- Высота места, см. -->			
			
			<input name="weight2" value="12" hidden /> <!-- Вес места, кг.--> 
			<input name="volume2" value="0.1" hidden /> <!-- объём места, длина*ширина*высота. -->
	<label for="city">Город-получатель: </label>
	<div class="ui-widget" style="display: inline-block;">
	  <input id="city" />
	  <br />
	</div>
			<input type="submit" class="btn btn-md btn-primary" value="Посчитать">
		</form>

				</div>
			</div>
		</div>

</body>
</html>
	</body>
	</html>

