@php
$setting = \App\Setting::first();
@endphp
<div style="margin-top: 35px;" class="x30">
    <div class="x30__wheel d-flex justify-center flex-column align-center">
        <div class="x30__wheels d-flex justify-center align-end">
            <div class="x30__wheel-center d-flex justify-center align-start">
                <div class="x30__bonus d-flex align-center" style="display: none;">
                    <div class="x30__bonus-cursor"></div>
                    <div class="x30__bonus-scroll d-flex align-center">
                        <div class="x30__bonus-item x2 d-flex align-center justify-center">x2</div>
                        <div class="x30__bonus-item x3 d-flex align-center justify-center">x3</div>
                        <div class="x30__bonus-item x5 d-flex align-center justify-center">x3</div>
                        <div class="x30__bonus-item x30 d-flex align-center justify-center">x3</div>
                        <div class="x30__bonus-item x2 d-flex align-center justify-center">x2</div>
                        <div class="x30__bonus-item x3 d-flex align-center justify-center">x3</div>
                        <div class="x30__bonus-item x5 d-flex align-center justify-center">x3</div>
                        <div class="x30__bonus-item x2 d-flex align-center justify-center">x2</div>
                        <div class="x30__bonus-item x3 d-flex align-center justify-center">x3</div>
                        <div class="x30__bonus-item x5 d-flex align-center justify-center">x3</div>
                    </div>
                </div>
                <div class="x30__timer d-flex flex-column justify-center align-center">
                    <b id="x30__text">Начало через</b>
                    <span id="x30__timer">30</span>
                </div>
            </div>
            <div class="x30__wheel-image">
                <img src="images/games/x30/wheel.svg?v=2" id="x30__wheel" style="transition: all 30s ease 0s; ">
            </div>
            <div class="x30__wheel-border"></div>
        </div>
        <div class="x30__cursor"></div>
    </div>
    <div class="wrapper">
        <div class="x30__top">
            <a href="#" rel="popup" data-popup="popup--x30" class="help d-flex align-center">
                <svg class="icon"><use xlink:href="images/symbols.svg#faq"></use></svg>
                <span>Как играть?</span>
            </a>
            <div class="x30__rocket d-flex align-center" id="x30__status">
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
                        <div class="x30__history-items">
                            <div class="x30__history-scroll d-flex align-center">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="x30__bet-game">
                    <div class="bx-input__input d-flex align-center justify-space-between flex-wrap pd10-20">
                        <div class="d-flex align-center justify-space-between">
                            
                                <input style="text-align: left;" type="text" id="wheel_input" placeholder="0.00" value="1.00">
                                <svg class="icon money"><use xlink:href="images/symbols.svg#coins"></use></svg>
                            
                        </div>
                        <div class="x30__bet-placed d-flex align-center justify-space-between">
                            <a onclick="$('#wheel_input').val(1)">Min</a>
                            <a onclick="$('#wheel_input').val(Number($('#balance').attr('balance')))">Max</a>
                            <a onclick="$('#wheel_input').val(Number($('#wheel_input').val()) + 10)">+10</a>
                            <a onclick="$('#wheel_input').val(Number($('#wheel_input').val()) + 100)">+100</a>
                            <a onclick="$('#wheel_input').val((Number($('#wheel_input').val()) * 2).toFixed(2))">x2</a>
                            <a onclick="$('#wheel_input').val(Math.max(($('#wheel_input').val()/2), 1).toFixed(2));">1/2</a>
                        </div>
                    </div>
                </div>
            </div>
            @auth
            @if(\Auth::user()->admin == 1)
            <div class="x30__bet-game" style="margin-bottom: 15px;">
                <div class="bx-input__input d-flex align-center justify-space-between flex-wrap">

                    <div class="d-flex align-center justify-space-between">
                        <div class="bet_block_wheel ">
                            <div class="w-100" >
                                <input type="" placeholder="Мультиплеер" id="mult_bonus" class="secodary_input" style="" name="">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-center justify-space-between">
                        <div class="bet_block_wheel ">
                            <div class="w-100" >
                                <select class="secodary_input" id="coeff_bonus" style="width: 100%;">

                                    <option value="0">Рандом</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="5">5</option>
                                    <option value="7">7</option>
                                    <option value="14">14</option>
                                    <option value="30">30</option>


                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-center justify-space-between">
                        <div class="bet_block_wheel ">
                            <div class="w-100" ><button class="btn is-ripples flare d-flex align-center has-ripple" onclick="goWheel('bonus')">Бонуска</button></div>
                        </div>

                    </div> 
                </div>
            </div>
            @endif
            @endauth
            <div class="x30__bets">
                <div class="x30__bet">
                    @auth
                    @if(\Auth::user()->admin == 1)
                    <div class="plusBlock" onclick="goWheel('2')">Go</div>
                    @endif
                    @endauth
                    <div onclick="disable(this);betWheel('2')" class="x30__bet-heading  is-ripples flare x2 d-flex align-center justify-space-between">
                        <span class="x30__bet-heading_x30">X2</span>
                        <img src="images/games/x2.svg">
                    </div>
                    <div class="x30__bet-info d-flex align-center justify-space-between">
                        <span class="d-flex align-center" style="color: #9EABCD;">
                            <svg class="icon small" style="margin-right: 8px;"><use xlink:href="images/symbols.svg#users"></use></svg>
                            <span data-players=2></span>
                        </span>
                        <span class="d-flex align-center" style="font-weight: 600;">
                            <span data-sumBets=2></span>
                            <svg class="icon money" style="margin-left: 8px;"><use xlink:href="images/symbols.svg#coins"></use></svg>
                        </span>
                    </div>
                    <div class="x30__bet-users x2">

                    </div>
                </div>
                <div class="x30__bet">
                    @auth
                    @if(\Auth::user()->admin == 1)
                    <div class="plusBlock" onclick="goWheel('3')">Go</div>
                    @endif
                    @endauth

                    <div onclick="disable(this);betWheel('3')" class="x30__bet-heading  is-ripples flare x3 d-flex align-center justify-space-between">
                        <span class="x30__bet-heading_x30">X3</span>
                        <img src="images/games/x3.svg">
                    </div>
                    <div class="x30__bet-info d-flex align-center justify-space-between">
                        <span class="d-flex align-center" style="color: #9EABCD;">
                            <svg class="icon small" style="margin-right: 8px;"><use xlink:href="images/symbols.svg#users"></use></svg>
                            <span data-players=3></span>
                        </span>
                        <span class="d-flex align-center" style="font-weight: 600;">
                            <span data-sumBets=3></span>
                            <svg class="icon money" style="margin-left: 8px;"><use xlink:href="images/symbols.svg#coins"></use></svg>
                        </span>
                    </div>
                    <div class="x30__bet-users x3">

                    </div>
                </div>
                <div class="x30__bet">
                    @auth
                    @if(\Auth::user()->admin == 1)
                    <div class="plusBlock" onclick="goWheel('5')">Go</div>
                    @endif
                    @endauth
                    <div onclick="disable(this);betWheel('5')" class="x30__bet-heading is-ripples flare x5 d-flex align-center justify-space-between">
                        <span class="x30__bet-heading_x30">X5</span>
                        <img src="images/games/x5.svg">
                    </div>
                    <div class="x30__bet-info d-flex align-center justify-space-between">
                        <span class="d-flex align-center" style="color: #9EABCD;">
                            <svg class="icon small" style="margin-right: 8px;"><use xlink:href="images/symbols.svg#users"></use></svg>
                            <span data-players=5></span>
                        </span>
                        <span class="d-flex align-center" style="font-weight: 600;">
                            <span data-sumBets=5></span>
                            <svg class="icon money" style="margin-left: 8px;"><use xlink:href="images/symbols.svg#coins"></use></svg>
                        </span>
                    </div>
                    <div class="x30__bet-users x5">

                    </div>
                </div>
                <div class="x30__bet">
                    @auth
                    @if(\Auth::user()->admin == 1)
                    <div class="plusBlock" onclick="goWheel('7')">Go</div>
                    @endif
                    @endauth
                    <div onclick="disable(this);betWheel('7')" class="x30__bet-heading is-ripples flare x7 d-flex align-center justify-space-between">
                        <span class="x30__bet-heading_x30">X7</span>
                        <img src="images/games/x7.svg">
                    </div>
                    <div class="x30__bet-info d-flex align-center justify-space-between">
                        <span class="d-flex align-center" style="color: #9EABCD;">
                            <svg class="icon small" style="margin-right: 8px;"><use xlink:href="images/symbols.svg#users"></use></svg>
                            <span data-players=7></span>
                        </span>
                        <span class="d-flex align-center" style="font-weight: 600;">
                            <span data-sumBets=7></span>
                            <svg class="icon money" style="margin-left: 8px;"><use xlink:href="images/symbols.svg#coins"></use></svg>
                        </span>
                    </div>
                    <div class="x30__bet-users x7">

                    </div>
                </div>
                <div class="x30__bet">
                    @auth
                    @if(\Auth::user()->admin == 1)
                    <div class="plusBlock" onclick="goWheel('14')">Go</div>
                    @endif
                    @endauth
                    <div onclick="disable(this);betWheel('14')" class="x30__bet-heading is-ripples flare x14 d-flex align-center justify-space-between">
                        <span class="x30__bet-heading_x30">X14</span>
                        <img src="images/games/x14.svg">
                    </div>
                    <div class="x30__bet-info d-flex align-center justify-space-between">
                        <span class="d-flex align-center" style="color: #9EABCD;">
                            <svg class="icon small" style="margin-right: 8px;"><use xlink:href="images/symbols.svg#users"></use></svg>
                            <span data-players=14></span>
                        </span>
                        <span class="d-flex align-center" style="font-weight: 600;">
                            <span data-sumBets=14></span>
                            <svg class="icon money" style="margin-left: 8px;"><use xlink:href="images/symbols.svg#coins"></use></svg>
                        </span>
                    </div>
                    <div class="x30__bet-users x14">

                    </div>
                </div>
                <div class="x30__bet">
                    @auth
                    @if(\Auth::user()->admin == 1)
                    <div class="plusBlock" onclick="goWheel('30')">Go</div>
                    @endif
                    @endauth
                    <div onclick="disable(this);betWheel('30')" class="x30__bet-heading is-ripples flare x30 d-flex align-center justify-space-between">
                        <span class="x30__bet-heading_x30">X30</span>
                        <img src="images/games/x30.svg">
                    </div>
                    <div class="x30__bet-info d-flex align-center justify-space-between">
                        <span class="d-flex align-center" style="color: #9EABCD;">
                            <svg class="icon small" style="margin-right: 8px;"><use xlink:href="images/symbols.svg#users"></use></svg>
                            <span data-players=30></span>
                        </span>
                        <span class="d-flex align-center" style="font-weight: 600;">
                            <span data-sumBets=30></span>
                            <svg class="icon money" style="margin-left: 8px;"><use xlink:href="images/symbols.svg#coins"></use></svg>
                        </span>
                    </div>
                    <div class="x30__bet-users x30">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@auth
@if(\Auth::user()->admin == 1)
<script type="text/javascript">
    function goWheel(coff) {
        if(coff == 'bonus'){
            param = {_token:csrf_token,
                coff: coff,
                coeff_bonus: $('#coeff_bonus').val(),
                mult_bonus: $('#mult_bonus').val()
            }
        }else{
            param = {_token:csrf_token,
                coff: coff
            }
        }
        $.post('/wheel/go',param).then(e=>{
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
    socket.emit('WHEEL_CONNECT')
    function getWheel(){
        $.post('/wheel/get',{_token: csrf_token}).then(e=>{
            if(e.success){
                e.success.forEach((e)=>{
                    e = e
                    class_dop = ''
                    if(e.user_id == USER_ID){
                        class_dop = 'img_no_blur'
                    }

                    $('.x30__bet-users.x'+e.coff).prepend('<div data-user-id='+e.user_id+' class="x30__bet-user d-flex align-center justify-space-between">\
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
                    $('span[data-sumBets='+e.coff+']').html((e.sum).toFixed(0))
                    $('span[data-players='+e.coff+']').html(e.players)
                })

            }
            updateHistory(e.history)
        })
    }
    getWheel()
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
    socket.emit('subscribe', 'roomGame_2_{{\Auth::user()->id}}');
</script>
@endauth