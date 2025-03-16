const startTest = async (url) => {
  
        updateStatus("Test wird gestartet...");
    
        const response = await makeRequest("wf_start_test", { url });
        if (response.test_id) {
            setTimeout(() => {
                loadLottieAnimation(lottieAnimations.processing);
            }, 1500);
           
            testId = response.test_id;
            retryCount = 0; // Reset Retry Counter
            log("Test started successfully, Test ID:", testId);
            setTimeout(() => {
                pollStatus();
            }, retryDelay);
        } else {
            showError("Keine Test-ID zurückgegeben.");
        }
    
}