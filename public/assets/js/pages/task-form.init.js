/******/ (function() { // webpackBootstrap
/*!**********************************************!*\
  !*** ./resources/js/pages/task-form.init.js ***!
  \**********************************************/
/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Task Form Init Js File
*/
var updateid = '';
var selectedstatus = '';
var taskid = '';
var i = 0;
$(document).ready(function () {
  'use strict'; //Task Assign User Validation

  $("#NewtaskForm").validate({
    rules: {
      'member[]': {
        required: true
      }
    },
    errorPlacement: function errorPlacement(error, element) {
      if (element.is(':checkbox')) {
        error.insertAfter('#taskassignee');
      } else {
        error.insertAfter(element);
      }
    }
  }); //Add New Task

  $(".addtask-btn").click(function () {
    var id = $(this).attr('data-id');
    $('#updatetaskdetail').css('display', 'none');
    $('#addtask').css('display', 'block');
    $('.update-task-title').css('display', 'none');
    $('.add-task-title').css('display', 'block');
    $('#taskname').val('');
    $('#taskdesc').val('');
    $('#TaskStatus').val('');
    $('#taskbudget').val('');
    $('#taskassignee input').prop("checked", false);
    taskid = id;
  });
  $("select#TaskStatus").change(function () {
    selectedstatus = $(this).children("option:selected").val();
  }); //Add New Task with Validation

  $("#addtask").click(function () {
    $('#updatetaskdetail').css('display', 'none');
    $('#addtask').css('display', 'block');
    $('.update-task-title').css('display', 'none');
    $('.add-task-title').css('display', 'block');
    var newtaskid = makeid(5);
    var taskname = $("#taskname").val();
    var d = new Date();
    var strDate = d.getDate() + " " + d.toLocaleString('default', {
      month: 'short'
    }) + ", " + d.getFullYear();
    var taskdesc = $("#taskdesc").val();
    var newtaskdesc = '';

    if (taskdesc.length > 0) {
      newtaskdesc = "<ul class='ps-3 mb-4 text-muted' id='task-desc'>" + "<li class='py-1'>" + taskdesc + "</li>" + "</ul>";
    }

    var taskbudget = $("#taskbudget").val();
    var taskassignee = new Array();
    var taskassigneevalue = new Array();
    var src = "";
    $('#taskassignee input[type=checkbox]:checked').each(function () {
      taskassigneevalue.push($(this).attr("id"));
      taskassignee.push($(this).nextAll("img").attr("src"));
    });

    for (i = 0; i < taskassignee.length; i++) {
      src = src + '<div class="avatar-group-item"><a href="#" class="d-inline-block" value="' + taskassigneevalue[i] + '"><img src="' + taskassignee[i] + '" class="rounded-circle avatar-xs m-1" alt=""></a></div>';
    }

    var statuscolor;

    if (selectedstatus == "Waiting") {
      statuscolor = "badge-soft-secondary";
    } else if (selectedstatus == "Approved") {
      statuscolor = "badge-soft-primary";
    } else if (selectedstatus == "Complete") {
      statuscolor = "badge-soft-success";
    } else if (selectedstatus == "Pending") {
      statuscolor = "badge-soft-warning";
    }

    if (taskname.length == 0 || taskbudget.length == 0 || selectedstatus.length == 0 || taskassignee.length == 0) {
      $("#NewtaskForm").validate().element("#taskname");
      $("#NewtaskForm").validate().element("#taskassignee input:checkbox");
      $("#NewtaskForm").validate().element("#TaskStatus");
      $("#NewtaskForm").validate().element("#taskbudget");
    } else {
      $(taskid).append("<div class='card task-box' id='" + newtaskid + "'>" + "<div class='card-body'>" + "<div class='dropdown float-end'>" + "<a href='#' class='dropdown-toggle arrow-none' data-bs-toggle='dropdown' aria-expanded='false'>" + "<i class='mdi mdi-dots-vertical m-0 text-muted h5'></i>" + "</a>" + "<div class='dropdown-menu dropdown-menu-end'>" + "<a class='dropdown-item edittask-details' href='#' data-bs-toggle='modal' data-bs-target='.bs-example-modal-lg' data-id='#" + newtaskid + "'>Edit</a>" + "<a class='dropdown-item deletetask' href='#' data-id='#" + newtaskid + "'>Delete</a>" + "</div>" + "</div>" + "<div class='float-end ml-2'>" + "<span class='badge rounded-pill font-size-12 " + statuscolor + "' id='task-status'>" + selectedstatus + "</span>" + "</div>" + "<div>" + "<h5 class='font-size-15'><a href='javascript: void(0);' class='text-dark' id='task-name'>" + taskname + "</a></h5>" + "<p class='text-muted mb-4' id='task-date'>" + strDate + "</p>" + "</div>" + newtaskdesc + "<div class='avatar-group float-start task-assigne'>" + src + "</div>" + "<div class='text-end'>" + "<h5 class='font-size-15 mb-1' id='task-budget'>$ " + taskbudget + "</h5>" + "<p class='mb-0 text-muted'>Budget</p>" + "</div>" + "</div>" + "</div>");
      $('#modalForm').modal('toggle');
    }
  });
  $('#modalForm').on('hidden.bs.modal', function (e) {
    var validator = $("#NewtaskForm").validate();
    $('#taskname').removeClass('error').next('label.error').remove();
    $('#TaskStatus').removeClass('error').next('label.error').remove();
    $('#taskbudget').removeClass('error').next('label.error').remove();
    validator.resetForm();
  }); //Update Task Details with Validation

  $("#updatetaskdetail").click(function () {
    var statuscolor;

    if (selectedstatus == "Waiting") {
      statuscolor = "badge-soft-secondary";
    } else if (selectedstatus == "Approved") {
      statuscolor = "badge-soft-primary";
    } else if (selectedstatus == "Complete") {
      statuscolor = "badge-soft-success";
    } else if (selectedstatus == "Pending") {
      statuscolor = "badge-soft-warning";
    }

    var taskname = $('#taskname').val();
    var d = new Date();
    var strDate = d.getDate() + " " + d.toLocaleString('default', {
      month: 'short'
    }) + ", " + d.getFullYear();
    var taskdesc = $("#taskdesc").val();
    var taskbudget = $("#taskbudget").val();
    var taskassignee = new Array();
    var taskassigneevalue = new Array();
    var src = "";
    $('#taskassignee input[type=checkbox]:checked').each(function () {
      taskassigneevalue.push($(this).attr("id"));
      taskassignee.push($(this).nextAll("img").attr("src"));
    });

    for (i = 0; i < taskassignee.length; i++) {
      src = src + '<div class="avatar-group-item"><a href="#" class="d-inline-block" value="' + taskassigneevalue[i] + '"><img src="' + taskassignee[i] + '" class="rounded-circle avatar-xs m-1" alt=""></a></div>';
    }

    var newtaskdesc = '';

    if (taskdesc.length > 0) {
      newtaskdesc = "<ul class='ps-3 mb-4 text-muted' id='task-desc'>" + "<li class='py-1'>" + taskdesc + "</li>" + "</ul>";
    }

    if (taskname.length == 0 || taskbudget.length == 0 || selectedstatus.length == 0 || taskassignee.length == 0) {
      $("#NewtaskForm").validate().element("#taskname");
      $("#NewtaskForm").validate().element("#taskassignee input:checkbox");
      $("#NewtaskForm").validate().element("#TaskStatus");
      $("#NewtaskForm").validate().element("#taskbudget");
    } else {
      $(updateid).html("<div class='card-body'>" + "<div class='dropdown float-end'>" + "<a href='#' class='dropdown-toggle arrow-none' data-bs-toggle='dropdown' aria-expanded='false'>" + "<i class='mdi mdi-dots-vertical m-0 text-muted h5'></i>" + "</a>" + "<div class='dropdown-menu dropdown-menu-end'>" + "<a class='dropdown-item edittask-details' href='#' data-bs-toggle='modal' data-bs-target='.bs-example-modal-lg' data-id='" + updateid + "'>Edit</a>" + "<a class='dropdown-item deletetask' href='#' data-id='" + updateid + "'>Delete</a>" + "</div>" + "</div> " + "<div class='float-end ml-2'>" + "<span class='badge rounded-pill font-size-12 " + statuscolor + "' id='task-status'>" + selectedstatus + "</span>" + "</div>" + "<div>" + "<h5 class='font-size-15'><a href='javascript: void(0);' class='text-dark' id='task-name'>" + taskname + "</a></h5>" + "<p class='text-muted'>" + strDate + "</p>" + "</div>" + newtaskdesc + "<div class='avatar-group float-start task-assigne'>" + src + "</div>" + "<div class='text-end'>" + "<h5 class='font-size-15 mb-1' id='task-budget'>$ " + taskbudget + "</h5>" + "<p class='mb-0 text-muted'>Budget</p>" + "</div>" + "</div>");
      $('#modalForm').modal('hide');
    }
  }); //Edit Task Details with Validation

  $('.main-content').on('click', '.edittask-details', function (event) {
    var id = $(this).attr('data-id');
    updateid = id;
    var validator = $("#NewtaskForm").validate();
    validator.resetForm();
    $('#updatetaskdetail').css('display', 'block');
    $('#addtask').css('display', 'none');
    $('.update-task-title').css('display', 'block');
    $('.add-task-title').css('display', 'none');
    var name = $(id).find('#task-name').text();
    var desc = $(id).find('#task-desc').text();
    var budget = parseInt($(id).find('#task-budget').text().replace(/[^0-9.]/g, ""));
    var status = $(id).find('#task-status').text();
    $('#taskassignee input').prop("checked", false);
    $(id).find('.task-assigne a').each(function () {
      var assigneusers = $(this).attr('value');
      $("#" + assigneusers).prop("checked", true);
    });
    $('#taskname').val(name);
    $('#taskdesc').val(desc);
    $('#taskbudget').val(budget);
    $('#TaskStatus').val(status);
    selectedstatus = status;
  }); //Delete Task

  $('.main-content').on('click', '.deletetask', function (event) {
    var id = $(this).attr('data-id');
    console.log('Task Deleted Successfully');
    $(id).remove();
  });
}); //Generate ID

function makeid(length) {
  var result = '';
  var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  var charactersLength = characters.length;

  for (var i = 0; i < length; i++) {
    result += characters.charAt(Math.floor(Math.random() * charactersLength));
  }

  return result;
}
/******/ })()
;