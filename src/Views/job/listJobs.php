<div class="container">
    <table class="table">
        <thead>
            <td>Company</td>
            <td>Designation</td>
            <td>Rate</td>
            <td>Start date</td>
            <td>Status</td>
            <td>Edit</td>
        </thead>
        <tbody>

            <?php foreach ($jobs as $job) :
                $startDate = new DateTime($job['job_start_date']);

                if ($job['job_end_date'] == null) {
                    $active = true;
                } else {
                    $active = false;
                }
            ?>

                <tr>
                    <td><?= ucfirst($job['company_name']) ?></td>
                    <td><?= $job['job_designation'] ?></td>
                    <td> £<?= $job['job_rate'] ?></td>
                    <td><?= $startDate->format('d/m/Y'); ?></td>
                    <td><?= $active ? "vert" : "rouge"; ?></td>
                    <td><a href="/job/update/<?= $job['job_id'] ?>"><i class="far fa-edit"></i></a></td>
                </tr>

            <?php endforeach ?>

        </tbody>
    </table>
</div>

<hr style="margin-top:100px">

<pre>
<?php
var_dump($jobs);
?>
</pre>