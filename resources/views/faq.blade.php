<div class="wrapper">
    <div style="margin-top: 20px;" class="faq d-flex flex-column">
        <div class="faq__item">
            <div class="faq__item-heading d-flex align-center">
                <b class="faq__item-question d-flex align-center justify-center">?</b>
                <span>Что такое SO-YOU-START.RU?</span>
            </div>
            <div class="faq__item-body">
                <p>SO-YOU-START.RU — сервис мгновенных игр.</p>
            </div>
        </div>
        <div class="faq__item">
            <div class="faq__item-heading d-flex align-center">
                <b class="faq__item-question d-flex align-center justify-center">?</b>
                <span>Как устроена реферальная система?</span>
            </div>
            <div class="faq__item-body">
                <p>Вы получаете +10% от каждого пополнения реферала. <br>
                Если набрать определённое количество рефералов, то можно использовать бесплатную прокрутку колеса и получить бонус.</p>
            </div>
        </div>
        <div class="faq__item">
            <div class="faq__item-heading d-flex align-center">
                <b class="faq__item-question d-flex align-center justify-center">?</b>
                <span>Сколько по времени производится вывод?</span>
            </div>
            <div class="faq__item-body">
                <p>Процесс выплаты занимает от 1 минут до 24 часов с момента создания заявки.  <br>
                Иногда, он может задержаться до 2-х дней.</p>
            </div>
        </div>
        <div class="faq__item">
            <div class="faq__item-heading d-flex align-center">
                <b class="faq__item-question d-flex align-center justify-center">?</b>
                <span>Какая минимальная сумма вывода?</span>
            </div>
            <div class="faq__item-body">
                <p>Минимальная сумма вывода составляет 100Р.</p>
            </div>
        </div>
        <div class="faq__item">
            <div class="faq__item-heading d-flex align-center">
                <b class="faq__item-question d-flex align-center justify-center">?</b>
                <span>Мой вывод отклонён, что делать?</span>
            </div>
            <div class="faq__item-body">
                <p>Скорее всего вы неправильно ввели данные, либо нарушили наши правила.</p>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
   $('.faq__item .faq__item-heading').click(function(e){
    e.preventDefault();
    if($(this).parent().hasClass('faq__item--opened')) {
        $(this).parent().removeClass('faq__item--opened').css({'max-height':'60px'});
    } else {
        $('.faq__item.faq__item--opened').removeClass('faq__item--opened').css({'max-height':'60px'});
        $(this).parent().addClass('faq__item--opened').css({'max-height': $(this).parent()[0].scrollHeight});
    }
});
</script>