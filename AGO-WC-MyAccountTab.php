<?php

require('PageGenerators/CreateAGO.php');

function GeneratePageContent($subtab_slug) //Предположим что $subtab_slug это значение, переданное с фронтенда
{
    //Вся эта функция - ответственность backend разработчиков, тут обрабатываются входящие данные
    $additionalContent = "Дополнительный контент $subtab_slug";

    switch ($subtab_slug) {
        case 'my_orders':
            $additionalContent = GenerateMyOrders();
            if (isset($_GET["edit"]) && isset($_GET["orderid"])) {
                $additionalContent = GenerateEditAGO($_GET["orderid"]);
            }
            if (isset($_GET["watch"]) && isset($_GET["orderid"])) {
                $additionalContent = GenerateWatchAGO($_GET["orderid"]);
            }
            break;
        case 'join':
            $additionalContent = GenerateJoinAGO();
            break;
        case 'create':
            $additionalContent = GenerateCreateAGO(1);
            if (isset($_GET["part2"])) {
                $additionalContent = GenerateCreateAGO(2);
            }
            break;
        case 'created':
            $additionalContent = GenerateMineAGO();
            break;
        case 'main': 
            $additionalContent = GenerateMainPage();
            break;
    }

    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
      var additionalContent = document.createElement('div');
      additionalContent.innerHTML = ' $additionalContent';
      additionalContent.classList.add('woocommerce-MyAccount-content');
      additionalContent.classList.add('ago-style-content-zone');
      var targetElement = document.querySelector('.woocommerce-MyAccount-content');
      if (targetElement) {
        targetElement.parentNode.insertBefore(additionalContent, targetElement.nextSibling);
      }
    });
    </script>
    ";

}

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
