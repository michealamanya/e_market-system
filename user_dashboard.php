
<?php
session_start(); // Start the session

// Simulating a logged-in user (in a real application, this would come from your authentication system)
if (!isset($_SESSION['username'])) {
    $_SESSION['username'] = 'Guest'; // Default to Guest if not logged in
}

if (isset($_POST['logout'])) {
    session_destroy(); // Destroy the session on logout
    header("Location: " . $_SERVER['PHP_SELF']); // Redirect to the same page after logout
    exit();
}
include_once 'php/db_connect.php'

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>emarket platform</title>
  <link rel="stylesheet" href="stt.css">
</head>

<body>
  <header class="header">
    <div class="container">
    <h1>Welcome to your E-Market Center Mr.<?php echo htmlspecialchars($_SESSION['username']); ?></h1>
      <nav>
        <ul>
          <li><a href="#products">Products</a></li>
          <li><a href="#about">About Us</a></li>
          <li><a href="#blog">Blog</a></li>
          <li><a href="#contact">Contact Us</a></li>
          <li><a href="faq.php">FAQS</a></li>
           <li><a href="php/update user info.php">My Account</a></li>
          <li><a href="php/logout.php">logout</a></li>
          <a href="cartplacement.php" style="position: relative;">
    <img src="images/cart.jpg" width="40" height="40">
    <span id="cart-count" style="position: absolute; top: -10px; right: -10px; background: red; color: white; border-radius: 50%; padding: 2px 6px; font-size: 12px;">
        <?php
            // Check if the user is logged in
            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];
                
                // Get the count of items in the cart for the logged-in user
                $cartCount = isset($_SESSION['cartitems'][$user_id]) ? array_sum(array_column($_SESSION['cartitems'][$user_id], 'quantity')) : 0;
                echo $cartCount;
            } else {
                echo '0'; // Default to 0 if user is not logged in
            }
        ?>
    </span>
</a>
        </ul>
      </nav>
      <div class="search-wrapper">
    <form action="php/search.php" method="GET">
        <input type="text" name="q" placeholder="Search for products..." required>
        <button type="submit">Search</button>
    </form>
</div>

    </div>
  </header>

  <section class="hero">
    <div class="container">
      <h2>Discover a World of Products</h2>
      <p>Welcome to your one-stop shop for all your needs. Explore our wide variety of high-quality products at competitive prices.</p>
      <a href="#products" class="btn">Shop Now</a>
    </div>
  </section>

  <section class="products" id="products">
    <div class="container">
      <h2>Our Products</h2>
      <div class="product-grid">
      <?php
$query = "SELECT * FROM products";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Loop through all the products
    while ($row = $result->fetch_assoc()) {
        $name = $row['name'];
        $description = $row['description'];
        $category = $row['category'];
        $price = $row['price'];
        $image = $row['image'];

        echo "
        <article class='product'>
            <img src='" . $image . "'>
            <h3>" . $name . "</h3>
            <p>" . $description . "</p>
            <span class='price'>$" . $price . "</span>
            <form action='cartplacement.php' method='POST'>
                <input type='hidden' name='product_id' value='" . $row['id'] . "'>
                <input type='hidden' name='name' value='" . $name . "'>
                <input type='hidden' name='price' value='" . $price . "'>
                <button type='submit' class='btn'>Add to Cart</button>
            </form>
        </article>";
    }
} else {
    echo "<p>No products found.</p>";
}
?>

        
        </div>
    </div>
  </section>

  <section class="about" id="about">
    <div class="container">
      <h2>About our E-Market Center</h2>
      <p>We are a leading online retailer dedicated to providing our customers with a convenient and enjoyable shopping experience. We offer a wide range of high-quality products at competitive prices, along with exceptional customer service.</p>
    </div>
  </section>

  <section class="blog" id="blog">
    <div class="container">
      <h2>Explore Our Blog</h2>
      <hr>
      <p>Stay updated on the latest trends, product reviews, and helpful tips by reading our informative blog posts.</p>
      <article class="blog-post">
        <h3>Product reviews</h3>
        <div class="more-content">
            <p>SmartHome 3000: The Ultimate Smart Home Hub
            Rating: ★★★★☆ (4/5)
            
            Overview: The SmartHome 3000 is a state-of-the-art smart home hub designed to centralize and streamline your home automation. With its sleek design and powerful features, it promises to make managing your smart devices easier than ever.
            
            Key Features:
            
            Voice Control: Compatible with Alexa, Google Assistant, and Siri.
            Multi-Device Integration: Supports over 500 smart devices, including lights, thermostats, cameras, and more.
            User-Friendly App: Intuitive app interface for easy setup and control.
            Advanced Security: Built-in encryption and two-factor authentication to protect your data.
            Energy Monitoring: Track and optimize your energy usage.</p>
        </div>
        <a href="#" class="btn" onclick="toggleContent()">Read More</a>
    </article>
    
    <script>
    function toggleContent() {
        var moreContent = document.querySelector('.more-content');
        moreContent.style.display = (moreContent.style.display === 'none' || moreContent.style.display === '') ? 'block' : 'none';
    }
    </script>
      <article class="blog-post">
        <h3>Customer stories</h3>
        <div class="more-content"></div>
        <p>How Sarah Found the Perfect Gift for herself for being supportive to us</p>
         <p> Meet Sarah: Sarah is a busy professional who loves to shop online but often struggles to find the perfect gifts for her friends and family. With a hectic schedule, she needs a reliable and convenient shopping experience.
          
          The Challenge: With her best friend’s birthday approaching, Sarah was on the hunt for a unique and thoughtful gift. She wanted something special but didn’t have the time to browse through multiple stores.
          
          The Solution: Sarah decided to try our e-market center after hearing positive reviews from her colleagues. She was impressed by the wide range of products and the user-friendly interface of our website.
          
          The Experience: Sarah quickly found the perfect gift—a beautifully crafted, personalized jewelry set. The detailed product descriptions and high-quality images helped her make an informed decision. She also appreciated the customer reviews, which gave her confidence in her choice.
          
          The Outcome: The gift arrived on time, beautifully packaged, and exceeded Sarah’s expectations. Her best friend was thrilled with the thoughtful and unique present. Sarah was delighted with the seamless shopping experience and the excellent customer service she received.
          
          Sarah’s Words: “I was blown away by the variety and quality of products available at the e-market center. The entire process was so smooth, from browsing to checkout. My friend loved the gift, and I couldn’t be happier. I’ll definitely be shopping here again!”
          
          Customer Story: John’s Home Office Makeover
          Meet John: John is a freelance graphic designer who recently decided to upgrade his home office. He needed ergonomic furniture and high-tech gadgets to create a productive and comfortable workspace.
          
          The Challenge: John was overwhelmed by the options available online and wanted to find a one-stop shop where he could get everything he needed without compromising on quality.
          
          The Solution: John discovered our e-market center through a recommendation from a fellow freelancer. He was impressed by the curated selection of office furniture and tech gadgets.
          
          The Experience: John found everything he needed, from an ergonomic chair to a state-of-the-art monitor. The detailed product specifications and customer reviews helped him make the right choices. He also took advantage of our special discounts and free shipping offer.
          
          The Outcome: John’s home office makeover was a huge success. The new setup not only improved his productivity but also made his workspace more comfortable and stylish. He received numerous compliments from clients during video calls.
          
          John’s Words: “The e-market center made my home office upgrade so easy and stress-free. The quality of the products is top-notch, and the customer service was excellent. I highly recommend it to anyone looking to enhance their workspace.”</p>
          <a href="#" class="btn" onclick="toggleContent()">Read More</a>
      </article>
      <article class="blog-post">
        <h3>Meet the scenes behind our foundation</h3>
        <div class="more-content"></div>
        <p>
          Welcome to a special behind-the-scenes look at our foundation! We are excited to share the stories, people, and passion that drive our mission. Our foundation is more than just an organization; it’s a community of dedicated individuals working together to make a difference. Let’s take a closer look at the heart and soul of our foundation.
          
          Our Mission and Vision
          At the core of our foundation is a commitment to serving. We strive to serve, and every day, our team works tirelessly to bring this vision to life.
          
          Meet Our Team
          Our team is composed of passionate professionals from diverse backgrounds, each bringing unique skills and perspectives to the table. Here are a few key members:
          
          Darius, Executive Director: With over 10 years of experience in trading, darius leads our foundation with a vision for development. He is dedicated to serving.
          Marvellous, Program Manager:Marvellous oversees our various programs, ensuring they run smoothly and effectively. He has a background in computing and a passion for serving.
         manzi, Volunteer Coordinator: Our volunteers are the backbone of our foundation, and manzi ensures they are well-supported and engaged.he has a knack for bringing people together and fostering a sense of community.
          Our Programs and Initiatives
          We are proud of the diverse range of programs and initiatives we offer. Here are a few highlights:
          
          gaming: This program focuses on recreation. It has helped 6 of individuals by health.
          Coperation: Aimed at unity, this initiative has made significant strides in togetherness.
          Renovation: Our annual Renovation brings together community members to health standards. It’s a day filled with activities, workshops, etc..
          Behind the Scenes: A Day in the Life
          Ever wondered what a typical day looks like at our foundation? Here’s a glimpse:
          
          Morning: Our team starts the day with a brief meeting to discuss goals and updates. We then dive into our tasks, whether it’s planning events, coordinating with partners, or working on new projects.
          Afternoon: This is when we often meet with community members, volunteers, and stakeholders. We also spend time reviewing progress and making adjustments to our strategies.
          Evening: As the day winds down, we reflect on our achievements and plan for the next day. It’s a time for collaboration and brainstorming new ideas.
          Our Impact
          We are proud of the impact we’ve made so far. Here are a few success stories:
          
         
          Get Involved
          We are always looking for passionate individuals to join our cause. Whether you want to volunteer, donate, or simply learn more, there are many ways to get involved:
          
          Volunteer: Join our team of dedicated volunteers and make a difference in your community.
          Donate: Your contributions help us continue our important work. Every donation, big or small, makes an impact.
          Spread the Word: Follow us on social media, share our stories, and help us reach more people.
          Thank you for taking the time to learn more about our foundation. Together, we can achieve great things and make a lasting impact. Stay tuned for more updates and stories from behind the scenes!
          </p>
          <a href="#" class="btn" onclick="toggleContent()">Read More</a>
      </article>
      </div>
  </section>

  <section class="contact" id="contact">
    <div class="container">
        <h2>Contact Us</h2>
        <p>Have any questions or need assistance? Feel free to <a href="contact">contact us</a>.</p>
        
        <div class="contact-methods">
            <div class="contact-item">
                <h4>Email Us</h4>
                <p><a href="mailto:amanyamicheal770@gmail.com">amanyamicheal770@gmail.com</a></p>
            </div>
            <div class="contact-item">
                <h4>Call Us</h4>
                <p><a href="tel:+256706590566">+256 706 590 566</a></p>
            </div>
            <div class="contact-item">
                <h4>Follow Us</h4>
                <a href="https://www.facebook.com" target="_blank">
                    <img src="images/facebook.jpeg" alt="Facebook">
                </a>
                <a href="https://www.twitter.com" target="_blank">
                    <img src="images/twitter.jpeg" alt="Twitter">
                </a>
                <a href="https://www.instagram.com" target="_blank">
                    <img src="images/instagram.jpeg" alt="Instagram">
                </a>
            </div>
        </div>
    </div>
</section>
       <footer>
        <p>&copy; 2024 Emarket services. All rights reserved.</p>
    </footer>
    
</body>
<script>
  function toggleContent(event) {
    event.preventDefault(); // Prevent default anchor behavior
    const moreContent = event.target.previousElementSibling; // Get the previous sibling which is more-content container
    if (moreContent.style.display === "none") {
      moreContent.style.display = "block"; // Show the content
      event.target.innerText = "Read Less"; // Change the button text
    } else {
      moreContent.style.display = "none"; // Hide the content
      event.target.innerText = "Read More"; // Change the button text back
    }
  }
  </script>
  <script>
    
    function addToCart(productName, price) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let productExists = cart.find(item => item.name === productName);

    if (productExists) {
        productExists.quantity += 1;
    } else {
        cart.push({ name: productName, price: price, quantity: 1 });
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    alert(`${productName} has been added to your cart!`); // User notification

    window.location.href = "cartplacement.php";
  }

</script>
</head>
</html>
