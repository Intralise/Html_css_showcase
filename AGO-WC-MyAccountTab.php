<?php

require('Helpers/AGO-Helpers.php');
require('PageGenerators/MyAGO.php');
require('PageGenerators/JoinAGO.php');
require('PageGenerators/CreateAGO.php');
require('PageGenerators/EditAGO.php');
require('PageGenerators/WatchAGO.php');
require('PageGenerators/MineAGO.php');

use AGO_Order;
use AGO_User;


// Регистрация кастомной страницы "group-order"
function register_group_order_page()
{
    add_rewrite_endpoint('group-order', EP_ROOT | EP_PAGES);
}
add_action('init', 'register_group_order_page');

// Добавление кастомной вкладки в MyAccount
function add_custom_tab_to_myaccount($menu_items)
{
    // Проверяем, что пользователь авторизован и его ID равен 5
    if (is_user_logged_in() ) { //&& (get_current_user_id() === 5 || get_current_user_id() === 1 || get_current_user_id() === 1264)
        $tab_title = 'Групповой заказ (ГЗ)';
        $tab_slug = 'group-order';

        // Переносим ссылку на вкладку во вторую позицию в меню MyAccount
        $new_menu_items = array();
        $count = 0;
        foreach ($menu_items as $key => $value) {
            $new_menu_items[$key] = $value;
            $count++;
            if ($count === 1) {
                $new_menu_items[$tab_slug] = $tab_title;
            }
        }

        return $new_menu_items;
    }

    return $menu_items;
}
add_filter('woocommerce_account_menu_items', 'add_custom_tab_to_myaccount');

// Функция для вывода содержимого вкладки "Групповой заказ"
function group_order_content()
{
    // HTML-разметка для подвкладок
    $subtabs = array(
        'my_orders' => array(
            'title' => 'Мои заказы',
            'content' => '<p>Содержимое подвкладки "Мои групповые заказы".</p>',
        ),
        'create' => array(
            'title' => 'Создать ГЗ',
            'content' => '<p>Содержимое подвкладки "Создать групповой заказ".</p>',
        ),
        'created' => array(
            'title' => 'Созданный ГЗ',
            'content' => '<p>Содержимое подвкладки "Созданный групповой заказ".</p>',
        ),
        'join' => array(
            'title' => 'Присоединиться',
            'content' => '<p>Содержимое подвкладки "Вступить в групповой заказ".</p>',
        ),
    );

    // Получаем значение параметра 'tab' из URL
    $active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : '';
    if(!isset($_GET['tab'])){
        echo '<div class="group-order-content">' . GeneratePageContent('main') . '</div>';
    }

    // Вывод содержимого вкладки "Групповой заказ"

    echo '<ul class="ago-My-Account-Tabs" >';

    // Генерация HTML-разметки для подвкладок
    foreach ($subtabs as $subtab_slug => $subtab) {
        $subtab_title = $subtab['title'];
        $subtab_content = $subtab['content'];

        $active_class = ($active_tab === $subtab_slug) ? 'is-active' : '';
        echo '<li  class="ago-My-Account-TabElem woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--' . $subtab_slug . ' ' . $active_class . '">';
        echo '<a href="' . wc_get_account_endpoint_url('group-order') . '?tab=' . $subtab_slug . '">' . $subtab_title . '</a>';
        echo '</li>';

        // Вывод содержимого подвкладки, если текущая подвкладка активна
        if ($active_class === 'is-active') {
            echo '<div class="group-order-content">' . GeneratePageContent($subtab_slug) . '</div>';
            
        } 
    }

    echo '</ul>';

}
add_action('woocommerce_account_group-order_endpoint', 'group_order_content');

function GeneratePageContent($subtab_slug)
{
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