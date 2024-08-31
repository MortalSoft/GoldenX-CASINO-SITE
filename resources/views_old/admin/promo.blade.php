<div class="content" >
	<div class="flex " >
		<div class="col" style="max-width: 100%;margin: 0px auto;">
			<div class="flex no_padding wrap">
				<div class="col">
					<div class="flex no_padding wrap">
						<div class="col-lg-4">
							<div class="content-area " style="min-height: 10px;">
								<button class="btn-auth w-100">Денежные промокоды</button>
							</div>
						</div>

						<div class="col-lg-4">
							<div class="content-area " style="min-height: 10px;" >
								<button class="btn-dep w-100" onclick="load('admin/deppromo');">Промокоды к депу</button>
							</div>
						</div>

						<div class="col-lg-4">
							<div class="content-area " style="min-height: 10px;">
								<button class="btn-dep w-100" onclick="load('admin/historypromo');">Последние активации</button>
							</div>
						</div>
					</div>
					<div class="content-area">
						<div class="flex no_padding wrap" style="margin-bottom: 10px;">
							<div class="col-lg-5 d-comp"></div>
							<div class="col-lg-5">						
								<div class="flex no_padding">
									<div class="w-100 d-comp"></div>
									<button onclick="generatePromo();show_modal('create_promo');" class="btn-auth w-100" ><span class="">Создать промокод</span></button>
								</div>
							</div>
						</div>
						<div class="table_scroll">
						<table>
							<thead>
								<tr>
									<th>ID</th>
									<th>Название</th>
									<th>Сумма</th>
									<th>Активаций</th>
									<th>Активировано</th>
									<th>Создатель</th>
									<th>Начало</th>
									<th>Конец</th>
									<th>Действие</th>
								</tr> 
							</thead>
							<!--ряд с ячейками заголовков-->
							<tbody id="all_promo">					 			
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
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function getPromo() {

		$.post('/admin/promo/all',{_token: csrf_token}).then(e=>{
			$('#all_promo').html('')
			$('#button_menu').html('')

			paginate = JSON.parse(e.paginate);
			for (var i = 0; i < paginate.length; i++) {
				$('#button_menu').append('<button onclick="pageList('+(Number(paginate[i]) - 1)+', `promoAll`, getPromo)" class="btn-dep w-100 '+(Number(paginate[i]) - 1)+'">'+paginate[i]+'</button>')
			}

			$('#button_menu button.'+e.step).addClass('btn-auth').removeClass('btn-dep')
			e.promo.forEach((e)=>{		
				$('#all_promo').append('<tr>\
					<th>'+e.id+'</th>\
					<td>'+e.name+'</td>\
					<td>'+e.sum+'</td>\
					<td>'+e.active+'</td>\
					<td>'+e.actived+'</td>\
					<td>'+e.user_name+'</td>\
					<td>'+e.start+'</td>\
					<td>'+e.end+'</td>\
					<td><button class="btn-dep w-100" onclick="promo_menu('+e.id+')"><i class="fa fa-list" style="font-size:16px"></i></button></td>\
					</tr>')
			});
		});
	}
	getPromo()


</script>