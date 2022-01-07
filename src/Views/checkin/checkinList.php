<div class="section">
    <div class="container">
        <h1 class="title has-text-centered">Check-in list for <?= ucwords($job['job_designation']) ?> at <?= ucwords($job['company_name']) ?></h1>
        <table class="table mx-auto">
            <thead>
                <td class="has-text-centered">Start date</td>
                <td class="has-text-centered">End date</td>
                <td class="has-text-centered">Break time</td>
                <td class="has-text-centered">Job time</td>
                <td class="has-text-centered">Edit</td>
                <td class="has-text-centered">Delete</td>
            </thead>
            <tbody>

                <?php
                foreach ($checkins as $checkin) :
                    $startDate = strtotime($checkin['checkin_start_datetime']);
                    $endDate = strtotime($checkin['checkin_end_datetime']);

                    $jobTimeInSeconds = $endDate - $startDate - ($checkin['checkin_break_time'] * 60);
                    $jobTimeInHours = $jobTimeInSeconds / 60 / 60;
                ?>

                    <tr>
                        <td class="has-text-centered"><?= $checkin['checkin_start_datetime'] ?></td>
                        <td class="has-text-centered"><?= $checkin['checkin_end_datetime'] ?></td>
                        <td class="has-text-centered"><?= $checkin['checkin_break_time'] ?></td>
                        <td class="has-text-centered"><?= $jobTimeInHours ?></td>
                        <td class="has-text-centered">
                            <a href="/job/checkin/update/<?= $checkin['id'] ?>">
                                <i class="far fa-edit has-text-info"></i>
                            </a>
                        </td>
                        <td class="has-text-centered">
                            <a href="/job/checkin/delete/<?= $checkin['id'] ?>">
                                <i class="far fa-trash-alt has-text-danger"></i>
                            </a>
                        </td>
                    </tr>

                <?php endforeach ?>

            </tbody>
        </table>
        <div class="has-text-centered">
            <a class="button is-primary" href="/job/checkin">Check-in</a>
        </div>

    </div>
</div>