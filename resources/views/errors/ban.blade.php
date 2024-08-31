  <!DOCTYPE html>
<html>
<head> 
    <meta charset="utf-8">
    <title>GOLDEN-X</title>
    <meta name="viewport" content="width=device-width, user-scalable=yes">
    <link rel="stylesheet" type="text/css" href="/css/style.css?v=@php echo time(); @endphp">
    <link rel="stylesheet" type="text/css" href="/css/main.css?v=@php echo time(); @endphp">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800;900&Montserrat&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@800&display=swap" rel="stylesheet">

     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
     
</head>

<body class="theme--dark">
 <div class="body_404">
 	<div class="panel_404">
 		<img src="/images/logotype-dark.png" class="logo" style="width:200px;">
 		<div class="text_1_404">Ваш аккаунт заблокирован!<br><br>
            Если вы считаете что это произошло по ошибке, <br>пожалуйста обратитесь в службу поддержки.<br><br>
 		<div class="text_1_404">Ваш айди: <span>{{\Auth::user()->id}}</span></div></div>
	<a href="https://t.me/goldenxs" target="_blank"  class="btn_bet_dice">Обратиться в поддержку</a>
 	</div>
 	
 </div>
</body>

 <style type="text/css">
 	.text_1_404 span{
 		/*font-size: 13px;*/
 		color: #387be5;
 	}
 </style>

 </html>