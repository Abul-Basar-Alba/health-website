<?php include '../includes/header.php'; ?>

<div class="contact-container">
<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="/assets/css/style.css">
    <h1><i class="fas fa-envelope"></i> Get in Touch</h1>
    <p class="contact-intro">Have questions about nutrition? Our experts are here to help!</p>
    
    <form class="contact-form" action="submit_contact.php" method="POST">
        <div class="form-group">
            <label for="name"><i class="fas fa-user"></i> Your Name</label>
            <input type="text" id="name" name="name" required 
                   placeholder="Enter your name">
        </div>

        <div class="form-group">
            <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
            <input type="email" id="email" name="email" required 
                   placeholder="Enter your email">
        </div>

        <div class="form-group">
            <label for="message"><i class="fas fa-comment"></i> Your Message</label>
            <textarea id="message" name="message" rows="5" required 
                      placeholder="How can we help you?"></textarea>
        </div>

        <button type="submit">
            <i class="fas fa-paper-plane"></i> Send Message
        </button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>