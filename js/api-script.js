//
//  JavaScript for the Country and City pages
//

//Fetches data after the HTML Loads and Storing it
document.addEventListener("DOMContentLoaded", function () {

    //Links are just local to test for now
    const countriesAPI = 'http://localhost/Github/COMP-3512-A2/api-countries.php';
    const citiesAPI = 'http://localhost/Github/COMP-3512-A2/api-cities.php';

    console.log(typeof (getCountry()));

    if (getCountry() == null) {
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
                console.log("Fetch Countries");
            })
            .catch(function () {
                console.log("ERROR: api-countries.php fetch");
            });
    } else {
        getCountry();
    }

    if (localStorage.getItem('Cities') == null) {
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
                console.log("Fetch Cities")
            })
            .catch(function () {
                console.log("ERROR: api-cities.php fetch");
            });
    } else {
        getCity();
    }
    loadCountries(getCountry());
})

//Adds click event for the list of countries to display its details
document.querySelector('#country-list').addEventListener('click', (e) => {
    //Prevents console.log from blipping 
    e.preventDefault();

    //Returns the ISO of the selected country
    const selectedCountry = e.target.id;

    getSelectedCountry(selectedCountry);
    loadCitiesFromCountry(selectedCountry);
    getImagesFromSelectedCountry(selectedCountry)
})

//-----LOCAL STORAGE FETCH FUNCTIONS-------------------------------------------------------------------------------

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
    console.log(countries);

    for (let c of countries) {

        //Adds the countries into the li element
        const list = document.querySelector('#country-list form');
        const newListItems = document.createElement('li');
        const newLink = document.createElement('a');
        newListItems.appendChild(newLink);
        list.appendChild(newListItems);
        newLink.textContent = c.CountryName;

        //Sets attribute to <a href=''> link
        newLink.setAttribute("href", "single-country.php?ISO=" + c.ISO);

        //DO NOT REMOVE, COUNTRIES LIST WON'T WORK WITHOUT
        newLink.setAttribute("id", c.ISO);
    };
}

//Gets country object for the country that is selected
function getSelectedCountry(selectedCountry) {
    const country = getCountry().find((c) => {
        return c.ISO == selectedCountry;
    });

    populateCountryDetails(country);
}

//Shows the country details 
function populateCountryDetails(c) {
    document.querySelector('#country-area').textContent = c.Area;
    document.querySelector('#country-pop').textContent = c.Population;
    document.querySelector('#country-cap').textContent = c.Capital;
    document.querySelector('#country-curr-name').textContent = c.CurrencyName;
    document.querySelector('#country-curr-code').textContent = c.CurrencyCode;
    document.querySelector('#country-dom').textContent = c.TopLevelDomain;
    document.querySelector('#country-lang').textContent = c.Languages;
    document.querySelector('#country-neig').textContent = c.Neighbours;
    document.querySelector('#country-desc').textContent = c.CountryDescription;
}

//Populate cities within country 
function loadCitiesFromCountry(selectedCountry) {
    getCity().forEach((c) => {
        if (selectedCountry == c.CountryCodeISO) {
            populateCityList(c);
        }
    })
}

//Populates the list of cities, as links, in the country page
function populateCityList(c) {
    //Adds the cities into the li element
    const list = document.querySelector('#cities-list');
    const newListItems = document.createElement('li');
    const newLink = document.createElement('a');
    newListItems.appendChild(newLink);
    list.appendChild(newListItems);
    newLink.textContent = c.AsciiName;

    //Sets attribute to <a href=''> link
    newLink.setAttribute("href", "single-city.php?CityCode=" + c.CityCode);
    newLink.setAttribute("id", c.CityCode);

    console.log(c);
}

//Gets all of the images for a country
function getImagesFromSelectedCountry() {

}

//Populate the images in the country page
function populateCountryImages() {

}

//-----CITY PAGE FUNCTIONS----------------------------------------------------------------------------------------
