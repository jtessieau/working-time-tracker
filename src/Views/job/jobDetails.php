<div class="section">
    <h1 class="title"><?= $job['job_designation']; ?></h1>
    <p class="subtitle"><?= ucfirst($job['company_name']); ?></p>

    <a href="/job/update/<?= $job['id']; ?>" class="button is-info">
        <i class="far fa-edit mr-2"></i>Edit
    </a>
    <a href="/job/delete/<?= $job['id']; ?>" class="button is-danger">
        <i class="far fa-trash-alt mr-2"></i>Delete
    </a>

    <?php
    $startDate = new DateTime($job['job_start_date']);

    if ($job['job_end_date'] == null) {
        $active = true;
    } else {
        $active = false;
    }
    ?>
    <?php if ($active) : ?>
        <a href="/job/checkin/<?= $job['id']; ?>" class="button is-primary">
            <i class="far fa-calendar-plus mr-2"></i>Checkin
        </a>
    <?php endif; ?>
</div>

<div class="section">
    <h2 class="title is-4">Last 10 check-ins</h2>
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