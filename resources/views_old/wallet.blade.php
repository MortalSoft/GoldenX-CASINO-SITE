<div class="content" >
	<div class="flex ">
		<div class="col-menu-lg">

		</div>
		<div class="col" style="max-width: 700px;margin: 0px auto;position:relative;">
			<div class="flex no_padding wrap">
				

				<div class="content-area-bonus" style="height: 229px;width: 100%;background: url(img/fon_b.png);position: relative;border-radius: 20px;background-size: cover;background-repeat: no-repeat;">
					<div class="bonus_ten"></div>
					<img src="img/bonus_w.png" class="bonus_p" style="right:20px">
					<div style="padding: 35px;padding-top: 43px;width: 100%;z-index: 4;position: relative;" class="p_500_10"> 
						<span class="title_promo">БОНУСЫ</span>
						<div class="about_promo">Крути колесо фортуны и зарабатывай!</div>
						<button class="btn_bonus" onclick="load('bonus')" style="width:152px;margin-top:45px">Попробовать</button>
					</div>

				</div>
				<div class="methods_pay">
					<div class="panel_pay_type" type="deposit">
						<input type="hidden" id="id_method" name="">
						<div class="padding-20" id="all_systems">
							
						</div>

						<div class="padding-20 d-mob">
							<button class="btn-auth w-100" onclick="typeShow(this)">Развернуть</button>
						</div>

					</div>
				</div>
				<div class="panel_pay"><div class="padding-35" style="padding-bottom: 0px;">
					<div class="menu_pay menu_pays">
						<div class="active" onclick="type_pay('deposit', this)">ПОПОЛНЕНИЕ</div>
						<div onclick="type_pay('withdraw', this)">ВЫВОД</div>
						<div onclick="type_pay('history', this)">ИСТОРИЯ</div>
					</div>
				</div>
				<script type="text/javascript">
					async function getSystem(type) {
						$('#all_systems').html('')
						await $.post('/system'+type+'/all',{_token: csrf_token}).then(e=>{	
							firstId = 0
							firstMinSum = 0	 			
							e.systems.forEach((e)=>{
								if(e.comm_rub == 0){
									comm_rub = '';
								}else{
									comm_rub = '+ '+e.comm_rub+' руб.';
								}	

								if(!e.comm_rub){comm_rub = '';}
								if(firstId == 0){ firstId = e.id }
									if(firstMinSum == 0){ firstMinSum = e.min_sum }

										$('#all_systems').append('<div onclick="changeMethod(this, '+e.id+', '+e.min_sum+', `'+type+'`, '+e.comm_percent+', '+e.comm_rub+')" class="method_block_pay">\
											<img src="'+e.img+'">\
											<span class="text_pay">'+e.name+'</span>\
											<div class="comission_block"><span>'+e.comm_percent+'% '+comm_rub+'</span></div>\
											</div>')
								});
						});

						changeMethod('.method_block_pay:eq(0)', firstId, firstMinSum, type)
					}
					getSystem('deps')
				</script>

				<script type="text/javascript">
					function type_pay(type, that) {
						$('#id_method').val('')
						$('.panels_pays').hide();
						if(type == 'deposit'){getSystem('deps')}
						if(type == 'withdraw'){getSystem('withdraws')}
						$('.'+type+'_panel').show();
						$('.menu_pays div').removeClass('active');
						$(that).addClass('active');
						$('.panel_pay_type').attr('type', type)
					}

					function type_history(type, that) {
						$('#id_method').val('')
						
						if(type == 'deposit'){getHistory('deps')}
						if(type == 'withdraw'){getHistory('withdraws')}
						
						$('.menu_history div').removeClass('active');
						$(that).addClass('active');
					}
					</script>

					<div class="panels_pays history_panel" style="display:none">

						<div class="padding-35" style="padding-top: 0px;">

							<div style="margin-top:25px">

								<div class="menu_pay menu_history flex no_padding" style="margin-bottom:25px;">
									<div class="active" style="width:100%;" onclick="type_history('deposit', this)">ПОПОЛНЕНИЯ</div>
									<div onclick="type_history('withdraw', this)"  style="width:100%;">ВЫВОДЫ</div>
								</div>
								<div style="height: 505px;overflow-y: auto;" id="all_history" class="element">
									

									
								</div>

							</div>
						</div>
					</div>

					<div class="panels_pays withdraw_panel" style="display:none">

						<div class="padding-35" style="border-bottom: 1px solid #E3E5FA;padding-top: 0px;">
							<div style="margin-top:25px">
								<input type="hidden" id="comm_percent" name="">
								<input type="hidden" id="comm_rub" name="">
								<label>Сумма вывода</label>
								<div class="flex no_padding wrap">
									<div style="position:relative;margin-top: 10px;" class="col-lg-5">
										<input type="" value="100" class="secodary_input input_wheel" id="sum_withdraw" onkeyup="$('#sum_itog_pay').html($('#sum_withdraw').val());updateW()" name="">
										<div class="dop_input">
											<svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M0 10.2908V11.375C0 12.2713 2.18359 13 4.875 13C7.56641 13 9.75 12.2713 9.75 11.375V10.2908C8.70137 11.0297 6.78437 11.375 4.875 11.375C2.96563 11.375 1.04863 11.0297 0 10.2908ZM8.125 3.25C10.8164 3.25 13 2.52129 13 1.625C13 0.728711 10.8164 0 8.125 0C5.43359 0 3.25 0.728711 3.25 1.625C3.25 2.52129 5.43359 3.25 8.125 3.25ZM0 7.62734V8.9375C0 9.83379 2.18359 10.5625 4.875 10.5625C7.56641 10.5625 9.75 9.83379 9.75 8.9375V7.62734C8.70137 8.49062 6.78184 8.9375 4.875 8.9375C2.96816 8.9375 1.04863 8.49062 0 7.62734ZM10.5625 7.90664C12.0174 7.6248 13 7.10176 13 6.5V5.41582C12.4109 5.83223 11.5451 6.1166 10.5625 6.2918V7.90664ZM4.875 4.0625C2.18359 4.0625 0 4.97148 0 6.09375C0 7.21602 2.18359 8.125 4.875 8.125C7.56641 8.125 9.75 7.21602 9.75 6.09375C9.75 4.97148 7.56641 4.0625 4.875 4.0625ZM10.4432 5.49199C11.9666 5.21777 13 4.67949 13 4.0625V2.97832C12.0986 3.61563 10.5498 3.9584 8.91973 4.03965C9.66875 4.40273 10.2197 4.89023 10.4432 5.49199Z" fill="#95A5BE"/>
											</svg>

										</div>
									</div>
									<div class="col-lg-5">
										<div class="flex no_padding wrap" >
											<button class="btn_bet col-4" style="margin-left: 0px;" onclick="$('#sum_withdraw').val(100);$('#sum_itog_pay').html(100);updateW()">100</button>
											<button class="btn_bet col-4" onclick="$('#sum_withdraw').val(250);$('#sum_itog_pay').html(250);updateW()">250</button>
											<button class="btn_bet col-4" style="margin-right: 0px;" onclick="$('#sum_withdraw').val(500);$('#sum_itog_pay').html(500);updateW()">500</button>
										</div>
									</div>
								</div>
							</div>


							<div style="margin-top:20px">
								<label>Поступит на счет</label>

								<div style="position:relative;margin-top: 10px;" >
									<input type="" value="100" readonly="" id="get_withdraw" class="secodary_input input_wheel"name="">
									<div class="dop_input">
										<svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M0 10.2908V11.375C0 12.2713 2.18359 13 4.875 13C7.56641 13 9.75 12.2713 9.75 11.375V10.2908C8.70137 11.0297 6.78437 11.375 4.875 11.375C2.96563 11.375 1.04863 11.0297 0 10.2908ZM8.125 3.25C10.8164 3.25 13 2.52129 13 1.625C13 0.728711 10.8164 0 8.125 0C5.43359 0 3.25 0.728711 3.25 1.625C3.25 2.52129 5.43359 3.25 8.125 3.25ZM0 7.62734V8.9375C0 9.83379 2.18359 10.5625 4.875 10.5625C7.56641 10.5625 9.75 9.83379 9.75 8.9375V7.62734C8.70137 8.49062 6.78184 8.9375 4.875 8.9375C2.96816 8.9375 1.04863 8.49062 0 7.62734ZM10.5625 7.90664C12.0174 7.6248 13 7.10176 13 6.5V5.41582C12.4109 5.83223 11.5451 6.1166 10.5625 6.2918V7.90664ZM4.875 4.0625C2.18359 4.0625 0 4.97148 0 6.09375C0 7.21602 2.18359 8.125 4.875 8.125C7.56641 8.125 9.75 7.21602 9.75 6.09375C9.75 4.97148 7.56641 4.0625 4.875 4.0625ZM10.4432 5.49199C11.9666 5.21777 13 4.67949 13 4.0625V2.97832C12.0986 3.61563 10.5498 3.9584 8.91973 4.03965C9.66875 4.40273 10.2197 4.89023 10.4432 5.49199Z" fill="#95A5BE"/>
										</svg>


									</div>

								</div>
							</div>

							<div style="margin-top:20px;margin-bottom: 0px;">
								<label>Номер кошелька</label>

								<div style="position:relative;margin-top: 10px;" >
									<input type="" class="secodary_input input_wheel" id="wallet_withdraw" name="">
									<div class="dop_input">
										<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M9.33393 9.94971L10.5395 8.74368C10.7018 8.58326 10.9073 8.47345 11.1308 8.42757C11.3544 8.3817 11.5864 8.40174 11.7988 8.48525L13.2681 9.07211C13.4827 9.15927 13.6667 9.30803 13.797 9.49966C13.9272 9.69128 13.9979 9.91719 14 10.1489V12.8409C13.9988 12.9986 13.9656 13.1543 13.9026 13.2988C13.8396 13.4433 13.748 13.5735 13.6334 13.6817C13.5188 13.7898 13.3834 13.8737 13.2355 13.9281C13.0877 13.9825 12.9303 14.0065 12.7729 13.9985C2.47744 13.3578 0.400043 4.63567 0.00716727 1.29757C-0.0110703 1.13365 0.00559289 0.967719 0.0560605 0.8107C0.106528 0.653681 0.189656 0.509132 0.299977 0.386561C0.410297 0.26399 0.545309 0.166176 0.69613 0.0995532C0.846951 0.0329307 1.01016 -0.000990209 1.17503 2.2004e-05H3.77447C4.00643 0.000708891 4.23288 0.0708044 4.4247 0.201293C4.61652 0.331781 4.76493 0.516695 4.85084 0.73225L5.43746 2.20209C5.52371 2.41372 5.54571 2.64608 5.50073 2.87015C5.45574 3.09421 5.34576 3.30005 5.18452 3.46195L3.97898 4.66797C3.97898 4.66797 4.67324 9.36823 9.33393 9.94971Z" fill="#95A5BE"/>
										</svg>




									</div>

								</div>
							</div>

						</div>

						<div class="padding-35">
							<div class="flex no_padding wrap">
								<div class="col-lg-5" style="margin-bottom: 10px;">
									<span class="text_min_dep">Мин. вывод: <span id="min_sum_withdraws">50</span> <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M0 7.12441V7.875C0 8.49551 1.51172 9 3.375 9C5.23828 9 6.75 8.49551 6.75 7.875V7.12441C6.02402 7.63594 4.69688 7.875 3.375 7.875C2.05313 7.875 0.725977 7.63594 0 7.12441ZM5.625 2.25C7.48828 2.25 9 1.74551 9 1.125C9 0.504492 7.48828 0 5.625 0C3.76172 0 2.25 0.504492 2.25 1.125C2.25 1.74551 3.76172 2.25 5.625 2.25ZM0 5.28047V6.1875C0 6.80801 1.51172 7.3125 3.375 7.3125C5.23828 7.3125 6.75 6.80801 6.75 6.1875V5.28047C6.02402 5.87812 4.69512 6.1875 3.375 6.1875C2.05488 6.1875 0.725977 5.87812 0 5.28047ZM7.3125 5.47383C8.31973 5.27871 9 4.9166 9 4.5V3.74941C8.59219 4.0377 7.99277 4.23457 7.3125 4.35586V5.47383ZM3.375 2.8125C1.51172 2.8125 0 3.4418 0 4.21875C0 4.9957 1.51172 5.625 3.375 5.625C5.23828 5.625 6.75 4.9957 6.75 4.21875C6.75 3.4418 5.23828 2.8125 3.375 2.8125ZM7.22988 3.80215C8.28457 3.6123 9 3.23965 9 2.8125V2.06191C8.37598 2.50312 7.30371 2.74043 6.1752 2.79668C6.69375 3.04805 7.0752 3.38555 7.22988 3.80215Z" fill="#95A5BE"/>
									</svg>
								</span>
								<div class="itog_pay">К выводу: <span class="sum_itog_pay" id="sum_itog_pay">100</span> <svg width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M0 8.70762V9.625C0 10.3834 1.84766 11 4.125 11C6.40234 11 8.25 10.3834 8.25 9.625V8.70762C7.3627 9.33281 5.74062 9.625 4.125 9.625C2.50938 9.625 0.887305 9.33281 0 8.70762ZM6.875 2.75C9.15234 2.75 11 2.1334 11 1.375C11 0.616602 9.15234 0 6.875 0C4.59766 0 2.75 0.616602 2.75 1.375C2.75 2.1334 4.59766 2.75 6.875 2.75ZM0 6.45391V7.5625C0 8.3209 1.84766 8.9375 4.125 8.9375C6.40234 8.9375 8.25 8.3209 8.25 7.5625V6.45391C7.3627 7.18437 5.73848 7.5625 4.125 7.5625C2.51152 7.5625 0.887305 7.18437 0 6.45391ZM8.9375 6.69023C10.1686 6.45176 11 6.00918 11 5.5V4.58262C10.5016 4.93496 9.76895 5.17559 8.9375 5.32383V6.69023ZM4.125 3.4375C1.84766 3.4375 0 4.20664 0 5.15625C0 6.10586 1.84766 6.875 4.125 6.875C6.40234 6.875 8.25 6.10586 8.25 5.15625C8.25 4.20664 6.40234 3.4375 4.125 3.4375ZM8.83652 4.64707C10.1256 4.41504 11 3.95957 11 3.4375V2.52012C10.2373 3.05938 8.92676 3.34941 7.54746 3.41816C8.18125 3.72539 8.64746 4.13789 8.83652 4.64707Z" fill="#726FE9"/>
								</svg>
							</div>
						</div>
						<div class="col-lg-5"><button class="btn_bet_dice" onclick="disable(this);goWithdraw(this)">Вывести
							<img src="img/yellow_coin.svg" class="dop_input">
						</button></div>
					</div>
					<span class="text_min_dep" style="margin-top: 15px;">Максимальный вывод с бонуса: 500p</span>
				</div>


			</div> 

			<!-- ////////////////////////////////////////////////////////// -->
			<div class="panels_pays deposit_panel">

				<div class="padding-35" style="border-bottom: 1px solid #E3E5FA;padding-top: 0px;">
					<div style="margin-top:25px">
						<label>Сумма пополнения</label>
						<div class="flex no_padding wrap">
							<div style="position:relative;margin-top: 10px;" class="col-lg-5">
								<input type="" value="100" class="secodary_input input_wheel" id="sumDep" onkeyup="$('.payDep').html($('#sumDep').val())" name="">
								<div class="dop_input">
									<svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M0 10.2908V11.375C0 12.2713 2.18359 13 4.875 13C7.56641 13 9.75 12.2713 9.75 11.375V10.2908C8.70137 11.0297 6.78437 11.375 4.875 11.375C2.96563 11.375 1.04863 11.0297 0 10.2908ZM8.125 3.25C10.8164 3.25 13 2.52129 13 1.625C13 0.728711 10.8164 0 8.125 0C5.43359 0 3.25 0.728711 3.25 1.625C3.25 2.52129 5.43359 3.25 8.125 3.25ZM0 7.62734V8.9375C0 9.83379 2.18359 10.5625 4.875 10.5625C7.56641 10.5625 9.75 9.83379 9.75 8.9375V7.62734C8.70137 8.49062 6.78184 8.9375 4.875 8.9375C2.96816 8.9375 1.04863 8.49062 0 7.62734ZM10.5625 7.90664C12.0174 7.6248 13 7.10176 13 6.5V5.41582C12.4109 5.83223 11.5451 6.1166 10.5625 6.2918V7.90664ZM4.875 4.0625C2.18359 4.0625 0 4.97148 0 6.09375C0 7.21602 2.18359 8.125 4.875 8.125C7.56641 8.125 9.75 7.21602 9.75 6.09375C9.75 4.97148 7.56641 4.0625 4.875 4.0625ZM10.4432 5.49199C11.9666 5.21777 13 4.67949 13 4.0625V2.97832C12.0986 3.61563 10.5498 3.9584 8.91973 4.03965C9.66875 4.40273 10.2197 4.89023 10.4432 5.49199Z" fill="#95A5BE"/>
									</svg>

								</div>
							</div>
							<div class="col-lg-5">
								<div class="flex no_padding wrap" >
									<button class="btn_bet col-4" style="margin-left: 0px;" onclick="$('#sumDep').val(100);$('.payDep').html(100)">100</button>
									<button class="btn_bet col-4" onclick="$('#sumDep').val(250);$('.payDep').html(250)">250</button>
									<button class="btn_bet col-4" style="margin-right: 0px;" onclick="$('#sumDep').val(500);$('.payDep').html(500)">500</button>
								</div>
							</div>
						</div>
					</div>


					<div style="margin-top:20px">
						<label>Комиссия платежной системы</label>

						<div style="position:relative;margin-top: 10px;" >
							<input type="" value="0.00" readonly="" class="secodary_input input_wheel" id="commDep" name="">
							<div class="dop_input">
								<svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M2.814 5.492C2.09533 5.492 1.50733 5.24933 1.05 4.764C0.602 4.26933 0.378 3.61133 0.378 2.79C0.378 1.96867 0.602 1.31533 1.05 0.83C1.50733 0.335333 2.09533 0.0879999 2.814 0.0879999C3.53267 0.0879999 4.116 0.335333 4.564 0.83C5.012 1.31533 5.236 1.96867 5.236 2.79C5.236 3.61133 5.012 4.26933 4.564 4.764C4.116 5.24933 3.53267 5.492 2.814 5.492ZM8.652 0.199999H10.318L3.626 10H1.96L8.652 0.199999ZM2.814 4.344C3.13133 4.344 3.37867 4.21333 3.556 3.952C3.74267 3.69067 3.836 3.30333 3.836 2.79C3.836 2.27667 3.74267 1.88933 3.556 1.628C3.37867 1.36667 3.13133 1.236 2.814 1.236C2.506 1.236 2.25867 1.37133 2.072 1.642C1.88533 1.90333 1.792 2.286 1.792 2.79C1.792 3.294 1.88533 3.68133 2.072 3.952C2.25867 4.21333 2.506 4.344 2.814 4.344ZM9.464 10.112C8.99733 10.112 8.57733 10.0047 8.204 9.79C7.84 9.566 7.55533 9.24867 7.35 8.838C7.14467 8.42733 7.042 7.95133 7.042 7.41C7.042 6.86867 7.14467 6.39267 7.35 5.982C7.55533 5.57133 7.84 5.25867 8.204 5.044C8.57733 4.82 8.99733 4.708 9.464 4.708C10.1827 4.708 10.766 4.95533 11.214 5.45C11.6713 5.93533 11.9 6.58867 11.9 7.41C11.9 8.23133 11.6713 8.88933 11.214 9.384C10.766 9.86933 10.1827 10.112 9.464 10.112ZM9.464 8.964C9.78133 8.964 10.0287 8.83333 10.206 8.572C10.3927 8.30133 10.486 7.914 10.486 7.41C10.486 6.906 10.3927 6.52333 10.206 6.262C10.0287 5.99133 9.78133 5.856 9.464 5.856C9.156 5.856 8.90867 5.98667 8.722 6.248C8.53533 6.50933 8.442 6.89667 8.442 7.41C8.442 7.92333 8.53533 8.31067 8.722 8.572C8.90867 8.83333 9.156 8.964 9.464 8.964Z" fill="#95A5BE"/>
								</svg>


							</div>

						</div>
					</div>

					<div style="margin-top:20px;margin-bottom: 0px;">
						<label>Промо-код (если есть)</label>

						<div style="position:relative;margin-top: 10px;" >
							<input type="" class="secodary_input input_wheel" id="promoDep" name="">
							<div class="dop_input">
								<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
									<g clip-path="url(#clip0)">
										<path d="M0.968964 3.75H5.65646V5.625H0.968964V3.75Z" fill="#95A5BE"/>
										<path d="M0.968964 6.5625H5.65646V13.125H0.968964V6.5625Z" fill="#95A5BE"/>
										<path d="M10.344 3.75H15.0315V5.625H10.344V3.75Z" fill="#95A5BE"/>
										<path d="M10.344 13.125H15.0315V6.5625H10.344V13.125ZM11.2815 10.3125H14.094V11.25H11.2815V10.3125Z" fill="#95A5BE"/>
										<path d="M10.783 2.48001C11.1 2.21201 11.281 1.82101 11.281 1.40601C11.281 0.630512 10.65 -0.000488281 9.87446 -0.000488281C9.25846 -0.000488281 8.71896 0.394012 8.53396 0.981012L7.99946 2.66751L7.46496 0.981012C7.27996 0.394012 6.74096 -0.000488281 6.12446 -0.000488281C5.34896 -0.000488281 4.71796 0.630512 4.71796 1.40601C4.71796 1.82051 4.89946 2.21201 5.21696 2.48051L6.71846 3.75001H6.59296V16L7.99946 14.5935L9.40596 16V3.75001H9.28046L10.783 2.48001ZM9.42796 1.26451C9.49046 1.06901 9.66946 0.937512 9.87496 0.937512C10.133 0.937512 10.344 1.14751 10.344 1.40601C10.344 1.54401 10.2835 1.67501 10.1785 1.76451L8.93796 2.81251L9.42796 1.26451ZM5.65646 1.40651C5.65646 1.14801 5.86696 0.937512 6.12546 0.937512C6.33046 0.937512 6.50996 1.06901 6.57246 1.26451L7.06296 2.81251L5.82346 1.76501C5.71746 1.67551 5.65696 1.54451 5.65696 1.40601L5.65646 1.40651Z" fill="#95A5BE"/>
									</g>
									<defs>
										<clipPath id="clip0">
											<rect width="16" height="16" fill="white"/>
										</clipPath>
									</defs>
								</svg>



							</div>

						</div>
					</div>

				</div>

				<div class="padding-35">
					<div class="flex no_padding wrap">
						<div class="col-lg-5" style="margin-bottom: 10px;">
							<span class="text_min_dep">Мин. депозит: <span id="min_sum_deposit">30</span> <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M0 7.12441V7.875C0 8.49551 1.51172 9 3.375 9C5.23828 9 6.75 8.49551 6.75 7.875V7.12441C6.02402 7.63594 4.69688 7.875 3.375 7.875C2.05313 7.875 0.725977 7.63594 0 7.12441ZM5.625 2.25C7.48828 2.25 9 1.74551 9 1.125C9 0.504492 7.48828 0 5.625 0C3.76172 0 2.25 0.504492 2.25 1.125C2.25 1.74551 3.76172 2.25 5.625 2.25ZM0 5.28047V6.1875C0 6.80801 1.51172 7.3125 3.375 7.3125C5.23828 7.3125 6.75 6.80801 6.75 6.1875V5.28047C6.02402 5.87812 4.69512 6.1875 3.375 6.1875C2.05488 6.1875 0.725977 5.87812 0 5.28047ZM7.3125 5.47383C8.31973 5.27871 9 4.9166 9 4.5V3.74941C8.59219 4.0377 7.99277 4.23457 7.3125 4.35586V5.47383ZM3.375 2.8125C1.51172 2.8125 0 3.4418 0 4.21875C0 4.9957 1.51172 5.625 3.375 5.625C5.23828 5.625 6.75 4.9957 6.75 4.21875C6.75 3.4418 5.23828 2.8125 3.375 2.8125ZM7.22988 3.80215C8.28457 3.6123 9 3.23965 9 2.8125V2.06191C8.37598 2.50312 7.30371 2.74043 6.1752 2.79668C6.69375 3.04805 7.0752 3.38555 7.22988 3.80215Z" fill="#95A5BE"/>
							</svg>
						</span>
						<div class="itog_pay">Всего к оплате: <span class="sum_itog_pay payDep">100</span> <svg width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M0 8.70762V9.625C0 10.3834 1.84766 11 4.125 11C6.40234 11 8.25 10.3834 8.25 9.625V8.70762C7.3627 9.33281 5.74062 9.625 4.125 9.625C2.50938 9.625 0.887305 9.33281 0 8.70762ZM6.875 2.75C9.15234 2.75 11 2.1334 11 1.375C11 0.616602 9.15234 0 6.875 0C4.59766 0 2.75 0.616602 2.75 1.375C2.75 2.1334 4.59766 2.75 6.875 2.75ZM0 6.45391V7.5625C0 8.3209 1.84766 8.9375 4.125 8.9375C6.40234 8.9375 8.25 8.3209 8.25 7.5625V6.45391C7.3627 7.18437 5.73848 7.5625 4.125 7.5625C2.51152 7.5625 0.887305 7.18437 0 6.45391ZM8.9375 6.69023C10.1686 6.45176 11 6.00918 11 5.5V4.58262C10.5016 4.93496 9.76895 5.17559 8.9375 5.32383V6.69023ZM4.125 3.4375C1.84766 3.4375 0 4.20664 0 5.15625C0 6.10586 1.84766 6.875 4.125 6.875C6.40234 6.875 8.25 6.10586 8.25 5.15625C8.25 4.20664 6.40234 3.4375 4.125 3.4375ZM8.83652 4.64707C10.1256 4.41504 11 3.95957 11 3.4375V2.52012C10.2373 3.05938 8.92676 3.34941 7.54746 3.41816C8.18125 3.72539 8.64746 4.13789 8.83652 4.64707Z" fill="#726FE9"/>
						</svg>
					</div>
				</div>
				<div class="col-lg-5">
					<button class="btn_bet_dice" onclick="disable(this);goDeposit(this)">Пополнить <img class="dop_btn" src="img/yellow_coin.svg"></button>
				</div>
			</div>
		</div>


	</div>

	<!-- //////////////////////////////////////////// -->



</div>

</div>

</div>
</div>
</div> 
</div>

<script type="text/javascript">
	function getHistory(type) {
		$('#all_history').html('')
		$.post('/wallet/gethistory',{_token: csrf_token, type}).then(e=>{				
			e.history.forEach((e)=>{	
				cansel = '';
				if(type == 'deps'){
					type_h = 'Депозит'
				}else{
					if(e.status == 0){
						cansel = '<span class="text-secondary cansel_withdraw" onclick="disable(this);canselWithdraw('+e.id+', this)">Отменить</span>';
					}
					
					type_h = 'Вывод'
				}

				if(e.status == 1){
					status = 'success'
				}

				if(e.status == 0){
					status = 'wait'
				}


				if(e.status == 5){
					status = 'wait'
				}

				if(e.status == 2){
					status = 'error'
				}

				$('#all_history').append('<div class="flex no_padding wrap mb-20">\
					<div class="col-5" style="max-width:240px;width:240px;">\
					<div class="block_history">'+cansel+'\
					<img src="'+e.img_system+'" class="img_history_panel">\
					<div class="text_history_panel">'+e.sum+'  <img src="img/coin.svg?v=5" style="position: absolute;transform: translateX(3px);"></div>\
					<img src="img/wallet/status_'+status+'.svg?v=3" class="img_status_history_panel">\
					</div>\
					</div>\
					<div class="col-5" style="max-width: calc(100% - 245px);height: 63px;position: relative;text-align: center;">\
					<span class="text_type">'+type_h+'</span>\
					</div>\
					</div>')
			});
		});
	}
	getHistory('deps');
</script>