 <div class="wrapper">

    <div class="newTimerBlock" style="display: none;">
        <img class="chat__promocode-img" src="images/snow/promocode.png" draggable="false">
        <div class="newTimerText">До нового года:</div>
        <div class="chat__promocode-timer NewYear d-flex align-center">
            <span class="chat__promocode-timer--span">0</span>
            <span class="chat__promocode-timer--span">0</span>
            <span>:</span>
            <span class="chat__promocode-timer--span">0</span>
            <span class="chat__promocode-timer--span">3</span>
            <span>:</span>
            <span class="chat__promocode-timer--span">0</span>
            <span class="chat__promocode-timer--span">3</span>
        </div>

        
    </div>

    <script type="text/javascript">
        function newYearIn()
        {

            var now = new Date();
            var newYear = new Date("Jan,01,2022,00:00:00");
            var totalRemains = (newYear.getTime()-now.getTime());
            if (totalRemains>1)
            {
                var RemainsSec=(parseInt(totalRemains/1000));
                var RemainsFullDays=(parseInt(RemainsSec/(24*60*60)));

                var secInLastDay=RemainsSec-RemainsFullDays*24*3600;
                var RemainsFullHours=(parseInt(secInLastDay/3600));
                if (RemainsFullHours<10){RemainsFullHours="0"+RemainsFullHours};
                var secInLastHour=secInLastDay-RemainsFullHours*3600;
                var RemainsMinutes=(parseInt(secInLastHour/60));
                if (RemainsMinutes<10){RemainsMinutes="0"+RemainsMinutes};
                var lastSec=secInLastHour-RemainsMinutes*60;
                if (lastSec<10){lastSec="0"+lastSec};


                RemainsFullHours = String(RemainsFullHours)
                RemainsMinutes = String(RemainsMinutes)
                lastSec = String(lastSec)

                $('.NewYear .chat__promocode-timer--span:nth-child(1)').html(RemainsFullHours[0])
                $('.NewYear .chat__promocode-timer--span:nth-child(2)').html(RemainsFullHours[1])
                $('.NewYear .chat__promocode-timer--span:nth-child(4)').html(RemainsMinutes[0])
                $('.NewYear .chat__promocode-timer--span:nth-child(5)').html(RemainsMinutes[1])
                $('.NewYear .chat__promocode-timer--span:nth-child(7)').html(lastSec[0])
                $('.NewYear .chat__promocode-timer--span:nth-child(8)').html(lastSec[1])

                setTimeout("newYearIn()",1000);
            } 
            else {
                $('.newTimerBlock').hide();
            }
        }


    // newYearIn()
    
</script>


<div style="margin-top: 20px;" class="tournier">
    <a onclick="load('tourniers')" class="tournier__link d-flex align-center justify-space-between">
        <div class="d-flex align-center">
            <svg class="icon"><use xlink:href="images/symbols.svg?v=6#tournier"></use></svg>
            <b>Турниры</b>
        </div>
        <span>Перейти к турнирам</span>
    </a>
</div>

<div class="games">

    <a href="slots" class="games__item games__item--slots flare d-flex align-end">
        <div class="games__item-text d-flex flex-column">
            <span>SLOTS</span>
            <p>? человек</p>
        </div>
    </a>
    <a href="shoot" class="games__item games__item--shoot flare d-flex align-end">
        <div class="games__item-text d-flex flex-column">
            <span>Crazy <br> Shoot</span>
            <p>? человек</p>
        </div>
    </a>


    <a  onclick="load('x100')" class="games__item games__item--x100 flare d-flex align-end">
        <div class="games__item-text d-flex flex-column">
            <span>X100</span>
            <p>? человек</p>
        </div>
    </a>

    <a  onclick="load('x30')" class="games__item games__item--x30 flare d-flex align-end">
        <div class="games__item-text d-flex flex-column">
            <span>X30</span>
            <p>? человек</p>
        </div>
    </a>



    <a  onclick="load('dice')" class="games__item games__item--dice flare d-flex align-end">
        <div class="games__item-text d-flex flex-column">
            <span>Dice</span>
            <p>? человек</p>
        </div>
    </a>


    <a onclick="load('mines')" class="games__item games__item--mines  flare d-flex align-end">
        <div class="games__item-text d-flex flex-column">
            <span>Mines</span>
            <p>? человек</p>
        </div>
    </a>





    <a href="crash" class="games__item  games__item--crash flare d-flex align-end">

        <div class="games__item-text d-flex flex-column">
            <span>Crash</span>
            <p>? человека</p>
        </div>
    </a>

    <a onclick="load('coinflip')" class="games__item games__item--coin flare d-flex align-end">

        <div class="games__item-text d-flex flex-column">
            <span>Coin Flip</span>
            <p>? человека</p>
        </div>
    </a>
    <a onclick="load('keno')" class="games__item games__item--keno flare d-flex align-end">

        <div class="games__item-text d-flex flex-column">
            <span>Keno</span>
            <p>? человека</p>
        </div>
    </a>

    <a onclick="load('boomcity')" class="games__item games__item--soon games__item--boomcity flare d-flex align-end">
        <div class="games__item-soon">
            <span>Soon</span>
        </div>
        <div class="games__item-text d-flex flex-column">
            <span>Boom <br> City</span>
            <p>? человек</p>
        </div>
        <div class="games__item-bg--dice-3"></div>
        <div class="games__item-bg--dice-2"></div>
        <div class="games__item-bg-confetti"></div>
        <div class="games__item-bg-ellipse"></div>
    </a> 

</div>
</div>
<div class="wrapper">
    @include('layouts.history')
</div>

<script type="text/javascript">

    $('.close').click(function(e) {
        setTimeout(() => {
            $('.overlayed, .popup, body').removeClass('active');
        }, 100)
        $('.overlayed').addClass('animation-closed')
        return false;
    });
    $('.overlayed').click(function(e) {
        var target = e.target || e.srcElement;
        if(!target.className.search('overlay')) {
            setTimeout(() => {
                $('.overlayed, .popup, body').removeClass('active');
            }, 100)
            $('.overlayed').addClass('animation-closed')
        } 
    }); 
    $('[rel=popup]').click(function(e) {
        showPopup($(this).attr('data-popup'));
        return false;
    });

    function showPopup(el) {
        if($('.popup').is('.active')) {
            $('.popup').removeClass('active');  
        }
        $('.overlayed, body, .popup.'+el).addClass('active');
        $('.overlayed').removeClass('animation-closed');
    }
</script>