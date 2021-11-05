<?php

use App\FormValidation\FormValidation;
use App\FormValidation\ValidationInterface;

class JobCreationFormValidation extends FormValidation implements ValidationInterface
{
    protected array $fields = [
        'designation',
        'rate',
        'startDate',
        'endDate',
        'periodOfWork',
        'firstDayOfTheWeek',
        'companyName',
        'companyCity'
    ];

    public function validate(): array
    {
        foreach (self::$fields as $field) {
            if(!array_key_exists($field, $this->data)){
                trigger_error("$field is not present in this form...");
                return null;
            }
        }

        $this->validateDesignation();
        $this->validateRate();
        $this->validateStartDate();
        $this->validateEndDate();
        $this->validatePerdiodOfWork();
        $this->validateFirstDayOfTheWeek();
        $this->validateCompanyName();
        $this->validateCompanyCity();

    }

    private function validateDesignation(): void
    {
        $designation = trim($this->data['designation']);

        if (empty($designation)) {
            $this->addError('designation', 'This field can not be empty.');
        } else if(!preg_match('/^[\p{L}\s]*$/')) {
            $this->addError('designation', 'Please enter a valid designation (No special chars).');
        }
    }

    private function validateRate(): void
    {
        $rate = $this->data['rate'];

        if (empty($rate)) {
            $this->addError('rate', 'Please enter a rate.');
        }else if(!is_numeric($rate)){
            $this->addError('rate', 'Numeric value only.')
        }
    }

    private function validateStartDate(): void
    {
        $startDate = $this->data['startDate'];

        if (empty($startDate) {
            $this->addError('startDate', 'Please add a start date.');
        } else if (!data_create_from_format('Y-m-d',$startDate)){
            $this->addError('startDate','Invalid date format.');
        }
    }

    private function validateEndDate(): void
    {
        $startDate = $this->data['endDate'];

        if (!data_create_from_format('Y-m-d',$endDate)){
            $this->addError('endDate','Invalid date format.');
        }
    }

    private function validatePerdiodOfWork(): void
    {

    }

    private function validateFirstDayOfTheWeek(): void
    {

    }

    private function validateCompanyName(): void
    {

    }

    private function validateCompanyCity(): void
}
