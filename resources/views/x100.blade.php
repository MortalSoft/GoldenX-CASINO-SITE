@php
$setting = \App\Setting::first();
@endphp
<div style="margin-top: 35px;" class="x30 x100">
    <div class="x30__wheel d-flex justify-center flex-column align-center">
        <div class="x30__wheels d-flex justify-center align-end">
            <div class="x30__wheel-center d-flex justify-center align-start">
                <div class="wheel__x100-bonus-x bonusBlock" style="display: none;">
                    <div class="wheel__x100-bonus-bg"></div>
                    <div class="wheel__x100-bonus d-flex justify-end align-center">
                        <div class="wheel__x100-bonus-content">
                            <div class="wheel__x100-bonus-slider">
                                <div class="wheel__x100-bonus-cursor"></div>
                                <div class="wheel__x100-bonus-scroll d-flex align-center">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="x30__timer TimerBlock d-flex flex-column justify-center align-center" >
                    <b id="x100__text">Начало через</b>
                    <span id="x100__timer">30</span>
                </div>
            </div>
            <div class="x30__wheel-image">
                <img src="images/games/x100/wheel.svg" id="x100__wheel" style="transition: all 30s ease 0s;">
            </div>
            <div class="x30__wheel-border"></div>
        </div>
        <div class="x30__cursor"></div>
    </div> 
    <div class="wrapper">
        <div class="x30__top">
            <a href="#" rel="popup" data-popup="popup--x100" class="help d-flex align-center">
                <svg class="icon"><use xlink:href="images/symbols.svg#faq"></use></svg>
                <span>Как играть?</span>
            </a>
            <div class="x30__rocket d-flex align-center" id="x100__status">
                @if($setting->theme == 0)
                    <img class="x30__rocket-img" src="images/rocket.png">
                @else
                    <img class="x30__rocket-img" src="images/snow/ded.png">
                @endif
                <div class="x30__rocket-coins"></div>
            </div>
        </div>
        <div class="x30__bottom">
            <div class="x30__bet d-flex align-center justify-space-between">
                <div class="x30__history">
                    <div class="bx-input__input d-flex align-center justify-space-between pd10-20">
                        <label class="d-flex align-center">История:</label>
                        <div class="x100__history-items">
                            <div class="x100__history-scroll d-flex align-center">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="x30__bet-game">
                    <div class="bx-input__input d-flex align-center justify-space-between flex-wrap pd10-20">
                        <div class="d-flex align-center justify-space-between">
                            
                                <input style="text-align: left;" placeholder="0.00" type="text" value="1.00" id="sumBetX100">
                                <svg class="icon money"><use xlink:href="images/symbols.svg#coins"></use></svg>
                            
                        </div>
                        <div class="x30__bet-placed d-flex align-center justify-space-between">
                            <a onclick="$('#sumBetX100').val(1)">Min</a>
                            <a onclick="$('#sumBetX100').val(Number($('#balance').attr('balance')))">Max</a>
                            <a onclick="$('#sumBetX100').val(Number($('#sumBetX100').val()) + 10)">+10</a>
                            <a onclick="$('#sumBetX100').val(Number($('#sumBetX100').val()) + 100)">+100</a>
                            <a onclick="$('#sumBetX100').val((Number($('#sumBetX100').val()) * 2).toFixed(2))">x2</a>
                            <a onclick="$('#sumBetX100').val(Math.max(($('#sumBetX100').val()/2), 1).toFixed(2));">1/2</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="x30__bets">
                <div class="x30__bet">
                    @auth
                    @if(\Auth::user()->admin == 1)
                    <div class="plusBlock" onclick="goX100('2')">Go</div>
                    @endif
                    @endauth
                    <div onclick="disable(this);betX100('2')" class="x30__bet-heading is-ripples flare x2 d-flex align-center justify-space-between">
                        <span>X2</span>
                    </div>
                    <div class="x30__bet-info d-flex align-center justify-space-between">
                        <span class="d-flex align-center" style="color: #9EABCD;">
                            <svg class="icon small" style="margin-right: 8px;"><use xlink:href="images/symbols.svg#users"></use></svg>
                            <span data-playersX100=2></span>
                       </span>
                        <span class="d-flex align-center" style="font-weight: 600;">
                            <span data-sumBetsX100=2></span>
                            <svg class="icon money" style="margin-left: 8px;"><use xlink:href="images/symbols.svg#coins"></use></svg>
                        </span>
                    </div>
                    <div class="x100__bet-users x2">

                    </div>
                </div>
                <div class="x30__bet">
                    @auth
                    @if(\Auth::user()->admin == 1)
                    <div class="plusBlock" onclick="goX100('3')">Go</div>
                    @endif
                    @endauth
                    <div onclick="disable(this);betX100('3')" class="x30__bet-heading is-ripples flare x3 d-flex align-center justify-space-between">
                        <span>X3</span>
                    </div>
                    <div class="x30__bet-info d-flex align-center justify-space-between">
                        <span class="d-flex align-center" style="color: #9EABCD;">
                            <svg class="icon small" style="margin-right: 8px;"><use xlink:href="images/symbols.svg#users"></use></svg>
                            <span data-playersX100=3></span>
                        </span>
                        <span class="d-flex align-center" style="font-weight: 600;">
                            <span data-sumBetsX100=3></span>
                            <svg class="icon money" style="margin-left: 8px;"><use xlink:href="images/symbols.svg#coins"></use></svg>
                        </span>
                    </div>
                    <div class="x100__bet-users x3">

                    </div>
                </div>
                <div class="x30__bet">
                    @auth
                    @if(\Auth::user()->admin == 1)
                    <div class="plusBlock" onclick="goX100('10')">Go</div>
                    @endif
                    @endauth
                    <div onclick="disable(this);betX100('10')" class="x30__bet-heading is-ripples flare x10 d-flex align-center justify-space-between">
                        <span>X10</span>
                    </div>
                    <div class="x30__bet-info d-flex align-center justify-space-between">
                        <span class="d-flex align-center" style="color: #9EABCD;">
                            <svg class="icon small" style="margin-right: 8px;"><use xlink:href="images/symbols.svg#users"></use></svg>
                            <span data-playersX100=10></span>
                        </span>
                        <span class="d-flex align-center" style="font-weight: 600;">
                            <span data-sumBetsX100=10></span>
                            <svg class="icon money" style="margin-left: 8px;"><use xlink:href="images/symbols.svg#coins"></use></svg>
                        </span>
                    </div>
                    <div class="x100__bet-users x10">

                    </div>
                </div>
                <div class="x30__bet">
                    @auth
                    @if(\Auth::user()->admin == 1)
                    <div class="plusBlock" onclick="goX100('15')">Go</div>
                    @endif
                    @endauth
                    <div onclick="disable(this);betX100('15')" class="x30__bet-heading is-ripples flare x15 d-flex align-center justify-space-between">
                        <span>X15</span>
                    </div>
                    <div class="x30__bet-info d-flex align-center justify-space-between">
                        <span class="d-flex align-center" style="color: #9EABCD;">
                            <svg class="icon small" style="margin-right: 8px;"><use xlink:href="images/symbols.svg#users"></use></svg>
                            <span data-playersX100=15></span>
                        </span>
                        <span class="d-flex align-center" style="font-weight: 600;">
                            <span data-sumBetsX100=15></span>
                            <svg class="icon money" style="margin-left: 8px;"><use xlink:href="images/symbols.svg#coins"></use></svg>
                        </span>
                    </div>
                    <div class="x100__bet-users x15">

                    </div>
                </div>
                <div class="x30__bet">
                    @auth
                    @if(\Auth::user()->admin == 1)
                    <div class="plusBlock" onclick="goX100('20')">Go</div>
                    @endif
                    @endauth
                    <div onclick="disable(this);betX100('20')" class="x30__bet-heading is-ripples flare x20 d-flex align-center justify-space-between">
                        <span>X20</span>
                    </div>
                    <div class="x30__bet-info d-flex align-center justify-space-between">
                        <span class="d-flex align-center" style="color: #9EABCD;">
                            <svg class="icon small" style="margin-right: 8px;"><use xlink:href="images/symbols.svg#users"></use></svg>
                            <span data-playersX100=20></span>
                        </span>
                        <span class="d-flex align-center" style="font-weight: 600;">
                            <span data-sumBetsX100=20></span>
                            <svg class="icon money" style="margin-left: 8px;"><use xlink:href="images/symbols.svg#coins"></use></svg>
                        </span>
                    </div>
                    <div class="x100__bet-users x20">

                    </div>
                </div>
                <div class="x30__bet">
                    @auth
                    @if(\Auth::user()->admin == 1)
                    <div class="plusBlock" onclick="goX100('100')">Go</div>
                    @endif
                    @endauth
                    <div onclick="disable(this);betX100('100')" class="x30__bet-heading is-ripples flare x100 d-flex align-center justify-space-between">
                        <span>X100</span>
                    </div>
                    <div class="x30__bet-info d-flex align-center justify-space-between">
                        <span class="d-flex align-center" style="color: #9EABCD;">
                            <svg class="icon small" style="margin-right: 8px;"><use xlink:href="images/symbols.svg#users"></use></svg>
                            <span data-playersX100=100></span>
                        </span>
                        <span class="d-flex align-center" style="font-weight: 600;">
                            <span data-sumBetsX100=100></span>
                            <svg class="icon money" style="margin-left: 8px;"><use xlink:href="images/symbols.svg#coins"></use></svg>
                        </span>
                    </div>
                    <div class="x100__bet-users x100">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@auth
@if(\Auth::user()->admin == 1)
<script type="text/javascript">
    function goX100(coff) {
        param = {
            _token:csrf_token,
            coff: coff
        }

        $.post('/x100/go',param).then(e=>{
            if(e.success){
                notification('success',e.mess)
            }
            if(e.error){      
                notification('error',e.error)
            }
        })
    }
    function getX100Bonus(user_id, avatar){
        param = {
            _token:csrf_token,
            user_id, avatar
        }

        $.post('/x100/bonusgo',param).then(e=>{
            if(e.success){
                notification('success',e.mess)
            }
            if(e.error){      
                notification('error',e.error)
            }
        })
    }
</script>
@endif
@endauth

<script type="text/javascript">
    socket.emit('X100_CONNECT')
    function getX100(){
        $.post('/x100/get',{_token: csrf_token}).then(e=>{
            if(e.success){
                e.success.forEach((e)=>{
                    e = e
                    class_dop = ''
                    if(e.user_id == USER_ID){
                        class_dop = 'img_no_blur'
                    }

                    dopText = ''
                    @auth
                    @if(\Auth::user()->admin == 1)
                    dopText = '<div class="dopPlusBetX100" onclick="getX100Bonus('+e.user_id+', `'+e.img+'`)">Bonus</div>'
                    @endif
                    @endauth

                    $('.x100 .x100__bet-users.x'+e.coff).prepend('<div data-user-id='+e.user_id+' class="x30__bet-user d-flex align-center justify-space-between">'+dopText+'\
                        <div class="history__user d-flex align-center justify-center">\
                        <div class="history__user-avatar '+class_dop+'" style="background: url('+e.img+') no-repeat center center / cover;"></div>\
                        <span>'+e.login+'</span>\
                        </div>\
                        <div class="x30__bet-sum d-flex align-center">\
                        <span>'+(Number(e.bet).toFixed(2))+'</span>\
                        <svg class="icon money" style="margin-left: 8px;"><use xlink:href="images/symbols.svg#coins"></use></svg>\
                        </div>\
                        </div>')


                })

                e.info.forEach((e)=>{
                    $('span[data-sumBetsX100='+e.coff+']').html((e.sum).toFixed(0))
                    $('span[data-playersX100='+e.coff+']').html(e.players)
                })


            }
            updateHistoryX100(e.history)
        })
    }
    getX100()


</script>
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

@auth
<script type="text/javascript">
    socket.emit('subscribe', 'roomGame_1_{{\Auth::user()->id}}');
</script>
@endauth