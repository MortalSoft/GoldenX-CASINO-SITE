 @extends('admin.layouts.master')

@section('title') @lang('translation.Dashboards') @endsection

@section('content')

@component('admin.components.breadcrumb')
@slot('li_1') Dashboards @endslot
@slot('title') Dashboard @endslot
@endcomponent



<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-body">

				<div class="table-responsive">
					<table class="table "  style="margin-bottom: 20px;"> 

						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Пользователь</th>
								<th scope="col">Система</th>
								<th scope="col">Сумма</th>
								<th scope="col">Кошелек</th>
								<th scope="col">Дата</th>
								@if($data['dop'] == 0)
								<th scope="col">Действия</th>
								@endif
							</tr>
						</thead>
						<tbody>
							@foreach($data['withdraws'] as $w)
							@php
								$u = \App\User::where('id', $w->user_id)->first();
							@endphp
							<tr>
								<th scope="row">{{$w->id}}</th>
								<td><img src="{{$u->avatar}}" style="width:30px;height:30px;border-radius: 100%" class="me-3"><a href="/admin/user/{{$u->id}}" target="_blank" @if($u->admin == 1) class="text-danger" @endif>{{$u->name}}</a></td>
								<th scope="row">{{$w->ps}}</th>
								<td>{{number_format($w->sum, 2, ',', ' ')}}</td>
								<th scope="row">{{$w->wallet}}</th>
								<td>{{date('d.m.y в H:i:s', strtotime($w->created_at))}}</td>
								@if($data['dop'] == 0)
								<th scope="col"><button onclick="changeWithdraw({{$w->id}}, 1)" class="btn btn-info btn-sm me-2">Вывести</button><button onclick="changeWithdraw({{$w->id}}, 2)" class="btn btn-danger btn-sm">Отменить</button></th>
								@endif
							</tr>
							@endforeach

						</tbody>
					</table>

					<div style="margin-bottom: 5px;">
						{{ $data['withdraws']->links() }}
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
