<?php

namespace App\Rules;
use App\Models\Occupant;
use App\Http\Traits\Api\Job\Realestate\OccupantAdapter;
use Illuminate\Support\Carbon;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\InvokableRule;

class OccupantDateFromLessDateToRule implements DataAwareRule, InvokableRule
{
    
    use OccupantAdapter;
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
          
        
        $editedOccupant = $this->data['initOccupant'];

        $qPrevOccupant = Occupant::where('realestate_id', $editedOccupant['realestate_id'])
            ->where('unvid', $this->getPrevOccupantUnvid($editedOccupant['unvid']))
            ->get();

         $qNextOccupant = Occupant::where('realestate_id', $editedOccupant['realestate_id'])
            ->where('unvid', $this->getNextOccupantUnvid($editedOccupant['unvid']))
            ->get();
    
        if (!$qPrevOccupant->isEmpty()){
            $prevOccupant = $qPrevOccupant->first();
            //datum muss nach dem DateTo des vorherigen Mieters liegen
            if ((new Carbon($value))->lessThan(new Carbon($prevOccupant->dateFrom))) {
                $fail('Das Einzugsdatum darf nicht vor dem '. $prevOccupant->date_from_editing. ' (liegen');
            }
        }

        if (!$qNextOccupant->isEmpty()){
            $nextOccupant = $qNextOccupant->first();
            //datum muss vor dem DateFrom des nächsten Mieters liegen
            if ((new Carbon($value))->greaterThan(new Carbon($nextOccupant->dateFrom))) {
                $fail('Das Einzugsdatum darf nicht nach dem '. $nextOccupant->date_from_editing. ' liegen');
            }
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
