<?php
$ip = $_SERVER['REMOTE_ADDR'];

// $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
// //Массив данных для вставки в БД при логировании входа в систему администратора -(панель управления)
// $data = array();

// $data['details'] = '';
// $data['details'] .= 'Страна пользователя      - '.$details->country.'<br/>';
// $data['details'] .= 'Регион пользователя      - '.$details->region.'<br/>';
// $data['details'] .= 'Город пользователя       - '.$details->city.'<br/>'; // -> "Mountain View"
// $data['details'] .= 'Провайдер пользователя   - '.$details->hostname.'<br/>';
// $data['details'] .= 'Откуда пользователь      - '.$details->loc.' + нужно гугл мап если надо<br/>';
// $data['details'] .= 'Организация пользователя - '.$details->org.'<br/>';

// print_r($data['details']);

# Новый сайт тут расположен 
// include_once 'siteblock/header.php';
// include_once 'siteblock/top_menu.php';
include_once 'counter.php';
echo 'Home Page';

include_once 'show_stats.php';
