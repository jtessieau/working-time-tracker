<div class="section">
    <div class="container" style="max-width:700px">
        <h1 class="title has-text-centered">Login</h1>
        <form method="post">
            <div class="field is-horizontal">
                <div class="field-label">
                    <label class="label" for="email">Email</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control has-icons-left">
                            <input class="input" type="text" id="email" name="email" value="<?php echo $_POST['email'] ?? '' ?>">
                            <span class="icon is-small is-left">
                                <i class="fas fa-envelope"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <span class="help is-danger"><?php echo $errorMessages['email'] ?? '' ?></span>

            </div>

            <div class="field is-horizontal">
                <div class="field-label">
                    <label class="label" for="password">Password</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control has-icons-left">
                            <input class="input" type="password" id="password" name="password">
                            <span class="icon is-small is-left">
                                <i class="fas fa-key"></i>
                            </span>
                        </div>
                    </div>
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