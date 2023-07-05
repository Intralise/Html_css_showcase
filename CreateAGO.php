<?php 
function GenerateCreateAGO($part)
{
    //Здесь мы формируем html код и записываем его в переменную $content
    $content = "<h3>Создание заказа</h3>";
    if($part == 1){
            $generateCreateForm = GenerateCreateForm();
    }
    
    $content .= "<div id='CreateTheOrder'>" . $generateCreateForm . "</div>";
    return json_encode($content, JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP);
}

//А этот метод - ответственность frontend разработчиков. Здесь идёт разработка исключительно html кода
function GenerateCreateForm() {
    $form = "
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js'></script>

    <form class='AGOCreateForm'>

    <div>
    <label for='inviteCode'>Укажите дату окончания формирования заказа*:</label>
    <input type='date' id='EndDate' name='inviteCode' required=''>

    <label for='inviteCode'>Укажите список разрешенных пользователей</label>
    <textarea title='ID пользователя через запятую' type='textarea' id='allowedUsers' name='inviteCode' required='' placeholder='11223344, 55667788, 9876567'></textarea>
    </div>

    <div>
    <label for='inviteCode'>Укажите общую минимальную сумму заказа:</label>
    <input type='text' id='totalMinimumAmount' name='inviteCode' required=''>

    <label for='inviteCode'>Укажите минимальную сумму для каждого участника:</label>
    <input type='text' id='userMinimumAmount' name='inviteCode' required=''>
    </div>
    <div>
    <input type='button' id='create-submit-btn' value='Создать'>
    </div>
    </form> ";
    return $form;
}

function GenerateExistNotice(){
    $notice = "
    <div class='AGONotice'><h5> У вас уже есть активный заказ, прежде чем создавать новый, завершите текущий</h5></div>
    ";
    return $notice;
}
