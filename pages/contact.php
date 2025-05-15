<?php include '../includes/header.php'; ?>

<div class="contact-container">
    <h1><i class="fas fa-envelope"></i> Get in Touch</h1>
    <p class="contact-intro">Have questions about nutrition? Our experts are here to help!</p>
    
    <form class="contact-form" action="submit_contact.php" method="POST">
        <div class="form-group">
            <label for="name"><i class="fas fa-user"></i> Your Name</label>
            <input type="text" id="name" name="name" required placeholder="Enter your name">
        </div>
        <div class="form-group">
            <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
            <input type="email" id="email" name="email" required placeholder="Enter your email">
        </div>
        <div class="form-group">
            <label for="weight"><i class="fas fa-weight"></i> Weight (kg)</label>
            <input type="number" id="weight" name="weight" min="0" step="0.1" required placeholder="Enter your weight in kg">
        </div>
        <div class="form-group">
            <label for="age"><i class="fas fa-birthday-cake"></i> Age</label>
            <input type="number" id="age" name="age" min="1" required placeholder="Enter your age">
        </div>
        <div class="form-group">
            <label for="height"><i class="fas fa-ruler-vertical"></i> Height (cm)</label>
            <input type="number" id="height" name="height" min="0" step="0.1" required placeholder="Enter your height in cm">
        </div>
        <div class="form-group">
            <label for="district"><i class="fas fa-map-marker-alt"></i> District</label>
            <input type="text" id="district" name="district" required placeholder="Enter your district">
        </div>
        <div class="form-group">
            <label for="country"><i class="fas fa-globe"></i> Country</label>
            <input type="text" id="country" name="country" required placeholder="Enter your country">
        </div>
        <div class="form-group">
            <label for="message"><i class="fas fa-comment"></i> Your Message</label>
            <textarea id="message" name="message" rows="5" required placeholder="How can we help you?"></textarea>
        </div>
        <button type="submit"><i class="fas fa-paper-plane"></i> Send Message</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>