<div class="content" >
	<div class="flex " >
		<div class="col" style="max-width: 100%;margin: 0px auto;">
			<div class="content-area">
				<div class="flex no_padding wrap" style="margin-bottom: 10px;">
					<div class="col-lg-5 d-comp"></div>
					<div class="col-lg-3">

						<button onclick="load('admin/users')" class="btn-auth w-100">Назад </button>


					</div>
				</div>

				<div class="flex no_padding wrap">
					<div class="col-lg-5">
						<div class="info_user" style="text-align: center;position: relative;margin-top: 10px;">
							<div class="balance_info_user text-secondary"><span id="balance"></span> p.</div>
							<img src="https://c.tenor.com/I6kN-6X7nhAAAAAi/loading-buffering.gif" id="avatar">
							<div class="mult_info_user text-secondary bg_success">Мультов нет</div>
							<div class="text-secondary name"><span id="name"></span>. ID <span id="id"></span></div>
						</div>
						<div class="hr" style="margin-top:10px;margin-bottom: 15px;"></div>
						<div class="flex no_padding">
							
							<div class="col"><button class="btn-dep w-100" style="border-radius: 10px 0px 0px 10px;">Проверка на мульты</button></div>
							<div class="col"><button class="btn-auth w-100" style="border-radius:0px 10px 10px 0px;">Настройки игрока</button></div>
						</div>

						<div style="margin-top: 10px;">
							<span class="text-secondary">Совпадения по кошелькам</span>

							<div class="table_scroll">
							<table style="margin-top:10px;">
							<thead>
								<tr>
									<th>ID</th>
									<th colspan="2">Логин</th>
									<th>Баланс</th>
									<th>IP</th>
									<th>Видеокарта</th>
									
									<th>Действие</th>
								</tr> 
							</thead>
							<!--ряд с ячейками заголовков-->
							<tbody id="all_mults_wallet">								
								<tr>
									
									
								</tr>

							</tbody>
							
							<!--ряд с ячейками тела таблицы-->
						</table>
						</div>
						</div>

						<div style="margin-top: 10px;">
							<span class="text-secondary">Мульты</span>

							<div class="table_scroll">
							<table style="margin-top:10px;">
							<thead>
								<tr>
									<th>ID</th>
									<th colspan="2">Логин</th>
									<th>Баланс</th>
									<th>IP</th>
									<th>Видеокарта</th>
									
									<th>Действие</th>
								</tr> 
							</thead>
							<!--ряд с ячейками заголовков-->
							<tbody id="all_mults">								
								<tr>
									
									
								</tr>

							</tbody>
							
							<!--ряд с ячейками тела таблицы-->
						</table>
						</div>
						</div>


						<div style="margin-top: 10px;">
							<span class="text-secondary">Переводы</span>

							<div class="table_scroll">
							<table style="margin-top:10px;">
							<thead>
								<tr>
									<th>Тип</th>
									<th>Баланс до</th>
									<th>Баланс после</th>
									<th>Изменение баланса</th>
									<th>Дата</th>
								</tr> 
							</thead>
							<!--ряд с ячейками заголовков-->
							<tbody id="all_transfers">								
								<tr>
									
									
								</tr>

							</tbody>
							
							<!--ряд с ячейками тела таблицы-->
						</table>
						</div>
						</div>

					</div>
					<div class="col-lg-5">
						<div class="flex no_padding wrap">
							<div class="col-5 col-lg-4 mb-20">
								<label>Имя</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <input type="" class="secodary_input"  id="user_name" name="">
					                </div>
					            </div>
							</div>
							<div class="col-5 col-lg-4 mb-20">
								<label>Ава</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <input type="" class="secodary_input"  id="user_avatar" name="">
					                </div>
					            </div>
							</div>
							<div class="col-5 col-lg-4 mb-20">
								<label>Баланс</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <input type="" class="secodary_input"  id="user_balance" name="">
					                </div>
					            </div>
							</div>
							<div class="col-5 col-lg-4 mb-20">
								<label>Вк</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <input type="" class="secodary_input"  readonly="" id="user_social" name="">
					                </div>
					            </div>
							</div>

							<div class="col-5 col-lg-4 mb-20">
								<label>IP</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <input type="" class="secodary_input" readonly=""  id="user_ip" name="">
					                </div>
					            </div>
							</div>

							<div class="col-5 col-lg-4 mb-20">
								<label>Видеокарта</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <input type="" class="secodary_input" readonly=""  id="user_videocard" name="">
					                </div>
					            </div>
							</div>


							<div class="col-5 col-lg-4 mb-20">
								<label>Роль</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <select type="" class="secodary_input"  id="user_admin" name="">
					                    	<option value="0">Игрок</option>
					                    	<option value="2">Модератор</option>
					                    	<option value="1">Администратор</option>
					                    	<option value="3">Ютубер</option>
					                    </select>
					                </div>
					            </div>
							</div>

							<div class="col-5 col-lg-4 mb-20">
								<label>Бан на сайте</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <select type="" class="secodary_input"  id="user_ban" name="">
					                    	<option value="0">Нет</option>
					                    	<option value="1">Да</option>
					                    </select>
					                </div>
					            </div>
							</div>

							<div class="col-5 col-lg-4 mb-20">
								<label>Причина бана на сайте</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <input type="" class="secodary_input"  id="user_why_ban" name="">
					                </div>
					            </div>
							</div>

							<div class="col-5 col-lg-4 mb-20">
								<label>Бан в чате</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <select type="" class="secodary_input"  id="user_chat_ban" name="">
					                    	<option value="0">Нет</option>
					                    	<option value="1">Да</option>
					                    </select>
					                </div>
					            </div>
							</div>


							<div class="col-5 col-lg-4 mb-20">
								<label>Рефералов</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <input type="" class="secodary_input" readonly="" id="user_refs" name="">
					                </div>
					            </div>
							</div>

							<div class="col-5 col-lg-4 mb-20">
								<label>Заработано с рефов</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <input type="" class="secodary_input" readonly=""  id="user_profit" name="">
					                </div>
					            </div>
							</div>

							<div class="col-5 col-lg-4 mb-20">
								<label>Пополнено</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <input type="" class="secodary_input" readonly=""  id="user_deps" name="">
					                </div>
					            </div>
							</div>

							<div class="col-5 col-lg-4 mb-20">
								<label>Выведено</label>
								<div class="flex no_padding wrap">
					                <div style="position:relative;margin-top: 10px;" class="col">
					                    <input type="" class="secodary_input" readonly=""  id="user_withdraws" name="">
					                </div>
					            </div>
							</div>


						</div>

						<button class="btn-auth w-100" onclick="saveUser()">Сохранить</button>
					
					<div style="margin-top: 10px;">
							<span class="text-secondary">Видеокарты</span>

							<div class="table_scroll">
							<table style="margin-top:10px;">
							<thead>
								<tr>
									<th>Видеокарта + IP</th>
								</tr> 
							</thead>
							<!--ряд с ячейками заголовков-->
							<tbody id="all_videocards">								
								<tr>
									
									
								</tr>

							</tbody>
							
							<!--ряд с ячейками тела таблицы-->
						</table>
						</div>
						</div>

</div>


				</div>

				<div style="margin-top: 10px;">
							<span class="text-secondary">История баланса</span>

							<div class="table_scroll">
							<table style="margin-top:10px;">
							<thead>
								<tr>
									
									<th>Тип</th>
									<th>Баланс до</th>
									<th>Баланс после</th>
									<th>Изменение баланса</th>
									<th>Дата</th>
								</tr> 
							</thead>
							<!--ряд с ячейками заголовков-->
							<tbody id="all_history">								
								<tr>
									
									
								</tr>

							</tbody>
							
							<!--ряд с ячейками тела таблицы-->
						</table>
						</div>
						<div class="col-lg-5">
							<div class="flex no_padding" id="button_menu">
								
							</div>
							<div class="flex no_padding" style="margin-top: 10px;">
								<input type="" id="id_page" value="1" onkeyup="pageListUser($('#id_page').val() - 1, loadInfoUser)" style="border-radius:10px 0px 0px 10px" class="secodary_input w-100" name="">
								<button class="btn-auth w-100" style="border-radius:0px 10px 10px 0px" onclick="pageListUser($('#id_page').val() - 1, loadInfoUser)" >Go</button>
							</div>
						</div>
						</div>


			</div>
		</div>
	</div>
</div> 