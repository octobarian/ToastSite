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
    document.querySelector("#country-list form").innerHTML = "";

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

//-----Country Filtering------------------------------------------------------------------------------------------

//Searches countries once there is at least one letter
function searchCountry() {
    const searchBox = document.querySelector("#countrySearch");
    searchBox.addEventListener("keyup", displayMatches);

    function displayMatches() {
        if (this.value.length >= 1) {
            const matches = findMatches(
                this.value,
                JSON.parse(localStorage.getItem("countriesData"))
            );
            printCountries(matches);
        }

        //If the search box is empty repopulate with all data
        if (this.value.length == 0) {
            printCountries(JSON.parse(localStorage.getItem("countriesData")));
        }
    }
}

//Finds countries that match in API vs. typed
function findMatches(wordToMatch, country) {
    return country.filter(c => {
        if (
            wordToMatch.toLowerCase() ==
            c.name.toLowerCase().substring(0, wordToMatch.length)
        ) {
            return c;
        }
    });
}

//Reverts all of the filters
function reset() {
    //https://stackoverflow.com/questions/12737528/reset-the-value-of-a-select-box
    let select = document.querySelector("#continent-list");

    select.selectedIndex = 0;

    loadCountries(getCountry());
}

/**
 * Continent filter
 */

//Displays the countries for which continent was chosen
function selectFilter() {
    let select = document.querySelector("#selected");
    let countryList = document.querySelector("#countryList ul");

    select.addEventListener("change", () => {
        countryList.innerHTML = "";
        let selected_continent = select.value;
        if (selected_continent != "R") {
            let filteredCountryList = JSON.parse(
                localStorage.getItem("countriesData")
            ).filter(c => c.continent == selected_continent);
            printCountries(filteredCountryList);
        } else {
            printCountries(JSON.parse(localStorage.getItem("countriesData")));
        }
    });
}

//Returns an array of countries within a continent 
document.querySelector('#continentButton').addEventListener('click', (e) => {
    if (e.target.nodeName == "BUTTON") {
        let contArray = [];
        for (let g of getCountry()) {
            console.log(g.Continent)
            if (g.Continent == selectContinent()) {
                contArray.push(g);
            }
        }
        loadCountries(contArray);
    }
})

//Returns the value of the selected continent
function selectContinent() {
    if (document.querySelector('#continent-list').value == "invalid") {} else {
        return document.querySelector('#continent-list').value;
    }
}

//Only show countries that have photos 
function countryWithPhotos() {}

function hideFilters() {
    let select = document.querySelector('#continent-filter');
    select.style.display = 'none';
    document.querySelector('#hide').style.display = 'none';
    document.querySelector('#show').style.display = 'block';
    loadCountries(getCountry());
}

function showFilters() {
    let select = document.querySelector('#continent-filter');
    select.style.display = 'block';
    document.querySelector('#hide').style.display = 'block';
    document.querySelector('#show').style.display = 'none';
}

function showImages(imageArr) {
    let imagesOnly = [];
    getCountry().forEach(c => {
        if (imageArr.includes(c.ISO)) {
            imagesOnly.push(c);
        }
    })
    loadCountries(imagesOnly);
}