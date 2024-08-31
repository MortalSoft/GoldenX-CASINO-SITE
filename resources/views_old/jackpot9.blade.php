 <div class="content">
   <div class="flex ">
      <div class="col-menu-lg">

      </div>
      <div class="col" style="max-width: 700px;margin: 0px auto;">
         <div class="flex no_padding wrap">
            <div class="col-lg-50">
               <div class="jackpot_block_info">
                  <div class="block_info_pos">
                     <div class="padding-20" style="position: relative;">
                        <span class="name_jackpot">CashPot</span>
                        <div class="inf_text_jackpot">Чем больше ставка - тем больше шанс выиграть.</div>
                        <img src="img/jackpot_money.png?v=2" class="img_jackpot" style="width:90px;top:20px;right: 10px;">
                     </div>

                  </div> 

               </div>
            </div>

            <div class="col-lg-25">
               <div class="jackpot_block_infogame">
                  <div class="padding-20">
                     <img src="img/games_jackpot.svg">
                     <div class="number_jackpot" id="gamesToday">0</div>
                     <div class="text_total_jackpot">ИГР СЕГОДНЯ</div>
                  </div>
               </div>
            </div>

            <div class="col-lg-25">
               <div class="jackpot_block_infogame">
                  <div class="padding-20">
                     <svg style="height: 19px;width: 19px;fill:#615EE8"><use xlink:href="img/main/symbols.svg?v=34#coins"></use></svg>
                     <div class="number_jackpot" id="maxWin">0</div>
                     <div class="text_total_jackpot">МАКС. ВЫИГРЫШ</div>
                  </div>
               </div>
            </div>
         </div>

         <div id="cashHunt" style="display: none">
            <div class="cashHantHeader">
               <img class="logoHantLeft d-comp" src="img/cashhant/logoLeft.png">
               <img class="logoHant" src="img/cashhant/logo.png">
               <img class="logoHantRight d-comp" src="img/cashhant/logoRight.png">
            </div>
            <div class="cashHantBlock" style="position:relative;">

                    <img src="img/cashhant/dop1.png" style="position:absolute;left: 5%;top:15%">
                    <img src="img/cashhant/dop2.png" style="position:absolute;right: 5%;top:35%">

                    <div class="cashHantBody" style="margin-bottom:20px;">
                     <center>    
                       <div class="cashHantWrapper">

                           @for ($i = 0; $i < 64; $i++)
                           <div class="hant" onclick="disable('.hant');selectCashHunt({{$i + 1}}, this)"></div>
                           @endfor

                       </div> 
                   </center>

               </div>

               <span class="text-secondary" style="font-weight: normal;">* Если вы не успели выбрать клетку, автоматически выберется 1 клетка</span>
           </div>
           <div class="cashHantBottom">
              <div class="flex no_padding wrap">
                 <div class="col-lg-60">
                    <div class="flex no_padding wrap">
                       <div class="col-5">
                          <div class="block_jackpot_info_game">
                             <img src="img/peoples.svg" class="imgJ">
                             <div class="infoJ">
                                <span class="number_infoJ usersCount">0</span>
                                <div class="text_infoJ">Игроков</div>
                            </div> 
                        </div>
                    </div>
                    <div class="col-5"> 
                      <div class="block_jackpot_info_game">
                        <svg class="imgJ" style="fill:#615EE8"><use xlink:href="img/main/symbols.svg?v=34#coins"></use></svg>     
                         <!-- <img src="img/coinsBlack.svg" class="imgJ"> -->
                         <div class="infoJ">
                            <span class="number_infoJ bankGame">0</span>
                            <div class="text_infoJ">Банк</div>
                        </div>
                    </div> 
                </div>     
            </div>        
        </div>   
        <div class="col-lg-40">
            <div class="flex no_padding" style="justify-content: space-between;">
               <div class="col" style="max-width: calc(100% - 80px);min-width: calc(100% - 80px);position: relative;">
                  <input type="" class="inputJackpot" id="inputCashHuntBet" readonly="" value="1" name="">
                  <div class="dopJ">
                     <img src="img/coinDopJ.svg">
                 </div>
             </div>
             <div class="col" style="max-width: 60px;min-width: 60px;position:relative;">
              <div class="water"></div>
              <div class="timerCashHunt">9</div>
          </div>
      </div> 
  </div>   
</div>


</div>

<!-- <button class="btn-dep w-100" style="margin-top: 25px">Что это такое?</button> -->

</div>


<div id="Jackpot" style="">

   <div class="blockRouletteJackpot" style="display: none;">
      
      <div class="item " style="margin-bottom:0px;margin-top: 5px;">
         <div class="roulette_jackpot" >
            <div class="inbox">
               <div class="players jackpot">                            
               </div>
           </div>
       </div>
   </div>
   <img class="arrowJackpotTop" src="img/arrowJackpotTop.png">
   <img class="arrowJackpotBottom" src="img/arrowJackpotBottom.png">
   <div class="blockRouletteJackpotTen_1"></div>
   <div class="blockRouletteJackpotTen_2"></div>
</div>

<div class="progress_block_jackpot">
  <div class="progress_jackpot" style="width: 100%"></div>
  <div class="time_jackpot"><img src="img/clock_jackpot.svg" class="clock_jackpot"><span class="time_j_span">00:<span class="timeJackpot">30</span></span></div>
</div>

<div class="flex no_padding wrap">
  <div class="col-lg-60">
     <div class="flex no_padding wrap">
        <div class="col-4">
           <div class="block_jackpot_info_game">
            <svg class="imgJ imgJCoin d-comp" style="width: 20px;"><use xlink:href="img/main/symbols.svg?v=50#users"></use></svg>
              <!-- <img src="img/peoples.svg" class="imgJ d-comp"> -->
              <div class="infoJ">
                 <span class="number_infoJ usersCount">0</span>
                 <div class="text_infoJ">Игроков</div>
             </div>
         </div>
     </div>
     <div class="col-4">
       <div class="block_jackpot_info_game">
         <svg class="imgJ imgJCoin d-comp" ><use xlink:href="img/main/symbols.svg?v=34#coins"></use></svg> 
          <!-- <img src="img/coinsBlack.svg" class="imgJ d-comp"> -->
          <div class="infoJ">
             <span class="number_infoJ bankGame" >0</span>
             <div class="text_infoJ">Банк</div>
         </div>
     </div>
 </div>
 <div class="col-4">
   <div class="block_jackpot_info_game">
      <div class="infoJ">
         <span class="number_infoJ chanceUser">0%</span>
         <div class="text_infoJ">Шанс</div>
     </div>
 </div>
</div>
</div>
</div>
<div class="col-lg-40">
 <div class="flex no_padding" style="justify-content: space-between;">
    <div class="col" style="max-width: calc(100% - 80px);min-width: calc(100% - 80px);position: relative;">
       <input type="" class="inputJackpot" id="inputJackpot" value="1" name="">
       <div class="dopJ">
          <img src="img/coinDopJ.svg">
      </div>
  </div>
  <div class="col" style="max-width: 60px;min-width: 60px">
   <button class="btnJ" onclick="disable(this);betJackpot(this)"><img style="position: relative;top:1px;left: 0px;" src="img/betBtnJ.svg"></button>
</div>
</div>
</div>
</div>

<div class="JackpotWin" style="display:none">
    <div class="betJackpot"> 
        <div class="flex no_padding wrap">
            <div class="col-4 col-m-5 " style="text-align:left" >
                <img src="https://sun9-3.userapi.com/impg/5GJzDw1lCKU1uagIMdaGF9YxI4j2yWVyt_elqw/Q0mcE10I1EA.jpg?size=50x50&quality=96&sign=2360c3b5e82e78ab0f12559a7201f398&type=album" class="betJackpotAva img_no_blur">
                <div class="betUser">   <span class="nameBetUser" style="font-weight:bold;color:#F68D44">ВЫИГРАЛ</span>   
                    <div class="sumBetUser" style="font-weight:bold;"><span style="color: #706bf6" id="sw_win"></span></div>
                </div>
            </div> 
            <div class="col-lg-4 d-comp" style="text-align:center" > 
                
                <img src="" id="sw_avatar" class="betJackpotAva">
                <div class="betUser">   <span class="nameBetUser" id="sw_login"></span>   
                    <div class="sumBetUser"><span id="sw_bet"></span>
                        <svg class="coinsBlackJ" ><use xlink:href="img/main/symbols.svg?v=34#coins"></use></svg>
                    </div>
                </div>
                
                
            </div>
            <div class="col-4 col-m-5" style="text-align: right;">
                <div class="ticketsBetUser" style="text-align: left;">  <span class="nameTicket">Билет</span>  
                    <div class="ticketNum" style="color: #9594C6">#<span id="sw_ticket"></span></div>
                </div>
                <div class="percentBetUser" style="position: relative;background: #4E4AFE;">
                    
                    <div class="percentTextUser" style="color: #fff"><span class="sw_percent"></span>%</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="JackpotPlay" style="display: none;">
  <div class="flex no_padding" style="margin-top: 20px;">
     <div style="width: 50px;border-bottom-left-radius: 0px;" class="arrowJackpot"><img src="img/arrowJackpot.svg" style="transform: translate(-50%, -50%) rotate(180deg)!important;"></div>
     
     <div style="width: calc(100% - 100px);">
        <div class="usersJackpot element">         


        </div>

    </div>
    <div style="width: 50px;border-bottom-right-radius: 0px;" class="arrowJackpot"><img src="img/arrowJackpot.svg" ></div>
</div>

<div class="chancesJackpot" style="width: 100%;"></div>



<div class="betsJackpot" >

</div>
</div>
<div class="waitJackpot" style="margin-top: 35px;">
  <center>
     <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin:auto;display:block;" width="46px" height="46px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
        <circle cx="50" cy="50" fill="none"  stroke="#DCDCEA" stroke-width="8" r="35" >
        </circle>

        <circle cx="50" cy="50" fill="none"  stroke="#615EE8" stroke-width="8" r="35" stroke-dasharray="164.93361431346415 56.97787143782138">
           <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
       </circle>



   </svg>
   <span class="text-secondary" style="margin-top: 10px;display: block;">Ожидание ставок...</span>
</center>

</div>
<button class="btn-dep w-100" style="margin-top: 25px" onclick="getHistoryJackpot();show_modal('history_jackpot')">История игр</button>
</div>


</div>
</div>
</div>

<script type="text/javascript">
  socket.emit('JACKPOT_CONNECT')
  function getJackpot(){
     $.post('/jackpot/get',{_token: csrf_token}).then(e=>{
        if(e.success){
           $('#gamesToday').html(e.gamesToday)
           $('#maxWin').html(e.maxWin)
           $('#inputCashHuntBet').val(e.sumBetUser)
           if((e.jackpot).length > 0){
              $('.JackpotPlay').show();
              $('.waitJackpot').hide();
              $('.betsJackpot').html('')
              $('.usersJackpot').html('')
              addInPlayers(e.players)
              addInBets(e.jackpot)
          }


      }
  })
 }
 getJackpot()



 socket.on('CASHHUNT_START',e=>{
    $('#Jackpot').hide()
    selectCashHunt(1, '.hant:eq(0)')
    $('.hant').removeClass('active show')
    $('.hant:eq(0)').addClass('active')
    $('#cashHunt').show()
    $('.water').addClass('animate')
    $('.cashHantWrapper .hant').each(function(i,elem) {
        img = e.cashHantJackpot[i] 
        $(this).html('<img src="img/cashhant/'+img+'.png">')

    });
})



</script>

<style type="text/css">

</style>