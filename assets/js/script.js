document.getElementById('healthForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const weight = document.getElementById('weight').value;
    
    fetch('calculate.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `weight=${weight}`
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.error) {
            throw new Error(data.error);
        }
        alert(`Protein Needs: ${data.protein}g\nCalcium Needs: ${data.calcium}mg`);
    })
    .catch(error => {
        alert('Error: ' + error.message);
    });
});