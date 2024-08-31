 @extends('admin.layouts.master')

@section('title') @lang('translation.Dashboards') @endsection

@section('content')

@component('admin.components.breadcrumb')
@slot('li_1') Dashboards @endslot
@slot('title') Dashboard @endslot
@endcomponent

@php
$setting = \App\Setting::first();
@endphp



<div class="row">
	
	<div class="col-sm-12">
		<div class="card">
			<div class="card-body">
				<h3>Настройки сайта</h3>
				<div class="row">
					<div class="col-lg-3 mb-3">
						<label>Название сайта</label>
						<input type="" class="form-control" id="name" value="{{$setting->name}}" name="">
					</div>
					<div class="col-lg-3 mb-3">
						<label>Айди группы вк</label>
						<input type="" class="form-control" id="group_id" value="{{$setting->group_id}}" name="">
					</div>
					<div class="col-lg-3 mb-3">
						<label>Токен группы вк</label>
						<input type="" class="form-control" id="group_token" value="{{$setting->group_token}}" name="">
					</div>
					<div class="col-lg-3 mb-3">
						<label>Канал тг</label>
						<input type="" class="form-control" id="tg_id" value="{{$setting->tg_id}}" name="">
					</div>
					<div class="col-lg-3 mb-3">
						<label>Бот тг</label>
						<input type="" class="form-control" id="tg_bot_id" value="{{$setting->tg_bot_id}}" name="">
					</div>
					<div class="col-lg-3 mb-3" >
						<label>Токен бота тг</label>
						<input type="" class="form-control" id="tg_token" value="{{$setting->tg_token}}" name="">
					</div>
					<div class="col-lg-3 mb-3">
						<label>Бонус за регистрацию</label>
						<input type="" class="form-control" id="bonus_reg" value="{{$setting->bonus_reg}}" name="">
					</div>
					<div class="col-lg-3 mb-3">
						<label>Бонус за подписку на группу ВК и ТГ</label>
						<input type="" class="form-control" id="bonus_group" value="{{$setting->bonus_group}}" name="">
					</div>
					<div class="col-lg-3 mb-3">
						<label>Максимальный вывод с бонуса</label>
						<input type="" class="form-control" id="max_withdraw_bonus" value="{{$setting->max_withdraw_bonus}}" name="">
					</div>
					<div class="col-lg-3 mb-3">
						<label>Депозит для перевода средств</label>
						<input type="" class="form-control" id="dep_transfer" value="{{$setting->dep_transfer}}" name="">
					</div>
					<div class="col-lg-3 mb-3">
						<label>Депозит для создания промокода</label>
						<input type="" class="form-control" id="dep_createpromo" value="{{$setting->dep_createpromo}}" name="">
					</div>
					<div class="col-lg-3 mb-3">
						<label>Тема сайта</label>
						<select class="form-select" id="theme">
                            <option value="0" @if($setting->theme == 0) selected="selected" @endif>Обычная</option>
                            <option value="1" @if($setting->theme == 1) selected="selected" @endif>Новогодняя</option>
                        </select>
						
					</div>
					<div class="col-lg-6 mb-3">
						<label>Мета-теги</label>
						<textarea type="" class="form-control" id="meta_tags" name="">{{$setting->meta_tags}}</textarea>
					</div>
					<div class="col-lg">
						<label>Действие</label>
						<button onclick="saveSetting(1)" class="btn btn-info btn-block w-100">Сохранить</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-sm-12">
		<div class="card">
			<div class="card-body">
				<h3>Настройки платежной системы FreeKassa</h3>
				<div class="row">
					<div class="col-lg-3 mb-3">
						<label>FK ID</label>
						<input type="" class="form-control" id="fk_id" value="{{$setting->fk_id}}" name="">
					</div>
					<div class="col-lg-3 mb-3">
						<label>FK SECRET 1</label>
						<input type="" class="form-control" id="fk_secret_1" value="{{$setting->fk_secret_1}}" name="">
					</div>
					<div class="col-lg-3 mb-3">
						<label>FK SECRET 2</label>
						<input type="" class="form-control" id="fk_secret_2" value="{{$setting->fk_secret_2}}" name="">
					</div>
					<div class="col-lg">
						<label>Действие</label>
						<button onclick="saveSetting(2)" class="btn btn-info btn-block w-100">Сохранить</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-sm-12">
		<div class="card">
			<div class="card-body">
				<h3>Настройки платежной системы Piastrix</h3>
				<div class="row">
					<div class="col-lg-3 mb-3">
						<label>Piastix ID</label>
						<input type="" class="form-control" id="piastrix_id" value="{{$setting->piastrix_id}}" name="">
					</div>
					<div class="col-lg-3 mb-3">
						<label>Piastix SECRET</label>
						<input type="" class="form-control" id="piastrix_secret" value="{{$setting->piastrix_secret}}" name="">
					</div>
					
					<div class="col-lg">
						<label>Действие</label>
						<button onclick="saveSetting(3)" class="btn btn-info btn-block w-100">Сохранить</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-sm-12">
		<div class="card">
			<div class="card-body">
				<h3>Настройки платежной системы Primepayments</h3>
				<div class="row">
					<div class="col-lg-3 mb-3">
						<label>ID проекта</label>
						<input type="" class="form-control" id="prime_id" value="{{$setting->prime_id}}" name="">
					</div>
					<div class="col-lg-3 mb-3">
						<label>SECRET 1</label>
						<input type="" class="form-control" id="prime_secret_1" value="{{$setting->prime_secret_1}}" name="">
					</div>
					<div class="col-lg-3 mb-3">
						<label>SECRET 2</label>
						<input type="" class="form-control" id="prime_secret_2" value="{{$setting->prime_secret_2}}" name="">
					</div>
					<div class="col-lg">
						<label>Действие</label>
						<button onclick="saveSetting(4)" class="btn btn-info btn-block w-100">Сохранить</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-sm-12">
		<div class="card">
			<div class="card-body">
				<h3>Настройки платежной системы Linepay</h3>
				<div class="row">
					<div class="col-lg-3 mb-3">
						<label>ID проекта</label>
						<input type="" class="form-control" id="linepay_id" value="{{$setting->linepay_id}}" name="">
					</div>
					<div class="col-lg-3 mb-3">
						<label>SECRET 1</label>
						<input type="" class="form-control" id="linepay_secret_1" value="{{$setting->linepay_secret_1}}" name="">
					</div>
					<div class="col-lg-3 mb-3">
						<label>SECRET 2</label>
						<input type="" class="form-control" id="linepay_secret_2" value="{{$setting->linepay_secret_2}}" name="">
					</div>
					<div class="col-lg">
						<label>Действие</label>
						<button onclick="saveSetting(5)" class="btn btn-info btn-block w-100">Сохранить</button>
					</div>


				</div>
			</div>
		</div>
	</div>

	<div class="col-sm-12">
		<div class="card">
			<div class="card-body">
				<h3>Настройки платежной системы Paypaylych</h3>
				<div class="row">
					<div class="col-lg-3 mb-3">
						<label>ID проекта</label>
						<input type="" class="form-control" id="paypaylych_id" value="{{$setting->paypaylych_id}}" name="">
					</div>
					<div class="col-lg-3 mb-3">
						<label>Токен</label>
						<input type="" class="form-control" id="paypaylych_token" value="{{$setting->paypaylych_token}}" name="">
					</div>
					<div class="col-lg">
						<label>Действие</label>
						<button onclick="saveSetting(6)" class="btn btn-info btn-block w-100">Сохранить</button>
					</div>


				</div>
			</div>
		</div>
	</div>

	<div class="col-sm-12">
		<div class="card">
			<div class="card-body">
				<h3>Настройки платежной системы AezaPay</h3>
				<div class="row">
					<div class="col-lg-3 mb-3">
						<label>ID проекта</label>
						<input type="" class="form-control" id="aezapay_id" value="{{$setting->aezapay_id}}" name="">
					</div>
					<div class="col-lg-3 mb-3">
						<label>Private Key</label>
						<input type="" class="form-control" id="aezapay_token" value="{{$setting->aezapay_token}}" name="">
					</div>
					<div class="col-lg">
						<label>Действие</label>
						<button onclick="saveSetting(7)" class="btn btn-info btn-block w-100">Сохранить</button>
					</div>


				</div>
			</div>
		</div>
	</div>

</div>


@endsection
@section('script')
<!-- apexcharts -->
<script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

<!-- dashboard init -->
<script src="/assets/js/pages/dashboard.init.js?v={{time()}}"></script>
@endsection
