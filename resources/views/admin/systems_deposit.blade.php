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
                <div class="row">
                    <div class="col-lg-2 mb-2">
                        <label>Название</label>
                        <input type="" id="name" class="form-control" name="">
                    </div>
                    <div class="col-lg-2 mb-2">
                        <label>Мин. сумма</label>
                        <input type="" id="min_sum" class="form-control" name="">
                    </div>
                    <div class="col-lg-2 mb-2">
                        <label>Комиссия</label>
                        <input type="" id="comm_percent" class="form-control" name="">
                    </div>
                    <div class="col-lg-2 mb-2">
                        <label>Изображение</label>
                        <input type="" id="img" class="form-control" name="">
                    </div>
                    <div class="col-lg-2 mb-2">
                        <label>Цвет</label>
                        <input type="color" class="form-control form-control-color" id="color" style="width:100%;max-width:100%" name="">
                    </div>
                    <div class="col-lg-2 mb-2">
                        <label>Cистема</label>
                        <select id="ps" class="form-select">
                            <option value="1">FreeKassa</option>
                            <option value="2">Piastrix</option>
                            <option value="3">Primepayments</option>
                            <option value="4">Linepay</option>
                            <option value="5">Paypaylych</option>
                            <option value="6">AezaPay</option>
                        </select>
                    </div>
                    <div class="col-lg-2 mb-2">
                        <label>Номер системы</label>
                        <input type="" id="number_ps" class="form-control" name="">
                    </div>
                    <div class="col-lg-2 mb-2">
                        <label>Действие</label>
                        <button onclick="addSystemDeposit()" class="btn btn-info btn-block w-100">Добавить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table "  style="margin-bottom: 20px;"> 

                        <thead>
                            <tr>
                                <th scope="col">Название</th>
                                <th scope="col">Мин. сумма</th>
                                <th scope="col">Комиссия</th>
                                <th scope="col">Изображение</th>
                                <th scope="col">Цвет</th>
                                <th scope="col">Cистема</th>
                                <th scope="col">Номер системы</th>
                                <th scope="col">Статус</th>
                                <th scope="col">Сорт</th>
                                <th scope="col">Действие</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['systems_deposit'] as $s)
                            
                            <tr id="systemDeposit_{{$s->id}}" class="systemSort_{{$s->sort}}">
                                <th><input type="" class="form-control systemDeposit_name" name="" value="{{$s->name}}"></th>
                                <th><input type="" class="form-control systemDeposit_min_sum" name="" value="{{$s->min_sum}}"></th>
                                <th><input type="" class="form-control systemDeposit_comm_percent" name="" value="{{$s->comm_percent}}"></th>
                                <th style="display: flex;"><input type="" class="form-control systemDeposit_img" name="" value="{{$s->img}}"> <img src="{{$s->img}}" style="height:30px;" class="ms-3"></th>
                                <th><input type="color" class="form-control form-control-color systemDeposit_color" name="" value="{{$s->color}}"></th>
                                <th>
                                    <select class="form-select systemDeposit_ps">
                                        <option value="1" @if($s->ps == 1) selected="selected" @endif>FreeKassa</option>
                                        <option value="2" @if($s->ps == 2) selected="selected" @endif>Piastrix</option>
                                        <option value="3" @if($s->ps == 3) selected="selected" @endif>Primepayments</option>
                                        <option value="4" @if($s->ps == 4) selected="selected" @endif>Linepay</option>
                                        <option value="5" @if($s->ps == 5) selected="selected" @endif>Paypaylych</option>
                                        <option value="6" @if($s->ps == 6) selected="selected" @endif>AezaPay</option>
                                    </select>
                                </th>
                                <th ><input type="" class="form-control systemDeposit_number_ps" name="" value="{{$s->number_ps}}"></th>
                                <th style="width:100px">
                                    <select class="form-select systemDeposit_off">
                                        <option value="0" @if($s->off == 0) selected="selected" @endif>On</option>
                                        <option value="1" @if($s->off == 1) selected="selected" @endif>Off</option>
                                    </select>
                                </th>
                                <th style="width:100px">
                                    <input type="" class="form-control systemDeposit_sort" name="" value="{{$s->sort}}">
                                </th>
                                
                                <th scope="col"><button onclick="saveSystemDeposit({{$s->id}})" class="btn btn-info btn-sm me-2 mb-2">Сохранить</button><button onclick="deleteSystemDeposit({{$s->id}})" class="btn btn-danger btn-sm">Удалить</button></th>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>                   

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
