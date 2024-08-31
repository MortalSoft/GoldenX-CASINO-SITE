<!DOCTYPE html>
<html>
<head> 
    <meta charset="utf-8">
    <title>LiftUp</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://kit.fontawesome.com/169df733b4.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, user-scalable=yes">
    <link rel="stylesheet" type="text/css" href="../css/style.css?v=@php echo time(); @endphp">
    <link rel="stylesheet" type="text/css" href="../css/admin_styles.css?v=@php echo time(); @endphp">
    <meta http-equiv="imagetoolbar" content="no" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800;900&Montserrat&display=swap" rel="stylesheet">
    <script type="text/javascript" src="https://ned.im/noty/v2/vendor/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="https://ned.im/noty/v2/vendor/noty-2.4.1/js/noty/packaged/jquery.noty.packaged.js"></script>
    <script type="text/javascript" src="https://ned.im/noty/v2/vendor/google-code-prettify/prettify.js"></script>
    <script type="text/javascript" src="https://ned.im/noty/v2/vendor/share.min.js"></script>
    <script type="text/javascript" src="https://ned.im/noty/v2/vendor/showdown/showdown.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js" crossorigin="anonymous"></script>

    <script type="text/javascript" src="../js/CountUp.js?v=1"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>


    <script type="text/javascript">
        var csrf_token = $('meta[name="csrf-token"]').attr('content')
    </script>
</head>
<body class="blur">
    <div class="header">
        <div class="flex" style="height:98px;padding-top:0px;padding-bottom: 0px;align-items: center;background: #f1f1f1;position: fixed;z-index: 10;border-bottom: 2px solid #eaecf1;">
            <div class="col-menu-lg d-all"> 
                <img src="../img/logo_2.png?v=1" class="logo" onclick="load('admin')">
            </div>
            <div class="col" style="max-width: 100%;margin: 0 auto;">
                <div class="flex no_padding wrap comp_padding" style="text-align:center;">
                    <div class="col d-comp">
                        <div class="flex no_padding menu_icon" style="text-align:start;padding-top: 10px!important;">
                            <div class="col active" style="position: relative;" onclick="load('admin', this)">
                                <svg width="24" height="23" viewBox="0 0 24 23" fill="none"  xmlns="http://www.w3.org/2000/svg" >
                                    <path d="M23.5033 11.3116L12.5988 0.251884C12.5203 0.172037 12.427 0.10869 12.3244 0.0654689C12.2217 0.0222474 12.1116 0 12.0005 0C11.8893 0 11.7793 0.0222474 11.6766 0.0654689C11.574 0.10869 11.4807 0.172037 11.4022 0.251884L0.497704 11.3116C0.180021 11.634 0 12.072 0 12.5288C0 13.4773 0.759793 14.2485 1.69431 14.2485H2.84327V22.1402C2.84327 22.6158 3.22184 23 3.69042 23H10.3062V16.9811H13.2712V23H20.3106C20.7792 23 21.1577 22.6158 21.1577 22.1402V14.2485H22.3067C22.7567 14.2485 23.1883 14.0684 23.5059 13.7433C24.1651 13.0715 24.1651 11.9833 23.5033 11.3116Z" fill="url(#paint0_radial)"/>
                                    <defs>
                                        <radialGradient id="paint0_radial" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(12 11.5) rotate(90) scale(11.5 12)">
                                            <stop stop-color="#699AF8"/>
                                            <stop offset="0.0001" stop-color="#7D7AFF"/>
                                            <stop offset="1" stop-color="#5E5BE5"/>
                                        </radialGradient>
                                    </defs>
                                </svg>


                                <span class="text-secondary text_admin">Главная</span>


                            </div>

                            <div class="col" onclick="show_modal('menu_user')">
                                <svg width="21"  height="23" viewBox="0 0 21 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.6696 9.97969C13.244 9.97969 15.3308 7.8836 15.3308 5.29766C15.3308 2.71172 13.244 0.615631 10.6696 0.615631C8.09511 0.615631 6.00833 2.71172 6.00833 5.29766C6.00833 7.8836 8.09511 9.97969 10.6696 9.97969ZM0.7 18.85C0.570112 19.6563 1.218 20.3852 2.02067 20.3852H19.3192C20.1483 20.3852 20.7698 19.6563 20.6399 18.85C19.8886 14.1945 15.7197 11.5406 10.6703 11.5406C5.621 11.5406 1.45133 14.1938 0.7 18.85Z" fill="#67749A"/>
                                </svg>

                                <span class="text-secondary text_admin">Юзеры</span>


                            </div>

                            <div class="col" onclick="load('admin/deps', this)">
                                <svg height="448pt" viewBox="0 0 448 448" width="448pt" style="height: 23px;width: 23px;" xmlns="http://www.w3.org/2000/svg"><path d="m408 184h-136c-4.417969 0-8-3.582031-8-8v-136c0-22.089844-17.910156-40-40-40s-40 17.910156-40 40v136c0 4.417969-3.582031 8-8 8h-136c-22.089844 0-40 17.910156-40 40s17.910156 40 40 40h136c4.417969 0 8 3.582031 8 8v136c0 22.089844 17.910156 40 40 40s40-17.910156 40-40v-136c0-4.417969 3.582031-8 8-8h136c22.089844 0 40-17.910156 40-40s-17.910156-40-40-40zm0 0"/></svg>

                                <span class="text-secondary text_admin">Депы</span>


                            </div>

                            <div class="col" onclick="load('admin/withdraw', this)">


                                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"  style="height: 23px;width: 23px;" x="0px" y="0px"
                                width="124px" height="124px" viewBox="0 0 124 124" style="enable-background:new 0 0 124 124;" xml:space="preserve">
                                <g><path d="M112,50H12C5.4,50,0,55.4,0,62c0,6.6,5.4,12,12,12h100c6.6,0,12-5.4,12-12C124,55.4,118.6,50,112,50z"/></g></svg>


                                <span class="text-secondary text_admin">Выводы</span>


                            </div>

                            <div class="col" onclick="show_modal('menu_promo')">


                                <svg id="Layer_1" enable-background="new 0 0 510 510" style="height: 23px;width: 23px;" height="512" viewBox="0 0 510 510" width="512" xmlns="http://www.w3.org/2000/svg"><g><path d="m488.468 345.72c12.879-4.987 21.532-17.679 21.532-31.584v-64.334c0-19.068-15.513-34.582-34.582-34.582h-3.531c10.468-13.552 9.502-33.148-2.921-45.572l-45.491-45.491c-9.831-9.831-24.924-12.688-37.558-7.108-6.786 2.998-14.871 1.485-20.118-3.762-5.247-5.248-6.76-13.333-3.764-20.118 5.581-12.633 2.725-27.727-7.108-37.559l-45.49-45.491c-13.482-13.481-35.422-13.483-48.906 0l-205.1 205.101h-20.849c-19.069 0-34.582 15.514-34.582 34.582v64.334c0 13.905 8.653 26.598 21.532 31.583 6.917 2.679 11.565 9.465 11.565 16.886s-4.648 14.208-11.565 16.886c-12.879 4.989-21.532 17.682-21.532 31.585v64.333c0 19.068 15.513 34.582 34.582 34.582h440.836c19.069 0 34.582-15.514 34.582-34.582v-64.333c0-13.903-8.652-26.596-21.531-31.585-6.918-2.679-11.566-9.465-11.566-16.886s4.648-14.207 11.565-16.885zm-206.724-314.386c1.787-1.787 4.694-1.787 6.48-.001l45.49 45.491c1.139 1.139 1.492 2.836.878 4.225-7.963 18.031-3.947 39.512 9.993 53.451 13.94 13.94 35.421 17.955 53.453 9.992 1.387-.612 3.085-.26 4.224.879l45.49 45.49c1.787 1.787 1.787 4.695.001 6.48l-17.88 17.879h-78.162l-126.927-126.927zm-78.173 78.172 105.715 105.714h-211.43zm-173.571 365.903v-64.333c0-1.611.951-3.061 2.366-3.609 18.381-7.119 30.73-25.147 30.73-44.862s-12.35-37.743-30.732-44.862c-1.414-.547-2.364-1.997-2.364-3.607v-64.334c0-2.526 2.056-4.582 4.582-4.582h340.418v234.771h-340.418c-2.526 0-4.582-2.055-4.582-4.582zm450-161.273c0 1.61-.95 3.06-2.365 3.608-18.381 7.119-30.732 25.147-30.732 44.862s12.35 37.743 30.731 44.861c1.415.548 2.366 1.999 2.366 3.609v64.333c0 2.526-2.056 4.582-4.582 4.582h-70.418v-234.771h70.418c2.526 0 4.582 2.056 4.582 4.582z"/><path d="m105 284.991h225v30h-225z"/><path d="m105 344.991h225v30h-225z"/><path d="m105 404.991h225v30h-225z"/></g></svg>

                                <span class="text-secondary text_admin">Промо</span>


                            </div>

                            <div class="col" onclick="show_modal('menu_gamepay')">
                                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" style="height: 23px;width: 23px;" h xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                width="25px" height="25.001px" viewBox="0 0 25 25.001" style="enable-background:new 0 0 25 25.001;" xml:space="preserve">
                                <g>
                                    <path d="M24.38,10.175l-2.231-0.268c-0.228-0.851-0.562-1.655-0.992-2.401l1.387-1.763c0.212-0.271,0.188-0.69-0.057-0.934
                                    l-2.299-2.3c-0.242-0.243-0.662-0.269-0.934-0.057l-1.766,1.389c-0.743-0.43-1.547-0.764-2.396-0.99L14.825,0.62
                                    C14.784,0.279,14.469,0,14.125,0h-3.252c-0.344,0-0.659,0.279-0.699,0.62L9.906,2.851c-0.85,0.227-1.655,0.562-2.398,0.991
                                    L5.743,2.455c-0.27-0.212-0.69-0.187-0.933,0.056L2.51,4.812C2.268,5.054,2.243,5.474,2.456,5.746L3.842,7.51
                                    c-0.43,0.744-0.764,1.549-0.991,2.4l-2.23,0.267C0.28,10.217,0,10.532,0,10.877v3.252c0,0.344,0.279,0.657,0.621,0.699l2.231,0.268
                                    c0.228,0.848,0.561,1.652,0.991,2.396l-1.386,1.766c-0.211,0.271-0.187,0.69,0.057,0.934l2.296,2.301
                                    c0.243,0.242,0.663,0.269,0.933,0.057l1.766-1.39c0.744,0.43,1.548,0.765,2.398,0.991l0.268,2.23
                                    c0.041,0.342,0.355,0.62,0.699,0.62h3.252c0.345,0,0.659-0.278,0.699-0.62l0.268-2.23c0.851-0.228,1.655-0.562,2.398-0.991
                                    l1.766,1.387c0.271,0.212,0.69,0.187,0.933-0.056l2.299-2.301c0.244-0.242,0.269-0.662,0.056-0.935l-1.388-1.764
                                    c0.431-0.744,0.764-1.548,0.992-2.397l2.23-0.268C24.721,14.785,25,14.473,25,14.127v-3.252
                                    C25.001,10.529,24.723,10.216,24.38,10.175z M12.501,18.75c-3.452,0-6.25-2.798-6.25-6.25s2.798-6.25,6.25-6.25
                                    s6.25,2.798,6.25,6.25S15.954,18.75,12.501,18.75z"/>
                                </g>
                            </svg>

                            <span class="text-secondary text_admin">GamePay</span>


                        </div> 

                        <div class="col" onclick="show_modal('menu_settings')">
                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" style="height: 23px;width: 23px;" h xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                            width="25px" height="25.001px" viewBox="0 0 25 25.001" style="enable-background:new 0 0 25 25.001;" xml:space="preserve">
                            <g>
                                <path d="M24.38,10.175l-2.231-0.268c-0.228-0.851-0.562-1.655-0.992-2.401l1.387-1.763c0.212-0.271,0.188-0.69-0.057-0.934
                                l-2.299-2.3c-0.242-0.243-0.662-0.269-0.934-0.057l-1.766,1.389c-0.743-0.43-1.547-0.764-2.396-0.99L14.825,0.62
                                C14.784,0.279,14.469,0,14.125,0h-3.252c-0.344,0-0.659,0.279-0.699,0.62L9.906,2.851c-0.85,0.227-1.655,0.562-2.398,0.991
                                L5.743,2.455c-0.27-0.212-0.69-0.187-0.933,0.056L2.51,4.812C2.268,5.054,2.243,5.474,2.456,5.746L3.842,7.51
                                c-0.43,0.744-0.764,1.549-0.991,2.4l-2.23,0.267C0.28,10.217,0,10.532,0,10.877v3.252c0,0.344,0.279,0.657,0.621,0.699l2.231,0.268
                                c0.228,0.848,0.561,1.652,0.991,2.396l-1.386,1.766c-0.211,0.271-0.187,0.69,0.057,0.934l2.296,2.301
                                c0.243,0.242,0.663,0.269,0.933,0.057l1.766-1.39c0.744,0.43,1.548,0.765,2.398,0.991l0.268,2.23
                                c0.041,0.342,0.355,0.62,0.699,0.62h3.252c0.345,0,0.659-0.278,0.699-0.62l0.268-2.23c0.851-0.228,1.655-0.562,2.398-0.991
                                l1.766,1.387c0.271,0.212,0.69,0.187,0.933-0.056l2.299-2.301c0.244-0.242,0.269-0.662,0.056-0.935l-1.388-1.764
                                c0.431-0.744,0.764-1.548,0.992-2.397l2.23-0.268C24.721,14.785,25,14.473,25,14.127v-3.252
                                C25.001,10.529,24.723,10.216,24.38,10.175z M12.501,18.75c-3.452,0-6.25-2.798-6.25-6.25s2.798-6.25,6.25-6.25
                                s6.25,2.798,6.25,6.25S15.954,18.75,12.501,18.75z"/>
                            </g>
                        </svg>

                        <span class="text-secondary text_admin">Настройки</span>


                    </div>


                </div>
            </div>





        </div>
    </div>
</div>
</div>
<script type="text/javascript">
   



        function load(page, that, callback, silent) { 

       
        let _load = function() {
            $.get("/" + page + (page.includes('?') ? '&' : '?') + 'json', function(data) {

                $('#_ajax_content_').html(data);
                window.history.pushState({"html":data,"pageTitle":$(document).find("title").text()}, $(document).find("title").text(), "/"+page);
                if(callback){
                    callback()
                }
               

            }).fail(function(jqxhr, settings, exception) {
                $('.preloader').addClass("preloader-remove");  
                $('.loader').fadeOut('fast');
                notifaction("error", "Ошибка")      
            });
        };

        _load();

    }



</script>



<div id="_ajax_content_">{!! html_entity_decode($page) !!}</div>


<div class="flex">



</div>


<div class="d-mob fixed_mob">
    <div class="flex no_padding">
        <div class="menu_icon_bottom active">
            <svg width="24" height="23" viewBox="0 0 24 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M23.5033 11.3115L12.5988 0.251823C12.5203 0.171976 12.427 0.108629 12.3244 0.0654079C12.2217 0.0221864 12.1116 -6.10352e-05 12.0005 -6.10352e-05C11.8893 -6.10352e-05 11.7793 0.0221864 11.6766 0.0654079C11.574 0.108629 11.4807 0.171976 11.4022 0.251823L0.497704 11.3115C0.180021 11.6339 0 12.0719 0 12.5287C0 13.4772 0.759793 14.2484 1.69431 14.2484H2.84327V22.1401C2.84327 22.6157 3.22184 22.9999 3.69042 22.9999H10.3062V16.9811H13.2712V22.9999H20.3106C20.7792 22.9999 21.1577 22.6157 21.1577 22.1401V14.2484H22.3067C22.7567 14.2484 23.1883 14.0684 23.5059 13.7432C24.1651 13.0715 24.1651 11.9833 23.5033 11.3115Z" fill="#6360E9"/>
            </svg><br>
            <span class="text_bottom">Главная</span>
        </div>
        <div class="menu_icon_bottom">
           <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 18.9984V20.9999C0 22.6546 4.03125 23.9999 9 23.9999C13.9688 23.9999 18 22.6546 18 20.9999V18.9984C16.0641 20.3624 12.525 20.9999 9 20.9999C5.475 20.9999 1.93594 20.3624 0 18.9984ZM15 5.99994C19.9688 5.99994 24 4.65463 24 2.99994C24 1.34525 19.9688 -6.10352e-05 15 -6.10352e-05C10.0312 -6.10352e-05 6 1.34525 6 2.99994C6 4.65463 10.0312 5.99994 15 5.99994ZM0 14.0812V16.4999C0 18.1546 4.03125 19.4999 9 19.4999C13.9688 19.4999 18 18.1546 18 16.4999V14.0812C16.0641 15.6749 12.5203 16.4999 9 16.4999C5.47969 16.4999 1.93594 15.6749 0 14.0812ZM19.5 14.5968C22.1859 14.0765 24 13.1109 24 11.9999V9.99838C22.9125 10.7671 21.3141 11.2921 19.5 11.6156V14.5968ZM9 7.49994C4.03125 7.49994 0 9.17806 0 11.2499C0 13.3218 4.03125 14.9999 9 14.9999C13.9688 14.9999 18 13.3218 18 11.2499C18 9.17806 13.9688 7.49994 9 7.49994ZM19.2797 10.139C22.0922 9.63275 24 8.639 24 7.49994V5.49838C22.3359 6.67494 19.4766 7.30775 16.4672 7.45775C17.85 8.12806 18.8672 9.02806 19.2797 10.139Z" fill="#67749A"/>
        </svg>

        <br>
        <span class="text_bottom">Ставки</span>
    </div>
    <div class="menu_icon_bottom chat_btn">
        <svg width="28" height="22" viewBox="0 0 28 22" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M16.5227 14.9287C18.2151 14.2152 19.5511 13.244 20.5301 12.0148C21.509 10.7858 21.9985 9.44739 21.9985 7.99956C21.9985 6.55167 21.509 5.21317 20.5297 3.98412C19.5508 2.75508 18.215 1.78378 16.5224 1.07012C14.8298 0.356576 12.9888 -6.10352e-05 10.9992 -6.10352e-05C9.00977 -6.10352e-05 7.1688 0.356794 5.47607 1.07012C3.78351 1.78372 2.44764 2.75502 1.46868 3.98412C0.489616 5.21339 0 6.55167 0 7.99961C0 9.239 0.370318 10.4061 1.1098 11.4998C1.84923 12.5932 2.86486 13.5152 4.15635 14.265C4.05226 14.5152 3.94549 14.7441 3.8361 14.9527C3.72665 15.161 3.59657 15.3613 3.44543 15.5542C3.29439 15.7471 3.17733 15.898 3.09393 16.007C3.01059 16.1163 2.8752 16.2703 2.68761 16.4679C2.50007 16.6658 2.38022 16.796 2.32823 16.8583C2.32823 16.8479 2.30738 16.8715 2.26568 16.9288C2.22393 16.9861 2.20051 17.012 2.19536 17.0071C2.19011 17.0014 2.16926 17.0275 2.13281 17.0848C2.09637 17.1421 2.07809 17.1708 2.07809 17.1708L2.03896 17.2486C2.02353 17.2801 2.01291 17.3109 2.00777 17.3423C2.00252 17.3733 1.99989 17.4074 1.99989 17.4438C1.99989 17.4801 2.00503 17.5138 2.01565 17.5452C2.0365 17.6805 2.09637 17.7896 2.19531 17.8734C2.2942 17.9565 2.40085 17.9981 2.51555 17.9981H2.56245C3.08315 17.9252 3.53112 17.8419 3.90604 17.748C5.51011 17.3316 6.95805 16.6647 8.24959 15.7482C9.18696 15.9148 10.1036 15.9981 10.9993 15.9981C12.9889 15.9988 14.8301 15.6423 16.5227 14.9287Z" fill="#67749A"/>
            <path d="M26.8889 15.5067C27.6287 14.4183 27.9983 13.2495 27.9983 11.9994C27.9983 10.7181 27.6072 9.51954 26.8263 8.40514C26.045 7.29085 24.9824 6.36366 23.6389 5.62411C23.8783 6.40525 23.9981 7.19683 23.9981 7.99903C23.9981 9.39466 23.6496 10.7175 22.9513 11.9676C22.2534 13.2172 21.2534 14.3212 19.9515 15.2797C18.7432 16.1546 17.3683 16.8262 15.8266 17.2951C14.2853 17.7637 12.6759 17.9982 10.9989 17.9982C10.6866 17.9982 10.2282 17.9776 9.62415 17.936C11.7177 19.3106 14.1759 19.9983 16.9985 19.9983C17.8944 19.9983 18.8109 19.9148 19.7485 19.7481C21.04 20.665 22.488 21.3313 24.0919 21.7482C24.4669 21.8422 24.9148 21.9254 25.4356 21.9982C25.5606 22.0087 25.6754 21.9722 25.7794 21.8888C25.8836 21.8055 25.9514 21.6913 25.9825 21.5456C25.9776 21.483 25.9825 21.4487 25.9982 21.4437C26.0136 21.4388 26.0109 21.4048 25.9903 21.3424C25.9697 21.2798 25.9592 21.2485 25.9592 21.2485L25.9203 21.1706C25.9094 21.15 25.8918 21.1212 25.8656 21.0849C25.8395 21.0487 25.8188 21.0223 25.803 21.0068C25.7877 20.9912 25.7645 20.965 25.733 20.9288C25.7019 20.8927 25.6809 20.8691 25.6704 20.8586C25.6184 20.7961 25.4987 20.666 25.3112 20.468C25.1236 20.2702 24.9884 20.1166 24.9051 20.0073C24.8217 19.8979 24.7045 19.747 24.5535 19.5541C24.4026 19.3615 24.2722 19.161 24.1628 18.9526C24.0535 18.7443 23.9467 18.5151 23.8426 18.2653C25.1342 17.5147 26.1495 16.5955 26.8889 15.5067Z" fill="#67749A"/>
        </svg>

        <br>
        <span class="text_bottom">Чат</span>
    </div>
    <div class="menu_icon_bottom">
        <svg width="24" height="23" viewBox="0 0 24 23" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M11.9999 10.0101C14.7642 10.0101 17.005 7.76924 17.005 5.00501C17.005 2.24079 14.7642 -6.10352e-05 11.9999 -6.10352e-05C9.23572 -6.10352e-05 6.99487 2.24079 6.99487 5.00501C6.99487 7.76924 9.23572 10.0101 11.9999 10.0101Z" fill="#67749A"/>
            <path d="M18.9949 22.0101C21.7591 22.0101 24 19.7692 24 17.005C24 14.2408 21.7591 11.9999 18.9949 11.9999C16.2307 11.9999 13.9898 14.2408 13.9898 17.005C13.9898 19.7692 16.2307 22.0101 18.9949 22.0101Z" fill="#67749A"/>
            <path d="M5.00507 22.0101C7.7693 22.0101 10.0101 19.7692 10.0101 17.005C10.0101 14.2408 7.7693 11.9999 5.00507 11.9999C2.24085 11.9999 0 14.2408 0 17.005C0 19.7692 2.24085 22.0101 5.00507 22.0101Z" fill="#67749A"/>
        </svg>

        <br>
        <span class="text_bottom">Ещё</span>
    </div>
</div>
</div>



<div class="modal_body" style="display:none">
    <div class="modal_panel modal_menu_user" style="display:none;position:relative;">
        <div class="padding-30">
            <div class="flex no_padding wrap">
                <div class="col mb-10">
                    <button class="btn-dep w-100" onclick="load('admin/users');close_modal()">Все юзеры</button>
                </div>
                <div class="col mb-10">
                    <button class="btn-dep w-100" onclick="load('admin/top_refs_profit');close_modal()">Топ рефоводов по заработку</button>
                </div>
                <div class="col mb-10">
                    <button class="btn-dep w-100" onclick="load('admin/top_refs_ref');close_modal()">Топ рефоводов по рефералам</button>
                </div>

                <div class="col">
                    <button class="btn-auth w-100" onclick="close_modal()">Закрыть</button>
                </div>
            </div> 
        </div>
    </div>

    <div class="modal_panel modal_menu_settings" style="display:none;position:relative;">
        <div class="padding-30">
            <div class="flex no_padding wrap">
                <div class="col-lg-5 mb-10">
                    <button class="btn-dep w-100" onclick="load('admin/settings_site');close_modal()">Настройки сайта</button>
                </div>
                <div class="col-lg-5 mb-10">
                    <button class="btn-dep w-100" onclick="load('admin/settings_withdraw');close_modal()">Настройки вывода</button>
                </div>
                <div class="col mb-10">
                    <button class="btn-dep w-100" onclick="load('admin/settings_deps');close_modal()">Настройки пополнения</button>
                </div>
                <div class="col-lg-5 mb-10">
                    <button class="btn-dep w-100" onclick="load('admin/settings_bonus');close_modal()">Настройки бонуса</button>
                </div>

                <div class="col-lg-5 mb-10">
                    <button class="btn-dep w-100" onclick="load('admin/settings_anti');close_modal()">Настройки антиминуса</button>
                </div>

                <div class="col mb-10">
                    <button class="btn-dep w-100" onclick="load('admin/settings_random');close_modal()">Настройки Random.Org</button>
                </div>

                <div class="col mb-10">
                    <button class="btn-dep w-100" onclick="load('admin/settings_partner');close_modal()">Настройки сотрудничества</button>
                </div>

                <div class="col mb-10">
                    <button class="btn-dep w-100" onclick="load('admin/settings_status');close_modal()">Настройки привилегий</button>
                </div>

                 <div class="col mb-10">
                    <button class="btn-dep w-100" onclick="load('admin/settings_repost');close_modal()">Настройки репоста</button>
                </div>

                <div class="col">
                    <button class="btn-auth w-100" onclick="close_modal()">Закрыть</button>
                </div>
            </div> 
        </div>
    </div>


    <div class="modal_panel modal_menu_promo" style="display:none;position:relative;">
        <div class="padding-30">
            <div class="flex no_padding wrap">
                <div class="col mb-10">
                    <button class="btn-dep w-100" onclick="load('admin/promo');close_modal()">Промокоды</button>
                </div>
                <div class="col mb-10">
                    <button class="btn-dep w-100" onclick="load('admin/deppromo');close_modal()">Промокоды к депу</button>
                </div>
                <div class="col mb-10">
                    <button class="btn-dep w-100" onclick="load('admin/historypromo');close_modal()">Последние активаций</button>
                </div>

                <div class="col">
                    <button class="btn-auth w-100" onclick="close_modal()">Закрыть</button>
                </div>
            </div> 
        </div>
    </div>

     <div class="modal_panel modal_menu_gamepay" style="display:none;position:relative;">
        <div class="padding-30">
            <div class="flex no_padding wrap">
                <div class="col mb-10">
                    <button class="btn-dep w-100" onclick="load('admin/gamepay_wallets');close_modal()">Кошельки</button>
                </div>
                <div class="col mb-10">
                    <button class="btn-dep w-100" onclick="load('admin/gamepay_addwallets');close_modal()">Добавление кошельков</button>
                </div>

                <div class="col mb-10">
                    <button class="btn-dep w-100" onclick="load('admin/gamepay_merchant');close_modal()">Настройка мерчанта</button>
                </div>

                <div class="col">
                    <button class="btn-auth w-100" onclick="close_modal()">Закрыть</button>
                </div>
            </div> 
        </div>
    </div>

    <div class="modal_panel modal_withdraw_menu" style="display:none;position:relative;">
        <div class="padding-30">
            <input type="hidden" id="id_withdraw" name="">
            <div class="flex no_padding wrap">
                <div class="col-lg-5 mb-10">
                    <button class="btn-dep w-100 " onclick="disable(this);updateWithdraw(1, this)">Отправить</button>
                </div>
                <div class="col-lg-5 mb-10">
                    <button class="btn-dep w-100 " onclick="disable(this);updateWithdraw(4, this)">Через пиастрикс</button>
                </div>

                 <div class="col-lg-5 mb-10">
                    <button class="btn-dep w-100 " onclick="disable(this);updateWithdraw(5, this)">Через FKWallet</button>
                </div>

                <div class="col-lg-5 mb-10">
                    <button class="btn-dep w-100" onclick="disable(this);updateWithdraw(3, this)">Обработка</button>
                </div>
                <div class="col-lg-5 mb-10">
                    <button class="btn-dep w-100" onclick="disable(this);updateWithdraw(2, this)">Отменить</button>
                </div>
                

                <div class="col">
                    <button class="btn-auth w-100" onclick="close_modal()">Закрыть</button>
                </div>
            </div> 
        </div>
    </div>

    <div class="modal_panel modal_promo_menu" style="display:none;position:relative;display: block;">
        <div class="padding-30">
            <input type="hidden" id="id_promo" name="">
            <div class="flex no_padding wrap">
                <div class="col-lg-5 mb-10">
                    <button class="btn-dep w-100 " onclick="disable(this);deletePromo(this)">Удалить</button>
                </div>
                <div class="col-lg-5 mb-10">
                    <button class="btn-dep w-100" onclick="showActive('promo')">Активации</button>
                </div>
                

                <div class="col ">
                    <button class="btn-auth w-100" onclick="close_modal()">Закрыть</button>
                </div>
            </div> 
        </div>
    </div>

    <div class="modal_panel modal_deppromo_menu" style="display:none;position:relative;display: block;">
        <div class="padding-30">
            <input type="hidden" id="id_deppromo" name="">
            <div class="flex no_padding wrap">
                <div class="col-lg-5 mb-10">
                    <button class="btn-dep w-100 " onclick="disable(this);deleteDepPromo(this)">Удалить</button>
                </div>
                <div class="col-lg-5 mb-10">
                    <button class="btn-dep w-100" onclick="showActive('deppromo')">Активации</button>
                </div>
                

                <div class="col ">
                    <button class="btn-auth w-100" onclick="close_modal()">Закрыть</button>
                </div>
            </div> 
        </div>
    </div>

    <div class="modal_panel modal_create_promo" style="display:none;position:relative;display: block;">
        <div class="padding-30" id="create_promo" style="">

            <div>
             <label>Название промо</label>
             <div class="flex no_padding wrap">
                <div style="position:relative;margin-top: 10px;" class="col">
                    <input type="" class="secodary_input" id="name_promo" name="">

                </div>

            </div>
        </div>


        <div style="margin-top:20px">
         <label>Сумма промо</label>
         <div class="flex no_padding wrap">
            <div style="position:relative;margin-top: 10px;" class="col">
                <input type="" class="secodary_input" id="sum_promo" name="">
            </div>

        </div>
    </div>


    <div style="margin-top:20px">
     <label>Кол-во активаций</label>
     <div class="flex no_padding wrap">
        <div style="position:relative;margin-top: 10px;" class="col">
            <input type="" class="secodary_input" id="active_promo" name="">

        </div>

    </div>
</div>

<div style="margin-top:20px">
 <label>Начало</label>
 <div class="flex no_padding wrap">
    <div style="position:relative;margin-top: 10px;" class="col">
        <input type="datetime-local" id="start_time_promo" class="secodary_input" name="">

    </div>

</div>
</div>

<div style="margin-top:20px">
 <label>Конец</label>
 <div class="flex no_padding wrap">
    <div style="position:relative;margin-top: 10px;" class="col">
        <input type="datetime-local" id="end_time_promo" class="secodary_input" name="">

    </div>

</div>
</div>

<div class="flex no_padding wrap">
    <div class="col-5"><button class="btn_bet_dice" style="width:100%;margin-top:25px;" onclick="createPromo()">Создать</button></div>
    <div class="col-5"><button class="btn-dep" style="width: 100%;margin-top: 25px;" onclick="close_modal()">Закрыть</button></div>
</div>


</div>
</div>

<div class="modal_panel modal_create_deppromo" style="display:none;position:relative;display: block;">
    <div class="padding-30" id="create_promo" style="">

        <div>
         <label>Название промо</label>
         <div class="flex no_padding wrap">
            <div style="position:relative;margin-top: 10px;" class="col">
                <input type="" class="secodary_input" id="name_deppromo" name="">

            </div>

        </div>
    </div>


    <div style="margin-top:20px">
     <label>% промо</label>
     <div class="flex no_padding wrap">
        <div style="position:relative;margin-top: 10px;" class="col">
            <input type="" class="secodary_input" id="sum_deppromo" name="">
        </div>

    </div>
</div>


<div style="margin-top:20px">
 <label>Кол-во активаций</label>
 <div class="flex no_padding wrap">
    <div style="position:relative;margin-top: 10px;" class="col">
        <input type="" class="secodary_input" id="active_deppromo" name="">

    </div>

</div>
</div>

<div style="margin-top:20px">
 <label>Начало</label>
 <div class="flex no_padding wrap">
    <div style="position:relative;margin-top: 10px;" class="col">
        <input type="datetime-local" id="start_time_deppromo" class="secodary_input" name="">

    </div>

</div>
</div>

<div style="margin-top:20px">
 <label>Конец</label>
 <div class="flex no_padding wrap">
    <div style="position:relative;margin-top: 10px;" class="col">
        <input type="datetime-local" id="end_time_deppromo" class="secodary_input" name="">

    </div>

</div>
</div>

<div class="flex no_padding wrap">
    <div class="col-5"><button class="btn_bet_dice" style="width:100%;margin-top:25px;" onclick="createDepPromo()">Создать</button></div>
    <div class="col-5"><button class="btn-dep" style="width: 100%;margin-top: 25px;" onclick="close_modal()">Закрыть</button></div>
</div>


</div>
</div>

<div class="modal_panel modal_ban_user" style="display:none;position:relative;">
 <div class="avatar_transfer"><img src="" id="ban_user_ava"></div>
 <input type="hidden" id="ban_user_id" name="">
 <div class="padding-30">
    <div class="flex no_padding wrap">
        <div class="col mm mb-10">
            <label>Действие</label>
            <select class="w-100 mt-10 secondary_select" id="ban_type" onchange="banTypeChange()">
                <option value="1">Забанить</option>
                <option value="0">Разбанить</option>
            </select>
        </div>
        <div class="col mb-10" id="ban_user">
            <label class="">Причина</label>
            <input type="" class="secodary_input mt-10" id="ban_why" name="">
        </div>
        <div class="col mb-10">
            <button class="btn-dep w-100" onclick="saveUserBan()">Сохранить</button>
        </div>

        <div class="col">
            <button class="btn-auth w-100" onclick="close_modal()">Закрыть</button>
        </div>
    </div> 
</div>
</div>

</div>

<script type="text/javascript" src="../js/script.js?v=@php echo time(); @endphp"></script>
<script type="text/javascript" src="../js/admin_script_20J0.js?v=@php echo time(); @endphp"></script>

</body>
</html> 