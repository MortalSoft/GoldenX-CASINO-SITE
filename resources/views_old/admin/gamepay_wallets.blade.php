 <div class="content" >
 	<div class="flex " >
 		<div class="col" style="max-width: 100%;margin: 0px auto;">
 			<div class="flex no_padding wrap">
 				<div class="col">
 					<div class="flex no_padding wrap">
 						<div class="col-lg-4">
 							<div class="content-area " style="min-height: 10px;">
 								<button class="btn-auth w-100">Кошельки</button>
 							</div>
 						</div>

 						<div class="col-lg-4">
 							<div class="content-area " style="min-height: 10px;" >
 								<button class="btn-dep w-100" onclick="load('admin/gamepay_addwallets');">Добавление кошельков</button>
 							</div>
 						</div>

 						<div class="col-lg-4">
 							<div class="content-area " style="min-height: 10px;">
 								<button class="btn-dep w-100" onclick="load('admin/gamepay_merchant');">Настройка мерчанта</button>
 							</div>
 						</div>
 					</div>
 					<div class="flex no_padding wrap">
 						<div class="col-lg-5">
 							<div class="content-area">
<div class="table_scroll">
 								<table>
 									<thead>
 										<tr>
 											<th>ID</th>
 											<th>Кошелек</th>
 											<th>Баланс</th>
 											<th>Действие</th>
 										</tr> 
 									</thead>
 									<!--ряд с ячейками заголовков-->
 									<tbody id="all_qiwi_wallets">					 			
 										<tr>
 											<td>данные</td>
 											<td>данные</td>
 											<td>данные</td>
 											<td>данные</td>
 										</tr>

 									</tbody>

 									<!--ряд с ячейками тела таблицы-->
 								</table>
 								
                                </div>
 							</div>
 						</div>


 						<div class="col-lg-5">
 							<div class="content-area">
<div class="table_scroll">
 								<table>
 									<thead>
 										<tr>
 											<th>ID</th>
 											<th>Кошелек</th>
 											<th>Баланс</th>
 											<th>Действие</th>
 										</tr> 
 									</thead>
 									<!--ряд с ячейками заголовков-->
 									<tbody id="all_yoomoney_wallets">					 			
 										<tr>
 											<td>данные</td>
 											<td>данные</td>
 											<td>данные</td>
 											<td>данные</td>
 										</tr>

 									</tbody>

 									<!--ряд с ячейками тела таблицы-->
 								</table>
                            </div>
 								
 							</div>
 						</div>


 						<div class="col-lg-5">
 							<div class="content-area">
<div class="table_scroll">
 								<table>
 									<thead>
 										<tr>
 											<th>ID</th>
 											<th>Кошелек</th>
 											<th>Баланс</th>
 											<th>Действие</th>
 										</tr> 
 									</thead>
 									<!--ряд с ячейками заголовков-->
 									<tbody id="all_payeer_wallets">					 			
 										<tr>
 											<td>данные</td>
 											<td>данные</td>
 											<td>данные</td>
 											<td>данные</td>
 										</tr>

 									</tbody>

 									<!--ряд с ячейками тела таблицы-->
 								</table>
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
 	function getWallets() {

 		$.post('/admin/gamepay/wallets',{_token: csrf_token}).then(e=>{
 			$('#all_qiwi_wallets').html('')
 			$('#all_yoomoney_wallets').html('')
 			$('#all_payeer_wallets').html('')

 			e.qiwi.forEach((e)=>{		
 				$('#all_qiwi_wallets').append('<tr>\
 					<th>'+e.id+'</th>\
 					<td>'+e.number+'</td>\
 					<td>'+e.balance+'</td>\
 					<td><button class="btn-dep w-100" onclick="gamepay_menu('+e.id+')"><i class="fa fa-list" style="font-size:16px"></i></button></td>\
 					</tr>')
 			});

 			e.yoomoney.forEach((e)=>{		
 				$('#all_yoomoney_wallets').append('<tr>\
 					<th>'+e.id+'</th>\
 					<td>'+e.number+'</td>\
 					<td>'+e.balance+'</td>\
 					<td><button class="btn-dep w-100" onclick="gamepay_menu('+e.id+')"><i class="fa fa-list" style="font-size:16px"></i></button></td>\
 					</tr>')
 			});

 			e.payeer.forEach((e)=>{		
 				$('#all_payeer_wallets').append('<tr>\
 					<th>'+e.id+'</th>\
 					<td>'+e.number+'</td>\
 					<td>'+e.balance+'</td>\
 					<td><button class="btn-dep w-100" onclick="gamepay_menu('+e.id+')"><i class="fa fa-list" style="font-size:16px"></i></button></td>\
 					</tr>')
 			});
 		});
 	}
 	getWallets()


 </script>