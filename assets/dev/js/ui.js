const updateStatus = (message) => {
    const statusElement = document.getElementById("wf-analyzer-status");
    if (statusElement) statusElement.textContent = message;
};

const showError = (message) => {
    console.error(message);
    loadLottieAnimation(lottieAnimations.error);
    updateStatus("Es ist leider ein unerwarteter Fehler aufgetreten. Wir entschuldigen uns für die Unannehmlichkeiten. Bitte versuchen Sie es in ein paar Minuten noch einmal oder wenden Sie sich an den Support, falls das Problem weiterhin besteht.")
    throw new Error("Execution aborted");

};

const handleError = (userMessage, error) => {

    showError(`${userMessage}: ${error.message || "Unbekannter Fehler"}`);
    
}

const updateResults = (data) => {
    const { gtmetrix_score, performance_score, structure_score, fully_loaded_time, largest_contentful_paint, time_to_first_byte, base64_screen_shot } = data;

    if (base64_screen_shot) {
        document.getElementById("wf-analyzer-screenshot").src = "data:image/jpeg;base64," + base64_screen_shot;
    }

    document.getElementById("wf-analyzer-result").classList.remove("wf-analyzer-hidden");
    document.getElementById("wf-chart-container").classList.remove("wf-analyzer-hidden");

    updateChartValues({ gtmetrix_score, performance_score, structure_score, fully_loaded_time, largest_contentful_paint, time_to_first_byte });
};

const hideElementsAfterSubmit = () => {
    document.querySelectorAll('.wf-hide-after-submit').forEach(function(element) {
        element.classList.add('animate__fadeOutUpBig');
    });

    setTimeout(function() {
        document.querySelectorAll('.wf-hide-after-submit').forEach(function(element) {
            element.style.display = 'none';
        });
    }, 200); 
}
