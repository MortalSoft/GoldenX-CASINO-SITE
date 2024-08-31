<div class="content" >
	<div class="flex " >
		<div class="col" style="max-width: 100%;margin: 0px auto;">
			<div class="flex no_padding wrap">
				<div class="col">
					<div class="flex no_padding wrap">
						<div class="col-lg-4">
							<div class="content-area " style="min-height: 10px;">
								<button class="btn-dep w-100" onclick="load('admin/users');">Все юзеры</button>
							</div>
						</div>

						<div class="col-lg-4">
							<div class="content-area " style="min-height: 10px;" >
								<button class="btn-auth w-100" >Топ рефоводов по заработку</button>
							</div>
						</div>

						<div class="col-lg-4">
							<div class="content-area " style="min-height: 10px;">
								<button class="btn-dep w-100" onclick="load('admin/top_refs_ref');">Топ рефоводов по рефералам</button>
							</div>
						</div>
					</div>
					<div class="content-area">
						<div class="table_scroll">
						<table>
							<thead>
								<tr>
									<th>ID</th>
									<th colspan="2">Логин</th>
									<th>Баланс</th>
									<th>IP</th>
									<th>Видеокарта</th>
									<th>Пополнено</th>
									<th>Выведено</th>
									<th>Рефералов</th>
									<th>Заработок с рефов</th>
									<th>Действие</th>
								</tr> 
							</thead>
							<!--ряд с ячейками заголовков-->
							<tbody id="all_users">								
								<tr>
									<td>данные</td>
									<td>данные</td>
									<td>данные</td>
									<td>данные</td>
									<td>данные</td>
									<td>данные</td>
									<td>данные</td>
									<td>данные</td>
									<td>данные</td>
									<td>данные</td>
								</tr>

							</tbody>
							
							<!--ряд с ячейками тела таблицы-->
						</table>
					</div>
						<div class="col-lg-5">
							<div class="flex no_padding" id="button_menu">
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function getUser() {
		$.post('/admin/user/top_refs_profit',{_token: csrf_token}).then(e=>{
			$('#all_users').html('')
			$('#button_menu').html('')

			paginate = JSON.parse(e.paginate);
			for (var i = 0; i < paginate.length; i++) {
				$('#button_menu').append('<button onclick="pageList('+(Number(paginate[i]) - 1)+', `userAllTopProfit`, getUser)" class="btn-dep w-100 '+(Number(paginate[i]) - 1)+'">'+paginate[i]+'</button>')
			}

			$('#button_menu button.'+e.step).addClass('btn-auth').removeClass('btn-dep')
			e.users.forEach((e)=>{
				if(e.ban == 0){
					ban = 'lock'
					type_ban = 1
				}else{
					ban = 'lock-open'
					type_ban = 0
				}
				$('#all_users').append('<tr>\
					<th>'+e.id+'</th>\
					<td><img class="avatar_user" src="'+e.avatar+'"></td>\
					<td><span>'+e.name+'</span></td>\
					<td>'+e.balance+'</td>\
					<td>'+e.ip+'</td>\
					<td>'+e.videocard+'</td>\
					<td>'+e.deps+'</td>\
					<td>'+e.withdraws+'</td>\
					<td>'+e.refs+'</td>\
					<td>'+e.profit+'</td>\
					<td><button class="btn-dep" style="width:50px;margin-right:5px" onclick="userBan(`'+e.avatar+'`, '+e.id+', '+type_ban+')"><i class="fa fa-'+ban+'"></i></button><button class="btn-dep" onclick="load(`admin/user/'+e.id+'`, ``, loadInfoUserTimer('+e.id+'))" style="width:50px"><i class="fa fa-cog"></i></button></td>\
					</tr>')
			});
		});
	}
	getUser()
</script>