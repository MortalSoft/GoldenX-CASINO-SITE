<div class="wrapper">
	<div style="margin-top: 35px;" class="crash coinflip">
		<div class="crash__top d-flex align-stretch justify-space-between">
			<div class="crash__left d-flex flex-column">
				<div class="bx-input d-flex flex-column" style="margin-bottom: 0;">
					<div class="bx-input__input d-flex align-center justify-space-between">
						
							<input class="fullInputWidth" style="text-align: left;" placeholder="0.00" id="coinSum" type="text" value="1.00" placeholder="0.00">
							<svg class="icon money"><use xlink:href="images/symbols.svg#coins"></use></svg>
						
					</div>
					<div class="x30__bet-placed d-flex align-center justify-space-between">
						<a onclick="$('#coinSum').val((Number($('#coinSum').val()) + 10).toFixed(2));">+10</a>
						<a onclick="$('#coinSum').val((Number($('#coinSum').val()) + 100).toFixed(2));">+100</a>
						<a onclick="$('#coinSum').val((Number($('#coinSum').val()) + 1000).toFixed(2));">+1000</a>
						<a onclick="$('#coinSum').val((Number($('#coinSum').val()) * 2).toFixed(2));">x2</a>
						<a onclick="$('#coinSum').val(Math.max((Number($('#coinSum').val()) / 2), 1).toFixed(2));">1/2</a>
					</div> 
				</div>
				<div class="bx-input d-flex flex-column" style="display: none;" id="playCoin">
					<div class="coinflip__placed d-flex align-center justify-space-between">
						<div onclick="disable(this);playCoinGame(this, 1)" class="coinflip__place d-flex align-center justify-center">
							<div>
								<b>Орёл</b>
								<svg class="icon coinflip__place-img">
<svg width="70" height="70" viewBox="0 0 70 70" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M14.2931 8.25769C13.9213 7.19128 12.7225 6.65808 11.6479 7.02722C10.5736 7.39622 10.0361 8.58581 10.408 9.65222C10.8626 10.8827 11.3587 12.072 11.9372 13.2206C12.7225 11.8259 13.6733 10.5544 14.7478 9.36511C14.5824 8.99597 14.4172 8.62696 14.2931 8.25769Z" fill="#2C3349"/>
<path d="M59.5927 9.65235C59.9646 8.58594 59.4273 7.39635 58.3528 7.02735C57.2782 6.65807 56.0794 7.19127 55.7076 8.25782C55.5834 8.62709 55.4183 8.9961 55.2529 9.36538C56.3273 10.5547 57.2782 11.8262 58.0635 13.2208C58.642 12.0721 59.1382 10.8828 59.5927 9.65235Z" fill="#2C3349"/>
<path d="M51.5323 24.7461C51.5323 24.1427 51.3873 23.5643 51.1413 23.0339C49.3197 24.917 47.293 26.5909 45.1099 28.0712C45.791 28.5337 46.5584 28.8476 47.3992 28.8476C49.6777 28.8476 51.5323 27.0071 51.5323 24.7461Z" fill="#2C3349"/>
<path d="M26.9759 24.519C28.8712 22.1766 31.7447 20.6445 35.0005 20.6445C38.2563 20.6445 41.1298 22.1766 43.0251 24.519C48.4957 20.7398 52.8112 15.5155 55.253 9.36523C50.3345 3.70508 43.1016 0 35.0005 0C26.8994 0 19.6665 3.70508 14.748 9.36523C17.1898 15.5155 21.5053 20.74 26.9759 24.519Z" fill="#2C3349"/>
<path d="M61.8653 57.9276V26.7969C61.8653 21.8338 60.5012 17.1991 58.0629 13.2207C56.948 15.5504 55.5118 17.6978 53.9404 19.7445C55.0451 21.1638 55.6656 22.9053 55.6656 24.7461C55.6656 29.2703 51.9583 32.9492 47.3993 32.9492C46.767 32.9492 46.1508 32.8583 45.5477 32.7212C45.7608 34.4628 46.1723 36.1817 46.9634 37.7517L49.2479 42.2859C49.9367 43.6483 48.9298 45.2539 47.3993 45.2539H44.3721L36.7193 56.6453C36.4279 57.0804 35.708 57.5586 34.9999 57.5586C34.3228 57.5586 33.5911 57.1089 33.2806 56.6453L25.6278 45.2539H22.6006C21.0703 45.2539 20.0632 43.6484 20.752 42.2859L23.0365 37.7517C23.8276 36.1817 24.2391 34.4628 24.4522 32.7212C23.849 32.8583 23.2329 32.9492 22.6006 32.9492C18.0416 32.9492 14.3343 29.2703 14.3343 24.7461C14.3343 22.905 14.9551 21.1638 16.0598 19.7445C14.4885 17.698 13.0521 15.5504 11.937 13.2207C9.49869 17.1991 8.13462 21.8338 8.13462 26.7969V57.9276C8.13462 61.0448 6.85335 64.2577 4.6216 66.5135C4.0015 67.0878 3.83631 67.9492 4.16682 68.7285C4.49747 69.5078 5.24144 70 6.06806 70H10.2012C14.4171 70 18.0953 67.457 19.6659 63.8477L25.2871 69.3846C26.0724 70.2049 27.3947 70.2049 28.1801 69.3846L34.9999 62.6581L41.8197 69.3846C42.5632 70.2048 43.9691 70.2052 44.7128 69.3846L50.334 63.8477C51.9046 67.457 55.5829 70 59.7987 70H63.9318C64.7585 70 65.5024 69.5078 65.8332 68.7285C66.1637 67.9492 65.9984 67.0878 65.3784 66.5135C63.1465 64.2577 61.8653 61.0448 61.8653 57.9276Z" fill="#2C3349"/>
<path d="M26.74 39.6087C28.0883 36.928 28.8009 33.9283 28.8009 30.9326C28.8009 27.5402 31.5821 24.7803 35.0006 24.7803C38.4191 24.7803 41.2003 27.5402 41.2003 30.9326C41.2003 33.9283 41.9128 36.928 43.2612 39.6087L44.0998 41.3232H43.2668C42.5722 41.3232 41.9238 41.6697 41.5415 42.2451L35.0006 52.0898L28.4596 42.2451C28.0773 41.6697 27.4291 41.3232 26.7343 41.3232H25.9014L26.74 39.6087Z" fill="#2C3349"/>
<path d="M22.6009 28.8477C23.4417 28.8477 24.2091 28.5338 24.8902 28.0714C22.7071 26.5911 20.6802 24.9171 18.8588 23.0341C18.6128 23.5643 18.4678 24.1428 18.4678 24.7461C18.4678 27.0072 20.3224 28.8477 22.6009 28.8477Z" fill="#2C3349"/>
</svg>
</svg>
							</div>
						</div>
						<div onclick="disable(this);playCoinGame(this, 2)" class="coinflip__place d-flex align-center justify-center">
							<div>
								<b>Решка</b>
								<svg class="icon coinflip__place-img">
<svg width="70" height="70" viewBox="0 0 70 70" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M41.0342 9.15693C37.9289 9.5866 35.6537 10.4153 30.5806 12.9319C27.5368 14.4357 23.8166 16.0623 22.2793 16.5227C19.7582 17.2593 19.051 17.3514 14.4392 17.3514C9.64287 17.382 9.24318 17.3207 7.3062 16.5534C6.16861 16.093 4.72357 15.3872 4.07791 14.9268L2.90958 14.1595L2.78659 14.8347C2.63287 15.9089 3.34002 18.7324 4.20089 20.4204C5.27699 22.5381 7.95186 25.2696 10.1041 26.4051C14.8389 28.9218 19.7582 28.8604 24.5238 26.2824C25.5691 25.6992 26.43 25.3309 26.43 25.4844C26.43 26.0061 23.9396 28.9218 22.7713 29.7504C22.1256 30.2108 21.0495 30.8553 20.3424 31.1622C19.297 31.6532 19.0203 31.9294 18.8666 32.8195C18.6821 33.8016 18.8666 36.9013 19.2355 39.3259L19.42 40.4308L17.1141 41.5663C13.7013 43.285 10.35 44.0216 6.87576 43.8681C4.41611 43.7761 3.77045 43.6226 1.89497 42.6712C-0.195732 41.6584 -0.257223 41.6277 0.296198 42.395C1.34155 43.8681 4.78506 46.9372 6.90651 48.2876C9.7966 50.1597 12.5637 51.2032 16.1917 51.817C18.8666 52.2774 19.9427 52.2774 25.8151 51.9705C33.1325 51.5408 35.2847 51.725 38.0518 52.9833C38.9127 53.3823 39.6506 53.7812 39.6506 53.8733C39.6506 53.9347 38.6053 54.0268 37.3139 54.0268C34.9773 54.0268 30.1195 55.1009 30.1195 55.6227C30.1195 56.1137 35.8074 58.6611 38.4208 59.3363C41.9565 60.2263 47.0603 60.2263 50.5653 59.3056C60.9573 56.5741 68.3978 48.1955 69.8121 37.6686C70.1195 35.1827 70.058 32.6046 69.5661 29.4128L69.3816 28.2773H54.9927L40.573 34.5477V34.5689V34.59L55.6691 40.8604L55.1157 41.8119C54.2548 43.285 52.0103 45.1572 49.7967 46.2006C47.9212 47.0907 47.5522 47.152 44.4162 47.152C41.3724 47.152 40.8497 47.06 39.2509 46.3234C36.945 45.2492 35.3462 43.9602 34.0242 42.1495C30.3039 37.0241 30.7036 30.2721 35.0388 25.6992C39.0357 21.4639 45.4308 20.359 50.3808 23.0598L52.0411 23.9806H59.8812C68.736 23.9806 68.0903 24.2568 66.3071 21.2798C61.8182 13.7912 52.9942 8.85002 44.4162 9.00348C43.0634 9.00348 41.5568 9.09555 41.0342 9.15693Z" fill="#2C3349"/>
</svg>
</svg>
							</div>
						</div>
					</div>
					<a style="margin-top: 15px" id="finishCoinBtn" onclick="disable(this);finishGameCoin(this)" class="btn btn--blue is-ripples flare d-flex align-center justify-center"><span>Забрать <span id="winCoin">1</span></span></a>
				</div>
				<div class="bx-input d-flex flex-column" id="startCoin">
					<a onclick="disable(this);startGameCoin(this)" class="btn btn--blue is-ripples flare d-flex align-center justify-center"><span>Начать игру</span></a>
				</div>

			</div>
			<div class="crash__right d-flex flex-column justify-space-between">
				<div class="coinflip__results d-flex align-center justify-space-between">
					<div class="coinflip__result d-flex align-center justify-space-between">
						<span>Серия:</span>
						<b id="coinStep">0</b>
					</div>
					<div class="coinflip__result d-flex align-center justify-space-between">
						<span>Коэфф.:</span>
						<b id="coinCoeff">x0.00</b>
					</div>
				</div>
				<div class="coinflip__game d-flex align-center justify-center">
					<div class="coinflip__wrapper" id="game">
						<div class="side-a"></div>
						<div class="side-b"></div>    

						<!-- <div class="coinflip__back">
							<img src="images/games/coin/coin--orel.png">
						</div>
						<div class="coinflip__front">
							<img src="images/games/coin/coin--reshka.png">
						</div> -->
					</div>
				</div>
			</div>


		</div>

		<div class="x30__bonus mines__bonus d-flex align-center" style="display: none;margin-top: 15px;">
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
	@include('layouts.history')
</div> 
<style type="text/css">
	
</style>
<script type="text/javascript">
	function getGameCoin(){
		$.post('/coin/get',{_token: csrf_token}).then(e=>{
			if(e.success){	
				$('#coinSum').val(e.bet)
				$('#coinCoeff').html('x'+Number(e.coeff).toFixed(2))
				$('#coinStep').html(e.step)	
				$("#winCoin").html(Number(e.coeff * e.bet).toFixed(2))
				$('#playCoin').show(); 
				$('#startCoin').hide();
				disable('#coinSum')	

				if(e.coeffBonusCoin > 1){
				
				x = (56*43) - (Number($('.mines__bonus').width())/2) + rand(10, 40)
				$('.mines__bonus .x30__bonus-scroll').css({'transition':'0s','transform':'translateX(-'+x+'px)'})

				$('.mines__bonus .x30__bonus-scroll').html('')
				$('.mines__bonus').show()

				bonusIkses = JSON.parse(e.bonusCoin)
				
				bonusIkses.forEach((e)=>{
					$('.mines__bonus .x30__bonus-scroll').append('<div class="x30__bonus-item x30 d-flex align-center justify-center">x'+e+'</div>')

				})	

				



			} 
			}
		}).fail(e=>{
			undisable(that)
			notification('error',JSON.parse(e.responseText).message)
		})	
	} 
	getGameCoin()
</script>

@auth
<script type="text/javascript">
    socket.emit('subscribe', 'roomGame_6_{{\Auth::user()->id}}');
</script>
@endauth