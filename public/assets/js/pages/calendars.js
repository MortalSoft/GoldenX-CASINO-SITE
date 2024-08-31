/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/*!*****************************************!*\
  !*** ./resources/js/pages/calendars.js ***!
  \*****************************************/

/* eslint-disable require-jsdoc, no-unused-vars */

var CalendarList = [];

function CalendarInfo() {
  this.id = null;
  this.name = null;
  this.checked = true;
  this.color = null;
  this.bgColor = null;
  this.borderColor = null;
  this.dragBgColor = null;
}

function addCalendar(calendar) {
  CalendarList.push(calendar);
}

function findCalendar(id) {
  var found;
  CalendarList.forEach(function (calendar) {
    if (calendar.id === id) {
      found = calendar;
    }
  });
  return found || CalendarList[0];
}

function hexToRGBA(hex) {
  var radix = 16;
  var r = parseInt(hex.slice(1, 3), radix),
      g = parseInt(hex.slice(3, 5), radix),
      b = parseInt(hex.slice(5, 7), radix),
      a = parseInt(hex.slice(7, 9), radix) / 255 || 1;
  var rgba = 'rgba(' + r + ', ' + g + ', ' + b + ', ' + a + ')';
  return rgba;
}

(function () {
  var calendar;
  var id = 0;
  calendar = new CalendarInfo();
  id += 1;
  calendar.id = String(id);
  calendar.name = 'My Calendar';
  calendar.color = '#ffffff';
  calendar.bgColor = '#556ee6';
  calendar.dragBgColor = '#556ee6';
  calendar.borderColor = '#556ee6';
  addCalendar(calendar);
  calendar = new CalendarInfo();
  id += 1;
  calendar.id = String(id);
  calendar.name = 'Company';
  calendar.color = '#ffffff';
  calendar.bgColor = '#50a5f1';
  calendar.dragBgColor = '#50a5f1';
  calendar.borderColor = '#50a5f1';
  addCalendar(calendar);
  calendar = new CalendarInfo();
  id += 1;
  calendar.id = String(id);
  calendar.name = 'Family';
  calendar.color = '#ffffff';
  calendar.bgColor = '#f46a6a';
  calendar.dragBgColor = '#f46a6a';
  calendar.borderColor = '#f46a6a';
  addCalendar(calendar);
  calendar = new CalendarInfo();
  id += 1;
  calendar.id = String(id);
  calendar.name = 'Friend';
  calendar.color = '#ffffff';
  calendar.bgColor = '#34c38f';
  calendar.dragBgColor = '#34c38f';
  calendar.borderColor = '#34c38f';
  addCalendar(calendar);
  calendar = new CalendarInfo();
  id += 1;
  calendar.id = String(id);
  calendar.name = 'Travel';
  calendar.color = '#ffffff';
  calendar.bgColor = '#bbdc00';
  calendar.dragBgColor = '#bbdc00';
  calendar.borderColor = '#bbdc00';
  addCalendar(calendar);
  calendar = new CalendarInfo();
  id += 1;
  calendar.id = String(id);
  calendar.name = 'etc';
  calendar.color = '#ffffff';
  calendar.bgColor = '#9d9d9d';
  calendar.dragBgColor = '#9d9d9d';
  calendar.borderColor = '#9d9d9d';
  addCalendar(calendar);
  calendar = new CalendarInfo();
  id += 1;
  calendar.id = String(id);
  calendar.name = 'Birthdays';
  calendar.color = '#ffffff';
  calendar.bgColor = '#f1b44c';
  calendar.dragBgColor = '#f1b44c';
  calendar.borderColor = '#f1b44c';
  addCalendar(calendar);
  calendar = new CalendarInfo();
  id += 1;
  calendar.id = String(id);
  calendar.name = 'National Holidays';
  calendar.color = '#ffffff';
  calendar.bgColor = '#ff4040';
  calendar.dragBgColor = '#ff4040';
  calendar.borderColor = '#ff4040';
  addCalendar(calendar);
})();
/******/ })()
;