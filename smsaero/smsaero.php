<?php
include_once('SmsaeroApiV2.class.php');

header("Content-Type: text/html; charset=utf-8");
$tel = htmlspecialchars($_POST["tel"]);
$random_number = (string)( rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
$refferer = getenv('HTTP_REFERER');
$date=date("d.m.y"); // число.месяц.год  
$time=date("H:i"); // часы:минуты:секунды 
$myemail = "ulokin.s@y-stroika.ru"; // e-mail администратора


// Отправка письма администратору сайта

$tema = "Промокод";
$message_to_myemail = "Был отправлен новый промокод: Grand-$random_number<br>
Телефон клиента: $tel<br>

Источник (ссылка): $refferer
";


// use SmsaeroApiV2\SmsaeroApiV2;
$smsaero_api = new SmsaeroApiV2('info@y-stroika.ru', 'fck09A884PErKIqWo8SoOgojNVr', 'grand-line'); // api_key из личного кабинета
// $smsaero_api->send([$tel], 'Спасибо за обращение, ваш промокод: Grand-' . $random_number, 'DIRECT'); 
// Отправка сообщений

mail($myemail, $tema, $message_to_myemail, "From: grandline-diler.ru <grandline-diler.ru> \r\n Reply-To: grandline-diler.ru \r\n"."MIME-Version: 1.0\r\n"."Content-type: text/html; charset=utf-8\r\n" ); //письмо администратору

// var_dump($smsaero_api->auth()); // Тестовый метод для проверки авторизации
// var_dump($smsaero_api->check_send(123456)); // Проверка статуса SMS сообщения
// var_dump($smsaero_api->sms_list(null,'тест',3)); //Получение списка отправленных sms сообщений
// var_dump($smsaero_api->balance()); // Запрос баланса

// var_dump($smsaero_api->cards()); // Получение списка платёжных карт
// var_dump($smsaero_api->addbalance(100, 12345)); // Пополнение баланса
// var_dump($smsaero_api->tariffs()); // Запрос тарифа
// var_dump($smsaero_api->sign_add('new sign')); // Добавление подписи
// var_dump($smsaero_api->sign_list()); // Получить список подписей
// var_dump($smsaero_api->group_add('new_group_name')); //Добавление группы
// var_dump($smsaero_api->group_list()); // Получение списка групп
// var_dump($smsaero_api->group_delete(123)); // Удаление группы
// var_dump($smsaero_api->contact_add('70000000000', null, null, 'male', 'name', 'surname', null, 'param example')); // Добавление контакта
// var_dump($smsaero_api->contact_delete(123)); // Удаление контакта
// var_dump($smsaero_api->contact_list()); // Список контактов
// var_dump($smsaero_api->blacklist_add(123)); // Добавление в чёрный список
// var_dump($smsaero_api->blacklist_delete(123)); // Удаление из чёрного списка
// var_dump($smsaero_api->blacklist_list()); // Список контактов в черном списке
// var_dump($smsaero_api->hlr_check('70000000000')); // Создание запроса на проверку HLR
// var_dump($smsaero_api->hlr_status(474664)); // Получение статуса HLR
// var_dump($smsaero_api->number_operator('79136535500')); // Определение оператора
// var_dump($smsaero_api->viber_send('70000000000', null, 'Bonus', 'INFO','Тестовое сообщение')); // Отправка Viber-рассылок
// var_dump($smsaero_api->viber_statistic(1636)); // Статистика по Viber-рассылке
// var_dump($smsaero_api->viber_list());  // Список Viber-рассылок
// var_dump($smsaero_api->viber_sign_list()); // Список доступных подписей для Viber-рассылок

?>