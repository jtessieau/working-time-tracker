<?php

namespace App\FormValidation\JobManagerForm;

use App\FormValidation\FormValidation;
use App\FormValidation\ValidationInterface;

use App\Models\JobModel;

use DateTime;

class CheckinFormValidation extends FormValidation implements ValidationInterface
{
    protected static array $fields = [
        'jobId',
        'startDate',
        'startTime',
        'endDate',
        'endTime',
        'breakTime'
    ];

    protected string $startDatetime;
    protected string $endDatetime;

    public function validate(): array
    {
        foreach (self::$fields as $field) {
            if (!array_key_exists($field, $this->data)) {
                trigger_error("$field is not present in this form...");
                return null;
            }
        }

        // compose start date and end date from form data
        $this->startDatetime = $this->data['startDate'] . " " . $this->data['startTime'];
        $this->endDatetime = $this->data['endDate'] . " " . $this->data['endTime'];

        $this->validateStartDate();
        $this->validateEndDate();
        $this->validateBreakTime();
        $this->endDatePosteriorToStartDate();

        return $this->errors;
    }

    private function validateStartDate(): void
    {
        if ($this->data['startDate'] === "" || $this->data['startTime'] === "") {
            $this->addError('startDate', 'Start date and time must be set.');
        } else {
            $jobModel = new JobModel();
            $job = $jobModel->findOne($this->data['jobId']);

            if (!is_null($job['job_end_date'])) {
                $jobEndDate = date_create_from_format('Y-m-d', $job['job_end_date']);
                $checkinStartDate = DateTime::createFromFormat('Y-m-d H:i', $this->startDatetime);

                if ($checkinStartDate > $jobEndDate) {
                    $this->addError('startDate', 'The check-in can\'t start after the end of job contract\'s.');
                }
            }
        }
    }

    private function validateEndDate(): void
    {
        if ($this->data['endDate'] === '' || $this->data['endTime'] === '') {
            $this->addError('endDate', 'End date and time must be set.');
        }
    }

    private function validateBreakTime(): void
    {
        if (!is_numeric($this->data['breakTime'])) {
            $this->addError('breakTime', 'Break time must be set as an integer (minutes).');
        }
        if ($this->data['breakTime'] === '') {
            $this->addError('breakTime', 'BreakTime must be set.');
        }
    }

    private function endDatePosteriorToStartDate(): void
    {
        $format = 'Y-m-d H:i';
        $startDate = DateTime::createFromFormat($format, $this->startDatetime);
        $endDate = DateTime::createFromFormat($format, $this->endDatetime);

        if ($endDate <= $startDate) {
            $this->addError('endDate', 'End date can\'t be before start date.');
        }
    }
}
