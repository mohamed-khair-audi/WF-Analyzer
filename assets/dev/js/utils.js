const log = (...messages) => {
    if (debugMode) console.log("[WF Analyzer]", ...messages);
};

/**
 * Führt eine AJAX-Anfrage aus.
 * @param {string} action - Die Aktion, die auf dem Server ausgeführt werden soll.
 * @param {Object} data - Die Daten, die an den Server gesendet werden sollen.
 * @returns {Promise<Object>} - Die vom Server zurückgegebenen Daten.
 */
async function makeRequest(action, data) {
    console.log("Making AJAX request:", action, data);

    // Füge den Nonce hinzu (Sicherheitstoken)
    data.security = wfAnalyzerVars.nonce;

    try {
        // Sende die AJAX-Anfrage
        const response = await fetch(wfAnalyzerVars.ajax_url, {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({ action, ...data }), // Daten als URL-kodierte Zeichenkette
        });

        // Überprüfe, ob die Antwort erfolgreich war (Statuscode 200-299)
        if (!response.ok) {
            handleError('Netzwerkfehler: ', response.status)
        }

        // Parse die JSON-Antwort
        const result = await response.json();
        console.log("Server response:", result);

        // Überprüfe, ob die Anfrage auf Serverseite erfolgreich war
        if (!result.success) {
            handleError('Anfrage auf Serverseite war nicht erfolgreich', result.data.message)
            return;
        }

        // Gib die Daten zurück
        return result.data;
    } catch (error) {
        // Fehlerbehandlung
        handleError("AJAX Fehler: " + error.message);
    }
}