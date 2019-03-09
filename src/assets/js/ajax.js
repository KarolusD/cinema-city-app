var T = {
	post: function(url, data, cinema, success) {
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState === 4 && this.status === 200) {
				var response = JSON.parse(this.responseText);
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
		var xhttp = new XMLHttpRequest();
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

var dateInput = document.getElementById('dateInput');
var cinemaSelect = document.getElementById('cinemaSelect');
var movieList = document.getElementById('movieList');
T.post('./config/savetocache.php', dateInput.value, cinemaSelect.value, function(data) {
		c(data);
});

dateInput.addEventListener('input', function() {
	console.log(dateInput.value);
    T.post('./config/savetocache.php', dateInput.value, cinemaSelect.value, function(data) {
		//console.log(data);
		c(data);
	});
});

cinemaSelect.addEventListener('input', function() {
	console.log('kino select');
    T.post('./config/savetocache.php', dateInput.value, cinemaSelect.value, function(data) {
		c(data);
	});
});


function c(e) {
	for(var property in e) {
		console.log(e[property]);
	}
}
