<div class="wrapper">
    <div class="keno">
        <div class="keno__title d-flex justify-center align-center">
            <div class="keno__title-bg d-flex justify-center align-center">
                <img src="images/games/keno/keno.png">
            </div>
        </div>
        <div class="keno__content">
            <div class="keno__round-info d-flex justify-space-between align-center">
                <div class="keno__round-info-item d-flex">
                    <div class="d-flex flex-column ">
                        <span>Банк игры</span>
                        <b><b class="bankKeno"></b> <svg class="icon" style="width: 18px; height: 18px;"><use xlink:href="images/symbols.svg#coins"></use></svg></b>
                    </div>
                    

                    <div class="d-flex flex-column " style="margin-left: 20px;">
                        <span>Игроков</span>
                        <b><b class="usersKeno"></b> <svg class="icon" style="width: 18px; height: 18px;"><use xlink:href="images/symbols.svg#users"></use></svg></b>
                    </div>
                </div>


                <div class="keno__round-info-item d-flex flex-column align-end">
                    <span>До начала игры</span>
                    <b>00:<b class="timeKeno">15</b></b>
                </div>
            </div>
            <div class="keno__mines d-flex justify-center align-center"> <!-- сюда когда игра закончена и ты выиграл добавляем класс keno__mines--win и снизу показываем хуйню эту где победа -->
                <div class="keno__mines-win" style="display: none;">
                    <span>Победа!</span>
                    <b>+100 000 Р</b>
                </div>
                <div class="keno__canvas d-flex justify-space-between flex-wrap">
                    @for ($i=1; $i <= 40; $i++)
                    <div class="keno__canvas-item  d-flex align-center justify-center" onclick="selectKeno({{$i}}, this)">
                        <div class="keno__canvas-users d-flex align-center"></div>
                        <span class="keno__canvas-number" >{{$i}}</span>
                        <div class="kenoBonus" style="display:none;">
                            <div class=" d-flex align-center flex-column justify-center" style="position: relative;top: -4px;"> <!-- это когда падает мульти бонус в ячейку -->
                                <svg style="height: 32px;width: 32px;" class="icon"><use xlink:href="images/symbols.svg#crown"></use></svg>
                                <p style="margin: 0;margin-top: 5px;font-weight: bold;color: #F2B200;">x3</p>
                            </div>
                        </div>
                    </div>
                    @endfor  


                </div>
            </div>
            <div class="keno__bet">
                <div class="keno__bet-settings d-flex align-center justify-space-between flex-wrap">
                    <div class="keno__bet-left d-flex align-center">

                        <a href="#" class="keno__cancel-select d-flex align-center" onclick="disable(this);clearKeno(this)">
                            <svg style="height: 13px;width: 13px;" class="icon"><use xlink:href="images/symbols.svg#close"></use></svg>
                            <span>Отменить выбор</span>
                        </a>
                        <a href="#" class="keno__auto-select d-flex align-center" onclick="disable(this);autoKeno(this)">
                            <svg style="height: 13px;width: 13px;" class="icon"><use xlink:href="images/symbols.svg#auto"></use></svg>
                            <span>Авто-выбор</span>
                        </a>
                    </div>
                    <div class="keno__bet-right d-flex align-center">
                        <input class="keno__bet-input" type="text" id="sumBetKeno" placeholder="0.00">
                        <button onclick="disable(this);betKeno(this)" class="keno__bet-add is-ripples flare btn btn--blue d-flex align-center">
                            <span>Поставить</span>
                        </button>
                        @auth
                        @if(\Auth::user()->admin == 1)
                        <button rel="popup" data-popup="popup--gokeno" class="keno__bet-add is-ripples flare btn btn--blue d-flex align-center">
                            <span>Подкрутка</span>
                        </button>
                        @endif
                        @endauth
                    </div>
                </div>
                <div class="keno__coeff">
                    <div class="keno__coeff-scroll d-flex align-center">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="wrapper">

   @auth
   @if(\Auth::user()->admin == 1)
   <div class="history">
    <table>
        <thead>
            <tr>
                <td>Игрок</td>
                <td>Ставка</td>
                <td>Номера</td>
                <td>Макс вин</td>
            </tr>
        </thead>
        <tbody class="gameKeno">

        </tbody>
    </table>
</div>
@endif
@endauth
</div>


<script type="text/javascript">
    var selectsKeno = []



    function getKeno() {
        $.post('/keno/get',{_token: csrf_token}).then(e=>{
            $('.bankKeno').html(Number(e.bank).toFixed(2))
            $('.usersKeno').html(e.users)
            $('.gameKeno').html('')

            e.history.forEach((e)=>{

              $('.gameKeno').prepend(' \
                 <tr>\
                 <td>\
                 <div class="history__user d-flex align-center justify-center">\
                 <div class="history__user-avatar" style="    background: url('+e.img+') no-repeat center center / cover;"></div>\
                 <span>'+e.login+'</span>\
                 </div>\
                 </td>\
                 <td>\
                 <div class="history__sum d-flex align-center justify-center">\
                 <span>'+e.bet+'</span>\
                 <svg class="icon money"><use xlink:href="images/symbols.svg#coins"></use></svg>\
                 </div>\
                 </td>\
                 <td>\
                 <div class="history__sum d-flex align-center justify-center">\
                 <span>'+e.numbers+'</span>\
                 </div>\
                 </td>\
                 <td>\
                 <div class="history__x d-flex align-center justify-center">\
                 <div class="history__x-bg">'+(Number(e.win).toFixed(2))+'</div>\
                 <span>'+(Number(e.win).toFixed(2))+'</span>\
                 </div>\
                 </td>\
                 </tr>')
          })
            if(e.success){                        
                select = JSON.parse(e.selects)
                select.forEach(async function(item, i, arr) { 
                    selectsKeno.push(item)
                    setTimeout(function(){
                        $('.keno__canvas-item:eq('+(item - 1)+')').addClass('keno__canvas-item--is-selected')

                    }, 100 * ++i)
                }); 
                $('#sumBetKeno').val(e.bet)
                disable('.keno__cancel-select')
                disable('.keno__auto-select')
                $('.keno__canvas-item').addClass('blocked')  
                

                setTimeout(function(){
                    updateKenoCoeff()
                    socket.emit('KENO_CONNECT')
                }, select.length * 100 + 100)
            }else{
                updateKenoCoeff()
                socket.emit('KENO_CONNECT')
            }
        })
    }
    getKeno()
</script>