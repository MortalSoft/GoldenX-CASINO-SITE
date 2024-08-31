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

@php

$bank_diceGame = round(\Cache::get('diceGame.bank'), 2) ?? 200;
$profit_diceGame = round(\Cache::get('diceGame.profit'), 2) ?? 0;

$bank_minesGame = round(\Cache::get('minesGame.bank'), 2) ?? 200;
$profit_minesGame = round(\Cache::get('minesGame.profit'), 2) ?? 0;

$bank_coinGame = round(\Cache::get('coinGame.bank'), 2) ?? 200;
$profit_coinGame = round(\Cache::get('coinGame.profit'), 2) ?? 0;

@endphp 


<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h3>Настройки антиминуса</h3>
                <div class="row">
                    <div class="col-lg-3 mb-3">
                        <label>Банк режима DICE</label>
                        <input type="" class="form-control" readonly id="dice_bank" value="{{$bank_diceGame}}" name="">
                    </div>
                    <div class="col-lg-3 mb-3">
                        <label>Заработок сайта с режима DICE</label>
                        <input type="" class="form-control" readonly id="dice_profit" value="{{$profit_diceGame}}" name="">
                    </div>
                    <div class="col-lg">
                        <label>Действие</label>
                        <button onclick="resetBank('dice')" class="btn btn-info btn-block w-100">Сбросить</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3 mb-3">
                        <label>Банк режима MINES</label>
                        <input type="" class="form-control" readonly id="mines_bank" value="{{$bank_minesGame}}" name="">
                    </div>
                    <div class="col-lg-3 mb-3">
                        <label>Заработок сайта с режима MINES</label>
                        <input type="" class="form-control" readonly id="mines_profit" value="{{$profit_minesGame}}" name="">
                    </div>
                    <div class="col-lg">
                        <label>Действие</label>
                        <button onclick="resetBank('mines')" class="btn btn-info btn-block w-100">Сбросить</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3 mb-3">
                        <label>Банк режима COIN FLIP</label>
                        <input type="" class="form-control" readonly id="coin_bank" value="{{$bank_coinGame}}" name="">
                    </div>
                    <div class="col-lg-3 mb-3">
                        <label>Заработок сайта с режима COIN FLIP</label>
                        <input type="" class="form-control" readonly id="coin_profit" value="{{$profit_coinGame}}" name="">
                    </div>
                    <div class="col-lg">
                        <label>Действие</label>
                        <button onclick="resetBank('coin')" class="btn btn-info btn-block w-100">Сбросить</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3 mb-3">
                        <label>Банк режима CRAZY SHOOT</label>
                        <input type="" class="form-control" readonly id="shoot_bank" value="{{$setting->shoot_bank}}" name="">
                    </div>
                    <div class="col-lg-3 mb-3">
                        <label>Заработок сайта с режима CRAZY SHOOT</label>
                        <input type="" class="form-control" readonly id="shoot_profit" value="{{$setting->shoot_profit}}" name="">
                    </div>
                    <div class="col-lg">
                        <label>Действие</label>
                        <button onclick="resetBank('shoot')" class="btn btn-info btn-block w-100">Сбросить</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3 mb-3">
                        <label>Банк режима X30 и X100</label>
                        <input type="" class="form-control" readonly id="wheel_bank" value="{{$setting->wheel_bank}}" name="">
                    </div>
                    <div class="col-lg-3 mb-3">
                        <label>Заработок сайта с режима X30 и X100</label>
                        <input type="" class="form-control" readonly id="wheel_profit" value="{{$setting->wheel_profit}}" name="">
                    </div>
                    <div class="col-lg">
                        <label>Действие</label>
                        <button onclick="resetBank('wheel')" class="btn btn-info btn-block w-100">Сбросить</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3 mb-3">
                        <label>Банк режима CRASH</label>
                        <input type="" class="form-control" readonly id="crash_bank" value="{{$setting->crash_bank}}" name="">
                    </div>
                    <div class="col-lg-3 mb-3">
                        <label>Заработок сайта с режима CRASH</label>
                        <input type="" class="form-control" readonly id="crash_profit" value="{{$setting->crash_profit}}" name="">
                    </div>
                    <div class="col-lg">
                        <label>Действие</label>
                        <button onclick="resetBank('crash')" class="btn btn-info btn-block w-100">Сбросить</button>
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
