<div class="content" >
	<div class="flex " >
		<div class="col" style="max-width: 100%;margin: 0px auto;">
			<div class="flex no_padding wrap">
				<div class="col">
					<div class="flex no_padding wrap">
						<div class="col-lg-4">
							<div class="content-area " style="min-height: 10px;">
								<button class="btn-dep btn_w btn_w_all w-100" onclick="getWithdraws('all', 0)">Все выводы</button>
							</div>
						</div>

						<div class="col-lg-4">
							<div class="content-area " style="min-height: 10px;" >
								<button class="btn-dep btn_w btn_w_0  w-100" onclick="getWithdraws(0, 0)">Активные выводы</button>
							</div>
						</div>

						<div class="col-lg-4">
							<div class="content-area " style="min-height: 10px;">
								<button class="btn-dep btn_w btn_w_1 w-100" onclick="getWithdraws(1, 0)">Выполненные выводы</button>
							</div>
						</div>

						<div class="col-lg-4">
							<div class="content-area " style="min-height: 10px;">
								<button class="btn-dep btn_w btn_w_mult w-100" onclick="getWithdraws('all', 1)">Выводы мультов</button>
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
									<th>Сумма</th>
									<th>Дата</th>
									<th>Система</th>
									<th>Кошелек</th>
									<th>Статус</th>
									<th>Действие</th>
								</tr> 
							</thead>
							<!--ряд с ячейками заголовков-->
							<tbody id="all_withdraw">					 			
								<tr>
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
							<div class="flex no_padding" style="margin-top: 10px;">
								<input type="" id="id_page" value="1" onkeyup="pageList($('#id_page').val() - 1, `withdrawsAll`, getWithdraws)" style="border-radius:10px 0px 0px 10px" class="secodary_input w-100" name="">
								<button class="btn-auth w-100" style="border-radius:0px 10px 10px 0px" onclick="pageList($('#id_page').val() - 1, `withdrawsAll`, getWithdraws)" >Go</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function getWithdraws(type = '', mult) {

		$.post('/admin/withdraws/all',{_token: csrf_token, type, mult}).then(e=>{
			$('#all_withdraw').html('')
			$('#button_menu').html('')

			paginate = JSON.parse(e.paginate);
			for (var i = 0; i < paginate.length; i++) {
				$('#button_menu').append('<button onclick="pageList('+(Number(paginate[i]) - 1)+', `withdrawsAll`, getWithdraws)" class="btn-dep w-100 '+(Number(paginate[i]) - 1)+'">'+paginate[i]+'</button>')
			}

			$('#button_menu button.'+e.step).addClass('btn-auth').removeClass('btn-dep')
			$('#id_page').val(e.step + 1)
			$('.btn_w').removeClass('btn-auth').addClass('btn-dep')
			$('.btn_w_'+e.type).addClass('btn-auth').removeClass('btn-dep')
			e.withdraws.forEach((e)=>{
				buttons = '<button class="btn-dep" onclick="withdraw_menu('+e.status+', '+e.id+')"><i class="fa fa-list" style="font-size:16px"></i></button> ';
				if (e.status == 0){
					buttons += '<button class="btn-dep" onclick="disable(this);updateWithdraw(5, this, '+e.id+')">FK</button>'
				}
				system = '';
				if(e.status  == 1){
					st = '<span class="badge badge_success">Отправлен</span>';
					buttons = '';
				}else if(e.status == 0){
					st = '<span class="badge badge_warning">Ожидание</span>';
				}else if(e.status == 2){
					st = '<span class="badge badge_error">Отменен</span>';
					buttons = '';
				}else{
					st = '<span class="badge badge_warning">Обработка</span>';
				}
				

				$('#all_withdraw').append('<tr>\
					<th>'+e.id+'</th>\
					<td onclick="load(`admin/info_user`,``, loadInfoUserTimer('+e.user_id+'))" ><img class="avatar_user" src="'+e.avatar+'"></td>\
					<td><span>'+e.login+'</span></td>\
					<td>'+e.sum+'</td>\
					<td>'+e.date+'</td>\
					<td>'+e.ps+'</td>\
					<td>'+e.wallet+'</td>\
					<td>'+st+'</td>\
					<td>'+buttons+'</td>\
					</tr>')
			});
		});
	}
	getWithdraws('', '')


</script>