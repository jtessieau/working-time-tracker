<div class="section">
    <div class="container">
        <?php if (!empty($jobs)) { ?>
            <h1 class="title has-text-centered">List of your jobs</h1>
            <table class="table mx-auto">
                <thead>
                    <td class="has-text-centered">Designation</td>
                    <td class="has-text-centered">Company</td>
                    <td class="has-text-centered">Rate</td>
                    <td class="has-text-centered">Start date</td>
                    <td class="has-text-centered">Status</td>
                    <td class="has-text-centered">Edit</td>
                    <td class="has-text-centered">Delete</td>
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
                            <td class="has-text-centered"> £<?= $job['job_rate'] ?></td>
                            <td class="has-text-centered"><?= $startDate->format('d/m/Y'); ?></td>
                            <td class="has-text-centered">
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
        <?php } else {
            echo '<h1 class="title has-text-centered">You have no jobs registred yet</h1>';
        } ?>
        <div class="has-text-centered">
            <a class="button is-primary" href="/job/start">Register a new job</a>
        </div>
    </div>
</div>