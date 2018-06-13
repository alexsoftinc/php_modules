Use the script in view (template)

<?php echo pagination($total,$per_page,$num_page,$start_row,'/categories.php');?>

Inctruction how the create in own site >:

Давайте посмотрим пример SQL-запроса

1
SELECT * FROM table LIMIT 0,10
Данный запрос вернет 10 строк, начиная с нулевой.

От теории к практике

Для работы нашей функции необходимо создать 2 переменные:

$per_page - Максимальное число сообщений на одной странице
$num_page - Число ссылок в навигации от активной ссылки
1
$per_page = 10;
2
$num_page = 2;
Далее договоримся, что номер записи будет передаваться через - $_GET['p'].

Ссылка в адресной строке будет выглядеть так:

1
http://example.com/categories.php?p=10
Тогда номер строки с которой начать выборку можно получить так:

1
$start_row = (!empty($_GET['p']))? intval($_GET['p']): 0;
Теперь необходимо получть общее число строк в базе данных. Для этого выполним следущий запрос:

1
mysql_query('SELECT COUNT(*) AS numrows FROM table');
где,table — это название таблицы с контентом

Так как номер строки с которой будет начинаться выборка не может быть меньше нуля и больше максимального количества записей, поэтому необходимо сделать проверку:

1
if($start_row < 0) $start_row = 0;
2
if($start_row > $total) $start_row = $total;
Теперь для получения нужных записей на странице необходимо выполнить следующий SQL-запрос:

1
$result = mysql_query('SELECT * FROM table LIMIT $start_row.','.$per_page');
2
 
3
$items = array();
4
while($row = mysql_fetch_assoc($result)){
5
    $items[] = $row;
6
}
Теперь массив $items будет содержать результаты выборки.

Что же, осталось написать функцию, которая будет формировать ссылки на страницы.

Давайте создадим функцию, которая содержать 5 параметров:

1
function pagination($total,$per_page,$num_links,$start_row,$url=''){}
1. $total — общее число строк в базе данных
2. $per_page — количество элементов на странице
3. $num_links — чило ссылок от активной страницы
4. $start_row — номер строки с которой началась выборка из базы
5. $url — URL-адрес, который будет подставляться в ссылки

Первое что необходимо сделать это посчитать количество страниц, которое будет в пейджинге:

1
//Получаем общее число страниц
2
$num_pages = ceil($total/$per_page);
3
 
4
// Если страница одна, то ничего не выводим
5
if ($num_pages == 1) return '';
Получаем номер текущей страницы с учетом количества элементов на странице:

01
$cur_page = $start_row;
02
 
03
//Если количество элементов на страницы больше чем общее число элементов
04
// то текущая страница будет равна последней
05
if ($cur_page > $total){
06
   $cur_page = ($num_pages - 1) * $per_page;
07
}
08
 
09
//Получаем номер текущей страницы
10
$cur_page = floor(($cur_page/$per_page) + 1);
Получаем номер стартовой страницы выводимой в пейджинге:

1
$start = (($cur_page - $num_links) > 0) ? $cur_page - $num_links : 0;
Получаем номер последней страницы выводимой в пейджинге:

1
$end = (($cur_page + $num_links) < $num_pages) ? $cur_page + $num_links : $num_pages;
Теперь перходим к разметки и формируем ссылку на предыдущую страницу:

01
    if  ($cur_page != 1){
02
        $i = $start_row - $per_page;
03
        if ($i <= 0) $i = 0;
04
        $output .= '<i>←</i><a href="'.$url.'?p='.$i.'">Предыдущая</a>';
05
    }
06
    else{
07
        $output .='<span><i>←</i>Предыдущая</span>';
08
    }
09
     
10
    $output .= '<span class="divider">|</span>';
Формируем ссылку на следующую страницу:

1
if ($cur_page < $num_pages){
2
   $output .= '<a href="'.$url.'?p='.($cur_page * $per_page).'">Следующая</a><i>→</i>';
3
}
4
else{
5
    $output .= '<span>Следующая<i>→</i></span>';
6
}
7
 
8
$output .= '</span><br/>';
Формируем ссылку на первую страницу:

1
if($cur_page > ($num_links + 1)){
2
   $output .= '<a href="'.$url.'" title="Первая"><img src="images/left_active.png"></a>';
3
}
Формируем список страниц с учетом стартовой и последней страницы:

01
for ($loop = $start; $loop <= $end; $loop++){
02
    $i = ($loop * $per_page) - $per_page;
03
 
04
   if ($i >= 0){
05
       if ($cur_page == $loop){
06
           $output .= '<span>'.$loop.'</span>'; // Текущая страница
07
       }
08
       else{
09
           $n = ($i == 0) ? '' : $i;
10
           $output .= '<a href="'.$url.'?p='.$n.'">'.$loop.'</a>';
11
       }
12
   }
13
}
Формируем ссылку на последнюю страницу:

1
if (($cur_page + $num_links) < $num_pages){
2
    $i = (($num_pages * $per_page) - $per_page);
3
    $output .= '<a href="'.$url.'?p='.$i.'" title="Последняя"><img src="images/right_active.png"></a>';
4
}
Возвращаем полученный код:

1
return '<div class="wrapPaging"><strong>Страницы:</strong>'.$output.'</div>';
Вот полный код функции для организации пагинации:

01
function pagination($total, $per_page, $num_links, $start_row, $url=''){
02
    //Получаем общее число страниц
03
    $num_pages = ceil($total/$per_page);
04
 
05
    if ($num_pages == 1) return '';
06
 
07
    //Получаем количество элементов на страницы
08
    $cur_page = $start_row;
09
 
10
    //Если количество элементов на страницы больше чем общее число элементов
11
    // то текущая страница будет равна последней
12
    if ($cur_page > $total){
13
        $cur_page = ($num_pages - 1) * $per_page;
14
    }
15
 
16
    //Получаем номер текущей страницы
17
    $cur_page = floor(($cur_page/$per_page) + 1);
18
 
19
    //Получаем номер стартовой страницы выводимой в пейджинге
20
    $start = (($cur_page - $num_links) > 0) ? $cur_page - $num_links : 0;
21
    //Получаем номер последней страницы выводимой в пейджинге
22
    $end   = (($cur_page + $num_links) < $num_pages) ? $cur_page + $num_links : $num_pages;
23
 
24
    $output = '<span class="ways">';
25
 
26
    //Формируем ссылку на предыдущую страницу
27
    if  ($cur_page != 1){
28
        $i = $start_row - $per_page;
29
        if ($i <= 0) $i = 0;
30
        $output .= '<i>←</i><a href="'.$url.'?p='.$i.'">Предыдущая</a>';
31
    }
32
    else{
33
        $output .='<span><i>←</i>Предыдущая</span>';
34
    }
35
     
36
    $output .= '<span class="divider">|</span>';
37
 
38
    //Формируем ссылку на следующую страницу
39
    if ($cur_page < $num_pages){>
40
        $output .= '<a href="'.$url.'?p='.($cur_page * $per_page).'">Следующая</a><i>→</i>';
41
    }
42
    else{
43
        $output .='<span>Следующая<i>→</i></span>';
44
    }
45
 
46
    $output .= '</span><br/>';
47
 
48
    //Формируем ссылку на первую страницу
49
    if  ($cur_page > ($num_links + 1)){
50
        $output .= '<a href="'.$url.'" title="Первая"><img src="images/left_active.png"></a>';
51
    }
52
 
53
    // Формируем список страниц с учетом стартовой и последней страницы   >
54
        for ($loop = $start; $loop <= $end; $loop++){
55
        $i = ($loop * $per_page) - $per_page;
56
 
57
        if ($i >= 0)
58
        {
59
            if ($cur_page == $loop)
60
            {
61
               //Текущая страница
62
               $output .= '<span>'.$loop.'</span>';
63
            }
64
            else
65
            {
66
 
67
               $n = ($i == 0) ? '' : $i;
68
 
69
               $output .= '<a href="'.$url.'?p='.$n.'">'.$loop.'</a>';
70
            }
71
        }
72
    }
73
 
74
    //Формируем ссылку на последнюю страницу
75
    if (($cur_page + $num_links) < $num_pages){
76
        $i = (($num_pages * $per_page) - $per_page);
77
        $output .= '<a href="'.$url.'?p='.$i.'" title="Последняя"><img src="images/right_active.png"></a>';
78
    }
79
 
80
    return '<div class="wrapPaging"><strong>Страницы:</strong>'.$output.'</div>';
81
}
А вот стили:

view sourceprint?
01
div.wrapPaging {padding: 6px 0px 6px 16px; font-family: Arial, sans-serif; font-size: 14px; clear: both;}
02
div.wrapPaging a, div.wrapPaging span {margin: 0 1px; padding: 2px 5px; line-height: 26px; text-decoration: none;}
03
div.wrapPaging a {background: none; color: #025A9C !important; text-decoration: underline; font-size: 14px;}
04
div.wrapPaging span {background: #E8E9EC; color: #000;}
05
div.wrapPaging span.ways {background: none; font-size: 15px; color: #999;}
06
div.wrapPaging span.ways span {background: none; color: #999;}
07
div.wrapPaging span.ways a {font-size: 15px;}
08
div.wrapPaging span.divider {color: #999;}
09
div.wrapPaging i {font-family: Times, sans-serif; margin: 0 5px 0 0;}
10
div.wrapPaging a:hover {color: #ff0000;}
11
div.wrapPaging strong {margin: 0 15px 0 0; font-size: 16px; font-weight: bold; color: #000;}
