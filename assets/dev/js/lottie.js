const lottieAnimationFolder = "/wp-content/plugins/wf-analyzer/assets/lottie/"
const lottieAnimations = {
    "starting": "starting-lottie.json",
    "processing": "processing-lottie.json",
    "done": "done-lottie.json",
    "error": "error-lottie.json"
};
const lottieAnimationContainer = document.getElementById("wf-lottie-container");
function loadLottieAnimation(animationURL) {
    clearLottieAnimation()
    animationInstance = lottie.loadAnimation({
        container: lottieAnimationContainer,
        renderer: "svg", 
        loop: true,
        autoplay: true,
        path: lottieAnimationFolder + animationURL,
        rendererSettings: {
            preserveAspectRatio: "xMidYMid meet" 
        }
    });
    lottieAnimationContainer.classList.remove("wf-analyzer-hidden");
}

function clearLottieAnimation() {
    lottieAnimationContainer.innerHTML = ""
}