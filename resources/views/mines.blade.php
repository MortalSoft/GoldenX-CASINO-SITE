<div class="mines d-flex justify-center" style="margin-top:35px">
	<div class="mines__wrapper d-flex justify-space-between align-start flex-wrap">
		<div class="mines__left d-flex flex-column justify-center align-center">
			<div class="bx-input d-flex flex-column">
				<div class="bx-input__input d-flex justify-space-between align-center">
					
						<input class="fullInputWidth" style="text-align: left;" placeholder="0.00" type="text" value="1.00" id="BetMines" onkeyup="updateMinesXNew()"  placeholder="0.00">
						<svg class="icon money"><use xlink:href="images/symbols.svg#coins"></use></svg>
					
				</div>
				<div class="x30__bet-placed d-flex align-center justify-space-between">
					<a  onclick="$('#BetMines').val(Number($('#BetMines').val()) + 10)">+10</a>
					<a  onclick="$('#BetMines').val(Number($('#BetMines').val()) + 100)">+100</a>
					<a  onclick="$('#BetMines').val(Number($('#BetMines').val()) + 1000)">+1000</a>
					<a  onclick="$('#BetMines').val((Number($('#BetMines').val()) * 2).toFixed(2));updateMinesXNew()">x2</a>
					<a  onclick="$('#BetMines').val(Math.max(($('#BetMines').val()/2), 1).toFixed(2));">1/2</a>
				</div>
			</div>
			<div class="bx-input">
				<div class="bx-input__input d-flex justify-space-between align-center">
					<label class="d-flex align-center">Кол-во бомб:</label>
					<div class="d-flex align-center">
						<input type="text" id="BombMines" onkeyup="updateMinesXNew()" value="3" style="width: 35px;text-align: center;padding-right: 8px;">
						<div class="mines__bomb Bomb d-flex align-center">
							<a class="mines__bomb--active bomb_3" onclick="$('#BombMines').val(3);$('.mines__bomb.Bomb a').removeClass('mines__bomb--active');$(this).addClass('mines__bomb--active');updateMinesXNew()">3</a>
							<a  class="bomb_5" onclick="$('#BombMines').val(5);$('.mines__bomb.Bomb a').removeClass('mines__bomb--active');$(this).addClass('mines__bomb--active');updateMinesXNew()">5</a>
							<a  class="bomb_10" onclick="$('#BombMines').val(10);$('.mines__bomb.Bomb a').removeClass('mines__bomb--active');$(this).addClass('mines__bomb--active');updateMinesXNew()">10</a>
							<a  class="bomb_24" onclick="$('#BombMines').val(24);$('.mines__bomb.Bomb a').removeClass('mines__bomb--active');$(this).addClass('mines__bomb--active');updateMinesXNew()">24</a>
						</div>
					</div>
					
				</div>
			</div>

			<div class="bx-input">
				<input type="hidden" id="LevelMines" value="25"  name="">
				<div class="bx-input__input d-flex justify-space-between align-center">
					<label class="d-flex align-center">Уровень:</label>
					<div class="mines__bomb Level d-flex align-center">
						<a  class="level_16" onclick="$('#LevelMines').val(16);$('.mines__bomb.Level a').removeClass('mines__bomb--active');$(this).addClass('mines__bomb--active');updateLevel()">1</a>
						<a  class="mines__bomb--active level_25"  onclick="$('#LevelMines').val(25);$('.mines__bomb.Level a').removeClass('mines__bomb--active');$(this).addClass('mines__bomb--active');updateLevel()">2</a>
						<a  class="level_36" onclick="$('#LevelMines').val(36);$('.mines__bomb.Level a').removeClass('mines__bomb--active');$(this).addClass('mines__bomb--active');updateLevel()">3</a>
						<a  class="level_49" onclick="$('#LevelMines').val(49);$('.mines__bomb.Level a').removeClass('mines__bomb--active');$(this).addClass('mines__bomb--active');updateLevel()">4</a>
					</div>
				</div>
			</div>
			<div class="bx-input start_block_mine" style="display: none;">
				<a  onclick="disable(this);startGameMineNew(this)" class="btn btn--blue d-flex align-center justify-center is-ripples flare"><span>Начать игру</span></a>
				
			</div>
			<div class="bx-input mines__buttons play_block_mine" style="display:none">
				<a  onclick="disable(this);disable('.mines__path-item');finishGameMineNew(this)" class="btn btn--blue d-flex align-center justify-center is-ripples flare"><span>Забрать <span id="winMine">0.00</span></span></a>
				<a  onclick="disable(this);autoClickMineNew(this)" class="btn d-flex align-center justify-center is-ripples flare"><span>Авто-выбор</span></a>
			</div>
			<div class="bx-input">
				<div class="mines__x">
					<div class="mines__scroll d-flex align-center">
						
					</div>
				</div>
			</div>
		</div>
		<div class="mines__right">
			<div class="mines__path d-flex justify-space-between flex-wrap">
				
			</div>
		</div>
		<div class="x30__bonus mines__bonus d-flex align-center" style="display: none;">
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
	</div>
</div>
<div class="wrapper">
	@include('layouts.history')
</div>

<script type="text/javascript">
	createMinePole(25)
	updateMinesXNew()
	getGameMineNew()
</script>

@auth
<script type="text/javascript">
    socket.emit('subscribe', 'roomGame_4_{{\Auth::user()->id}}');
</script>
@endauth