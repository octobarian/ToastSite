let CITIES;
let COUNTRIES;

//Fetches data after the HTML Loads and Storing it
document.addEventListener("DOMContentLoaded", function () {

    //Links are just local to test for now
    const countriesAPI = 'http://127.0.0.1/Github/COMP-3512-A2/api-countries.php';
    const citiesAPI = 'http://127.0.0.1/Github/COMP-3512-A2/api-cities.php';

    if (COUNTRIES == null) {
        fetch(countriesAPI, {
                //Browser error without this line    
                mode: 'no-cors'
            })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {

                //Sorts Countries alphabetically by ISO
                const sortedCountries = data.sort((a, b) => {
                    return a.ISO < b.ISO ? -1 : 1;
                });

                localStorage.setItem('Countries', JSON.stringify(sortedCountries));
                COUNTRIES = JSON.parse(localStorage.getItem('Countries'));
                //console.log(COUNTRIES);
                loadCountries();
            })
            .catch(function () {
                console.log("ERROR In Fetch");
            });
    } else {
        COUNTRIES = JSON.parse(localStorage.getItem('Countries'));
    }

    if (CITIES == null) {
        fetch(citiesAPI, {
                //Browser error without this line    
                mode: 'no-cors'
            })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {

                //Sorts Cities alphabetically by CountryCodeISO
                const sortedCities = data.sort((a, b) => {
                    return a.CountryCodeISO < b.CountryCodeISO ? -1 : 1;
                });

                localStorage.setItem('Cities', JSON.stringify(sortedCities));
                CITIES = JSON.parse(localStorage.getItem('Cities'));
                //console.log(CITIES);
            })
            .catch(function () {
                console.log("ERROR In Fetch");
            });
    } else {
        CITIES = JSON.parse(localStorage.getItem('Cities'));
    }
})

//-----COUNTRY PAGE FUNCTIONS--------------------------------------------------------------------------------------

//Populate Countries On Initial Country Page Load
function loadCountries() {
    for (let c of COUNTRIES) {
        //console.log(c)
        //Adds the countries into the li element
        const list = document.querySelector('#country-list');
        const newListItems = document.createElement('li');
        const newLink = document.createElement('a');
        newListItems.appendChild(newLink);
        list.appendChild(newListItems);
        newLink.textContent = c.CountryName;

        //Sets attribute to <a href=''> link
        newLink.setAttribute("href", 'single-country.php?iso=' + c.ISO);
    };
}
