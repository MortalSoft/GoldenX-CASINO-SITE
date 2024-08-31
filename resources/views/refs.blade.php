@auth
<div class="wrapper">
                <div style="margin-top: 20px;" class="bonus refferal">
                    <div class="bonus__top">
                        <div class="bonus__items">
                            <div class="bonus__item bonus__item--block bonus__item--reposts">
                                <div class="bonus__item-title"><span>Партнерка</span></div>
                                <div class="bonus__content d-flex justify-space-between align-center">
                                    <div class="bx-input__input d-flex align-center justify-space-between"  style="width: 81%;">
                                        <label class="d-flex align-center">Реф. ссылка:</label>
                                        <div class="d-flex align-center">
                                            <span class="bx-input__text" onclick="copy('ref_link')" id="ref_link" >https://golden-x.vip/go/{{\Auth::user()->id}}</span>
                                        </div>
                                    </div>
                                    <div class="bonus__buttons d-flex align-center">
                                        <a href="#" onclick="copy('ref_link')" class="btn btnCopy btn--blue is-ripples flare d-flex align-center"><span>Скопировать</span></a>
                                    </div>
                                </div>
                                <div class="refferal__stats d-flex align-center justify-space-between">
                                    <div class="refferal__left d-flex align-center">
                                        <div class="refferal__stat d-flex flex-column">
                                            <span class="d-flex align-center">{{\Auth::user()->refs}} <svg class="icon"><use xlink:href="images/symbols.svg#users"></use></svg></span>
                                            <p>рефералов</p>
                                        </div>
                                        <div class="refferal__stat d-flex flex-column">
                                            <span class="d-flex align-center">{{\Auth::user()->profit}} <svg class="icon"><use xlink:href="images/symbols.svg#coins"></use></svg></span>
                                            <p>заработано</p>
                                        </div>
                                        <div class="refferal__stat d-flex flex-column">
                                            <span class="d-flex align-center"><b id="refBalance">{{\Auth::user()->balance_ref}}</b> <svg class="icon"><use xlink:href="images/symbols.svg#coins"></use></svg></span>
                                            <p>доступно к снятию</p>
                                        </div>
                                    </div>
                                    <a href="#" onclick="disable(this);changeRefBalance(this)" class="btn btn--red d-flex align-center is-ripples flare"><span>Снять</span></a>
                                </div>
                            </div>
                            <div class="bonus__item d-flex justify-center bonus__item--block bonus__item--daily">
                                <div class="bonus__wheel">
                                    <div class="bonus__wheel-cursor"></div>
                                    <div class="bonus__wheel-go" onclick="disable(this);getBonusRef(this)" id="bonusGo">
                                        <div><span id="refs">{{\Auth::user()->bonus_refs}}</span> из 10</div>
                                    </div>
                                    <div class="bonus__wheel-image">
                                         <div class="bonus__wheel-borders d-flex align-center justify-center">
                                            <img class="bonus__rotate-defs" src="images/bonus/bonus-wheel--borders.svg">
                                            <img class="bonus__rotate" src="images/bonus/bonus-wheel.svg" style="transition: 30s ease;" id="bonusWheel">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script type="text/javascript">
            	function copy(id) {
			    var $temp = $("<input>");
			    $("body").append($temp);
			    $temp.val($('#'+id+'').text()).select();
			    document.execCommand("copy");
			    $temp.remove();

			    $('.btnCopy').text('Cкопировано!');
			};
            </script>

	@else
	<script type="text/javascript">location.href='/';</script>
	@endauth