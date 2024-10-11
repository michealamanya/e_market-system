<?php
$title = "FAQ - E-Market";
$page = "faq";
include 'header.php';

// Array of FAQs
$faqs = [
    ["What is E-Market?", "E-Market is an online platform where you can buy and sell a wide range of products."],
    ["How do I create an account?", "To create an account, click on the <a href='signup.php'>Sign Up</a> button and fill in your details. If you already have an account, click on <a href='login.php'>Login</a>."],
    ["What payment methods are accepted?", "We accept credit/debit cards, PayPal, bank transfers, and mobile money options (Airtel, MTN)." ],
    ["How can I track my order?", "Once your order is shipped, you will receive a tracking number via email. You can track your order on our website and pick up from designated stations by presenting your receipt."]
];
?>

<div class="container">
    <section class="faq-section">
        <h2>Frequently Asked Questions</h2>
        <?php foreach ($faqs as $faq) : ?>
            <div class="faq">
                <h3><?php echo $faq[0]; ?></h3>
                <p><?php echo $faq[1]; ?></p>
            </div>
        <?php endforeach; ?>
    </section>
</div>

<script>
    document.querySelectorAll('.faq h3').forEach(faq => {
        faq.addEventListener('click', () => {
            faq.nextElementSibling.style.display = faq.nextElementSibling.style.display === 'block' ? 'none' : 'block';
        });
    });
</script>

<?php include 'footer.php'; ?>
