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
 								<button class="btn-auth w-100" onclick="load('admin/settings_deps');">Настройки пополнения</button>
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
 					<div class="flex no_padding wrap">
 						<div class="col-lg-5">
 							<div class="flex no_padding wrap" id="all_systems">
 								
 							</div>
 							
 						</div>
 						<div class="col-lg-5">
 							<div class="content-area">
 								<span class="text-secondary" id="title_s_w">Добавление систем пополнения</span>
 								<div class="flex no_padding wrap" style="margin-top: 20px;">
 									<div class="col-5 mb-20">
 										<label>Ссылка на картинку</label>
 										<div class="flex no_padding wrap">
 											<div style="position:relative;margin-top: 10px;" class="col">
 												<input type="" onkeyup="imgWithdraw()" class="secodary_input" id="img_val" name="">
 											</div>
 										</div>
 									</div>
 									<div class="col-5">
 										<img src="" id="img_withdraw">
 									</div>

                                    <input type="hidden" id="id_ww"  name="">

 									<div class="col mb-20">
 										<label>Минимальная сумма пополнения</label>
 										<div class="flex no_padding wrap">
 											<div style="position:relative;margin-top: 10px;" class="col">
 												<input type="" class="secodary_input" id="min_w" value="50" name="">
 											</div>
 										</div>   
 									</div>

                                    <div class="col-5 mb-20">
                                        <label>Платежная система</label>
                                        <div class="flex no_padding wrap">
                                            <div style="position:relative;margin-top: 10px;" class="col">
                                                <select type="" class="secodary_input" id="ps_w" name="">
                                                    <option value="1">FreeKassa</option>
                                                    <option value="2">GamePay</option>
                                                    <option value="3">Piastrix</option>
                                                </select>
                                            </div>
                                        </div>   
                                    </div>

                                    <div class="col-5 mb-20">
                                        <label>Номер системы пополнения</label>
                                        <div class="flex no_padding wrap">
                                            <div style="position:relative;margin-top: 10px;" class="col">
                                                <input type="" class="secodary_input" id="number_w" value="" name="">
                                            </div>
                                        </div>   
                                    </div>

                                    <div class="col-5 mb-20">
                                        <label>Название</label>
                                        <div class="flex no_padding wrap">
                                            <div style="position:relative;margin-top: 10px;" class="col">
                                                <input type="" class="secodary_input" id="name_w" value="" name="">
                                            </div>
                                        </div>   
                                    </div>

 									<div class="col-5 mb-20">
 										<label>Комиссия: %</label>
 										<div class="flex no_padding wrap">
 											<div style="position:relative;margin-top: 10px;" class="col">
 												<input type="" class="secodary_input" id="comm_percent" value="0" name="">
 											</div>
 										</div>
 									</div>


                                    
                                        <div class="col mb-20 buttons_s_w_1">
                                            <button class="btn-auth w-100" onclick="addSystemDep()">Добавить</button>
                                        </div>
                                    
                                        <div class="col-lg-5 mb-20 buttons_s_w_2" style="display: none;">
                                            <button class="btn-dep w-100" onclick="closeEditSystemDep()">Закрыть</button>
                                        </div>
                                        <div class="col-lg-5 mb-20 buttons_s_w_2" style="display: none;">
                                            <button class="btn-auth w-100" onclick="saveEditSystemDep()">Сохранить</button>
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
 	function getSystemDep() {
 		$.post('/systemdeps/all',{_token: csrf_token}).then(e=>{
 			$('#all_systems').html('')
 			e.systems.forEach((e)=>{
 				if(e.ps == 1){
                    ps = 'FreeKassa (№ '+e.number_ps+')'
                }else if(e.ps == 2){
                    ps = 'GamePay (№ '+e.number_ps+')'
                }else{
                    ps = 'Piastrix'
                }
 				$('#all_systems').append('<div class="col-lg-5">\
 									<div class="content-area">\
                                    <span class="text-secondary" style="font-size:16px">'+e.name+'</span>\
 										<div class="header_system mb-20" style="margin-top:10px;">\
 											<img src="'+e.img+'">\
 											<div class="w-100 comm_w" style="text-align: right;"><span class="text-secondary">'+e.comm_percent+'%</span></div>\
 											<div class="w-100 comm_w" style="text-align: right;"><span class="text-secondary">От '+e.min_sum+' руб.</span></div>\
 										</div><span class="text-secondary" style="font-size:14px">Через: '+ps+'</span>\
\
 										<div class="flex no_padding wrap" style="margin-top:10px;">\
 											<div class="col-5"><button class="btn-dep w-100" onclick="deleteSystemDep('+e.id+')">Удалить</button></div>\
 											<div class="col-5"><button class="btn-dep w-100" onclick="editSystemDep('+e.id+', `'+e.name+'`, `'+e.img+'`, `'+e.comm_percent+'`,  '+e.min_sum+', '+e.ps+', '+e.number_ps+')">Редактировать</button></div>\
 										</div>\
 									</div>\
 								</div>')
 			});
 		});
 	}
 	getSystemDep()
 </script>
