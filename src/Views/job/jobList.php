<div class="section">
    <div class="container job-list">
        <?php if (!empty($jobs)) { ?>
            <h1 class="title has-text-centered">Your Registred Jobs</h1>
            <div class="columns is-multiline">
                <?php foreach ($jobs as $job) :
                    $startDate = new DateTime($job['job_start_date']);

                    if ($job['job_end_date'] == null) {
                        $active = true;
                    } else {
                        $active = false;
                    }
                ?>
                    <div class="column is-4">
                        <div class="card">
                            <a href="/job/checkin/list/<?= $job['id'] ?>">
                                <div class="card-content">
                                    <p class="title is-4">
                                        <?= ucwords($job['job_designation']) ?>
                                    </p>
                                    <p class="subtitle is-6">
                                        <?= ucfirst($job['company_name']) ?>
                                    </p>
                                </div>
                            </a>

                            <div class="is-active">
                                <?=
                                $active ?
                                    '<i class="fas fa-circle is-size-5 has-text-success"></i>'
                                    :
                                    'i class="fas fa-circle has-text-danger"></i>';
                                ?>
                            </div>

                            <footer class="card-footer">
                                <a href="/job/update/<?= $job['id'] ?>" class="card-footer-item edit-job">
                                    <i class=" far fa-edit mr-2"></i>Edit
                                </a>
                                <a href=" /job/delete/<?= $job['id'] ?>" class="card-footer-item delete-job">
                                    <i class="far fa-trash-alt mr-2"></i>Delete
                                </a>
                            </footer>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        <?php
        } else {
            echo '<h1 class="title has-text-centered">You have no jobs registred yet</h1>';
        }
        ?>

        <div class=" has-text-centered mt-4">
            <a class="button is-primary" href="/job/start">Register a new job</a>
        </div>
    </div>
</div>