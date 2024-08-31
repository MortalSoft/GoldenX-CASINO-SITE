 <div class="content" >
 	<div class="flex " >
 		<div class="col" style="max-width: 100%;margin: 0px auto;">
 			<div class="flex no_padding wrap">
 				<div class="col">
 					<div class="flex no_padding wrap">
 						<div class="col-lg-4">
 							<div class="content-area " style="min-height: 10px;">
 								<button class="btn-dep w-100" onclick="load('admin/gamepay_wallets');">Кошельки</button>
 							</div>
 						</div>

 						<div class="col-lg-4">
 							<div class="content-area " style="min-height: 10px;" >
 								<button class="btn-auth w-100" >Добавление кошельков</button>
 							</div>
 						</div>

 						<div class="col-lg-4">
 							<div class="content-area " style="min-height: 10px;">
 								<button class="btn-dep w-100" onclick="load('admin/gamepay_merchant');">Настройка мерчанта</button>
 							</div>
 						</div>
 					</div>
 					<div class="flex no_padding wrap">
 						<div class="col-lg-4">
 							<div class="content-area">
                                <span class="text-secondary">Добавление Qiwi</span>
 								<div class="flex no_padding wrap" style="margin-top: 20px;">
                                    <div class="col mb-20">
                                        <label>Номер кошелька</label>
                                        <div class="flex no_padding wrap">
                                            <div style="position:relative;margin-top: 10px;" class="col">
                                                <input type=""  class="secodary_input" id="qiwi_wallet" name="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col mb-20">
                                        <label>Токен кошелька</label>
                                        <div class="flex no_padding wrap">
                                            <div style="position:relative;margin-top: 10px;" class="col">
                                                <input type=""  class="secodary_input" id="qiwi_token" name="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col mb-20">
                                        <button class="btn-auth w-100" onclick="addWallet('qiwi')">Добавить</button>
                                    </div>
                                </div>
 								
 							</div>
 						</div>


 						<div class="col-lg-4">
 							<div class="content-area">
                                <span class="text-secondary">Добавление YooMoney</span>
                                <div class="flex no_padding wrap" style="margin-top: 20px;">
                                    <div class="col mb-20">
                                        <label>Номер кошелька</label>
                                        <div class="flex no_padding wrap">
                                            <div style="position:relative;margin-top: 10px;" class="col">
                                                <input type=""  class="secodary_input" id="yoomoney_wallet" name="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col mb-20">
                                        <label>Токен кошелька</label>
                                        <div class="flex no_padding wrap">
                                            <div style="position:relative;margin-top: 10px;" class="col">
                                                <input type=""  class="secodary_input" id="yoomoney_token" name="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col mb-20">
                                        <button class="btn-auth w-100" onclick="addWallet('yoomoney')">Добавить</button>
                                    </div>
                                </div>
 								
 							</div>
 						</div>


 						<div class="col-lg-4">
 							<div class="content-area">
                                <span class="text-secondary">Добавление Payeer</span>
                                <div class="flex no_padding wrap" style="margin-top: 20px;">
                                    <div class="col mb-20">
                                        <label>Номер кошелька</label>
                                        <div class="flex no_padding wrap">
                                            <div style="position:relative;margin-top: 10px;" class="col">
                                                <input type=""  class="secodary_input" id="payeer_wallet" name="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col mb-20">
                                        <label>App ID</label>
                                        <div class="flex no_padding wrap">
                                            <div style="position:relative;margin-top: 10px;" class="col">
                                                <input type=""  class="secodary_input" id="payeer_appid" name="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col mb-20">
                                        <label>Api Key</label>
                                        <div class="flex no_padding wrap">
                                            <div style="position:relative;margin-top: 10px;" class="col">
                                                <input type=""  class="secodary_input" id="payeer_token" name="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col mb-20">
                                        <button class="btn-auth w-100" onclick="addWallet('payeer')">Добавить</button>
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
