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
                    <div class="col-lg mb-2">
                        <label>Название</label>
                        <input type="" id="name" class="form-control" name="">
                    </div>
                    <div class="col-lg mb-2">
                        <label>Мин. сумма</label>
                        <input type="" id="min_sum" class="form-control" name="">
                    </div>
                    <div class="col-lg mb-2">
                        <label>Комиссия %</label>
                        <input type="" id="comm_percent" class="form-control" name="">
                    </div>
                    <div class="col-lg mb-2">
                        <label>Комиссия руб</label>
                        <input type="" id="comm_rub" class="form-control" name="">
                    </div>
                    <div class="col-lg mb-2">
                        <label>Изображение</label>
                        <input type="" id="img" class="form-control" name="">
                    </div>
                    <div class="col-lg mb-2">
                        <label>Цвет</label>
                        <input type="color" class="form-control form-control-color" id="color" style="width:100%;max-width:100%" name="">
                    </div>
                    
                    <div class="col-lg mb-2">
                        <label>Действие</label>
                        <button onclick="addSystemWithdraw()" class="btn btn-info btn-block w-100">Добавить</button>
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
                                <th scope="col">Комиссия %</th>
                                <th scope="col">Комиссия руб</th>
                                <th scope="col">Изображение</th>
                                <th scope="col">Цвет</th>
                                <th scope="col">Статус</th>
                                <th scope="col">Действие</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['systems_withdraw'] as $s)
                            
                            <tr id="systemWithdraw_{{$s->id}}">
                                <th><input type="" class="form-control systemWithdraw_name" name="" value="{{$s->name}}"></th>
                                <th><input type="" class="form-control systemWithdraw_min_sum" name="" value="{{$s->min_sum}}"></th>
                                <th><input type="" class="form-control systemWithdraw_comm_percent" name="" value="{{$s->comm_percent}}"></th>
                                <th><input type="" class="form-control systemWithdraw_comm_rub" name="" value="{{$s->comm_rub}}"></th>
                                <th style="display: flex;"><input type="" class="form-control systemWithdraw_img" name="" value="{{$s->img}}"> <img src="{{$s->img}}" style="height:30px;" class="ms-3"></th>
                                <th><input type="color" class="form-control form-control-color systemWithdraw_color" name="" value="{{$s->color}}"></th>
                                
                                
                                <th style="width:100px">
                                    <select class="form-select systemWithdraw_off">
                                        <option value="0" @if($s->off == 0) selected="selected" @endif>On</option>
                                        <option value="1" @if($s->off == 1) selected="selected" @endif>Off</option>
                                    </select>
                                </th>
                                
                                <th scope="col"><button onclick="saveSystemWithdraw({{$s->id}})" class="btn btn-info btn-sm me-2 mb-2">Сохранить</button><button onclick="deleteSystemWithdraw({{$s->id}})" class="btn btn-danger btn-sm">Удалить</button></th>
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
