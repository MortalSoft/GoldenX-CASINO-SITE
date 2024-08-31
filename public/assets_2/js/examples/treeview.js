'use strict';
$(document).ready(function () {

    $('#jstree_demo1').jstree({'core' : {
            'data' : [
                {
                    "text" : "Same but with checkboxes",
                    "children" : [
                        { "text" : "initially selected", "state" : { "selected" : true } },
                        { "text" : "custom icon URL", "icon" : "//jstree.com/tree-icon.png" },
                        { "text" : "initially open", "state" : { "opened" : true }, "children" : [ "Another node" ] },
                        { "text" : "custom icon class", "icon" : "glyphicon glyphicon-leaf" }
                    ]
                },
                "And wholerow selection"
            ]
        }});

    $('#jstree_demo2').jstree({'plugins':["wholerow"], 'core' : {
            'data' : [
                {
                    "text" : "Same but with checkboxes",
                    "children" : [
                        { "text" : "initially selected", "state" : { "selected" : true } },
                        { "text" : "custom icon URL", "icon" : "//jstree.com/tree-icon.png" },
                        { "text" : "initially open", "state" : { "opened" : true }, "children" : [ "Another node" ] },
                        { "text" : "custom icon class", "icon" : "glyphicon glyphicon-leaf" }
                    ]
                },
                "And wholerow selection"
            ]
        }});

    $('#jstree_demo3').jstree({'plugins':["wholerow", "checkbox"], 'core' : {
            'data' : [
                {
                    "text" : "Same but with checkboxes",
                    "children" : [
                        { "text" : "initially selected", "state" : { "selected" : true } },
                        { "text" : "custom icon URL", "icon" : "//jstree.com/tree-icon.png" },
                        { "text" : "initially open", "state" : { "opened" : true }, "children" : [ "Another node" ] },
                        { "text" : "custom icon class", "icon" : "glyphicon glyphicon-leaf" }
                    ]
                },
                "And wholerow selection"
            ]
        }});

});