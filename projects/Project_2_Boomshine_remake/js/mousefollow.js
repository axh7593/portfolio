"use strict";

var canvas = document.querySelector("canvas");
//var ctx = canvas.getContext("2d");

var initcalled=false;
var radius = 20;

var mouseX, mouseY;

function drawFollowCircle(ctx){
	console.log('follow');
  // Clear the background
  //ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
  //debugger;
  // Establish the circle path
  ctx.beginPath();
  ctx.arc(mouseX, mouseY, radius, 0 , 2 * Math.PI, false);
  
  // Fill the circle
  ctx.fillStyle = '#FD5B78';
  ctx.fill();
  

}

// Redraw the circle every time the mouse moves
canvas.addEventListener('mousemove',function(e){
	mouseX = e.clientX, mouseY = e.clientY;
  //drawFollowCircle(e.clientX, e.clientY);
});

// Clear the canvas when the mouse leaves the canvas region
canvas.addEventListener('mouseout',function(e){
  //ctx.clearRect(0, 0, canvas.WIDTH, canvas.HEIGHT);
});

// Draw a circle in the center initially,
// so the program hints at what it does before any mouse interaction
//drawFollowCircle(canvas.WIDTH / 2, canvas.HEIGHT / 2);