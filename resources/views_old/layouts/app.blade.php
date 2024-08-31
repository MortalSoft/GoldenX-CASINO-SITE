
<!DOCTYPE html> 
<html>
<head> 
    <meta charset="utf-8">
    <title>LiftUp</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, user-scalable=yes">
    <meta name="description" content="LiftUp" />
    <meta name="keywords" content="liftup, nvuti, cabura, лифтап, лифт, деньги, поднять" />
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="fonts/stylesheet.css">
    <link rel="stylesheet" type="text/css" id="themeSite" href="css/light.css">

    <meta http-equiv="imagetoolbar" content="no" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="shortcut icon" href="/img/logo_icon.png">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800;900&Montserrat&display=swap" rel="stylesheet">
    <script type="text/javascript" src="https://ned.im/noty/v2/vendor/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="https://ned.im/noty/v2/vendor/noty-2.4.1/js/noty/packaged/jquery.noty.packaged.js"></script>
    <script type="text/javascript" src="https://ned.im/noty/v2/vendor/google-code-prettify/prettify.js"></script>
    <script type="text/javascript" src="https://ned.im/noty/v2/vendor/share.min.js"></script>
    <script type="text/javascript" src="https://ned.im/noty/v2/vendor/showdown/showdown.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js" crossorigin="anonymous"></script>

    <script type="text/javascript" src="js/CountUp.js?v=1"></script>

    <script type="text/javascript">



        @guest
        var USER_AVA = ''
        var USER_ID = 0;
        var ADMIN_CHAT = '';
        @else

        @php 
        $ava = htmlentities(\Auth::user()->avatar, ENT_QUOTES, 'UTF-8'); 
        @endphp
        


        var  USER_AVA = '{{$ava}}'
        var USER_ID = {{\Auth::user()->id}};

        
        @if(\Auth::user() && (\Auth::user()->admin == 1 or \Auth::user()->admin == 2))  
        function deleteMess(){
            id = $('#id_mess_ban_modal').val()
            $.post('/chat/delete',{_token: csrf_token, id}).then(e=>{
              if(e.success){
                notification('success','Успешно')
            }else{      
                notification('error',e.mess)
            }
        })
        }
        function banMessShow(){
            id = $('#id_mess_ban_modal').val()
            show_modal('chat_ban')
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
        function open_admin(that) {
          var id_mess = $(that).parent('.admin_panel_chat').parent('.class_mess').attr('id_mess')
          $('#id_mess_ban_modal').val(id_mess)
          show_modal('select_chat')
      }


      var ADMIN_CHAT = '<div class="admin_panel_chat"><div style="width:100%;height:100%" onclick="open_admin(this)"><svg width="6" height="32" viewBox="0 0 6 32" fill="none" xmlns="http://www.w3.org/2000/svg">\
      <circle cx="2.76596" cy="2.76596" r="2.76596" fill="#A9AFCA"/>\
      <circle cx="2.76596" cy="15.766" r="2.76596" fill="#A9AFCA"/>\
      <circle cx="2.76596" cy="28.766" r="2.76596" fill="#A9AFCA"/>\
      </svg></div>\
      </div>';
      // ADMIN_CHAT = ''
      @else
      var ADMIN_CHAT = '';
      @endif  
      @endguest


  </script>
</head>
<body class="blur">
    <div class="panel_bets">
        <div class="top_chat d-mob">
            <div style="width:100%"><span class="circle_online_mob"></span>
                <span class="title_chat" style="font-size: 18px;line-height: 22px;color: #1A2547;">LIVE СТАВКИ</span> </div>

                <div style="width:100%;text-align: right;">
                    <svg class="icon_mob_online"><use xlink:href="img/main/symbols.svg?v=80#user"></use></svg>
                    <span class="online online_mob" ></span>
                </div>


                
            </div>

            <div class="table_game col" style="height:calc(100% - 85px);overflow-y:hidden;">


                <div class="gameHistory" id="gameHistory_1">

                </div>


                <div class="table_game_ten"></div>



            </div>

            
        </div>
        

        <div class="panel_more">
            <div class="top_chat d-mob">
                <div style="width:100%"><span class="circle_online_mob"></span>
                    <span class="title_chat" style="font-size: 18px;line-height: 22px;color: #1A2547;">МЕНЮ</span> </div>

                    <div style="width:100%;text-align: right;">
                        <svg class="icon_mob_online"><use xlink:href="img/main/symbols.svg?v=80#user"></use></svg>
                        <span class="online online_mob" ></span>
                    </div>

                    
                </div>  

                <div style="height:calc(100% - 85px);overflow-y:auto;" class="padding-20">
                    <div class="block_menu_mobile" onclick="@auth load('bonus', this);$('.panel_more').removeClass('open') @else notification('error', 'Авторизуйтесь') @endauth ">
                        <div class="icon_block_menu"><svg style="height: 23px;width: 24px;"><use xlink:href="img/main/symbols.svg?v=80#bonus"></use></svg></div>
                        <span class="text_menu_block">БОНУСЫ</span>
                    </div>
                    <div class="block_menu_mobile" onclick="@auth load('refs', this);$('.panel_more').removeClass('open') @else notification('error', 'Авторизуйтесь') @endauth ">
                        <div class="icon_block_menu"><svg style="height: 23px;width: 21px;"><use xlink:href="img/main/symbols.svg?v=80#user"></use></svg></div>
                        <span class="text_menu_block">ПАРТНЕРКА</span>
                    </div>
                    <div class="block_menu_mobile" onclick="load('faq');$('.panel_more').removeClass('open')">
                        <div class="icon_block_menu"><svg style="height: 23px;width: 20px;"><use xlink:href="img/main/symbols.svg?v=80#faq"></use></svg></div>
                        <span class="text_menu_block">F.A.Q</span>
                    </div>
                    <div class="block_menu_mobile"onclick="open_link('https://vk.com/public{{\App\Setting::first()->group_id}}');$('.panel_more').removeClass('open')">
                        <div class="icon_block_menu"><svg style="height: 26px;width: 24px;"><use xlink:href="img/main/symbols.svg?v=80#support"></use></svg></div>
                        <span class="text_menu_block">ПОДДЕРЖКА</span>
                    </div>
                </div>
            </div>
            <div class="preloader">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin:auto;background:transparent;display:block;" width="200px" height="200px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                    <defs><clipPath id="ldio-bi2sjpa4f4-cp"><rect x="0" y="0" width="100" height="82.235"></rect></clipPath></defs>
                    <path stroke="#dcdcdc" stroke-width="1" fill="#dcdcdc" d="M85.529 75.177H14.471c-2.469 0-4.471 2.002-4.471 4.471h80C90 77.179 87.998 75.177 85.529 75.177z"></path>
                    <g clip-path="url(#ldio-bi2sjpa4f4-cp)">
                        <g>
                            <animateTransform attributeName="transform" type="translate" repeatCount="indefinite" dur="1s" values="0 0;0 150" keyTimes="0;1"></animateTransform>
                            <g transform="translate(0 -75)">
                                <path fill="#ffb856" d="M50 25c-13.785 0-25 11.215-25 25s11.215 25 25 25s25-11.216 25-25S63.784 25 50 25z M50 70.845 c-11.494 0-20.844-9.351-20.844-20.845S38.506 29.155 50 29.155S70.845 38.506 70.845 50S61.493 70.845 50 70.845z"></path>
                                <path fill="#ffd55d" d="M50 29.155c-11.494 0-20.844 9.351-20.844 20.844S38.506 70.845 50 70.845S70.845 61.493 70.845 50S61.493 29.155 50 29.155 z"></path>
                                <path fill="#ffff34" d="M48.11 62.796v-1.64c-1.535-0.068-3.041-0.358-4.281-0.765c-1.029-0.337-1.611-1.421-1.342-2.469 l0.043-0.167c0.297-1.158 1.521-1.781 2.653-1.395c1.152 0.392 2.465 0.662 3.855 0.662c2.032 0 3.421-0.783 3.421-2.21 c0-1.354-1.14-2.21-3.778-3.101c-3.814-1.283-6.416-3.066-6.416-6.523c0-3.137 2.211-5.596 6.025-6.345v-1.639 c0-0.965 0.782-1.746 1.746-1.746h0c0.965 0 1.746 0.782 1.746 1.746v1.39c1.275 0.057 2.327 0.226 3.21 0.459 c1.107 0.291 1.782 1.404 1.498 2.513v0c-0.287 1.118-1.44 1.803-2.546 1.473c-0.843-0.251-1.887-0.453-3.16-0.453 c-2.317 0-3.066 0.998-3.066 1.997c0 1.176 1.247 1.924 4.277 3.065c4.241 1.498 5.953 3.458 5.953 6.666 c0 3.173-2.246 5.882-6.345 6.594v1.89c0 0.965-0.782 1.746-1.746 1.746h-0.001C48.892 64.543 48.11 63.761 48.11 62.796z"></path>
                            </g>
                        </g>
                    </g>
                    <path stroke="#dcdcdc" stroke-width="1" fill="#dcdcdc" d="M14.471 84.823h71.058c2.469 0 4.471-2.002 4.471-4.471v-0.704H10v0.704C10 82.821 12.002 84.823 14.471 84.823z"></path>


                </svg>


                <span class="text-secondary" style="font-size: 20px;display: block;position: absolute;top:calc(50% + 100px);left: 50%;transform: translate(-50%,-50%);">Загрузка...</span>

            </div>
            <div class="header">
                <div class="flex" style="height:98px;padding-top:0px;padding-bottom: 0px;align-items: center;position: fixed;z-index: 10;">
                    <div class="col-menu-lg d-all d-img"  style="width:50px">
                        <img src="img/logo_2.png?v=1" class="logo d-comp" onclick="load('')">
                        <img src="img/logo_icon.png?v=1" class="logo d-mob" style="max-width:45px;position:relative;top: 0px;" onclick="load('')">
                    </div>
                    <div class="col" style="max-width: 700px;margin: 0 auto;">
                        <div class="flex no_padding wrap comp_padding" style="text-align:center;">
                            <div class="col-5 d-comp">
                                <div class="flex no_padding menu_icon" style="text-align:start;padding-top: 10px!important;">
                                    <div class="col" style="position: relative;">
                                        <svg style="height: 23px;width: 24px;" class="page_active page_" onclick="load('', this) ">  <use xlink:href="img/main/symbols.svg?v=80#home"></use></svg>

                                    </div>
                                    <div class="col">
                                        <svg style="height: 23px;width: 24px;" class="page_active page_bonus" onclick="@auth load('bonus', this) @else notification('error', 'Авторизуйтесь') @endauth">  <use xlink:href="img/main/symbols.svg?v=80#bonus"></use></svg>

                                    </div> 

                                    <div class="col">


                                       <svg style="height: 23px;width: 21px;" class="page_active page_refs" onclick="@auth load('refs', this) @else notification('error', 'Авторизуйтесь') @endauth">  <use xlink:href="img/main/symbols.svg?v=80#user"></use></svg>

                                   </div>

                                   <div class="col"> 


                                       <svg style="height: 23px;width: 20px;" class="page_active page_faq" onclick="load('faq', this) ">  <use xlink:href="img/main/symbols.svg?v=80#faq"></use></svg>

                                   </div>

                                   <div class="col">
                                       <svg style="height: 23px;width: 24px;" class="page_active" onclick="open_link('https://vk.com/public{{\App\Setting::first()->group_id}}') ">  <use xlink:href="img/main/symbols.svg?v=80#support"></use></svg>



                                   </div>
                               </div>
                           </div>
                           <!-- <div class="col-5 d-mob"></div> -->
                           @auth
                           <div class="col-lg-5" style="text-align:right;">
                            <div style="display:inline-block;position: relative;top:5px;margin-right: 10px;" сlass="">
                                <div class="text_bal">Баланс</div>
                                <div style="position: relative;top:5px" class="balance_block"><span class="balance" id="balance"><span id="balance_first"></span>.<span id="balance_second"></span><span id="balance_third"></span></span>
                                    <svg style="height: 13px;width: 13px;"><use xlink:href="img/main/symbols.svg?v=80#coins"></use></svg>
                                </div>
                            </div>
                            <button class="btn-dep" onclick="load('wallet')">Пополнить</button>
                            <button class="btn-prof btn_open_close_prof" style="cursor: default;position: relative;">
                                <svg style="height: 16px;width: 16px;position: relative;top:1px;" ><use xlink:href="img/main/symbols.svg?v=80#user"></use></svg> 
                                

                                <svg width="11" height="7" class="icon_profile_menu_mini click_pp"  viewBox="0 0 11 7" fill="none" xmlns="http://www.w3.org/2000/svg"> 
                                    <path d="M5.5 7L0.73686 0.25L10.2631 0.250001L5.5 7Z" />
                                </svg>

                                <div style="position:absolute;opacity: 0;width: 52px;height: 41px;top:0px;left: 0px;" class="click_pp"></div>
                                <div class="block_panel_prof">
                                    <div class="div_prof"><span class="text_id">ID: {{\Auth::user()->id}}</span></div>

                                    
                                    <div class="hr_prof"></div>
                                    <div class="div_prof"><span class="text_exit" onclick="load('profile');$('.btn_open_close_prof').removeClass('active');">
                                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6.99953 6.42811C8.80401 6.42811 10.2667 4.98922 10.2667 3.21406C10.2667 1.4389 8.80401 0 6.99953 0C5.19505 0 3.73239 1.4389 3.73239 3.21406C3.73239 4.98922 5.19505 6.42811 6.99953 6.42811V6.42811ZM0.0116709 12.5173C-0.0793708 13.0707 0.374747 13.5711 0.937353 13.5711H13.0623C13.6434 13.5711 14.079 13.0707 13.9879 12.5173C13.4613 9.32146 10.5393 7.49964 7.00008 7.49964C3.4609 7.49964 0.538295 9.32093 0.0116709 12.5173V12.5173Z" fill="#67749A"/>
                                        </svg>


                                        ПРОФИЛЬ
                                    </span></div>
                                    <style type="text/css">
                                    .block_panel_prof{                                        
                                        height: 160px;
                                    }
                                </style>
                                


                                <div class="hr_prof"></div>
                                <div class="div_prof"><span class="text_exit" onclick="location.href='/logout'">
                                    <svg width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1.22222 11H9.77778C10.4518 11 11 10.4518 11 9.77778V1.22222C11 0.548167 10.4518 0 9.77778 0H1.22222C0.548167 0 0 0.548167 0 1.22222V4.8895H4.27656V2.44444L7.94322 5.5L4.27656 8.55556V6.11172H0V9.77778C0 10.4518 0.548167 11 1.22222 11Z" fill="#67749A"/>
                                    </svg>

                                    ВЫЙТИ
                                </span></div>
                            </div>

                        </button>
                    </div>
                    @else
                    <div class="col-lg-5" style="text-align:right;">
                        <button onclick="location.href='/vk_auth'" class="btn-auth">Авторизация</button>
                    </div>
                    @endauth



                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function activeLinks(){

            $('.page_active').removeClass('active');
            var s = location.href;
            var url = (s.substr(s.lastIndexOf("/")+1))
            $('.page_'+url).addClass('active');
        }

        

        function load(page, that) {
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

                }).fail(function(jqxhr, settings, exception) {
                    $('.preloader').addClass("preloader-remove");
                    notifaction("error", "Ошибка")      
                });
            };

            _load();
        }





    </script>

    <script type="text/javascript" src="js/script.js"></script>


    <div id="_ajax_content_">{!! html_entity_decode($page) !!}</div>


    <div class="flex">
        <div class="col-menu-lg" style="text-align: center;">
            <div style="height: 100%;display: grid;position: relative;">

                <div class="menu">
                    <div class="panel_menu panel_0" style="text-align:center;">
                        <div class="icon_menu">

                            <svg class="page_active page_x30"  onclick="load('x30', this)" style="width: 24px;height:24px;">  <use xlink:href="img/main/symbols.svg?v=80#x50"></use></svg>

                        </div>

                        <div class="icon_menu">


                           <svg class="page_active page_dice"  onclick="load('dice', this)" style="width: 24px;height:24px;">  <use xlink:href="img/main/symbols.svg?v=80#dice"></use></svg>

                       </div>
                       <div class="icon_menu">


                        <svg class="page_active page_mines"  onclick="load('mines', this)" style="width: 24px;height:24px;">  <use xlink:href="img/main/symbols.svg?v=80#mines"></use></svg>

                    </div>


                    
                     <style type="text/css">
                        .panel_0{
                            height: 155px;
                        }
                        .panel_1{
                            margin-top: 330px;
                        }
                    </style>


                </div>

                @auth 
                <div class="panel_menu panel_1" style="text-align:center;height: 140px;padding: 0px;padding-top: 0px;width: 73px;">
                    <div class="avatar" style="padding: 14px;border-radius: 15px;">
                        <img src="{{\Auth::user()->avatar}}" style="width:45px;height:45px;border-radius: 20px;filter: drop-shadow(0px 10px 15px rgba(0, 0, 0, 0.06));">
                    </div>

                    <div class="icon_menu" onclick="location.href='/logout'" style="margin-top: 20px">
                        <svg  style="width: 18px;height:18px;"> <use xlink:href="img/main/symbols.svg?v=80#logout"></use></svg>
                    </div>

                </div>

                @endauth
            </div>
        </div>
    </div>
    <div class="col" >

    </div>
    @include('layouts.chat')
</div>


<div class="d-mob fixed_mob">
    <div class="flex no_padding">
        <div class="menu_icon_bottom page_active page_" onclick="load('', this)">

            <svg style="height: 23px;width: 24px;"><use xlink:href="img/main/symbols.svg?v=80#home"></use></svg>

            <br>
            <span class="text_bottom">Главная</span>
        </div>
        <div class="menu_icon_bottom bets_btn">


            <svg style="height: 24px;width: 24px;"><use xlink:href="img/main/symbols.svg?v=80#coins"></use></svg>

            <br>
            <span class="text_bottom">Ставки</span>
        </div>
        <div class="menu_icon_bottom chat_btn">

            <svg style="height: 22px;width: 28px;"><use xlink:href="img/main/symbols.svg?v=80#chat"></use></svg>



            <br>
            <span class="text_bottom">Чат</span>
        </div>
        <div class="menu_icon_bottom more_btn">
            <svg style="height: 23px;width: 24px;"><use xlink:href="img/main/symbols.svg?v=80#more"></use></svg>

            

            <br>
            <span class="text_bottom">Ещё</span>
        </div>
    </div>
</div>



<div class="modal_body" style="display:none;z-index:51">
 <div class="modal_panel modal_payment" style="display:none;position:relative;display: block;">
    <div class="modal_system"><img src="../img/wallet/qiwi.png" id="img_pay"></div>
    <div class="padding-30">
        <div style="margin-top:0px">
         <label>Кошелек для перевода</label>
         <div class="flex no_padding wrap">
            <div style="position:relative;margin-top: 10px;" class="col">
                <input type="" readonly="" value="" id="wallet_pay" class="secodary_input"name="">

            </div>


        </div>
    </div>

    <div style="margin-top:10px">
     <label>Комментарий для перевода</label>
     <div class="flex no_padding wrap">
        <div style="position:relative;margin-top: 10px;" class="col">
            <input type="" readonly="" value="" id="comment_pay" class="secodary_input"name="">

        </div>


    </div>
</div>

<div style="margin-top:10px">
 <label>Сумма перевода</label>
 <div class="flex no_padding wrap">
    <div style="position:relative;margin-top: 10px;" class="col">
        <input type="" readonly="" value="" id="sum_pay" class="secodary_input"name="">

    </div>


</div>
</div>


<div class="flex no_padding wrap" style="width:100%; margin-bottom: 20px;">
    <div class="col"><button class="btn_bet_dice" style="width:100%;margin-top:25px;" id="check_pay">Проверить перевод</button></div> 
    <div class="col"><button class="btn-dep" style="width:100%;margin-top:25px;" onclick="close_modal()">Закрыть</button></div>
</div>
<!-- <span class="text-secondary">*Срок зачисления депозита до 2 часов</span><br> -->
<div  class="text-secondary" style="font-size:13px;font-weight: normal;margin-top:0px;">При переводе вы должны в точности указать номер кошелька, сумму, комментарий. В случае ошибки деньги не возвращаем.</div>
</div>
</div>  
 
<div class="modal_panel modal_select_chat" style="display:none;position:relative;display: block;">

    <div class="padding-30">
        <input type="hidden" id="id_mess_ban_modal" name="">
        <div class="flex no_padding wrap">
            <div style="position:relative;margin-top: 0px;" class="col-5">
                <button class="btn-dep" style="width:100%;" onclick="deleteMess();close_modal()">Удалить</button>

            </div>

            <div style="position:relative;margin-top: 0px;" class="col-5">
                <button class="btn-dep" style="width:100%;" onclick="close_modal();banMessShow();">Забанить</button>

            </div>


            <div style="position:relative;margin-top: 10px;" class="col">
               <button class="btn-auth" style="width:100%;" onclick="close_modal()">Закрыть</button>
           </div>


       </div>








   </div>
</div>


@auth
<div class="modal_panel modal_tg" style="display:none;position:relative;display: block;">

    <div class="padding-30">
        <div style="margin-top:0px">
         <label  style="font-size: 15px;line-height: 15px">Для привязки аккаунта напишите нашему боту <a style="text-decoration-line: none;color: #706bf6" href="https://t.me/{{\App\Setting::first()->tg_bot_id}}" target="_blank">@<span>{{\App\Setting::first()->tg_bot_id}}</span></a> данное сообщение:</label>
         <div class="flex no_padding wrap">
            <div style="position:relative;margin-top: 10px;" class="col">
                <input type="" style="text-align: center;" readonly="" value="/bind {{\Auth::user()->id}}" id="" class="secodary_input"name="">

            </div>


        </div>
    </div>

    <div class="flex no_padding wrap" style="width:100%">
        <div class="col"><button class="btn_bet_dice" style="width:100%;margin-top:25px;" onclick="disable(this);checkTgConnect(this)">Проверить привязку</button></div>
        <div class="col"><button class="btn-dep" style="width:100%;margin-top:25px;" onclick="close_modal()">Закрыть</button></div>
    </div>
</div>
</div>

<div class="modal_panel modal_check_dice element" style="display:none;position:relative;display: block;max-height: 90%;overflow-y: auto;">
    <div class="padding-30" style="text-align:center">

        <div style="position:relative;" class="block_dice block_dice_check">
            <span class="percent_dice_check" id="chanse_dice">< 30</span>
            <img src="img/dice_lose.svg" class="svg_dice svg_dice_check">
            <div class="text_dice" style="position:absolute;height: 55px;width: 200px;top:44%;display: flex;left:50%;transform: translate(-50%,-50%);">

                <span class="p_t_big" id="dice_n_1_check">0</span>
                <span class="p_t_big" id="dice_n_2_check">0</span>
                <span class="p_t_big" id="dice_n_3_check">0</span>
                <span class="p_t_big" id="dice_n_4_check">0</span>
                
            </div>

            <div class="text_dice" style="position:absolute;height: 55px;width: 200px;top:44%;left:50%;transform: translate(-50%,-50%);">
                <span style="width:100%;font-size: 30px;line-height: 37px;position: relative;top:15px">,</span>
            </div>


        </div>
        <div class="hr" style="height:1px;"></div>
        <div class="flex no_padding">
            <div class="col"><span class="color_gray_d small">Ставка</span><br><span class="color_gray_d" id="dice_bet"></span></div>
            <div class="col"><span class="color_gray_d small">Коэффициент</span><br><span class="color_gray_d" id="dice_coeff"></span></div>
            <div class="col"><span class="color_gray_d small">Выигрыш</span><br><span class="percent_dice_check" id="dice_win"></span></div>
        </div>
        <div class="hr" style="height:1px;margin-top: 20px;"></div>

        <div class="flex no_padding">
            <div class="col" style="min-width:100px;width: 100px;text-align: left;"><span class="title_check">Full String</span></div>
            <div class="col" style="width: calc(100% - 100px);text-align: left;"><span class="body_check" id="full_dice"></span></div>
        </div>

        <div class="flex no_padding" style="margin-top:10px">
            <div class="col" style="min-width:100px;width: 100px;text-align: left;"><span class="title_check">Hash</span></div>
            <div class="col" style="width: calc(100% - 100px);text-align: left;"><span class="body_check" id="hash_dice"></span></div>
        </div>

        <div class="flex no_padding" style="margin-top:10px">
            <div class="col" style="min-width:100px;width: 100px;text-align: left;"><span class="title_check">Salt1</span></div>
            <div class="col" style="width: calc(100% - 100px);text-align: left;"><span class="body_check" id="salt1_dice"></span></div>
        </div>

        <div class="flex no_padding" style="margin-top:10px">
            <div class="col" style="min-width:100px;width: 100px;text-align: left;"><span class="title_check">Number</span></div>
            <div class="col" style="width: calc(100% - 100px);text-align: left;"><span class="body_check" id="number_dice"></span></div>
        </div>

        <div class="flex no_padding" style="margin-top:10px">
            <div class="col" style="min-width:100px;width: 100px;text-align: left;"><span class="title_check">Salt2</span></div>
            <div class="col" style="width: calc(100% - 100px);text-align: left;"><span class="body_check" id="salt2_dice"></span></div>
        </div>

        <button style="margin-top:10px;" class="btn-dep w-100" onclick="close_modal()">Закрыть</button>
    </div>

</div>




<div class="modal_panel modal_check_mine element" style="display:none;position:relative;display: block;max-height: 90%;overflow-y: auto;">
    <div class="padding-30" style="text-align:center">
        <div class="wrapper wrapper_mine_check minesPoleCheck">
            @for ($i = 0; $i < 25; $i++)
            <div class="mine mine_check"><img class="mine_img win hide" src="img/mine_img_win.png" ><img class="mine_img lose hide" src="img/mine_img_lose.png" ></div>
            @endfor 
        </div>
        <div class="hr" style="height:1px;margin-top: 15px;"></div>
        <div class="flex no_padding">
            <div class="col"><span class="color_gray_d small">Ставка</span><br><span class="color_gray_d" id="mine_bet"></span></div>
            <div class="col"><span class="color_gray_d small">Коэффициент</span><br><span class="color_gray_d" id="mine_coeff"></span></div>
            <div class="col"><span class="color_gray_d small">Выигрыш</span><br><span class="percent_dice_check" id="mine_win"></span></div>
        </div>
        <div class="hr" style="height:1px;margin-top: 20px;"></div>

        <div class="flex no_padding">
            <div class="col" style="min-width:100px;width: 100px;text-align: left;"><span class="title_check">Full String</span></div>
            <div class="col" style="width: calc(100% - 100px);text-align: left;"><span class="body_check" id="full_mine"></span></div>
        </div>

        <div class="flex no_padding" style="margin-top:10px">
            <div class="col" style="min-width:100px;width: 100px;text-align: left;"><span class="title_check">Hash</span></div>
            <div class="col" style="width: calc(100% - 100px);text-align: left;"><span class="body_check" id="hash_mine"></span></div>
        </div>

        <div class="flex no_padding" style="margin-top:10px">
            <div class="col" style="min-width:100px;width: 100px;text-align: left;"><span class="title_check">Salt1</span></div>
            <div class="col" style="width: calc(100% - 100px);text-align: left;"><span class="body_check" id="salt1_mine"></span></div>
        </div>

        <div class="flex no_padding" style="margin-top:10px">
            <div class="col" style="min-width:100px;width: 100px;text-align: left;"><span class="title_check">Number</span></div>
            <div class="col" style="width: calc(100% - 100px);text-align: left;"><span class="body_check" id="number_mine"></span></div>
        </div>

        <div class="flex no_padding" style="margin-top:10px">
            <div class="col" style="min-width:100px;width: 100px;text-align: left;"><span class="title_check">Salt2</span></div>
            <div class="col" style="width: calc(100% - 100px);text-align: left;"><span class="body_check" id="salt2_mine"></span></div>
        </div>

        <button style="margin-top:10px;" class="btn-dep w-100" onclick="close_modal()">Закрыть</button>
    </div>

</div>

@if(\Auth::user()->admin == 1)


<div class="modal_panel modal_chat_ban" style="display:none;position:relative;display: block;">

    <input type="hidden" id="chat_id_ban" name="">
    <div class="padding-30">
        <div style="margin-top:0px">
         <label>Причина бана</label>
         <div class="flex no_padding wrap">
            <div style="position:relative;margin-top: 10px;" class="col">
                <select type=""  class="secodary_input" id="why_chat_ban" name="">
                    <option value="1">Попрошайничество</option>
                    <option value="2">Распространение реф кодов</option>
                    <option value="3">Оскорбление</option>
                    <option value="4">Спам</option>
                    <option value="5">Слив промо</option>
                    <option value="6">Пиар</option>
                    <option value="7">Клевета</option>
                </select>
            </div>

        </div>
    </div>

    
    <div style="margin-top:10px">
     <label>Бан</label>
     <div class="flex no_padding wrap">
        <div style="position:relative;margin-top: 10px;" class="col">
            <select type=""  class="secodary_input" id="type_chat_ban" onchange="typeChatBan()" name="">
                <option value="1">Навсегда</option>
                <option value="2">До какого-то время</option>
            </select>

        </div>

    </div>
</div>

<div style="margin-top:10px;display: none;" id="type_ban_2">
 <label>Бан до</label>
 <div class="flex no_padding wrap">
    <div style="position:relative;margin-top: 10px;" class="col">
        <input type="datetime-local"  class="secodary_input" id="time_chat_ban" name="">

    </div>

</div>
</div>


<div class="flex no_padding wrap" style="width:100%">
    <div class="col-5"><button class="btn_bet_dice" style="width:100%;margin-top:25px;" onclick="banMess()">Забанить</button></div>
    <div class="col-5"><button class="btn-dep" style="width: 100%;margin-top: 25px;" onclick="close_modal()">Закрыть</button></div>
</div>
</div>
</div>


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

@endif

@endauth

<div class="modal_panel modal_transfer" style="display:none;position:relative;display: block;">
    <div class="avatar_transfer"><img src="" id="avatar_transfer"></div>
    <input type="hidden" id="trans_id" name="">
    <div class="padding-30">
        <div style="margin-top:0px">
         <label>Сумма перевода</label>
         <div class="flex no_padding wrap">
            <div style="position:relative;margin-top: 10px;" class="col mm">
                <input type=""  class="secodary_input input_wheel" id="trans_sum" name="">
                <div class="dop_input">
                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 10.2908V11.375C0 12.2713 2.18359 13 4.875 13C7.56641 13 9.75 12.2713 9.75 11.375V10.2908C8.70137 11.0297 6.78437 11.375 4.875 11.375C2.96563 11.375 1.04863 11.0297 0 10.2908ZM8.125 3.25C10.8164 3.25 13 2.52129 13 1.625C13 0.728711 10.8164 0 8.125 0C5.43359 0 3.25 0.728711 3.25 1.625C3.25 2.52129 5.43359 3.25 8.125 3.25ZM0 7.62734V8.9375C0 9.83379 2.18359 10.5625 4.875 10.5625C7.56641 10.5625 9.75 9.83379 9.75 8.9375V7.62734C8.70137 8.49062 6.78184 8.9375 4.875 8.9375C2.96816 8.9375 1.04863 8.49062 0 7.62734ZM10.5625 7.90664C12.0174 7.6248 13 7.10176 13 6.5V5.41582C12.4109 5.83223 11.5451 6.1166 10.5625 6.2918V7.90664ZM4.875 4.0625C2.18359 4.0625 0 4.97148 0 6.09375C0 7.21602 2.18359 8.125 4.875 8.125C7.56641 8.125 9.75 7.21602 9.75 6.09375C9.75 4.97148 7.56641 4.0625 4.875 4.0625ZM10.4432 5.49199C11.9666 5.21777 13 4.67949 13 4.0625V2.97832C12.0986 3.61563 10.5498 3.9584 8.91973 4.03965C9.66875 4.40273 10.2197 4.89023 10.4432 5.49199Z" fill="#95A5BE"/>
                    </svg>



                </div>
            </div>

        </div>
    </div>


    <div class="flex no_padding wrap" style="width:100%">
        <div class="col-5"><button class="btn_bet_dice" style="width:100%;margin-top:25px;" onclick="disable(this);goTransfer(this)">Перевести</button></div>
        <div class="col-5"><button class="btn-dep" style="width: 100%;margin-top: 25px;" onclick="close_modal()">Закрыть</button></div>
    </div>
</div>
</div>

<div class="modal_panel modal_status" style="display:none;display: block;">
    <div class="padding-30">


        <table>
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Депозит</th>
                    <th>Бонус</th>
                </tr> 
            </thead>
            <!--ряд с ячейками заголовков-->
            <tbody id="all_status_table">                              


            </tbody>

            <!--ряд с ячейками тела таблицы-->
        </table>


        <span class="text-secondary" style="font-weight: 400;font-size:13px">Достижение - это уровень, для получения которого необходимо выполнить требования по общей сумме пополнений на сайте за все время. Требования для каждого достижения приведены выше. При получении нового достижения игроку выдается одноразовый бонус в размере, указанном в колонке "Бонус".</span>
        <button class="btn-dep" style="width: 100%;margin-top: 25px;" onclick="close_modal()">Закрыть</button>
    </div>
</div>

<div class="modal_panel modal_history_jackpot element" style="display:none;display: block;max-height: 90%;overflow-y: auto;">
    <div class="padding-30">


        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Логин</th>
                    <th>Ставка</th>
                    <th>Выигрыш</th>
                </tr> 
            </thead>
            <!--ряд с ячейками заголовков-->
            <tbody id="history_jackpot" style="text-align:center;">                              
                <!--  5 -->

            </tbody>

            <!--ряд с ячейками тела таблицы-->
        </table>

        <button class="btn-dep" style="width: 100%;margin-top: 25px;" onclick="close_modal()">Закрыть</button>
    </div>
</div>


<div class="modal_panel modal_about_wheel" style="display:none;display: block;">
    <div class="padding-30">

        <span class="text-secondary" style="font-weight: 400;font-size:13px">В этом режиме вам предстоит выбрать цвет или цвета и сделать ставку. Если угадаете цвет, который выпадет, то вы выиграли. 
            <div class="hr" style="margin-top:15px;margin-bottom: 15px;"></div>
            <span class="text-secondary">Возможные ставки:</span>
            <div class="flex no_padding wrap" style="margin-top: 15px;">
                <div class="col-5">
                    <div class="bets_block x2" style="box-shadow: none;">
                        <div style="min-width: 49px;max-width: 49px;">
                            <svg width="53" height="30" viewBox="0 0 53 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g filter="url(#filter0_d)">
                                    <path d="M26.5 10.7576L7 3L26.5 19L46 3L26.5 10.7576Z" fill="url(#paint000_radial)"></path>
                                </g>
                                <defs>
                                    <filter id="filter0_d" x="0" y="0" width="53" height="30" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                        <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                                        <feOffset dy="4"></feOffset>
                                        <feGaussianBlur stdDeviation="3.5"></feGaussianBlur>
                                        <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.14 0"></feColorMatrix>
                                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow"></feBlend>
                                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow" result="shape"></feBlend>
                                    </filter>
                                    <radialGradient id="paint000_radial" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(26.5 11) rotate(90) scale(8 19.5)">
                                        <stop stop-color="#FCFF5B"></stop>
                                        <stop offset="1" stop-color="#FCB922"></stop>
                                    </radialGradient>
                                </defs>
                            </svg>

                        </div>
                        <div class="col" style="text-align:right;">

                            <div class="x_wheel" style="top:-17px;color:white;">2x</div>

                        </div>
                    </div>
                </div>

                <div class="col-5">
                    <div class="bets_block x3" style="box-shadow: none;">
                        <div style="min-width: 49px;max-width: 49px;">
                            <img src="img/mini_bet_x3.png" style="position:relative;bottom: 8px;" draggable="false">

                        </div>
                        <div class="col" style="text-align:right;">

                            <div class="x_wheel" style="top:-17px;color:white;">3x</div>

                        </div>
                    </div>
                </div>

                <div class="col-5">
                    <div class="bets_block x5" style="box-shadow: none;">
                        <div style="min-width: 49px;max-width: 49px;">
                            <img src="img/mini_bet_x5.png" style="position:relative;bottom: 6px;" draggable="false">

                        </div>
                        <div class="col" style="text-align:right;">

                            <div class="x_wheel" style="top:-17px;color:white;">5x</div>

                        </div>
                    </div>
                </div>

                <div class="col-5">
                    <div class="bets_block x30" style="box-shadow: none;">
                        <div style="min-width: 49px;max-width: 49px;">
                            <img src="img/mini_bet_x30.png" style="position:relative;bottom: 10px;" draggable="false">

                        </div>
                        <div class="col" style="text-align:right;">

                            <div class="x_wheel" style="top:-17px;color:white;">30x</div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="hr" style="margin-top:15px;margin-bottom: 15px;"></div>

            <span class="text-secondary" style="font-weight: 400;font-size:13px">Также присуствует бонусная игра, при выпадении которой начинается выбор мультиплеера (от 2х до 7х).</span>
            <div style="display:flex;justify-content: center;margin-top: 15px;">
                <div class="bets_block xbonus" style="box-shadow: none;width: 55px;padding: 0px;">
                    <div style="min-width: 100%;text-align: center;">
                        <img src="img/mini_bet_xbonus.png?v=1" style="position:relative;bottom: 10px;width: 40px;" draggable="false">

                    </div>
                </div>
            </div>
            


        </span>
        <button class="btn-dep" style="width: 100%;margin-top: 25px;" onclick="close_modal()">Закрыть</button>
    </div>
</div>

<div class="modal_panel modal_promo" style="display:none">
    <div class="modal_panel_1">
        <div class="block_modal_btn active" onclick="$('.modal_panel_2 .padding-30').hide();$('#active_promo').show();$('.block_modal_btn').removeClass('active');$(this).addClass('active');">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0)">
                    <path d="M1.45351 5.62598H8.48476V8.43848H1.45351V5.62598Z" />
                    <path d="M1.45351 9.84473H8.48476V19.6885H1.45351V9.84473Z" />
                    <path d="M15.516 5.62598H22.5473V8.43848H15.516V5.62598Z" />
                    <path d="M15.516 19.6885H22.5473V9.84473H15.516V19.6885ZM16.9223 15.4697H21.141V16.876H16.9223V15.4697Z" fill="white"/>
                    <path d="M16.1745 3.72075C16.65 3.31875 16.9215 2.73225 16.9215 2.10975C16.9215 0.9465 15.975 0 14.8117 0C13.8877 0 13.0785 0.59175 12.801 1.47225L11.9992 4.002L11.1975 1.47225C10.92 0.59175 10.1115 0 9.18675 0C8.0235 0 7.077 0.9465 7.077 2.10975C7.077 2.7315 7.34925 3.31875 7.8255 3.7215L10.0777 5.62575H9.8895V24.0007L11.9992 21.891L14.109 24.0007V5.62575H13.9207L16.1745 3.72075ZM14.142 1.8975C14.2357 1.60425 14.5042 1.407 14.8125 1.407C15.1995 1.407 15.516 1.722 15.516 2.10975C15.516 2.31675 15.4252 2.51325 15.2677 2.6475L13.407 4.2195L14.142 1.8975ZM8.48475 2.1105C8.48475 1.72275 8.8005 1.407 9.18825 1.407C9.49575 1.407 9.765 1.60425 9.85875 1.8975L10.5945 4.2195L8.73525 2.64825C8.57625 2.514 8.4855 2.3175 8.4855 2.10975L8.48475 2.1105Z" />
                </g>
                <defs>
                    <clipPath id="clip0">
                        <rect width="24" height="24" fill="white" transform="translate(0 0.000976562)"/>
                    </clipPath>
                </defs>
            </svg>
        </div>

        <div class="block_modal_btn" style="margin-bottom: 15px" onclick="$('.modal_panel_2 .padding-30').hide();$('#create_promo').show();$('.block_modal_btn').removeClass('active');$(this).addClass('active');">
            <svg width="24" height="23" viewBox="0 0 24 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12.3333 11.3333H1M12.3333 22.6667V11.3333V22.6667ZM12.3333 11.3333V0V11.3333ZM12.3333 11.3333H23.6667H12.3333Z"  stroke-width="2" stroke-linecap="round"/>
            </svg>

        </div>
    </div>
    <div class="modal_panel_2">
        <div class="padding-30" id="create_promo" style="display:none">

            <div>
             <label>Название промо</label>
             <div class="flex no_padding wrap">
                <div style="position:relative;margin-top: 10px;" class="col">
                    <input type=""  class="secodary_input input_wheel" id="name_crpromo" name="">
                    <div class="dop_input">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0)">
                                <path d="M0.968964 3.75098H5.65646V5.62598H0.968964V3.75098Z" fill="#95A5BE"/>
                                <path d="M0.968964 6.56348H5.65646V13.126H0.968964V6.56348Z" fill="#95A5BE"/>
                                <path d="M10.344 3.75098H15.0315V5.62598H10.344V3.75098Z" fill="#95A5BE"/>
                                <path d="M10.344 13.126H15.0315V6.56348H10.344V13.126ZM11.2815 10.3135H14.094V11.251H11.2815V10.3135Z" fill="#95A5BE"/>
                                <path d="M10.7829 2.4805C11.0999 2.2125 11.2809 1.8215 11.2809 1.4065C11.2809 0.631 10.6499 0 9.87445 0C9.25845 0 8.71895 0.3945 8.53395 0.9815L7.99945 2.668L7.46495 0.9815C7.27995 0.3945 6.74095 0 6.12445 0C5.34895 0 4.71795 0.631 4.71795 1.4065C4.71795 1.821 4.89945 2.2125 5.21695 2.481L6.71845 3.7505H6.59295V16.0005L7.99945 14.594L9.40595 16.0005V3.7505H9.28045L10.7829 2.4805ZM9.42795 1.265C9.49045 1.0695 9.66945 0.938 9.87495 0.938C10.1329 0.938 10.3439 1.148 10.3439 1.4065C10.3439 1.5445 10.2834 1.6755 10.1784 1.765L8.93795 2.813L9.42795 1.265ZM5.65645 1.407C5.65645 1.1485 5.86695 0.938 6.12545 0.938C6.33045 0.938 6.50995 1.0695 6.57245 1.265L7.06295 2.813L5.82345 1.7655C5.71745 1.676 5.65695 1.545 5.65695 1.4065L5.65645 1.407Z" fill="#95A5BE"/>
                            </g>
                            <defs>
                                <clipPath id="clip0">
                                    <rect width="16" height="16" fill="white" transform="translate(0 0.000976562)"/>
                                </clipPath>
                            </defs>
                        </svg>


                    </div>
                </div>

            </div>
        </div>


        <div style="margin-top:20px">
         <label>Сумма промо</label>
         <div class="flex no_padding wrap">
            <div style="position:relative;margin-top: 10px;" class="col">
                <input type=""  class="secodary_input input_wheel" id="sum_crpromo" name="">
                <div class="dop_input">
                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 10.2908V11.375C0 12.2713 2.18359 13 4.875 13C7.56641 13 9.75 12.2713 9.75 11.375V10.2908C8.70137 11.0297 6.78437 11.375 4.875 11.375C2.96563 11.375 1.04863 11.0297 0 10.2908ZM8.125 3.25C10.8164 3.25 13 2.52129 13 1.625C13 0.728711 10.8164 0 8.125 0C5.43359 0 3.25 0.728711 3.25 1.625C3.25 2.52129 5.43359 3.25 8.125 3.25ZM0 7.62734V8.9375C0 9.83379 2.18359 10.5625 4.875 10.5625C7.56641 10.5625 9.75 9.83379 9.75 8.9375V7.62734C8.70137 8.49062 6.78184 8.9375 4.875 8.9375C2.96816 8.9375 1.04863 8.49062 0 7.62734ZM10.5625 7.90664C12.0174 7.6248 13 7.10176 13 6.5V5.41582C12.4109 5.83223 11.5451 6.1166 10.5625 6.2918V7.90664ZM4.875 4.0625C2.18359 4.0625 0 4.97148 0 6.09375C0 7.21602 2.18359 8.125 4.875 8.125C7.56641 8.125 9.75 7.21602 9.75 6.09375C9.75 4.97148 7.56641 4.0625 4.875 4.0625ZM10.4432 5.49199C11.9666 5.21777 13 4.67949 13 4.0625V2.97832C12.0986 3.61563 10.5498 3.9584 8.91973 4.03965C9.66875 4.40273 10.2197 4.89023 10.4432 5.49199Z" fill="#95A5BE"/>
                    </svg>



                </div>
            </div>

        </div>
    </div>


    <div style="margin-top:20px">
     <label>Кол-во активаций</label>
     <div class="flex no_padding wrap">
        <div style="position:relative;margin-top: 10px;" class="col">
            <input type=""  class="secodary_input input_wheel" id="act_crpromo" name="">
            <div class="dop_input">
                <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.49957 6.1576C8.17515 6.1576 9.53334 4.77925 9.53334 3.0788C9.53334 1.37834 8.17515 0 6.49957 0C4.82398 0 3.46579 1.37834 3.46579 3.0788C3.46579 4.77925 4.82398 6.1576 6.49957 6.1576ZM0.0108372 11.9905C-0.0737015 12.5207 0.34798 13 0.870399 13H12.1292C12.6689 13 13.0733 12.5207 12.9888 11.9905C12.4998 8.92918 9.78645 7.18403 6.50007 7.18403C3.21369 7.18403 0.499846 8.92867 0.0108372 11.9905Z" fill="#95A5BE"/>
                </svg>



            </div>
        </div>

    </div>
</div>

<div class="flex no_padding wrap">
    <div class="col-5"><button class="btn_bet_dice" style="width:100%;margin-top:25px;" onclick="disable(this);createPromoUser(this)">Создать</button></div>
    <div class="col-5"><button class="btn-dep" style="width: 100%;margin-top: 25px;" onclick="close_modal()">Закрыть</button></div>
</div>


</div>


<div class="padding-30" id="active_promo">

    <div>
     <label>Активация промокода</label>
     <div class="flex no_padding wrap">
        <div style="position:relative;margin-top: 10px;max-width: calc(100% - 55px);" class="col-5">
            <input type=""  class="secodary_input input_wheel"name="" id="promo_name">
            <div class="dop_input">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0)">
                        <path d="M0.968964 3.75098H5.65646V5.62598H0.968964V3.75098Z" fill="#95A5BE"/>
                        <path d="M0.968964 6.56348H5.65646V13.126H0.968964V6.56348Z" fill="#95A5BE"/>
                        <path d="M10.344 3.75098H15.0315V5.62598H10.344V3.75098Z" fill="#95A5BE"/>
                        <path d="M10.344 13.126H15.0315V6.56348H10.344V13.126ZM11.2815 10.3135H14.094V11.251H11.2815V10.3135Z" fill="#95A5BE"/>
                        <path d="M10.7829 2.4805C11.0999 2.2125 11.2809 1.8215 11.2809 1.4065C11.2809 0.631 10.6499 0 9.87445 0C9.25845 0 8.71895 0.3945 8.53395 0.9815L7.99945 2.668L7.46495 0.9815C7.27995 0.3945 6.74095 0 6.12445 0C5.34895 0 4.71795 0.631 4.71795 1.4065C4.71795 1.821 4.89945 2.2125 5.21695 2.481L6.71845 3.7505H6.59295V16.0005L7.99945 14.594L9.40595 16.0005V3.7505H9.28045L10.7829 2.4805ZM9.42795 1.265C9.49045 1.0695 9.66945 0.938 9.87495 0.938C10.1329 0.938 10.3439 1.148 10.3439 1.4065C10.3439 1.5445 10.2834 1.6755 10.1784 1.765L8.93795 2.813L9.42795 1.265ZM5.65645 1.407C5.65645 1.1485 5.86695 0.938 6.12545 0.938C6.33045 0.938 6.50995 1.0695 6.57245 1.265L7.06295 2.813L5.82345 1.7655C5.71745 1.676 5.65695 1.545 5.65695 1.4065L5.65645 1.407Z" fill="#95A5BE"/>
                    </g>
                    <defs>
                        <clipPath id="clip0">
                            <rect width="16" height="16" fill="white" transform="translate(0 0.000976562)"/>
                        </clipPath>
                    </defs>
                </svg>


            </div>
        </div>
        <div class="col-5" style="max-width:45px">
            <div class="flex no_padding wrap" > 
                <button class="btn_bet col" onclick="disable(this);actPromo(this)"><svg width="18" height="19" style="position: relative;top:3px" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.7715 0.219402C17.6703 0.118657 17.5424 0.0489052 17.4029 0.0183473C17.2634 -0.0122106 17.1181 -0.00230401 16.984 0.0469024L0.484014 6.0469C0.341715 6.10088 0.219204 6.19686 0.132753 6.32212C0.0463009 6.44737 0 6.59596 0 6.74815C0 6.90034 0.0463009 7.04893 0.132753 7.17419C0.219204 7.29944 0.341715 7.39543 0.484014 7.4494L6.92651 10.0219L11.6815 5.2519L12.739 6.3094L7.96151 11.0869L10.5415 17.5294C10.5971 17.669 10.6933 17.7886 10.8177 17.8728C10.942 17.9571 11.0888 18.002 11.239 18.0019C11.3906 17.9988 11.5376 17.9498 11.6608 17.8615C11.784 17.7731 11.8775 17.6495 11.929 17.5069L17.929 1.0069C17.9801 0.87421 17.9924 0.729725 17.9646 0.590295C17.9367 0.450865 17.8697 0.322235 17.7715 0.219402Z" class="svg_iii"/>
                </svg>
            </button>
        </div>
    </div>
</div>
</div>



<div style="margin-top:20px">
 <label>Перевод средств игроку</label>
 <div class="flex no_padding wrap">
    <div style="position:relative;margin-top: 10px;max-width: calc(100% - 55px);" class="col-5">
        <input type="" placeholder="ID игрока"  class="secodary_input input_wheel" id="id_transfer" name="">
        <div class="dop_input">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0)">
                    <path d="M0.968964 3.75098H5.65646V5.62598H0.968964V3.75098Z" fill="#95A5BE"/>
                    <path d="M0.968964 6.56348H5.65646V13.126H0.968964V6.56348Z" fill="#95A5BE"/>
                    <path d="M10.344 3.75098H15.0315V5.62598H10.344V3.75098Z" fill="#95A5BE"/>
                    <path d="M10.344 13.126H15.0315V6.56348H10.344V13.126ZM11.2815 10.3135H14.094V11.251H11.2815V10.3135Z" fill="#95A5BE"/>
                    <path d="M10.7829 2.4805C11.0999 2.2125 11.2809 1.8215 11.2809 1.4065C11.2809 0.631 10.6499 0 9.87445 0C9.25845 0 8.71895 0.3945 8.53395 0.9815L7.99945 2.668L7.46495 0.9815C7.27995 0.3945 6.74095 0 6.12445 0C5.34895 0 4.71795 0.631 4.71795 1.4065C4.71795 1.821 4.89945 2.2125 5.21695 2.481L6.71845 3.7505H6.59295V16.0005L7.99945 14.594L9.40595 16.0005V3.7505H9.28045L10.7829 2.4805ZM9.42795 1.265C9.49045 1.0695 9.66945 0.938 9.87495 0.938C10.1329 0.938 10.3439 1.148 10.3439 1.4065C10.3439 1.5445 10.2834 1.6755 10.1784 1.765L8.93795 2.813L9.42795 1.265ZM5.65645 1.407C5.65645 1.1485 5.86695 0.938 6.12545 0.938C6.33045 0.938 6.50995 1.0695 6.57245 1.265L7.06295 2.813L5.82345 1.7655C5.71745 1.676 5.65695 1.545 5.65695 1.4065L5.65645 1.407Z" fill="#95A5BE"/>
                </g>
                <defs>
                    <clipPath id="clip0">
                        <rect width="16" height="16" fill="white" transform="translate(0 0.000976562)"/>
                    </clipPath>
                </defs>
            </svg>


        </div>
    </div>
    <div class="col-5" style="max-width:45px">
        <div class="flex no_padding wrap" > 
            <button class="btn_bet col" onclick="disable(this);getUserTransfer(this)"><svg width="18" height="19" style="position: relative;top:3px" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.7715 0.219402C17.6703 0.118657 17.5424 0.0489052 17.4029 0.0183473C17.2634 -0.0122106 17.1181 -0.00230401 16.984 0.0469024L0.484014 6.0469C0.341715 6.10088 0.219204 6.19686 0.132753 6.32212C0.0463009 6.44737 0 6.59596 0 6.74815C0 6.90034 0.0463009 7.04893 0.132753 7.17419C0.219204 7.29944 0.341715 7.39543 0.484014 7.4494L6.92651 10.0219L11.6815 5.2519L12.739 6.3094L7.96151 11.0869L10.5415 17.5294C10.5971 17.669 10.6933 17.7886 10.8177 17.8728C10.942 17.9571 11.0888 18.002 11.239 18.0019C11.3906 17.9988 11.5376 17.9498 11.6608 17.8615C11.784 17.7731 11.8775 17.6495 11.929 17.5069L17.929 1.0069C17.9801 0.87421 17.9924 0.729725 17.9646 0.590295C17.9367 0.450865 17.8697 0.322235 17.7715 0.219402Z" class="svg_iii"/>
            </svg>
        </button>
    </div>
</div>
</div>
</div>

<button class="btn-dep" style="width: 100%;margin-top: 25px;" onclick="close_modal()">Закрыть</button>

</div>
</div>
</div>
</div>
<center>
    <div class="footer_bottom_menu">
        <div class="bottom_menu text-secondary page_active page_terms" onclick="load('terms', this)" style="font-size: 12px;">Пользовательское соглашение</div>
        <div class="bottom_menu text-secondary page_active page_policy" onclick="load('policy',this)" style="font-size: 12px;">Политика конфеденциальности</div>
    </div>    
</center>

@auth
<script type="text/javascript">
    balanceUpdate(0, {{\Auth::user()->balance}}, 0)

    if(localStorage.getItem('setting1') == 1){
        $('body').addClass('blur_img')
    } 
    dark = localStorage.getItem('setting_theme')
    if (dark != 1){
        $('#themeSite').attr('href','css/light.css')
    }else{
        $('#themeSite').attr('href','css/dark.css')
    }

    activeLinks();
</script>
@endauth
<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="css/ripple.css">
<script src="js/ripple.js" type="text/javascript"></script>
<script>
    $.ripple('.wheel__bet-item-heading', {
        debug: true,
        multi: false,
        color: "#fff",
        opacity: 0.3,
        duration: 0.3
    });
    
</script> 


<svg height="0" width="0">
  <defs>
    <linearGradient id="lgrad-p" gradientTransform="rotate(75)"><stop offset="45%" stop-color="#4169e1"></stop><stop offset="99%" stop-color="#c44764"></stop></linearGradient>
    <linearGradient id="lgrad-s" gradientTransform="rotate(75)"><stop offset="45%" stop-color="#ef3c3a"></stop><stop offset="99%" stop-color="#6d5eb7"></stop></linearGradient>
    <linearGradient id="lgrad-g" gradientTransform="rotate(75)"><stop offset="45%" stop-color="#585f74"></stop><stop offset="99%" stop-color="#b6bbc8"></stop></linearGradient>
</defs>
</svg>


</body>
</html>

<a href="https://freekassa.ru" target="_blank" style="opacity: 0;height: 0px;width: 0px;position: absolute;" rel="noopener noreferrer">
  <img src="https://cdn.freekassa.ru/banners/small-dark-1.png" title="Прием платежей">
</a>


