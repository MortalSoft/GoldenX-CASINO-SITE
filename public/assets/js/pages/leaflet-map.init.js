/******/ (function() { // webpackBootstrap
/*!************************************************!*\
  !*** ./resources/js/pages/leaflet-map.init.js ***!
  \************************************************/
/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: leaflet init js
*/
// leaflet-map
var mymap = L.map('leaflet-map').setView([51.505, -0.09], 13);
L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
  maxZoom: 18,
  attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' + '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' + 'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
  id: 'mapbox/streets-v11',
  tileSize: 512,
  zoomOffset: -1
}).addTo(mymap); // leaflet-map-marker

var markermap = L.map('leaflet-map-marker').setView([51.505, -0.09], 13);
L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
  maxZoom: 18,
  attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' + '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' + 'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
  id: 'mapbox/streets-v11',
  tileSize: 512,
  zoomOffset: -1
}).addTo(markermap);
L.marker([51.5, -0.09]).addTo(markermap);
L.circle([51.508, -0.11], {
  color: '#34c38f',
  fillColor: '#34c38f',
  fillOpacity: 0.5,
  radius: 500
}).addTo(markermap);
L.polygon([[51.509, -0.08], [51.503, -0.06], [51.51, -0.047]], {
  color: '#556ee6',
  fillColor: '#556ee6'
}).addTo(markermap); // Working with popups

var popupmap = L.map('leaflet-map-popup').setView([51.505, -0.09], 13);
L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
  maxZoom: 18,
  attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' + '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' + 'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
  id: 'mapbox/streets-v11',
  tileSize: 512,
  zoomOffset: -1
}).addTo(popupmap);
L.marker([51.5, -0.09]).addTo(popupmap).bindPopup("<b>Hello world!</b><br />I am a popup.").openPopup();
L.circle([51.508, -0.11], 500, {
  color: '#f46a6a',
  fillColor: '#f46a6a',
  fillOpacity: 0.5
}).addTo(popupmap).bindPopup("I am a circle.");
L.polygon([[51.509, -0.08], [51.503, -0.06], [51.51, -0.047]], {
  color: '#556ee6',
  fillColor: '#556ee6'
}).addTo(popupmap).bindPopup("I am a polygon.");
var popup = L.popup(); // leaflet-map-custom-icons

var customiconsmap = L.map('leaflet-map-custom-icons').setView([51.5, -0.09], 13);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(customiconsmap);
var LeafIcon = L.Icon.extend({
  options: {
    iconSize: [45, 95],
    iconAnchor: [22, 94],
    popupAnchor: [-3, -76]
  }
});
var greenIcon = new LeafIcon({
  iconUrl: 'assets/images/logo.svg'
});
L.marker([51.5, -0.09], {
  icon: greenIcon
}).addTo(customiconsmap); // Interactive Choropleth Map

var interactivemap = L.map('leaflet-map-interactive-map').setView([37.8, -96], 4);
L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
  maxZoom: 18,
  attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' + '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' + 'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
  id: 'mapbox/light-v9',
  tileSize: 512,
  zoomOffset: -1
}).addTo(interactivemap); // get color depending on population density value

function getColor(d) {
  return d > 1000 ? '#435fe3' : d > 500 ? '#556ee6' : d > 200 ? '#677de9' : d > 100 ? '#798ceb' : d > 50 ? '#8a9cee' : d > 20 ? '#9cabf0' : d > 10 ? '#aebaf3' : '#c0c9f6';
}

function style(feature) {
  return {
    weight: 2,
    opacity: 1,
    color: 'white',
    dashArray: '3',
    fillOpacity: 0.7,
    fillColor: getColor(feature.properties.density)
  };
}

var geojson = L.geoJson(window.statesData, {
  style: style
}).addTo(interactivemap); // leaflet-map-group-control

var cities = L.layerGroup();
L.marker([39.61, -105.02]).bindPopup('This is Littleton, CO.').addTo(cities), L.marker([39.74, -104.99]).bindPopup('This is Denver, CO.').addTo(cities), L.marker([39.73, -104.8]).bindPopup('This is Aurora, CO.').addTo(cities), L.marker([39.77, -105.23]).bindPopup('This is Golden, CO.').addTo(cities);
var mbAttr = 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' + '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' + 'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    mbUrl = 'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';
var grayscale = L.tileLayer(mbUrl, {
  id: 'mapbox/light-v9',
  tileSize: 512,
  zoomOffset: -1,
  attribution: mbAttr
}),
    streets = L.tileLayer(mbUrl, {
  id: 'mapbox/streets-v11',
  tileSize: 512,
  zoomOffset: -1,
  attribution: mbAttr
});
var layergroupcontrolmap = L.map('leaflet-map-group-control', {
  center: [39.73, -104.99],
  zoom: 10,
  layers: [streets, cities]
});
var baseLayers = {
  "Grayscale": grayscale,
  "Streets": streets
};
var overlays = {
  "Cities": cities
};
L.control.layers(baseLayers, overlays).addTo(layergroupcontrolmap);
/******/ })()
;