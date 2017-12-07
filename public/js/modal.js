'use strict';

let modals = document.getElementsByClassName("modal"); //get all modals
Array.prototype.forEach.call(modals, function (modal) {
	console.log(modal);
	let openerId;
	if (openerId = modal.getAttribute("opener")) {
		let btnThatOpens = document.getElementById(modal.getAttribute("opener"));
		let span = modal.getElementsByClassName("closeModal")[0];
		if (btnThatOpens) {
			document.addEventListener('keydown', (e) => { //on keyboard press
				if (e.keyCode == 27) { //Esc
					modal.style.display = "none";
				}
			});
			btnThatOpens.onclick = function (e) {
				modal.style.display = "block";
				modal.getElementsByTagName("input")[0].focus();
			};
			if (span != undefined) {
				span.onclick = function () {
					modal.style.display = "none";
				};
			}

		}
	}
});

window.onclick = function (event) {
	Array.prototype.forEach.call(modals, function (modal) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
	});
};