function updatePageWithNewDate(change) {
    var currentDate = document.getElementById("date").value;
    var currentScale = parseInt(document.getElementById("scale").value);
    
    var dateObj = new Date(currentDate);
    
    var unitToAdd = 1;
    if (currentScale === 1) {
        unitToAdd = 7; 
    } else if (currentScale === 2) {

        if (change === 'prev') {
            dateObj.setMonth(dateObj.getMonth() - 1);
        } else if (change === 'next') {
            dateObj.setMonth(dateObj.getMonth() + 1); 
            unitToAdd=0;
        }
    }
    
    if (change === 'prev') {
        dateObj.setDate(dateObj.getDate() - unitToAdd); 
    } else if (change === 'next') {
        dateObj.setDate(dateObj.getDate() + unitToAdd); 
    }

    // Convertir la nouvelle date en format YYYY-MM-DD
    var newDate = dateObj.toISOString().slice(0, 10);

    window.location.href = "?date=" + newDate + "&scale=" + currentScale;
}
