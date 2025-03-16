document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("wf-analyzer-form");


    if (!form) {
        showError("WF Analyzer form not found!");
        return;
    }


    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const url = document.getElementById("wf-analyzer-website-url").value.trim();
        if (!url) {
            showError("Bitte geben Sie eine gültige URL ein.");
            return;
        }

        hideElementsAfterSubmit();
        loadLottieAnimation(lottieAnimations.starting);

        
        startTest(url)
       
    });
});