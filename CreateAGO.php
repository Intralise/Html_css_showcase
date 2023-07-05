<?php 
function GenerateCreateAGO($part)
{
    $content = "<h3>Создание заказа</h3>";
    if($part == 1){
        if(GetActiveCreatedAGO(get_current_user_id()) != 0){     
            $generateCreateForm = GenerateExistNotice();
        } else {
            $generateCreateForm = GenerateCreateForm();
        }
    }
    else {
        $content .= "<h5 class='AGOSuccess'>Ваш заказ, создан!</br> Вступите в него!</h5>";
        if(isset($_GET["invitecode"])){
            $content .="<p class='AGOCreInvCode'><strong>Инвайт код: </strong>";
            $content .= $_GET["invitecode"];
            $content .= '</p>';
        }
        $generateCreateForm = GenerateJoinForm(2);
    }
    
    $content .= "<div id='CreateTheOrder'>" . $generateCreateForm . "</div>";
    return json_encode($content, JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP);
}
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