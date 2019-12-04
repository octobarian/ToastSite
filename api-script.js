let CITIES;
let COUNTRIES;

//Fetches data after the HTML Loads and Storing it
document.addEventListener("DOMContentLoaded", function () {

    //Links are just local to test for now
    const citiesAPI = 'http://127.0.0.1/Github/COMP-3512-A2/api-cities.php';
    const countriesAPI = 'http://127.0.0.1/Github/COMP-3512-A2/api-countries.php';

    if (CITIES == null) {
        fetch(citiesAPI, {
                //Browser error without this line    
                mode: 'no-cors'
            })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                localStorage.setItem('Cities', JSON.stringify(data));
                CITIES = JSON.parse(localStorage.getItem('Cities'));
                console.log(CITIES);
            })
            .catch(function () {
                console.log("ERROR In Fetch");
            });
    } else {
        CITIES = JSON.parse(localStorage.getItem('Cities'));
    }

    if (COUNTRIES == null) {
        fetch(countriesAPI, {
                //Browser error without this line    
                mode: 'no-cors'
            })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                localStorage.setItem('Countries', JSON.stringify(data));
                COUNTRIES = JSON.parse(localStorage.getItem('Countries'));
                console.log(COUNTRIES);
            })
            .catch(function () {
                console.log("ERROR In Fetch");
            });
    } else {
        COUNTRIES = JSON.parse(localStorage.getItem('Countries'));
    }

})
