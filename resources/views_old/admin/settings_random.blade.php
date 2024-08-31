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
 								<button class="btn-dep w-100" onclick="load('admin/settings_bonus');">Настройки бонуса</button>
 							</div>
 						</div>

 						<div class="col-lg-3">
 							<div class="content-area " style="min-height: 10px;">
 								<button class="btn-auth w-100" onclick="load('admin/settings_random');">Настройки  Random.Org</button>
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
 					<div class="flex no_padding wrap">
 						<div class="col-lg-5">
 							<div class="flex no_padding wrap" id="all_keys">
 								
 							</div>
 							
 						</div>
 						<div class="col-lg-5">
 							<div class="content-area">
 								<span class="text-secondary" id="title_s_w">Добавление ключей Random.Org</span>
 								<div class="flex no_padding wrap" style="margin-top: 20px;">
 									<div class="col mb-20">
 										<label>Ключ</label>
 										<div class="flex no_padding wrap">
 											<div style="position:relative;margin-top: 10px;" class="col">
 												<input type="" class="secodary_input" id="key_random" name="">
 											</div>
 										</div>
 									</div>
 									
                                      
 									

                                    
                                        <div class="col mb-20 buttons_s_w_1">
                                            <button class="btn-auth w-100" onclick="addRandom()">Добавить</button>
                                        </div>
                                    
                                      
 									

 								</div>
 							</div>	
 						</div>
 					</div>

 				</div>
 			</div>
 		</div>
 	</div>
 </div>

 <script type="text/javascript">
 	function getRandom() {
 		$.post('/admin/random/all',{_token: csrf_token}).then(e=>{
 			$('#all_keys').html('')
 			e.keys.forEach((e)=>{
 						
 				$('#all_keys').append('<div class="col-lg-5">\
 									<div class="content-area">\
                                    <span class="text-secondary" style="font-size:12px">'+e.name_key+'</span>\
 										<div class="header_system mb-20" style="margin-top:10px;">\
 											<span class="text-secondary" style="font-size:16px">Игр: '+e.games+'</span>\
 										</div>\
\
 										<div class="flex no_padding wrap">\
 											<div class="col"><button class="btn-dep w-100" onclick="deleteRandomKey('+e.id+')">Удалить</button></div>\
 										</div>\
 									</div>\
 								</div>')
 			});
 		});
 	}
 	getRandom()
 </script>
