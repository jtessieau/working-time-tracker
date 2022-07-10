<div class="section">
    <h1 class="title"><?= $job['job_designation']; ?></h1>
    <p class="subtitle"><?= ucfirst($job['company_name']); ?></p>

    <h2>Last 10 check-ins</h2>
    <?php if (count($checkins) > 0) : ?>
        <ul>
            <?php foreach ($checkins as $checkin) : ?>
                <li>
                    From
                    <?= $checkin['checkin_start_datetime']; ?>
                    to
                    <?= $checkin['checkin_end_datetime']; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif ?>
</div>