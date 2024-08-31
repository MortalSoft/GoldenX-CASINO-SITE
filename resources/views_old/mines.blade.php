
<div class="content" >
	<div class="flex ">
		<div class="col-menu-lg">

		</div>
		<div class="col" style="max-width: 700px;margin: 0px auto;">
			<div class="flex no_padding wrap">
				<div class="col-lg-5">

					<label>Ставка</label>
					<div class="flex no_padding wrap" style="margin-top:10px">
						<div class="col-5">

							<div style="position:relative;">
								<input type="" class="secodary_input input_wheel" onkeyup="updateMinesXNew()"  value="1.00" id="BetMines" name="">
								<div class="dop_input">
									<svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M0 10.2908V11.375C0 12.2713 2.18359 13 4.875 13C7.56641 13 9.75 12.2713 9.75 11.375V10.2908C8.70137 11.0297 6.78437 11.375 4.875 11.375C2.96563 11.375 1.04863 11.0297 0 10.2908ZM8.125 3.25C10.8164 3.25 13 2.52129 13 1.625C13 0.728711 10.8164 0 8.125 0C5.43359 0 3.25 0.728711 3.25 1.625C3.25 2.52129 5.43359 3.25 8.125 3.25ZM0 7.62734V8.9375C0 9.83379 2.18359 10.5625 4.875 10.5625C7.56641 10.5625 9.75 9.83379 9.75 8.9375V7.62734C8.70137 8.49062 6.78184 8.9375 4.875 8.9375C2.96816 8.9375 1.04863 8.49062 0 7.62734ZM10.5625 7.90664C12.0174 7.6248 13 7.10176 13 6.5V5.41582C12.4109 5.83223 11.5451 6.1166 10.5625 6.2918V7.90664ZM4.875 4.0625C2.18359 4.0625 0 4.97148 0 6.09375C0 7.21602 2.18359 8.125 4.875 8.125C7.56641 8.125 9.75 7.21602 9.75 6.09375C9.75 4.97148 7.56641 4.0625 4.875 4.0625ZM10.4432 5.49199C11.9666 5.21777 13 4.67949 13 4.0625V2.97832C12.0986 3.61563 10.5498 3.9584 8.91973 4.03965C9.66875 4.40273 10.2197 4.89023 10.4432 5.49199Z" fill="#95A5BE"/>
									</svg>

								</div>
							</div>
						</div>

						<div class="col-5" >
							<div class="flex no_padding wrap">
								<div class="col-5">
									<button class="btn_bet btn_mine_bomb" onclick="$('#BetMines').val((Number($('#BetMines').val()) * 2).toFixed(2));updateMinesXNew()" style="margin-top:0px">x2</button>
								</div>
								<div class="col-5">
									<button class="btn_bet btn_mine_bomb" onclick="$('#BetMines').val(Number($('#balance').attr('balance')).toFixed(2));updateMinesXNew()" style="margin-top:0px">max</button>
								</div>
							</div>
						</div>
					</div>

					<br>
					<label>Количество бомб</label>
					<div class="flex no_padding wrap" style="margin-top:10px">
						<div class="col-5" style="width:70px;max-width:70px;">

							<div style="position:relative;">
								<input type="" class="secodary_input input_wheel" onkeyup="updateMinesXNew()" id="BombMines" value="3" min="2" max="25" name="">
								<div class="dop_input">
									<svg width="11" height="16" viewBox="0 0 11 16" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M7.53622 5.123V4.109C7.53574 3.8105 7.30017 3.5685 7.009 3.5685H6.20963V2.5825H7.08655C7.39527 2.5825 7.68303 2.4575 7.89567 2.231C8.08978 2.0255 8.20976 1.7455 8.20976 1.4365C8.20976 1.42 8.20928 1.403 8.20879 1.3865V1.389L8.1805 0.6075C8.16831 0.2695 7.89811 0 7.56646 0C7.55817 0 7.55037 0 7.54208 0.0005H7.54305C7.21335 0.0135 6.95096 0.2905 6.95096 0.6305C6.95096 0.6385 6.95096 0.647 6.95145 0.655V0.654L6.97535 1.3215H6.12135C5.49171 1.3215 4.97912 1.847 4.97912 2.4925V3.5685H3.99149C3.70032 3.569 3.46475 3.8105 3.46426 4.109V5.123C1.43633 5.9545 0 7.989 0 10.3615C0 13.4705 2.46688 16 5.5 16C8.53312 16 11 13.4705 11 10.3615C11 7.989 9.56367 5.9545 7.53574 5.1235L7.53622 5.123Z" fill="#95A5BE"/>
									</svg>


								</div>
							</div>
						</div>
						<div class="col-5" style="width:calc(100% - 75px);max-width:100%;">
							<div class="flex no_padding wrap lastBombBtn" >
								<div class="col-5" style="width:calc(100% / 4 - 5px);max-width:calc(100 / 4 - 5px);">
									<button class="btn_bet btn_mine_bomb bomb_3 active" onclick="$('#BombMines').val(3);updateMinesXNew()" style="margin-top:0px">3</button>
								</div>
								<div class="col-5" style="width:calc(100% / 4 - 5px);max-width:calc(100 / 4 - 5px);">
									<button class="btn_bet btn_mine_bomb bomb_5" onclick="$('#BombMines').val(5);updateMinesXNew()" style="margin-top:0px">5</button>
								</div>

								
							
							</div>
						</div>
					</div>

					<br>
					<label>Уровень</label>
					<div class="flex no_padding wrap" style="margin-top:10px">
						
						<input type="hidden" id="LevelMines" value="25"  name="">
								
						<div class="col" style="width:calc(100%);max-width:100%;">
							<div class="flex no_padding wrap" >
								<div class="col-5" style="width:calc(100% / 4 - 5px);max-width:calc(100 / 4 - 5px);">
									<button class="btn_bet btn_mine_level level_16 " onclick="$('#LevelMines').val(16);updateLevel();" style="margin-top:0px">4x4</button>
								</div>
								<div class="col-5" style="width:calc(100% / 4 - 5px);max-width:calc(100 / 4 - 5px);">
									<button class="btn_bet btn_mine_level level_25 active" onclick="$('#LevelMines').val(25);updateLevel();" style="margin-top:0px">5x5</button>
								</div>
								<div class="col-5" style="width:calc(100% / 4 - 5px);max-width:calc(100 / 4 - 5px);">
									<button class="btn_bet btn_mine_level level_36" onclick="$('#LevelMines').val(36);updateLevel();" style="margin-top:0px">6x6</button>
								</div>
								<div class="col-5" style="width:calc(100% / 4 - 5px);max-width:calc(100 / 4 - 5px);">
									<button class="btn_bet btn_mine_level level_49" onclick="$('#LevelMines').val(49);updateLevel();" style="margin-top:0px">7x7</button>
								</div>
							</div>
						</div>
					</div>


					<button class="btn_bet_dice start_block_mine w-100" style="margin-top:20px;display: none" onclick="disable(this);startGameMineNew(this)">Играть <img class="dop_btn" src="img/yellow_coin.svg"> </button>



					<div class="flex no_padding play_block_mine wrap" style="display:none">
						<div class="col-5">
							<button class="btn_bet_dice w-100" style="margin-top:20px" onclick="disable(this);$('.mine').addClass('no_select');finishGameMineNew(this)">Забрать <span id="winMine">0.00</span><img class="dop_btn" src="img/yellow_coin.svg"> </button>
						</div>
						<div class="col-5">
							<button class="btn_bet_dice w-100" style="margin-top:20px" onclick="disable(this);$('.mine').addClass('no_select');autoClickMineNew(this)">Автовыбор </button>
						</div>
					</div>

					
					
					
					<div style="margin-top: 15px;display: none;" id="mines_bonus">
						<label>Мультиплеер</label>
						<div class="item " style="margin-bottom:0px;margin-top: 5px;">
							<div class="roulette_mines" >
								<div class="inbox">
									<div class="players mines"> 									
									</div>
								</div>
							</div>
						</div>
					</div>

					<div style="height:40px;margin-bottom: 15px;margin-top: 10px;"><button class="btn-dep w-100" style="margin-top:0px;display: none;" id="checkMine" onclick="checkMine()">Проверить игру</button></div>

				</div>
				<div class="col-lg-5 padding_right_10_comp">
					
					<center>
						<div class="block">
							<div class="wrapper minesPole" id="minesPole">

								

							</div>


							<div class="mine_block">
								<img src="img/mine_block.png" class="img_mine_block"  draggable="false">
							</div>

							<div class="win_mine_block" style="display: none">
								<center><div class="winText">Выигрыш</div><div class="sumWinText"></div></center>
							</div>
						</div>


					</center>
				</div>
			</div>


			<div class="blockMinesXTen">
				<!-- <div class="arrowMines arrowRight" onclick="scrollRight()" style="opacity: 1;"><img src="img/icons/arrow.svg?v=1" style="height: 40px;position: relative;top:50%;transform: translateY(-50%);"></div> -->
				<div class="blockMinesX">
				</div>
				<!-- <div class="arrowMines arrowLeft" onclick="scrollLeft_1()" style="left:0;opacity: 0;"><img src="img/icons/arrow.svg?v=1" style="height: 40px;position: relative;top:50%;transform: translateY(-50%) rotate(180deg);"></div> -->
			</div>


			<!--  -->

			@include('layouts.history')

			<!--  -->

		</div>
	</div>
</div> 


<script type="text/javascript">
	createMinePole(25)
	updateMinesX()
	getGameMineNew()
</script>