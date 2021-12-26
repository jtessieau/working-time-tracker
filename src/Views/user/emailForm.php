<div class="container">
    <h1 class="title has-text-centered">Modify e-mail address</h1>
    <div class="block mx-auto" style="width: 300px">
        <form method="post">
            <div class="field">
                <label class="label" for="email">Email</label>
                <div class="control has-icons-left">
                    <input class="input" type="text" id="email" name="email" value="<?= $email ?? '' ?>">
                    <span class="icon is-small is-left">
                        <i class="fas fa-envelope"></i>
                    </span>
                </div>
            </div>
            <div class="field">
                <label class="label" for="emailConfirmation">Confirm Email</label>
                <div class="control has-icons-left">
                    <input class="input" type="text" id="emailConfirmation" name="emailConfirmation">
                    <span class="icon is-small is-left">
                        <i class="fas fa-envelope"></i>
                    </span>
                </div>
                <span class="help is-danger"><?php echo $errorMessages['email'] ?? '' ?></span>
            </div>

            <div class="field is-grouped is-grouped-centered">
                <div class="control">
                    <button class="button is-link">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
var_dump($errorMessages);
?>