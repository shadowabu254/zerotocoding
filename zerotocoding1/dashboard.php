<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Creators Team</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/9848aaebde.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Inside the <nav> element -->
   <!-- <video autoplay muted loop id="video-bg">
    <source src="images/orbit.mp4" type="video/mp4">
    Your browser does not support the video tag.
</video>
<!-- Add additional source tags if necessary for other video formats -->
    <div id="header">
        <div class="container">
            <nav>
                <img style="border-radius: 1000px;" src="images/digitalcreator.png" class="logo" alt="icon">
                <ul id="sidemenu">
                    <li><a href="dashboard.php">Home</a></li>
                    <li><a href="about.html">About</a></li>
                    <li><a href="service.html">Services</a></li>
                    <li><a href="projects.html">Projects</a></li>
                    <li><a href="news.html">News&Events</a></li>
                    <li><a href="faqs.html">FAQs</a></li>
                    <li><a href="index.php">Contact Us</a></li>
                    <i class="fa-solid fa-xmark" onclick="closemenu()"></i>
                </ul>
                <i class="fa-solid fa-bars" onclick="openmenu()"></i>
            </nav>
            <input type="text" id="search-box" placeholder="Search...">
            <div id="search-results"></div>
            
            <div class="header-text">
                <h2 style="color: green;"><b><u>We Are:</u></b></h2>
                <p>Web Developers</p>
                <p>Computer Programmers</p>
                <p>Technical Writers</p>
                <p>Project Managers</p>
                <p>Cyber Security Enthuasists</p>
                <p>Database Managers</p>
                <h1>Hi, We are <span>Digital Creators </span><br>from Kenya</h1>
            </div>
        </div>
    </div>
    <script>
        var sidemenu=document.getElementById("sidemenu")
        function openmenu(){
            sidemenu.style.right="0"
        }
        function closemenu(){
            sidemenu.style.right="-200px"
        }
    </script>
      <!-- Add this script tag at the end of your HTML body -->

      <script>
   // Function to handle search
   function search() {
        var searchTerm = document.getElementById("search-box").value.trim().toLowerCase();
        
        if (searchTerm === "") {
            document.getElementById("search-results").innerHTML = "";
            return;
        }

        var content = document.body.innerText;
        var matches = content.match(new RegExp(searchTerm, "gi"));

        if (matches) {
            var resultsHtml = "<ul>";
            matches.forEach(function(match, index) {
                var id = "match-" + index;
                var highlightedMatch = "<span class='highlight' id='" + id + "'>" + match + "</span>";
                resultsHtml += "<li><a href='#" + id + "'>" + highlightedMatch + "</a></li>";
            });
            resultsHtml += "</ul>";
            document.getElementById("search-results").innerHTML = resultsHtml;

            // Scroll to the location of the match when clicked
            document.querySelectorAll("#search-results a").forEach(function(link) {
                link.addEventListener("click", function(event) {
                    var targetId = this.getAttribute("href").substring(1);
                    var targetElement = document.getElementById(targetId);
                    targetElement.scrollIntoView({ behavior: "smooth" });
                    event.preventDefault(); // Prevent default link behavior
                });
            });
        } else {
            document.getElementById("search-results").innerHTML = "No matches found.";
        }
    }

    // Event listener for search box
    document.getElementById("search-box").addEventListener("input", search);
</script>
<div class="copyright">
        <p>Copyright &copy;DigitalCreators. Made By <i class="fa-solid fa-heart"></i>@digitalcreator</p>
    </div>
</body>
</html>