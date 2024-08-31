/******/ (function() { // webpackBootstrap
/*!**************************************************!*\
  !*** ./resources/js/pages/form-advanced.init.js ***!
  \**************************************************/
/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Form Advanced Js File
*/
!function ($) {
  "use strict";

  var AdvancedForm = function AdvancedForm() {};

  AdvancedForm.prototype.init = function () {
    // Select2
    $(".select2").select2();
    $(".select2-limiting").select2({
      maximumSelectionLength: 2
    });
    $(".select2-search-disable").select2({
      minimumResultsForSearch: Infinity
    });
    $('.select2-ajax').select2({
      ajax: {
        url: "https://api.github.com/search/repositories",
        dataType: 'json',
        delay: 250,
        data: function data(params) {
          return {
            q: params.term,
            // search term
            page: params.page
          };
        },
        processResults: function processResults(data, params) {
          // parse the results into the format expected by Select2
          // since we are using custom formatting functions we do not need to
          // alter the remote JSON data, except to indicate that infinite
          // scrolling can be used
          params.page = params.page || 1;
          return {
            results: data.items,
            pagination: {
              more: params.page * 30 < data.total_count
            }
          };
        },
        cache: true
      },
      placeholder: 'Search for a repository',
      minimumInputLength: 1,
      templateResult: formatRepo,
      templateSelection: formatRepoSelection
    });

    function formatRepo(repo) {
      if (repo.loading) {
        return repo.text;
      }

      var $container = $("<div class='select2-result-repository clearfix'>" + "<div class='select2-result-repository__avatar'><img src='" + repo.owner.avatar_url + "' /></div>" + "<div class='select2-result-repository__meta'>" + "<div class='select2-result-repository__title'></div>" + "<div class='select2-result-repository__description'></div>" + "<div class='select2-result-repository__statistics'>" + "<div class='select2-result-repository__forks'><i class='fa fa-flash'></i> </div>" + "<div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> </div>" + "<div class='select2-result-repository__watchers'><i class='fa fa-eye'></i> </div>" + "</div>" + "</div>" + "</div>");
      $container.find(".select2-result-repository__title").text(repo.full_name);
      $container.find(".select2-result-repository__description").text(repo.description);
      $container.find(".select2-result-repository__forks").append(repo.forks_count + " Forks");
      $container.find(".select2-result-repository__stargazers").append(repo.stargazers_count + " Stars");
      $container.find(".select2-result-repository__watchers").append(repo.watchers_count + " Watchers");
      return $container;
    }

    function formatRepoSelection(repo) {
      return repo.full_name || repo.text;
    }

    function formatState(state) {
      if (!state.id) {
        return state.text;
      }

      var baseUrl = "/assets/images/flags/select2";
      var $state = $('<span><img src="' + baseUrl + '/' + state.element.value.toLowerCase() + '.png" class="img-flag" /> ' + state.text + '</span>');
      return $state;
    }

    ;
    $(".select2-templating").select2({
      templateResult: formatState
    }); //colorpicker start

    $("#colorpicker-default").spectrum();
    $("#colorpicker-showalpha").spectrum({
      showAlpha: true
    });
    $("#colorpicker-showpaletteonly").spectrum({
      showPaletteOnly: true,
      showPalette: true,
      color: '#34c38f',
      palette: [['#556ee6', 'white', '#34c38f', 'rgb(255, 128, 0);', '#50a5f1'], ['red', 'yellow', 'green', 'blue', 'violet']]
    });
    $("#colorpicker-togglepaletteonly").spectrum({
      showPaletteOnly: true,
      togglePaletteOnly: true,
      togglePaletteMoreText: 'more',
      togglePaletteLessText: 'less',
      color: '#556ee6',
      palette: [["#000", "#444", "#666", "#999", "#ccc", "#eee", "#f3f3f3", "#fff"], ["#f00", "#f90", "#ff0", "#0f0", "#0ff", "#00f", "#90f", "#f0f"], ["#f4cccc", "#fce5cd", "#fff2cc", "#d9ead3", "#d0e0e3", "#cfe2f3", "#d9d2e9", "#ead1dc"], ["#ea9999", "#f9cb9c", "#ffe599", "#b6d7a8", "#a2c4c9", "#9fc5e8", "#b4a7d6", "#d5a6bd"], ["#e06666", "#f6b26b", "#ffd966", "#93c47d", "#76a5af", "#6fa8dc", "#8e7cc3", "#c27ba0"], ["#c00", "#e69138", "#f1c232", "#6aa84f", "#45818e", "#3d85c6", "#674ea7", "#a64d79"], ["#900", "#b45f06", "#bf9000", "#38761d", "#134f5c", "#0b5394", "#351c75", "#741b47"], ["#600", "#783f04", "#7f6000", "#274e13", "#0c343d", "#073763", "#20124d", "#4c1130"]]
    });
    $("#colorpicker-showintial").spectrum({
      showInitial: true
    });
    $("#colorpicker-showinput-intial").spectrum({
      showInitial: true,
      showInput: true
    }); // Time Picker

    $('#timepicker').timepicker({
      icons: {
        up: 'mdi mdi-chevron-up',
        down: 'mdi mdi-chevron-down'
      },
      appendWidgetTo: "#timepicker-input-group1"
    });
    $('#timepicker2').timepicker({
      showMeridian: false,
      icons: {
        up: 'mdi mdi-chevron-up',
        down: 'mdi mdi-chevron-down'
      },
      appendWidgetTo: "#timepicker-input-group2"
    });
    $('#timepicker3').timepicker({
      minuteStep: 15,
      icons: {
        up: 'mdi mdi-chevron-up',
        down: 'mdi mdi-chevron-down'
      },
      appendWidgetTo: "#timepicker-input-group3"
    }); //Bootstrap-TouchSpin

    var defaultOptions = {}; // touchspin

    $('[data-toggle="touchspin"]').each(function (idx, obj) {
      var objOptions = $.extend({}, defaultOptions, $(obj).data());
      $(obj).TouchSpin(objOptions);
    });
    $("input[name='demo3_21']").TouchSpin({
      initval: 40,
      buttondown_class: "btn btn-primary",
      buttonup_class: "btn btn-primary"
    });
    $("input[name='demo3_22']").TouchSpin({
      initval: 40,
      buttondown_class: "btn btn-primary",
      buttonup_class: "btn btn-primary"
    });
    $("input[name='demo_vertical']").TouchSpin({
      verticalbuttons: true
    }); //Bootstrap-MaxLength

    $('input#defaultconfig').maxlength({
      warningClass: "badge bg-info",
      limitReachedClass: "badge bg-warning"
    });
    $('input#thresholdconfig').maxlength({
      threshold: 20,
      warningClass: "badge bg-info",
      limitReachedClass: "badge bg-warning"
    });
    $('input#moreoptions').maxlength({
      alwaysShow: true,
      warningClass: "badge bg-success",
      limitReachedClass: "badge bg-danger"
    });
    $('input#alloptions').maxlength({
      alwaysShow: true,
      warningClass: "badge bg-success",
      limitReachedClass: "badge bg-danger",
      separator: ' out of ',
      preText: 'You typed ',
      postText: ' chars available.',
      validate: true
    });
    $('textarea#textarea').maxlength({
      alwaysShow: true,
      warningClass: "badge bg-info",
      limitReachedClass: "badge bg-warning"
    });
    $('input#placement').maxlength({
      alwaysShow: true,
      placement: 'top-left',
      warningClass: "badge bg-info",
      limitReachedClass: "badge bg-warning"
    });
  }, //init
  $.AdvancedForm = new AdvancedForm(), $.AdvancedForm.Constructor = AdvancedForm;
}(window.jQuery), //Datepicker
function ($) {
  "use strict";

  $.AdvancedForm.init();
}(window.jQuery);
$(function () {
  'use strict';

  var $date = $('.docs-date');
  var $container = $('.docs-datepicker-container');
  var $trigger = $('.docs-datepicker-trigger');
  var options = {
    show: function show(e) {
      console.log(e.type, e.namespace);
    },
    hide: function hide(e) {
      console.log(e.type, e.namespace);
    },
    pick: function pick(e) {
      console.log(e.type, e.namespace, e.view);
    }
  };
  $date.on({
    'show.datepicker': function showDatepicker(e) {
      console.log(e.type, e.namespace);
    },
    'hide.datepicker': function hideDatepicker(e) {
      console.log(e.type, e.namespace);
    },
    'pick.datepicker': function pickDatepicker(e) {
      console.log(e.type, e.namespace, e.view);
    }
  }).datepicker(options);
  $('.docs-options, .docs-toggles').on('change', function (e) {
    var target = e.target;
    var $target = $(target);
    var name = $target.attr('name');
    var value = target.type === 'checkbox' ? target.checked : $target.val();
    var $optionContainer;

    switch (name) {
      case 'container':
        if (value) {
          value = $container;
          $container.show();
        } else {
          $container.hide();
        }

        break;

      case 'trigger':
        if (value) {
          value = $trigger;
          $trigger.prop('disabled', false);
        } else {
          $trigger.prop('disabled', true);
        }

        break;

      case 'inline':
        $optionContainer = $('input[name="container"]');

        if (!$optionContainer.prop('checked')) {
          $optionContainer.click();
        }

        break;

      case 'language':
        $('input[name="format"]').val($.fn.datepicker.languages[value].format);
        break;
    }

    options[name] = value;
    $date.datepicker('reset').datepicker('destroy').datepicker(options);
  });
  $('.docs-actions').on('click', 'button', function (e) {
    var data = $(this).data();
    var args = data.arguments || [];
    var result;
    e.stopPropagation();

    if (data.method) {
      if (data.source) {
        $date.datepicker(data.method, $(data.source).val());
      } else {
        result = $date.datepicker(data.method, args[0], args[1], args[2]);

        if (result && data.target) {
          $(data.target).val(result);
        }
      }
    }
  });
});
/******/ })()
;