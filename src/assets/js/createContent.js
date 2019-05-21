import { T } from './vendors/ajax';
import { searchMain } from './search';

const dateInput = document.getElementById('dateInput');
const cinemaSelect = document.querySelector('.select-cinema'); //must use className
const filterSelect = document.querySelector('.select-filter'); //must use className
const movieList = document.getElementById('movieList');

function createContent(data) {
  
  
  // console.log(d.getHours(), d.getMinutes(), d.getSeconds(),  'usuwam loader');
  movieList.innerHTML = ''; // clear movies list
  let docFragment = document.createDocumentFragment();
  // looping through ajax response
  for (let property in data) {
    let movieTile = document.createElement('div'); // div for movie tile
    let showTimeList = document.createElement('ul'); // ul list for showtimes
    movieTile.classList.add('movie');
    showTimeList.classList.add('movie__showtimes-list');
    //console.log(data[property]);
    if (search.value) {
      movieTile.style.display = 'none';
    }

    movieTile.innerHTML = `
            <img
                src="${data[property].poster_link}" 
                class="movie__img"
                alt="${data[property].name}"
                title="${data[property].name}" 
            />
            <h2 class="movie__title">${data[property].name}</h2>
            <p class="movie__length">${data[property].length} min.</p>
            `;

    // looping through showtimes
    let showtime = data[property].showtime;

    for (let i = 0; i < showtime.length; i++) {
      showTimeList.innerHTML += `
                <li class="showtimes-list__showtime">
                    <a target="_blank" href="${showtime[i].booking_link}">${
        showtime[i].time
      }</a>
                </li>
            `;
      //console.log('dodano', showTimeList);
    }
    //console.log('render');
    movieTile.appendChild(showTimeList);
    docFragment.appendChild(movieTile);
  }
  movieList.appendChild(docFragment);
  searchMain();
  noResults();
}
// T.post(
//   './config/savetocache.php',
//   dateInput.value,
//   cinemaSelect.value,
//   filterSelect.value,
//   function(data) {
//     console.log(d.getHours(), d.getMinutes(), d.getSeconds());
//     createContent(data);
//     console.log(d.getHours(), d.getMinutes(), d.getSeconds());
//     noResults();
//   }
// );

dateInput.addEventListener('change', selectDate);
cinemaSelect.addEventListener('change', selectCinema);
filterSelect.addEventListener('change', selectFilter);

function selectCinema() {
  //console.log('kino select');
  T.post(
    './config/savetocache.php',
    dateInput.value,
    cinemaSelect.value,
    filterSelect.value,
    function(data) {
      createContent(data);
    }
  );
}

function selectDate() {
  //console.log(dateInput.value);
  var d = new Date();
//console.log(d.getHours(), d.getMinutes(), d.getSeconds(), 'date-change');
  T.post(
    './config/savetocache.php',
    dateInput.value,
    cinemaSelect.value,
    filterSelect.value,
    function(data) {
      d = new Date();
      //console.log(d.getHours(), d.getMinutes(), d.getSeconds(), 'end-of-ajax');
      createContent(data);
    }
  );
}

function selectFilter() {
 
  //console.log('filter select', filterSelect.value);
  T.post(
    './config/savetocache.php',
    dateInput.value,
    cinemaSelect.value,
    filterSelect.value,
    function(data) {
      createContent(data);
    }
    );
  // var r = searchFor(search.value, new Date().getTime());
  // renderMovieList(r.toHide, r.toShow);
}

function noResults() {
  if (movieList.innerHTML === '') {
    movieList.innerHTML =
      '<p class="no-results">Brak seansów na wybrany dzień</p>';
  }
}
