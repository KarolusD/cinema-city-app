var T = {
    post: function (url, data, success) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                success(this.responseText);
            }
        };
        xhttp.open("POST", url, true);
        // xhttp.setRequestHeader("Content-Type", "application/json");
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        console.log(xhttp.responseText);
        console.log(data);
        xhttp.send('date=2019-02-11&key=val');
    },
       get: function (url, success) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                success(this.responseText);
            }
        };
        xhttp.open("GET", url, true);
        xhttp.setRequestHeader("Content-Type", "application/json");
        xhttp.send();
    }
}

T.post('savetocache.php', {'date': '2019-02-11'}, function(data){
    console.log(JSON.parse(data));
});



