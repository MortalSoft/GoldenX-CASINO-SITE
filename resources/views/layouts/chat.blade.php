@php
$setting = \App\Setting::first();
@endphp
<div class="chat">
    <div class="chat__heading d-flex align-center justify-space-between">
        <div class="chat__online d-flex align-center">
            <svg class="icon"><use xlink:href="/images/symbols.svg#users"></use></svg>
            <div>
                <span>Онлайн</span>
                <p class="online"></p>
            </div>
        </div>
        <div class="chat__buttons d-flex align-center justify-end">
            <a  class="d-flex align-center justify-center">
                <svg class="icon"><use xlink:href="/images/symbols.svg#rules"></use></svg>
            </a>
            <a  class="close-chat d-flex align-center justify-center">
                <svg class="icon"><use xlink:href="/images/symbols.svg#close"></use></svg>
            </a>
        </div>


    </div>

    <div class="chat__promocode">
                <div class="chat__promocode-inner" @if($setting->theme == 0)style="padding-left: 30px;"@endif>
                    @if($setting->theme == 1)
                    <img class="chat__promocode-img" src="images/snow/promocode.png">
                    @endif
                    <h4>Новый промокод</h4>
                    <div class="chat__promocode-timer Chat d-flex align-center">
                        <span class="chat__promocode-timer--span">0</span>
                        <span class="chat__promocode-timer--span">1</span>
                        <span>:</span>
                        <span class="chat__promocode-timer--span">3</span>
                        <span class="chat__promocode-timer--span">4</span>
                        <span>:</span>
                        <span class="chat__promocode-timer--span">2</span>
                        <span class="chat__promocode-timer--span">2</span>
                    </div>
                </div>
            </div>
 
    <!--         <div class="chat__giveaway">
            <div class="chat__giveaway-inner">
                <h5>Промокод каждый час</h5>
                <div class="chat__giveaway-timer d-flex align-center">
                    <span class="chat__giveaway-timer--span">0</span><span class="chat__giveaway-timer--span">0</span><span>:</span><span class="chat__giveaway-timer--span">0</span><span class="chat__giveaway-timer--span">0</span><span>:</span><span class="chat__giveaway-timer--span">0</span><span class="chat__giveaway-timer--span">0</span>
                </div>
            </div>
        </div>
    
    <div class="chat__header-info d-flex align-center justify-space-between">
        <div class="chat__giveaway">
            <div class="chat__giveaway-inner">
                <h5>Промокод каждый час</h5>
                <div class="chat__giveaway-timer d-flex align-center">
                    <span class="chat__giveaway-timer--span">0</span><span class="chat__giveaway-timer--span">0</span><span>:</span><span class="chat__giveaway-timer--span">0</span><span class="chat__giveaway-timer--span">0</span><span>:</span><span class="chat__giveaway-timer--span">0</span><span class="chat__giveaway-timer--span">0</span>
                </div>
            </div>
        </div>
    </div>
    -->
    <div class="chat__messages" ss-container>                
    </div>
    <div class="chat__bottom">
        <div class="chat__send d-flex align-center justify-space-between">
            <div class="chat__input">
                <input type="text" onkeydown="if(event.keyCode==13){ disable(this);sendMess(this); }" id="messageChat" placeholder="Введите ваше сообщение...">
            </div>
            <div class="chat__buttons d-flex align-center">
                <a onclick="disable(this);sendMess(this)"  class="d-flex align-center justify-center">
                    <svg class="icon"><use xlink:href="/images/symbols.svg#send"></use></svg>
                </a>
                <a  class="d-flex align-center justify-center" id="btnStickers">
                    <svg class="icon"><use xlink:href="/images/symbols.svg#stickers"></use></svg>
                </a>
                <a  class="d-flex align-center justify-center" id="btnSmiles">
                    <svg class="icon"><use xlink:href="/images/symbols.svg#smiles"></use></svg>
                </a>
            </div>
        </div>
        <div class="chat__smiles chat__smiles--smiles" ss-container>
            <div class="chat__smiles-scroll">
                @for ($i = 1; $i <= 59; $i++)
                <div onclick="AddSmile({{$i}})" class="chat__smiles-item d-flex align-center justify-center"><img src="images/chat/smiles/{{$i}}.png"></div>
                @endfor


            </div>
        </div>
        <div class="chat__smiles chat__smiles--stickers" ss-container>
            <div class="chat__smiles-scroll">
               @for ($i = 1; $i <= 21; $i++)
               <div onclick="disable(this);sendSticker({{$i}}, this)" class="chat__smiles-item d-flex align-center justify-center"><img src="images/chat/stickers/{{$i}}.jpg"></div>
               @endfor

           </div>
       </div>
   </div>
</div> 