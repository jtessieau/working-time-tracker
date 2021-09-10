<div class="container">
    <div class="block mx-auto" style="width: 300px">
        <form method="post">
            <div class="field">
                <label class="label" for="firstName">First Name</label>
                <div class="control has-icons-left">
                    <input
                            class="input"
                            type="text"
                            id="firstName"
                            name="firstName"
                            value="<?php echo isset($_POST['firstName']) ? $_POST['firstName'] : '' ?>"
                            required
                    >
                    <span class="icon is-small is-left">
                        <i class="fas fa-user-circle"></i>
                    </span>
                    <?php
                        if (!empty($errors['firstName'])) {
                            echo '<p class="help is-danger">' . $errors['firstName'] . '</p>';
                        }
                    ?>
                </div>
            </div>
            <div class="field">
                <label class="label" for="lastName">Last Name</label>
                <div class="control has-icons-left">
                    <input
                            class="input"
                            type="text"
                            id="lastName"
                            name="lastName"
                            value="<?php echo isset($_POST['lastName']) ? $_POST['lastName'] : '' ?>"
                            required
                    >
                    <span class="icon is-small is-left">
                        <i class="fas fa-user-circle"></i>
                    </span>
                    <?php
                    if (!empty($errors['lastName'])) {
                        echo '<p class="help is-danger">' . $errors['lastName'] . '</p>';
                    }
                    ?>
                </div>
            </div>


            <div class="field">
                <label class="label" for="email">Email</label>
                <div class="control has-icons-left">
                    <input
                            class="input"
                            type="email"
                            id="email"
                            name="email"
                            value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>"
                            required>
                    <span class="icon is-small is-left">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <?php
                    if (!empty($errors['email'])) {
                        echo '<p class="help is-danger">' . $errors['email'] . '</p>';
                    }
                    ?>
                </div>
            </div>

            <div class="field">
                <label class="label" for="password">Password</label>
                <div class="control has-icons-left">
                    <input class="input" type="password" id="password" name="password" required>
                    <span class="icon is-small is-left">
                        <i class="fas fa-key"></i>
                    </span>
                    <?php
                    if (!empty($errors['password'])) {
                        echo '<p class="help is-danger">' . $errors['password'] . '</p>';
                    }
                    ?>
                </div>
            </div>

            <div class="field">
                <label class="label" for="password2">Re-enter Password</label>
                <div class="control has-icons-left">
                    <input class="input" type="password" id="password2" name="password2" required>
                    <span class="icon is-small is-left">
                        <i class="fas fa-key"></i>
                    </span>
                </div>
            </div>

            <div class="field is-grouped is-grouped-centered">
                <div class="control">
                    <button class="button is-link">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
