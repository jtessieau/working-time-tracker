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

        <?php foreach ($jobs as $job):
            $startDate = new DateTime($job['start_date']);

            if ($job['end_date'] == null) {
                $active = true;
            } else {
                $active = false;
            }
        ?>

            <tr>
                <td><?= ucfirst($job['name']) ?></td>
                <td><?= $job['designation'] ?></td>
                <td> £<?= $job['rate'] ?></td>
                <td><?= $startDate->format('d/m/Y'); ?></td>
                <td><?= $active ? "vert" : "rouge"; ?></td>
                <td>edit</td>
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
