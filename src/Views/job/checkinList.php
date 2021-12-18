<div class="container">
    <table class="table">
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
</div>

<hr style="margin-top:100px">

<pre>
<?php
var_dump($checkins);
?>
</pre>