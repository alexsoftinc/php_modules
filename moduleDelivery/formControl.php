<?php 
// этот массив можно удобно распичатать если надо 
// echo '<pre>',print_r($_POST,1),'</pre>'; 

include_once 'class/DeliveryCdekAPI.php';
// Запуск методов самого АПИ и отработка на исключения заодно ) 
try {

	//создаём экземпляр объекта CalculatePriceDeliveryCdek
	$calc = new CalculatePriceDeliveryCdek();
	
	//Авторизация. Для получения логина/пароля (в т.ч. тестового) обратитесь к разработчикам СДЭК -->
	//$calc->setAuth('authLoginString', 'passwordString');
	
	//устанавливаем город-отправитель
	$calc->setSenderCityId($_REQUEST['senderCityId']);
	//устанавливаем город-получатель
	$calc->setReceiverCityId($_REQUEST['receiverCityId']);
	//устанавливаем дату планируемой отправки
	$calc->setDateExecute($_REQUEST['dateExecute']);
	
	//устанавливаем тариф по-умолчанию
	$calc->setTariffId('62');
	//задаём список тарифов с приоритетами
    // $calc->addTariffPriority($_REQUEST['tariffList1']);
    // $calc->addTariffPriority($_REQUEST['tariffList2']);
	
	
	//устанавливаем режим доставки
	$calc->setModeDeliveryId($_REQUEST['modeId']);
	//добавляем места в отправление
	$calc->addGoodsItemBySize($_REQUEST['weight1'], $_REQUEST['length1'], $_REQUEST['width1'], $_REQUEST['height1']);
	$calc->addGoodsItemByVolume($_REQUEST['weight2'], $_REQUEST['volume2']);
	
	if ($calc->calculate() === true) {
		$res = $calc->getResult();

		include_once 'good_page.php';

		echo 'Цена доставки: ' . $res['result']['price'] . 'руб.<br />';
		echo 'Срок доставки: ' . $res['result']['deliveryPeriodMin'] . '-' . 
								 $res['result']['deliveryPeriodMax'] . ' дн.<br />';
		echo 'Планируемая дата доставки: c ' . $res['result']['deliveryDateMin'] . ' по ' . $res['result']['deliveryDateMax'] . '.<br />';
		echo 'Выбран тариф - <small>Магистральный экспресс склад-склад </small> .<br />';

        if(array_key_exists('cashOnDelivery', $res['result'])) {
            echo 'Ограничение оплаты наличными, от (руб): ' . $res['result']['cashOnDelivery'] . '.<br />';
        }

        include_once 'good_footer.php';
	} else {
		$err = $calc->getError();

		if( isset($err['error']) && !empty($err) ) {
			//var_dump($err);
			include_once 'error_page.php';

			foreach($err['error'] as $e) {
				echo '<p>Текст возникшей ошибки: ' . $e['text'] . '.</p><br />';
			}
			include_once 'footer_error.php';
		}
	}
   
     // var_dump($calc->getResult());
     // var_dump($calc->getError());

} catch (Exception $e) {
	include_once 'error_page.php';
    	echo '<p>Возникла ошибка: ' . $e->getMessage() . "</p><br />";
    include_once 'footer_error.php';
}