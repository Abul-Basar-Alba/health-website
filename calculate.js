document.getElementById('healthForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);
    const response = await fetch('calculate.php', {
        method: 'POST',
        body: formData
    });

    const result = await response.json();

    if (result.error) {
        alert('Error: ' + result.error);
        return;
    }

    // Display results
    const resultDiv = document.createElement('div');
    resultDiv.className = 'result-container';
    resultDiv.innerHTML = `
        <h2>Your Nutrition Needs</h2>
        <p><strong>BMI:</strong> ${result.bmi}</p>
        <p><strong>BMR:</strong> ${result.bmr}</p>
        <p><strong>Protein:</strong> ${result.protein}</p>
        <p><strong>Calcium:</strong> ${result.calcium}</p>
        <p><strong>Vitamin C:</strong> ${result.vitamin_c}</p>
        <p><strong>Vitamin D:</strong> ${result.vitamin_d}</p>
        <p><strong>Fiber:</strong> ${result.fiber}</p>
        <p><strong>Iron:</strong> ${result.iron}</p>
        <p><strong>Magnesium:</strong> ${result.magnesium}</p>
        <p><strong>Potassium:</strong> ${result.potassium}</p>
        <p><strong>Water:</strong> ${result.water}</p>
    `;
    document.querySelector('.container').appendChild(resultDiv);
});