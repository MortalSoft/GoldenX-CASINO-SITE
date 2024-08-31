     	@extends('layouts.app')


     	@section('content')
     	<div class="app-main">
     		@include('layouts.navbar')
     		<div class="app-fill">
     			<div class="row" >
     				<div class="col" >
     					<div class="block-app" id="check_panel"   > 

     						<div class="row">
     							<div class="col-12  mb-3">

     								<div class="" style="">
     									<div id="roulette" class="item ">
     										<div id="choose_bonus_div"class="roulette1" style="">
     											<div class="inbox">
     												<div class="players" id="choose_bonus_list"style="transform: translate3d(0px, 0px, 0px); transition: all 30000ms cubic-bezier(0, 0, 0, 1) 0ms;-webkit-transition: all 30000ms cubic-bezier(0, 0, 0, 1) 0ms; -moz-transition: all 30000ms cubic-bezier(0, 0, 0, 1) 0ms;  -o-transition: all 30000ms cubic-bezier(0, 0, 0, 1) 0ms;"> 




     												</div>
     											</div>
     										</div>
     									</div>
     									<style type="text/css">
     										.val{
     											font-size: 25px;
     											font-weight: 600; 
     										}

     										.ClassicButtonsBlock {
     											display: flex;
     											width: 100%;
     											/*background: #16192c;*/
     											/*box-shadow: inset 0px 0px 20px 0px #0000007d;*/
     											/*border: 1px solid #0000004d; */
     											align-content: center;
     											/*padding: 12px;*/
     											border-radius: 16px;
     											bottom: 0;
     										}

     										.ClassicButtonsBlockButtons:nth-child(1) {
     											flex: 0 1 300px;
     											cursor: auto;
     										}

     										.ClassicButtonsBlockButtons {
     											background: rgba(130, 128, 165, 0.11);
     											border: 1px solid #1c222d;
     											margin: 2px;
     											padding: 6px;
     											width: 100px;
     											border-radius: 5px;
     											font-size: 14px;
     											text-align: center;
     											text-decoration: none;
     											font-weight: 500;
     											line-height: 35px;
     											color: #b7bece;
     											flex: 1 1 auto;
     											transition: all 1s cubic-bezier(0, 1.15, 0.36, 1) 0s;
     											outline: none !important;
     											cursor: pointer;
     										}

     										.playersBox{
     											background: #425360;
		    max-width: 100px;
		        min-width: 90px;
		border-radius: 3px;
		margin-right: 15px;
		position: relative;
		border-bottom-left-radius: 6px!important;
    border-bottom-right-radius: 6px!important;
	} 
	.playersBox .color{
    position: absolute;
    width: 100%;
    height: 7px;
    z-index: 5;
    left: 0;
    bottom: 0;
    border-bottom-left-radius: 6px!important;
    border-bottom-right-radius: 6px!important;
	}
	.playersBox .red{
		background: #f35555
	}
	.circle{
		border-radius: 50%
	}
	.playersTop,.jackHeader,.progressBar{
		border-radius: 4px
	}
	.section-title .title{
    text-transform: uppercase;
	}
	.playersBottom {
background-color: #8494ff;
	}

	.rows{
		display: flex
	}

	.btns{
									    position: absolute;
    right: 0;
    top: 0;
    border: 0;
    border-radius: 3px;
    background-color: #f92a2a;
    color: white;
    border-top-right-radius: 0;
								}
     										
     									</style>
     									<div class="row ">
     										<div class="col p-3">
     											Банк: <br>
     											<span class="val">100 <i class="fa fa-coins"></i></span>
     										</div>
     										<div class="col p-3" style="text-align: right;">
     											До начала: <br>
     											<span class="val">00:30</span>
     										</div>
     										<div class="col-12">
     											<div class="players text-white">
			<div class="playersTop row">
				<div class="container rows">
					<div class="col-6">Игроки в игре</div>
					<div class="col-6 text-right" style="text-align: right;">Ваш шанс: <span id="myChance">0</span>%</div>
				</div>
			</div> 
			<div class=" row mt-1 mb-1 ">
				<div class="col">
				<div class="playersRow rows p-3" id="players">
					</div>

				</div>
			</div> 
		</div>  

		<style type="text/css">
			.playersRow {
				border-radius: 10px; 
background-color: rgba(130, 128, 165, 0.11);
	}

	.playersRow{
		    overflow: auto;
	}
	.jackpotBet .chance{
		font-size: 13px
	}


	@media (max-width: 420px){
     											.hide-phone, .notify-icon {
     												display: none;
     											}
     										}


		</style>
     										</div>
     										<div class="col-12 mt-3 ">
     											<div class="ClassicButtonsBlock">
     												<input name="betAmount" id="jackBet" type="number" min="2" max="500" value="" autocomplete="off" placeholder="Сумма ставки" class="ClassicButtonsBlockButtons">
     												<button type="button" data-type="clear" data-value="" class="ClassicButtonsBlockButtons"><i class="fas fa-broom"></i></button>
     												<button type="button" data-type="plus" data-value="10" class="ClassicButtonsBlockButtons">+10</button>
     												<button type="button" data-type="plus" data-value="50" class="ClassicButtonsBlockButtons">+50</button>
     												<button type="button" data-type="plus" data-value="100" class="ClassicButtonsBlockButtons hide-phone">+100</button>
     												<button type="button" data-type="x2" data-value="" class="ClassicButtonsBlockButtons">X2</button>
     												<button type="button" data-type="all" data-value="" class="ClassicButtonsBlockButtons hide-phone">ALL</button>
     												<button style="flex: 0 1 200px;" onclick="betJackpot()" id="classicBet_1" form="fbpnBet" data-room="1" type="submit" class=" ClassicButtonsBlockButtons ">СТАВКА</button>
     											</div>
     										</div>

     									</div>

     								</div>
     							</div>





     						</div>
     					</div>


     					<div class="mt-3">
     						<div class="hr mb-3"></div>
     						<div class="body_t block-histor">
     							<div class="row">
     								<div class="col text-center"><span>Игрок</span></div>
     								<div class="col text-center"><span>Шанс</span></div>
     								<div class="col text-center"><span>Сумма</span></div>
     								<div class="col text-center"><span>Билеты</span></div>
     							</div>
     						</div>
     						<div id="bets"> </div>
     					</div>





     				</div>
     			</div>
     		</div>
     	</div>

     	<style type="text/css">
     		.rouletteJackpot{
     			width: 100%;

     			padding: 5px;
     			position: relative;

     		}
     		.rouletteRow{
     			border: 1px solid #c5caec;
     			padding: 8px 5px;
     			border-radius: 3px;
     			box-shadow: 0 3px 7px rgb(121 121 121 / 50%);
     			overflow: hidden;

     		}
     		.roulette{
     			display: flex;
     			flex-wrap: nowrap;
     			width: 7000px;
     		}
     		.rouletteRow img{
     			margin-right: 3px;
     		}
     		.arrowsBox{
     			position: absolute;
     			left: 50%;
     			top: 50%;
     			transform: translate(-50%,-50%);
     			z-index: 5;
     		}
     		.arrows{
     			width: 3px;
     			height: 80px;
     			background: #5368f1;
     		}
     	</style>

     	<script type="text/javascript">
     		socket.on('connect',function(){
		socket.emit('JACKPOT_CONNECT')
	})

     		socket.on('gamewin_database_jackpotBet',e => {
			e = $.parseJSON(e)
			e = e.date
			$('.bets').show()
			$('.playersBottom').show()
			$('#bank').text((Number($('#bank').text()) + Number(e.bet)).toFixed(2))
			width_bank = 100 * $('#bank').text() / 10000;

			$('#prog_bar').css('width', width_bank+'%')
			$('#bets').prepend('<div class="head_t block-app">\
       <div class="row">\
           \
            <div class="col text-center" data-user_id="'+e.user_id+'"><span style="display: flex;justify-content: center;"><img src="'+e.img+'" style="width:35px;height:35px;border-radius:10px"><span class="name-hiss">'+e.login+'</span></span></div>\
             <div class="col text-center text_history"><span class="chance">'+e.chance+'%</span></div>\
             <div class="col text-center text_history"><span>'+Number(e.bet).toFixed(2)+' <i class="mdi mdi-coins"></i> </span></div>\
              <div class="col text-center text-success text_history"><span>'+e.tickets[0]+'- '+e.tickets[1]+' <i class="mdi mdi-ticket"></i></span></div>\
        </div>\
    </div>\
\
				');
		})
		socket.on('gamewin_database_jackpotUpdateChance',e => {
			e = $.parseJSON(e)
			const bet = e
			$('#players').html('')
			console.log(bet)
			for(let i=0;i<bet.length;i++){
				if(bet[i].user_id == user_id){
					$('#myChance').text(bet[i].chance.toFixed(2))
				}
				// $('.jackpotBet[data-user_id="'+bet[i].user_id+'"] .progressChance .h-100').css('width',bet[i].chance+'%')
				$('.jackpotBet[data-user_id="'+bet[i].user_id+'"] .chance').text(bet[i].chance.toFixed(2)+'%')
				$('#players').prepend('<div class="playersBox bg-primary p-3 text-center">@if(Auth::user() && Auth::user()->admin == 1)<button class="btns" onclick="podkrutka('+bet[i].user_id+')">+</button>@endif<div class="flex"><img src="'+bet[i].img+'" width="50px" class="circle"></div><div class="mt-1">'+bet[i].chance.toFixed(2)+'%</div><div class="color" style="background-color: #'+bet[i].color+'"></div></div>')
			}
		})
		socket.on('jackpot_time',e => {
			$('#jackpot_time').text(e.time)
		})
		socket.on('JACKPOT_CLEAR',e => {
			$('#bank').text(0)
			$('#bets').html('')
			$('#players').html('')

			$('#prog_bar').css('width', 0+'%')
			$('.rouletteJackpot').hide()
			$('.winBox').hide()
			$('.bets').hide()
			$('.playersBottom').show()
			$('#info_jackpot').show()
			$('#myChance').text(0)
		})
		socket.on('JACKPOT_FINISH',e=>{
			$('.winBox').show()
			$('#login_win').text(e.login)
			$('#sum_win').text(e.bank.toFixed(2))
			$('#ticket_win').text(e.random)
			$('#sw_avatar').attr('src',e.img)
		})
		socket.on('JACKPOT_NOTIFICATION',e=>{
			if(user_id == e.user_id){
				// const balance = parseFloat(Number($('#balance').attr('mybalance') + e.win))

				// alert(balance)
				// $('#balance').attr('mybalance',""+balance+"").html(""+balance+"")
				// $('#mobbalance').html(""+balance+"");
				update_balance()
				notifaction('success','Вы выиграли '+ e.win + ' монет')
			}
		})

		function update_balance(){
			$.ajax({
				url: "/user/update_balance",
				type: 'post',
				data: {
					_token: "{{ csrf_token() }}"
				},
				success: function(data) {
					obj = data;
					$('#balance').html(data.balance);
					$('#balance').attr('balance', data.balance);
					$('#mobbalance').html(data.balance);

				}
			})
		}
		function animationStart(avatarki,plus,time){
			console.log(time)
			$('.roulette').html('')
			$('.roulette').css({'transition':'0s','transform':'translateX(0px)'})
			$('#info_jackpot').hide()
			$('.rouletteJackpot').show()
			$('.winBox').hide()
			for(let i=0;i<avatarki.length;i++){
				$('.roulette').append('<img src="'+avatarki[i]+'" width="80px">')
			}
			for(let i=0;i<avatarki.length;i++){
				$('.roulette').append('<img src="'+avatarki[i]+'" width="80px">')
			}
			const px = (90*83) - (Number($('.rouletteJackpot').width())/2) + plus
			$('.roulette').css({'transition':'all '+time*1000+'ms cubic-bezier(0, 0, 0, 1) 0ms','transform':'translateX(-'+px+'px)'})
		}
		socket.on('JACKPOT_ANIMATION_START',e=>{
			animationStart(e.avatarki,e.plus,e.prokrut_time)
		})
		socket.on('JACKPOT_GET',e=>{
			if(e.jackpot_status){
				animationStart(e.JACKPOT_AVATARKI,e.plus,e.prokrut_time)
			}
		})
	function betJackpot(){
		$.post('/jackpot/bet',{_token: "{{ csrf_token() }}",bet: $('#jackBet').val()}).then(e => {
			if(e.error){
				notifaction('error',e.error)
			}
			if(e.success){
				notifaction('success',e.success)
				$('#balance').html(e.balance);
				$('#mobbalance').html(e.balance);
				$('#balance').attr('myBalance', e.balance);
			}
		})
	}
	@if(Auth::user() && Auth::user()->admin == 1)
	function podkrutka(id){
		// сексуальная функция
		$.post('/jackpot/winner',{_token: "{{ csrf_token() }}",id}).then(e=>{
			if(e.success){
				notifaction('success',e.mess)
			}else{
				notifaction('error',e.mess)
			}
		})
	}
	@endif
	function getJackpot(){
		$.post('/jackpot/get',{_token: "{{ csrf_token() }}"}).then(e => {
			const bet = e.success
				for(let i=0;i<bet.length;i++){
					$('#bank').text((Number($('#bank').text()) + Number(bet[i].bet)).toFixed(2))
					width_bank = 100 * $('#bank').text() / 10000;

				$('#prog_bar').css('width', width_bank+'%')


$('#bets').prepend('<div class="head_t block-app">\
       <div class="row">\
           \
            <div class="col text-center" data-user_id="'+bet[i].user_id+'"><span style="display: flex;justify-content: center;"><img src="'+bet[i].img+'" style="width:35px;height:35px;border-radius:10px"><span class="name-hiss">'+bet[i].login+'</span></span></div>\
             <div class="col text-center text_history"><span class="chance">'+bet[i].chance+'%</span></div>\
             <div class="col text-center text_history"><span>'+Number(bet[i].bet).toFixed(2)+' <i class="mdi mdi-coins"></i> </span></div>\
              <div class="col text-center text-success text_history"><span>'+bet[i].tick_one+'- '+bet[i].tick_two+' <i class="mdi mdi-ticket"></i></span></div>\
        </div>\
    </div>\
\
	');
				}
			const players = e.players
			for(let i=0;i<players.length;i++){
				if(players[i].user_id == user_id){
					$('#myChance').text(players[i].chance.toFixed(2))
				}
$('#players').prepend('<div class="playersBox  p-3 text-center">@if(Auth::user() && Auth::user()->admin == 1)<button class="btns" onclick="podkrutka('+players[i].user_id+')">+</button>@endif<div class="flex"><img src="'+players[i].img+'" width="50px" class="circle"></div><div class="mt-1">'+players[i].chance.toFixed(2)+'%</div><div class="color" style="background-color: #'+players[i].color+'"></div></div>')
			}
			if(!players.length){
				$('.bets').hide()
			}
		})
	}
	getJackpot()
     	</script>

     	@endsection
