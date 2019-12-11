function createMap(lat, long) {
    document.querySelector("#Map").style.height = "25em";
    return new google.maps.Map(document.querySelector("#Map"), {
        center: {
            lat: lat,
            lng: long
        },
        mapTypeId: "satellite",
        zoom: 18
    });
}

document.addEventListener("DOMContentLoaded", () => {
    let buttDesc = document.querySelector("#buttDesc");
    let buttDet = document.querySelector("#buttDet");
    let buttMap = document.querySelector("#buttMap");

    let desc = document.querySelector("#desc");
    let det = document.querySelector("#details");
    let map = document.querySelector("#Map");

    buttDesc.addEventListener('click', () => {
        desc.style.display = "block";
        det.style.display = "none";
        map.style.display = "none";
    })

    buttDet.addEventListener('click', () => {
        det.style.display = "block";
        desc.style.display = "none";
        map.style.display = "none";
    })

    buttMap.addEventListener('click', () => {
        map.style.display = "block";
        det.style.display = "none";
        desc.style.display = "none";
    })
})

function displayDetails(info) {
    if (info.Exif != null) {
        let exif = JSON.parse(info.Exif);
        let loc = document.querySelector("#details");
        let model = document.createElement("p");
        let exposure = document.createElement("p");
        let aperture = document.createElement("p");
        let focalLength = document.createElement("p");
        let iso = document.createElement("p");

        model.textContent = "Make: " + exif.model;
        loc.appendChild(model);

        exposure.textContent = "Exposure: " + exif.exposure_time;
        loc.appendChild(exposure);

        aperture.textContent = "Aperture: " + exif.aperture;
        loc.appendChild(aperture);

        focalLength.textContent = "Focal Length: " + exif.focal_length;
        loc.appendChild(focalLength);

        iso.textContent = "ISO: " + exif.iso;
        loc.appendChild(iso);

        let colors = JSON.parse(info.Colors);

        colors.forEach(c => {
            let span = document.createElement("span");
            span.style.backgroundColor = c;
            loc.appendChild(span);
        })
    } else {
        let loc = document.querySelector("#details");
        let noInfo = document.createElement("p");
        noInfo.textContent = "No Detail Information for this Photo!";
        loc.appendChild(noInfo);
    }
}

function displayHover(info) {
    if (info.Exif != null) {

        let exif = JSON.parse(info.Exif);
        let loc = document.querySelector("#hoverInfo");
        let model = document.createElement("p");
        let exposure = document.createElement("p");
        let aperture = document.createElement("p");
        let focalLength = document.createElement("p");
        let iso = document.createElement("p");

        model.textContent = "Make: " + exif.model;
        loc.appendChild(model);

        exposure.textContent = "Exposure: " + exif.exposure_time;
        loc.appendChild(exposure);

        aperture.textContent = "Aperture: " + exif.aperture;
        loc.appendChild(aperture);

        focalLength.textContent = "Focal Length: " + exif.focal_length;
        loc.appendChild(focalLength);

        iso.textContent = "ISO: " + exif.iso;
        loc.appendChild(iso);

        let colors = JSON.parse(info.Colors);

        colors.forEach(c => {
            let span = document.createElement("span");
            span.style.backgroundColor = c;
            loc.appendChild(span);
        })
    } else {
        let loc = document.querySelector("#hoverInfo");
        let noInfo = document.createElement("p");
        noInfo.textContent = "No Detail Information for this Photo!";
        loc.appendChild(noInfo);
    }
}