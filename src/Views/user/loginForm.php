<div class="section">
    <div class="columns is-vcentered" style="min-height:80vh;">
        <div class="column">
            <div class="card m-auto" style="max-width: 600px;">
                <div class="card-header">
                    <h1 class="card-header-title is-centered is-size-4">Login</h1>
                    <span class="card-header-icon is-size-4">
                        <i class="fas fa-user"></i>
                    </span>
                </div>
                <div class="card-content">
                    <form method="post">
                        <div class="field is-horizontal">
                            <div class="field-label is-normal">
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
                            <div class="field-label is-normal">
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
                                <button class="button is-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <p class="card-footer-item">
                        <span>
                            If you don't have an account, you can <a href="/signin">register here</a>.
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>