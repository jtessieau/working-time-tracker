<div class="container">
    <div class="block mx-auto" style="width: 300px">
        <form method="post">
            <div class="field">
                <label class="label" for="designation">Job Title</label>
                <div class="control has-icons-left">
                    <input class="input" type="text" id="designation" name="designation" required>
                    <span class="icon is-small is-left">
                        <i class="fas fa-briefcase"></i>
                    </span>
                </div>
            </div>
            <div class="field">
                <label class="label" for="rate">Rate</label>
                <div class="control has-icons-left">
                    <input class="input" type="text" id="rate" name="rate" required>
                    <span class="icon is-small is-left">
                        <i class="fas fa-hand-holding-usd"></i>
                    </span>
                </div>
            </div>
            <div class="field">
                <label class="label" for="company">Company</label>
                <div class="control has-icons-left">
                    <input class="input" type="text" id="company" name="company" required>
                    <span class="icon is-small is-left">
                        <i class="fas fa-building"></i>
                    </span>
                </div>
            </div>
            <div class="field">
                <label class="label" for="startDate">Starting date</label>
                <div class="control has-icons-left">
                    <input class="input" type="date" id="startDate" name="startDate" required>
                    <span class="icon is-small is-left">
                        <i class="fas fa-calendar-alt"></i>
                    </span>
                </div>
            </div>
            <div class="field">
                <label class="label" for="endDate">Ending date</label>
                <div class="control has-icons-left">
                    <input class="input" type="date" id="endDate" name="endDate" required>
                    <span class="icon is-small is-left">
                        <i class="fas fa-calendar-alt"></i>
                    </span>
                </div>
            </div>
            <div class="field">
                <label class="label" for="periodOfWork">Period of pay</label>
                <div class="select">
                    <select name="periodOfWork" id="periodOfWork">
                        <option value="daily">Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly">Monthly</option>
                    </select>
                </div>
            </div>
            <div class="field">
                <label class="label" for="firstDayOfTheWeek">Period start if weekly</label>
                <div class="select">
                    <select name="firstDayOfTheWeek" id="firstDayOfTheWeek">
                        <option value="0">Sunday</option>
                        <option value="1">Monday</option>
                        <option value="2">Tuesday</option>
                        <option value="3">Wednesday</option>
                        <option value="4">Thursday</option>
                        <option value="5">Friday</option>
                        <option value="6">Saturday</option>
                    </select>
                </div>
            </div>

            <div class="field is-grouped is-grouped-centered">
                <div class="control">
                    <button class="button is-link">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
