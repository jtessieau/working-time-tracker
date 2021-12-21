<div class="container">
    <table class="table">
        <thead>
            <td>Designation</td>
            <td>Company</td>
            <td>Rate</td>
            <td>Start date</td>
            <td>Status</td>
            <td>Edit</td>
            <td>Delete</td>
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
                    <td><a href="/job/checkin/list/<?= $job['id'] ?>"><?= ucwords($job['job_designation']) ?></a></td>
                    <td><?= ucfirst($job['company_name']) ?></td>
                    <td> £<?= $job['job_rate'] ?></td>
                    <td><?= $startDate->format('d/m/Y'); ?></td>
                    <td>
                        <?=
                        $active ?
                            '<i class="fas fa-circle has-text-success"></i>'
                            :
                            '<i class="fas fa-circle has-text-danger"></i>';
                        ?>
                    </td>
                    <td class="has-text-centered">
                        <a href="/job/update/<?= $job['id'] ?>">
                            <i class="far fa-edit has-text-info"></i>
                        </a>
                    </td>
                    <td class="has-text-centered">
                        <a href="/job/delete/<?= $job['id'] ?>">
                            <i class="far fa-trash-alt has-text-danger"></i>
                        </a>
                    </td>
                </tr>

            <?php endforeach ?>

        </tbody>
    </table>
    <a class="button is-primary" href="/job/start">Start a job</a>
</div>

<hr style="margin-top:100px">

<pre>
<?php
var_dump($jobs);
?>
</pre>