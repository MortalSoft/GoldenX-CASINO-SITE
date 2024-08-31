<div style="margin-top: 35px;" class="dice">
	@auth
	@if(\Auth::user()->admin == 1)
		<!-- <div class="dice__chance">
				<div class="dice__select-chance d-flex align-center justify-space-between">
					<a class="dice__type--active">Ручные ставки</a>
					<a>Авто ставки</a>
					<a>Турбо ставки</a>
				</div> 
			</div> -->
	@endif
	@endauth
	<div class="dice__drum d-flex justify-center align-center" id="dice__result">
		<div class="dice__center">
			<div class="dice__timer">
				<span class="d-flex justify-center align-center">
					<div class="dice__slider">
						<div class="dice__slider-inner d-flex flex-column" id="dice_n_1">
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>0</span>
							</div>
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>1</span>
							</div>
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>2</span>
							</div>
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>3</span>
							</div>
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>4</span>
							</div>
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>5</span>
							</div>
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>6</span>
							</div>
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>7</span>
							</div>
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>8</span>
							</div>
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>9</span>
							</div>
						</div>
					</div>
				</span>
				<span class="d-flex justify-center align-center">
					<div class="dice__slider">
						<div class="dice__slider-inner d-flex flex-column" id="dice_n_2">
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>0</span>
							</div>
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>1</span>
							</div>
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>2</span>
							</div>
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>3</span>
							</div>
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>4</span>
							</div>
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>5</span>
							</div>
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>6</span>
							</div>
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>7</span>
							</div>
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>8</span>
							</div>
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>9</span>
							</div>
						</div>
					</div>
				</span>
				<span class="d-flex justify-center align-center">
					<div class="dice__slider">
						<div class="dice__slider-inner d-flex flex-column" id="dice_n_3">
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>0</span>
							</div>
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>1</span>
							</div>
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>2</span>
							</div>
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>3</span>
							</div>
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>4</span>
							</div>
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>5</span>
							</div>
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>6</span>
							</div>
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>7</span>
							</div>
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>8</span>
							</div>
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>9</span>
							</div>
						</div>
					</div>
				</span>
				<span class="d-flex justify-center align-center">
					<div class="dice__slider">
						<div class="dice__slider-inner d-flex flex-column" id="dice_n_4">
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>0</span>
							</div>
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>1</span>
							</div>
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>2</span>
							</div>
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>3</span>
							</div>
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>4</span>
							</div>
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>5</span>
							</div>
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>6</span>
							</div>
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>7</span>
							</div>
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>8</span>
							</div>
							<div class="dice__slider-item d-flex align-center justify-center">
								<span>9</span>
							</div>
						</div>
					</div>
				</span>
			</div>
		</div>
		<div class="dice__result d-flex align-center justify-center"></div>
		
	</div>
	<div class="wrapper">
		<div class="dice__bet">
			<div class="dice__procent">
				<div class="bx-input__input d-flex align-center justify-space-between">
					<label class="d-flex align-center">Процент:</label>
					<input readonly style="cursor: default;" type="text" value="50.00" onkeyup="updateDicePercent()" id="PercentDice">
				</div>
			</div>
			<div class="dice__chance">
				<input type="range" oninput="diceRange()" class="dice__range" value="50">
				<div class="dice__select-chance d-flex align-center justify-space-between">
					<a  class="active btn_min_change" onclick="changeDice('minPlay', this)">Меньше</a>
					<a  onclick="changeDice('maxPlay', this)">Больше</a>
				</div> 
			</div>
			
			<div class="dice__x">
				<div class="bx-input__input d-flex align-center justify-space-between">
					<label class="d-flex align-center">Коэффицент:</label>
					<input readonly style="cursor: default;" type="text" value="2.00" onkeyup="updateDiceCoeff()" id="CoeffDice">
				</div>
			</div>
			<div class="dice__betting">
				<div class="bx-input__input d-flex align-center justify-space-between">
					
						<input class="fullInputWidth" style="text-align: left;" type="text" value="1.00" placeholder="0.00" onkeyup="updateDiceBet()" id="BetDice">
						<svg class="icon money"><use xlink:href="images/symbols.svg#coins"></use></svg>
					
				</div>
			</div>
			<div class="dice__betting">
				<div class="x30__bet-placed d-flex align-center justify-space-between">
					<a  onclick="$('#BetDice').val('1.00');updateDiceBet(); return false;">Min</a>
					<a  onclick="$('#BetDice').val(Number($('#balance').attr('balance')).toFixed(2));updateDiceBet(); return false;">Max</a>
					<a  onclick="$('#BetDice').val(($('#BetDice').val() * 2).toFixed(2));updateDiceBet(); return false;">x2</a>
					<a  onclick="$('#BetDice').val(Math.max(($('#BetDice').val()/2), 1).toFixed(2));updateDiceBet(); return false;">1/2</a>
				</div>
			</div>
			<div class="dice__win">
				<div class="bx-input__input d-flex align-center justify-space-between">
					<label class="d-flex align-center">Выигрыш:</label>
					<div class="d-flex align-center">
						<input readonly style="cursor: default;" type="text" value="2.00" onkeyup="updateDiceWin()" id="WinDice">
						<svg class="icon money"><use xlink:href="images/symbols.svg#coins"></use></svg>
					</div>
				</div>
			</div>
			<div class="dice__play d-flex justify-center align-center" style="grid-column: 1 / 4;">
				<a  class="btn is-ripples flare btn--blue d-flex align-center" onclick="disable(this);playDice(this)" id="dice__play"><span>Крутить</span></a>
				
				<a  class="btn is-ripples flare btn--red d-flex align-center" onclick="newGame(this)" id="dice__replay" style="display: none;" ><span>Играть ещё раз</span></a>
			</div>

		</div>
		<div style="text-align:center;width: 100%;margin-top: 15px;font-weight: bold;cursor: pointer;display: none;"  id="checkDice" class=""><a  onclick="return false;" rel="popup" data-popup="popup--fair-dice">Проверить игру</a></div>
	</div>
</div>
<div class="wrapper">
	@include('layouts.history')
</div>

<script type="text/javascript">
	changeDice('minPlay', '.btn_min_change')
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
    socket.emit('subscribe', 'roomGame_3_{{\Auth::user()->id}}');
</script>
@endauth