
/*
- Create an HTML page with a head element that provides a title for your page, and links to external CSS and JavaScript files.
- On the HTML page, create 3 divs and a button labeled "Click Me".
- Add classes and/or ids to your divs, then use the CSS to set their font-size and background color. 
- Add function in your JavaScript file to alert the text "Clicked!", and have your button call this function when it is clicked.
- Use CSS to make it so that hovering over any of the 3 divs causes the text to temporarily become bold.
- Make it so that the user can specify custom colors for the first div. To accomplish this, add a text box and another button labeled "Change color". Write a JavaScript function that gets invoked by clicking this button that gets the text from the textbox and sets the color of the first div.
 
STRETCH CHALLENGES

- Repeat the previous step (changing the background color to the value in the box), but this time, use jQuery instead of vanilla JavaScript.
- Add another button to toggle the visibility of the third div. Use jQuery to make it slowly fade in and fade out, rather than just turning on and off.
- Try out Bootstrap. Use bootstrap styles to make it so that your three divs look nice, and respond well when the page is resized.
*/
function clickedMe() {
	alert('Clicked!');
}

//vanilla JavaScript
function colorChange() {
	let color = document.getElementById('color-change').value;
	document.getElementById('first').style.backgroundColor = color;
}

//jQuery
function colorChangeJQ() {
	let color = $('#color-change-jq').val();
	$('#first').css('background-color', color);
}

function toggleHide(selector) {
	$(selector).fadeToggle(1000);
}