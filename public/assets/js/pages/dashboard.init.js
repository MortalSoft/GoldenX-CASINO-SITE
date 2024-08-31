
var csrf_token = $('meta[name="csrf-token"]').attr('content')
var chart = {
  height: 350,
  type: 'area',
  toolbar: {
    show: false
  },
  zoom: {
    type: 'x',
    enabled: false,
    autoScaleYaxis: true
  },
}
var dataLabels = {
  enabled: false
}
var stroke = {
  curve: 'smooth',
  width: 2
}
var markers = {
  size: 3,
  strokeWidth: 3,
  hover: {
    size: 4,
    sizeOffset: 2
  }
}
var yaxis = {
  low: 0,
  offsetX: 0,
  offsetY: 0,
  show: true,
  labels: {
    low: 0,
    offsetX: 0,
    show: true,
  },
  axisBorder: {
    low: 0,
    offsetX: 0,
    show: true,
  },
}
var grid = {
  row: {
    colors: ['transparent', 'transparent'], opacity: .2
  },
  borderColor: 'rgba(0,0,0,0.05)'
}
var colors = ['#556ee6', '#f1b44c']
var fill = {
  type: 'gradient',
  gradient: {
    shadeIntensity: 1,
    inverseColors: false,
    opacityFrom: 0.45,
    opacityTo: 0.05,
    stops: [20, 100, 100, 100]
  }
}
var legend = {
  show: false,
}
var tooltip = {
  x: {
    format: 'dd.MM.yy HH:mm'
  },
}

var axisBorder = {
  show: true, 
  color: 'rgba(0,0,0,0.05)'
}
var axisTicks = {
  show: true, 
  color: 'rgba(0,0,0,0.05)'
}

function  statUpdate(id, that) {
  $.post('/admin/chart',{_token: csrf_token, id}).then(e=>{

    $('#deposits').html(parseFloat(e.deps_n).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")+' ₽')
    $('#withdraws').html(parseFloat(e.withdraws_n).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")+' ₽')
    $('#profit').html(parseFloat(e.profit_n).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")+' ₽')

    $('.stat-pills .nav-link').removeClass('active')
    $(that).addClass('active')
    $('#chart1').remove()
    $('#chart2').remove()
    $('.chartAdmin1').append('<div id="chart1" class="apex-charts" dir="ltr"></div>')
    $('.chartAdmin2').append('<div id="chart2" class="apex-charts" dir="ltr"></div>')

    var options = {

      markers, yaxis, grid, colors, fill, legend, tooltip, chart, dataLabels, stroke,

      series: [{
        name: 'Депозиты',
        data: e.deps
      }, {
        name: 'Выводы',
        data: e.withdraws
      }],
      xaxis: {
        type: 'datetime', axisBorder, axisTicks,
        categories: e.labels                
      },

    };

    var chart_render = new ApexCharts(
      document.querySelector("#chart1"),
      options
      );
    chart_render.render();

    var options = {

      markers, yaxis, grid, colors, fill, legend, tooltip, chart, dataLabels, stroke,

      series: [{
        name: 'Профит',
        data: e.profit
      }],
      xaxis: {
        type: 'datetime', axisBorder, axisTicks,
        categories: e.labels                
      },

    }; 

    var chart_render = new ApexCharts(
      document.querySelector("#chart2"),
      options
      );
    chart_render.render();

  }).fail(e=>{
    noty('error', JSON.parse(e.responseText).message)
  });
}

function noty(type, msg) {
  alert(msg)
}

function saveUser(id) {
  $.post('/admin/saveUser',{_token: csrf_token, id, balance: $('#balance').val(), demo_balance: $('#demo_balance').val(), admin: $('#admin').val()}).then(e=>{
    noty('success', 'Успешно')
    $('#balance_2').val($('#balance').val())
  }).fail(e=>{
    noty('error', JSON.parse(e.responseText).message)
  });
}

function changeBan(id, type) {
  $.post('/admin/changeBan',{_token: csrf_token, id, type}).then(e=>{
    location.href = ''
  }).fail(e=>{
    noty('error', JSON.parse(e.responseText).message)
  });
}

function deleteUser(id){
  $.post('/admin/deleteUser',{_token: csrf_token, id}).then(e=>{
    location.href = '/admin/users'
  }).fail(e=>{
    noty('error', JSON.parse(e.responseText).message)
  });
}

function changePay(id) {
  $.post('/admin/changePay',{_token: csrf_token, id}).then(e=>{
    location.href = ''
  }).fail(e=>{
    noty('error', JSON.parse(e.responseText).message)
  });
}

function changeWithdraw(id, status) {
  $.post('/admin/changeWithdraw',{_token: csrf_token, id, status}).then(e=>{
    if(e.success == false) return noty('error', e.mess);
    location.href = ''
  }).fail(e=>{
    noty('error', JSON.parse(e.responseText).message)
  });
} 

function saveSystemWithdraw(id){
  name = $('#systemWithdraw_'+id+' .systemWithdraw_name').val()
  min_sum = $('#systemWithdraw_'+id+' .systemWithdraw_min_sum').val()
  comm_percent = $('#systemWithdraw_'+id+' .systemWithdraw_comm_percent').val()
  comm_rub = $('#systemWithdraw_'+id+' .systemWithdraw_comm_rub').val()
  img = $('#systemWithdraw_'+id+' .systemWithdraw_img').val()
  off = $('#systemWithdraw_'+id+' .systemWithdraw_off').val()
  color = $('#systemWithdraw_'+id+' .systemWithdraw_color').val()

  $.post('/admin/saveSystemWithdraw',{_token: csrf_token, id, name, min_sum, comm_percent, comm_rub, img, off, color}).then(e=>{
    noty('success', 'Успешно')
  }).fail(e=>{
    noty('error', JSON.parse(e.responseText).message)
  });
}

function addSystemWithdraw(){
  name = $('#name').val()
  min_sum = $('#min_sum').val()
  comm_percent = $('#comm_percent').val()
  img = $('#img').val()
  comm_rub = $('#comm_rub').val()
  color = $('#color').val()

  $.post('/admin/addSystemWithdraw',{_token: csrf_token, name, min_sum, comm_percent, img, comm_rub, color}).then(e=>{
    location.href = ''
  }).fail(e=>{
    noty('error', JSON.parse(e.responseText).message)
  });
}

function deleteSystemWithdraw(id) {
  $.post('/admin/deleteSystemWithdraw',{_token: csrf_token, id}).then(e=>{
    location.href = ''
  }).fail(e=>{
    noty('error', JSON.parse(e.responseText).message)
  });
}


function saveSystemDeposit(id){
  name = $('#systemDeposit_'+id+' .systemDeposit_name').val()
  min_sum = $('#systemDeposit_'+id+' .systemDeposit_min_sum').val()
  comm_percent = $('#systemDeposit_'+id+' .systemDeposit_comm_percent').val()
  img = $('#systemDeposit_'+id+' .systemDeposit_img').val()
  ps = $('#systemDeposit_'+id+' .systemDeposit_ps').val()
  number_ps = $('#systemDeposit_'+id+' .systemDeposit_number_ps').val()
  off = $('#systemDeposit_'+id+' .systemDeposit_off').val()
  color = $('#systemDeposit_'+id+' .systemDeposit_color').val()
  sort = $('#systemDeposit_'+id+' .systemDeposit_sort').val()

  $.post('/admin/saveSystemDeposit',{_token: csrf_token, id, name, min_sum, comm_percent, img, ps, number_ps, off, color, sort}).then(e=>{
    noty('success', 'Успешно')
  }).fail(e=>{
    noty('error', JSON.parse(e.responseText).message)
  });
}

function addSystemDeposit(){
  name = $('#name').val()
  min_sum = $('#min_sum').val()
  comm_percent = $('#comm_percent').val()
  img = $('#img').val()
  ps = $('#ps').val()
  number_ps = $('#number_ps').val()
  color = $('#color').val()

  $.post('/admin/addSystemDeposit',{_token: csrf_token, name, min_sum, comm_percent, img, ps, number_ps, color}).then(e=>{
    location.href = ''
  }).fail(e=>{
    noty('error', JSON.parse(e.responseText).message)
  });
}

function deleteSystemDeposit(id) {
  $.post('/admin/deleteSystemDeposit',{_token: csrf_token, id}).then(e=>{
    location.href = ''
  }).fail(e=>{
    noty('error', JSON.parse(e.responseText).message)
  });
} 


function createPromo() {
  $.post('/admin/createPromo',{_token: csrf_token, name: $('#name_promo').val(), sum: $("#sum_promo").val(), active: $("#active_promo").val()}).then(e=>{
    location.href = ''
  }).fail(e=>{
    noty('error', JSON.parse(e.responseText).message)
  });
}

function deletePromo(id){
  $.post('/admin/deletePromo',{_token: csrf_token, id}).then(e=>{
    location.href = ''
  }).fail(e=>{
    noty('error', JSON.parse(e.responseText).message)
  });
}

function createDepPromo() {
  $.post('/admin/createDepPromo',{_token: csrf_token, name: $('#name_promo').val(), percent: $("#percent_promo").val(), active: $("#active_promo").val()}).then(e=>{
    location.href = ''
  }).fail(e=>{
    noty('error', JSON.parse(e.responseText).message)
  });
}

function deleteDepPromo(id){
  $.post('/admin/deleteDepPromo',{_token: csrf_token, id}).then(e=>{
    location.href = ''
  }).fail(e=>{
    noty('error', JSON.parse(e.responseText).message)
  });
}

function saveSetting(type){
  param = {_token: csrf_token, type}

  if(type == 1){
    param = {_token: csrf_token, type,
      name: $('#name').val(),
      group_id: $('#group_id').val(),
      group_token: $('#group_token').val(),
      tg_id: $('#tg_id').val(),
      tg_bot_id: $('#tg_bot_id').val(),
      tg_token: $('#tg_token').val(),
      bonus_reg: $('#bonus_reg').val(),
      bonus_group: $('#bonus_group').val(),
      dep_transfer: $('#dep_transfer').val(),
      dep_createpromo: $('#dep_createpromo').val(),
      meta_tags: $('#meta_tags').val(),
      max_withdraw_bonus: $("#max_withdraw_bonus").val(),
      theme: $("#theme").val()}
  }

  if(type == 2){
    param = {_token: csrf_token, type,
      fk_id: $('#fk_id').val(),
      fk_secret_1: $('#fk_secret_1').val(),
      fk_secret_2: $('#fk_secret_2').val()}
  }

  if(type == 3){
    param = {_token: csrf_token, type,
      piastrix_id: $('#piastrix_id').val(),
      piastrix_secret: $('#piastrix_secret').val()}
  }

  if(type == 4){
    param = {_token: csrf_token, type,
      prime_id: $('#prime_id').val(),
      prime_secret_1: $('#prime_secret_1').val(),
      prime_secret_2: $('#prime_secret_2').val()}
  }

  if(type == 5){
    param = {_token: csrf_token, type,
      linepay_id: $('#linepay_id').val(),
      linepay_secret_1: $('#linepay_secret_1').val(),
      linepay_secret_2: $('#linepay_secret_2').val()}
  }

  if(type == 6){
    param = {_token: csrf_token, type,
      paypaylych_id: $('#paypaylych_id').val(),
      paypaylych_token: $('#paypaylych_token').val()}
  }

  if(type == 7){
    param = {_token: csrf_token, type,
      aezapay_id: $('#aezapay_id').val(),
      aezapay_token: $('#aezapay_token').val()}
  }
  
  $.post('/admin/saveSetting',param).then(e=>{
    noty('success', 'Успешно')
  }).fail(e=>{
    noty('error', JSON.parse(e.responseText).message)
  });
}

function resetBank(type){
  $.post('/admin/resetBank',{_token: csrf_token, type}).then(e=>{
    if(e.success){
      noty('success', e.mess)
      $('#'+type+'_bank').val(200)
      $('#'+type+'_profit').val(0)
    }else{
      noty('error', e.mess)
    }

  });
}

function placesTourniers() {
        places = $('#places_t').val();
        places = Number(places)
        $('#places_input_t').html('')
        for (var i = 1; i <= places; i++) {
          $('#places_input_t').append('<div class="col-lg-3 mb-3">\
                <label>Приз за '+i+' место</label>\
                <input type="" id="place_'+i+'_t" value="100" class="form-control" name="">\
              </div>\
              ')
        }
}



function createTournier(){
  name = $('#name_t').val();
  places = $('#places_t').val();
  places = Number(places)

  prizes = []

  for (var i = 1; i <= places; i++) {
    prizes.push(Number($('#place_'+i+'_t').val()))
  }

  start = $('#start_t').val();
  end = $('#end_t').val();
  game_id = $('#game_t').val();
  desc = $('#desc_t').val();

  $.post('/admin/createTournier',{_token: csrf_token, name, places, prizes, start, end, game_id, desc}).then(e=>{
    if(e.success){
      location.href = ''
    }else{
      notification('error', e.mess)
    }

  }); 
}

// function systemUP(system_id, sort){
//   if (sort == 1){
//     return true;
//   }

//   upper_element =  $('.systemSort_'+sort)
//   downer_element =  $('.systemSort_'+(sort - 1))
// }