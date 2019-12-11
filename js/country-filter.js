/**
 * Searches countries once there is at least one letter
 */
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

/**
 * Finds countries that match in API vs. typed
 */
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


/**
 * Reverts all of the filters
 */
function reset() {
    let colMid = document.querySelector(".mid");
    let colRight = document.querySelector(".right");
    let cityList = document.querySelector("#citiesList ul");
    let cityBlock = document.querySelector("#citiesList");
    let base = document.querySelector("#base");

    //https://stackoverflow.com/questions/12737528/reset-the-value-of-a-select-box
    let select = document.querySelector("#selected");
    colMid.style.display = "none";
    colRight.style.display = "none";
    cityBlock.style.display = "none";
    base.style.display = "block";
    cityList.innerHTML = "";
    select.selectedIndex = 0;

    printCountries(JSON.parse(localStorage.getItem("countriesData")));
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

/**
 * Only show countries that have photos 
 */
function countryWithPhotos() {}
