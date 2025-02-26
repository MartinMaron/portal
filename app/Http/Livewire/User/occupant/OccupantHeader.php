<?php

namespace app\Http\Livewire\User\Occupant;
use App\Models\Occupant;
use Livewire\Component;
use Livewire\HydrationMiddleware\AddAttributesToRootTagOfHtml;
use Spatie\LaravelIgnition\FlareMiddleware\AddJobs;
use Symfony\Component\HttpKernel\DependencyInjection\AddAnnotatedClassesToCachePass;

class OccupantHeader extends Component
{

    public $occupant;
    public $showStandardIcon = true;
    public $addAction = null;
    public $hasRealestateOccupantsDifferentAdresses = false;

    public function mount(Occupant $occupant)
    {
        $this->occupant = $occupant;
        $this->hasRealestateOccupantsDifferentAdresses = $this->occupant->realestate->has_occupants_different_adresses;
        if ($this->addAction != null)
        {
            /* $this->addAction = $addAction; */
            $this->showStandardIcon = false;
        }
    }

    public function raise_CreateVerbrauchsinfoUserEmailModal()
    {
        $this->emit($this->addAction, $this->occupant->nutzeinheitNo);
    }

    public function render()
    {
        return view('livewire.user.occupant.occupant-header');
    }
}
