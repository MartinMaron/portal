<?php

namespace App\Http\Livewire\User\Realestate\VerbrauchsinfoUserEmail;
use DateTime;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\Occupant;
use App\Models\Verbrauchsinfo;
use App\Models\VerbrauchsinfoUserEmail;
use Usernotnull\Toast\Concerns\WireToast;

class Detail extends Component
{
    use WireToast;

    public $userEmail;
    public Occupant $occupant;
    public $showEditModal = false;
    public string $dialogMode = '';

    public bool $aktiv;
    public string $email;
    public DateTime $dateFrom;
    public Datetime $dateTo;
    public string $firstinitUsername;

    protected $listeners = [
        'showUserEmailModal' => 'showModal',
        'closeUserEmailModal' => 'closeModal',
        'showCreateUserEmailModal' => 'createModal'
    ];

    public function rules()
    {
        return [
            'userEmail.email' => 'required|string|email|max:255',
            'userEmail.firstinitUsername' => 'nullable',
            'userEmail.nutzeinheitNo' => 'required',
            'userEmail.realestate_id' => 'required',
            'userEmail.info_per_portal_editing' => 'nullable',
            'userEmail.infoPerPortal' => 'nullable',
            'userEmail.info_per_post_editing' => 'nullable',
        ];
    }

    public function showModal ($userEmail){
        $this->dialogMode = 'edit';
        $this->userEmail = $userEmail;
        $this->showEditModal = true;
    }

    public function closeModal($save){
        if ($save && $this->userEmail){
            if ($this->validate())
            {
                if($this->dialogMode == 'create')
                {
                    VerbrauchsinfoUserEmail::create($this->userEmail);
                    toast()->success('Emailadresse für Verbraucherinformationen hinzugefügt','Achtung')->push();
                    $this->emit('refreshParent');
                 }
                if($this->dialogMode == 'edit')
                {
                    
                    VerbrauchsinfoUserEmail::updateOrcreate(
                            ['id' => $this->userEmail['id']],
                            ['email' => $this->userEmail['email'],
                            'firstinitUsername' => $this->userEmail['firstinitUsername'],
                            'infoPerPortal' => $this->userEmail['infoPerPortal'],
                            'infoPerEmail' => $this->userEmail['infoPerEmail'],
                            'infoPerPost' => $this->userEmail['infoPerPost'],
                            ]
                            );
                    toast()->success('Emailadresse für Verbraucherinformationen wurde geändert','Achtung')->push();

                }
                $this->emit('refreshParent');
                $this->showEditModal = false ;
            }else{
                $this->showEditModal = true;
            };
        }else{
            $this->showEditModal = false;
        }
   }

    public function createModal($userEmail)
    {
        $this->dialogMode = 'create';
        $this->userEmail = $userEmail;
        $this->showEditModal = true;
    }

    public function render()
    {
        return view('livewire.user.realestate.verbrauchsinfo-user-email.detail');
    }
}
