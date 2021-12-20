<?php

/**
 * The view must receive 2 arrays:
 *     - $errorMessages => Contains error messages from validation & controller.
 *     - $formData => Contains form value from $formData or from database for edition.
 */

?>

<h1>Checkin</h1>

<form id="checkinForm" method="post">
    <!-- Select job from list -->
    <label for="jobId">Job:</label>
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

    <!-- Start date and time -->
    <fieldset>
        <label for="startDate">Start date and time:</label>
        <input type="date" name="startDate" id="startDate" value="<?php echo $formData['startDate'] ?? date("Y-m-d"); ?>">
        <input type="time" name="startTime" id="startTime" value="<?php echo $formData['startTime'] ?? date("H:i"); ?>">
    </fieldset>

    <!-- End date and time -->
    <fieldset>
        <label for="endDate">End date and time:</label>
        <input type="date" name="endDate" id="endDate" value="<?php echo $formData['endDate'] ?? date("Y-m-d"); ?>">
        <input type="time" name="endTime" id="endTime" value="<?php echo $formData['endTime'] ?? date("H:i"); ?>">
    </fieldset>

    <!-- Break time in minutes -->
    <fieldset>
        <label for="breakTime">Unpaid break time:</label>
        <input type="number" name="breakTime" id="breakTime" value="<?php echo $formData['breakTime'] ?>">
    </fieldset>

    <span class="help is-danger"><?php echo $errorMessages['checkinCreation'] ?? '' ?></span>

    <button type="submit" class="button is-link" form="checkinForm" name="submit" value="submit">
        Submit
    </button>
</form>

<?php

var_dump($errorMessages)

?>