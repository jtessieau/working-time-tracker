<?php

namespace App\FormValidation;

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
        if (!is_int($this->data['breakTime'])) {
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
            $this->addError('date', 'End date can\'t be before start date.');
        }
    }
}
