export var T = {
  post: function(url, data, cinema, filter, success) {
    const xhttp = new XMLHttpRequest();

    xhttp.onloadstart = function() {
      document.getElementById('movieList').innerHTML =
        '<div class="bg-all"><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></div>';
      const allInputs = document.querySelectorAll('select, .input-field');
      for(let i in allInputs) {
        if(allInputs[i].querySelector) {
          allInputs[i].style['pointer-events'] = 'none'
        }
      }
    };

    xhttp.onreadystatechange = function() {
      if (this.readyState === 4 && this.status === 200) {
        let response = JSON.parse(this.responseText);
        success(response);
        const allInputs = document.querySelectorAll(
          'select, .input-field'
        );
        for (var i in allInputs) {
          if (allInputs[i].querySelector) {
            allInputs[i].style['pointer-events'] = 'all';
          }
        }
      }
    };
    xhttp.open('POST', url, true);
    // xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send('date=' + data + '&cinema=' + cinema + '&filter=' + filter);
  },
  get: function(url, success) {
    const xhttp = new XMLHttpRequest();
    xhttp.onprogress = function() {
      document.getElementById('movieList').innerHTML =
        '<div class="bg-all"><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></div>';
    };

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
