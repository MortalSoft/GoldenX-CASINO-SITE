function userBan(avatar, id, type_ban){
	show_modal('ban_user');
	$('#ban_user_ava').attr('src', avatar) 
	$('#ban_user_id').val(id)
	$('#ban_type').val(1)
	$('#ban_why').val('')
	$('#ban_user').show()
	if(type_ban == 0){
		$('#ban_type').val(0)
		$('#ban_user').hide()
	}
}

function notification(type, mess){
	noty({
		layout: 'bottomLeft',
		textAlign: 'center',
		text: mess,
		type: type,
		timeout: 1000,
	});
}

async function infoUser(id) {
	user = await $.post('/admin/infouser', $.param({_token: csrf_token, id: id})).then();
	return user.user
}

async function infoPromo(type, name) {
	promo = await $.post('/admin/infopromo', $.param({_token: csrf_token, type, name})).then();
	return promo.promo
}

async function getDateFromDate(date){
	date = await $.post('/admin/getdatefromdate', $.param({_token: csrf_token, date: date})).then();
	return date.date
}
function imgWithdraw(){
	img = $('#img_val').val();
	$('#img_withdraw').attr('src', img)
}
function giveBonusMines(){
	$.post('/admin/givebonusmines',{_token: csrf_token, id: $('#idMinesBonus').val()}).then(e=>{
		if(e.success){
			notification('success', e.mess)
			$('#idMinesBonus').val('')
		}else{
			notification('error', e.mess) 
		}

	});
}

function giveBonusCoin(){ 
	$.post('/admin/givebonuscoin',{_token: csrf_token, id: $('#idCoinBonus').val()}).then(e=>{
		if(e.success){
			notification('success', e.mess)
			$('#idCoinBonus').val('')
		}else{
			notification('error', e.mess)
		}

	});  
}

function giveBonusShoot(drop){ 
	$.post('/admin/givebonusshoot',{_token: csrf_token, drop, id: $('#idShootBonus').val()}).then(e=>{
		if(e.success){
			notification('success', e.mess)
			$('#idShootBonus').val('')
		}else{
			notification('error', e.mess)
		}

	});  
}

function deleteSystemWithdraw(id){
	$.post('/admin/deletesystemwithdraw',{_token: csrf_token, id: id}).then(e=>{
		if(e.success){
			notification('success', e.mess)
			getSystemWithdraw()
		}else{
			notification('error', e.mess)
		}

	});
}

function saveUser(){
	id = $("#id").html()
	params = {_token: csrf_token,
		id: id,
		chat_ban: $("#user_chat_ban").val(),
		why_ban: $("#user_why_ban").val(),
		ban: $('#user_ban').val(),
		admin: $('#user_admin').val(),
		balance: $('#user_balance').val(),
		name: $('#user_name').val(),
		avatar: $('#user_avatar').val()

	}
	$.post('/admin/saveuser', params).then(e=>{
		notification(e.type, e.mess)
	});
}


function searchMultUser(id){
	$.post('/admin/searchmultuser', {_token: csrf_token, id: id}).then(e=>{
		if(e.mults.length > 0){
			$('.mult_info_user').removeClass('bg_success').html('Мульты есть').addClass('bg_danger')
		}
		e.mults.forEach((e)=>{
			if(e.ban == 0){
				ban = 'lock'
				type_ban = 1
			}else{
				ban = 'lock-open'
				type_ban = 0
			}
			$('#all_mults').append('<tr>\
				<th>'+e.id+'</th>\
				<td><img class="avatar_user" src="'+e.avatar+'"></td>\
				<td><span>'+e.name+'</span></td>\
				<td>'+e.balance+'</td>\
				<td>'+e.ip+'</td>\
				<td>'+e.videocard+'</td>\
				<td><button class="btn-dep" style="width:50px;margin-right:5px" onclick="userBan(`'+e.avatar+'`, '+e.id+', '+type_ban+')"><i class="fa fa-'+ban+'"></i></button><button class="btn-dep" onclick="load(`admin/info_user`,``, loadInfoUserTimer('+e.id+'))" style="width:50px"><i class="fa fa-cog"></i></button></td>\
				</tr>')
		});

		e.mults_wallet.forEach((e)=>{
			if(e.ban == 0){
				ban = 'lock'
				type_ban = 1
			}else{
				ban = 'lock-open'
				type_ban = 0
			}
			$('#all_mults_wallet').append('<tr>\
				<th>'+e.id+'</th>\
				<td><img class="avatar_user" src="'+e.avatar+'"></td>\
				<td><span>'+e.name+'</span></td>\
				<td>'+e.balance+'</td>\
				<td>'+e.ip+'</td>\
				<td>'+e.videocard+'</td>\
				<td><button class="btn-dep" style="width:50px;margin-right:5px" onclick="userBan(`'+e.avatar+'`, '+e.id+', '+type_ban+')"><i class="fa fa-'+ban+'"></i></button><button class="btn-dep" onclick="load(`admin/info_user`,``, loadInfoUserTimer('+e.id+'))" style="width:50px"><i class="fa fa-cog"></i></button></td>\
				</tr>')
		});
	});
}
function loadInfoUser(id = ''){
	$.post('/admin/loaduser', {_token: csrf_token, id: id}).then(e=>{
		user = e.user
		for (var key in user) {
			if (user.hasOwnProperty(key)) {  
				$("#user_"+key).val(user[key]) 
			}
		} 

		$("#balance").html(user.balance)
		$("#id").html(user.id)
		$("#name").html(user.name)
		$("#avatar").attr('src', user.avatar)
		searchMultUser(user.id)
		$('#button_menu').html('')
		$('#all_history').html('')
		paginate = JSON.parse(e.paginate);
		for (var i = 0; i < paginate.length; i++) {
			$('#button_menu').append('<button onclick="pageListUser('+(Number(paginate[i]) - 1)+', loadInfoUser)" class="btn-dep w-100 '+(Number(paginate[i]) - 1)+'">'+paginate[i]+'</button>')
		}

		$('#button_menu button.'+e.step).addClass('btn-auth').removeClass('btn-dep')
		$('#id_page').val(e.step + 1)

		e.cashe_hist_user_m.forEach((e)=>{
			razn = Number(e.balance_after) - Number(e.balance_before)
			razn = razn.toFixed(2)
			if (razn > 0){
				razn = '+'+razn
			}
			$('#all_history').append('<tr>\
				<td><span>'+e.type+'</span></td>\
				<td>'+e.balance_before+'</td>\
				<td>'+e.balance_after+'</td>\
				<td>'+razn+'</td>\
				<td>'+e.date+'</td>\
				</tr>')
		});
		$('#all_transfers').html('')
		$('#all_deps').html('')
		$('#all_withdraws').html('')


		e.deps.forEach((e)=>{
			
			$('#all_deps').append('<tr>\
				<th>'+e.id+'</th>\
				<td><img class="avatar_user" src="'+e.avatar+'"></td>\
				<td><span>'+e.login+'</span></td>\
				<td>'+e.sum+'</td>\
				<td>'+e.data+'</td>\
				</tr>')
		});

		e.withdraws.forEach((e)=>{
			
			$('#all_withdraws').append('<tr>\
				<th>'+e.id+'</th>\
				<td><img class="avatar_user" src="'+e.avatar+'"></td>\
				<td><span>'+e.login+'</span></td>\
				<td>'+e.sum+'</td>\
				<td>'+e.date+'</td>\
				</tr>')
		});


		e.transfers.forEach((e)=>{
			razn = Number(e.balance_after) - Number(e.balance_before)
			razn = razn.toFixed(2)
			if (razn > 0){
				razn = '+'+razn
			}
			$('#all_transfers').append('<tr>\
				<td><span>'+e.type+'</span></td>\
				<td>'+e.balance_before+'</td>\
				<td>'+e.balance_after+'</td>\
				<td>'+razn+'</td>\
				<td>'+e.date+'</td>\
				</tr>')
		});

		e.videocards.forEach((e)=>{
			
			$('#all_videocards').append('<tr>\
				<td><span>'+e+'</span></td>\
				</tr>')
		});



	});
}

loadInfoUser()

function loadInfoUserTimer(id) {
	setTimeout(() =>loadInfoUser(id), 1000)
}

function resetBank(type){
	$.post('/admin/resetbank',{_token: csrf_token, type}).then(e=>{
		if(e.success){
			notification('success', e.mess)
			$('#'+type+'_bank').html(250)
			$('#'+type+'_profit').html(0)
		}else{
			notification('error', e.mess)
		}

	});
}

function updateAuto(type, game, that){
	$.post('/admin/updateauto',{_token: csrf_token, type, game}).then(e=>{
		if(e.success){
			$(".btn-"+game).removeClass('btn-auth').addClass('btn-dep')
			$(that).addClass('btn-auth').removeClass('btn-dep')
			notification('success', e.mess)
		}else{
			notification('error', e.mess)
		}

	});
}

function deleteSystemDep(id){
	$.post('/admin/deletesystemdep',{_token: csrf_token, id: id}).then(e=>{
		if(e.success){
			notification('success', e.mess)
			getSystemDep()
		}else{
			notification('error', e.mess)
		}

	});
}

function addWallet(type){
	if(type == 'payeer'){
		param = {
			type,
			_token: csrf_token,
			wallet: $("#payeer_wallet").val(),
			appid: $("#payeer_appid").val(),
			token: $("#payeer_token").val()
		}
	}else{
		param = {
			type,
			_token: csrf_token,
			wallet: $("#"+type+"_wallet").val(),
			token: $("#"+type+"_token").val()
		}
	}

	$.post('/admin/gamepay/addwallet',param).then(e=>{
		if(e.success){
			notification('success', e.mess)
			$("#"+type+"_wallet").val('')
			$("#payeer_appid").val('')
			$("#"+type+"_token").val('')

		}else{
			notification('error', e.mess)
		}

	});

}


function closeEditSystemWithdraw(){
	$('#title_s_w').html('Добавление систем вывода')
	$('#img_val').val('');
	imgWithdraw();
	$('#min_w').val('50');
	$('#comm_percent').val('5')
	$('#comm_rub').val('0')
	$('#name_w').val('')

	$('.buttons_s_w_1').show()
	$('.buttons_s_w_2').hide()
}

function editSystemWithdraw(id, name, img, comm_percent, comm_rub, min_sum){
	$('#title_s_w').html('Редактирование системы вывода №'+id)
	$('#img_val').val(img);
	imgWithdraw();
	$('#min_w').val(min_sum);
	$('#comm_percent').val(comm_percent)
	$('#comm_rub').val(comm_rub)
	$('#id_ww').val(id)
	$('#name_w').val(name)

	$('.buttons_s_w_1').hide()
	$('.buttons_s_w_2').show()
}

function editSystemDep(id, name, img, comm_percent, min_sum, ps, number_ps){
	$('#title_s_w').html('Редактирование системы пополнения №'+id)
	$('#img_val').val(img);
	imgWithdraw();
	$('#min_w').val(min_sum);
	$('#comm_percent').val(comm_percent)
	$('#ps_w').val(ps)
	$('#id_ww').val(id)
	$('#name_w').val(name)
	$('#number_w').val(number_ps)

	$('.buttons_s_w_1').hide()
	$('.buttons_s_w_2').show()
}

function closeEditSystemDep(argument) {
	$('#title_s_w').html('Добавление систем пополнения')
	$('#img_val').val('');
	imgWithdraw();
	$('#min_w').val('50');
	$('#comm_percent').val('5')
	$('#id_ww').val('')
	$('#name_w').val('')
	$('#number_w').val('')

	$('.buttons_s_w_1').show()
	$('.buttons_s_w_2').hide()
}

function saveEditSystemDep(argument) {
	img = $('#img_val').val();
	id = $('#id_ww').val();
	min = $('#min_w').val();
	comm_percent = $('#comm_percent').val();
	ps = $('#ps_w').val();
	name = $('#name_w').val();
	number_ps = $('#number_w').val()

	$.post('/admin/editsystemdep',{_token: csrf_token,number_ps, id,img, min, comm_percent, ps, name}).then(e=>{
		if(e.success){			
			closeEditSystemDep()
			getSystemDep();
			notification('success', e.mess)
		}else{
			notification('error', e.mess)
		}

	});
}
function editStatus(id, color, deposit, name, bonus){
	$('#title_s_w').html('Редактирование привилегии №'+id)
	$('#id_status').val(id);
	$('#color_status').val(color);
	$('#deposit_status').val(deposit);
	$('#name_status').val(name);
	$('#bonus_status').val(bonus);

	$('.buttons_s_w_1').hide()
	$('.buttons_s_w_2').show()
}

function closeEditStatus(argument) {
	$('#title_s_w').html('Добавление привилегий')
	$('#color_status').val('');
	$('#deposit_status').val('');
	$('#name_status').val('')
	$('#bonus_status').val('')

	$('.buttons_s_w_1').show()
	$('.buttons_s_w_2').hide()
}


function editRepost(id, color, repost, bonus){
	$('#title_s_w').html('Редактирование уровня репоста №'+id)
	$('#id_repost').val(id);
	$('#color_repost').val(color);
	$('#to_repost').val(repost);
	$('#bonus_repost').val(bonus);

	$('.buttons_s_w_1').hide()
	$('.buttons_s_w_2').show()
}

function closeEditRepost() {
	$('#title_s_w').html('Добавление уровня репоста')
	$('#color_repost').val('');
	$('#to_repost').val('');
	$('#bonus_repost').val('')

	$('.buttons_s_w_1').show()
	$('.buttons_s_w_2').hide()
}


function saveEditRepost() {
	id = $('#id_repost').val();
	color = $('#color_repost').val();
	repost = $('#to_repost').val();
	bonus = $('#bonus_repost').val();

	$.post('/admin/editrepost',{_token: csrf_token,color, id,repost, bonus}).then(e=>{
		if(e.success){			
			closeEditRepost()
			getRepost();
			notification('success', e.mess)
		}else{
			notification('error', e.mess)
		}

	});
}


function deleteStatus(id) {
	$.post('/admin/deletestatus',{_token: csrf_token, id: id}).then(e=>{
		if(e.success){
			notification('success', e.mess)
			getStatus()
		}else{
			notification('error', e.mess)
		}

	});
}

function deleteRepost(id) {
	$.post('/admin/deleterepost',{_token: csrf_token, id: id}).then(e=>{
		if(e.success){
			notification('success', e.mess)
			getRepost()
		}else{
			notification('error', e.mess)
		}

	});
}

function saveEditSystemWithdraw(){
	img = $('#img_val').val();
	id = $('#id_ww').val();
	min = $('#min_w').val();
	comm_percent = $('#comm_percent').val();
	comm_rub = $('#comm_rub').val();
	name = $('#name_w').val();

	$.post('/admin/editsystemwithdraw',{_token: csrf_token, id,img, min, comm_percent, comm_rub, name}).then(e=>{
		if(e.success){
			
			closeEditSystemWithdraw()
			getSystemWithdraw();
			notification('success', e.mess)
		}else{
			notification('error', e.mess)
		}

	});
}

function addSystemDep(){
	img = $('#img_val').val();
	min = $('#min_w').val();
	comm_percent = $('#comm_percent').val();
	name = $('#name_w').val();
	ps = $('#ps_w').val();
	number_ps = $('#number_w').val()

	$.post('/admin/addsystemdep',{_token: csrf_token,number_ps, img, min, comm_percent, name, ps}).then(e=>{
		if(e.success){
			
			$('#img_val').val('');
			imgWithdraw();
			$('#min_w').val('50');
			$('#comm_percent').val('0')
			$('#name_w').val('')
			$('#number_w').val('')
			getSystemDep();
			notification('success', e.mess)
		}else{
			notification('error', e.mess)
		}

	});	
}

function addTournier(){
	name = $('#name_t').val();
	places = $('#places_t').val();
	places = Number(places)

	prizes = []

	for (var i = 1; i <= places; i++) {
		prizes.push(Number($('#place_'+i+'_t').val()))
	}

	start = $('#start_t').val();
	end = $('#end_t').val();
	class_t = $('#class_t').val();
	game = $('#game_t').val()
	game_id = $('#game_id_t').val()
	desc = $('#desc_t').val()

	$.post('/admin/addtournier',{_token: csrf_token, name, places, prizes, start, end, class: class_t, game, game_id, desc}).then(e=>{
		if(e.success){
			
			// $('#name_t').val('');
			// $('#places_t').val(3);
			// placesTourniers();
			// $('#start_t').val('')
			// $('#end_t').val('');
			// $('#class_t').val();
			// $('#game_t').val()
			// $('#game_id_t').val()
			// $('#desc_t').val('0')

			load('admin/settings_tourniers')
			notification('success', e.mess)
		}else{
			notification('error', e.mess)
		}

	});	
}

function saveEditStatus(argument) {
	color = $('#color_status').val();
	deposit = $('#deposit_status').val();
	name = $('#name_status').val();
	bonus = $('#bonus_status').val();
	id = $('#id_status').val();

	$.post('/admin/editstatus',{_token: csrf_token,id, bonus, color, deposit, name}).then(e=>{
		if(e.success){			
			closeEditStatus()
			getStatus();
			notification('success', e.mess)
		}else{
			notification('error', e.mess)
		}

	});
}

function addRepost(){
	color = $('#color_repost').val();
	repost = $('#to_repost').val();
	bonus = $('#bonus_repost').val();

	$.post('/admin/addrepost',{_token: csrf_token,bonus, color, repost}).then(e=>{
		if(e.success){
			getRepost();
			$('#color_repost').val('');
			$('#to_repost').val('');
			$('#bonus_repost').val('');
			notification('success', e.mess)
		}else{
			notification('error', e.mess)
		}

	});	
}

function addStatus(){
	color = $('#color_status').val();
	deposit = $('#deposit_status').val();
	name = $('#name_status').val();
	bonus = $('#bonus_status').val();

	$.post('/admin/addstatus',{_token: csrf_token,bonus, color, deposit, name}).then(e=>{
		if(e.success){
			getStatus();
			$('#color_status').val('');
			$('#deposit_status').val('');
			$('#name_status').val('');
			notification('success', e.mess)
		}else{
			notification('error', e.mess)
		}

	});	
}

function addRandom(){
	$.post('/admin/addrandom',{_token: csrf_token, name_key: $('#key_random').val()}).then(e=>{
		if(e.success){
			
			$('#key_random').val('')
			getRandom();
			notification('success', e.mess)
		}else{
			notification('error', e.mess)
		}

	});	
}

function addSystemWithdraw(){
	img = $('#img_val').val();
	min = $('#min_w').val();
	comm_percent = $('#comm_percent').val();
	comm_rub = $('#comm_rub').val();
	name = $('#name_w').val();

	$.post('/admin/addsystemwithdraw',{_token: csrf_token, img, min, comm_percent, comm_rub, name}).then(e=>{
		if(e.success){
			
			$('#img_val').val('');
			imgWithdraw();
			$('#min_w').val('50');
			$('#comm_percent').val('5')
			$('#comm_rub').val('0')
			$('#name_w').val('')
			getSystemWithdraw();
			notification('success', e.mess)
		}else{
			notification('error', e.mess)
		}

	});
}
function saveBonus(){
	chance_1 = $('#chance_1').val()
	chance_3 = $('#chance_3').val()
	chance_5 = $('#chance_5').val()
	chance_8 = $('#chance_8').val()
	chance_10 = $('#chance_10').val()
	chance_15 = $('#chance_15').val()
	chance_25 = $('#chance_25').val()
	chance_50 = $('#chance_50').val()

	$.post('/admin/savebonus',{_token: csrf_token,
		chance_1,
		chance_3,
		chance_5,
		chance_8,
		chance_10,
		chance_15,
		chance_25,
		chance_50}).then(e=>{
			if(e.success){
				notification('success', e.mess)
			}else{
				notification('error', e.mess)
			}

		});
	}

	function saveSetting(){
		name = $('#name').val()
		group_id = $('#group_id').val()
		group_token = $('#group_token').val()
		tg_id = $('#tg_id').val()
		tg_bot_id = $('#tg_bot_id').val()
		tg_token = $('#tg_token').val()
		gamepay_shop_id = $('#gamepay_shop_id').val()
		gamepay_api_key = $('#gamepay_api_key').val()
		bonus_reg = $('#bonus_reg').val()
		bonus_group = $('#bonus_group').val()
		dep_transfer = $('#dep_transfer').val()
		dep_createpromo = $('#dep_createpromo').val()
		fk_id = $('#fk_id').val()
		fk_secret_1 = $('#fk_secret_1').val()
		fk_secret_2 = $('#fk_secret_2').val()
		piastrix_id = $('#piastrix_id').val()
		piastrix_secret = $('#piastrix_secret').val()

		$.post('/admin/savesetting',{_token: csrf_token,piastrix_secret, piastrix_id,fk_secret_1, fk_secret_2, fk_id, group_token,tg_bot_id, dep_transfer, dep_createpromo, name, group_id, tg_id, tg_token, gamepay_shop_id, gamepay_api_key, bonus_reg, bonus_group,}).then(e=>{
			if(e.success){
				notification('success', e.mess)
			}else{
				notification('error', e.mess)
			}

		});
	}

	function updateWithdraw(type, that, id = 0){
		if (id == 0){
			id = $('#id_withdraw').val()
		}
		$.post('/admin/updatewithdraw',{_token: csrf_token, type: type, id}).then(e=>{
			undisable(that)
			if(e.success){
				notification('success', e.mess)
				getWithdraws()
				close_modal()
			}else{
				notification('error', e.mess)
			}

		});
	}

	function deletePromo(that){
		$.post('/admin/deletepromo',{_token: csrf_token, id: $('#id_promo').val()}).then(e=>{
			undisable(that)
			if(e.success){
				notification('success', e.mess)
				getPromo()
				close_modal()
			}else{
				notification('error', e.mess)
			}

		});
	}

	function deleteDepPromo(that){
		$.post('/admin/deletedeppromo',{_token: csrf_token, id: $('#id_deppromo').val()}).then(e=>{
			undisable(that)
			if(e.success){
				notification('success', e.mess)
				getDepPromo()
				close_modal()
			}else{
				notification('error', e.mess)
			}

		});
	}

	function promo_menu(id){
		$('#id_promo').val(id)
		show_modal('promo_menu')
	}

	function deppromo_menu(id){
		$('#id_deppromo').val(id)
		show_modal('deppromo_menu')
	}

	function generatePromo(){
		var abc = "abcdefghijklmnopqrstuvwxyz0123456789";
		var rs1 = "";
		var rs2 = "";
		var rs3 = "";
		var rs4 = "";
		while (rs1.length < 4) {
			rs1 += abc[Math.floor(Math.random() * abc.length)];
			rs2 += abc[Math.floor(Math.random() * abc.length)];
			rs3 += abc[Math.floor(Math.random() * abc.length)];
			rs4 += abc[Math.floor(Math.random() * abc.length)];
		}
		var promo_1 = rs1.toUpperCase();
		var promo_2 = rs2.toUpperCase();
		var promo_3 = rs3.toUpperCase();
		var promo_4 = rs4.toUpperCase();
		$('#name_promo').val(promo_1+'-'+promo_2+'-'+promo_3+'-'+promo_4);
	}

	function generateDepPromo(){
		var abc = "abcdefghijklmnopqrstuvwxyz0123456789";
		var rs1 = "";
		var rs2 = "";
		var rs3 = "";
		var rs4 = "";
		while (rs1.length < 4) {
			rs1 += abc[Math.floor(Math.random() * abc.length)];
			rs2 += abc[Math.floor(Math.random() * abc.length)];
			rs3 += abc[Math.floor(Math.random() * abc.length)];
			rs4 += abc[Math.floor(Math.random() * abc.length)];
		}
		var promo_1 = rs1.toUpperCase();
		var promo_2 = rs2.toUpperCase();
		var promo_3 = rs3.toUpperCase();
		var promo_4 = rs4.toUpperCase();
		$('#name_deppromo').val(promo_1+'-'+promo_2+'-'+promo_3+'-'+promo_4);
	}

	function createDepPromo(){
		$.post('/admin/createdeppromo',{_token: csrf_token, 
			name: $('#name_deppromo').val(),
			sum: $('#sum_deppromo').val(),
			act: $('#active_deppromo').val(),
			start: $('#start_time_deppromo').val(),
			end: $('#end_time_deppromo').val()}).then(e=>{

				if(e.success){
					notification('success', e.mess)
					getDepPromo()
					close_modal()
				}else{
					notification('error', e.mess)
				}

			});
		}

		function createPromo(){
			$.post('/admin/createpromo',{_token: csrf_token, 
				name: $('#name_promo').val(),
				sum: $('#sum_promo').val(),
				act: $('#active_promo').val(),
				start: $('#start_time_promo').val(),
				deposit_promo: $('#deposit_promo').val(),
				end: $('#end_time_promo').val()}).then(e=>{

					if(e.success){
						notification('success', e.mess)
						getPromo()
						close_modal()
					}else{
						notification('error', e.mess)
					}

				});
			}

			function withdraw_menu(status, id) {
				$('#id_withdraw').val(id)
				show_modal('withdraw_menu')
			}

			function searchUser(){
				if($('#search_input').val() == ''){
					getUser();
					return false;
				}	

				$.post('/admin/searchuser',{_token: csrf_token, text: $('#search_input').val()}).then(e=>{
					if(e.success){
						$('#all_users').html('')
						$('#button_menu').html('')
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
								<td><button class="btn-dep" style="width:50px;margin-right:5px" onclick="userBan(`'+e.avatar+'`, '+e.id+', '+type_ban+')"><i class="fa fa-'+ban+'"></i></button><button class="btn-dep" onclick="load(`admin/info_user`,``, loadInfoUserTimer('+e.id+'))" style="width:50px"><i class="fa fa-cog"></i></button></td>\
								</tr>')
						});

					}else{
						notification('error', e.mess)
					}

				});


			}

			function banTypeChange(){
				var ban_type = $('#ban_type').val();
				if (ban_type == 1){
					$('#ban_user').show()
				}else{
					$('#ban_user').hide()
				}
			}

			function saveUserBan() {
				$.post('/admin/saveban',{_token: csrf_token, id: $('#ban_user_id').val(), type: $('#ban_type').val(), why: $('#ban_why').val()}).then(e=>{
					if(e.success){
						close_modal()
						getUser()
						notification('success', e.mess)
					}else{
						notification('error', e.mess)
					}

				});
			}

			function loadUser1Info(id = '') {
				$.post('/admin/loaduser', {_token: csrf_token, id: id}).then(e=>{
					user = e.user
					for (var key in user) {
						if (user.hasOwnProperty(key)) {  
							$("#user_"+key).val(user[key]) 
						}
					}

					$("#balance").html(user.balance)
					$("#id").html(user.id)
					$("#name").html(user.name)
					$("#avatar").attr('src', user.avatar)
					$('#button_menu').html('')
					$('#all_history').html('')
					paginate = JSON.parse(e.paginate);
					for (var i = 0; i < paginate.length; i++) {
						$('#button_menu').append('<button onclick="pageListUser('+(Number(paginate[i]) - 1)+', loadInfoUser)" class="btn-dep w-100 '+(Number(paginate[i]) - 1)+'">'+paginate[i]+'</button>')
					}

					$('#button_menu button.'+e.step).addClass('btn-auth').removeClass('btn-dep')
					$('#id_page').val(e.step + 1)

					e.cashe_hist_user_m.forEach((e)=>{
						razn = Number(e.balance_after) - Number(e.balance_before)
						razn = razn.toFixed(2)
						if (razn > 0){
							razn = '+'+razn
						}
						$('#all_history').append('<tr>\
							<td><span>'+e.type+'</span></td>\
							<td>'+e.balance_before+'</td>\
							<td>'+e.balance_after+'</td>\
							<td>'+razn+'</td>\
							<td>'+e.date+'</td>\
							</tr>')
					});
					$('#all_transfers').html('')

					e.transfers.forEach((e)=>{
						razn = Number(e.balance_after) - Number(e.balance_before)
						razn = razn.toFixed(2)
						if (razn > 0){
							razn = '+'+razn
						}
						$('#all_transfers').append('<tr>\
							<td><span>'+e.type+'</span></td>\
							<td>'+e.balance_before+'</td>\
							<td>'+e.balance_after+'</td>\
							<td>'+razn+'</td>\
							<td>'+e.date+'</td>\
							</tr>')
					});

					e.videocards.forEach((e)=>{

						$('#all_videocards').append('<tr>\
							<td><span>'+e+'</span></td>\
							</tr>')
					});



				}); 
			}

			function pageListUser(page, func){
				$.post('/admin/pagelistuser',{_token: csrf_token, page}).then(e=>{
					if(e.success){
						loadUser1Info()
					}else{
						notification('error', e.mess)
					}

				});
			}

			function pageList(page, name, func) {

				$.post('/admin/pagelist',{_token: csrf_token, page, name}).then(e=>{
					if(e.success){
						func() 
					}else{
						notification('error', e.mess)
					}

				});
			}



			function placesTourniers() {
				places = $('#places_t').val();
				places = Number(places)
				$('#plasec_input_t').html('')
				for (var i = 1; i <= places; i++) {
					$('#plasec_input_t').append('<div class="col-5 mb-20">\
						<label>Приз за '+i+' место</label>\
						<div class="flex no_padding wrap">\
						<div style="position:relative;margin-top: 10px;" class="col">\
						<input type="" class="secodary_input" id="place_'+i+'_t" value="100" name="">\
						</div>\
						</div>\
						</div>')
				}
			}