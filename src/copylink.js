function copy_clip(id) {
	var copyText = document.getElementById(id);

	copyText.addEventListener("copy", function(event) {
		event.preventDefault();
		if (event.clipboardData) {
			event.clipboardData.setData("text/plain", copyText.textContent);
			//console.log(event.clipboardData.getData("text"));
		}
	});
	document.execCommand("copy");
}
