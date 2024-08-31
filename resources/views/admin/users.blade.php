@php
$users = \App\User::paginate(15);
@endphp

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
                <th scope="col">Имя</th>
                <th scope="col">IP</th>
                <th scope="col">Баланс</th>
                <th scope="col">Депозитов</th>
                <th scope="col">Выводов</th>
                <th scope="col">Дата регистрации</th>
                <th scope="col">Действия</th>
            </tr>
        </thead>
        <tbody>
          @foreach($users as $u)
          @php
          $deps = \App\Payment::where('user_id', $u->id)->where('status', 1)->sum('sum');
          $withdraws = \App\Withdraw::where('user_id', $u->id)->where('status', 1)->sum('sum');
          @endphp
          <tr>
            <th scope="row">{{$u->id}}</th>
            <td><img src="{{$u->avatar}}" style="width:30px;height:30px;border-radius: 100%" class="me-3"><a href="user/{{$u->id}}" target="_blank" @if($u->admin == 1) class="text-danger" @endif>{{$u->name}}</a></td>
            <td>{{$u->ip}}</td>
            <td>{{number_format($u->balance, 2, ',', ' ')}}</td>
            <td>{{number_format($deps, 2, ',', ' ')}}</td>
            <td>{{number_format($withdraws, 2, ',', ' ')}}</td>
            <td>{{date('d.m.y в H:i:s', strtotime($u->created_at))}}</td>
            <td id="btns_bun_id_{{$u->id}}"><a href="user/{{$u->id}}" class="btn btn-primary btn-sm me-2">Перейти</a>@if($u->ban == 1)<button onclick="changeBan({{$u->id}}, 0)" class="btn btn-success btn-sm ">Разблокировать</button>@else<button onclick="changeBan({{$u->id}}, 1)" class="btn btn-danger btn-sm">Заблокировать</button>@endif</td>
        </tr>
        @endforeach

    </tbody>
</table>

<div style="margin-bottom: 5px;">
    {{ $users->links() }}
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
