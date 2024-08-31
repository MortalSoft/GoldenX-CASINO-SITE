
<div class="wrapper">
    <div style="margin-top: 35px;" class="shoot">
        <div class="shoot__live" id="tir">
            <div class="shoot__live-drop-cursor">
                <img src="images/games/shoot/cursor.png"> 
            </div>
            <div class="shoot__live-drop">
                <div class="shoot__live-drop-scroll d-flex" id="livedrops">



                </div>
                <div class="shoot__live-drop-game d-flex align-center justify-center">
                    <a class="btn btn--orange is-ripples flare d-flex align-center has-ripple" id="game" onclick="disable(this);startGameShoot(this);"><span>Испытать удачу</span></a>
                    <a class="btn btn--orange is-ripples flare d-flex align-center has-ripple" onclick="disable(this);shootGame(this);" style="display: none;" id="shoot"><span>Стрелять</span></a>
                </div>
            </div>
        </div>
        <!-- CASH HUNT WINDOW -->
        <div class="shoot__live shoot__live--game d-flex flex-column align-center justify-center" id="cashhunt" style="display: none;">
            <div class="shoot__game-wrapper CashHunt">
                <div class="cash-hunt d-flex justify-center">
                    <div class="cash-hunt__logo"></div>
                    <div class="cash-hunt__inner">
                
                    </div>
                </div>
                <div class="shoot__live-drop-game d-flex align-center justify-center">
                    <a onclick="disable(this);startCashHuntGame(this)" class="btn btn--orange is-ripples flare d-flex align-center has-ripple"><span>Играть</span></a>
                </div>
            </div>
        </div>
        <!-- ###### -->

        <!-- COINFLIP WINDOW -->
        <div class="shoot__live shoot__live--game d-flex flex-column align-center justify-center" id="coinflip" style="display: none;">
            <div class="shoot__game-wrapper">
                <div class="coinflip">
                    <div class="coinflip__inner" id="coinSliderX">
                        <div class="coinflip__slider coinflip__slider--orel d-flex flex-column justify-center align-center">
                            <div class="coinflip__slider-i">
                                <img src="images/games/coin/coin--orel.png">
                            </div>
                            <div class="coinflip__slider-block">
                                <div class="coinflip__slider-scroll d-flex Orel">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="coinflip__wrapper" id="coin">
                            <div class="side-a"></div>
                            <div class="side-b"></div>   
                        </div>
                        <div class="coinflip__slider coinflip__slider--reshka d-flex flex-column justify-center align-center">
                            <div class="coinflip__slider-i">
                                <img src="images/games/coin/coin--reshka.png">
                            </div>
                            <div class="coinflip__slider-block">
                                <div class="coinflip__slider-scroll d-flex Reshka">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="coinflip__inner" id="coinGame" style="display: none;">
                        
                        <div class="coinflip__x-block d-flex align-center justify-center">
                            <div class="d-flex align-center">
                                <img src="images/games/coin/coin--orel.png">
                                <b style="color: #FFBA2F;" id="orelCoeff"></b>
                            </div>
                        </div>
                        <div class="coinflip__wrapper" id="gameCoin">
                            <div class="side-a"></div>
                            <div class="side-b"></div>    
                        </div>
                        <div class="coinflip__x-block d-flex align-center justify-center">
                            <div class="d-flex align-center">
                                <img src="images/games/coin/coin--reshka.png">
                                <b style="color: #3C8AFF;" id="reshkaCoeff"></b>
                            </div>
                        </div> 
                    </div>
                </div>
                
            </div>
        </div>
        <!-- ###### -->

        <!-- CRAZYGAME WINDOW -->
        <div class="shoot__live shoot__live--game d-flex flex-column align-center justify-center" id="crazygame" style="display: none;">
            <div class="shoot__game-wrapper" style="width: 650px;">
                <div class="crazygame">
                    <div class="crazygame__container">
                        <div class="crazygame__game-select">
                            <div class="d-flex flex-column align-center justify-center">
                                <h4>Примите ваше решение:</h4>
                                <div class="crazygame__game-selects d-flex align-center">
                                    <a onclick="disable('.crazygame__game-selects a');selectCrazytime(1)"></a>
                                    <a onclick="disable('.crazygame__game-selects a');selectCrazytime(2)"></a>
                                    <a onclick="disable('.crazygame__game-selects a');selectCrazytime(3)"></a>
                                </div>
                            </div>
                        </div>
                        <div class="crazygame__center-ellipse d-flex align-center justify-center"></div>
                        <div class="crazygame__center-ellipse-border"></div>
                        <div class="crazygame__ctx">
                            <div class="crazygame__cursor d-flex justify-center align-start">
                                <img src="images/games/сursor--for.svg?v=3"> 
                            </div>
                            <div class="crazygame__cursor crazygame__cursor--two d-flex justify-center align-start">
                                <img src="images/games/cursor--two.svg"> 
                            </div>
                            <div class="crazygame__cursor crazygame__cursor--three d-flex justify-center align-start">
                                <img src="images/games/cursor--three.svg"> 
                            </div>
                            <div class="crazygame__wheel-center d-flex align-center justify-center">
                                <div class="crazygame__wheel-center-border d-flex align-center justify-center">
                                    <img src="images/logotype--dark.svg">
                                </div>
                            </div>
                            <ul class="crazygame__wheel">
                                
                            </ul>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- ###### -->

        <!-- POCHINKO WINDOW -->
        <div class="shoot__live shoot__live--game d-flex flex-column align-center justify-center" id="pochinko" style="display: none;">
            <div class="shoot__game-wrapper Pachinko" style="width: 460px;">
                
                <div class="pochinko d-flex flex-column justify-space-between">
                    <div class="pochinko__canvas">
                        <div style="position: relative;" id="insertCanvas"></div>
                    </div>
                    <div></div>
                    <div class="pochinko__lvls">
                        <div class="pochinko__lvl d-flex align-center justify-center flex-column">
                            <div class="pochinko__lvl-x">
                                <span></span>
                            </div>
                        </div>
                        <div class="pochinko__lvl d-flex align-center justify-center flex-column">
                            <div class="pochinko__lvl-x">
                                <span></span>
                            </div>
                        </div>
                        <div class="pochinko__lvl d-flex align-center justify-center flex-column">
                            <div class="pochinko__lvl-x">
                             <span></span>
                         </div>
                     </div>
                     <div class="pochinko__lvl d-flex align-center justify-center flex-column">
                        <div class="pochinko__lvl-x">
                            <span></span>
                        </div>
                    </div>
                    <div class="pochinko__lvl d-flex align-center justify-center flex-column">
                        <div class="pochinko__lvl-x">
                            <span></span>
                        </div>
                    </div>
                    <div class="pochinko__lvl d-flex align-center justify-center flex-column">
                        <div class="pochinko__lvl-x">
                            <span></span>
                        </div>
                    </div>
                    <div class="pochinko__lvl d-flex align-center justify-center flex-column">
                        <div class="pochinko__lvl-x">
                            <span></span>
                        </div>
                    </div>
                    <div class="pochinko__lvl d-flex align-center justify-center flex-column">
                        <div class="pochinko__lvl-x">
                            <span></span>
                        </div>
                    </div>
                    <div class="pochinko__lvl d-flex align-center justify-center flex-column">
                        <div class="pochinko__lvl-x">
                            <span></span>
                        </div>
                    </div>
                    <div class="pochinko__lvl d-flex align-center justify-center flex-column">
                        <div class="pochinko__lvl-x">
                            <span></span>
                        </div>
                    </div>
                    <div class="pochinko__lvl d-flex align-center justify-center flex-column">
                        <div class="pochinko__lvl-x">
                            <span></span>
                        </div>
                    </div>
                    <div class="pochinko__lvl d-flex align-center justify-center flex-column">
                        <div class="pochinko__lvl-x">
                            <span></span>
                        </div>
                    </div>
                    <div class="pochinko__lvl d-flex align-center justify-center flex-column">
                        <div class="pochinko__lvl-x">
                            <span></span>
                        </div>
                    </div>
                    <div class="pochinko__lvl d-flex align-center justify-center flex-column">
                        <div class="pochinko__lvl-x">
                            <span></span>
                        </div>
                    </div>
                    <div class="pochinko__lvl d-flex align-center justify-center flex-column">
                        <div class="pochinko__lvl-x">
                            <span></span>
                        </div>
                    </div>
                    <div class="pochinko__lvl d-flex align-center justify-center flex-column">
                        <div class="pochinko__lvl-x">
                            <span></span>
                        </div>
                    </div>                        
                </div>
            </div>
        </div>
    </div>
    <!-- ###### -->
    <div class="shoot__bet d-flex justify-center align-center">
        <a onclick="clearShootBet()" class="shoot__bet-btn-settings d-flex align-center">
            <svg class="icon" style="width: 18px;"><use xlink:href="images/symbols.svg#close"></use></svg>
            <span>Сбросить</span>
        </a>
        <div class="shoot__bet-btns d-flex align-center">
            <a class="active">1</a>
            <a>10</a>
            <a>50</a>
            <a>100</a>
            <a>1k</a>
            <a>5k</a>
        </div>
        <a onclick="repeatShootBet()" class="shoot__bet-btn-settings d-flex align-center">
            <svg class="icon"><use xlink:href="images/symbols.svg?v=5#refresh"></use></svg>
            <span>Повторить</span>
        </a>
    </div>
    <div class="shoot__bets">
        <a onclick="shootBet(1)" class="shoot__bet-item d-flex align-center justify-center shoot__bet-item--1x is-ripples">
            <span>1x</span>
        </a>
        <a onclick="shootBet(2)" class="shoot__bet-item d-flex align-center justify-center shoot__bet-item--2x is-ripples">
            <span>2x</span>
        </a>
        <a onclick="shootBet('cashhunt')" class="shoot__bet-item d-flex align-center justify-space-between shoot__bet-item--bonus shoot__bet-item--cashhunt is-ripples">
            <b><span>CashHunt</span></b>
            <svg class="icon"><use xlink:href="images/symbols.svg#cash-hunt"></use></svg>
        </a>
        <a onclick="shootBet('crazytime')" class="shoot__bet-item d-flex align-center justify-space-between shoot__bet-item--bonus shoot__bet-item--crazygame is-ripples">
            <b><span>CrazyTime</span></b>
            <svg class="icon"><use xlink:href="images/symbols.svg#x30"></use></svg>
        </a>
        <a onclick="shootBet(5)" class="shoot__bet-item d-flex align-center justify-center shoot__bet-item--5x is-ripples">
            <span>5x</span>
        </a>
        <a onclick="shootBet(10)" class="shoot__bet-item d-flex align-center justify-center shoot__bet-item--10x is-ripples">
            <span>10x</span>
        </a>
        <a onclick="shootBet('coinflip')" class="shoot__bet-item d-flex align-center justify-space-between shoot__bet-item--bonus shoot__bet-item--coinflip is-ripples">
            <b><span>CoinFlip</span></b>
            <svg class="icon"><use xlink:href="images/symbols.svg?v=5#coinflip"></use></svg>
        </a>
        <a onclick="shootBet('pachinko')" class="shoot__bet-item d-flex align-center justify-space-between shoot__bet-item--bonus shoot__bet-item--pochinko is-ripples"> 
            <b><span>Pachinko</span></b>
            <svg class="icon"><use xlink:href="images/symbols.svg?v=7#pochinko"></use></svg>
        </a>
    </div>
</div>
</div>


<script src="js/games/shoot.js?v={{time()}}" type="text/javascript"></script>
<script src="js/pochinko/libraries/p5.js"></script>
<script src="js/pochinko/libraries/p5.dom.min.js"></script>
<script src="js/pochinko/libraries/p5.sound.min.js"></script>
<script src="js/pochinko/libraries/matter.js"></script>
<script src="js/pochinko/ground.js"></script>
<script src="js/pochinko/divisions.js"></script>
<script src="js/pochinko/Plinko.js?v=6"></script>
<script src="js/pochinko/Particle.js?v=12"></script>
<script src="js/pochinko/sketch.js?v=15" type="text/javascript"></script>



<script type="text/javascript"> 
    var radius = 12 * 600 / 600
    function go() {
        PosX = Number($('#PosX').val())
        particles.push(new Particle(PosX, 0,radius));
    }

    function checkWidth(){
        widthBlock = $('.shoot__game-wrapper.Pachinko').width()

        scaleBlock = widthBlock / 600

        heightBlock = 808 * scaleBlock
        $('.shoot .pochinko').css('height', heightBlock+'px')

        $('#insertCanvas canvas').css('transform', 'scale('+scaleBlock+')')

    }

    window.onresize = function(event) {
        checkWidth()
    };

</script>

@auth
<script type="text/javascript">
    socket.emit('subscribe', 'roomGame_0_{{\Auth::user()->id}}');
</script>
@endauth