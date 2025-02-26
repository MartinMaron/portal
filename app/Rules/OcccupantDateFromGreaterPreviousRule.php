<?php

namespace App\Rules;

use App\Models\Occupant;
use App\Traits\OccupantAdapter;
use Illuminate\Support\Carbon;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\InvokableRule;

class OcccupantDateFromGreaterPreviousRule implements DataAwareRule, InvokableRule
{
     /**
     * All of the data under validation.
     *
     * @var array
     */
    protected $data = [];
    
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        $prevOccupant = $this->data['initOccupant'];
        if ( (new Carbon($value))->lte(new Carbon($prevOccupant['dateFrom'])) ) {
            $fail('Das Einzugsdatum darf nicht vor dem '. $prevOccupant['dateFrom']. ' liegen');
        }        
    }

   /**
     * Set the data under validation.
     *
     * @param  array  $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

}
