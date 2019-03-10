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
var cinemaSelect = document.querySelector('.select-cinema'); //must use className
var movieList = document.getElementById('movieList');

T.post('./config/savetocache.php', dateInput.value, cinemaSelect.value, function(data) {
	c(data);
});

dateInput.addEventListener('change', selectDate);
cinemaSelect.addEventListener('change', selectCinema);

function selectCinema() {
	console.log('kino select');
	T.post('./config/savetocache.php', dateInput.value, cinemaSelect.value, function (data) {
		c(data);
	});
}

function selectDate() {
	console.log(dateInput.value);
	T.post('./config/savetocache.php', dateInput.value, cinemaSelect.value, function (data) {
		c(data);
	});
}

function c(e) {
	for (var property in e) {
		console.log(e[property]);
	}
}

document.addEventListener('DOMContentLoaded', function () {
	var elems = document.querySelectorAll('select');
	const options = {
		classes: 'select select--cinema'
	}
	var instances = M.FormSelect.init(elems, options);
});


document.addEventListener('DOMContentLoaded', createDatePicker);

function createDatePicker() {
	var elems = document.querySelectorAll('.datepicker');
	const options = {
		format: 'yyyy-mm-dd',
		i18n: {
			cancel: 'Anuluj',
			done: 'Zatwierdź',
			clear: 'Wyczyść',
			weekdays: [
				'Niedziela',
				'Poniedziałek',
				'Wtorek',
				'Środa',
				'Czwartek',
				'Piątek',
				'Sobota'
			],

			weekdaysShort: [
				'Niedz',
				'Pon',
				'Wt',
				'Śr',
				'Czw',
				'Pt',
				'Sob'
			],

			months: [
				'Styczeń',
				'Luty',
				'Marzec',
				'Kwiecień',
				'Maj',
				'Czerwiec',
				'Lipiec',
				'Sierpień',
				'Wrzesień',
				'Październik',
				'Listopad',
				'Grudzień'
			],

			monthsShort: [
				'Sty',
				'Lut',
				'Mar',
				'Kwi',
				'Maj',
				'Cze',
				'Lip',
				'Sie',
				'Wrz',
				'Lis',
				'Paź',
				'Gru'
			]
		}
	}
	var datepicker = M.Datepicker.init(elems, options);
}



