<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<style>
    /* Styles for the div container */
    .container {
        margin-top: 14rem;
        width: 100%;
        /* Full width */

        /* Light grey background */
        padding: 20px 0;
        /* Some padding at the top and bottom */
        text-align: center;
        /* Center the links */
    }

    /* Base styles for the links */
    .container a {
        color: white;
        /* White text color for contrast */
        text-decoration: none;
        /* Remove underlines from links */
        margin: 0 10px;
        /* Add some space between the links */
        padding: 10px 20px;
        /* Padding for clickable area */
        border-radius: 5px;
        /* Rounded corners for the links */
        transition: background-color 0.3s;
        /* Smooth transition for hover effects */
    }

    /* Specific styles for each link */
    .container a.memberreg {
        background-color: #4CAF50;
        /* Green background */
    }

    .container a.memberrenewal {
        background-color: #2196F3;
        /* Blue background */
    }

    /* Hover effect for links */
    .container a.memberreg:hover {
        background-color: #3e8e41;
        /* Darker green on hover */
    }

    .container a.memberrenewal:hover {
        background-color: #1e88e5;
        /* Darker blue on hover */
    }
</style>
</head>

<body>

    <div class="container">
        <a class="memberreg" href="<?php echo base_url(); ?>/memberreg">Member Registration</a>
        <a class="memberrenewal" href="<?php echo base_url(); ?>/memberrenewalpage">Member Renewal</a>
    </div>

</body>

</html>

</html>