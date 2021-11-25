<div class="container">
    <div class="block mx-auto" style="width: 300px">
        <span class='help is-danger'><?php echo $errorMessages['jobCreation'] ?? ''; ?></span>
        <form method="post" id="createJobForm">
            <div class="field">
                <label class="label" for="designation">Job Title</label>
                <div class="control has-icons-left">
                    <input class="input" type="text" id="designation" name="designation" value=<?php echo $_POST['designation'] ?? '' ?>>
                    <span class="icon is-small is-left">
                        <i class="fas fa-briefcase"></i>
                    </span>
                </div>
                <span class='help is-danger'><?php echo $errorMessages['designation'] ?? ''; ?></span>
            </div>

            <div class="field">
                <label class="label" for="rate">Rate</label>
                <div class="control has-icons-left">
                    <input class="input" type="text" id="rate" name="rate" value=<?php echo $_POST['rate'] ?? '' ?>>
                    <span class="icon is-small is-left">
                        <i class="fas fa-hand-holding-usd"></i>
                    </span>
                </div>
                <span class='help is-danger'><?php echo $errorMessages['rate'] ?? ''; ?></span>
            </div>
            <div class="field">
                <label class="label" for="companyName">Company name</label>
                <div class="control has-icons-left">
                    <input class="input" type="text" id="companyName" name="companyName" value=<?php echo $_POST['companyName'] ?? '' ?>>
                    <span class="icon is-small is-left">
                        <i class="fas fa-building"></i>
                    </span>
                </div>
                <span class='help is-danger'><?php echo $errorMessages['companyName'] ?? ''; ?></span>
            </div>

            <div class="field">
                <label class="label" for="companyCity">Company city</label>
                <div class="control has-icons-left">
                    <input class="input" type="text" id="companyCity" name="companyCity" value=<?php echo $_POST['companyCity'] ?? '' ?>>
                    <span class="icon is-small is-left">
                        <i class="fas fa-building"></i>
                    </span>
                </div>
                <span class='help is-danger'><?php echo $errorMessages['companyCity'] ?? ''; ?></span>
            </div>

            <div class="field">
                <label class="label" for="startDate">Starting date</label>
                <div class="control has-icons-left">
                    <input class="input" type="date" id="startDate" name="startDate" value=<?php echo $_POST['startDate'] ?? '' ?>>
                    <span class="icon is-small is-left">
                        <i class="fas fa-calendar-alt"></i>
                    </span>
                </div>
                <span class='help is-danger'><?php echo $errorMessages['startDate'] ?? ''; ?></span>
            </div>

            <div class="field" id="endDateKnown">
                <div class="control">
                    <label class="checkbox">
                        <input type="checkbox" name='endDateKnown' <?php echo isset($_POST['endDateKnown']) ? 'checked' : ''; ?>>
                        I know the ending date.
                    </label>
                </div>
            </div>

            <div class="field" id="endDate">
                <label class="label" for="endDate">Ending date</label>
                <div class="control has-icons-left">
                    <input class="input" type="date" name="endDate" value=<?php echo $_POST['endDate'] ?? '' ?>>
                    <span class="icon is-small is-left">
                        <i class="fas fa-calendar-alt"></i>
                    </span>
                </div>
                <span class='help is-danger'><?php echo $errorMessages['endDate'] ?? ''; ?></span>
            </div>

            <div class="field">
                <label class="label" for="periodOfWork">Period of pay</label>
                <div class="select">
                    <select name="periodOfWork" id="periodOfWork">
                        <option value="daily" <?php echo isset($_POST['periodOfWork']) &&  $_POST['periodOfWork'] == 'daily' ? 'selected' : ''; ?>>Daily</option>
                        <option value="weekly" <?php echo isset($_POST['periodOfWork']) &&  $_POST['periodOfWork'] == 'weekly' ? 'selected' : ''; ?>>Weekly</option>
                        <option value="monthly" <?php echo isset($_POST['periodOfWork']) &&  $_POST['periodOfWork'] == 'monthly' ? 'selected' : ''; ?>>Monthly</option>
                    </select>
                </div>
                <span class='help is-danger'><?php echo $errorMessages['periodOfWork'] ?? ''; ?></span>
            </div>

            <div class="field">
                <label class="label" for="firstDayOfTheWeek">Period start if weekly</label>
                <div class="select">
                    <select name="firstDayOfTheWeek" id="firstDayOfTheWeek">
                        <option value="0" <?php echo isset($_POST['firstDayOfTheWeek']) &&  $_POST['firstDayOfTheWeek'] === '0' ? 'selected' : ''; ?>>Sunday</option>
                        <option value="1" <?php echo isset($_POST['firstDayOfTheWeek']) &&  $_POST['firstDayOfTheWeek'] === '1' ? 'selected' : ''; ?>>Monday</option>
                        <option value="2" <?php echo isset($_POST['firstDayOfTheWeek']) &&  $_POST['firstDayOfTheWeek'] === '2' ? 'selected' : ''; ?>>Tuesday</option>
                        <option value="3" <?php echo isset($_POST['firstDayOfTheWeek']) &&  $_POST['firstDayOfTheWeek'] === '3' ? 'selected' : ''; ?>>Wednesday</option>
                        <option value="4" <?php echo isset($_POST['firstDayOfTheWeek']) &&  $_POST['firstDayOfTheWeek'] === '4' ? 'selected' : ''; ?>>Thursday</option>
                        <option value="5" <?php echo isset($_POST['firstDayOfTheWeek']) &&  $_POST['firstDayOfTheWeek'] === '5' ? 'selected' : ''; ?>>Friday</option>
                        <option value="6" <?php echo isset($_POST['firstDayOfTheWeek']) &&  $_POST['firstDayOfTheWeek'] === '6' ? 'selected' : ''; ?>>Saturday</option>
                    </select>
                </div>
                <span class='help is-danger'><?php echo $errorMessages['firstDayOfTheWeek'] ?? ''; ?></span>
            </div>

            <div class="field is-grouped is-grouped-centered">
                <div class="control">
                    <button type="submit" class="button is-link" form="createJobForm" name="submit" value="submit">
                        Submit
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    let endDate = document.querySelector('#endDate');
    let endDateKnown = document.querySelector('#endDateKnown input');

    function displayEndDate() {
        if (endDateKnown.checked) {
            endDate.style.display = 'block';
        } else {
            endDate.style.display = 'none';
        }
    }

    displayEndDate();

    endDateKnown.addEventListener('change', () => {
        displayEndDate()
    });
</script>