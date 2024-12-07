<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <style>
        
        body {
            background-color: #23a018;
            color: #118a2f;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        header {
            background-color: #333;
            color: #1f8916;
            padding: 15px 0;
        }

        .container {
            width: 80%;
            margin: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        h1 {
            font-size: 2rem;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        nav ul li {
            display: inline;
            margin: 0 10px;
        }

        nav ul li a {
            color: #117f1c;
            text-decoration: none;
        }

        nav ul li a:hover {
            text-decoration: underline;
        }

        .hero {
            background-image: url('background.jpg');
            background-size: cover;
            background-position: center;
            color: #fff;
            text-align: center;
            padding: 100px 20px;
        }

        .hero h2 {
            font-size: 2.5rem;
        }

        .hero p {
            font-size: 1.2rem;
            margin: 20px 0;
        }

        .btn {
            background-color: #5cb85c;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .btn:hover {
            background-color: #4cae4c;
        }

        footer {
            background-color: #3a3535;
            color: #1b9c2a;
            text-align: center;
            padding: 10px 0;
            margin-top: 20px;
        }

      
        @media (max-width: 768px) {
         
            .container {
                flex-direction: column;
                align-items: flex-start;
            }

            .container h1 {
                font-size: 1.5rem;
                margin-bottom: 10px;
            }

            nav ul {
                text-align: center;
                width: 100%;
            }

            nav ul li {
                display: block;
                margin: 5px 0;
            }

           
            .hero {
                padding: 60px 20px;
            }

            .hero h2 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .btn {
                padding: 8px 16px;
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            
            .hero h2 {
                font-size: 1.8rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .btn {
                padding: 6px 14px;
                font-size: 0.9rem;
            }

            footer {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>Zero-To-One</h1>
            <nav>
                <ul>
                    <li><a href="about.php">About</a></li>
                    <li><a href="service.php">Services</a></li>
                    <li><a href="cusview.php">Customers</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="reg.php">SignUp</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <section class="hero">
            <h2>Your Gateway to Quality Services</h2>
            <p>Explore our offerings and see how we can serve you.</p>
            <a href="service.php" class="btn">Learn More</a>
        </section>
    </main>

    <footer>
        <p> Zero-To-One beauty care service center. All rights reserved.</p>
    </footer>
</body>
</html>
