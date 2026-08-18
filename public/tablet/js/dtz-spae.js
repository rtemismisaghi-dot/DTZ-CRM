// =====================================
// DTZ TABLET SPACE
// CLEAN VERSION
// =====================================


let canvas;
let ctx;


let lines = [];
let dimensions = [];


let drawing = false;
let startPoint = null;


document.addEventListener(
"DOMContentLoaded",
function(){


    canvas =
    document.getElementById("planCanvas");


    if(!canvas){

        console.error("Canvas پیدا نشد");

        return;
    }



    ctx =
    canvas.getContext("2d");



    resizeCanvas();



    console.log(
        "DTZ Canvas Ready"
    );



});





function resizeCanvas(){


    if(!canvas)
        return;



    let rect =
    canvas.getBoundingClientRect();



    canvas.width =
    rect.width;



    canvas.height =
    rect.height;



}