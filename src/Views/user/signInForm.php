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
                        value="<?php echo htmlspecialchars($_POST['firstName']) ?? '' ?>"
                    >
                    <span class="icon is-small is-left">
                        <i class="fas fa-user-circle"></i>
                    </span>
                </div>
                <span class="help is-danger">
                    <?php echo $errorMessages['firstName'] ?? ''; ?>
                </span>
            </div>

            <div class="field">
                <label class="label" for="lastName">Last Name</label>
                <div class="control has-icons-left">
                    <input
                        class="input"
                        type="text"
                        id="lastName"
                        name="lastName"
                        value="<?php echo htmlspecialchars($_POST['lastName']) ?? '' ?>"
                    >
                    <span class="icon is-small is-left">
                        <i class="fas fa-user-circle"></i>
                    </span>
                </div>
                <span class="help is-danger">
                    <?php echo $errorMessages['lastName'] ?? ''; ?>
                </span>
            </div>

            <div class="field">
                <label class="label" for="email">Email</label>
                <div class="control has-icons-left">
                    <input
                        class="input"
                        type="email"
                        id="email"
                        name="email"
                        value="<?php echo htmlspecialchars($_POST['email']) ?? '' ?>"
                    >
                    <span class="icon is-small is-left">
                        <i class="fas fa-envelope"></i>
                    </span>
                </div>
                <span class="help is-danger">
                    <?php echo $errorMessages['email'] ?? ''; ?>
                </span>
            </div>

            <div class="field">
                <label class="label" for="password">Password</label>
                <div class="control has-icons-left">
                    <input class="input" type="password" id="password" name="password">
                    <span class="icon is-small is-left">
                        <i class="fas fa-key"></i>
                    </span>
                </div>
            </div>

            <div class="field">
                <label class="label" for="password2">Re-enter Password</label>
                <div class="control has-icons-left">
                    <input class="input" type="password" id="password2" name="password2">
                    <span class="icon is-small is-left">
                        <i class="fas fa-key"></i>
                    </span>
                </div>
                <span class="help is-danger">
                    <?php echo $errorMessages['password'] ?? ''; ?>
                </span>
            </div>

            <div class="field is-grouped is-grouped-centered">
                <div class="control">
                    <button class="button is-link">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
