 <div class="content" >
	<div class="flex " >
		<div class="col" style="max-width: 100%;margin: 0px auto;">
			<div class="flex no_padding wrap">
				<div class="col">
					<div class="flex no_padding wrap">
						<div class="col-lg-3">
							<div class="content-area " style="min-height: 10px;">
								<button class="btn-auth w-100" onclick="load('admin/settings_site');">Настройки сайта</button>
							</div>
						</div>

						<div class="col-lg-3">
							<div class="content-area " style="min-height: 10px;" >
								<button class="btn-dep w-100" onclick="load('admin/settings_withdraw');">Настройки вывода</button>
							</div>
						</div>

						<div class="col-lg-3">
							<div class="content-area " style="min-height: 10px;">
								<button class="btn-dep w-100" onclick="load('admin/settings_deps');">Настройки пополнения</button>
							</div>
						</div>

						<div class="col-lg-3">
							<div class="content-area " style="min-height: 10px;">
								<button class="btn-dep w-100" onclick="load('admin/settings_bonus');">Настройки бонуса</button>
							</div>
						</div>

						<div class="col-lg-3">
							<div class="content-area " style="min-height: 10px;">
								<button class="btn-dep w-100" onclick="load('admin/settings_random');">Настройки  Random.Org</button>
							</div>
						</div>

						<div class="col-lg-3">
							<div class="content-area " style="min-height: 10px;">
								<button class="btn-dep w-100" onclick="load('admin/settings_partner');">Настройки сотрудничества</button>
							</div>
						</div>

						<div class="col-lg-3">
							<div class="content-area " style="min-height: 10px;">
								<button class="btn-dep w-100" onclick="load('admin/settings_anti');">Настройки антиминуса</button>
							</div>
						</div>
						<div class="col-lg-3">
                            <div class="content-area " style="min-height: 10px;">
                                <button class="btn-dep w-100" onclick="load('admin/settings_status');">Настройки привилегий</button>
                            </div>
                        </div>
					</div>
					@php
						$setting = \App\Setting::first();
					@endphp
					<div class="content-area">
						<div class="flex no_padding wrap">
							<div class="col-5 col-lg-3 mb-20">
								<label>Название сайта</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <input type="" class="secodary_input" value="{{$setting->name}}" id="name" name="">
					                </div>
					            </div>
							</div>

							<div class="col-5 col-lg-3 mb-20">
								<label>Айди группы вк</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <input type="" class="secodary_input" value="{{$setting->group_id}}" id="group_id" name="">
					                </div>
					            </div>
							</div>

							<div class="col-5 col-lg-3 mb-20">
								<label>Токен группы вк</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <input type="" class="secodary_input" value="{{$setting->group_token}}" id="group_token" name="">
					                </div>
					            </div> 
							</div>

							<div class="col-5 col-lg-3 mb-20">
								<label>Канал тг</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <input type="" class="secodary_input" value="{{$setting->tg_id}}" id="tg_id" name="">
					                </div>
					            </div>
							</div>

							<div class="col-5 col-lg-3 mb-20">
								<label>Бот тг</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <input type="" class="secodary_input" value="{{$setting->tg_bot_id}}" id="tg_bot_id" name="">
					                </div>
					            </div>
							</div>

							<div class="col-5 col-lg-3 mb-20">
								<label>Токен бота тг</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <input type="" class="secodary_input" value="{{$setting->tg_token}}" id="tg_token" name="">
					                </div>
					            </div>
							</div>

							<div class="col-5 col-lg-3 mb-20">
								<label>FK ID</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <input type="" class="secodary_input" value="{{$setting->fk_id}}" id="fk_id" name="">
					                </div>
					            </div>
							</div>

							<div class="col-5 col-lg-3 mb-20">
								<label>FK SECRET 1</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <input type="" class="secodary_input" value="{{$setting->fk_secret_1}}" id="fk_secret_1" name="">
					                </div>
					            </div>
							</div>

							<div class="col-5 col-lg-3 mb-20">
								<label>FK SECRET 2</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <input type="" class="secodary_input" value="{{$setting->fk_secret_2}}" id="fk_secret_2" name="">
					                </div>
					            </div>
							</div>

							<div class="col-5 col-lg-3 mb-20">
								<label>Piastix ID</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <input type="" class="secodary_input" value="{{$setting->piastrix_id}}" id="piastrix_id" name="">
					                </div>
					            </div>
							</div>

							<div class="col-5 col-lg-3 mb-20">
								<label>Piastix SECRET</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <input type="" class="secodary_input" value="{{$setting->piastrix_secret}}" id="piastrix_secret" name="">
					                </div>
					            </div>
							</div>

							<div class="col-5 col-lg-3 mb-20">
								<label>Айди магазина GamePay</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <input type="" class="secodary_input" value="{{$setting->gamepay_shop_id}}" id="gamepay_shop_id" name="">
					                </div>
					            </div>
							</div>

							<div class="col-5 col-lg-3 mb-20">
								<label>API KEY GamePay</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <input type="" class="secodary_input" value="{{$setting->gamepay_api_key}}" id="gamepay_api_key" name="">
					                </div>
					            </div>
							</div>

							<div class="col-5 col-lg-3 mb-20">
								<label>Бонус за регистрацию</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <input type="" class="secodary_input" value="{{$setting->bonus_reg}}" id="bonus_reg" name="">
					                </div>
					            </div>
							</div>

							

							<div class="col-5 col-lg-3 mb-20">
								<label>Бонус за подписку на группу ВК и ТГ</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <input type="" class="secodary_input" value="{{$setting->bonus_group}}" id="bonus_group" name="">
					                </div>
					            </div>
							</div>

							<div class="col-5 col-lg-3 mb-20">
								<label>Депозит для перевода средств</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <input type="" class="secodary_input" value="{{$setting->dep_transfer}}" id="dep_transfer" name="">
					                </div>
					            </div>
							</div>

							<div class="col-5 col-lg-3 mb-20">
								<label>Депозит для создания промокода</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <input type="" class="secodary_input" value="{{$setting->dep_createpromo}}" id="dep_createpromo" name="">
					                </div>
					            </div>
							</div>
 
						</div>

						<div class="flex no_padding wrap" style="margin-bottom: 10px;">
							<div class="col-lg-5 d-comp"></div>
							<div class="col-lg-5">						
								<div class="flex no_padding">
									<div class="w-100 d-comp"></div>
									<button onclick="saveSetting();" class="btn-auth w-100" ><span class="">Сохранить</span></button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
