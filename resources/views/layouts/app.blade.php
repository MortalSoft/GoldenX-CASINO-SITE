@php 

$setting = \App\Setting::first();
$snow = 0; 

@endphp
@if(\Auth::guest())
@php $snow = 0;  @endphp
@endif
@if(\Auth::user() && \Auth::user()->admin != 1)
@php $snow = 0;  @endphp
@endif

@php $snow = $setting->theme; @endphp

@if(\Auth::user() && \Auth::user()->ban == 1)
@include('errors.ban')
@php exit() @endphp
@endif
<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$setting->name}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {!! $setting->meta_tags !!}
    <!-- <link rel="icon" type="image/png" href="images/favicon.png" sizes="64x64" /> -->
    <!-- <meta name="msapplication-TileImage" content="images/favicon.png"> -->
    <link rel="apple-touch-icon" sizes="64x64" href="/images/favicon.png">
    <link rel="icon" sizes="64x64" href="/images/favicon.png">

    <link rel="stylesheet" href="/css/main.css?v={{time()}}">

    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>

    @if($snow == 1)
    <link rel="stylesheet" href="/css/snow.css?v={{time()}}">
    <script src="/js/snowfall.jquery.js" type="text/javascript"></script>
    @endif
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-scrollbar@latest/simple-scrollbar.css">
    <script src="https://cdn.jsdelivr.net/npm/simple-scrollbar@latest/simple-scrollbar.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="/js/modal.js" type="text/javascript"></script>
    <script src="/js/ripple.js" type="text/javascript"></script>
    <link rel="stylesheet" href="css/ripple.css">

    <script src="/js/countup.js?v={{time()}}" type="text/javascript"></script>


    <script
    src="https://hcaptcha.com/1/api.js?render=explicit"
    async
    defer
    ></script>

    <!-- <script async src="https://telegram.org/js/telegram-widget.js?21" data-telegram-login="betusxbot" data-size="large" data-auth-url="https://betusx.pro/tg/auth/callback" data-request-access="write"></script>
    <script src="https://telegram.org/js/widget-frame.js?60" data-telegram-login="betusxbot" data-size="large" data-auth-url="https://betusx.pro/tg/auth/callback" data-request-access="write"></script> -->

</head> 

@include('layouts.colors_systems')

<body class="theme--dark">

    <div class="winter" style="display:none;">
        <img src="images/snow/christmas.png" class="winter__bg" alt="">
        <img src="images/snow/christmas.png" class="winter__bg--2" alt="">
        <div class="winter__canvas">
            <canvas width="640" height="480" id="fireworks-canvas"></canvas>
            <canvas width="640" height="480" id="fireworks-canvas2"></canvas>
        </div>
        <div class="winter__wrapper d-flex align-center justify-center flex-column">
            <h3>Выберите подарок</h3>
            <div class="winter__wrapper-inner">
                <div class="winter__item" onclick="disable('.winter__item');openWinter(1)">
                    <div class="winter__front d-flex align-center justify-center">
                        <span></span>
                    </div>
                    <div class="winter__back d-flex align-center justify-center">
                        <span>?</span>
                    </div>
                </div>
                <div class="winter__item" onclick="disable('.winter__item');openWinter(2)">
                    <div class="winter__front d-flex align-center justify-center">
                        <span></span>
                    </div>
                    <div class="winter__back d-flex align-center justify-center">
                        <span>?</span>
                    </div>
                </div>
                <div class="winter__item" onclick="disable('.winter__item');openWinter(3)">
                    <div class="winter__front d-flex align-center justify-center">
                        <span></span>
                    </div>
                    <div class="winter__back d-flex align-center justify-center">
                        <span>?</span>
                    </div>
                </div>
                <div class="winter__item" onclick="disable('.winter__item');openWinter(4)">
                    <div class="winter__front d-flex align-center justify-center">
                        <span></span>
                    </div>
                    <div class="winter__back d-flex align-center justify-center">
                        <span>?</span>
                    </div>
                </div>
                <div class="winter__item" onclick="disable('.winter__item');openWinter(5)">
                    <div class="winter__front d-flex align-center justify-center">
                        <span></span>
                    </div>
                    <div class="winter__back d-flex align-center justify-center">
                        <span>?</span>
                    </div>
                </div>
                <div class="winter__item" onclick="disable('.winter__item');openWinter(6)">
                    <div class="winter__front d-flex align-center justify-center">
                        <span></span>
                    </div>
                    <div class="winter__back d-flex align-center justify-center">
                        <span>?</span>
                    </div>
                </div>
                <div class="winter__item" onclick="disable('.winter__item');openWinter(7)">
                    <div class="winter__front d-flex align-center justify-center">
                        <span></span>
                    </div>
                    <div class="winter__back d-flex align-center justify-center">
                        <span>?</span>
                    </div>
                </div>
                <div class="winter__item" onclick="disable('.winter__item');openWinter(8)">
                    <div class="winter__front d-flex align-center justify-center">
                        <span></span>
                    </div>
                    <div class="winter__back d-flex align-center justify-center">
                        <span>?</span>
                    </div>
                </div>
                <div class="winter__item" onclick="disable('.winter__item');openWinter(9)">
                    <div class="winter__front d-flex align-center justify-center">
                        <span></span>
                    </div>
                    <div class="winter__back d-flex align-center justify-center">
                        <span>?</span>
                    </div>
                </div>
                <div class="winter__item" onclick="disable('.winter__item');openWinter(10)">
                    <div class="winter__front d-flex align-center justify-center">
                        <span></span>
                    </div>
                    <div class="winter__back d-flex align-center justify-center">
                        <span>?</span>
                    </div>
                </div>
                <div class="winter__item" onclick="disable('.winter__item');openWinter(11)">
                    <div class="winter__front d-flex align-center justify-center">
                        <span></span>
                    </div>
                    <div class="winter__back d-flex align-center justify-center">
                        <span>?</span>
                    </div>
                </div>
                <div class="winter__item" onclick="disable('.winter__item');openWinter(12)">
                    <div class="winter__front d-flex align-center justify-center">
                        <span></span>
                    </div>
                    <div class="winter__back d-flex align-center justify-center">
                        <span>?</span>
                    </div>
                </div>
                <div class="winter__item" onclick="disable('.winter__item');openWinter(13)">
                    <div class="winter__front d-flex align-center justify-center">
                        <span></span>
                    </div>
                    <div class="winter__back d-flex align-center justify-center">
                        <span>?</span>
                    </div>
                </div>
                <div class="winter__item" onclick="disable('.winter__item');openWinter(14)">
                    <div class="winter__front d-flex align-center justify-center">
                        <span></span>
                    </div>
                    <div class="winter__back d-flex align-center justify-center">
                        <span>?</span>
                    </div>
                </div>
                <div class="winter__item" onclick="disable('.winter__item');openWinter(15)">
                    <div class="winter__front d-flex align-center justify-center">
                        <span></span>
                    </div>
                    <div class="winter__back d-flex align-center justify-center">
                        <span>?</span>
                    </div>
                </div>
                <div class="winter__item" onclick="disable('.winter__item');openWinter(16)">
                    <div class="winter__front d-flex align-center justify-center">
                        <span></span>
                    </div>
                    <div class="winter__back d-flex align-center justify-center">
                        <span>?</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="winter__snow"></div>
        <div class="winter__snow winter__snow--bottom"></div>
        <div class="winter__snow winter__snow--left"></div>
        <div class="winter__snow winter__snow--right"></div>
    </div>

    
    <div class="mobile-menu d-flex align-center">
        <nav class="mobile-menu__links d-flex align-center justify-space-between">
            <li style="margin-top: 7px;"><a class="btn_active btn_bonus" onclick="load('bonus')"><svg class="icon"><use xlink:href="images/symbols.svg#mobile_promo"></use></svg></a></li>
            <li style="margin-top: 7px;"><a href="#" id="chatBtn"><svg class="icon"><use xlink:href="images/symbols.svg#mobile_chat"></use></svg></a></li>
            <li><a class="btn_active btn_" onclick="load('')"><svg class="icon"><use xlink:href="images/symbols.svg#mobile_game"></use></svg></a></li>
            <li><a rel="popup" data-popup="popup--wallet"><svg class="icon"><use xlink:href="images/symbols.svg#mobile_wallet"></use></svg></a></li>
            <li><a href="#" id="moreBtn"><svg class="icon"><use xlink:href="images/symbols.svg#mobile_menu"></use></svg></a></li>
        </nav>
    </div>
    <div class="mobile-navbar d-flex flex-column">
        <li class="d-flex flex-column">
            <a onclick="$('#moreBtn').click();load('')" href='#'>Главная</a>
            <a onclick="$('#moreBtn').click();load('bonus')">Бонусы</a>
            <a onclick="$('#moreBtn').click();load('refs')">Партнерка</a>
            <a onclick="$('#moreBtn').click();load('faq')">Faq</a>
            <a href="https://t.me/mortalsoft" target="_blank">Поддержка</a>
        </li>
    </div>
    <div class="preloader d-flex align-center justify-center">
        <div class="preloader__lift d-flex align-center justify-center">
            <div class="preloader__lift-container d-flex align-center justify-space-between">
                <div class="preloader__loader">
                   <svg width="220" height="163" viewBox="0 0 220 163" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M128.964 0.498828C119.205 1.86455 112.054 4.49845 96.1106 12.4977C86.5443 17.2777 74.8522 22.4479 70.0207 23.9112C62.0971 26.2524 59.8747 26.5451 45.3803 26.5451C30.3062 26.6426 29.05 26.4475 22.9624 24.0088C19.3871 22.5455 14.8455 20.3018 12.8163 18.8385L9.14438 16.3997L8.75787 18.5459C8.27472 21.9602 10.4972 30.9349 13.2028 36.3002C16.5848 43.0313 24.9916 51.7134 31.7556 55.3228C46.6365 63.322 62.0971 63.1269 77.0747 54.9326C80.36 53.0791 83.0657 51.9085 83.0657 52.3962C83.0657 54.0546 75.2387 63.322 71.5668 65.9559C69.5376 67.4192 66.1556 69.4678 63.9331 70.4433C60.6477 72.0041 59.778 72.8821 59.2949 75.7111C58.7151 78.8327 59.2949 88.6854 60.4544 96.392L61.0342 99.9038L53.787 103.513C43.0612 108.976 32.5286 111.317 21.6095 110.83C13.8792 110.537 11.85 110.049 5.95562 107.025C-0.615157 103.806 -0.808415 103.708 0.930909 106.147C4.2163 110.83 15.0388 120.585 21.7062 124.877C30.7893 130.828 39.4859 134.144 50.8882 136.095C59.2949 137.559 62.6769 137.559 81.1331 136.583C104.131 135.217 110.895 135.803 119.591 139.802C122.297 141.071 124.616 142.339 124.616 142.631C124.616 142.827 121.331 143.119 117.272 143.119C109.929 143.119 94.6612 146.533 94.6612 148.192C94.6612 149.753 112.538 157.849 120.751 159.996C131.863 162.825 147.904 162.825 158.92 159.898C191.58 151.216 214.964 124.584 219.409 91.1242C220.376 83.2225 220.182 75.0282 218.636 64.8828L218.057 61.2734H172.834L127.515 81.2044V81.2715V81.3386L174.96 101.27L173.221 104.294C170.515 108.976 163.461 114.927 156.504 118.244C150.609 121.073 149.45 121.268 139.594 121.268C130.027 121.268 128.385 120.975 123.36 118.634C116.113 115.219 111.088 111.122 106.933 105.367C95.2409 89.0756 96.4971 67.6143 110.122 53.0791C122.684 39.617 142.782 36.1051 158.34 44.6897L163.558 47.6162H188.198C216.027 47.6162 213.998 48.4942 208.394 39.0317C194.286 15.2291 166.553 -0.476692 139.594 0.0110659C135.342 0.0110659 130.607 0.303725 128.964 0.498828Z" fill="#526184"/>
</svg>
                </div>
            </div>
        </div>
    </div>
    <div id="app">
        <div class="sidebar">
            <div class="sidebar__inner d-flex justify-space-between flex-column">
                <div class="sidebar__top">
                    <div class="sidebar__logotype">
                        <a onclick="load('')" href='#'></a>
                    </div>
                    <div class="sidebar__block sidebar__games  d-flex flex-column justify-center align-center">
                        @if($snow == 1)
                        <img class="sidebar__img sidebar__img--1" src="images/snow/confetti/1.png">
                        <img class="sidebar__img sidebar__img--2" src="images/snow/confetti/2.png">
                        <img class="sidebar__img sidebar__img--3" src="images/snow/confetti/3.png">
                        @endif
                        
                        <a href="shoot" class="sidebar__game game_shoot d-flex justify-center align-center">
                            <div class="sidebar__game-center d-flex align-center justify-center align-center">
                                <svg class="icon"><use xlink:href="/images/symbols.svg?v=5#hunt"></use></svg>
                            </div>
                            <div class="sidebar__game-name d-flex align-center flex-end">
                                <span>CrazyShoot</span>
                            </div>
                            <div class="sidebar__game--hover"></div>
                        </a>
                        
                        <a onclick="load('x100')" class="sidebar__game game_x100 d-flex justify-center align-center">
                            <div class="sidebar__game-center d-flex align-center justify-center align-center">
                                <svg class="icon"><use xlink:href="/images/symbols.svg#x100"></use></svg>
                            </div>
                            <div class="sidebar__game-name d-flex align-center flex-end">
                                <span>X100</span>
                            </div>
                            <div class="sidebar__game--hover"></div>
                        </a>

                        <a onclick="load('x30')" class="sidebar__game  game_x30 d-flex justify-center align-center">
                            <div class="sidebar__game-center d-flex align-center justify-center align-center">
                                <svg class="icon"><use xlink:href="/images/symbols.svg#x30"></use></svg>
                            </div>
                            <div class="sidebar__game-name d-flex align-center flex-end">
                                <span>X30</span>
                            </div>
                            <div class="sidebar__game--hover"></div>
                        </a>

                        <a href="crash" class="sidebar__game  game_crash d-flex justify-center align-center">
                            <div class="sidebar__game-center d-flex align-center justify-center align-center">
                                <svg class="icon"><use xlink:href="/images/symbols.svg#crash"></use></svg>
                            </div>
                            <div class="sidebar__game-name d-flex align-center flex-end">
                                <span>Crash</span>
                            </div>
                            <div class="sidebar__game--hover"></div>
                        </a>
                        
                      
                        <a onclick="load('dice')" class="sidebar__game game_dice d-flex justify-center align-center">
                            <div class="sidebar__game-center d-flex align-center justify-center align-center">
                                <svg class="icon"><use xlink:href="/images/symbols.svg#dice"></use></svg>
                            </div>
                            <div class="sidebar__game-name d-flex align-center flex-end">
                                <span>Dice</span>
                            </div>
                            <div class="sidebar__game--hover"></div>
                        </a>

                        <a onclick="load('mines')" class="sidebar__game game_mines d-flex justify-center align-center">
                            <div class="sidebar__game-center d-flex align-center justify-center align-center">
                                <svg class="icon"><use xlink:href="/images/symbols.svg#mines"></use></svg>
                            </div>
                            <div class="sidebar__game-name d-flex align-center flex-end">
                                <span>Mines</span>
                            </div>
                            <div class="sidebar__game--hover"></div>
                        </a>

                        <a onclick="load('coinflip')" class="sidebar__game game_coinflip d-flex justify-center align-center">
                            <div class="sidebar__game-center d-flex align-center justify-center align-center">
                                <svg class="icon"><use xlink:href="/images/symbols.svg?v=3#coinflip"></use></svg>
                            </div>
                            <div class="sidebar__game-name d-flex align-center flex-end">
                                <span>Coin Flip</span>
                            </div>
                            <div class="sidebar__game--hover"></div>
                        </a>                  
                        <a onclick="load('keno')" class="sidebar__game game_keno d-flex justify-center align-center">
                            <div class="sidebar__game-center d-flex align-center justify-center align-center">
                                <svg class="icon"><use xlink:href="/images/symbols.svg?v=3#keno"></use></svg>
                            </div>
                            <div class="sidebar__game-name d-flex align-center flex-end">
                                <span>Keno</span>
                            </div>
                            <div class="sidebar__game--hover"></div>
                        </a>                                          

                        


                    </div>
                    @auth
                    <div class="sidebar__block sidebar__profile d-flex justify-center align-center flex-column">
                        <div class="sidebar__user-avatar" style="background: url({{\Auth::user()->avatar}}) no-repeat center center / cover;"></div>
                        
                    </div>
                    @endauth 
                </div>
                <div class="sidebar__socials d-flex flex-column align-center justify-center">
                    <a href="https://vk.com/public{{\App\Setting::first()->group_id}}" target="_blank" class="sidebar__social--vk d-flex align-center justify-center">
                        <svg class="icon"><use xlink:href="/images/symbols.svg?v=2#vk"></use></svg>
                    </a>
                    <a href="https://t.me/{{\App\Setting::first()->tg_id}}" target="_blank" class="sidebar__social--tg d-flex align-center justify-center">
                        <svg class="icon"><use xlink:href="/images/symbols.svg?v=2#telegram"></use></svg>
                    </a>
                </div>
               
            </div>
        </div>
        <div class="header">
            <div class="wrapper d-flex align-center justify-space-between flex-wrap">
                <nav class="header__links d-flex align-center">
                    <li>
                        <a href="#" onclick="load('')" class="d-flex align-center">
                            <svg class="icon"><use xlink:href="images/symbols.svg#home"></use></svg>
                            <span>Главная</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" onclick="load('bonus')" class="d-flex align-center">
                            <svg class="icon"><use xlink:href="images/symbols.svg#giveaway"></use></svg>
                            <span>Бонусы</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" onclick="load('refs')" class="d-flex align-center">
                            <svg class="icon"><use xlink:href="images/symbols.svg#users"></use></svg>
                            <span>Партнерка</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" onclick="load('faq')" class="d-flex align-center">
                            <svg class="icon"><use xlink:href="images/symbols.svg#faq"></use></svg>
                            <span>F.A.Q</span>
                        </a>
                    </li>
                    <li>
                        <a href="https://t.me/mortalsoft" target="_blank" class="d-flex align-center">
                            <svg class="icon"><use xlink:href="images/symbols.svg#support"></use></svg>
                            <span>Поддержка</span>
                        </a>
                    </li>
                </nav>
                <div class="header__right d-flex align-center">
                    <div class="sidebar__logotype flare">
                        <a href="#" onclick="load('')"></a>
                    </div>

                    @auth
                    @php
                    $min_sort = \App\SystemDep::min('sort');
                    @endphp
                    <div class="header__user d-flex align-center justify-space-between">
                        <div class="header__user-balance d-flex align-center">
                            <div class="header__user-b d-flex align-center">
                                <span id="balance" onclick="$('.wallet__method--sort-{{$min_sort}}_DEPOSIT').click();$('.wallet__method--Qiwi_WITHDRAW').click()" style="cursor:pointer;" rel="popup" data-popup="popup--wallet"></span>
                                <svg class="icon"><use xlink:href="images/symbols.svg#coins"></use></svg>
                            </div>
                            <div class="header__user-balance-add">
                                <a href="#" onclick="$('.wallet__method--sort-{{$min_sort}}_DEPOSIT').click();$('.wallet__method--Qiwi_WITHDRAW').click()" rel="popup" data-popup="popup--wallet" onclick="return false;" class="btn is-ripples flare d-flex align-center"><span>ПОПОЛНИТЬ</span></a>
                            </div>
                        </div>
                        <div class="header__user-profile d-flex align-center" id="dropdownUser">
                            <svg class="icon"><use xlink:href="images/symbols.svg#user"></use></svg>
                            <div class="header__user-dropdown d-flex flex-column">
                                <a href="#" class="header__user-dropdown--id d-flex align-center">
                                    <span>ID: <b>{{\Auth::user()->id}}</b></span>
                                </a>
                                <a href="#" onclick="load('profile')" class="d-flex align-center">
                                    <svg class="icon"><use xlink:href="images/symbols.svg#user"></use></svg>
                                    <span>Профиль</span>
                                </a>
                                <a href="#" rel="popup" data-popup="popup--coupon" onclick="return false;" class="d-flex align-center">
                                    <svg class="icon"><use xlink:href="images/symbols.svg#coupon"></use></svg>
                                    <span>Промокоды</span>
                                </a>

                                <!-- <a href="#" id="darkTheme" onclick="return false;" class="d-flex align-center">
                                    <svg class="icon"><use xlink:href="images/symbols.svg?v=1#dark"></use></svg>
                                    <span>Темная тема</span>
                                    <em>new</em>
                                </a>
                                <a href="#" id="lightTheme" onclick="return false;" class="d-flex align-center">
                                    <svg class="icon"><use xlink:href="images/symbols.svg?v=1#light"></use></svg>
                                    <span>Светлая тема</span>
                                </a> -->
                                
                                <a href="logout" onclick="location.href='logout'" class="d-flex align-center">
                                    <svg class="icon"><use xlink:href="images/symbols.svg#exit"></use></svg>
                                    <span>Выйти</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    @else
                    <a href="#" rel="popup" data-popup="popup--auth" onclick="return false;" class="btn is-ripples btn--blue d-flex align-center flare"><span>АВТОРИЗАЦИЯ</span></a>
                    @endauth
                </div>
            </div>
        </div>

        <script src="js/script.js?v={{time()}}" type="text/javascript"></script>

        <main id="_ajax_content_">{!! html_entity_decode($page) !!}</main>

        <div class="footer">
            <div class="wrapper d-flex align-center justify-space-between flex-wrap">
                <nav class="footer__links d-flex align-center">
                    <li class="footer__link">
                        <a href="#" onclick="load('terms')">Соглашение</a>
                    </li>
                    <li class="footer__link">
                        <a href="#" onclick="load('policy')">Политика конфиденциальности</a>
                    </li>
                </nav>
                <div class="footer__text"><span>SO-YOU-START.RU — ALL RIGHTS RESERVED.</span></div>
            </div>
        </div>
        @include('layouts.chat')
    </div>

    <div class="overlayed">

        @guest
        <div class="popup popup--auth" style="max-width:350px">
            <div class="popup__title d-flex align-center justify-space-between">
                <span>Авторизация</span>
                <a href="#" class="close d-flex align-center justify-center">
                    <svg class="icon"><use xlink:href="images/symbols.svg#close"></use></svg>
                </a>
            </div>
            <div class="popup__content">
                <div class="auth_blocks">
                    <a href="/vk_auth" class="btn btn--blue d-flex align-center justify-center is-ripples flare"><span>ВКОНТАКТЕ</span></a>
                    <a href="/google_auth" class="btn btn--red d-flex align-center justify-center is-ripples flare"><span>GOOGLE</span></a>
                    <a href="/yandex_auth" class="btn btn--red d-flex align-center justify-center is-ripples flare"><span>ЯНДЕКС</span></a>
                    <a href="/tg_auth" class="btn btn--blue d-flex align-center justify-center is-ripples flare"><span>TELEGRAM</span></a>

                </div>
                
            </div>
        </div>
        
        @endguest
       
        <div class="popup popup--crash-info">
            <div class="popup__title d-flex align-center justify-space-between">
                <span>Режим «Crash»</span>
                <a href="#" class="close d-flex align-center justify-center">
                    <svg class="icon"><use xlink:href="images/symbols.svg#close"></use></svg>
                </a>
            </div>
            <div class="popup__content">
                <p>Crash - онлайн игра, и как и все онлайн игры имеет недостатки, связанные с сетью</p>
                <div class="text__borders"></div>
                <p>Быстродействие выполнения ручного вывода (кнопка "Вывести деньги"), отображение графика на странице, напрямую зависят от следующих факторов:</p>
                <ol class="show_ul">
                    <li>Скорость Вашего интернет соединения</li>
                    <li>Пинг до сервера (Latency / Задержка)</li>
                    <li>Мощность смартфона или компьютера (используется для обработки данных графика и его показа)</li>
                    <li>Время ответа от нашего сервера</li>
                </ol>


                <div class="text__borders"></div>
                <p> 
                    Сервис GOLDEN-X не гарантирует своевременного выполнения ручного вывода после нажатия (кнопка "Вывести деньги") и настоятельно рекомендует использовать функцию автоматического вывода средств (поле "Автовывод").
                </p>
                <div class="text__borders"></div>
                <p>
                Функция "Автовывод" используется на стороне сервера, что снижает риск проблем, связанных с своевременным выводом, на 99.9%</p>
                <br>
                <div class="bx-input">
                    <a onclick="localStorage.setItem('crashAgree', 'true');;$('.close').click()" class="btn btn--red d-flex align-center justify-center is-ripples flare"><span>Я ознакомлен. Закрыть</span></a>
                </div>

            </div>
        </div>

        @auth
        <div class="popup popup--demo-add">
            <div class="popup__title d-flex align-center justify-space-between">
                <div class="popup__tabs d-flex align-center">
                    <div class="popup__tab popup__tab--active d-flex align-center">
                        <svg class="icon"><use xlink:href="images/symbols.svg#plus"></use></svg>
                        <span>Пополнение демо баланса</span>
                    </div>
                    
                </div>
                <a href="#" class="close d-flex align-center justify-center">
                    <svg class="icon"><use xlink:href="images/symbols.svg#close"></use></svg>
                </a>
            </div>
            <div class="popup__content">
                <div class="wallet  d-flex align-stretch justify-space-between flex-wrap">



                    <div class="wallet__content d-flex flex-column justify-space-between" style="width:100%">
                        <div class="wallet__content-top">
                           <div class="bx-input d-flex flex-column">
                            <div class="bx-input__input d-flex align-center justify-space-between">
                                <label class="d-flex align-center">Сумма пополнения:</label>
                                <div class="d-flex align-center">
                                    <input type="text" id="add_balance"  placeholder="0.00">
                                    <svg class="icon money"><use xlink:href="images/symbols.svg#coins"></use></svg>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="wallet__content-bottom" style="margin-top:10px;">
                        <div class="wallet__order d-flex justify-space-between align-center">
                            <div class="wallet__txt d-flex flex-column">

                                <b class="d-flex align-center">Всего к оплате: <span class="d-flex align-center"><b class="">0</b> <svg class="icon money"><use xlink:href="images/symbols.svg#coins"></use></svg></span></b>
                            </div>
                            <a onclick="addDemoBalance()" class="btn is-ripples flare btn--blue d-flex align-center"><span>ПОПОЛНИТЬ</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="popup popup--wallet">
        <div class="popup__title d-flex align-center justify-space-between">
            <div class="popup__tabs d-flex align-center">
                <div class="popup__tab popup__tab--active d-flex align-center">
                    <svg class="icon"><use xlink:href="images/symbols.svg#plus"></use></svg>
                    <span>Пополнение</span>
                </div>
                <div class="popup__tab d-flex align-center">
                    <svg class="icon"><use xlink:href="images/symbols.svg#minus"></use></svg>
                    <span>Вывод</span>
                </div>
                <div class="popup__tab d-flex align-center">
                    <svg class="icon"><use xlink:href="images/symbols.svg#timer"></use></svg>
                    <span>История</span>
                </div>
            </div>
            <a href="#" class="close d-flex align-center justify-center">
                <svg class="icon"><use xlink:href="images/symbols.svg#close"></use></svg>
            </a>
        </div>
        <script type="text/javascript">
            function setSystemDep(id){
                $('#systemDep').val(id)
            }
        </script>
        <div class="popup__content">
            <div class="wallet wallet--refill d-flex align-stretch justify-space-between flex-wrap">
                <div class="wallet__methods">
                    <div class="wallet__scroll" ss-container>
                        @php
                        $systemDeps = \App\SystemDep::orderBy('sort', 'asc')->orderBy('id', 'asc')->where('off', 0)->get();

                        @endphp
                        @foreach($systemDeps as $s)

                        <div onclick="setSystemDep({{$s->id}})" class="wallet__method wallet__method--sort-{{$s->sort}}_DEPOSIT wallet__method--{{$s->id}}_DEPOSIT d-flex align-center">
                            <img src="{{$s->img}}">
                            <div class="d-flex flex-column">
                                <span>{{$s->name}}</span>
                                <b>{{$s->comm_percent}}%</b>
                            </div>
                        </div>

                        @endforeach

                    </div>
                </div>

                <input type="hidden" id="systemDep" name="">
                <div class="wallet__content d-flex flex-column justify-space-between">
                    <div class="wallet__content-top">
                        <div class="bx-input d-flex flex-column">
                            <div class="bx-input__input d-flex align-center justify-space-between">                       
                                    <input type="text" style="text-align: left;" id="sumDep" onkeyup="$('.payDep').html($('#sumDep').val())" placeholder="ВВЕДИТЕ СУММУ">
                                    <svg class="icon money"><use xlink:href="images/symbols.svg#coins"></use></svg>
                            </div>
                        </div>
                        
                    <div class="x30__bet-placed d-flex align-center justify-space-between payments">
                        <a onclick="$('#sumDep').val((Number($('#sumDep').val()) + 10).toFixed(2));">+10</a>
                        <a onclick="$('#sumDep').val((Number($('#sumDep').val()) + 100).toFixed(2));">+100</a>
                        <a onclick="$('#sumDep').val((Number($('#sumDep').val()) + 1000).toFixed(2));">+1000</a>
                        <a onclick="$('#sumDep').val((Number($('#sumDep').val()) * 2).toFixed(2));">x2</a>
                        <a onclick="$('#sumDep').val(Math.max((Number($('#sumDep').val()) / 2), 1).toFixed(2));">1/2</a>
                    </div> 

                        <div class="bx-input d-flex flex-column">
                            <div class="bx-input__input d-flex align-center justify-space-between">
                                <input type="text" style="text-align: left;" id="promoDep" placeholder="ВВЕДИТЕ ПРОМОКОД">
                            </div>
                        </div>

                        <div class="d-flex align-center justify-space-between">
                            <div class="wallet__txt"><span class="d-flex align-center">Комиссия: 0%</span></div>
                        </div>
                    </div>
                    <div class="wallet__content-bottom">
                        <div class="wallet__order d-flex justify-space-between align-center">
                            <div class="wallet__txt d-flex flex-column">
                                
                                <b class="d-flex align-center">Всего к оплате: <span class="d-flex align-center"><b class="payDep">0</b> <svg class="icon money"><use xlink:href="images/symbols.svg#coins"></use></svg></span></b>
                            </div>
                            <a onclick="disable(this);goDeposit(this)" class="btn is-ripples flare btn--blue d-flex align-center"><span>ПОПОЛНИТЬ</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                
            </script>
            <script type="text/javascript">
                function setSystemW(id, comm_percent, comm_rub, min_sum){
                    $('#systemW').val(id)
                    $('#min_sum_withdraws').html(min_sum)
                    $('#comm_percent').val(comm_percent)
                    $('#comm_rub').val(comm_rub)
                    updateW()
                }
            </script>
            <div class="wallet wallet--withdraw d-flex align-stretch justify-space-between flex-wrap">
                <div class="wallet__methods">
                    <div class="wallet__scroll" ss-container>
                     @php
                     $SystemWithraws = \App\SystemWithdraw::all();

                     @endphp
                     @foreach($SystemWithraws as $s)

                     <div onclick="setSystemW({{$s->id}}, {{$s->comm_percent}}, {{$s->comm_rub}}, {{$s->min_sum}})" class="W wallet__method wallet__method--{{$s->name}}_WITHDRAW d-flex align-center">
                        <img src="{{$s->img}}">
                        <div class="d-flex flex-column">
                            <span>{{$s->name}}</span>
                            <b>{{$s->comm_percent}}% @if($s->comm_rub > 0) + {{$s->comm_rub}}P  @endif</b>
                        </div>
                    </div>

                    @endforeach
                </div>
            </div>
            <input type="hidden" id="systemW" name="">
            <input type="hidden" id="comm_rub" name="">
            <input type="hidden" id="comm_percent" name="">
            <div class="wallet__content d-flex flex-column justify-space-between">
                <div class="wallet__content-top">
                    <div class="bx-input d-flex flex-column">
                        <div class="bx-input__input d-flex align-center justify-space-between">
                            
                                <input type="text" style="text-align: left;" id="sum_withdraw" onkeyup="$('#sum_itog_pay').html($('#sum_withdraw').val());updateW()" placeholder="ВВЕДИТЕ СУММУ ВЫВОДА">
                                <svg class="icon money"><use xlink:href="images/symbols.svg#coins"></use></svg>
                            
                        </div>
                    </div>
                    <div class="bx-input d-flex flex-column">
                        <div class="bx-input__input d-flex align-center justify-space-between">
                            <label class="d-flex align-center">Поступит на счёт:</label>
                            <div class="d-flex align-center">
                                <span class="bx-input__text" id="get_withdraw"></span>
                                <svg class="icon money"><use xlink:href="images/symbols.svg#coins"></use></svg>
                            </div>
                        </div>
                    </div>
                    <div class="bx-input d-flex flex-column">
                        <div class="bx-input__input d-flex align-center justify-space-between">
                            
                                <input style="text-align: left;"  type="text" id="wallet_withdraw" placeholder="ВВЕДИТЕ РЕКВИЗИТЫ">
                            
                        </div>
                    </div>
                </div>
                <div class="wallet__content-bottom">
                    <div class="wallet__order d-flex justify-space-between align-center">
                        <div class="wallet__txt d-flex flex-column">
                            <span class="d-flex align-center">Мин. вывод: &nbsp;<span id="min_sum_withdraws">50</span> <svg class="icon money"><use xlink:href="images/symbols.svg#coins"></use></svg></span>
                            <b class="d-flex align-center">К выводу: <span class="d-flex align-center"><span class="sum_itog_pay" id="sum_itog_pay">100</span> <svg class="icon money"><use xlink:href="images/symbols.svg#coins"></use></svg></span></b>
                        </div>
                        <a onclick="disable(this);goWithdraw(this)" class="btn is-ripples flare btn--red d-flex align-center"><span>ВЫВЕСТИ</span></a>
                    </div>
                    <div class="wallet__order d-flex justify-space-between align-center">
                        <div class="wallet__txt d-flex flex-column">
                            <span class="d-flex align-center">Максимальный вывод с бонуса: &nbsp;<span>{{ in_array($u->status, [0, 1]) ? 300 : ($u->status == 2 ? 500 : ($u->status == 3 ? 600 : ($u->status == 4 ? 750 : ($u->status == 5 ? 1000 : 2000)))) }}</span> <svg class="icon money"><use xlink:href="images/symbols.svg#coins"></use></svg></span>
                        </div></div>
                    </div>
                </div>
            </div>
            @auth
            <div class="wallet wallet--history d-flex flex-column justify-center align-center">
                <div class="wallet__tabs d-flex align-center">
                    <div class="wallet__tab wallet__tab--active d-flex align-center">
                        <svg class="icon"><use xlink:href="images/symbols.svg#plus"></use></svg>
                        <span>Пополнения</span>
                    </div>
                    <div class="wallet__tab d-flex align-center">
                        <svg class="icon"><use xlink:href="images/symbols.svg#minus"></use></svg>
                        <span>Выводы</span>
                    </div>
                </div>
                <div class="wallet__history wallet__history--refill">
                    @php
                    $deps = \App\Payment::where('user_id', \Auth::user()->id)->orderBy('id', 'desc')->limit(10)->get();

                    @endphp

                    @foreach($deps as $d)
                    <div class="wallet__history-item d-flex justify-space-between align-center">
                        <div class="wallet__history-left d-flex align-center">
                         <div class="wallet__method d-flex align-center">
                            <img src="{{$d->img_system}}">
                            @php
                            $system_dep = \App\SystemDep::where('img', $d->img_system)->first();
                            @endphp
                            <span>@if($system_dep){{$system_dep->name}}@endif</span>
                        </div>
                        <div class="wallet__history-sum d-flex align-center">
                            <span>{{$d->sum}}</span>
                            <svg class="icon money"><use xlink:href="images/symbols.svg#coins"></use></svg>
                        </div>
                    </div>
                    <div class="wallet__history-status @if($d->status == 0) warning @else success @endif">
                        <span>@if($d->status == 0) Ожидание... @else Успешно @endif</span>
                    </div>
                </div>

                @endforeach



            </div>
            <div class="wallet__history wallet__history--withdraw">

                @php
                $withdraws = \App\Withdraw::where('user_id', \Auth::user()->id)->orderBy('id', 'desc')->limit(10)->get();

                @endphp

                @foreach($withdraws as $w)
                <div class="wallet__history-item d-flex justify-space-between align-center">
                    <div class="wallet__history-left d-flex align-center">
                        <div class="wallet__method d-flex align-center">
                            <img src="{{$w->img_system}}">
                            @php
                            $system_w = \App\SystemWithdraw::where('img', $w->img_system)->first();
                            @endphp
                            <span>@if($system_w){{$system_w->name}}@endif</span>
                        </div>
                        <div class="wallet__history-sum d-flex align-center">
                            <span>{{$w->sum}}</span>
                            <svg class="icon money"><use xlink:href="images/symbols.svg#coins"></use></svg>
                        </div>
                    </div>
                    <div id="statusW_{{$w->id}}" class="wallet__history-status  @if($w->status == 0) warning @elseif($w->status == 2) error @elseif($w->status == 1) success  @elseif($w->status == 3 || $w->status == 4) warning @else error @endif ">
                        <span >@if($w->status == 0) Ожидание... (<a onclick="disable(this);canselWithdraw({{$w->id}}, this)">Отменить</a>)@elseif($w->status == 2) Отменен @elseif($w->status == 1) Успешно  @elseif($w->status == 3) Ожидает отправки @elseif($w->status == 4) Отправлен @else Ошибка @endif</span>
                    </div>
                </div>

                @endforeach
            </div> 
        </div>


        @endauth
        @endauth
    </div>
</div>

@auth
@if(\Auth::user()->admin == 1)
<div class="popup popup--gokeno">
    <div class="popup__title d-flex align-center justify-space-between">
        <div class="popup__tabs d-flex align-center">
            <div class="popup__tab popup__tab--active d-flex align-center">
                <svg class="icon"><use xlink:href="images/symbols.svg#plus"></use></svg>
                <span>Подкрутка кено</span>
            </div>

        </div>
        <a href="#" class="close d-flex align-center justify-center">
            <svg class="icon"><use xlink:href="images/symbols.svg#close"></use></svg>
        </a>
    </div>
    <div class="popup__content">
        <div class="wallet  d-flex align-stretch justify-space-between flex-wrap">



            <div class="wallet__content d-flex flex-column justify-space-between" style="width:100%">
                <div class="wallet__content-top">
                    <div class="bx-input d-flex  align-stretch justify-space-between ">
                        <div class="bx-input__input d-flex align-center justify-space-between">
                            <label class="d-flex align-center">Ч-1:</label>
                            <div class="d-flex align-center">
                                <input type="text" id="kenoGo1"   placeholder="0">

                            </div>
                        </div>
                        <div class="bx-input__input d-flex align-center justify-space-between">
                            <label class="d-flex align-center">Ч-2:</label>
                            <div class="d-flex align-center">
                                <input type="text" id="kenoGo2"   placeholder="0">

                            </div>
                        </div>
                        <div class="bx-input__input d-flex align-center justify-space-between">
                           <label class="d-flex align-center">Ч-3:</label>
                           <div class="d-flex align-center">
                            <input type="text" id="kenoGo3"   placeholder="0">

                        </div>
                    </div>

                </div>

                <div class="bx-input d-flex  align-stretch justify-space-between ">
                    <div class="bx-input__input d-flex align-center justify-space-between">
                        <label class="d-flex align-center">Ч-4:</label>
                        <div class="d-flex align-center">
                            <input type="text" id="kenoGo4"   placeholder="0">

                        </div>
                    </div>
                    <div class="bx-input__input d-flex align-center justify-space-between">
                        <label class="d-flex align-center">Ч-5:</label>
                        <div class="d-flex align-center">
                            <input type="text" id="kenoGo5"   placeholder="0">

                        </div>
                    </div>
                    

                </div>            



            </div>
            <div class="wallet__content-bottom" style="margin-top:10px;">
                <div class="wallet__order d-flex justify-space-between align-center">
                    <div class="wallet__txt d-flex flex-column">

                    </div>
                    <a onclick="kenoGo()" class="btn is-ripples flare btn--blue d-flex align-center"><span>Подкрутить</span></a>
                </div>
            </div>

            <div class="text__borders"></div>

            <div class="wallet__content-top">
                <div class="bx-input d-flex  align-stretch justify-space-between ">
                    <div class="bx-input__input d-flex align-center justify-space-between">
                        <label class="d-flex align-center">Номер:</label>
                        <div class="d-flex align-center">
                            <input type="text" id="kenoBonusNumber"   placeholder="0">

                        </div>
                    </div>
                    <div class="bx-input__input d-flex align-center justify-space-between">
                        <label class="d-flex align-center">Икс:</label>
                        <div class="d-flex align-center">
                            <input type="text" id="kenoBonusCoeff"   placeholder="0">

                        </div>
                    </div>


                </div>



            </div>
            <div class="wallet__content-bottom" style="margin-top:10px;">
                <div class="wallet__order d-flex justify-space-between align-center">
                    <div class="wallet__txt d-flex flex-column">

                    </div>
                    <a onclick="kenoGoBonus()" class="btn is-ripples flare btn--blue d-flex align-center"><span>Подкрутить бонуску</span></a>
                </div>
            </div>

        </div>
    </div>
</div>
</div>

<script type="text/javascript">
    function kenoGo(){

        $.post('/keno/go',{_token: csrf_token, 
            kenoGo1: $('#kenoGo1').val(),
            kenoGo2: $('#kenoGo2').val(),
            kenoGo3: $('#kenoGo3').val(),
            kenoGo4: $('#kenoGo4').val(),
            kenoGo5: $('#kenoGo5').val(),
            
            
        }).then(e=>{

            if(e.success){      

                notification('success','Успешно')
            }
            if(e.error){       
                notification('error',e.error)
            }
        }).fail(e=>{
            notification('error',JSON.parse(e.responseText).message)
        })  
    }

    function kenoGoBonus(){

        $.post('/keno/bonusgo',{_token: csrf_token, 
            kenoBonusNumber: $('#kenoBonusNumber').val(),
            kenoBonusCoeff: $('#kenoBonusCoeff').val(),
        }).then(e=>{
            if(e.success){     

                notification('success','Успешно')
            }
            if(e.error){       
                notification('error',e.error)
            }
        }).fail(e=>{
            notification('error',JSON.parse(e.responseText).message)
        })  
    }
</script>
@endif

@endauth




<div class="popup popup--coupon">
    <div class="popup__title d-flex align-center justify-space-between">
        <div class="popup__tabs d-flex align-center">
            <div class="popup__tab popup__tab--active d-flex align-center">
                <svg class="icon"><use xlink:href="images/symbols.svg#plus"></use></svg>
                <span>Промокод</span>
            </div>

        </div>
        <a href="#" class="close d-flex align-center justify-center">
            <svg class="icon"><use xlink:href="images/symbols.svg#close"></use></svg>
        </a>
    </div>
    <div class="popup__content">
        <div class="bx-input d-flex align-center justify-space-between promocodeInputBlock">
            <div class="bx-input__input promocodeInput d-flex align-center justify-space-between">
                
                
                    <input type="text" style="text-align: left;" id="promo_name" placeholder="ВВЕДИТЕ ПРОМОКОД">
                    
            </div>

            <a onclick="disable(this);actPromo(this)" class="btn is-ripples flare btn--blue d-flex align-center justify-center promocodeInputBtn"><span>Активировать</span></a>

            
        </div>
        <div class="tournier__separate"></div>
        <div class="bx-input">
            <div class="bx-input__create-coupon">
                <div class="bx-input__input d-flex align-center justify-space-between">
                    
                        <input type="text"  style="text-align: left;" id="name_crpromo" placeholder="ПРОМОКОД">
                   
                </div>
                <div class="bx-input__input d-flex align-center justify-space-between">
                    
                        <input style="text-align: left;"  type="text" id="sum_crpromo" placeholder="СУММА">
                        <svg class="icon money"><use xlink:href="images/symbols.svg#coins"></use></svg>
                    
                </div>
            </div>
            <div class="bx-input__create-coupon">
                <div class="bx-input__input d-flex align-center justify-space-between">
                    
                        <input type="text" style="text-align: left;" placeholder="КОЛИЧЕСТВО АКТИВАЦИЙ" id="act_crpromo" placeholder="0.00">
                        <svg class="icon money"><use xlink:href="images/symbols.svg#users"></use></svg>
                   
                </div>
                <a onclick="disable(this);createPromoUser(this)" style="height: 55px;" class="btn is-ripples flare btn--red d-flex align-center justify-center" ><span>Создать</span></a>
            </div>
            
        </div>
    </div> 
</div>
<div class="popup popup--send">
    <div class="popup__title d-flex align-center justify-space-between">
        <div class="popup__tabs d-flex align-center">
            <div class="popup__tab popup__tab--active d-flex align-center">
                <svg class="icon"><use xlink:href="images/symbols.svg#minus"></use></svg>
                <span>Перевод средств</span>
            </div>
            <div class="popup__tab d-flex align-center" rel="popup" data-popup="popup--coupon">
                <svg class="icon"><use xlink:href="images/symbols.svg#plus"></use></svg>
                <span>Промокод</span>
            </div>
        </div>
        <a href="#" class="close d-flex align-center justify-center">
            <svg class="icon"><use xlink:href="images/symbols.svg#close"></use></svg>
        </a>
    </div>
    <div class="popup__content">
        <div class="bx-input">
            <div class="bx-input__create-coupon">
                <div class="bx-input__input d-flex align-center justify-space-between">
                    <label class="d-flex align-center">ID игрока:</label>
                    <div class="d-flex align-center">
                        <input type="text" placeholder="ID">
                    </div>
                </div>
                <div class="bx-input__input d-flex align-center justify-space-between">
                    <label class="d-flex align-center">Сумма:</label>
                    <div class="d-flex align-center">
                        <input type="text" placeholder="0.00">
                        <svg class="icon money"><use xlink:href="images/symbols.svg#coins"></use></svg>
                    </div>
                </div>
            </div>
            <div class="bx-input__btn d-flex align-center">
                <a href="#" class="btn is-ripples flare btn--blue d-flex align-center"><span>Перевести</span></a>
                <div class="history__user d-flex align-center justify-center" style="margin-left: 10px">
                    <div class="history__user-avatar" style="background: url(https://sun1-47.userapi.com/s/v1/ig2/XpJjGMiNkluJe92SSJXtnBchRcr51JMc6-9JVxZO3ZMbCRjtmbKCjmpTRq_2_0cOZ6dVShhXRrA8i381ORNssVHX.jpg?size=200x200&amp;quality=95&amp;crop=31,8,944,944&amp;ava=1) no-repeat center center / cover;"></div>
                    <span>Владимир Макаров</span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="popup popup--promo-history">
    <div class="popup__title d-flex align-center justify-space-between">
        <span>История промокодов</span>
        <a href="#" class="close d-flex align-center justify-center">
            <svg class="icon"><use xlink:href="images/symbols.svg#close"></use></svg>
        </a>
    </div>
    <div class="popup__content">
        <div class="wallet__history">
            <div class="wallet__history-item d-flex justify-space-between align-center">
                <div class="wallet__history-left d-flex align-center">
                    <span style="font-weight: 600;margin-right: 20px;">7W8J9K0Q2G2O0A</span>
                    <div class="wallet__history-sum d-flex align-center">
                        <span>2 / 25 </span>
                        <svg class="icon money"><use xlink:href="images/symbols.svg#users"></use></svg>
                    </div>
                </div>
                <div class="wallet__history-status">
                    <span>Осталось: 3 активации</span>
                </div>
            </div>
        </div>
    </div>
</div>

@auth
<div class="popup popup--tg popup--about">
    <div class="popup__title d-flex align-center justify-space-between">
        <span>Телеграм</span>
        <a href="#" class="close d-flex align-center justify-center">
            <svg class="icon"><use xlink:href="images/symbols.svg#close"></use></svg>
        </a>
    </div>
    <div class="popup__content">
        <p>Для привязки аккаунта напишите нашему боту <a href="https://t.me/{{\App\Setting::first()->tg_bot_id}}" target="_blank" style="cursor: pointer;">@<span style="cursor: pointer;">{{\App\Setting::first()->tg_bot_id}}</span></a> данное сообщение:</p>
        <div class="borders"></div>
        <p onclick="copyText(this)" style="text-align:center;width: 100%;font-size:18px;font-weight: 600;">/bind {{\Auth::user()->id}}</p>
        <div class="borders"></div>
        <a onclick="disable(this);checkTgConnect(this)" class="btn btn--red d-flex align-center justify-center is-ripples flare"><span>Проверить привязку</span></a>
    </div>
</div>
@endauth
<div class="popup popup--refill popup--about">
    <div class="popup__title d-flex align-center justify-space-between">
        <span>Пополнение</span>
        <a href="#" class="close d-flex align-center justify-center">
            <svg class="icon"><use xlink:href="images/symbols.svg#close"></use></svg>
        </a>
    </div>
    <div class="popup__content">
        <div class="bx-input">
            <div class="bx-input__input d-flex align-center justify-space-between">
                <label class="d-flex align-center">Счёт:</label>
                <div class="d-flex align-center">
                    <span class="bx-input__text" id="wallet_pay" onclick="copyText('wallet_pay')">79002224132</span>
                    <a href="#" onclick="copyText('wallet_pay')" class="btn btn--blue is-ripples flare d-flex align-center" style="margin-left:5px;"><span>Copy</span></a>
                </div>
            </div> 
        </div>
        <div class="bx-input">
            <div class="bx-input__input d-flex align-center justify-space-between">
                <label class="d-flex align-center">Комментарий:</label>
                <div class="d-flex align-center">
                    <span class="bx-input__text" id="comment_pay" onclick="copyText('comment_pay')">39618</span>
                    <a href="#" onclick="copyText('comment_pay')" class="btn btn--blue is-ripples flare d-flex align-center" style="margin-left:5px;"><span>Copy</span></a>
                </div>
            </div>
        </div>
        <div class="bx-input">
            <div class="bx-input__input d-flex align-center justify-space-between">
                <label class="d-flex align-center">Сумма перевода:</label>
                <div class="d-flex align-center">
                    <span class="bx-input__text" id="sum_pay" onclick="copyText('sum_pay')">100</span>
                    <svg class="icon money"><use xlink:href="images/symbols.svg#coins"></use></svg>
                    <a href="#" onclick="copyText('sum_pay')" class="btn btn--blue is-ripples flare d-flex align-center" style="margin-left:5px;"><span>Copy</span></a>
                </div>
            </div>
        </div>
        <div class="bx-input">
            <a id="check_pay"  class="btn btn--red d-flex align-center justify-center is-ripples flare"><span>Проверить перевод</span></a>
        </div>
        <div class="borders"></div>
        <p>При переводе вы должны в точности указать номер кошелька, сумму, комментарий. В случае ошибки деньги не возвращаем.</p>
    </div>
</div>
<script>
    function copyText(that){
        var $temp = $("<input>"); 
        $("body").append($temp);
        $temp.val($(that).text()).select();
        document.execCommand("copy");
        $temp.remove();

        notification('success', 'Скопировано!')
    }
</script>
@if(\Auth::user() && (\Auth::user()->admin == 1 or \Auth::user()->admin == 2)) 
<script type="text/javascript">
    function  typeChatBan() {
        type = $('#type_chat_ban').val();
        $('#type_ban_2').hide()
        $('#time_chat_ban').val('')
        if(type == 2){
            $('#type_ban_2').show()
        }
    }
</script>
<div class="popup popup--ban popup--about">
    <div class="popup__title d-flex align-center justify-space-between">
        <span>Забанить</span>
        <a href="#" class="close d-flex align-center justify-center">
            <svg class="icon"><use xlink:href="images/symbols.svg#close"></use></svg>
        </a>
    </div>
    <input type="hidden" id="chat_id_ban" name="">
    <div class="popup__content">
        <div class="bx-input bx-input--select d-flex flex-column" >
            <label>Причина бана</label>
            <select class="select" id="why_chat_ban">
                <option value="1">Попрошайничество</option>
                <option value="2">Распространение реф кодов</option>
                <option value="3">Оскорбление</option>
                <option value="4">Спам</option>
                <option value="5">Слив промо</option>
                <option value="6">Пиар</option>
                <option value="7">Клевета</option>
                <option value="8">Введение в заблуждение</option>
            </select>
        </div>
        <div class="bx-input bx-input--select d-flex flex-column" >
            <label>Бан</label>
            <select class="select" id="type_chat_ban" onchange="typeChatBan()">
                <option value="1">Навсегда</option>
                <option value="2">До какого-то время</option>
            </select>
        </div>
        <div class="bx-input d-flex flex-column" id="type_ban_2" style="display: none;">
            <div class="bx-input__input d-flex align-center justify-space-between">
                <label class="d-flex align-center">Время:</label>
                <div class="d-flex align-center">
                    <input type="datetime-local" id="time_chat_ban">
                </div>
            </div>
        </div>
        <div class="bx-input">
            <a onclick="banMess()" class="btn btn--red d-flex align-center justify-center is-ripples flare"><span>Забанить</span></a>
        </div>
    </div>
</div>
@endif

<div class="popup popup--x30 popup--about">
    <div class="popup__title d-flex align-center justify-space-between">
        <span>Режим «x30»</span>
        <a href="#" class="close d-flex align-center justify-center">
            <svg class="icon"><use xlink:href="images/symbols.svg#close"></use></svg>
        </a>
    </div>
    <div class="popup__content">
        <p>В этом режиме вам предстоит выбрать цвет или цвета и сделать ставку. Если угадаете цвет, который выпадет, то вы выиграли.</p>
        <div class="borders"></div>
        <h4>Возможные ставки:</h4>
        <div class="bets">
            <div class="x30__bet-heading is-ripples flare x2 d-flex align-center justify-space-between">
                <span>X2</span>
                <img src="images/games/x2.svg">
            </div>
            <div class="x30__bet-heading is-ripples flare x3 d-flex align-center justify-space-between">
                <span>X3</span>
                <img src="images/games/x3.svg">
            </div>
            <div class="x30__bet-heading is-ripples flare x5 d-flex align-center justify-space-between">
                <span>X5</span>
                <img src="images/games/x5.svg">
            </div>
            <div class="x30__bet-heading is-ripples flare x7 d-flex align-center justify-space-between">
                <span>X7</span>
                <img src="images/games/x7.svg">
            </div>
            <div class="x30__bet-heading is-ripples flare x14 d-flex align-center justify-space-between">
                <span>X14</span>
                <img src="images/games/x14.svg">
            </div>
            <div class="x30__bet-heading is-ripples flare x30 d-flex align-center justify-space-between">
                <span>X30</span>
                <img src="images/games/x30.svg">
            </div>
        </div>
        <div class="borders"></div>
        <p>Также присуствует бонусная игра, при выпадении которой начинается выбор мультиплеера (от 2х до 7х).</p>
    </div>
</div>

<div class="popup popup--x100 popup--about">
    <div class="popup__title d-flex align-center justify-space-between">
        <span>Режим «x100»</span>
        <a href="#" class="close d-flex align-center justify-center">
            <svg class="icon"><use xlink:href="images/symbols.svg#close"></use></svg>
        </a>
    </div>
    <div class="popup__content x100">
        <p>В этом режиме вам предстоит выбрать цвет или цвета и сделать ставку. Если угадаете цвет, который выпадет, то вы выиграли.</p>
        <div class="borders"></div>
        <h4>Возможные ставки:</h4>
        <div class="bets">
            <div class="x30__bet-heading is-ripples flare x2 d-flex align-center justify-space-between">
                <span>X2</span>
                <!-- <img src="images/games/x2.svg"> -->
            </div>
            <div class="x30__bet-heading is-ripples flare x3 d-flex align-center justify-space-between">
                <span>X3</span>
                <!-- <img src="images/games/x3.svg"> -->
            </div>
            <div class="x30__bet-heading is-ripples flare x10 d-flex align-center justify-space-between">
                <span>X10</span>
                <!-- <img src="images/games/x5.svg"> -->
            </div>
            <div class="x30__bet-heading is-ripples flare x15 d-flex align-center justify-space-between">
                <span>X15</span>
                <!-- <img src="images/games/x7.svg"> -->
            </div>
            <div class="x30__bet-heading is-ripples flare x20 d-flex align-center justify-space-between">
                <span>X20</span>
                <!-- <img src="images/games/x14.svg"> -->
            </div>
            <div class="x30__bet-heading is-ripples flare x100 d-flex align-center justify-space-between" >
             <span>X100</span>
             <!-- <img src="images/games/x30.svg"> -->
         </div>
     </div>
     <div class="borders"></div>
     <p>Также присуствует бонусная игра, выпадает она в случайную игру. При выпадении, начинается выбор игрока, укоторого выигрыш умножится на 4х.</p>
 </div>
</div>
<div class="popup popup--about popup--hits">
    <div class="popup__title d-flex align-center justify-space-between">
        <span>Достижения</span>
        <a href="#" class="close d-flex align-center justify-center">
            <svg class="icon"><use xlink:href="images/symbols.svg#close"></use></svg>
        </a>
    </div>
    <div class="popup__content">
        <table>
            <thead>
                <tr>
                    <td>Название</td>
                    <td>Депозит</td>
                    <td>Бонус</td>
                </tr>
            </thead>
            <tbody id="all_status_table">
                <tr>
                    <td>
                        <span class="user-status wolf">Волк</span>
                    </td>
                    <td>
                        <span>100</span>
                    </td>
                    <td>
                        <span>10</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="user-status predator">Хищник</span>
                    </td>
                    <td>
                        <span>500</span>
                    </td>
                    <td>
                        <span>50</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="user-status premium">Премиум</span>
                    </td>
                    <td>
                        <span>1000</span>
                    </td>
                    <td>
                        <span>100</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="user-status alpha">Альфа</span>
                    </td>
                    <td>
                        <span>2500</span>
                    </td>
                    <td>
                        <span>250</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="user-status vip">Вип</span>
                    </td>
                    <td>
                        <span>5000</span>
                    </td>
                    <td>
                        <span>500</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="user-status professional">Профи</span>
                    </td>
                    <td>
                        <span>10000</span>
                    </td>
                    <td>
                        <span>1000</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="user-status legend">Легенда</span>
                    </td>
                    <td>
                        <span>50000</span>
                    </td>
                    <td>
                        <span>5000</span>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="borders"></div>
        <p>Достижение - это уровень, для получения которого необходимо выполнить требования по общей сумме пополнений на сайте за все время. Требования для каждого достижения приведены выше. При получении нового достижения игроку выдается одноразовый бонус в размере, указанном в колонке "Бонус".</p>
    </div>
</div>
<div class="popup popup--fair-dice" style="width: 375px;">
    <div class="popup__title d-flex align-center justify-space-between">
        <span>Dice</span>
        <a href="#" class="close d-flex align-center justify-center">
            <svg class="icon"><use xlink:href="images/symbols.svg#close"></use></svg>
        </a>
    </div>
    <div class="popup__content">
        <div class="dice__check d-flex align-center flex-column">
            <div class="dice__check-chance" id="chanse_dice">30 <</div>
            <div class="dice__check-result dice__check-result--lose d-flex align-end">
                <span id="dice_n_1_check">2</span>
                <span id="dice_n_2_check">9</span>
                <b>,</b>
                <span id="dice_n_3_check">4</span>
                <span id="dice_n_4_check">2</span>
            </div>
        </div>
        <div class="mines__check d-flex justify-space-between align-center">
            <div class="mines__check-sum d-flex align-center">
                <span id="dice_bet">2,212</span>
                <svg class="icon money"><use xlink:href="images/symbols.svg#coins"></use></svg>
            </div>
            <span id="dice_coeff">x3.33</span>
            <div class="mines__check-sum mines__check-sum--total d-flex align-center">
                <span id="dice_win">2,212</span>
                <svg class="icon money"><use xlink:href="images/symbols.svg#coins"></use></svg>
            </div>
        </div>
        <div class="popup__fair d-flex flex-column">
            <div class="popup__fair-item d-flex align-start">
                <b>Full string</b>
                <span id="full_dice">18324ufjdfh2ihi[[123,kmjf</span>
            </div>
            <div class="popup__fair-item d-flex align-start">
                <b>Hash</b>
                <span id="hash_dice">17273721fd9f1jf9idmm11fdi231ij1mjidfhysygu8tgkjmsjgmsgu</span>
            </div>
            <div class="popup__fair-item d-flex align-start">
                <b>Salt1</b>
                <span id="salt1_dice">(6dsi2j,j2,f,[][])</span>
            </div>
            <div class="popup__fair-item d-flex align-start">
                <b>Number</b>
                <span id="number_dice">7772381</span>
            </div>
            <div class="popup__fair-item d-flex align-start">
                <b>Salt2</b>
                <span id="salt2_dice">Q7237yhhiw223r</span>
            </div>
        </div>
    </div>
</div>

</div>

<script type="text/javascript">
    var ADMIN_CHAT = ''
    @guest
    var USER_AVA = '';
    var USER_ID = 0;
    var ADMIN_CHAT = '';
    @else 

    var USER_ID = {{\Auth::user()->id}};
    @if(\Auth::user()->admin == 1) 
    var ADMIN_CHAT = '<div class="chat__buttons-admins">\
    <a href="#"><svg class="icon"><use xlink:href="/images/symbols.svg#close"></use></svg></a>\
    <a href="#" rel="popup" data-popup="popup--ban"><svg class="icon" style="width: 20px; height: 20px"><use xlink:href="/images/symbols.svg#warning"></use></svg></a>\
    </div>';
    @endif
    @endif
</script>

<script src="js/fireworks.js" type="text/javascript"></script>

<script>

    window.onload = function () {
        var firework = JS_FIREWORKS.Fireworks({
            id : 'fireworks-canvas',
            hue : 120,
            particleCount : 50,
            delay : 0,
            minDelay : 20,
            maxDelay : 40,
            fireworkSpeed : 3,
            fireworkAcceleration : 1.05,
            particleFriction : .95,
            particleGravity : 1.5
        });
        firework.start();
        var firework2 = JS_FIREWORKS.Fireworks({
            id : 'fireworks-canvas2',
            hue : 120,
            particleCount : 50,
            delay : 0,
            minDelay : 20,
            maxDelay : 40,
            fireworkSpeed : 4,
            fireworkAcceleration : 1.05,
            particleFriction : .95,
            particleGravity : 1.5
        });
        firework2.start();
    };

   

    @auth
    balanceUpdate(0, {{\Auth::user()->type_balance == 0 ? \Auth::user()->balance : \Auth::user()->demo_balance}}, 1)
    @endauth
    $('#btnSmiles').click(function(e) {
        e.preventDefault()
        $('.chat').toggleClass('chat--smiles').removeClass('chat--stickers');
        $('#btnStickers').removeClass('active');
        $(this).toggleClass('active');
    });
    $('#btnStickers').click(function(e) {
        e.preventDefault()
        $('#btnSmiles').removeClass('active');
        $('.chat').toggleClass('chat--stickers').removeClass('chat--smiles');
        $(this).toggleClass('active');
    });
    $('#dropdownUser').click(function(e){
        e.preventDefault()
        $(this).toggleClass('dropdown');
    });
    $(document).on('click', function(e) {
        if (!$(e.target).closest("#dropdownUser").length) {
            $('.header__user-dropdown').parent().removeClass('dropdown');
        }
        e.stopPropagation();
    });

    $(".popup--wallet .popup__content .wallet").not(":first").hide();
    $(".popup--wallet .popup__tab").click(function () {
        if ($(this).hasClass('popup__tab--active')) {

        } else {
            $(".popup--wallet .popup__content .wallet").hide().eq($(this).index()).fadeIn(500);
        }
        $('.popup--wallet .popup__tab.popup__tab--active').removeClass('popup__tab--active');
        $(this).addClass('popup__tab--active');
        return false;
    });

    $('.wallet--refill .wallet__method').click(function(e) {
        e.preventDefault()
        if ($(this).hasClass('active')) {

        } else {
            $('.wallet--refill .wallet__method.wallet__method--active').removeClass('wallet__method--active')
            $(this).addClass('wallet__method--active')
        }
    });

    $('.wallet--withdraw .wallet__method').click(function(e) {
        e.preventDefault()
        if ($(this).hasClass('active')) {

        } else {
            $('.wallet--withdraw .wallet__method.wallet__method--active').removeClass('wallet__method--active')
            $(this).addClass('wallet__method--active')
        }
    });

    $(".popup--wallet .popup__content .wallet__history").not(":first").hide();
    $(".wallet--history .wallet__tab").click(function () {
        if ($(this).hasClass('wallet__tab--active')) {

        } else {
            $(".popup--wallet .popup__content .wallet__history").hide().eq($(this).index()).fadeIn(500);
        }
        $('.wallet--history .wallet__tab.wallet__tab--active').removeClass('wallet__tab--active');
        $(this).addClass('wallet__tab--active');
        return false;
    });


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
    $(document).ready(function() {
        // captcha_r()
        $(document).on("click","[rel=popup]",function() {

            showPopup($(this).attr('data-popup'));
            return false;
        });

    });

    function showPopup(el) {
        if($('.popup').is('.active')) {
            $('.popup').removeClass('active');  
        }
        $('.overlayed, body, .popup.'+el).addClass('active');
        $('.overlayed').removeClass('animation-closed');
    }



    socket.on('laravel_database_x100Bet',e => {
        e = $.parseJSON(e)
        e = e.data
        class_dop = ''
        if(e.user_id == USER_ID){
            class_dop = 'img_no_blur'
        }
        dopText = ''
        @auth
        @if(\Auth::user()->admin == 1)
        dopText = '<div class="dopPlusBetX100" onclick="getX100Bonus('+e.user_id+', `'+e.img+'`)">Bonus</div>'
        @endif
        @endauth
        $('.x100 .x100__bet-users.x'+e.coff).prepend('<div data-user-id='+e.user_id+' class="x30__bet-user d-flex align-center justify-space-between">'+dopText+'\
            <div class="history__user d-flex align-center justify-center">\
            <div class="history__user-avatar '+class_dop+'" style="background: url('+e.img+') no-repeat center center / cover;"></div>\
            <span>'+e.login+'</span>\
            </div>\
            <div class="x30__bet-sum d-flex align-center">\
            <span>'+(Number(e.bet).toFixed(2))+'</span>\
            <svg class="icon money" style="margin-left: 8px;"><use xlink:href="images/symbols.svg#coins"></use></svg>\
            </div>\
            </div>')

        $('span[data-sumBetsX100='+e.coff+']').html((e.sumBets).toFixed(0))
        $('span[data-playersX100='+e.coff+']').html(e.players)

    })


    function chatAdd(data){
        class_dop = ''
        if(data.user_id == USER_ID || data.type_mess != 0){
            class_dop = 'img_no_blur'
        }

        @if($setting->theme == 0)
            ava = '<div class="chat__msg-avatar '+class_dop+'" style="background: url('+data.avatar+') no-repeat center center / cover;"></div> '
        @else
            ava = '<div class="chat__msg-avatar '+class_dop+'" style="background: url('+data.avatar+') no-repeat center center / cover;"><img src="../images/games/cap_new.png?v=1" class="cap_new"></div> '
        @endif

        
        class_mess = 'mess';


        if(data.type_mess == 4){
            class_mess = 'system_mess';
            @if($setting->theme == 0)
                        ava = '<div class="chat__msg-avatar '+class_dop+'" ></div>';
                        @else
                            ava = '<div class="chat__msg-avatar '+class_dop+'" ><img src="../images/games/cap_new.png?v=1" class="cap_new"></div>';
                        @endif
        }




        dopAdminText = ''
        @if(\Auth::user() && (\Auth::user()->admin == 1 or \Auth::user()->admin == 2))  
        dopAdminText =  '<div class="chat__buttons-admins">\
        <a onclick="deleteMess('+data.id+')"><svg class="icon"><use xlink:href="/images/symbols.svg#close"></use></svg></a>\
        <a onclick="banMessSetId('+data.id+')"  rel="popup" data-popup="popup--ban"><svg class="icon" style="width: 20px; height: 20px;pointer-events: none"><use xlink:href="/images/symbols.svg#warning"></use></svg></a>\
        </div>'
        @endif


        $('.chat__messages .ss-wrapper .ss-content').append('<div id="msg_'+data.id+'" class="chat__msg d-flex align-start">\
            '+ava+'\
            <div class="chat__msg-info d-flex flex-column">\
            <b>'+data.time+'</b>\
            <span>'+data.status_mess+' '+data.autor+'</span>\
            <div class="chat__msg-message '+class_mess+'">\
            <span>'+data.content+'</span>\
            </div>\
            '+dopAdminText+'\
            </div>\
            </div>');

        chatScroll() 


    }



    function chatGet(){
        $.post('/chat/get',{_token: csrf_token}).then(e=>{
            if(e.history){
                $('.chat__messages .ss-wrapper .ss-content').html('');
                e.history.forEach((e)=>{
                    data = e


                    class_dop = ''
                    if(data.user_id == USER_ID || data.type_mess != 0){
                        class_dop = 'img_no_blur'
                    }

                    @if($setting->theme == 0)
                        ava = '<div class="chat__msg-avatar '+class_dop+'" style="background: url('+data.avatar+') no-repeat center center / cover;"></div> '
                    @else
                        ava = '<div class="chat__msg-avatar '+class_dop+'" style="background: url('+data.avatar+') no-repeat center center / cover;"><img src="../images/games/cap_new.png?v=1" class="cap_new"></div> '
                    @endif
                    
                    class_mess = 'mess';


                    if(data.type_mess == 4){
                        class_mess = 'system_mess';
                        @if($setting->theme == 0)
                        ava = '<div class="chat__msg-avatar '+class_dop+'" ></div>';
                        @else
                            ava = '<div class="chat__msg-avatar '+class_dop+'" ><img src="../images/games/cap_new.png?v=1" class="cap_new"></div>';
                        @endif
                        
                    }

                    

                    dopAdminText = ''
                    @if(\Auth::user() && (\Auth::user()->admin == 1 or \Auth::user()->admin == 2))  
                    dopAdminText =  '<div class="chat__buttons-admins">\
                    <a onclick="deleteMess('+data.id+')"><svg class="icon"><use xlink:href="/images/symbols.svg#close"></use></svg></a>\
                    <a onclick="banMessSetId('+data.id+')"  rel="popup" data-popup="popup--ban"><svg class="icon" style="width: 20px; height: 20px;pointer-events: none"><use xlink:href="/images/symbols.svg#warning"></use></svg></a>\
                    </div>'
                    @endif


                    $('.chat__messages .ss-wrapper .ss-content').prepend('<div id="msg_'+data.id+'" class="chat__msg d-flex align-start">\
                        '+ava+'\
                        <div class="chat__msg-info d-flex flex-column">\
                        <b>'+data.time+'</b>\
                        <span>'+data.status_mess+' '+data.autor+'</span>\
                        <div class="chat__msg-message '+class_mess+'">\
                        <span>'+data.content+'</span>\
                        </div>\
                        '+dopAdminText+'\
                        </div>\
                        </div>');

                    chatScroll()

                })


            } 

        })
    }


    chatGet()


    @if(\Auth::user() && (\Auth::user()->admin == 1 or \Auth::user()->admin == 2))  
    function deleteMess(id){

        $.post('/chat/delete',{_token: csrf_token, id}).then(e=>{
          if(e.success){
            notification('success','Успешно')
        }else{      
            notification('error',e.mess)
        }
    })
    }
    function banMessSetId(id){
        $('#chat_id_ban').val(id)
    }
    function banMess(){
        why_ban = $('#why_chat_ban').val()
        time_ban = $('#time_chat_ban').val()
        id = $('#chat_id_ban').val()
        $.post('/chat/ban',{_token: csrf_token, id, why_ban, time_ban}).then(e=>{

          if(e.success){
            notification('success','Успешно')
        }else{    
            notification('error',e.mess)
        }
    })
    }




    @endif  



    activeLinks()


    var captcha_r = function () {
        $('#captcha_reload').html('<div style="width:100%" class="h-captcha" id="captcha"  data-sitekey="952c2020-3e6b-43fe-b941-4659cb499ec7"></div>')
        console.log('hCaptcha is ready.');
        var widgetID = hcaptcha.render('captcha', { sitekey: '952c2020-3e6b-43fe-b941-4659cb499ec7' });
    };
    


</script>


    @auth
    @if(\Auth::user()->id != 0)
    <script type="text/javascript">


        function openWinter(id){
            $.post('/winter/start',{_token: csrf_token, id}).then(e=>{
                undisable('.winter__item')   
                if(e.success){  
                    
                    e.prize.forEach(function(item, i, arr) {
                        $('.winter__item:eq('+i+') .winter__front span').html(item+' Р')

                    })  
                   
                    balanceUpdate(e.lastbalance, e.newbalance)
                    notification('success',e.success)
                    notification('success','С Новым годом!')

                    $('.winter__item:eq('+(id - 1)+')').addClass('winter__item--active')

                    setTimeout(() => $('.winter__item').addClass('winter__item--active'),1000);

                    setTimeout(() => location.href='/',2000);

                }else{       
                    notification('error',e.mess)
                }
            }).fail(e=>{
                undisable('.winter__item')   
                notification('error',JSON.parse(e.responseText).message)
            })  
        }

       

        socket.on('laravel_database_openNewYear', function(data){
            $('.winter').fadeIn();
        }) 

        socket.on('laravel_database_closeNewYear', function(data){
            $('.winter').fadeOut();
        }) 

    </script>
    

    @if(\Auth::user()->newYear == 0 && \App\Setting::first()->newYear == 1)
    <script type="text/javascript">
        $('.winter').fadeIn();
    </script>
    @endif

    @endif

    <script type="text/javascript">
        socket.emit('subscribe', 'roomUser_{{\Auth::user()->id}}');
    </script>
    @endauth






</body>
</html>

<style type="text/css">
    @media(max-width: 475px){
  .toast-top-right{
    margin-top: 60px!important;
  }
}
</style>