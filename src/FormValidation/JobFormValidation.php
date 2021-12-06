<?php

namespace App\FormValidation;

use App\FormValidation\FormValidation;
use App\FormValidation\ValidationInterface;

class JobFormValidation extends FormValidation implements ValidationInterface
{
    protected static array $fields = [
        'designation',
        'rate',
        'startDate',
        // 'endDateKnown',
        'endDate',
        'periodOfWork',
        'firstDayOfTheWeek',
        'companyName'
    ];

    public function validate(): array
    {
        foreach (self::$fields as $field) {
            if (!array_key_exists($field, $this->data)) {
                trigger_error("$field is not present in this form...");
                return null;
            }
        }

        var_dump($_POST);

        $this->validateDesignation();
        $this->validateRate();
        $this->validateStartDate();
        $this->validateEndDate();
        $this->validatePerdiodOfWork();
        $this->validateFirstDayOfTheWeek();
        $this->validateCompanyName();

        return $this->errors;
    }

    private function validateDesignation(): void
    {
        $designation = trim($this->data['designation']);

        if (empty($designation)) {
            $this->addError('designation', 'This field can not be empty.');
        } elseif (!preg_match('/^[\p{L}\s]*$/', $designation)) {
            $this->addError('designation', 'Please enter a valid designation (No special chars).');
        }
    }

    private function validateRate(): void
    {
        $rate = $this->data['rate'];

        if (empty($rate)) {
            $this->addError('rate', 'Please enter a rate.');
        } elseif (!is_numeric($rate)) {
            $this->addError('rate', 'Numeric value only.');
        }
    }

    private function validateStartDate(): void
    {
        $startDate = $this->data['startDate'];

        if (empty($startDate)) {
            $this->addError('startDate', 'Please add a start date.');
        } elseif (!date_create_from_format('Y-m-d', $startDate)) {
            $this->addError('startDate', 'Invalid date format.');
        }
    }

    private function validateEndDate(): void
    {
        $endDate = $this->data['endDate'];

        if (isset($this->data['endDateKnown'])) {
            if (!date_create_from_format('Y-m-d', $endDate)) {
                $this->addError('endDate', 'Invalid date format.');
            }
        }
    }

    private function validatePerdiodOfWork(): void
    {
        $periodOfWork = $this->data['periodOfWork'];
        $validAnswer = ['daily', 'weekly', 'monthly'];

        if (!in_array($periodOfWork, $validAnswer)) {
            $this->addError('periodOfWork', 'Invalid answer ... Please choose from the drop-down list.');
        }
    }

    private function validateFirstDayOfTheWeek(): void
    {
        $firstDayOfTheWeek = $this->data['firstDayOfTheWeek'];
        $validAnswer = ['0', '1', '2', '3', '4', '5', '6'];

        if (!in_array($firstDayOfTheWeek, $validAnswer)) {
            $this->addError('firstDayOfTheWeek', 'Invalid answer ... Please choose from the drop-down list.');
        }
    }

    private function validateCompanyName(): void
    {
        $companyName = $this->data['companyName'];

        if (empty($companyName)) {
            $this->addError('companyName', 'This field can not be empty.');
        } elseif (!preg_match('/^[\p{L}\s]*$/', $companyName)) {
            $this->addError('companyName', 'Please enter a valid name (No special chars).');
        }
    }
}
