<div class="card">
    <div class="card-content">
        <div class="media">
            <div class="media-content">
                <p class="title is-4"><?= "{$userData['first_name']} {$userData['last_name']}" ?></p>
                <p class="subtitle is-6"><?= $userData['email'] ?></p>
            </div>
        </div>
    </div>
</div>

<a href="/user/email">Modify email address</a>
<a href="/user/password">Modify password</a>