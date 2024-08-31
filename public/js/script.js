var csrf_token = $('meta[name="csrf-token"]').attr('content')

$('#balance').html('')

function getRandomInt(min, max) {
	min = Math.ceil(min);
	max = Math.floor(max);
	return Math.floor(Math.random() * (max - min)) + min;
}

function activeLinks(){

	$('.sidebar__game').removeClass('sidebar__game--active');
	var s = location.href;
	var url = (s.substr(s.lastIndexOf("/")+1))
	$('.btn_active').removeClass('active')
	
	$('.btn_active.btn_'+url).addClass('active')	
	$('.game_'+url).addClass('sidebar__game--active');
}



function load(page, that, func = '', id = '') {
	$('.preloader').removeClass("preloader-remove");  
	let _load = function() {
		$.get("/" + page + (page.includes('?') ? '&' : '?') + 'json', function(data) {
			$('#_ajax_content_').html(data);
			window.history.pushState({"html":data,"pageTitle":$(document).find("title").text()}, $(document).find("title").text(), "/"+page);
			$('#_ajax_content_').fadeIn('slow')
			$('.preloader').addClass("preloader-remove");  
			$('.btn_open_close_prof').removeClass('active');
			activeLinks();
			chatGet()
			getHistoryGames()
			$(".popup--wallet .popup__content .wallet").not(":first").hide();
			$(".popup--wallet .popup__content .wallet__history").not(":first").hide();
			if(func == 1){
				setTimeout(() => loadTournier(id), 1000); 
			}
			socket.emit('getGamesOnline');
			$('html, body').animate({scrollTop: 0},0);
			

		}).fail(function(jqxhr, settings, exception) {
			$('.preloader').addClass("preloader-remove");
			notifaction("error", "Ошибка")      
		});
	};

	_load();
}




$(document).ready(function() {
	$('.preloader').addClass("preloader-remove");
	// $('#app').snowfall({image :"images/snow/snow/1.png", minSize: 5, maxSize:15, flakeCount: 20});
	$.ripple('.is-ripples', {
		debug: true,
		multi: false, 
		color: "#fff",
		opacity: 0.4,
		duration: 0.3
	});
	toastr.options = {
		"closeButton": false,
		"debug": false,
		"newestOnTop": true,
		"progressBar": true,
		"positionClass": "toast-top-right",
		"preventDuplicates": false,
		"onclick": null,
		"showDuration": "500",
		"hideDuration": "1000",
		"timeOut": "5000",
		"extendedTimeOut": "1000",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	};
	$('#chatBtn').click(function(e){
		e.preventDefault();
		$('#moreBtn').removeClass('active');
		$(this).toggleClass('active')
		$('body').toggleClass('chat--opened').removeClass('more--opened');
	});
	$('#moreBtn').click(function(e){
		e.preventDefault();
		$('#chatBtn').removeClass('active');
		$(this).toggleClass('active')
		$('body').toggleClass('more--opened').removeClass('chat--opened');
	});

	$('.close-chat').click(function(e){
		e.preventDefault();
		$('body').removeClass('chat--opened');
		$('#chatBtn').removeClass('active');
	})
});

const socket = io(':2083');

socket.emit('getUsersOnline');
socket.emit('getGamesOnline');

socket.on('usersOnline', function(data){
	$('.online').html(Number(data));
})

socket.on('gamesOnline', function(data){
	gamesOnline = JSON.parse(data)
	let i = 0;
    while (i < 9) {
        onlineG = gamesOnline[i].length
        $('.games .games__item:eq('+i+') .games__item-text p').html(Number(onlineG)+' человек');
        
        i++;
    }
})

socket.on('laravel_database_mess', function(data){
	data = JSON.parse(data);
	var type = data.type;

	if(type == "uploadMessage"){
		chatAdd(data);    
	}
	if(type == "chat_clear"){
		$('.chat__messages .ss-wrapper .ss-content').html('');
	}
	if(type == "deleteMess"){
		var idd = data.id;
		$('#msg_'+idd).remove();
	}
}) 

socket.on('CHAT_TIME',e=>{
	chatHour = String(e.chatHour)
	chatMinute = String(e.chatMinute)
	chatSecond = String(e.chatSecond)
	$('.Chat .chat__promocode-timer--span:nth-child(1)').html(chatHour[0])
	$('.Chat .chat__promocode-timer--span:nth-child(2)').html(chatHour[1])
	$('.Chat .chat__promocode-timer--span:nth-child(4)').html(chatMinute[0])
	$('.Chat .chat__promocode-timer--span:nth-child(5)').html(chatMinute[1])
	$('.Chat .chat__promocode-timer--span:nth-child(7)').html(chatSecond[0])
	$('.Chat .chat__promocode-timer--span:nth-child(8)').html(chatSecond[1])
})


socket.on('laravel_database_history', function(data){
	e = JSON.parse(data); 

	$(".gameHistory").prepend(' \
		<tr>\
		<td>\
		<div class="history__game d-flex align-center justify-center">\
		<svg class="icon"><use xlink:href="images/symbols.svg?v=5#'+e.icon_game+'"></use></svg>\
		<span>'+e.name_game+'</span>\
		</div>\
		</td>\
		<td>\
		<div class="history__user d-flex align-center justify-center">\
		<div class="history__user-avatar" style="    background: url('+e.avatar+') no-repeat center center / cover;"></div>\
		<span>'+e.name+'</span>\
		</div>\
		</td>\
		<td>\
		<div class="history__sum d-flex align-center justify-center">\
		<span>'+e.bet+'</span>\
		<svg class="icon money"><use xlink:href="images/symbols.svg#coins"></use></svg>\
		</div>\
		</td>\
		<td>\
		<div class="history__x d-flex align-center justify-center">\
		<div class="history__x-bg">'+((e.win / e.bet).toFixed(2))+'x</div>\
		<span>'+((e.win / e.bet).toFixed(2))+'x</span>\
		</div>\
		</td>\
		<td>\
		<div class="history__sum d-flex align-center justify-center">\
		<span>'+e.win+'</span>\
		<svg class="icon money"><use xlink:href="images/symbols.svg#coins"></use></svg>\
		</div>\
		</td>\
		</tr>');
	
	$('.gameHistory').children().slice(10).remove();

}) 

function sleep(milliseconds) {
	const date = Date.now();
	let currentDate = null;
	do {
		currentDate = Date.now();
	} while (currentDate - date < milliseconds);
}

function stretchArray(arr, limit) {
  if (!arr.length || limit < arr.length) {
    throw new Error('Не удалось растянуть массив.');
  }

  // Целое число, на которое будет размножен каждый элемент.
  const integer = Math.floor(limit / arr.length);

  // a % b - остаток от деления.
  // По единичке будем накидывать на каждый элемент.
  // Кому досталось, тому досталось, как `крошки` со стола.
  let crumbs = limit % arr.length;

  const newArr = Array.from(arr, function(item, index) {
    // Сколько раз нужно размножить элемент массива.
    const repeater = integer + (crumbs > 0 ? 1 : 0);

    // Уменьшаем количество `крошек`.
    crumbs--;

    // Размножаем элемент массива и возвращаем.
    return Array(repeater).fill(item);
  });
  
  // [[1, 1], [2, 2]] => [1, 1, 2, 2]
  return [].concat(...newArr);

  // Можно с помощью `flat`:
  // return newArr.flat();
}

var numbersBlockBoom = [10, 11, 12, 13, 14, 15,
						18, 19, 20, 21, 22, 23,
						26, 27, 28, 29, 30, 31,
						34, 35, 36, 37, 38, 39,
						42, 43, 44, 45, 46, 47,
						50, 51, 52, 53, 54, 55]
function startBoom(e) {

	if(e.statusBoom == 0){
		// WAIT
		numbersBlockBoom.forEach(function(item, i, arr) {
			if(e.blocksBoom[i] == 'wait'){
				$('.boomcity__path div:eq('+(item - 1)+')').addClass('wait').html('<svg class="icon"><use xlink:href="/images/symbols.svg#dice"></use></svg>')
			}else{
				$('.boomcity__path div:eq('+(item - 1)+')').addClass(e.blocksBoom[i])
			}
		  });
	}
}

const perFace = [
  [-0.1, 0.3, -1],
  [-0.1, 0.6, -0.4],
  [-0.85, -0.42, 0.73],
  [-0.8, 0.3, -0.75],
  [0.3, 0.45, 0.9],
  [-0.16, 0.6, 0.18]
];

function rollDice(first, second){

	$('.diceBoom').removeClass('rolling throw')

	$(".diceBlock:nth-child(1) .diceBoom").css("transform", `rotate3d(${perFace[first - 1]}, 180deg)`);
	$(".diceBlock:nth-child(2) .diceBoom").css("transform", `rotate3d(${perFace[second - 1]}, 180deg)`);

	setTimeout(() => {
	   $(".diceBoom").addClass("throw");
	}, 50);	
}


socket.on('BOOM_GET',e=>{
	startBoom(e)
	$('#boom_city__timer').html(e.timeBoom)
})

socket.on('BOOM_TIME',e=>{
	$('#boom_city__timer').html(e.time)
})

var BetOffWheel = 'on';

socket.on('WHEEL_GET',e=>{
	startWheel(e)
	var arr = e.coefficients
	$(".x30__bet-heading_x30").each(function() {
		$(this).html('x'+arr[0]+'');
		if(e.statusBonus == 2){
			$(this).addClass('gold')
		}
		arr.shift();
	});

	if(e.statusBonus == 1){
		startBonus(e)
	}

})

socket.on('WHEEL_NEW_COEFF',e=>{
	var arr = e.coefficients
	console.log(arr)
	$(".x30__bet-heading_x30").each(function() {
		$(this).html('x'+arr[0]+'').removeClass('gold');
		arr.shift();
	});

})



socket.on('WHEEL_START',e=>{
	startWheel(e)
})

socket.on('WHEEL_BONUS',e=>{
	startBonus(e)
})

function startBonus(e){
	$('.x30 .x30__bonus-scroll').css({'transition':'0s','transform':'translateX(0px)'})

	$('.x30 .x30__bonus-scroll').html('')
	$('.x30 .x30__bonus').show()
	$('.x30 .x30__timer').hide()

	x = 56 * 42 - rand(5, 40)
	setTimeout(() =>   $('.x30 .x30__bonus-scroll').css({'transition':''+e.bonusWheelTime+'s','transform':'translateX(-'+x+'px)'}), 100);

	e.bonusArr.forEach((e)=>{

		$('.x30 .x30__bonus-scroll').append('<div class="x30__bonus-item x30 d-flex align-center justify-center">'+e.multiplayer[0]+'</div>')

	})
}

function startWheel(e){

	if(e.wheelStatus == 1){
		$('#x30__text').html('Прокрутка');
		$('#x30__status').addClass('x30__rocket--started');
	}

	rotateW = e.wheelRotate + e.wheelPlus;
	$('#x30__wheel').css('transition', 'all '+e.wheelTime+'s ease 0s').css('transform', 'rotate('+rotateW+'deg)')
	console.log('startWheel')
}


socket.on('WHEEL_TIME',e=>{
	window.BetOffWheel = e.bet
	$('#x30__timer').html(e.time)

	per = 100 * Number(e.time) / 30
	$('.prog_wheel').css('width', per+'%')
	$('.text_wheel').html(e.text)
})

socket.on('WHEEL_NOTIFY',e=>{
	if(USER_ID == e.user_id){
		notification('success', 'Вы выиграли '+e.win.toFixed(2)+' монет')
		updateBalance() 
	}
})

socket.on('WHEEL_FINISH',e=>{
	// $('.bets_block_col').addClass('opacity');
	// $('.bets_block_col.x'+e.colorCoffResult).removeClass('opacity')
	$('#x30__status').removeClass('x30__rocket--started');
	// updateBalance() 
	updateHistory(e.history)
})


socket.on('WHEEL_CLEAR',e=>{
	$('#x30__text').html('Начало через');
	$('.bets_block_col').removeClass('opacity');
	$('span[data-sumBets]').html(0)
	$('span[data-players]').html(0)
	$('.x30 .x30__bonus').hide()
	$('.x30 .x30__timer').show()

	$('.x30__bet-users').html('')
	var arr = [2, 3, 5, 7, 14, 30]
	$(".x30__bet-heading_x30").each(function() {
		$(this).html('x'+arr[0]+'').removeClass('gold');
		arr.shift();
	});
})

socket.on('laravel_database_updateBalance',e => {
	e = $.parseJSON(e)
	if(USER_ID == e.user_id){
		balanceUpdate(e.lastbalance, e.newbalance)
	}
})

socket.on('laravel_database_wheelBet',e => {
	e = $.parseJSON(e)
	e = e.data
	class_dop = ''
	if(e.user_id == USER_ID){
		class_dop = 'img_no_blur'
	}
	$('.x30__bet-users.x'+e.coff).prepend('<div data-user-id='+e.user_id+' class="x30__bet-user d-flex align-center justify-space-between">\
		<div class="history__user d-flex align-center justify-center">\
		<div class="history__user-avatar" style="background: url('+e.img+') no-repeat center center / cover;"></div>\
		<span>'+e.login+'</span>\
		</div>\
		<div class="x30__bet-sum d-flex align-center">\
		<span>'+(Number(e.bet).toFixed(2))+'</span>\
		<svg class="icon money" style="margin-left: 8px;"><use xlink:href="images/symbols.svg#coins"></use></svg>\
		</div>\
		</div>')

	

	$('span[data-sumBets='+e.coff+']').html((e.sumBets).toFixed(0))
	$('span[data-players='+e.coff+']').html(e.players)
})

socket.on('laravel_database_updateWheelBet',e => {
	e = $.parseJSON(e)
	e = e.data	
	$('span[data-sumBets='+e.coff+']').html((e.sumBets).toFixed(0))
	$('span[data-players='+e.coff+']').html(e.players)
	$('.x30__bet-users.x'+e.coff+' .x30__bet-user[data-user-id='+e.user_id+'] .x30__bet-sum span').html((Number(e.bet).toFixed(2))+'')
})

function betWheel(coff){
	if(window.BetOffWheel == 'off'){
		notification('error','Ставки закрыты, ждите следующий раунд')
		return undisable('.x30__bet-heading')
	}
	$.post('/wheel/bet',{_token: csrf_token, coff: coff, bet: $('#wheel_input').val()}).then(e=>{
		undisable('.x30__bet-heading')
		if(e.success){
			balanceUpdate(e.lastbalance, e.newbalance)
			notification('success',e.success)
		}
		if(e.error){      
			notification('error',e.error)
		}
	})
}

socket.on('X100_GET',e=>{
	startX100(e)
})


socket.on('X100_START',e=>{
	startX100(e)
})

socket.on('X100_START_BONUS',e=>{
	$('.x100 .wheel__x100-bonus-scroll').css('transition', '0s').css('transform', 'translateX(0px)')
	$('.x100 .bonusBlock').show();
	$('.TimerBlock').hide();
	$('.x100 .wheel__x100-bonus-scroll').html('')
	e.x100BonusAvatars.forEach((e)=>{

		$('.x100 .wheel__x100-bonus-scroll').append('<div class="x30__bonus-item x2 d-flex align-center justify-center" style="background: url('+e.img+') no-repeat center center / cover"></div>')

	})

	

	pxScrollX100Bonus = (56*48) - (Number($('.wheel__x100-bonus-x').width())/2) + rand(10, 40)
	setTimeout(() => $('.x100 .wheel__x100-bonus-scroll').css('transition', '10s').css('transform', 'translateX(-'+pxScrollX100Bonus+'px)'), 100);
	


}) 

socket.on('X100_CLEAR',e=>{
	$('.wheel__x100-winner').hide();
	

	$('#x100__text').html('Начало через');
	$('span[data-sumBetsX100]').html(0)
	$('span[data-playersX100]').html(0)
	$('.x100__bet-users').html('')
})


socket.on('X100_FINISH',e=>{

	// $('.bonusBlock').hide();
	// $('.betBlock').show();
	// $('.historyBlock').show();

	// $('.wheel__x100-winner').show();
	// $('.wheel__x100-winner b').html('x'+e.colorCoffResultX100)

	$('.wheel__bet-item-users').html('')
	$('.bonusBlock').hide();
	$('.TimerBlock').show();

	$('#x100__status').removeClass('x30__rocket--started');
	// updateBalance() 
	updateHistoryX100(e.history)
	$('.x100__bet-users').html('')
})

function startX100(e){

	if(e.x100Status == 1){
		$('#x100__text').html('Прокрутка');
		$('#x100__status').addClass('x30__rocket--started');
	}
	rotateW = e.x100Rotate - e.x100Plus - 180;
	$('#x100__wheel').css('transition', 'all '+e.x100Time+'s ease 0s').css('transform', 'rotate('+rotateW+'deg)')

	if(e.statusBonusX100 > 0){ 
		$('.x100 .wheel__x100-bonus-scroll').css('transition', '0s').css('transform', 'translateX(0px)')
		$('.bonusBlock').show();
		$('.bonusBlock').hide();
		$('.x100 .wheel__x100-bonus-scroll').html('')
		e.x100BonusAvatars.forEach((e)=>{

			$('.x100 .wheel__x100-bonus-scroll').append('<div class="wheel__x100-bonus-item" style="background: url('+e.img+') no-repeat center center / cover"></div>')

		})



		pxScrollX100Bonus = (56*48) - (Number($('.wheel__x100-bonus-x').width())/2) + rand(10, 40)
		$('.x100 .wheel__x100-bonus-scroll').css('transition', ''+(e.x100Time - 20)+'s')
		$('.x100 .wheel__x100-bonus-scroll').css('transform', 'translateX(-'+pxScrollX100Bonus+'px)');
	}
	
}

socket.on('X100_TIME',e=>{
	$('#x100__timer').html(e.time)
})



socket.on('laravel_database_updateX100Bet',e => {
	e = $.parseJSON(e)
	e = e.data	

	$('span[data-sumBetsX100='+e.coff+']').html((e.sumBets).toFixed(0))
	$('span[data-playersX100='+e.coff+']').html(e.players)
	$('.x100 .x100__bet-users.x'+e.coff+' .x30__bet-user[data-user-id='+e.user_id+'] .x30__bet-sum span').html((Number(e.bet).toFixed(2))+'')
})


function betX100(coff){
	$.post('/x100/bet',{_token: csrf_token, coff: coff, bet: $('#sumBetX100').val()}).then(e=>{
		undisable('.x30__bet-heading')
		if(e.success){
			balanceUpdate(e.lastbalance, e.newbalance)
			notification('success',e.success)
		}
		if(e.error){      
			notification('error',e.error)
		}
	})
}


function getHistoryGames() {
	$.post('/history/games',{_token: csrf_token}).then(e=>{     

		e.history.forEach((e)=>{  


			$(".gameHistory").prepend(' \
				<tr>\
				<td>\
				<div class="history__game d-flex align-center justify-center">\
				<svg class="icon"><use xlink:href="images/symbols.svg?v=5#'+e.icon_game+'"></use></svg>\
				<span>'+e.name_game+'</span>\
				</div>\
				</td>\
				<td>\
				<div class="history__user d-flex align-center justify-center">\
				<div class="history__user-avatar" style="    background: url('+e.avatar+') no-repeat center center / cover;"></div>\
				<span>'+e.name+'</span>\
				</div>\
				</td>\
				<td>\
				<div class="history__sum d-flex align-center justify-center">\
				<span>'+e.bet+'</span>\
				<svg class="icon money"><use xlink:href="images/symbols.svg#coins"></use></svg>\
				</div>\
				</td>\
				<td>\
				<div class="history__x d-flex align-center justify-center">\
				<div class="history__x-bg">'+((e.win / e.bet).toFixed(2))+'x</div>\
				<span>'+((e.win / e.bet).toFixed(2))+'x</span>\
				</div>\
				</td>\
				<td>\
				<div class="history__sum d-flex align-center justify-center">\
				<span>'+e.win+'</span>\
				<svg class="icon money"><use xlink:href="images/symbols.svg#coins"></use></svg>\
				</div>\
				</td>\
				</tr>');
		});
	});
}


getHistoryGames()
var SHOW = 0;
function typeShow(that){
	$("#all_systems").toggleClass('show')
	if(SHOW == 0){
		SHOW = 1;
		$(that).html('Свернуть')
	}else{
		SHOW = 0;
		$(that).html('Развернуть')
	}
}

function getHistoryJackpot(){
	$.post('/jackpot/all',{_token: csrf_token}).then(e=>{
		$('#history_jackpot').html('')
		e.jackpot.forEach((e)=>{  
			randomR = (e.random)
			randomR = randomR.replace(/""/g,"''")          	

			class_dop = ''
			if(e.user_id == USER_ID){
				class_dop = 'img_no_blur'
			}

			$('#history_jackpot').append("<tr><td class='text-secondary' >"+e.id+"</td>\
				<td class='text-secondary'><img src='"+e.avatar+"' class='avatar_user "+class_dop+"'></td>\
				<td class='text-secondary'>"+e.bet+"</td>\
				<td class='text-secondary'>"+e.win+"</td>\
				<td class='text-secondary'>	<form action='https://api.random.org/verify' method='post' target='_blank'>\
				<input type='hidden' name='format' value='json'>\
				<input type='hidden' name='random' value='"+randomR+"' >\
				<input type='hidden' name='signature' value='"+e.signature+"'>\
				<button class='btn-auth' style='width:45px;height45px;' onclick='$(`.btn_check_"+e.id+"`).click()'><img src='random.svg?v=1' style='width:25px;'></button> <button type='submite' class='btn_check_"+e.id+"' style='display:none' ></button>\
				</form></td></tr>\
				")


		});
	}); 
}

function updateHistory(e){
	$('.x30__history-scroll').html('')
	e.forEach((e)=>{
		randomR = (e.random)
		randomR = randomR.replace(/""/g,"''")
		$('.x30__history-scroll').append("<form action='https://api.random.org/verify' method='post' target='_blank'>\
			<input type='hidden' name='format' value='json'>\
			<input type='hidden' name='random' value='"+randomR+"' >\
			<input type='hidden' name='signature' value='"+e.signature+"'>\
			<div class='x30__history-item x"+e.coff+"' onclick='$(`.btn_check_"+e.id+"`).click()'></div> <button type='submite' class='btn_check_"+e.id+"' style='display:none' ></button>\
			</form>\
			")
	}) 
}

function updateHistoryX100(e){
	

	$('.x100__history-scroll').html('')
	e.forEach((e)=>{
		randomR = (e.random)
		randomR = randomR.replace(/""/g,"''")
		$('.x100__history-scroll').append("<form action='https://api.random.org/verify' method='post' target='_blank'>\
			<input type='hidden' name='format' value='json'>\
			<input type='hidden' name='random' value='"+randomR+"' >\
			<input type='hidden' name='signature' value='"+e.signature+"'>\
			<div class='x30__history-item x"+e.coff+"' onclick='$(`.btn_check_"+e.id+"`).click()'></div> <button type='submite' class='btn_check_"+e.id+"' style='display:none' ></button>\
			</form>\
			")
	}) 
}






function disable(that){
	$(that).css('pointer-events', 'none')
	$(that).attr('disabled', 'disabled')
}

function undisable(that){
	$(that).removeAttr('disabled', 'disabled')
	$(that).css('pointer-events', '')
}

function notification(type, mess){
	toastr[type](mess)
}

function chatScroll(){
	var div = $(".chat__messages .ss-wrapper .ss-content");
	div.scrollTop(div.prop('scrollHeight'));
}

function rotateBonusWheel(select, deg, time){
	$('.'+select).css('transition', time+'s').css('transform', 'rotate('+deg+'deg) ')
}

var options = {
	useEasing : true,
	useGrouping : true,
	separator : ',',
	decimal : 2,
	prefix : '',
	suffix : ''
};



function updateBalance(){
	$.post('/balance/get',{_token: csrf_token}).then(e=>{
		if(e.success){
			balanceUpdate($('#balance').attr('balance'), e.balance)      
		}

	});
}

function changeRepostBalance(){
	$.post('/repost/change',{_token: csrf_token}).then(e=>{
		if(e.success){
			$('#bonusBalance').html(0)
			notification('success', 'Вы успешно обменяли бонусный баланс на реальный')
			balanceUpdate($('#balance').attr('balance'), e.balance)      
		}else{
			notification('error', e.mess)
		}

	});

}

function changeRefBalance(){
	$.post('/refs/change',{_token: csrf_token}).then(e=>{
		if(e.success){
			$('#refBalance').html(0)
			notification('success', 'Вы успешно обменяли реферальный баланс на реальный')
			balanceUpdate($('#balance').attr('balance'), e.balance)      
		}else{
			notification('error', e.mess)
		}

	});
}
function animateNumber(first, second, time){
    $({numberValue: first}).animate({numberValue: second}, {
       duration: time,
       easing: "linear",
       step: function(val) {
          $('#balance').text(parseFloat(val).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, " "));
      }
  });
}

function balanceUpdate(lastbalance, balance, time = 250) {

	$('#balance').attr('balance', balance);
	animateNumber(lastbalance, balance, time)
	

}

function open_link(link){
	window.open(link)
}

function getBonusVk(that){
	$.post('/bonus/vk',{_token: csrf_token}).then(e=>{
		undisable(that)
		if(e.link){
			setTimeout(() => open_link(e.link), 1000);  
		}
		if(e.success){
			notification('success', e.mess)
			balanceUpdate(e.lastbalance, e.newbalance)      
		}else{
			notification('error', e.mess)
		}

	});
}

function getBonusRef(that){
	$.post('/bonus/ref',{_token: csrf_token}).then(e=>{

		if(e.success){
			$('#refs').html(e.refs)
			rotateBonusWheel('bonus__rotate', 0, 0)
			setTimeout(() => rotateBonusWheel('bonus__rotate', (e.rotate) - rand(10, 45), 10), 100); 
			setTimeout(() => notification('success', e.mess), 10000);     
			setTimeout(() => balanceUpdate(e.lastbalance, e.newbalance), 10000);      
			setTimeout(() => undisable(that), 10000);  
		}else{
			undisable(that)
			notification('error', e.mess)
		}

	});
}

// function copy(id) {
// 	var copyText = document.getElementById(id);
// 	copyText.select();
// 	document.execCommand("copy");
// }

function copyText(id) {
	var $temp = $("<input>");
	$("body").append($temp);
	$temp.val($('#'+id+'').text()).select();
	document.execCommand("copy");
	$temp.remove();
	toastr['info']('Cкопировано!')
	$('.btnCopy').text('Cкопировано!');
};

function checkTgConnect(that) {
	$.post('/bonus/checktg',{_token: csrf_token}).then(e=>{
		undisable(that)
		if(e.success){
			notification('success', e.mess)
			$('.close').click()    
		}else{
			notification('error', e.mess)
		}

	});
}
function getBonusTg(that) {
	$.post('/bonus/tg',{_token: csrf_token}).then(e=>{
		undisable(that)
		if(e.modal){
			showPopup('popup--tg')
		}
		if(e.success){
			notification('success', e.mess)
			balanceUpdate(e.lastbalance, e.newbalance)      
		}else{
			notification('error', e.mess)
		}

	});
}

function getBonus(that) {
	$.post('/bonus/get',{_token: csrf_token}).then(e=>{

		if(e.success){
			rotateBonusWheel('bonus__rotate', 0, 0)
			setTimeout(() => rotateBonusWheel('bonus__rotate', (e.rotate) - rand(10, 45), 10), 100); 
			setTimeout(() => notification('success', e.mess), 10000);     
			setTimeout(() => balanceUpdate(e.lastbalance, e.newbalance), 10000);   
			setTimeout(() => undisable(that), 10000);  
		}else{
			undisable(that)
			notification('error', e.mess)
		}

	});

}




function sendMess(that){
	$.post('/chat/send',{_token: csrf_token, message: $('#messageChat').val()}).then(e=>{
		undisable(that)
		if(e.success){
			$('#messageChat').val('')
			notification('success', 'Сообщение отправлено')
		}else{
			notification('error', e.mess)
		}
	});
}
function sendSticker(sticker, that){
	$.post('/chat/sendsticker',{_token: csrf_token, sticker}).then(e=>{
		undisable(that)
		if(e.success){

			$('.panel_stickers').removeClass('open')
		}else{
			notification('error', e.mess)
		}
	});
}
function checkStatus(id, that){
	$.post('/deposit/checkstatus',{_token: csrf_token, id}).then(e=>{
		undisable(that)
		if(e.success){
			updateBalance()
			notification('success', 'Вы успешно пополнили баланс')
			$('.close').click()
		}else{
			notification('error', e.mess)
		}
	});
}

function createPromoUser(that) {
	$.post('/promo/create',{_token: csrf_token, name: $('#name_crpromo').val(), sum: $('#sum_crpromo').val(), act: $('#act_crpromo').val()}).then(e=>{
		undisable(that)
		if(e.success){
			balanceUpdate(e.lastbalance, e.newbalance)
			notification('success', 'Вы успешно создали промокод') 
			close_modal()
		}else{
			notification('error', e.mess)
		}
	}); 
}

function goTransfer(that) {
	$.post('/transfer/go',{_token: csrf_token, id: $('#trans_id').val(), sum: $('#trans_sum').val()}).then(e=>{
		undisable(that)
		if(e.success){
			balanceUpdate(e.lastbalance, e.newbalance)
			notification('success', 'Вы успешно перевели средства') 
			close_modal()
		}else{
			notification('error', e.mess)
		}
	}); 
}
function getUserTransfer(that) {
	$.post('/transfer/getuser',{_token: csrf_token, id: $('#id_transfer').val()}).then(e=>{
		undisable(that)
		if(e.success){
			$('#avatar_transfer').attr('src', e.avatar)
			$('#trans_id').val(e.id)
			show_modal('transfer')    
		}else{
			notification('error', e.mess)
		}
	}); 
}

function actPromo(that){
	var cap = $('#captcha > iframe').attr('data-hcaptcha-response')
	if (cap == ''){
		notification('error','Пройдите капчу')
		undisable(that)
		return false;
	}

	$.post('/promo/act',{_token: csrf_token, name: $('#promo_name').val()}).then(e=>{
		undisable(that)
		if(e.success){
			balanceUpdate(e.lastbalance, e.newbalance)
			notification('success', 'Промокод успешно активирован')
			$('#promo_name').val('')
			captcha_r()

		}else{
			notification('error', e.mess)
			captcha_r()
		}
	}); 
}

function canselWithdraw(id, that) {
	$.post('/withdraw/cansel',{_token: csrf_token, id}).then(e=>{
		undisable(that)
		if(e.success){
			balanceUpdate(e.lastbalance, e.newbalance)
			notification('success', 'Вывод успешно отменен')
			$('#statusW_'+id+' span').html('Отменен')
			$('#statusW_'+id).removeClass('warning').addClass('error')

		}else{
			notification('error', e.mess)
		}
	}); 
}

function goWithdraw(that) {
	$.post('/withdraw/go',{_token: csrf_token, sum: Number($('#sum_withdraw').val()), system: $('#systemW').val(), wallet: $('#wallet_withdraw').val()}).then(e=>{
		undisable(that)
		if(e.success){
			balanceUpdate(e.lastbalance, e.newbalance)
			notification('success', 'Средства успешно поставлены на вывод. Время ожидания от 5 минут до 24 часов')
			
			$('.wallet__history--withdraw').prepend('<div class="wallet__history-item d-flex justify-space-between align-center">\
                    <div class="wallet__history-left d-flex align-center">\
                        <div class="wallet__method d-flex align-center">\
                            <img src="'+e.withdraw.img_system+'">\
                            <span>'+e.withdraw.ps+'</span>\
                        </div>\
                        <div class="wallet__history-sum d-flex align-center">\
                            <span>'+e.withdraw.sum+'</span>\
                            <svg class="icon money"><use xlink:href="images/symbols.svg#coins"></use></svg>\
                        </div>\
                    </div>\
                    <div id="statusW_'+e.withdraw.id+'" class="wallet__history-status  warning">\
                        <span >Ожидание... (<a onclick="disable(this);canselWithdraw('+e.withdraw.id+', this)">Отменить</a>)</span>\
                    </div>\
                </div>')
		}else{
			notification('error', e.mess)
		}
	}); 
}

function goDeposit(that) {
	$.post('/deposit/go',{_token: csrf_token, sum: Number($('#sumDep').val()), system: $('#systemDep').val(), promo: $('#promoDep').val()}).then(e=>{
		undisable(that)
		if(e.success){

			if(e.modal == 0){
				notification('success', 'Перенаправляем на оплату')
				location.href = e.link
			}else{
				transfer = e.transfer
				amount_to = transfer.amount_to
				wallet_to = transfer.wallet_to
				comment_to = transfer.comment_to
				order_id = transfer.order_id
				img = e.img
				// $('#img_pay').attr('src', img)
				$('#wallet_pay').html(wallet_to)
				$('#comment_pay').html(comment_to)
				$('#sum_pay').html(amount_to)
				$('#check_pay').attr('onclick', 'disable(this);checkStatus('+order_id+', this)')
				showPopup('popup--refill')
			}

		}else{
			notification('error', e.mess)
		}
	});
}

function open_panel_smiles() {
	$(".panel_smiles").toggleClass('open');  
	$(".panel_stickers").removeClass('open');  
} 

function open_panel_stickers(){
	$(".panel_stickers").toggleClass('open');  
	$(".panel_smiles").removeClass('open');  
}

function addSmileInChat(smile){
	$("#messageChat").val($("#messageChat").val() +' '+smile)
}
$(document).ready(function(){ 
	$('img').attr('draggable', "false") 
	$('.logo').css('pointer-events', "auto")       
  $(".click_pp").click(function(){ // задаем функцию при нажатиии на элемент <button>
      $(".btn_open_close_prof").toggleClass('active'); // вызываем событие click на элементе <div>
  });

   $(".btn_open_close_prof").focusout(function(){ // задаем функцию при потере фокуса элементом  <div>, или любым вложенным элементо
	     $(".btn_open_close_prof").removeClass('active'); // устанавливаем элементу <div> цвет заднего фона зеленый
	 });
    $("#messageChat").focus(function(){ // задаем функцию при потере фокуса элементом  <div>, или любым вложенным элементо
	     $(".panel_smiles").removeClass('open'); // устанавливаем элементу <div> цвет заднего фона зеленый
	     $(".panel_stickers").removeClass('open'); 
	     
	 });

  $(".chat_btn").click(function(){ // задаем функцию при нажатиии на элемент <button>
  	$(".col-chat-lg").toggleClass('open'); 
  	$(".chat_btn").toggleClass('active');
  	chatScroll()
  });

  $(".more_btn").click(function(){ // задаем функцию при нажатиии на элемент <button>
  	$(".panel_more").toggleClass('open'); 
  	$(".more_btn").toggleClass('active');
  });

   $(".bets_btn").click(function(){ // задаем функцию при нажатиии на элемент <button>
   	$(".panel_bets").toggleClass('open'); 
   	$(".bets_btn").toggleClass('active');
   });


   



});


function AddSmile(id){
	var text = $.trim($(".chat__input input").val());
	$(".chat__input input").focus().val(text + ' :smile_' + id + ': ');
};

function changeBalance(type, that) {
	$.post('/change/balance',{_token: csrf_token, type}).then(e=>{
		if(e.success){
			$('.dice__select-chance a').removeClass('active')
			$(that).addClass('active')
			localStorage.setItem('balance', type);
			balanceUpdate(0, e.balance)
			$('#demoPanel').hide();
			if(type == 1){
				$('#demoPanel').show();
			}
		}else{
			notification('error', e.mess)
		}
	});
}

function addDemoBalance(){
	$.post('/add/demobalance',{_token: csrf_token, addbalance: $('#add_balance').val()}).then(e=>{
		if(e.success){
			balanceUpdate($('#balance').attr('balance'), e.balance)
			$('.close').click();
			notification('success', 'Демо баланс успешно пополнен')
		}else{
			notification('error', e.mess)
		}
	});
}


var typeDice = 'minPlay'
function changeDice(type, that){
	typeDice = type
	updateDiceCoeff()
	$('.dice__select-chance a').removeClass('active')
	$(that).addClass('active')
}

function diceRange(){
	value = $('.dice__range').val()

	val_pos = value
	pos = 'right'
	if (typeDice == 'maxPlay'){
		val_pos = 100 - value
		pos = 'left'
	} 
	if(val_pos > 95){
		return $('.range_dice').val(5);
	}
	if(val_pos < 1){
		return $('.range_dice').val(100);
	}
	$('#PercentDice').val(Number(val_pos).toFixed(2))
	$('#CoeffDice').val(Number(100 / val_pos).toFixed(2))
	$('.dice__range').css( 'background', 'linear-gradient(to '+pos+', #7C79FF 0%, #7C79FF '+val_pos +'%, #DFDEEF ' + val_pos + '%, #DFDEEF 100%)' );
	updateDiceBet()
}

function updateDicePercent(){
	percent = $('#PercentDice').val()
	if(percent > 95){
		$('#PercentDice').val('95.00')
		percent = 95
	}
	if(percent < 1){
		$('#PercentDice').val('1.00')
		percent = 1
	}
	coeff = 100 / percent
	val_pos = percent
	pos = 'right'
	if (typeDice == 'maxPlay'){ 
		val_pos = 100 - percent
		pos = 'left'
	} 
	value = percent
	$('.dice__range').css( 'background', 'linear-gradient(to '+pos+', #7C79FF 0%, #7C79FF '+value +'%, #DFDEEF ' + value + '%, #DFDEEF 100%)' );
	$('.dice__range').val(val_pos);
	$('#CoeffDice').val(Number(coeff).toFixed(2))
	updateDiceBet()
}

function updateDiceCoeff(){
	coeff = Number($('#CoeffDice').val())

	if(coeff > 100){
		coeff = 100
		$('#CoeffDice').val('100.00')
	}
	if(coeff < 1.05){
		coeff = 1.05
		$('#CoeffDice').val('1.05')
	}
	percent = 100 / coeff
	pos = 'right'
	val_pos = percent
	if (typeDice == 'maxPlay'){
		val_pos = 100 - percent
		pos = 'left'
	} 
	value = percent


	$('.dice__range').css( 'background', 'linear-gradient(to '+pos+', #7C79FF 0%, #7C79FF '+percent +'%, #DFDEEF ' + percent + '%, #DFDEEF 100%)' );
	$('.dice__range').val(val_pos);

	if(coeff == 1.05){
		$('#PercentDice').val(Number(95).toFixed(2))
		return updateDiceBet()
	}
	$('#PercentDice').val(Number(percent).toFixed(2))
	return updateDiceBet()
}

function updateDiceWin(){
	win = $('#WinDice').val()
	percent = $('#PercentDice').val()
	coeff = 100 / percent
	bet = (win / coeff).toFixed(2)
	$('#BetDice').val(bet)
}

function updateDiceBet(){
	bet = $('#BetDice').val()
	percent = $('#PercentDice').val()
	coeff = 100 / percent
	win = (bet * coeff).toFixed(2)
	$('#WinDice').val(win)
}

function rand(min, max) {
	return Math.floor(Math.random() * (max - min)) + min;
}

function  playDice(that, type = typeDice) {
	$('#checkDice').hide()
	$.post('/dice/play',{_token: csrf_token, type, bet: $('#BetDice').val(),  percent: $('#PercentDice').val()}).then(e=>{
		undisable(that)
		if(e.success){
			$('#checkDice').show()
			balanceUpdate(e.lastbalance, e.newbalance)

			if(type == 'minPlay'){
				chance = '< '+$('#PercentDice').val()
			}else{
				chance = '> '+Number(100 - $('#PercentDice').val()).toFixed(2)
			}
			$('#dice_bet').html($('#BetDice').val())
			$('#dice_win').html(e.win.toFixed(2))
			$('#dice_coeff').html('x'+((100 / Number($('#PercentDice').val())).toFixed(2)))
			$("#chanse_dice").html(chance)
			$('#salt2_dice').html(e.salt2); 
			$('#full_dice').html(e.full_string);
			$('#hash_dice').html(e.hash);
			$('#salt1_dice').html(e.salt1);
			$('#number_dice').html(e.number);


			$('#dice__result').removeClass('dice__drum--win dice__drum--lose');
			$('#dice__result').addClass('dice__drum--'+e.type+'');

			$('.dice__check-result').removeClass('dice__check-result--lose dice__check-result--win')
			$('.dice__check-result').addClass('dice__check-result--'+e.type+'')
			var result = ['win', 'lose'],
			chances = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];

			var height = $('.dice__slider-inner .dice__slider-item').length,
			one = $('.dice__slider-inner .dice__slider-item')[0].offsetHeight;

			number = Number(e.number).toFixed(2)
			var n = (number).split('.');

			if(n[0] < 10){
				n[0] = '0'+n[0]
			} 
			if(n[1] < 10){
				n[1] = n[1]+'0'
			}

			$('#dice_n_1_check').html(n[0][0])
			$('#dice_n_2_check').html(n[0][1])
			$('#dice_n_3_check').html(n[1][0])
			$('#dice_n_4_check').html(n[1][1])

			$('#dice_n_1').css({'transform':'translateY(-'+ one * n[0][0] +'px)'});
			$('#dice_n_2').css({'transform':'translateY(-'+ one * n[0][1] +'px)'});
			$('#dice_n_3').css({'transform':'translateY(-'+ one * n[1][0] +'px)'});
			$('#dice_n_4').css({'transform':'translateY(-'+ one * n[1][1] +'px)'});


		}else{
			notification('error', e.mess)
		}
	});




}




function close_modal(){
	$('.modal_body').fadeOut('fast')
	$('.modal_panel').fadeOut('fast')
}

function show_modal(modal){
	$('.modal_body').fadeIn('fast')
	$('.modal_panel').hide()
	$('.modal_'+modal+'').fadeIn('fast')
} 

function changeMethod(that, id, min_dep, type, comm_percent, comm_rub) {
	$('#id_method').val(id)
	$('#min_sum_'+type).html(min_dep)
	$('.method_block_pay').removeClass('active')
	$(that).addClass('active')
	$('#comm_percent').val(comm_percent)
	$('#comm_rub').val(comm_rub)
	if(type == 'withdraws' && Number(comm_rub) > -1){
		sum = $('#sum_withdraw').val()
		sum_get = sum - (sum * (comm_percent / 100))
		sum_get = sum_get - comm_rub
		$('#get_withdraw').val(sum_get)
	}
}

function updateW() {
	sum = $('#sum_withdraw').val()
	comm_rub = $('#comm_rub').val()
	comm_percent = $('#comm_percent').val()
	sum_get = sum - (sum * (comm_percent / 100))
	sum_get = sum_get - comm_rub
	$('#get_withdraw').html(sum_get)
}


function checkDice(){
	show_modal('check_dice')
}

function checkMine(){
	show_modal('check_mine') 
}



$(window).on('load', function () {
	$('.preloader').addClass("preloader-remove");     
});

function createMinePole(mines) {
	$('.mines__bomb.Bomb').html('')
	$('.mines__bomb.Bomb').append('<a href="#" class="bomb_3" onclick="$(`#BombMines`).val(3);$(`.mines__bomb.Bomb a`).removeClass(`mines__bomb--active`);$(this).addClass(`mines__bomb--active`);updateMinesXNew()">3</a>')
	$('.mines__bomb.Bomb').append('<a href="#" class="bomb_5" onclick="$(`#BombMines`).val(5);$(`.mines__bomb.Bomb a`).removeClass(`mines__bomb--active`);$(this).addClass(`mines__bomb--active`);updateMinesXNew()">5</a>')
	$('.mines__bomb.Bomb').append('<a href="#" class="bomb_'+Number((mines / 2).toFixed(0) - 3)+'" onclick="$(`#BombMines`).val('+Number((mines / 2).toFixed(0) - 3)+');$(`.mines__bomb.Bomb a`).removeClass(`mines__bomb--active`);$(this).addClass(`mines__bomb--active`);updateMinesXNew()">'+Number((mines / 2).toFixed(0) - 3)+'</a>')
	$('.mines__bomb.Bomb').append('<a href="#" class="bomb_'+Number(mines  - 1)+'" onclick="$(`#BombMines`).val('+Number(mines  - 1)+');$(`.mines__bomb.Bomb a`).removeClass(`mines__bomb--active`);$(this).addClass(`mines__bomb--active`);updateMinesXNew()">'+Number(mines  - 1)+'</a>')
	


	$('.mines__path').html('').removeClass('level_16 level_25 level_36 level_49').addClass('level_'+mines+'')
	
	
	$('.mines__bomb.Level a').removeClass('mines__bomb--active')
	$('.mines__bomb.Level a.level_'+mines).addClass('mines__bomb--active')
	n = Math.sqrt(mines)
	for (var i = 0; i < mines; i++) {
		$('.mines__path').append('<div class="mines__path-item d-flex align-center justify-center" onclick="disable(this);$(`.mine`).addClass(`no_select`);clickMineNew(this, '+Number(i + 1)+')">\
			<svg class="mines__path--lose icon"><use xlink:href="images/symbols.svg#close"></use></svg>\
			<svg class="mines__path--win icon"><use xlink:href="images/symbols.svg#check"></use></svg>\
			</div>')
		// $('.minesPoleCheck').append('<div class="mine mine_check" onclick="disable(this);$(`.mine`).addClass(`no_select`);clickMineNew(this, '+Number(i + 1)+')"><img class="mine_img win hide" src="img/mine_img_win.png" ><img class="mine_img lose hide" src="img/mine_img_lose.png" ></div>')

	}

	updateMinesXNew()
}

function updateLevel(){
	level = $('#LevelMines').val();
	createMinePole(level)


}



function updateMinesXNew(){
	$('.mines__scroll').html('')
	$('.mines__bomb.Bomb a').removeClass('mines__bomb--active')
	BombMines = Number($('#BombMines').val())
	$('.mines__bomb.Bomb a.bomb_'+BombMines).addClass('mines__bomb--active')
	level = $('#LevelMines').val();
	for(let i = 0; i< level - BombMines; i++){
		coeffMine = getCoffNew(BombMines, i+1, level)
		win = coeffMine * Number($('#BetMines').val())
		$('.mines__scroll').append('<div class="mines__x-item">\
			<p class="d-flex align-center justify-space-between">'+Number(i + 1)+' ход <span>'+coeffMine.toFixed(2)+'x</span></p>\
			<b>'+win.toFixed(2)+'</b>\
			</div>')
	}
}

function startGameMineNew(that){
	$('#checkMine').hide();
	$.post('/newmines/start',{_token: csrf_token,level: $('#LevelMines').val(), bet: Number($('#BetMines').val()), bomb: Number($('#BombMines').val())}).then(e=>{
		if(e.success){

			$('.win_mine_block').hide()
			undisable('.mines__path-item')
			$('.mines__path-item').removeClass('mines__path-item--lose mines__path-item--win')
			disable('#BetMines')
			disable('#BombMines')
			disable('.btn_mine_bomb')
			disable('.btn_mine_level')
			notification('success', 'Игра началась!')
			$('.start_block_mine').hide()
			$('.play_block_mine').show()
			$('.mines__x-item').removeClass('active')
			$('.mines__x-item:eq(0)').addClass('mines__x-item--win')
			$('.mines__scroll').stop().animate({
				scrollLeft: `0px`
			}, 800);


			balanceUpdate(e.lastbalance, e.newbalance)


			if(e.bonus == 1){
				notification('success', 'Бонусная игра!')
				$('.mines__bonus .x30__bonus-scroll').css({'transition':'0s','transform':'translateX(0px)'})

				$('.mines__bonus .x30__bonus-scroll').html('')
				$('.mines__bonus').show()

				disable('.start_block_mine a')
				disable('.play_block_mine a')

				e.ikses.forEach((e)=>{
					$('.mines__bonus .x30__bonus-scroll').append('<div class="x30__bonus-item x30 d-flex align-center justify-center">x'+e+'</div>')

				})	

				x = (56*43) - (Number($('.mines__bonus').width())/2) + rand(10, 40)


				betMine = Number($('#BetMines').val())
				betNew = betMine * e.bonusMine
				betNew = betNew.toFixed(2)			
				disable('.mines__path-item')

				setTimeout(() => $('.mines__bonus .x30__bonus-scroll').css({'transition':'10s','transform':'translateX(-'+x+'px)'}), 200);
				setTimeout(() => $('#BetMines').val(betNew),10000);
				setTimeout(() => undisable('.mines__path-item'),10000);
				setTimeout(() => notification('success', 'Поздравляем! Ваша ставка умножилась на '+e.bonusMine),10000);
				setTimeout(() => updateMinesXNew(),10000);
				setTimeout(() => undisable('.start_block_mine a'),10000);
				setTimeout(() => undisable('.play_block_mine a'),10000);
			}
		}else{
			undisable(that)
			notification('error', e.mess)
		}

	});
}

function finishGameMineNew(that){
	$.post('/newmines/finish',{_token: csrf_token}).then(e=>{
		$('.mine').removeClass('no_select')
		undisable('.mine')
		undisable(that)
		if(e.success){
			balanceUpdate(e.lastbalance, e.newbalance)
			undisable('#BetMines')
			undisable('#BombMines')
			undisable('.mines__bomb a')

			undisable('.start_block_mine a')
			undisable('.play_block_mine a')
			$('.start_block_mine').show()
			$('.play_block_mine').hide()
			$('#winMine').html('0.00')
			game = e.game
			$('#checkMine').show();
			notification('success' , 'Вы выиграли ' +Number(game.win).toFixed(2))
			$('.sumWinText').html(Number(game.win).toFixed(2));
			$('.win_mine_block').show()

			mines = JSON.parse(game.mines)
			mines.forEach(function(item, i, arr) {
				num = item - 1
				// $('.mine:eq('+num+')').children('.mine_img.lose').removeClass('hide').addClass('animate')
				$('.mines__x-item:eq('+num+')').addClass('mines__x-item--lose')

				// $('.mine_check:eq('+num+')').children('.mine_img.lose').removeClass('hide').addClass('animate')
				// $('.mine_check:eq('+num+')').addClass('animate')

			});
			$('.mines__bonus').hide()
			betMine = Number($('#BetMines').val())
			betNew = betMine / game.bonusMine
			betNew = betNew.toFixed(2)	
			$('#BetMines').val(betNew)
			updateMinesXNew()

			$("#full_mine").html(game.full_string)
			$("#hash_mine").html(game.hash)
			$("#salt1_mine").html(game.salt1)
			$("#number_mine").html(game.pole_hash)
			$("#salt2_mine").html(game.salt2)
			undisable('.btn_mine_level')
			$("#mine_bet").html(game.bet.toFixed(2))
			$("#mine_win").html(Number(game.win).toFixed(2))
			$("#mine_coeff").html(((game.win) / (game.bet)).toFixed(2))
			$('#checkMine').show();

		}else{
			undisable('.mines__path-item')
			notification('error', e.mess)
		}

	});
}

function autoClickMineNew(that){
	$.post('/newmines/autoclick',{_token: csrf_token}).then(e=>{
		undisable(that)
		if(e.success){
			num = e.num - 1
			$('.mine').removeClass('no_select')
			clickMineNew('.mines__path-item:eq('+num+')', e.num)
		}else{
			notification('error', e.mess)
		}

	});
}

function clickMineNew(that, mine){

	$.post('/newmines/click',{_token: csrf_token, mine}).then(e=>{
		$('.mine').removeClass('no_select')
		undisable('.mine')
		if(e.success){      
			if(e.type == 'lose'){
				undisable('#BetMines')
				undisable('#BombMines')
				undisable('.mines__bomb a')
				undisable('.start_block_mine a')
				undisable('.play_block_mine a')


				$('.start_block_mine').show()
				$('.play_block_mine').hide()
				$('#winMine').html('0.00')
				game = e.game
				mines = JSON.parse(game.mines)
				mines.forEach(function(item, i, arr) {
					num = item - 1
					$('.mines__path-item:eq('+num+')').addClass('mines__path-item--lose')

					// $('.mine_check:eq('+num+')').children('.mine_img.lose').removeClass('hide').addClass('animate')
					// $('.mine_check:eq('+num+')').addClass('animate')

				});
				$(that).addClass('mine_lose')
				$('.mine_check:eq('+(mine - 1)+')').addClass('mine_lose')

				$('.mines__bonus').hide()
				betMine = Number($('#BetMines').val())
				betNew = betMine / game.bonusMine
				betNew = betNew.toFixed(2)	
				$('#BetMines').val(betNew)
				updateMinesXNew()

				$("#full_mine").html(game.full_string)
				$("#hash_mine").html(game.hash)
				$("#salt1_mine").html(game.salt1)
				$("#number_mine").html(game.pole_hash)
				$("#salt2_mine").html(game.salt2)

				$("#mine_bet").html(game.bet.toFixed(2))
				$("#mine_win").html('0.00')
				$("#mine_coeff").html(((game.win) / (game.bet)).toFixed(2))
				$('#checkMine').show();


			}else{
				if(e.gameOff == 1){
					finishGameMineNew('.play_block_mine')
				}
				game = e.game
				step = game.step
				$('.mines__x-item').removeClass('mines__x-item--win')
				$('.mines__x-item:eq('+step+')').addClass('mines__x-item--win')

				$('.mines__scroll').stop().animate({
					scrollLeft: `${ (step - 0) * 160 }px`
				}, 800);



				
				$(that).addClass('mines__path-item--win')

				num = mine - 1
				// $('.mine_check:eq('+num+')').children('.mine_img.win').removeClass('hide').addClass('animate')
				// $('.mine_check:eq('+num+')').addClass('animate mine_win')
				$('#winMine').html(Number(game.win).toFixed(2))
			}
		}else{
			undisable(that)
			notification('error', e.mess)
		}

	});
}

function getGameMineNew(){
	$.post('/newmines/get',{_token: csrf_token}).then(e=>{
		if(e.success){
			disable('#BetMines')
			disable('#BombMines')

			disable('.btn_mine_level')
			game = e.game
			$('#LevelMines').val(game.level)
			$('#winMine').html(Number(game.win).toFixed(2))
			$('#BetMines').val(Number(game.bet).toFixed(2))
			$('#BombMines').val(Number(game.num_mines))

			createMinePole(game.level)
			disable('.mines__bomb a')
			

			$('.start_block_mine').hide()
			$('.play_block_mine').show()

			step = game.step
			$('.mines__x-item').removeClass('mines__x-item--win')
			$('.mines__x-item:eq('+step+')').addClass('mines__x-item--win')
			$('.mines__scroll').stop().animate({
				scrollLeft: `${ (step - 0) * 160 }px`
			}, 800);




			click = JSON.parse(game.click)
			click.forEach(function(item, i, arr) {
				num = item - 1
				$('.mines__path-item:eq('+num+')').addClass('mines__path-item--win')

				// $('.mine_check:eq('+num+')').children('.mine_img.win').removeClass('hide').addClass('animate')
				// $('.mine_check:eq('+num+')').addClass('animate mine_win')

			});


			if(game.bonusMine > 1){
				
				x = (56*43) - (Number($('.mines__bonus').width())/2) + rand(10, 40)
				$('.mines__bonus .x30__bonus-scroll').css({'transition':'0s','transform':'translateX(-'+x+'px)'})

				$('.mines__bonus .x30__bonus-scroll').html('')
				$('.mines__bonus').show()

				bonusIkses = JSON.parse(game.bonusIkses)
				
				bonusIkses.forEach((e)=>{
					$('.mines__bonus .x30__bonus-scroll').append('<div class="x30__bonus-item x30 d-flex align-center justify-center">x'+e+'</div>')

				})	

				



			} 

		}else{
			$('.start_block_mine').show()
		}

	});
}

function getCoffNew(count, steps, mines){
	var coeff = 1;
	for(var i = 0; i < (mines - count) && steps > i; i++) {
		coeff *= ((mines - i) / (mines - count - i));
	}
	return coeff;
}

function betJackpot(that){

	$.post('/jackpot/bet',{_token: csrf_token, bet: $('#inputJackpot').val()}).then(e=>{
		undisable(that)
		if(e.success){
			$('#inputCashHuntBet').val(e.sumBetUser)
			balanceUpdate(e.lastbalance, e.newbalance)
			notification('success',e.success)
		}
		if(e.error){      
			notification('error',e.error)
		}
	}).fail(e=>{
		undisable(that)
		// e = JSON.stringify(e)
		notification('error',JSON.parse(e.responseText).message)
	})
}

function hexToRgb(hex) {
	var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
	return result ? {
		r: parseInt(result[1], 16),
		g: parseInt(result[2], 16),
		b: parseInt(result[3], 16)
	} : null;
}

function addInPlayers(players){
	$('.usersCount').html(players.length)
	players.forEach((e)=>{

		class_dop = ''
		if(e.user_id == USER_ID){
			class_dop = 'img_no_blur'
		}

		$('.chancesJackpot').prepend("<div style='width:"+e.chance+"%;background:#"+e.color+"'></div>")
		$('.usersJackpot').prepend(' <div class="userJackpot" data-user_id="'+e.user_id+'">\
			<center>\
			<img src="'+e.img+'" class="userJackpotAva '+class_dop+'">\
			<div class="userJackpotPercent">'+(e.chance).toFixed(2)+'%</div>\
			</center>\
			</div>')

	})
}



function addInBets(jackpot){
	jackpot.forEach((e)=>{
		if(e.user_id == USER_ID){
			$('.chanceUser').html(e.chance.toFixed(2)+'%')
		}

		color = hexToRgb("#"+e.color+"")
		$('.bankGame').text((Number($('.bankGame').html()) + Number(e.bet)).toFixed(0))
		percent_circle = 290 + 25 - ((e.chance).toFixed(0) * 290 / 100)
		cashHuntCoeff = e.cashHuntCoeff

		if(cashHuntCoeff == 0){
			cashHuntCoeff = ''
		}else{
			cashHuntCoeff = '<span style="color:#706bf6">(x'+cashHuntCoeff+')</span>'
		}

		class_dop = ''
		if(e.user_id == USER_ID){
			class_dop = 'img_no_blur'
		}


		$('.betsJackpot').prepend('<div class="betJackpot" data-user_id="'+e.user_id+'">\
			<div class="flex no_padding wrap">\
			<div class="col-5">\
			<img src="'+e.img+'" class="betJackpotAva '+class_dop+'">\
			<div class="betUser">\
			<span class="nameBetUser">'+(e.login).split(' ')[0]+'</span>\
			<div class="sumBetUser">'+(e.bet).toFixed(0)+' <svg class="coinsBlackJ" ><use xlink:href="img/main/symbols.svg?v=34#coins"></use></svg> '+cashHuntCoeff+'</div>\
			</div>\
			</div>\
			<div class="col-5" style="text-align: right;">\
			<div class="ticketsBetUser" style="text-align: left;">\
			<span class="nameTicket">Билеты</span>\
			<div class="ticketNum" style="color: #9594C6">'+e.tick_one+' - '+e.tick_two+'</div>\
			</div>\
			<div class="percentBetUser" style="position: relative;background: rgba('+color.r+', '+color.g+', '+color.b+', 0.1);">\
			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="position: absolute;top:0;left: 0;" width="50px" height="50px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">\
			<circle stroke-linecap="round"  cx="50" cy="50" r="47" stroke="rgba('+color.r+', '+color.g+', '+color.b+', 1)" stroke-width="6" fill="none" stroke-dasharray="315" stroke-dashoffset="'+percent_circle+'" stroke-mitterlimit="0" transform="rotate(-90 ) translate(-100 0)" />\
			</svg>\
			<div class="percentTextUser" style="color: rgba('+color.r+', '+color.g+', '+color.b+', 1)">'+(e.chance).toFixed(0)+'%</div>\
			\
			</div>\
			\
			\
			</div>\
			\
			\
			</div>\
			</div>')

	})
}

socket.on('JACKPOT_TIME',e => {
	
	percent_time = 100 * e.time / 30
	$('.progress_jackpot').css('width', percent_time+'%')
	$('.timeJackpot').text(e.time)
})

socket.on('laravel_database_jackpotUpdateChance',e => {
	e = $.parseJSON(e)
	const bet = e
	$('.usersJackpot').html('')
	$('.chancesJackpot').html('')
	console.log(bet)
	$('.usersCount').html(bet.length)
	for(let i=0;i<bet.length;i++){
		if(bet[i].user_id == USER_ID){
			$('.chanceUser').html(bet[i].chance.toFixed(2)+'%')
		}

		percent_circle = 290 + 25 - ((bet[i].chance).toFixed(0) * 290 / 100)
		
		$('.betJackpot[data-user_id="'+bet[i].user_id+'"] .percentTextUser').text(bet[i].chance.toFixed(0)+'%')
		$('.betJackpot[data-user_id="'+bet[i].user_id+'"] .percentBetUser svg circle').attr('stroke-dashoffset', percent_circle)
		$('.chancesJackpot').prepend("<div style='width:"+bet[i].chance+"%;background:#"+bet[i].color+"'></div>")

		class_dop = ''
		if(bet[i].user_id == USER_ID){
			class_dop = 'img_no_blur'
		}


		$('.usersJackpot').prepend(' <div class="userJackpot" data-user_id="'+bet[i].user_id+'">\
			<center>\
			<img src="'+bet[i].img+'" class="userJackpotAva '+class_dop+'">\
			<div class="userJackpotPercent">'+(bet[i].chance).toFixed(2)+'%</div>\
			</center>\
			</div>')
	}
})
socket.on('laravel_database_jackpotUpdateBet',e => {
	e = $.parseJSON(e)
	$('.betsJackpot').html('')
	addInBets(e.jackpot)
	e.info.forEach((e)=>{
		userid = e.user_id
		if(userid == USER_ID){
			bet = e.bet
			$('#inputCashHuntBet').val(bet)
		}
	})
})
socket.on('laravel_database_jackpotBet',e => {
	e = $.parseJSON(e)
	e = e.date
	$('.JackpotPlay').show();
	$('.waitJackpot').hide();
	$('.bankGame').text((Number($('.bankGame').html()) + Number(e.bet)).toFixed(0))
	


	color = hexToRgb("#"+e.color+"")

	class_dop = ''
	if(e.user_id == USER_ID){
		class_dop = 'img_no_blur'
	}

	percent_circle = 290 + 25 - (Number(e.chance).toFixed(0) * 290 / 100)
	$('.betsJackpot').prepend('<div class="betJackpot" data-user_id="'+e.user_id+'">\
		<div class="flex no_padding wrap">\
		<div class="col-5">\
		<img src="'+e.img+'" class="betJackpotAva '+class_dop+'">\
		<div class="betUser">\
		<span class="nameBetUser">'+(e.login).split(' ')[0]+'</span>\
		<div class="sumBetUser">'+Number(e.bet).toFixed(0)+' <svg class="coinsBlackJ" ><use xlink:href="img/main/symbols.svg?v=34#coins"></use></svg> </div>\
		</div>\
		</div>\
		<div class="col-5" style="text-align: right;">\
		<div class="ticketsBetUser" style="text-align: left;">\
		<span class="nameTicket">Билеты</span>\
		<div class="ticketNum" style="color: #9594C6">'+e.tickets[0]+' - '+e.tickets[1]+'</div>\
		</div>\
		<div class="percentBetUser" style="position: relative;background: rgba('+color.r+', '+color.g+', '+color.b+', 0.1);">\
		<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="position: absolute;top:0;left: 0;" width="50px" height="50px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">\
		<circle stroke-linecap="round"  cx="50" cy="50" r="47" stroke="rgba('+color.r+', '+color.g+', '+color.b+', 1)" stroke-width="6" fill="none" stroke-dasharray="315" stroke-dashoffset="315" stroke-mitterlimit="0" transform="rotate(-90 ) translate(-100 0)" />\
		</svg>\
		<div class="percentTextUser" style="color: rgba('+color.r+', '+color.g+', '+color.b+', 1)">'+(e.chance).toFixed(0)+'%</div>\
		\
		</div>\
		\
		\
		</div>\
		\
		\
		</div>\
		</div>')

	$('.betJackpot[data-user_id="'+e.user_id+'"] .percentBetUser svg circle').attr('stroke-dashoffset', percent_circle)


})

socket.on('JACKPOT_ANIMATION_START',e=>{
	animationStart(e.avatarJackpot,e.plusJackpot,e.timerJackpotAnimate)
})
socket.on('JACKPOT_GET',e=>{
	if(e.statusJackpot == 2){
		$('#Jackpot').show();
		$('#cashHunt').hide();
		animationStart(e.avatarJackpot,e.plusJackpot,e.timerJackpotAnimate)
	}
	if(e.statusJackpot == 3){
		$('.water').css('transition', e.timerCashHantJackpot+'s')
		$('.water').addClass('animate')
		$('.cashHantWrapper .hant').each(function(i,elem) {
			img = e.cashHantJackpot[i] 
			$(this).html('<img src="img/cashhant/'+img+'.png">')

		});
		$('#cashHunt').show();
		$('#Jackpot').hide();
		
		
	}
})


function animationStart(avatarki,plus,time){
	console.log(time)
	$('.players.jackpot').html('')
	$('.players.jackpot').css({'transition':'0s','transform':'translateX(0px)'})
	$('.progress_block_jackpot').hide()
	$('.blockRouletteJackpot').show()

	for(let i=0;i<avatarki.length;i++){
		class_dop = ''
		av = avatarki[i]
		if(av == USER_AVA){
			class_dop = 'img_no_blur'
		}
		$('.players.jackpot').append('<img src="'+avatarki[i]+'" id_img="'+i+'" class="'+class_dop+'" width="60px">')
	}
	for(let i=0;i<avatarki.length;i++){
		class_dop = ''
		av = avatarki[i]
		if(av == USER_AVA){
			class_dop = 'img_no_blur'
		}


		$('.players.jackpot').append('<img src="'+avatarki[i]+'" id_img="'+i+'" class="'+class_dop+'" width="60px">')
	}
	const px = 3800 + plus
	$('.players.jackpot').css({'transition':'all '+time*1000+'ms cubic-bezier(0, 0, 0, 1) 0ms','transform':'translateX(-'+px+'px)'})
}


socket.on('JACKPOT_CLEAR',e => {
	$('.bankGame').text(0)
	$('.bankGame').text(0)
	$('.chanceUser').text('0%')
	$('.usersCount').html(0)

	$('.progress_block_jackpot').show()
	$('.blockRouletteJackpot').hide()
	$('.JackpotPlay').hide();
	$('.waitJackpot').show();
	$('.betsJackpot').html('')
	$('.usersJackpot').html('')
	$('.JackpotWin').hide();

	$('.chancesJackpot').html('')

	$('.progress_jackpot').css('width', '100%')
	$('.timeJackpot').text(30)
})

socket.on('JACKPOT_NOTIFICATION',e=>{
	if(USER_ID == e.user_id){
		updateBalance()			
	}
})


socket.on('JACKPOT_FINISH',e=>{
	$('.JackpotWin').show();
	$("#sw_win").html(Number(e.bank).toFixed(2));
	$(".sw_percent").html(e.percent);
	$("#sw_login").html((e.login).split(' ')[0]);
	$("#sw_bet").html(e.bet);
	$('#sw_avatar').attr('src', e.img)
	$("#sw_ticket").html(e.random);
	if(e.bank > $('#maxWin').html()){
		$('#maxWin').html(e.bank)
	}
	$('#gamesToday').html(Number(Number($('#gamesToday').html()) + 1))
})

socket.on('CASHHUNT_FINISH',e=>{
	$('.hant').addClass('show')
	$('.cashHantWrapper .hant').each(function(i,elem) {
		x = e.coefsHunt[i]
		$(this).html('<span class="coeffHunt">x'+x+'</span>')

	});
})

socket.on('CASHHUNT_END',e=>{
	$('#Jackpot').show()
	$('.water').removeClass('animate')
	$('#cashHunt').hide()
	
})

socket.on('CASHHUNT_TIME',e=>{
	$('.timerCashHunt').html(e.time)
})

socket.on('JACKPOT_BANK',e=>{
	$('.bankGame').html(e.bank)
})



socket.on('KENO_TIME',e=>{
	$('.timeKeno').html(e.time)
})

socket.on('KENO_CLEAR',e=>{
	selectsKeno = []
	$('.gameKeno').html('')
	$('.keno__canvas-item .keno__canvas-number').show()
	$('.keno__canvas-item .kenoBonus').hide()

	$('.bankKeno').html(0)
	$('.usersKeno').html(0)
	$('.keno__mines').removeClass('keno__mines--win')
	$('.keno__mines .keno__mines-win').hide();
	undisable('.keno__cancel-select')
	$('.keno__coeff-scroll').html('')
	undisable('.keno__auto-select')
	$('.keno__canvas-item').removeClass('blocked')
	$('.keno__canvas-item').removeClass('keno__canvas-item--is-selected keno__canvas-item--is-revealed keno__canvas-item--has-hit')
})


socket.on('KENO_SELECT',e=>{
	if ($('.keno__canvas-item:eq('+(e.item - 1)+')').hasClass('keno__canvas-item--is-selected')){
		$('.keno__canvas-item:eq('+(e.item - 1)+')').addClass('keno__canvas-item--has-hit')
	}else{
		$('.keno__canvas-item:eq('+(e.item - 1)+')').addClass('keno__canvas-item--is-revealed')
	}

})

socket.on('KENO_GET',e=>{
	e.selectNumberKeno.forEach(async function(item, i, arr) { 


		if ($('.keno__canvas-item:eq('+(item - 1)+')').hasClass('keno__canvas-item--is-selected')){
			$('.keno__canvas-item:eq('+(item - 1)+')').addClass('keno__canvas-item--has-hit')
		}else{
			$('.keno__canvas-item:eq('+(item - 1)+')').addClass('keno__canvas-item--is-revealed')
		}
	}); 

}) 

socket.on('KENO_BONUS',e=>{
	numberBonusKeno = e.bonusKeno.number 
	coeffBonusKeno = e.bonusKeno.coeff

	$('.keno__canvas-item:eq('+(numberBonusKeno - 1)+') .keno__canvas-number').hide()
	$('.keno__canvas-item:eq('+(numberBonusKeno - 1)+') .kenoBonus').show()
	$('.keno__canvas-item:eq('+(numberBonusKeno - 1)+') .kenoBonus div p').html('x'+coeffBonusKeno)

})

socket.on('laravel_database_updateKenoBank',e => {
	e = $.parseJSON(e)
	$('.bankKeno').html(Number(e.bank).toFixed(2))
	$('.usersKeno').html(e.users)

	
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

socket.on('laravel_database_kenoWin',e => {
	e = $.parseJSON(e)
	if(USER_ID == e.user_id){
		$('.keno__mines').addClass('keno__mines--win')
		$('.keno__mines .keno__mines-win').show();
		$('.keno__mines .keno__mines-win b').html((Number(e.win).toFixed(0))+' Р');
	}
})

function selectCashHunt(id, that) {
	$.post('/jackpot/selecthunt',{_token: csrf_token, id}).then(e=>{
		undisable('.hant')
		if(e.success){
			$('.hant').removeClass('active')
			$(that).addClass('active')
		}
		if(e.error){      
			notification('error',e.error)
		}
	}).fail(e=>{
		undisable('.hant')
		notification('error',JSON.parse(e.responseText).message)
	})	
}

kenoCoefs = [
[5.92],
[3.6, 9.6],
[2.2, 5.3, 100],
[1.5, 3.24, 20, 200],
[1.1, 2.8, 7.5, 28, 780]
]
function selectKeno(id, that){
	if(selectsKeno.indexOf(id) != -1){  
		const index = selectsKeno.indexOf(id);
		if (index > -1) {
			selectsKeno.splice(index, 1);
			$(that).removeClass('keno__canvas-item--is-selected')
		}
	}else{
		if (selectsKeno.length == 5){
			return notification('error', 'Максимум 5 ячеек')
		}
		selectsKeno.push(id)
		$(that).addClass('keno__canvas-item--is-selected')
	}

	updateKenoCoeff()

	
}

function updateKenoCoeff(){
	$('.keno__coeff-scroll').html('')

	if(selectsKeno.length > 0){
		kenoIkses = kenoCoefs[selectsKeno.length - 1]

		kenoIkses.forEach(async function(item, i, arr) { 

			$('.keno__coeff-scroll').append('<div class="keno__coeff-item d-flex flex-column">\
				<b>'+item+'x</b>\
				<span>'+(i + 1)+' hits</span>\
				</div>')

		}); 
	}
}



function sleep(ms) {
	return new Promise(resolve => setTimeout(resolve, ms));
}



function clearKeno(that) {
	selectsKeno.forEach(async function(item, i, arr) { 
		setTimeout(function(){
			$('.keno__canvas-item:eq('+(item - 1)+')').removeClass('keno__canvas-item--is-selected')
		}, 100 * ++i)
	}); 

	setTimeout(function(){
		undisable(that)
		$('.keno__coeff-scroll').html('')
	}, selectsKeno.length * 100 + 100)


	selectsKeno = []	

	
	
}

function autoKeno(that){	
	$('.keno__canvas-item').removeClass('keno__canvas-item--is-selected')
	
	selectsKeno = []	

	for (var i = 1; i <= 5; i++) {
		randItem = rand(1, 41)
		type = 'False'
		while (type == 'False'){
			if(selectsKeno.indexOf(randItem) != -1){  
				randItem = rand(1, 41)
			}else{
				break
			}
		}
		selectsKeno.push(randItem)
	}

	selectsKeno.forEach(async function(item, i, arr) { 
		setTimeout(function(){
			$('.keno__canvas-item:eq('+(item - 1)+')').addClass('keno__canvas-item--is-selected')
		}, 100 * ++i)
	}); 

	setTimeout(function(){
		undisable(that)
		updateKenoCoeff()
	}, 600)

	
}

function betKeno(that){
	selects = JSON.stringify(selectsKeno)
	$.post('/keno/bet',{_token: csrf_token, selectsKeno: selects, bet: $('#sumBetKeno').val()}).then(e=>{
		undisable(that)
		if(e.success){		
			disable('.keno__cancel-select')
			disable('.keno__auto-select')
			$('.keno__canvas-item').addClass('blocked')
			balanceUpdate(e.lastbalance, e.newbalance)
			notification('success',e.success)
		}
		if(e.error){       
			notification('error',e.error)
		}
	}).fail(e=>{
		undisable(that)
		notification('error',JSON.parse(e.responseText).message)
	})	
} 


function checkTheme() {
	if (localStorage.getItem('theme') === 'dark') {
		$('body').addClass('theme--dark');
		$('#darkTheme').hide();
		$('#lightTheme').show();
	} else {
		$('body').removeClass('theme--dark');
		$('#darkTheme').show();
		$('#lightTheme').hide();
		localStorage.removeItem('theme');
	}
}

// checkTheme()

$('#darkTheme').click(function(e){
	e.preventDefault();
	localStorage.setItem('theme', 'dark');
	$('body').addClass('theme--dark');
	$(this).hide();
	$('#lightTheme').show();
});
$('#lightTheme').click(function(e){
	e.preventDefault();
	localStorage.removeItem('theme');
	$('body').removeClass('theme--dark');
	$(this).hide();
	$('#darkTheme').show();
});



 // initial data
 let countY = [0, 2];
 let countX = [0, 1];

 let updatedCountY = [0];
 let updatedCountX = [0];

 var bet_user = 0;

 function crashBet(that){
 	const info = {
 		bet: Number($('#crashSum').val()),
 		auto: Number($('#crashAuto').val()),
 		_token: csrf_token
 	}
 	$.post('/crash/bet',info).then(e=>{
 		if(e.success){
 			bet_user = 1;
 			notification('success',e.success)
 			balanceUpdate(e.lastbalance, e.newbalance)
 			$('#btnCrash span').html('Ожидание игры...')	
 			disable('#crashSum')	
 			disable('#crashAuto')				
 		}
 		if(e.error){
 			undisable(that)
 			notification('error',e.error)
 		}
 	})

 }

 

 function crashGive(that){
 	const info = {
 		_token: csrf_token
 	}
 	$.post('/crash/give',info).then(e=>{
 		if(e.success){
 			bet_user = 0;
 			notification('info', 'Забираем...')
 			// $('#btnCrash').html('Забираем...')
 		}
 		if(e.error){
 			undisable(that)
 			notification('error',e.error)
 		}
 	})

 }



 socket.on('laravel_database_crashBet',e=>{
 	e = $.parseJSON(e)
 	$('.crash__history-users').prepend(' <div id="game_crash_id_'+e.id+'" class="crash__history-item-user d-flex align-center justify-space-between">\
 		<div class="history__user d-flex align-center justify-center">\
 		<div class="history__user-avatar" style="background: url('+e.img+') no-repeat center center / cover;"></div>\
 		<span>'+e.login+'</span>\
 		</div>\
 		<div class="d-flex align-center">\
 		<div class="d-flex align-center">\
 		<span class="bx-input__text">'+Number(e.bet).toFixed(2)+'</span>\
 		<svg class="icon money"><use xlink:href="images/symbols.svg#coins"></use></svg>\
 		</div>\
 		<div class="crash__history-user-x d-flex align-center justify-space-between">\
 		<div class="d-flex align-center">\
 		<span class="bx-input__text">0</span>\
 		<svg class="icon money"><use xlink:href="images/symbols.svg#coins"></use></svg>\
 		</div>\
 		<a href="#" class="crash__history-item">\
 		<span>x0</span>\
 		</a>\
 		</div>\
 		</div>\
 		</div>')
 })


 function startGameCoin(that){
 	$.post('/coin/bet',{_token: csrf_token, bet: $('#coinSum').val()}).then(e=>{
 		undisable(that)
 		if(e.success){	
 			disable('#coinSum')	
 			$('#playCoin').show();
 			$('#startCoin').hide();
 			$('#coinCoeff').html('x'+Number(0).toFixed(2))
 			$('#coinStep').html(0)	
 			$("#winCoin").html(Number(0 * $('#coinSum').val()).toFixed(2))
 			balanceUpdate(e.lastbalance, e.newbalance)
 			notification('success',e.success)

 			if(e.bonus == 1){
 				notification('success', 'Бонусная игра!')
 				$('.mines__bonus .x30__bonus-scroll').css({'transition':'0s','transform':'translateX(0px)'})

 				$('.mines__bonus .x30__bonus-scroll').html('')
 				$('.mines__bonus').show()

 				disable('.coinflip__place')
 				disable('#finishCoinBtn')

 				e.bonusCoin.forEach((e)=>{
 					$('.mines__bonus .x30__bonus-scroll').append('<div class="x30__bonus-item x30 d-flex align-center justify-center">x'+e+'</div>')

 				})	

 				x = (56*43) - (Number($('.mines__bonus').width())/2) + rand(10, 40)


 				betMine = Number($('#coinSum').val())
 				betNew = betMine * e.coeffBonusCoin
 				betNew = betNew.toFixed(2)	

 				setTimeout(() => $('.mines__bonus .x30__bonus-scroll').css({'transition':'10s','transform':'translateX(-'+x+'px)'}), 200);
 				setTimeout(() => $('#coinSum').val(betNew),10000);
 				setTimeout(() => undisable('.coinflip__place'),10000);
 				setTimeout(() => notification('success', 'Поздравляем! Ваша ставка умножилась на '+e.coeffBonusCoin),10000);
 				setTimeout(() => undisable('#finishCoinBtn'),10000);
 			}

 		}else{       
 			notification('error',e.mess)
 		}
 	}).fail(e=>{
 		undisable(that)
 		notification('error',JSON.parse(e.responseText).message)
 	})	
 }

 function finishGameCoin(that){
 	$.post('/coin/finish',{_token: csrf_token}).then(e=>{
 		undisable(that)
 		if(e.success){	
 			undisable('#coinSum')	
 			$('#coinCoeff').html('x0.00')
 			$('#coinStep').html(0)	
 			$("#winCoin").html(Number(0).toFixed(2))
 			$('#playCoin').hide(); 
 			$('#startCoin').show();
 			balanceUpdate(e.lastbalance, e.newbalance)
 			notification('success',e.success)

 			$('.mines__bonus').hide()
 			betMine = Number($('#coinSum').val())
 			betNew = betMine / e.coeffBonusCoin
 			betNew = betNew.toFixed(2)	
 			$('#coinSum').val(betNew)
 		}else{       
 			notification('error',e.mess)
 		}
 	}).fail(e=>{
 		undisable(that)
 		notification('error',JSON.parse(e.responseText).message)
 	})	
 }

 function playCoinGame(that, type){
 	disable('#finishCoinBtn')
 	disable('.coinflip__place')
 	$(that).addClass('coinflip__place--active')
 	$.post('/coin/play',{_token: csrf_token, type}).then(e=>{


 		if(e.success){	
 			if(e.off == 3){
 				notification('success', 'Бонусная игра!')
 				$('.mines__bonus .x30__bonus-scroll').css({'transition':'0s','transform':'translateX(0px)'})

 				$('.mines__bonus .x30__bonus-scroll').html('')
 				$('.mines__bonus').show()

 				disable('.coinflip__place')
 				disable('#finishCoinBtn')

 				e.bonusCoin.forEach((e)=>{
 					$('.mines__bonus .x30__bonus-scroll').append('<div class="x30__bonus-item x30 d-flex align-center justify-center">x'+e+'</div>')

 				})	
 				
 				x = (56*43) - (Number($('.mines__bonus').width())/2) + rand(10, 40)


 				betMine = Number($('#coinSum').val())
 				betNew = betMine * e.coeffBonusCoin
 				betNew = betNew.toFixed(2)	

 				setTimeout(() => $('.mines__bonus .x30__bonus-scroll').css({'transition':'10s','transform':'translateX(-'+x+'px)'}), 200);
 				setTimeout(() => $('#coinSum').val(betNew),10000);
 				setTimeout(() => $("#winCoin").html(Number(e.win).toFixed(2)),10000);
 				setTimeout(() => undisable('.coinflip__place'),10000);
 				setTimeout(() => notification('success', 'Поздравляем! Ваша ставка умножилась на '+e.coeffBonusCoin),10000);
 				setTimeout(() => undisable('#finishCoinBtn'),10000);
 				setTimeout(() =>{ undisable('#finishCoinBtn')
 					$(that).removeClass('coinflip__place--active')  
 				},10000);

 				return
 			}

 			$('.coinflip__wrapper').removeClass('animated flip_1 flip_2')
 			setTimeout(() => {
 				$('.coinflip__wrapper').addClass('animated flip_'+e.type)
 			}, 100) 

 			setTimeout(() => {
 				undisable(that)
 				undisable('.coinflip__place')
 				undisable('#finishCoinBtn')
 				$(that).removeClass('coinflip__place--active')  
 				



 				if(e.off == 1){
 					$('#coinCoeff').html('x0.00')
 					$('#coinStep').html(0)	
 					$("#winCoin").html(Number(0).toFixed(2))
 					$('#playCoin').hide(); 
 					$('#startCoin').show();
 					undisable('#coinSum')	

 					$('.mines__bonus').hide()
 					betMine = Number($('#coinSum').val())
 					betNew = betMine / e.coeffBonusCoin
 					betNew = betNew.toFixed(2)	
 					$('#coinSum').val(betNew)
 				}else{
 					$('#coinCoeff').html('x'+Number(e.coeff).toFixed(2))
 					$('#coinStep').html(e.step)	
 					$("#winCoin").html(Number(e.win).toFixed(2))
 				}       
 			}, 1000)    
 		}else{
 			undisable(that)
 			undisable('.coinflip__place')
 			undisable('#finishCoinBtn')
 			$(that).removeClass('coinflip__place--active')       
 			notification('error',e.mess)
 		}
 	}).fail(e=>{
 		undisable(that)
 		undisable('.coinflip__place')
 		undisable('#finishCoinBtn')
 		$(that).removeClass('coinflip__place--active')     
 		notification('error',JSON.parse(e.responseText).message)
 	})	
 }