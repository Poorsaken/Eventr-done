<?php
include('./routes/router.php');

// PHP code goes here
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/sidetabs.css"/>
    <script>
        // Function to set the active navlink
        function setActiveNavLink(id) {
            // Remove active class from all navlinks
            const navlinks = document.querySelectorAll('.navlinks');
            navlinks.forEach(link => link.classList.remove('active'));

            // Add active class to the current navlink
            document.getElementById(id).classList.add('active');

            // Store the active navlink in localStorage
            localStorage.setItem('activeNavLink', id);
        }
        // Function to load the active navlink from localStorage on page load
        function loadActiveNavLink() {
            const activeNavLink = localStorage.getItem('activeNavLink');
            if (activeNavLink) {
                document.getElementById(activeNavLink).classList.add('active');
            } else {
                // Default to the first navlink if no active link is found
                document.getElementById('active-events').classList.add('active');
            }
        }

        // Call loadActiveNavLink when the page loads
        window.onload = loadActiveNavLink;
    </script>
</head>
<body>

<div class="parents">
    <div class="logo">
        <h1>Eventr</h1>
    </div>

   
    <div class="navlinks" id="active-events">
        <div class="nav_icon">
            <img src="./img/active_icon.png"/>
        </div>
        <div class="nav_title">
            <a onclick="ActiveEvents(); setActiveNavLink('active-events')">Active Events</a>
        </div>
    </div>

    <div class="navlinks" id="cancelled-events">
        <div class="nav_icon">
            <img src="./img/cancel_icon.png"/>
        </div>
        <div class="nav_title">
            <a onclick="CancelledEvents(); setActiveNavLink('cancelled-events')">Cancelled Events</a>
        </div>
    </div>
   
    <div class="navlinks" id="add-event">
        <div class="nav_icon">
            <img src="./img/addevent_icon.png"/>
        </div>
        <div class="nav_title">
            <a onclick="AddEvents(); setActiveNavLink('add-event')">Add Event</a>
        </div>
    </div>

    <div class="navlinks" id="update-event">
        <div class="nav_icon">
            <img src="./img/updateevent_icon.png"/>
        </div>
        <div class="nav_title">
            <a onclick="UpdateEvents(); setActiveNavLink('update-event')">Update Event</a>
        </div>
    </div>

    <div class="navlinks" id="delete-event">
        <div class="nav_icon">
            <img src="./img/delete_icon.png"/>
        </div>
        <div class="nav_title">
            <a onclick="DeleteEvents(); setActiveNavLink('delete-event')">Delete Event</a>
        </div>
    </div>

    <div class="logout" onclick="Logout()">
        <div class="logout_text">
            <a class="logoutdiv">Logout</a>
        </div>
        <div class="logout_icon">
            <img src="../img/Vector.png" alt="">
        </div>
    </div>
</div>

</body>
</html>
