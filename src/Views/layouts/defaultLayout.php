<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>test</title>
</head>

<body>
    <nav class="navbar" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a class="navbar-item" href="https://bulma.io">
                <img src="https://bulma.io/images/bulma-logo.png" width="112" height="28">
            </a>

            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="navbarBasicExample" class="navbar-menu">
            <div class="navbar-start">
                <a href="/" class="navbar-item">
                    Home
                </a>

                <a href="/job" class="navbar-item">
                    My jobs
                </a>
            </div>

            <div class="navbar-end">
                <div class="navbar-item">
                    <?php
                    if (!isset($_SESSION['user'])) {
                    ?>
                        <div class="buttons">
                            <a href="/signin" class="button is-primary">
                                <strong>Sign in</strong>
                            </a>
                            <a href="login" class="button is-light">
                                Log in
                            </a>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="buttons">
                            <a href="#" class="button is-primary">
                                <?= $_SESSION['user']['firstName'] . ' ' . $_SESSION['user']['lastName'] ?>
                            </a>
                            <a href="/logout" class="button is-light">
                                Log out
                            </a>
                        </div>

                    <?php
                    }
                    ?>

                </div>
            </div>
        </div>
    </nav>

    <?= $pageContent ?>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // Get all "navbar-burger" elements
            const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

            // Check if there are any navbar burgers
            if ($navbarBurgers.length > 0) {

                // Add a click event on each of them
                $navbarBurgers.forEach(el => {
                    el.addEventListener('click', () => {

                        // Get the target from the "data-target" attribute
                        const target = el.dataset.target;
                        const $target = document.getElementById(target);

                        // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
                        el.classList.toggle('is-active');
                        $target.classList.toggle('is-active');

                    });
                });
            }

        });
    </script>
</body>

</html>