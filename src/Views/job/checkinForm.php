<?php

/**
 * The view must receive 2 arrays:
 *     - $errorMessages => Contains error messages from validation & controller.
 *     - $formData => Contains form value from $formData or from database for edition.
 */

?>
<div class="section">
    <div class="container" style="max-width:700px">
        <h1 class="title has-text-centered">Check-in Form</h1>
        <form id="checkinForm" method="post">
            <!-- Select job from list -->
            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label" for="jobId">Job:</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control is-expanded">
                            <div class="select">
                                <select name="jobId" id="jobId">
                                    <?php foreach ($jobList as $job) :
                                        $jobDesignation = ucwords($job['job_designation']);
                                        if ($job['id'] === $formData['jobId']) {
                                            echo "<option value=\"{$job['id']}\" selected>$jobDesignation</option>";
                                        } else {
                                            echo "<option value=\"{$job['id']}\">$jobDesignation</option>";
                                        }
                                    endforeach ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Start date and time -->
            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label" for="endDate">Start:</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <input class="input" type="date" name="startDate" id="startDate" value="<?php echo $formData['startDate'] ?? date("Y-m-d"); ?>">
                        </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <input class=" input" type="time" name="startTime" id="startTime" value="<?php echo $formData['startTime'] ?? date("H:i"); ?>">
                        </div>
                    </div>
                </div>
            </div>


            <!-- End date and time -->
            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label" for="endDate">End:</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <input class="input" type="date" name="endDate" id="endDate" value="<?php echo $formData['endDate'] ?? date("Y-m-d"); ?>">
                        </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <input class="input" type="time" name="endTime" id="endTime" value="<?php echo $formData['endTime'] ?? date("H:i"); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Break time in minutes -->
            <div class="field">
                <div class="control"></div>
            </div>

            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label" for="breakTime">Unpaid time:</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <input class="input" type="number" name="breakTime" id="breakTime" value="<?php echo $formData['breakTime'] ?? "0" ?>">
                        </div>
                    </div>
                </div>
            </div>

            <span class="help is-danger"><?php echo $errorMessages['checkinCreation'] ?? '' ?></span>



            <div class="field is-grouped is-grouped-centered">
                <p class="control">
                    <button type="submit" class="button is-link" form="checkinForm" name="submit" value="submit">
                        Submit
                    </button>
                </p>
            </div>
        </form>
    </div>
</div>
<?php

var_dump($errorMessages)

?>