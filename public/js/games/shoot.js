var crazyColors = {'1': '#36717A', '2': '#AC8D69', '5': '#7C5D63', '10': '#605C7C', 'coinflip': '', 'pachinko': '', 'cashhunt': '', 'crazytime': ''}

var crazyCoeffs = [
5, 1, 2, 'pachinko', 1, 5, 1, 'bonusX3',2, 1, 'coinflip', 1, 2, 1, 10, 2, 'cashhunt', 1, 2, 1, 5, 1, 'coinflip', 1, 5, 2, 10, 1, 'pachinko', 1, 2, 5, 'bonusX5', 1, 2, 'coinflip', 1, 10, 2, 5, 1, 'cashhunt', 1, 2, 5, 1, 2, 'coinflip', 2, 1, 10, 2, 1, 'crazytime', 1, 2
];

var goLeft = 0

var lastBetsCrazy = {}
var lastSumBetsCrazy = 0
var timeout
var sumBetCrazyX1 = 0
var sumBetCrazyX2 = 0
var sumBetCrazyX5 = 0
var sumBetCrazyX10 = 0
var sumBetCrazyCoinflip = 0 
var sumBetCrazyPachinko = 0
var sumBetCrazyCashhunt = 0
var sumBetCrazyCrazytime = 0

var sumBetsCrazy = 0

var betSumShoot = 1

var selectCashHuntId = -1

var informationPachinko = []

function shootBet(coeff) {
    var balanceUser = $('#balance').attr('balance')

    if(sumBetsCrazy + betSumShoot > balanceUser){
        return notification('error', 'Недостаточно средств')
    }

    sumBetsCrazy += betSumShoot

    if(coeff == 1){
        sumBetCrazyX1 += betSumShoot
        $('.shoot__bet-item--1x span').html(sumBetCrazyX1+' P')
    }

    if(coeff == 2){
        sumBetCrazyX2 += betSumShoot
        $('.shoot__bet-item--2x span').html(sumBetCrazyX2+' P')
    }

    if(coeff == 5){
        sumBetCrazyX5 += betSumShoot
        $('.shoot__bet-item--5x span').html(sumBetCrazyX5+' P')
    }

    if(coeff == 10){
        sumBetCrazyX10 += betSumShoot
        $('.shoot__bet-item--10x span').html(sumBetCrazyX10+' P')
    }

    if(coeff == 'coinflip'){
        sumBetCrazyCoinflip += betSumShoot
        $('.shoot__bet-item--coinflip span').html(sumBetCrazyCoinflip+' P')
    }

    if(coeff == 'pachinko'){
        sumBetCrazyPachinko += betSumShoot
        $('.shoot__bet-item--pochinko span').html(sumBetCrazyPachinko+' P')
    }

    if(coeff == 'cashhunt'){
        sumBetCrazyCashhunt += betSumShoot
        $('.shoot__bet-item--cashhunt span').html(sumBetCrazyCashhunt+' P')
    }

    if(coeff == 'crazytime'){
        sumBetCrazyCrazytime += betSumShoot
        $('.shoot__bet-item--crazygame span').html(sumBetCrazyCrazytime+' P')
    }

}

function clearShootBet() {
    sumBetCrazyX1 = 0
    sumBetCrazyX2 = 0
    sumBetCrazyX5 = 0
    sumBetCrazyX10 = 0
    sumBetCrazyCoinflip = 0
    sumBetCrazyPachinko = 0
    sumBetCrazyCashhunt = 0
    sumBetCrazyCrazytime = 0
    sumBetsCrazy = 0

    $('.shoot__bet-item--1x span').html('1x')
    $('.shoot__bet-item--2x span').html('2x')
    $('.shoot__bet-item--5x span').html('5x')
    $('.shoot__bet-item--10x span').html('10x')

    $('.shoot__bet-item--coinflip span').html('CoinFlip')
    $('.shoot__bet-item--pochinko span').html('Pachinko')
    $('.shoot__bet-item--cashhunt span').html('CashHunt')
    $('.shoot__bet-item--crazygame span').html('CrazyTime')
}

function repeatShootBet() {

    sumBetsCrazy = lastSumBetsCrazy

    if(lastBetsCrazy['1'] > 0){
        sumBetCrazyX1 = Number(lastBetsCrazy['1'])
        $('.shoot__bet-item--1x span').html(sumBetCrazyX1+' P')
    }
    
    if(lastBetsCrazy['2'] > 0){
        sumBetCrazyX2 = Number(lastBetsCrazy['2'])
        $('.shoot__bet-item--2x span').html(sumBetCrazyX2+' P')
    }

    if(lastBetsCrazy['5'] > 0){
        sumBetCrazyX5 = Number(lastBetsCrazy['5'])
        $('.shoot__bet-item--5x span').html(sumBetCrazyX5+' P')
    }
    
    if(lastBetsCrazy['10'] > 0){
        sumBetCrazyX10 = Number(lastBetsCrazy['10'])
        $('.shoot__bet-item--10x span').html(sumBetCrazyX10+' P')
    }
    
    if(lastBetsCrazy['coinflip'] > 0){
        sumBetCrazyCoinflip = Number(lastBetsCrazy['coinflip'])
        $('.shoot__bet-item--coinflip span').html(sumBetCrazyCoinflip+' P')
    }
    
    if(lastBetsCrazy['pachinko'] > 0){
        sumBetCrazyPachinko = Number(lastBetsCrazy['pachinko'])
        $('.shoot__bet-item--pochinko span').html(sumBetCrazyPachinko+' P')
    }
    
    if(lastBetsCrazy['cashhunt'] > 0){
        sumBetCrazyCashhunt = Number(lastBetsCrazy['cashhunt'])
        $('.shoot__bet-item--cashhunt span').html(sumBetCrazyCashhunt+' P')
    }
    
    if(lastBetsCrazy['crazytime'] > 0){
        sumBetCrazyCrazytime = Number(lastBetsCrazy['crazytime'])
        $('.shoot__bet-item--crazygame span').html(sumBetCrazyCrazytime+' P')
    }
    
}


function startAnimateShootScroll() {
    maxRast = (131*49) - (Number($('.shoot__live-drop').width())/2)
    
    rast = $('.shoot__live-drop-scroll').position()['left']
    rast = Math.abs(rast)

    if(rast <= 0){
        goLeft = 1
        $('.shoot__live-drop-scroll').css('transition', '80s').css('transition-timing-function', 'linear').css('transform', 'translateX(-'+maxRast+'px)')
        timeout = setTimeout(function() {
            startAnimateShootScroll()
        }, 80000)
    }

    else if(rast >= maxRast - 50){
        goLeft = 0
        $('.shoot__live-drop-scroll').css('transition', '80s').css('transition-timing-function', 'linear').css('transform', 'translateX(0px)')
        timeout = setTimeout(function() {
            startAnimateShootScroll()
        }, 80000)
    }

    

}

function stopAnimateShootScroll(stop) {
    $('.shoot__live-drop-scroll').css('transition', '2s').css('transition-timing-function', 'linear').css('transform', 'translateX('+(stop + 1)+'px)')
}

function restartAnimateShootScroll(time = 3) {
    maxRast = (131*49) - (Number($('.shoot__live-drop').width())/2)

    goTo = Number($('.shoot__live-drop').width())/2
    r = 0
    if(goLeft == 1){
        r = maxRast * -1
        time = 80 - time
    }
    $('.shoot__live-drop-scroll').css('transition', ''+time+'s').css('transition-timing-function', 'linear').css('transform', 'translateX('+r+'px)')

    setTimeout(function() {
        startAnimateShootScroll()
    }, time * 1000 + 50)

    // startAnimateShootScroll()
}

function selectCashHunt(id){
    selectCashHuntId = id
    $('.cash-hunt__item').removeClass('cash-hunt__item--select')
    $('.cash-hunt__item:eq('+id+')').addClass('cash-hunt__item--select')
}

function startCashHuntGame(that){
    $.post('/shoot/cashhuntstart',{_token: csrf_token, selectCashHuntId}).then(e=>{
        undisable(that)
        if(e.success){
            e.coeffs.forEach(function(item, i, arr) {
                $('.cash-hunt__item.id_'+i+' .cash-hunt__back b').html(item+'x') 
            });

            $('.cash-hunt__item').addClass('cash-hunt__item--result');
            $('.cash-hunt__item:eq('+selectCashHuntId+')').addClass('cash-hunt__item--win');
            
            balanceUpdate(e.lastbalance, e.newbalance) 
            notification('success', 'Вы выиграли '+e.winUser)
            
            setTimeout(() => {                

                $('#tir').slideDown(500);
                $('#cashhunt').slideUp(500);

                setTimeout(() => {
                    setTimeout(function() {
                        // $('.shoot__live-drop-item').removeClass('shoot__live-drop-item--flipped');
                    }, 500) 
                    
                    $('.shoot__live').removeClass('shoot__live-drop-scroll--flipped');

                    setTimeout(function() {
                        $('#game').show();
                        $('#shoot').hide();

                        clearShootBet()

                        $('.cash-hunt__item').removeClass('cash-hunt__item--result');
                        $('.cash-hunt__item').removeClass('cash-hunt__item--win cash-hunt__item--select');

                        selectCashHuntId = -1

                        maxRast = (131*49) - (Number($('.shoot__live-drop').width())/2)
                        restartAnimateShootScroll(80 * Math.abs(rast) / maxRast)
                        $('.shoot__live-drop-cursor').removeClass('shoot__live-drop-cursor--shooting');

                    }, 750)
                }, 500) 


            }, 2000) 


        }else{       
            notification('error',e.mess)
        }
    }).fail(e=>{
        undisable(that)
        notification('error',JSON.parse(e.responseText).message)
    })
}

function startGameShoot(that){
    betsCrazy = {'1': sumBetCrazyX1, '2': sumBetCrazyX2, '5': sumBetCrazyX5, '10': sumBetCrazyX10, 'coinflip': sumBetCrazyCoinflip, 'pachinko': sumBetCrazyPachinko, 'cashhunt': sumBetCrazyCashhunt, 'crazytime': sumBetCrazyCrazytime }
    $.post('/shoot/start',{_token: csrf_token, betsCrazy}).then(e=>{
        undisable(that)
        if(e.success){  
            lastBetsCrazy = betsCrazy
            lastSumBetsCrazy = sumBetsCrazy

            // $('.shoot__live-drop-scroll').removeClass('animate');
            $('#shoot').show();  
            $(that).hide();
            undisable('#shoot')     
            balanceUpdate(e.lastbalance, e.newbalance)   

            $('.shoot__live-drop-item').removeClass('shoot__live-drop-item--flipped');

            // rast = $('.shoot__live-drop-scroll').position()['left']
            

            // maxRast = (131*49) - (Number($('.shoot__live-drop').width())/2)
            // restartAnimateShootScroll(80 * Math.abs(rast) / maxRast)
            
            setTimeout(function() {
                $('.shoot__live').addClass('shoot__live-drop-scroll--flipped');
                // $('.shoot__live-drop-scroll').addClass('animate');
                $('.shoot__live-drop-item .shoot__live-drop-x b').html('')
            }, 100)
        }else{       
            notification('error',e.mess)
        }
    }).fail(e=>{
        undisable(that)
        notification('error',JSON.parse(e.responseText).message)
    })  
}

function getShootGame() {
    $.post('/shoot/get',{_token: csrf_token}).then(e=>{
        if(e.success){ 

            lastBetsCrazy = e.betsCrazy
            lastSumBetsCrazy = e.sumBetsCrazy

            repeatShootBet()

            $('#shoot').show();  
            $('#game').hide();  


            setTimeout(function() {
                $('.shoot__live').addClass('shoot__live-drop-scroll--flipped');
                $('.shoot__live-drop-item .shoot__live-drop-x b').html('')
            }, 100)
            

            if(e.type == 4){
                setTimeout(function() {
                    $('#tir').slideUp(500);
                    $('#cashhunt').slideDown(500);
                    $('.cash-hunt__inner').html('')
                    e.cashHuntGame.forEach(function(item, i, arr) {
                        $('.cash-hunt__inner').append('<div onclick="selectCashHunt('+i+')" class="cash-hunt__item id_'+i+'">\
                            <div class="cash-hunt__front">\
                            <img src="images/games/cashhunt/'+item+'.svg">\
                            </div>\
                            <div class="cash-hunt__back">\
                            <b></b>\
                            </div>\
                            </div>') 
                    });
                }, 100)
            }

            if(e.type == 5){
                setTimeout(function() {
                    $('#tir').slideUp(500);
                    $('#crazygame').slideDown(500);
                    $('.crazygame__wheel').html('')
                    colors = e.colors
                    e.coeffs.forEach(function(item, i, arr) {
                        $('.crazygame__wheel').append('<li id="'+i+'" class="crazygame__wheel-item '+colors[i]+'">\
                            <span>'+item+'</span>\
                            </li>')
                    });
                }, 100)
            }

        }
    }).fail(e=>{
        notification('error',JSON.parse(e.responseText).message)
    })  
}

function infoPachinko(e){
    balanceUpdate(e[0], e[1]) 
    notification('success', 'Вы выиграли '+e[2])
    setTimeout(() => {

        $('#tir').slideDown(500);
        $('#pochinko').slideUp(500);

        setTimeout(() => {
            setTimeout(function() {
                // $('.shoot__live-drop-item').removeClass('shoot__live-drop-item--flipped');
            }, 500)

            // $('.shoot__live-drop-item:eq('+n+')').removeClass('shoot__live-drop-item--flipped');
            $('.shoot__live').removeClass('shoot__live-drop-scroll--flipped');

            setTimeout(function() {
                undisable('#shoot')
                $('#game').show();
                $('#shoot').hide();

                clearShootBet()

                maxRast = (131*49) - (Number($('.shoot__live-drop').width())/2)
                restartAnimateShootScroll(80 * Math.abs(rast) / maxRast)
                $('.shoot__live-drop-cursor').removeClass('shoot__live-drop-cursor--shooting');

            }, 750)
        }, 500) 
    }, 1000) 
}

function selectCrazytime(number){
    $.post('/shoot/crazystart',{_token: csrf_token, number}).then(e=>{
        undisable('.crazygame__game-selects a');
        if(e.success){  
            $('.crazygame__game-select').hide();
            setTimeout(function() {
                $('.crazygame__wheel').css('transition', '15s').css('transform', 'rotate(-'+(e.rotate + (360 * 7))+'deg)')

                setTimeout(function() {
                    balanceUpdate(e.lastbalance, e.newbalance) 
                    notification('success', 'Вы выиграли '+e.winUser)

                    setTimeout(function() {
                        $('.crazygame__game-select').show();
                        $('#tir').slideDown(500);
                        $('#crazygame').slideUp(500);

                        $('.crazygame__wheel').css('transition', '0s').css('transform', 'rotate(0deg)')

                        setTimeout(() => {
                            // $('.shoot__live-drop-item:eq('+n+')').removeClass('shoot__live-drop-item--flipped');
                            setTimeout(function() {
                                // $('.shoot__live-drop-item').removeClass('shoot__live-drop-item--flipped');
                            }, 500)

                            $('.shoot__live').removeClass('shoot__live-drop-scroll--flipped');

                            setTimeout(function() {
                                undisable('#shoot')
                                $('#game').show();
                                $('#shoot').hide();

                                clearShootBet()

                                maxRast = (131*49) - (Number($('.shoot__live-drop').width())/2)
                                restartAnimateShootScroll(80 * Math.abs(rast) / maxRast)
                                $('.shoot__live-drop-cursor').removeClass('shoot__live-drop-cursor--shooting');

                            }, 750)
                        }, 500) 
                    }, 1000)
                }, 15000)
            }, 250)
        }else{       
            notification('error',e.mess)
        }
    }).fail(e=>{
        undisable('.crazygame__game-selects a');
        notification('error',JSON.parse(e.responseText).message)
    }) 
}

function shootGame(that){
    rast = $('.shoot__live-drop-scroll').position()['left']
    stopAnimateShootScroll(rast)

    n = (Math.abs(rast) + (Number($('.shoot__live-drop').width())/2)) / 131
    // n = Math.abs(n)
    n = Math.floor(n)   
    

    $.post('/shoot/go',{_token: csrf_token, number: n}).then(e=>{

        if(e.success){  
            $('.shoot__live-drop-cursor').addClass('shoot__live-drop-cursor--shooting');
            // $('.shoot__live-drop-scroll').removeClass('animate');
            // $('.shoot__live-drop-scroll').css('transform', 'translateX('+rast+'px)')
            

            e.crazyCoeffs.forEach(function(item, i, arr) {
                if(item == 1 || item == 2 || item == 5 || item == 10){
                    coeff = '<div class="shoot__live-drop-x" ><b>x'+item+'</b></div>'
                    coeff1 = item+'x'
                }else{ 
                    if(item == 'cashhunt'){
                        coeff = '<svg class="icon shoot__live-drop-bonus-ico"><use xlink:href="images/symbols.svg#cash-hunt"></use></svg>'
                    }

                    if(item == 'coinflip'){
                        coeff = '<svg class="icon shoot__live-drop-bonus-ico"><use xlink:href="images/symbols.svg?v=5#coinflip"></use></svg>'
                    }

                    if(item == 'crazytime'){
                        coeff = '<svg class="icon shoot__live-drop-bonus-ico"><use xlink:href="images/symbols.svg#x30"></use></svg>'
                    }

                    if(item == 'pachinko'){
                        coeff = '<svg class="icon shoot__live-drop-bonus-ico"><use xlink:href="images/symbols.svg?v=7#pochinko"></use></svg>'
                    }

                    if(item == 'bonusX3'){
                        coeff = '<div class="shoot__live-drop-x" ><b>3x</b></div>'
                    }

                    if(item == 'bonusX5'){
                        coeff = '<div class="shoot__live-drop-x" ><b>5x</b></div>'
                    }

                    coeff1 = item
                }



                $('.shoot__live-drop-item:eq('+i+')').html(' <div class="shoot__live-drop-front d-flex align-center justify-center">\
                    '+coeff+'\
                    <div class="shoot__live-drop-x-pattern"></div>\
                    </div>\
                    <div class="shoot__live-drop-back d-flex align-center justify-center">\
                    <img class="shoot__live-drop-img-not" src="images/games/shoot/shoot-close.svg">\
                    </div>')
                

                $('.shoot__live-drop-item:eq('+i+')').removeClass('shoot__live-drop-item--1x shoot__live-drop-item--2x shoot__live-drop-item--5x shoot__live-drop-item--10x')
                $('.shoot__live-drop-item:eq('+i+')').removeClass('shoot__live-drop-item--bonusX3 shoot__live-drop-item--bonusX5 shoot__live-drop-item--cashhunt shoot__live-drop-item--coinflip shoot__live-drop-item--crazytime shoot__live-drop-item--pachinko')
                $('.shoot__live-drop-item:eq('+i+')').addClass('shoot__live-drop-item--'+coeff1)

            });

            setTimeout(function() {
                console.log(n)

                $('.shoot__live-drop-item:eq('+n+')').addClass('shoot__live-drop-item--flipped');
                // $('.shoot__live').removeClass('shoot__live-drop-scroll--flipped');
                
                if(e.type == 1){
                    balanceUpdate(e.lastbalance, e.newbalance) 
                    notification('success', 'Вы выиграли '+e.winUser)
                }               
            }, 50)

            if(e.type == 5){
                clearTimeout(timeout)
                setTimeout(function() {
                    $('#tir').slideUp(500);
                    $('#crazygame').slideDown(500);
                    $('.crazygame__wheel').html('')
                    colors = e.colors
                    e.coeffs.forEach(function(item, i, arr) {
                        $('.crazygame__wheel').append('<li id="'+i+'" class="crazygame__wheel-item '+colors[i]+'">\
                            <span>'+item+'</span>\
                            </li>')
                    });
                }, 700)
                return
            }

            if(e.type == 4){
                clearTimeout(timeout)
                setTimeout(function() {
                    $('#tir').slideUp(500);
                    $('#cashhunt').slideDown(500);
                    $('.cash-hunt__inner').html('')
                    e.images.forEach(function(item, i, arr) {
                        $('.cash-hunt__inner').append('<div onclick="selectCashHunt('+i+')" class="cash-hunt__item id_'+i+'">\
                            <div class="cash-hunt__front">\
                            <img src="images/games/cashhunt/'+item+'.svg">\
                            </div>\
                            <div class="cash-hunt__back">\
                            <b></b>\
                            </div>\
                            </div>')
                    });
                }, 700)
                return
            }

            if(e.type == 3){
                clearTimeout(timeout)
                setTimeout(function() {
                    $('#tir').slideUp(500);
                    $('#pochinko').slideDown(500);

                    e.pachinkoCoeffs.forEach(function(item, i, arr) {
                        if(item == 'Double'){
                            textT = item
                        }else{
                            textT = item+'<span class="x--text">x</span>'
                        }
                        $('.pochinko__lvls .pochinko__lvl:eq('+i+') .pochinko__lvl-x span').html(textT)
                    });

                    informationPachinko = [e.lastbalance, e.newbalance, e.winUser]

                    setTimeout(function() {
                        checkWidth()
                        setTimeout(function() {
                            particles.push(new Particle(e.position, 0, 12));
                        }, 500)
                    }, 550)
                }, 700)
                return
            }

            if(e.type == 2){
                clearTimeout(timeout)
                setTimeout(function() {
                    $('#tir').slideUp(500);
                    $('#coinflip').slideDown(500);
                    $('.coinflip__slider-scroll').html('')
                    e.coin1Coeffs.forEach(function(item, i, arr) {
                        $('.coinflip__slider-scroll.Reshka').append('<div class="coinflip__slider-item d-flex justify-center align-center">\
                            <b>x'+item+'</b>\
                            </div>')
                    });

                    e.coin2Coeffs.forEach(function(item, i, arr) {
                        $('.coinflip__slider-scroll.Orel').append('<div class="coinflip__slider-item d-flex justify-center align-center">\
                            <b>x'+item+'</b>\
                            </div>')
                    });

                    $('#reshkaCoeff').html(e.reshkaCoeff+'x');
                    $('#orelCoeff').html(e.orelCoeff+'x');

                    setTimeout(function() {   
                        x = (52*50) - (Number($('.coinflip__slider-block').width())/2) + rand(10, 40)

                        $('.coinflip__slider-scroll').css('transition', '5s').css('transform', 'translateX(-'+x+'px)')
                        
                        setTimeout(function() {
                            $('#coinSliderX').slideUp(500);
                            $('#coinGame').slideDown(500);

                            $('.coinflip__wrapper').removeClass('animated flip_1 flip_2')
                            setTimeout(() => {
                                $('.coinflip__wrapper').addClass('animated flip_'+e.winType)

                                setTimeout(() => {
                                    balanceUpdate(e.lastbalance, e.newbalance) 
                                    notification('success', 'Вы выиграли '+e.winUser)

                                    $('#tir').slideDown(500);
                                    $('#coinflip').slideUp(500);

                                    $('#coinSliderX').slideDown(500);
                                    $('#coinGame').slideUp(500);

                                    $('.coinflip__wrapper').removeClass('animated flip_1 flip_2')
                                    $('.coinflip__slider-scroll').css('transition', '0s').css('transform', 'translateX(0px)')

                                    setTimeout(() => {
                                        setTimeout(function() {
                                            // $('.shoot__live-drop-item').removeClass('shoot__live-drop-item--flipped');
                                        }, 500)
                                        // $('.shoot__live-drop-item:eq('+n+')').removeClass('shoot__live-drop-item--flipped');
                                        $('.shoot__live').removeClass('shoot__live-drop-scroll--flipped');

                                        setTimeout(function() {
                                            undisable(that)
                                            $('#game').show();
                                            $(that).hide();
                                            
                                            clearShootBet()

                                            maxRast = (131*49) - (Number($('.shoot__live-drop').width())/2)
                                            restartAnimateShootScroll(80 * Math.abs(rast) / maxRast)
                                            $('.shoot__live-drop-cursor').removeClass('shoot__live-drop-cursor--shooting');

                                        }, 750)
                                    }, 500) 


                                }, 3000) 
                            }, 1000) 

                        }, 6000)

                    }, 700)
                    
                }, 700)
                return
            }

            setTimeout(function() {
                setTimeout(function() {
                    // $('.shoot__live-drop-item').removeClass('shoot__live-drop-item--flipped');
                }, 500)
                // $('.shoot__live-drop-item:eq('+n+')').removeClass('shoot__live-drop-item--flipped');
                $('.shoot__live').removeClass('shoot__live-drop-scroll--flipped');
                
            }, 750)

            clearTimeout(timeout)

            if(e.muliPlayer == 1){
                setTimeout(function() {
                    notification('success', 'Поздравляем! Ваша ставка умножилась на '+e.multiCoeff+'')
                    lastBetsCrazy = e.newBets
                    lastSumBetsCrazy = e.newSumBets
                    repeatShootBet();

                    maxRast = (131*49) - (Number($('.shoot__live-drop').width())/2)
                    restartAnimateShootScroll(80 * Math.abs(rast) / maxRast)
                    $('.shoot__live-drop-cursor').removeClass('shoot__live-drop-cursor--shooting');
                }, 800)

                setTimeout(function() {
                    $('.shoot__live-drop-item').removeClass('shoot__live-drop-item--flipped');
                    $('.shoot__live').addClass('shoot__live-drop-scroll--flipped');

                    $('.shoot__live-drop-item .shoot__live-drop-x b').html('')
                    undisable(that)
                    
                }, 1800)
                return
            }


            setTimeout(function() {
                undisable(that)
                $('#game').show();
                $(that).hide();
                
                clearShootBet()

                maxRast = (131*49) - (Number($('.shoot__live-drop').width())/2)
                restartAnimateShootScroll(80 * Math.abs(rast) / maxRast)

                // $('.shoot__live-drop-scroll').addClass('animate');
                $('.shoot__live-drop-cursor').removeClass('shoot__live-drop-cursor--shooting');
            }, 1500)

        }else{      
            undisable(that) 
            notification('error',e.mess)
        }
    }).fail(e=>{
        undisable(that)
        notification('error',JSON.parse(e.responseText).message)
    })  
}

$(document).ready(function() {
    // $('#game').click(function(e) {
    //     e.preventDefault();
    //     $('.shoot__live').addClass('shoot__live-drop-scroll--flipped');
    //     $('.shoot__live-drop-scroll').removeClass('animate');
    //     $('#shoot').show();
    //     $(this).hide();
    // });
    $('.shoot__bet-btns a').click(function(){
        sum = $(this).html()
        if(sum == '1k'){
            sum = 1000
        }
        if(sum == '5k'){
            sum = 5000
        }

        betSumShoot = Number(sum)

        if($(this).hasClass('active')) {

        } else {
            $('.shoot__bet-btns a.active').removeClass('active');
            $(this).addClass('active');
        }
    });
    // cashhunt
    // $('#shoot').click(function(){
    //     $('#tir').slideUp(500);
    //     $('#cashhunt').slideDown(500);
    //     setTimeout(function() {
    //         $('.shoot .cash-hunt__item').addClass('cash-hunt__item--result');
    //     }, 2000)
    // });

    // coinflip
    // $('#shoot').click(function(){
    //     $('#tir').slideUp(500);
    //     $('#coinflip').slideDown(500);
    //     setTimeout(function() {
    //         $('#xOrel').html('x22');
    //         setTimeout(function() {
    //             $('#coin').addClass('coinflip__wrapper--flip');
    //             setTimeout(function(){
    //                 $('#xReshka').html('x22');
    //                 setTimeout(function() {
    //                     $('#coinSliderX').slideUp(500);
    //                     $('#coinGame').slideDown(500);
    //                 }, 500)
    //             }, 1300)
    //         }, 300)
    //     }, 1000)
    // });

    // crazygame
    // $('#shoot').click(function() {
    //     $('#tir').slideUp(500);
    //     $('#crazygame').slideDown(500);
    // });

    // pochinko
    // $('#shoot').click(function() {
    //     $('#tir').slideUp(500);
    //     $('#pochinko').slideDown(500);
    //     setTimeout(function() {
    //         checkWidth()
    //     }, 550)
    // });



    $('.shoot__live-drop-scroll').html('')

    crazyCoeffs.forEach(function(item, i, arr) {
        if(item == 1 || item == 2 || item == 5 || item == 10){
            coeff = '<div class="shoot__live-drop-x" ><b>x'+item+'</b></div>'
            coeff1 = item+'x'
        }else{ 
            if(item == 'cashhunt'){
                coeff = '<svg class="icon shoot__live-drop-bonus-ico"><use xlink:href="images/symbols.svg#cash-hunt"></use></svg>'
            }

            if(item == 'coinflip'){
                coeff = '<svg class="icon shoot__live-drop-bonus-ico"><use xlink:href="images/symbols.svg?v=5#coinflip"></use></svg>'
            }
            
            if(item == 'crazytime'){
                coeff = '<svg class="icon shoot__live-drop-bonus-ico"><use xlink:href="images/symbols.svg#x30"></use></svg>'
            }
            
            if(item == 'pachinko'){
                coeff = '<svg class="icon shoot__live-drop-bonus-ico"><use xlink:href="images/symbols.svg?v=7#pochinko"></use></svg>'
            }

            if(item == 'bonusX3'){
                coeff = '<div class="shoot__live-drop-x" ><b>3x</b></div>'
            }

            if(item == 'bonusX5'){
                coeff = '<div class="shoot__live-drop-x" ><b>5x</b></div>'
            }
            
            coeff1 = item
        }
        $('.shoot__live-drop-scroll').append('<div class="shoot__live-drop-item shoot__live-drop-item--'+coeff1+'">\
            <div class="shoot__live-drop-front d-flex align-center justify-center">\
            '+coeff+'\
            <div class="shoot__live-drop-x-pattern"></div>\
            </div>\
            <div class="shoot__live-drop-back d-flex align-center justify-center">\
            <img class="shoot__live-drop-img-not" src="images/games/shoot/shoot-close.svg">\
            </div>\
            </div>')
    });

    setTimeout(function() {
        startAnimateShootScroll()
        // $('.shoot__live-drop-scroll').addClass('animate')
    }, 500)

    setTimeout(function() {
        checkWidth()
        getShootGame()
    }, 50)

});


