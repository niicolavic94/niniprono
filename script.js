document.querySelector('.hero button').addEventListener('click', function() {
    alert('Merci pour votre abonnement!');
});

// Ajoutez d'autres fonctionnalités JavaScript ici
    // Get today's date
        let today = new Date();
        let day = today.getDate();
        let month = today.getMonth() + 1; // Months are zero-based
        let year = today.getFullYear();

        // Ensure leading zeros for day and month
        day = (day < 10) ? '0' + day : day;
        month = (month < 10) ? '0' + month : month;

        // Combine the date components
        let formattedDate = day + '/' + month + '/' + year;

        // Update the HTML element
        document.getElementById("date-jour").textContent = formattedDate;

        // Calculate the date for next week
        let nextWeek = new Date(today.getFullYear(), today.getMonth(), today.getDate() + 7);
        let nextWeekDay = nextWeek.getDate();
        let nextWeekMonth = nextWeek.getMonth() + 1;
        let nextWeekYear = nextWeek.getFullYear();

        // Ensure leading zeros for day and month
        nextWeekDay = (nextWeekDay < 10) ? '0' + nextWeekDay : nextWeekDay;
        nextWeekMonth = (nextWeekMonth < 10) ? '0' + nextWeekMonth : nextWeekMonth;

        let formattedNextWeekDate = nextWeekDay + '/' + nextWeekMonth + '/' + nextWeekYear;
        document.getElementById("date-semaine").textContent = formattedNextWeekDate;




        