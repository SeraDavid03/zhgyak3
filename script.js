document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");
    const temperatureInput = document.querySelector("#homerseklet");
    const submitButton = document.querySelector("button");

    form.addEventListener("submit", function(event) {
        const temperature = parseFloat(temperatureInput.value);
        
        if (temperature < -10 || temperature > 50) {
            alert("A hőmérséklet kívül esik a megengedett tartományon (-10°C - 50°C).");
            event.preventDefault();
        }
    });
});
