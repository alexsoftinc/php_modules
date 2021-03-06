Сегодня при разработке одного проекта, необходимо было генерировать уникальный буквенный код. Для реализации этой задачи было принято решение брать текущее время в миллисекундах и переводить их в буквенный код. Для этого я использовал следующую функцию:

<b>Результат этой функции будет напоминать нумерацию колонок в Microsoft Excel, т. е. A-Z, AA-ZZ, AAA-ZZZ и т. д. Например:</b>
<hr>
<code>
echo num2alpha(0); // Выведет «A»
echo num2alpha(10); // Выведет «K»
echo num2alpha(100); // Выведет «CW»
</code>

А если в качестве аргумента использовать функцию time(), которая возвращает количество секунд, прошедших с начала Эпохи Unix (1 января 1970, 00:00:00 GMT) до текущего времени, то можно получить уникальный буквенный код:
<code>
$time = time(); // 1313755781
echo num2alpha($time); // Выведет DFNWCRN
</code>
<hr>
<b>Для обратного декодирования строки нужно использовать эту функцию:</b>
<code>
  function alpha2num($a) {
    $r = 0;
    $l = strlen($a);
    for ($i = 0; $i < $l; $i++) {
        $r += pow(26, $i) * (ord($a[$l - $i - 1]) - 0x40);
    }
    return $r - 1;
}
  </code>
