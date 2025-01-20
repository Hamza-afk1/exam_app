// resources/js/dashboard.js

setInterval(function() {
    fetch('/api/dashboard-data')
        .then(response => response.json())
        .then(data => {
            document.getElementById('totalFormateurs').innerText = data.totalFormateurs;
            document.getElementById('totalStagiaires').innerText = data.totalStagiaires;
            document.getElementById('totalUsers').innerText = data.totalUsers;
            document.getElementById('totalGroups').innerText = data.totalGroups;
        });
}, 60000); // Updates every 60 seconds
