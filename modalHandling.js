// Handles show/hide events for dialog boxes in speakers.php, panels.php and register.php

function OpenModal(event) {
	const modaldiv = document.getElementById("modal-div");
	if (!modaldiv.querySelector(".modal")) {
		MoveModals();
		console.log("moving");
	}
	//alert("hello");
	// change modal's visibility to visible
	if (event.target.hasAttribute("card-id")) {
		var modal = "modal-" + event.target.getAttribute("card-id");
	} else {
		var modal = "success";
	}
	//alert(modal);
	document.getElementById(modal).classList.remove("hidden");
	document.getElementById(modal).classList.add("visible");
	//console.log(modal);
	//alert($(test).attr('class'))
	document.getElementById("modal_overlay").classList.remove("hidden");
	//console.log("done");
}

function CloseModal(element) {
	//alert("hello");
	document.getElementById("modal_overlay").classList.add("hidden");
	document.querySelector(".visible").classList.add("hidden");
	document.querySelector(".visible").classList.remove("visible");
}

function MoveModals() {
	const modals = document.querySelectorAll("speaker-modal, panel-modal");
	const modaldiv = document.getElementById("modal-div");
	modals.forEach(function (currentValue, currentIndex, listObj) {
		modaldiv.insertAdjacentElement("beforeend", currentValue);
	});
}
