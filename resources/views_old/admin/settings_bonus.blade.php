 <div class="content" >
	<div class="flex " >
		<div class="col" style="max-width: 100%;margin: 0px auto;">
			<div class="flex no_padding wrap">
				<div class="col">
					<div class="flex no_padding wrap">
						<div class="col-lg-3">
							<div class="content-area " style="min-height: 10px;">
								<button class="btn-dep w-100" onclick="load('admin/settings_site');">Настройки сайта</button>
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
								<button class="btn-auth w-100" onclick="load('admin/settings_bonus');">Настройки бонуса</button>
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
								<label>Шанс на выпадение 1р</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <input type="" class="secodary_input" value="{{$setting->chance_1}}" id="chance_1" name="">
					                </div>
					            </div>
							</div>

							<div class="col-5 col-lg-3 mb-20">
								<label>Шанс на выпадение 3р</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <input type="" class="secodary_input" value="{{$setting->chance_3}}" id="chance_3" name="">
					                </div>
					            </div>
							</div>

							<div class="col-5 col-lg-3 mb-20">
								<label>Шанс на выпадение 5р</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <input type="" class="secodary_input" value="{{$setting->chance_5}}" id="chance_5" name="">
					                </div>
					            </div>
							</div>

							<div class="col-5 col-lg-3 mb-20">
								<label>Шанс на выпадение 8р</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <input type="" class="secodary_input" value="{{$setting->chance_8}}" id="chance_8" name="">
					                </div>
					            </div>
							</div>

							<div class="col-5 col-lg-3 mb-20">
								<label>Шанс на выпадение 10р</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <input type="" class="secodary_input" value="{{$setting->chance_10}}" id="chance_10" name="">
					                </div>
					            </div>
							</div>

							<div class="col-5 col-lg-3 mb-20">
								<label>Шанс на выпадение 15р</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <input type="" class="secodary_input" value="{{$setting->chance_15}}" id="chance_15" name="">
					                </div>
					            </div>
							</div>

							<div class="col-5 col-lg-3 mb-20">
								<label>Шанс на выпадение 25р</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <input type="" class="secodary_input" value="{{$setting->chance_25}}" id="chance_25" name="">
					                </div>
					            </div>
							</div>

							<div class="col-5 col-lg-3 mb-20">
								<label>Шанс на выпадение 50р</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <input type="" class="secodary_input" value="{{$setting->chance_50}}" id="chance_50" name="">
					                </div>
					            </div>
							</div>

							
 
						</div>

						<div class="flex no_padding wrap" style="margin-bottom: 10px;">
							<div class="col-lg-5 d-comp"></div>
							<div class="col-lg-5">						
								<div class="flex no_padding">
									<div class="w-100 d-comp"></div>
									<button onclick="saveBonus();" class="btn-auth w-100" ><span class="">Сохранить</span></button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
