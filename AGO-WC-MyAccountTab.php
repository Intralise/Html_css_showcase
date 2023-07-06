<?php

require('PageGenerators/CreateAGO.php');

function GeneratePageContent($subtab_slug) //Предположим что $subtab_slug это значение, переданное с фронтенда
{
    //Вся эта функция - ответственность backend разработчиков, тут обрабатываются входящие данные
    $additionalContent = "Дополнительный контент $subtab_slug";

    switch ($subtab_slug) {
        
        case 'join':
            //Эти функции возвращают html код. Соответственно создание таких функций - ответственность frontend разработчиков
            $additionalContent = GenerateJoinAGO();
            break;
        case 'create':
            $additionalContent = GenerateCreateAGO(1);
            break;
        case 'created':
            $additionalContent = GenerateMineAGO();
            break;
    }

    //Небольшая вставка про отладку
    $var = 'test';
    LogTXT('Значение, которое мы хотим увидеть', $var);
    //либо можно отлаживать код таким образом "question 2" выведется в консоль
    echo("<script>console.log('php_array: ".json_encode('question 2')."');</script>");	

    //После того как функции вернули нам html код, мы должны его вывести на экран
    //Вывод происходит посредством ф-ции echo

    echo "<script>
    document.addEventListener('DOMContentLoaded', function() { //этот код выполнится в момент загрузки контента страницы
      var additionalContent = document.createElement('div');
      additionalContent.innerHTML = ' $additionalContent'; //а здесь мы обращаемся непосредственно к нашему html коду и вставляем его в созданный нами div
      }
    });
    </script>
    ";

}

//ещё один пример работы с html кодом 
function GenerateMainPage(){
    $content = "
    <div class='infosectionAll'>
        <div class='InfoSectionID'>
            <h4>Добро пожаловать в групповой заказ</h4>
        </div>
        <div class='InfoSectionPrice'>
            <h6>Если возникли трудности:
            <a style='text-decoration:underline'href='https://wa.me/79194112151?text=%D0%92%D0%BE%D0%B7%D0%BD%D0%B8%D0%BA%D0%BB%D0%B8%20%D1%82%D1%80%D1%83%D0%B4%D0%BD%D0%BE%D1%81%D1%82%D0%B8%20%D1%81%20AGO!'><strong>НАПИШИТЕ НАМ</strong></a>
            </h6>
            <i>Данный функционал еще дорабатывается и дополняется, могут возникать проблемы при использовании, в случае возникновения ошибок просим уведомить администрацию сайта по ссылке выше</i>
        </div>
        
    </div>
    
    ";
    return json_encode($content, JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP);
}

//Эта функция записывает ваши данные в txt файл, который находится в папке вашего плагина
function LogTXT($message, $data)
{
    file_put_contents(__DIR__ . '/log.txt', $message . PHP_EOL, FILE_APPEND);
	$log = date('Y-m-d H:i:s') . ' ' . json_encode($data);
	file_put_contents(__DIR__ . '/log.txt', $log . PHP_EOL, FILE_APPEND);
}


