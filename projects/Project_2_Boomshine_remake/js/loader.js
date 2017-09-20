/*
loader.js
variable 'app' is in global scope - i.e. a property of window.
app is our single global object literal - all other functions and properties of 
the game will be properties of app.
*/
"use strict";

// if app exists use the existing copy
// else create a new empty object literal
var app = app || {};


window.onload = function(){
	console.log("window.onload called");
	// This is the "sandbox" where we hook our modules up
	// so that we don't have any hard-coded dependencies in
	// the modules themselves
	// more full blown sandbox solutions are discussed here:
	// http://addyosmani.com/writing-modular-js/
	app.sound.init()
	app.main.sound = app.sound;
	app.main.init();
	
}

window.onresize = function(){
		app.main.canvas.width = window.innerWidth-app.main.BORDER;
		app.main.canvas.height = window.innerHeight-app.main.BORDER;
		app.main.WIDTH = window.innerWidth-app.main.BORDER;
		app.main.HEIGHT = window.innerHeight-app.main.BORDER;
	
}

window.onblur = function(){
 console.log("blur at " + Date());
 app.main.pauseGame();
};
window.onfocus = function(){
 console.log("focus at " + Date());
 app.main.resumeGame();
};