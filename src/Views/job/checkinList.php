<div class="container">
    <table class="table">
        <thead>
            <td>Start date</td>
            <td>End date</td>
            <td>Break time</td>
            <td>Job time</td>
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
                    <td><?= $checkin['checkin_start_datetime'] ?></td>
                    <td><?= $checkin['checkin_end_datetime'] ?></td>
                    <td><?= $checkin['checkin_break_time'] ?></td>
                    <td><?= $jobTimeInHours ?></td>
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