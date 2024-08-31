<div class="wrapper">
	<div style="margin-top: 20px;" class="bonus">
		<div class="bonus__top">
			<div class="bonus__items">
				<div class="bonus__item">
					<div class="bonus__item-title"><span>Вконтакте</span></div>
					<div class="bonus__content d-flex justify-space-between align-center">
						<div class="bx-input__input d-flex align-center justify-space-between">
							<label class="d-flex align-center">Размер:</label>
							<div class="d-flex align-center">
								<span class="bx-input__text">{{\App\Setting::first()->bonus_group}}</span>
								<svg class="icon money"><use xlink:href="images/symbols.svg#coins"></use></svg>
							</div>
						</div>
						<div class="bonus__buttons d-flex align-center">
							<a href="#" onclick="disable(this);getBonusVk(this)" class="btn btn--blue is-ripples flare d-flex align-center"><span>Получить</span></a>
							<a href="#"  onclick="open_link('https://vk.com/public{{\App\Setting::first()->group_id}}')" class="btn is-ripples flare d-flex align-center">ВК</a>
						</div>
					</div>
				</div>
				<div class="bonus__item">
					<div class="bonus__item-title"><span>Телеграм</span></div>
					<div class="bonus__content d-flex justify-space-between align-center">
						<div class="bx-input__input d-flex align-center justify-space-between">
							<label class="d-flex align-center">Размер:</label>
							<div class="d-flex align-center">
								<span class="bx-input__text">{{\App\Setting::first()->bonus_group}}</span>
								<svg class="icon money"><use xlink:href="images/symbols.svg#coins"></use></svg>
							</div>
						</div>
						<div class="bonus__buttons d-flex align-center">
							<a href="#" onclick="disable(this);getBonusTg(this)" class="btn btn--blue is-ripples flare d-flex align-center"><span>Получить</span></a>
							<a href="#" onclick="open_link('https://t.me/{{\App\Setting::first()->tg_id}}')" class="btn is-ripples flare d-flex align-center">TG</a>
						</div>
					</div>
				</div>
				<div class="bonus__item d-flex justify-center bonus__item--block bonus__item--daily" style="">
					<div class="bonus__wheel">
						<div class="bonus__wheel-cursor"></div>
						<div class="bonus__wheel-go" onclick="disable(this);getBonus(this)" id="bonusGo">
							<span>Крутить</span>
						</div>
						<div class="bonus__wheel-image">
							<div class="bonus__wheel-borders d-flex align-center justify-center">
								<img class="bonus__rotate-defs" src="images/bonus/bonus-wheel--borders.svg">
								<img class="bonus__rotate" src="images/bonus/bonus-wheel.svg" style="transition: 30s ease;" id="bonusWheel">
							</div>
						</div>
					</div>
				</div>
				<div class="bonus__item bonus__item--block bonus__item--levels" style="display: none;">
					<div class="bonus__item-title"><span>Уровни</span></div>
					<div class="bonus__content d-flex align-center justify-space-between flex-wrap">
						<div class="bonus__levels-info d-flex align-center flex-wrap">
							<div class="bonus__levels-image"></div>
							<div class="bonus__levels-text d-flex flex-column">
								<span>Повышайте свой ранг - получайте призы!</span>
								<p>Опыт начисляется за пополнения.</p>
							</div>
						</div>
						<div class="bonus__levels-items" id="all_bonusStatus_table">
							<div class="bonus__levels-item bonus__levels-item--1 d-flex flex-column align-center justify-center">
								<h4>Уровень 1</h4>
								<span class="user-status new" style="margin-bottom: 15px;">Новичок</span>
								<a href="#" class="btn is-ripples flare btn--orange d-flex align-center"><span>От 1 до 3</span></a>
							</div>
						</div>
					</div>
				</div>
				<div class="bonus__item bonus__item--block bonus__item--reposts">
					<div class="bonus__item-title"><span>Бонус за репосты</span></div>
					<div class="bonus__content d-flex justify-space-between align-center">
						<div class="bx-input__input d-flex align-center justify-space-between"  style="width: 84%;">
							<label class="d-flex align-center">Бонусный баланс:</label>
							<div class="d-flex align-center">
								<span class="bx-input__text">{{\Auth::user()->balance_repost ?? 0}}</span>
								<svg class="icon money"><use xlink:href="images/symbols.svg#coins"></use></svg>
							</div>
						</div>
						<div class="bonus__buttons d-flex align-center">
							<a href="#" onclick="disable(this);changeRepostBalance(this)" class="btn btn--blue is-ripples flare d-flex align-center"><span>Обменять</span></a>
						</div>
					</div>
					<div class="bonus__reposts-items" id="all_reposts">

						
					</div>
				</div>
			</div>
		</div>

		<div class="bonus__bottom">
			<div class="bonus__hits d-flex flex-column">
				<a href="#" rel="popup" data-popup="popup--hits" class="help d-flex align-center">
					<svg class="icon"><use xlink:href="images/symbols.svg#faq"></use></svg>
					<span>Что это такое?</span>
				</a>
				<div class="bonus__hits-title"><span>Достижения</span></div>
				<div class="bonus__hits-content">
					<div class="bonus__hits-items" id="all_status">				
					</div>
				</div>
			</div>
		</div>


		<script type="text/javascript">
			var MY_REPOSTS = {{\Auth::user()->reposts ?? 0}}

			function getRepost() {
				$.post('/repost/all',{_token: csrf_token}).then(e=>{
					$('#all_reposts').html('')
					e.repost.forEach((e)=>{
						percent = 100 * MY_REPOSTS / e.repost_to
						if(percent > 100) { percent = 100 }
							$('#all_reposts').append('<div class="bonus__reposts-item d-flex flex-column" >\
							<span class="bonus__reposts-level">'+e.id+' уровень</span>\
							<div class="d-flex align-center justify-space-between">\
								<p class="bonus__reposts-count">'+MY_REPOSTS+' / '+e.repost_to+'</p>\
								<div class="bonus__reposts-count--value">'+e.bonus+'</div>\
							</div>\
							<div class="bonus__reposts-progress">\
								<div class="bonus__reposts-progress--width" style="width: '+percent+'%;"></div>\
							</div>\
						</div>')


					});
				});
			}
			getRepost()


			var MY_SUM_DEP = {{\Auth::user()->deps ?? 0}}
			var USER_STATUS = {{\Auth::user()->status ?? 0}}
			function getStatus() {
				$.post('/status/all',{_token: csrf_token}).then(e=>{
					$('#all_status').html('')
					$('#all_status_table').html('')
					e.status.forEach((e)=>{
						percent = 100 * MY_SUM_DEP / e.deposit
						check = ''
						if(percent > 100) { percent = 100;check = 'active' }

					

						if(USER_STATUS == e.id){
							textBonus = 'От '+e.minSumBonus+' до '+e.maxSumBonus
						}else{
							textBonus = ''+MY_SUM_DEP+' / <b>'+e.deposit+'</b>'
						}
							$('#all_status').append('<div class="bonus__hits-item bonus__hits-item--'+check+' d-flex flex-column">\
							<b>'+MY_SUM_DEP+' / '+e.deposit+'</b>\
							<span>'+e.name+'</span>\
							<div class="bonus__hits-progress-bar">\
								<div class="bonus__hits-progress" style="width: '+percent+'%;"></div>\
							</div>\
						</div>')

						$('#all_status_table').append('<tr>\
                            <td>\
                                <span class="user-status '+e.class+'">'+e.name+'</span>\
                            </td>\
                            <td>\
                                <span>'+e.deposit+'</span>\
                            </td>\
                            <td>\
                                <span>'+e.bonus+'</span>\
                            </td>\
                        </tr>')

                        $('#all_bonusStatus_table').append('<div class="bonus__levels-item bonus__levels-item--2 d-flex flex-column align-center justify-center">\
								<h4>Уровень '+(e.id + 1)+'</h4>\
								<span class="user-status '+e.class+'" style="margin-bottom: 15px;">'+e.name+'</span>\
								<a href="#" class="btn disabled is-ripples flare btn--purple d-flex align-center"><span>'+textBonus+'</b></span></a>\
							</div>')
					});
				});
			}
			getStatus()
		</script>
	</div>
</div>