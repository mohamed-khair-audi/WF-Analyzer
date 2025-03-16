const pollStatus = async () => {
    if (!testId) {
       showError("Kein Test gefunden.");
        return;
    }

    try {
        log("Checking status for Test ID:", testId);
        updateStatus("Überprüfe Teststatus...");

        const response = await makeRequest("wf_get_report", { test_id: testId });

        if (response.pending) {
            handlePendingStatus(response);
            return;
        }

        handleCompletedStatus(response);
    } catch (error) {
        handleError("Fehler beim Überprüfen des Status", error);
    }
};

/**
 * Handles the case where the test is still pending.
 */
const handlePendingStatus = (response) => {
    log(response.message || "Test läuft noch, retrying...");

    if (retryCount >= maxRetries) {
       showError("Maximale Anzahl an Versuchen erreicht.");
        return;
    }

    retryCount++;
    retryDelay = Math.min(retryDelay * 1.5, 30000); // Max 30s
    setTimeout(() => pollStatus(), retryDelay);
};

/**
 * Handles the case where the test is completed and updates the UI.
 */
const delay = (ms) => new Promise(resolve => setTimeout(resolve, ms));

async function handleCompletedStatus  (response)  {

    log("Test abgeschlossen, sende Daten ans Frontend.");
   

    if (!response.gtmetrix_score) {
        showError("Unbekannte Server-Antwort.");
        return;
    }

    try {
        await delay(1550); // Wait before starting the animation
        loadLottieAnimation(lottieAnimations.done); // Load animation
        updateStatus("Test abgeschlossen.");
        await delay(1700); // Wait while animation is showing
        clearLottieAnimation(); // Clear the animation
        document.getElementById("wf-analyzer-result").scrollIntoView({
            behavior: 'smooth',  // For smooth scrolling
            block: 'start'       // Adjusts where the element aligns (top of the viewport)
        });
        updateResults(response); // Update results after the animation
        
    } catch (error) {
        handleError('Error during result update:', error);
        return;
        // Optionally, you could handle errors more gracefully (e.g., show a message to the user)
    }
};
