<div class="container">
    <div class="block mx-auto" style="width: 300px">
        <form method="post">
            <div class="field">
                <label class="label" for="email">Email</label>
                <div class="control has-icons-left">
                    <input
                            class="input"
                            type="text"
                            id="email"
                            name="email"
                            value="<?php echo $_POST['email'] ?? '' ?>"
                            >
                    <span class="icon is-small is-left">
                    <i class="fas fa-envelope"></i>
                </span>
                </div>
                <span class="help is-danger"><?php echo $errorMessages['email'] ?? '' ?></span>
            </div>

            <div class="field">
                <label class="label" for="password">Password</label>
                <div class="control has-icons-left">
                    <input class="input" type="password" id="password" name="password">
                    <span class="icon is-small is-left">
                        <i class="fas fa-key"></i>
                    </span>
                </div>
                <span class="help is-danger"><?php echo $errorMessages['password'] ?? '' ?></span>
            </div>

            <span class="help is-danger"><?php echo $errorMessages['connection'] ?? '' ?></span>

            <div class="field is-grouped is-grouped-centered">
                <div class="control">
                    <button class="button is-link">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
