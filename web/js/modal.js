	// Get the modal
	var modal = document.getElementById("myModal");
	var modalImg = document.getElementById("imgtemp");

	// Get the image and insert it inside the modal - use its
	var img = document.getElementById("popup1");
	img.onclick = function() {
		modal.style.display = "block";
		modalImg.src = this.src;
	}

	var img = document.getElementById("popup2");
	img.onclick = function() {
		modal.style.display = "block";
		modalImg.src = this.src;
	}

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() { 
		modal.style.display = "none";
	}