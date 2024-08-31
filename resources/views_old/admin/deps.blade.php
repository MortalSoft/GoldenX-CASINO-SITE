<div class="content" >
	<div class="flex " >
		<div class="col" style="max-width: 100%;margin: 0px auto;">
			<div class="flex no_padding wrap">
				<div class="col">
					
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
								</tr> 
							</thead>
							<!--ряд с ячейками заголовков-->
							<tbody id="all_payments">					 			
								<tr>
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
								<input type="" id="id_page" value="1" onkeyup="pageList($('#id_page').val() - 1, `paymentsAll`, getPayments)" style="border-radius:10px 0px 0px 10px" class="secodary_input w-100" name="">
								<button class="btn-auth w-100" style="border-radius:0px 10px 10px 0px" onclick="pageList($('#id_page').val() - 1, `paymentsAll`, getPayments)" >Go</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function getPayments() {

		$.post('/admin/payments/all',{_token: csrf_token}).then(e=>{
			$('#all_payments').html('')
			$('#button_menu').html('')

			paginate = JSON.parse(e.paginate);
			for (var i = 0; i < paginate.length; i++) {
				$('#button_menu').append('<button onclick="pageList('+(Number(paginate[i]) - 1)+', `paymentsAll`, getPayments)" class="btn-dep w-100 '+(Number(paginate[i]) - 1)+'">'+paginate[i]+'</button>')
			}

			$('#button_menu button.'+e.step).addClass('btn-auth').removeClass('btn-dep')
			$('#id_page').val(e.step + 1)
			e.payments.forEach((e)=>{

				$('#all_payments').append('<tr>\
					<th>'+e.id+'</th>\
					<td onclick="load(`admin/info_user`,``, loadInfoUserTimer('+e.user_id+'))" ><img class="avatar_user" src="'+e.avatar+'"></td>\
					<td><span>'+e.login+'</span></td>\
					<td>'+e.sum+'</td>\
					<td>'+e.data+'</td>\
					<td><img src="'+e.img_system+'" style="max-width:40px;"></td>\
					</tr>')
			});
		});
	}
	getPayments()


</script>