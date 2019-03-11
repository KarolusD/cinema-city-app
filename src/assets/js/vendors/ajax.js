export var T = {
	post: function(url, data, cinema, success) {
		const xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState === 4 && this.status === 200) {
				let response = JSON.parse(this.responseText);
				success(response);
				//console.log(response);
			}
		};
		xhttp.open('POST', url, true);
		// xhttp.setRequestHeader("Content-Type", "application/json");
		xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		console.log(xhttp.responseText);
		console.log(data);
		xhttp.send('date=' + data + '&cinema=' + cinema);
	},
	get: function(url, success) {
		const xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState === 4 && this.status === 200) {
				success(this.responseText);
			}
		};
		xhttp.open('GET', url, true);
		xhttp.setRequestHeader('Content-Type', 'application/json');
		xhttp.send();
	}
};










