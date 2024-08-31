function diceRange(){
	value = $('.dice__range').val()

	val_pos = value
	pos = 'right'
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

function playDice() {
    var result = ['win', 'lose'],
        chances = [1, 2, 3, 4, 5, 6, 7, 8, 9];

    var height = $('.dice__slider-inner .dice__slider-item').length,
        one = $('.dice__slider-inner .dice__slider-item')[0].offsetHeight;

    $('#dice_n_1').css({'transform':'translateY(-'+ one * chances[Math.floor(Math.random()*chances.length)] +'px)'});
    $('#dice_n_2').css({'transform':'translateY(-'+ one * chances[Math.floor(Math.random()*chances.length)] +'px)'});
    $('#dice_n_3').css({'transform':'translateY(-'+ one * chances[Math.floor(Math.random()*chances.length)] +'px)'});
    $('#dice_n_4').css({'transform':'translateY(-'+ one * chances[Math.floor(Math.random()*chances.length)] +'px)'});

    $('#dice__result').addClass('dice__drum--' + result[Math.floor(Math.random()*result.length)]);
    $('#dice__play').hide();
    $('#dice__replay').show();
    toastr["error"]("Вы проиграли 4 рубля!", "DICE")
}

function newGame() {
    $('#dice__result').removeClass('dice__drum--win');
    $('#dice__result').removeClass('dice__drum--lose');
    $('#dice__play').show();
    $('#dice__replay').hide();
}