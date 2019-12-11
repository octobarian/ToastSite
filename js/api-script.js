//
//  JavaScript for the Country and City pages
//

//Fetches data after the HTML Loads and Storing it
document.addEventListener("DOMContentLoaded", function () {
    fetchAPIData();
})

//Adds click event for the list of countries to display its details
document.querySelector('#country-list').addEventListener('click', (e) => {
    //Prevents console.log from blipping 
    e.preventDefault();

    window.location.href = "../single-country.php" + e.target.search;

    console.log(window.location.href);
})

//-----LOCAL STORAGE FETCH FUNCTIONS-------------------------------------------------------------------------------

function fetchAPIData() {
    const countriesAPI = './api-countries.php';
    const citiesAPI = './api-cities.php';

    if (localStorage.getItem('Countries') == null) {
        fetch(countriesAPI, {
                //Browser error without this line    
                mode: 'no-cors'
            })
            .then((response) => response.json())
            .then(function (data) {
                //Sorts Countries alphabetically by ISO
                const sortedCountries = data.sort((a, b) => {
                    return a.ISO < b.ISO ? -1 : 1;
                });

                localStorage.setItem('Countries', JSON.stringify(sortedCountries));

            })
            .then(() => loadCountries(getCountry()))
            .catch(() => console.log("ERROR: api - countries.php fetch"))
    } else {
        loadCountries(getCountry())
    }

    if (localStorage.getItem('Cities') == null) {
        fetch(citiesAPI, {
                //Browser error without this line    
                mode: 'no-cors'
            })
            .then((response) => response.json())
            .then(function (data) {
                //Sorts Cities alphabetically by CountryCodeISO
                const sortedCities = data.sort((a, b) => {
                    return a.CountryCodeISO < b.CountryCodeISO ? -1 : 1;
                });

                localStorage.setItem('Cities', JSON.stringify(sortedCities));
            })
            .catch(() => console.log("ERROR: api-cities.php fetch"))
    } else {
        getCity();
    }
}

//Returns the array of Countries from localstorage
function getCountry() {
    return JSON.parse(localStorage.getItem('Countries'));
}

//Returns the array of Cities from localstorage
function getCity() {
    return JSON.parse(localStorage.getItem('Cities'));
}

//-----COUNTRY PAGE FUNCTIONS--------------------------------------------------------------------------------------

//Populate Countries On Initial Country Page Load
function loadCountries(countries) {
    for (let c of countries) {

        //Adds the countries into the li element
        const list = document.querySelector('#country-list form');
        const newListItems = document.createElement('li');
        const newLink = document.createElement('a');
        newListItems.appendChild(newLink);
        list.appendChild(newListItems);
        newLink.textContent = c.CountryName;

        //Sets attribute to <a href=''> link
        newLink.setAttribute("href", "../single-country.php?ISO=" + c.ISO);

        //DO NOT REMOVE, COUNTRIES LIST WON'T WORK WITHOUT
        //newLink.setAttribute("id", c.ISO);
    };
}
