 
<div class="content" >
	<div class="flex ">
		<div class="col-menu-lg">

		</div>
		<div class="col" style="max-width: 700px;margin: 0px auto;position:relative;">
			<div style="">
				<div style="position:relative;" class="block_dice">
					
					<img src="img/dice.svg" class="svg_dice">
					

					<div class="text_dice" style="position:absolute;height: 55px;width: 200px;top:44%;display: flex;left:50%;transform: translate(-50%,-50%);">
						
							<span class="p_t_big" id="dice_n_1">0</span>
							<span class="p_t_big" id="dice_n_2">0</span>
							<span class="p_t_big" id="dice_n_3">0</span>
							<span class="p_t_big" id="dice_n_4">0</span>
						
						
					</div>

					<div class="text_dice" style="position:absolute;height: 55px;width: 200px;top:44%;left:50%;transform: translate(-50%,-50%);">
						<span style="width:100%;font-size: 30px;line-height: 37px;position: relative;top:15px">,</span>
					</div>

					
				</div>
				
				<div class="flex no_padding wrap">
					<div class="col-lg-3 col-input-dice">
						<div>
							<label>Процент</label>
							<div style="position:relative;margin-top: 10px;">
								<input type="" class="secodary_input input_dice " onkeyup="updateDicePercent()" id="PercentDice" value="50.00" name="">
								<div class="dop_input">
									<svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M2.814 5.492C2.09533 5.492 1.50733 5.24933 1.05 4.764C0.602 4.26933 0.378 3.61133 0.378 2.79C0.378 1.96867 0.602 1.31533 1.05 0.83C1.50733 0.335333 2.09533 0.0879999 2.814 0.0879999C3.53267 0.0879999 4.116 0.335333 4.564 0.83C5.012 1.31533 5.236 1.96867 5.236 2.79C5.236 3.61133 5.012 4.26933 4.564 4.764C4.116 5.24933 3.53267 5.492 2.814 5.492ZM8.652 0.199999H10.318L3.626 10H1.96L8.652 0.199999ZM2.814 4.344C3.13133 4.344 3.37867 4.21333 3.556 3.952C3.74267 3.69067 3.836 3.30333 3.836 2.79C3.836 2.27667 3.74267 1.88933 3.556 1.628C3.37867 1.36667 3.13133 1.236 2.814 1.236C2.506 1.236 2.25867 1.37133 2.072 1.642C1.88533 1.90333 1.792 2.286 1.792 2.79C1.792 3.294 1.88533 3.68133 2.072 3.952C2.25867 4.21333 2.506 4.344 2.814 4.344ZM9.464 10.112C8.99733 10.112 8.57733 10.0047 8.204 9.79C7.84 9.566 7.55533 9.24867 7.35 8.838C7.14467 8.42733 7.042 7.95133 7.042 7.41C7.042 6.86867 7.14467 6.39267 7.35 5.982C7.55533 5.57133 7.84 5.25867 8.204 5.044C8.57733 4.82 8.99733 4.708 9.464 4.708C10.1827 4.708 10.766 4.95533 11.214 5.45C11.6713 5.93533 11.9 6.58867 11.9 7.41C11.9 8.23133 11.6713 8.88933 11.214 9.384C10.766 9.86933 10.1827 10.112 9.464 10.112ZM9.464 8.964C9.78133 8.964 10.0287 8.83333 10.206 8.572C10.3927 8.30133 10.486 7.914 10.486 7.41C10.486 6.906 10.3927 6.52333 10.206 6.262C10.0287 5.99133 9.78133 5.856 9.464 5.856C9.156 5.856 8.90867 5.98667 8.722 6.248C8.53533 6.50933 8.442 6.89667 8.442 7.41C8.442 7.92333 8.53533 8.31067 8.722 8.572C8.90867 8.83333 9.156 8.964 9.464 8.964Z" fill="#95A5BE"/>
									</svg>

								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-5 col-range d-comp">
						<input type="range" style="width:100%;margin-top: 15px" oninput="diceRange()" class="range range_dice"  name="" value="50">
						<div class="flex no_padding wrap">
							<div class="col-5"> 
								<span class="range_text">0</span>
							</div>
							<div class="col-5" style="text-align:right">
								<span class="range_text">100</span>
							</div>
						</div>
						<div class="flex no_padding" style="margin-top: 5px">
							<button class="btn-auth w-100 btn_change btn_min_change" onclick="changeDice('minPlay', this)" style="border-radius: 10px 0px 0px 10px;height: 35px">Меньше</button>
							<button class="btn-dep w-100 btn_change" onclick="changeDice('maxPlay', this)" style="border-radius: 0px 10px 10px 0px;height: 35px">Больше</button>
						</div>
						
					</div>
					<div class="col-lg-3 col-input-dice d-comp">
						<div style="">
							<label>Коэффициент</label>
							<div style="position:relative;margin-top: 10px;">
								<input type="" class="secodary_input input_dice " onkeyup="updateDiceCoeff()" id="CoeffDice" value="2.00" name="">
								<div class="dop_input">
									<svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M7.336 10L4.97 6.598L2.646 10H0.042L3.668 5.016L0.224 0.199999H2.8L5.054 3.378L7.266 0.199999H9.716L6.3 4.932L9.954 10H7.336Z" fill="#95A5BE"/>
									</svg>

								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="flex no_padding wrap" style="margin-top:25px">
					<div class="col-lg-3 col-input-dice">
						<div>
							<label>Ставка</label>
							<div style="position:relative;margin-top: 10px;">
								<input type="" class="secodary_input input_dice" onkeyup="updateDiceBet()" id="BetDice" value="1.00" name="">
								<div class="dop_input">
									<svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M0 10.2908V11.375C0 12.2713 2.18359 13 4.875 13C7.56641 13 9.75 12.2713 9.75 11.375V10.2908C8.70137 11.0297 6.78437 11.375 4.875 11.375C2.96563 11.375 1.04863 11.0297 0 10.2908ZM8.125 3.25C10.8164 3.25 13 2.52129 13 1.625C13 0.728711 10.8164 0 8.125 0C5.43359 0 3.25 0.728711 3.25 1.625C3.25 2.52129 5.43359 3.25 8.125 3.25ZM0 7.62734V8.9375C0 9.83379 2.18359 10.5625 4.875 10.5625C7.56641 10.5625 9.75 9.83379 9.75 8.9375V7.62734C8.70137 8.49062 6.78184 8.9375 4.875 8.9375C2.96816 8.9375 1.04863 8.49062 0 7.62734ZM10.5625 7.90664C12.0174 7.6248 13 7.10176 13 6.5V5.41582C12.4109 5.83223 11.5451 6.1166 10.5625 6.2918V7.90664ZM4.875 4.0625C2.18359 4.0625 0 4.97148 0 6.09375C0 7.21602 2.18359 8.125 4.875 8.125C7.56641 8.125 9.75 7.21602 9.75 6.09375C9.75 4.97148 7.56641 4.0625 4.875 4.0625ZM10.4432 5.49199C11.9666 5.21777 13 4.67949 13 4.0625V2.97832C12.0986 3.61563 10.5498 3.9584 8.91973 4.03965C9.66875 4.40273 10.2197 4.89023 10.4432 5.49199Z" fill="#95A5BE"/>
									</svg>

								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-5 col-range">
						<br>
						<div class="flex no_padding wrap" style="margin-bottom: 10px">
							<button class="btn_bet col-3" style="margin-left: 0px;" onclick="$('#BetDice').val(Math.max(($('#BetDice').val()/2), 1).toFixed(2));updateDiceBet()">1/2</button>
							<button class="btn_bet col-3" onclick="$('#BetDice').val(($('#BetDice').val() * 2).toFixed(2));updateDiceBet();">x2</button>
							<button class="btn_bet col-3" onclick="$('#BetDice').val('1.00');updateDiceBet()">min</button>
							<button class="btn_bet col-3" style="margin-right: 0px;" onclick="$('#BetDice').val(Number($('#balance').attr('balance')).toFixed(2));updateDiceBet()">max</button>
						</div>
					</div>
					<div class="col-lg-3 col-input-dice d-comp">
						<div style="">
							<label>Возможый выигрыш</label>
							<div style="position:relative;margin-top: 10px;">
								<input type="" class="secodary_input input_dice" onkeyup="updateDiceWin()" id="WinDice" value="2.00" name="">
								<div class="dop_input">
									<svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M0 10.2908V11.375C0 12.2713 2.18359 13 4.875 13C7.56641 13 9.75 12.2713 9.75 11.375V10.2908C8.70137 11.0297 6.78437 11.375 4.875 11.375C2.96563 11.375 1.04863 11.0297 0 10.2908ZM8.125 3.25C10.8164 3.25 13 2.52129 13 1.625C13 0.728711 10.8164 0 8.125 0C5.43359 0 3.25 0.728711 3.25 1.625C3.25 2.52129 5.43359 3.25 8.125 3.25ZM0 7.62734V8.9375C0 9.83379 2.18359 10.5625 4.875 10.5625C7.56641 10.5625 9.75 9.83379 9.75 8.9375V7.62734C8.70137 8.49062 6.78184 8.9375 4.875 8.9375C2.96816 8.9375 1.04863 8.49062 0 7.62734ZM10.5625 7.90664C12.0174 7.6248 13 7.10176 13 6.5V5.41582C12.4109 5.83223 11.5451 6.1166 10.5625 6.2918V7.90664ZM4.875 4.0625C2.18359 4.0625 0 4.97148 0 6.09375C0 7.21602 2.18359 8.125 4.875 8.125C7.56641 8.125 9.75 7.21602 9.75 6.09375C9.75 4.97148 7.56641 4.0625 4.875 4.0625ZM10.4432 5.49199C11.9666 5.21777 13 4.67949 13 4.0625V2.97832C12.0986 3.61563 10.5498 3.9584 8.91973 4.03965C9.66875 4.40273 10.2197 4.89023 10.4432 5.49199Z" fill="#95A5BE"/>
									</svg>

								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="flex no_padding wrap" style="margin-top:25px">
					<div class="col-lg-3 col-input-dice">

					</div>
					<div class="col-lg-5 col-range">
						<div class="d-mob">
							<div class="flex no_padding wrap ">
								<div class="col-5"><button class="btn_bet_dice" onclick="disable(this);playDice(this, 'minPlay')">Меньше <img class="dop_btn" src="img/yellow_coin.svg"></button></div>
								<div class="col-5"><button class="btn_bet_dice" onclick="disable(this);playDice(this, 'maxPlay')">Больше</button></div>
							</div>
						</div>

						<button class="btn_bet_dice d-comp" onclick="disable(this);playDice(this)">Крутить <img class="dop_btn" src="img/yellow_coin.svg"></button>

						<div style="height:40px"><button class="btn-dep w-100" style="margin-top:15px;display: none;" id="checkDice" onclick="checkDice()">Проверить игру</button></div>
						


					</div>
					<div class="col-lg-3 col-input-dice">

					</div>
				</div>
			</div>

			<!-- /// -->
			@include('layouts.history')
			


			<!-- ///// -->

		</div>
	</div>
</div>

<script type="text/javascript">
	changeDice('minPlay', '.btn_min_change')
</script>