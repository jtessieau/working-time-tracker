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
                $startDate = strtotime($checkin['start_date']);
                $endDate = strtotime($checkin['end_date']);

                $jobTimeInSeconds = $endDate - $startDate - ($checkin['break_time'] * 60);
                $jobTimeInHours = $jobTimeInSeconds / 60 / 60;
            ?>

                <tr>
                    <td><?= $checkin['start_date'] ?></td>
                    <td><?= $checkin['end_date'] ?></td>
                    <td><?= $checkin['break_time'] ?></td>
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