@auth
<div class="content" >
	<div class="flex ">
		<div class="col-menu-lg">

		</div>
		<div class="col" style="max-width: 700px;margin: 0px auto;position:relative;">
			<div class="flex no_padding wrap">
				<div class="col-lg-5 bonus">
					<div class="content-area-bonus" >
						<center>
							<div class="block_bonus">
								<img src="img/bonus_1.png" class="images_bonus" style="width: calc(100% - 40px);">
								<img src="img/bonus_2.png" class="images_bonus" style="width: 100%;">
								<img src="img/bonus_wheel.png?v=1" class="images_bonus" style="width: 100%;">
								<img src="img/cursor_bonus.png" class="images_bonus cursor_bonus" style="width: calc(100% + 22px);">
								<img src="img/center_bonus.png" class="images_bonus" style="width: auto;top:55%">
							</div>

							<button class="btn_bonus_start" onclick="disable(this);getBonus(this)">Крутить <svg width="28" height="37" viewBox="0 0 28 37" fill="none" xmlns="http://www.w3.org/2000/svg" class="dop_btn">
								<g filter="url(#filter0_f)">
									<path d="M2 16.2488V17.75C2 18.991 5.02344 20 8.75 20C12.4766 20 15.5 18.991 15.5 17.75V16.2488C14.048 17.2719 11.3938 17.75 8.75 17.75C6.10625 17.75 3.45195 17.2719 2 16.2488ZM13.25 6.5C16.9766 6.5 20 5.49102 20 4.25C20 3.00898 16.9766 2 13.25 2C9.52344 2 6.5 3.00898 6.5 4.25C6.5 5.49102 9.52344 6.5 13.25 6.5ZM2 12.5609V14.375C2 15.616 5.02344 16.625 8.75 16.625C12.4766 16.625 15.5 15.616 15.5 14.375V12.5609C14.048 13.7562 11.3902 14.375 8.75 14.375C6.10977 14.375 3.45195 13.7562 2 12.5609ZM16.625 12.9477C18.6395 12.5574 20 11.8332 20 11V9.49883C19.1844 10.0754 17.9855 10.4691 16.625 10.7117V12.9477ZM8.75 7.625C5.02344 7.625 2 8.88359 2 10.4375C2 11.9914 5.02344 13.25 8.75 13.25C12.4766 13.25 15.5 11.9914 15.5 10.4375C15.5 8.88359 12.4766 7.625 8.75 7.625ZM16.4598 9.6043C18.5691 9.22461 20 8.4793 20 7.625V6.12383C18.752 7.00625 16.6074 7.48086 14.3504 7.59336C15.3875 8.09609 16.1504 8.77109 16.4598 9.6043Z" fill="#FFD234" fill-opacity="0.41"/>
								</g>
								<path d="M2 31.5816V33.75C2 35.5426 6.36719 37 11.75 37C17.1328 37 21.5 35.5426 21.5 33.75V31.5816C19.4027 33.0594 15.5687 33.75 11.75 33.75C7.93125 33.75 4.09727 33.0594 2 31.5816ZM18.25 17.5C23.6328 17.5 28 16.0426 28 14.25C28 12.4574 23.6328 11 18.25 11C12.8672 11 8.5 12.4574 8.5 14.25C8.5 16.0426 12.8672 17.5 18.25 17.5ZM2 26.2547V28.875C2 30.6676 6.36719 32.125 11.75 32.125C17.1328 32.125 21.5 30.6676 21.5 28.875V26.2547C19.4027 27.9812 15.5637 28.875 11.75 28.875C7.93633 28.875 4.09727 27.9812 2 26.2547ZM23.125 26.8133C26.0348 26.2496 28 25.2035 28 24V21.8316C26.8219 22.6645 25.0902 23.2332 23.125 23.5836V26.8133ZM11.75 19.125C6.36719 19.125 2 20.943 2 23.1875C2 25.432 6.36719 27.25 11.75 27.25C17.1328 27.25 21.5 25.432 21.5 23.1875C21.5 20.943 17.1328 19.125 11.75 19.125ZM22.8863 21.984C25.9332 21.4355 28 20.359 28 19.125V16.9566C26.1973 18.2313 23.0996 18.9168 19.8395 19.0793C21.3375 19.8055 22.4395 20.7805 22.8863 21.984Z" fill="#FFD234"/>
								<defs>
									<filter id="filter0_f" x="0" y="0" width="22" height="22" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
										<feFlood flood-opacity="0" result="BackgroundImageFix"/>
										<feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
										<feGaussianBlur stdDeviation="1" result="effect1_foregroundBlur"/>
									</filter>
								</defs>
							</svg>
						</button>
					</center>

				</div>
			</div>
			<div class="col-lg-5 bonus">
				<div class="content-area-bonus" style="min-height: 10px;">
					<span class="text_bonus">
						Бонус за ВКонтакте
					</span>
					<div class="sum_bonus">
						{{\App\Setting::first()->bonus_group}} <svg width="29" height="29" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M0 22.9564V25.375C0 27.3744 4.87109 29 10.875 29C16.8789 29 21.75 27.3744 21.75 25.375V22.9564C19.4107 24.6047 15.1344 25.375 10.875 25.375C6.61563 25.375 2.33926 24.6047 0 22.9564ZM18.125 7.25C24.1289 7.25 29 5.62441 29 3.625C29 1.62559 24.1289 0 18.125 0C12.1211 0 7.25 1.62559 7.25 3.625C7.25 5.62441 12.1211 7.25 18.125 7.25ZM0 17.0148V19.9375C0 21.9369 4.87109 23.5625 10.875 23.5625C16.8789 23.5625 21.75 21.9369 21.75 19.9375V17.0148C19.4107 18.9406 15.1287 19.9375 10.875 19.9375C6.62129 19.9375 2.33926 18.9406 0 17.0148ZM23.5625 17.6379C26.808 17.0092 29 15.8424 29 14.5V12.0814C27.6859 13.0104 25.7545 13.6447 23.5625 14.0355V17.6379ZM10.875 9.0625C4.87109 9.0625 0 11.0902 0 13.5938C0 16.0973 4.87109 18.125 10.875 18.125C16.8789 18.125 21.75 16.0973 21.75 13.5938C21.75 11.0902 16.8789 9.0625 10.875 9.0625ZM23.2963 12.2514C26.6947 11.6396 29 10.4389 29 9.0625V6.64395C26.9893 8.06563 23.5342 8.83027 19.8979 9.01152C21.5687 9.82148 22.7979 10.909 23.2963 12.2514Z" fill="#1A2547"/>
						</svg>

					</div>

					<button class="btn_bonus" onclick="disable(this);getBonusVk(this)">Получить</button>
					<button class="btn_social_bonus" onclick="open_link('https://vk.com/public{{\App\Setting::first()->group_id}}')"><svg width="21" style="position: relative;top:2px" height="12" viewBox="0 0 21 12" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M20.5183 0.787679C20.6636 0.334016 20.5183 0 19.8227 0H17.5259C16.9414 0 16.6719 0.288317 16.5258 0.606546C16.5258 0.606546 15.3577 3.26205 13.7031 4.98697C13.1676 5.48716 12.9244 5.64586 12.6321 5.64586C12.486 5.64586 12.2664 5.48716 12.2664 5.03267V0.787679C12.2664 0.242618 12.1054 0 11.6189 0H8.00696C7.64209 0 7.42247 0.252589 7.42247 0.492715C7.42247 1.00869 8.2502 1.12834 8.33508 2.58073V5.73643C8.33508 6.42855 8.2012 6.55402 7.90896 6.55402C7.13023 6.55402 5.23589 3.88605 4.11154 0.833377C3.89367 0.239295 3.67317 0 3.08606 0H0.787483C0.131247 0 0 0.288317 0 0.606546C0 1.17321 0.778734 3.98825 3.6268 7.71144C5.52551 10.2539 8.19858 11.6324 10.6337 11.6324C12.094 11.6324 12.2742 11.3266 12.2742 10.799V8.87717C12.2742 8.26481 12.4125 8.14267 12.8754 8.14267C13.2166 8.14267 13.8002 8.3022 15.1634 9.52775C16.7209 10.981 16.9773 11.6324 17.854 11.6324H20.1508C20.8071 11.6324 21.1361 11.3266 20.9471 10.7217C20.7388 10.1202 19.9951 9.24691 19.009 8.2108C18.4735 7.62087 17.6703 6.98525 17.4261 6.66702C17.0858 6.25905 17.1829 6.07709 17.4261 5.71399C17.4261 5.71399 20.2261 2.0365 20.5174 0.787679H20.5183Z" fill="#BCC7E8"/>
					</svg>
				</button>
			</div>
			<div class="content-area-bonus" style="min-height: 10px;">
				<span class="text_bonus">
					Бонус за Telegram
				</span>
				<div class="sum_bonus">
					{{\App\Setting::first()->bonus_group}} <svg width="29" height="29" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M0 22.9564V25.375C0 27.3744 4.87109 29 10.875 29C16.8789 29 21.75 27.3744 21.75 25.375V22.9564C19.4107 24.6047 15.1344 25.375 10.875 25.375C6.61563 25.375 2.33926 24.6047 0 22.9564ZM18.125 7.25C24.1289 7.25 29 5.62441 29 3.625C29 1.62559 24.1289 0 18.125 0C12.1211 0 7.25 1.62559 7.25 3.625C7.25 5.62441 12.1211 7.25 18.125 7.25ZM0 17.0148V19.9375C0 21.9369 4.87109 23.5625 10.875 23.5625C16.8789 23.5625 21.75 21.9369 21.75 19.9375V17.0148C19.4107 18.9406 15.1287 19.9375 10.875 19.9375C6.62129 19.9375 2.33926 18.9406 0 17.0148ZM23.5625 17.6379C26.808 17.0092 29 15.8424 29 14.5V12.0814C27.6859 13.0104 25.7545 13.6447 23.5625 14.0355V17.6379ZM10.875 9.0625C4.87109 9.0625 0 11.0902 0 13.5938C0 16.0973 4.87109 18.125 10.875 18.125C16.8789 18.125 21.75 16.0973 21.75 13.5938C21.75 11.0902 16.8789 9.0625 10.875 9.0625ZM23.2963 12.2514C26.6947 11.6396 29 10.4389 29 9.0625V6.64395C26.9893 8.06563 23.5342 8.83027 19.8979 9.01152C21.5687 9.82148 22.7979 10.909 23.2963 12.2514Z" fill="#1A2547"/>
					</svg>

				</div>

				<button class="btn_bonus"  onclick="disable(this);getBonusTg(this)">Получить</button>
				<button class="btn_social_bonus" onclick="open_link('https://t.me/{{\App\Setting::first()->tg_id}}')" style="position:relative;top:5px"><svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M10.5 0.328125C4.88053 0.328125 0.328125 4.88119 0.328125 10.5C0.328125 16.1188 4.88119 20.6719 10.5 20.6719C16.1195 20.6719 20.6719 16.1188 20.6719 10.5C20.6719 4.88119 16.1188 0.328125 10.5 0.328125ZM15.496 7.29684L13.8265 15.164C13.7032 15.7218 13.3711 15.857 12.9078 15.5945L10.3648 13.7202L9.13828 14.9015C9.00309 15.0367 8.88825 15.1515 8.62575 15.1515L8.80622 12.5632L13.5188 8.3055C13.7242 8.12503 13.4735 8.02266 13.2024 8.20312L7.37822 11.8696L4.86806 11.086C4.32272 10.9141 4.31025 10.5407 4.98291 10.2782L14.7899 6.49622C15.2453 6.33216 15.643 6.60713 15.4954 7.29619L15.496 7.29684Z" fill="#BCC7E8"/>
				</svg>

			</button>
		</div>
	</div>

	<div class="content-area-bonus" style="width: 100%;min-height: 50px;">
		<div style="padding: 35px;padding-top: 43px;z-index: 4;position: relative;" class="p_500_10 w-100"> 
			<span class="title_promo" >
				Достижения
			</span>

			<div class="flex no_padding wrap" id="all_status" style="margin-top: 20px;">
				

			</div>

			<button class="btn-dep" style="width: 100%" onclick="show_modal('status')">Что это такое?</button>
		</div>
		 
		 
	</div>

	
			<div class="content-area-bonus" style="width: 100%;min-height: 50px;">
		<div style="padding: 35px;padding-top: 43px;z-index: 4;position: relative;" class="p_500_10 w-100"> 
			<span class="title_promo" >
				Бонус за репост
			</span>
			<div style="margin-top: 20px;">
				<span class="text-secondary">Бонусный баланс:</span>
				<div class="title_promo" style="font-size: 28px;margin-bottom: 15px;margin-top: 10px;" id="bonusBalance">{{\Auth::user()->balance_repost}}</div>
				<button class="btn-auth" onclick="disable(this);changeRepostBalance(this)">Обменять</button>
			</div>
			<div class="hr" style="margin-top: 20px;"></div>
			<div class="flex no_padding wrap" id="all_reposts" style="margin-top: 15px;">
				

			</div>

		</div>
		 
		 
	</div>

	
	<script type="text/javascript">
	var MY_REPOSTS = {{\Auth::user()->reposts}}

	function getRepost() {
        $.post('/repost/all',{_token: csrf_token}).then(e=>{
            $('#all_reposts').html('')
            e.repost.forEach((e)=>{
            	percent = 100 * MY_REPOSTS / e.repost_to
            	if(percent > 100) { percent = 100 }
                $('#all_reposts').append('<div class="col-lg-3 mb-20">\
					<div class="flex no_padding wrap">\
						<div class="col-5" style="max-width:calc(100% - 35px)">\
							<span class="text_bonus" style="margin-top: 0px;font-weight: 700;margin-bottom: 5px">'+e.id+' уровень</span>\
							<span class="text_bonus" style="margin-top: 0px;">'+MY_REPOSTS+' / '+e.repost_to+'</span>\
						</div>\
						<div class="col-5" style="text-align: right;max-width:35px;">\
							<span class="text_bonus" style="margin-top: 0px;font-size: 19px;font-weight: bold;position: relative;top:50%;transform: translateY(-50%);color:'+e.color+'">'+e.bonus+'</span>\
						</div>\
					</div>\
					\
					<div class="block_proggress" style="height: 5px;">\
						<div class="prog" style="width: '+percent+'%;background: '+e.color+';height: 5px;"></div>\
						\
					</div>\
				</div>')

            	
            });
        });
    }
    getRepost()


	var MY_SUM_DEP = {{\Auth::user()->deps}}
    function getStatus() {
        $.post('/status/all',{_token: csrf_token}).then(e=>{
            $('#all_status').html('')
            $('#all_status_table').html('')
            e.status.forEach((e)=>{
            	percent = 100 * MY_SUM_DEP / e.deposit
            	if(percent > 100) { percent = 100 }
                $('#all_status').append('<div class="col-lg-4 mb-20">\
					<span class="text_bonus" style="margin-top: 0px;">'+e.name+'</span>\
					<div class="block_proggress">\
						<span>'+MY_SUM_DEP+' / '+e.deposit+'</span>\
						<div class="prog" style="width: '+percent+'%;background: '+e.color+'"></div>\
						\
					</div>\
				</div>')

            	$('#all_status_table').append('<tr>\
                    <td class="text-secondary" style="color: '+e.color+'">'+e.name+'</td>\
                    <td class="text-secondary">'+e.deposit+'</td>\
                    <td class="text-secondary">'+e.bonus+'</td>\
                </tr>')
            });
        });
    }
    getStatus()
</script>


	<div class="content-area-bonus" style="height: 229px;width: 100%;background: url(img/fon_b.png);position: relative;border-radius: 20px;background-size: cover;background-repeat: no-repeat;">
		<div class="bonus_ten"></div>
		<img src="img/bonus_people.png" class="bonus_p light">
		<img src="img/bonus_people_dark.png?v=1" class="bonus_p dark">
		<div style="padding: 35px;padding-top: 43px;width: 100%;z-index: 4;position: relative;" class="p_500_10"> 
			<span class="title_promo">ПРОМО-КОДЫ</span>
			<div class="about_promo">Активируй, создавай и дари радость игрокам</div>
			<button class="btn_bonus" style="width:152px;margin-top:45px" onclick="show_modal('promo')">Попробовать</button>
		</div>
		  
	</div>

	

</div>
</div>
</div> 
</div>

@else
<script type="text/javascript">location.href='/';</script>
@endauth
