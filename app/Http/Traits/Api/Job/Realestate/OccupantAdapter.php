<?php

namespace App\Http\Traits\Api\Job\Realestate;

use App\Models\Occupant;
use App\Models\User;
use App\Models\UserVerbrauchsinfoAccessControl;
use App\Models\Verbrauchsinfo;
use App\Models\VerbrauchsinfoCounterMeter;
use App\Models\VerbrauchsinfoUserEmail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

trait OccupantAdapter
{
    public function getNextOccupantUnvid($unvid)
    {
        $nr = intval(substr($unvid, 15, 3));
        $nr++;

        return substr($unvid, 0, 15) . str_pad($nr, 3, '0', STR_PAD_LEFT);
    }

    public function getPrevOccupantUnvid($unvid)
    {
        $nr = intval(substr($unvid, 15, 3));
        $nr--;

        return substr($unvid, 0, 15) . str_pad($nr, 3, '0', STR_PAD_LEFT);
    }

    private function generateNewAddress(Occupant $occupant) {}

    public function makeDefaultOccupant(Occupant $oldOccupant)
    {
        return Occupant::make([
            'nekoId' => 'new',
            'realestate_id' => $oldOccupant->realestate_id,
            'budguid' => $oldOccupant->realestate->nekoId,
            'nutzeinheitNo' => $oldOccupant->nutzeinheitNo,
            'unvid' => $this->getNextOccupantUnvid($oldOccupant->unvid),
            'anrede' => '',
            'title' => '',
            'nachname' => 'Neuer Nutzer',
            'vorname' => '',
            'address' => '',
            'street' => $oldOccupant->street,
            'postcode' => $oldOccupant->postcode,
            'houseNr' => $oldOccupant->houseNr,
            'city' => $oldOccupant->city,
            'vat' => $oldOccupant->vat,
            'uaw' => $oldOccupant->uaw,
            'qmkc' => $oldOccupant->qmkc,
            'qmww' => $oldOccupant->qmww,
            'pe' => $oldOccupant->pe,
            'lokalart' => $oldOccupant->lokalart,
            'customEinheitNo' => $oldOccupant->customEinheitNo,
            'lage' => $oldOccupant->lage,
            'eigentumer' => $oldOccupant->eigentumer,
            'dateFrom' => new Carbon,
            'bemerkung' => '',
            'email' => '',
            'telephone_number' => '',
            'eigentumer' => '',
            'OptimisticLockField' => 0,
        ]);
    }

    public function changeOccupant(Occupant $initOccupant, $newOccupant, bool $isEmpty, $newDate)
    {


        if ($isEmpty) {
            $newOccupant['nachname'] = 'Leerstand';
            $newOccupant['leerstand'] = true;
        } else {
            $newOccupant['leerstand'] = false;
        }
        $newOccupant['dateFrom'] = $newDate;
        $newOccupant['nekoId'] = 'new';
        $save = $this->editOccupant($newOccupant);

        /*  dump($newOccupant);
        dump($save); */

        if ($save->wasRecentlyCreated) {
            $save->refresh();
            $save->vorauszahlung_editing = $newOccupant['vorauszahlung_editing'];
            $save->personen_zahl = $newOccupant['personen_zahl'];
            $initOccupant->dateTo = (new carbon($newDate))->addDay(-1);
            $initOccupant->save();

            /* entziehen der Sicht-Berechtigungen des alten Nutzers */
            foreach ($initOccupant->userVerbrauchsinfoAccessControls()->get() as $accContr) {
                if (carbon::parse($accContr->datum) > carbon::parse($newOccupant['dateFrom'])) {
                    $accContr->delete();
                }
            }

            $nU = new User;
            $nU->email = $save->unvid . '@e-neko.de';
            $nU->name = $save->nachname;
            $nU->password = Hash::make($save->unvid);
            $nU->createdFromWebForOccupant = $save->id;
            $nU->isMieter = true;
            $nU->isUser = false;
            $nU->isAdmin = false;
            $nU->save();

            /* erstellen VerbrauchinfosUserEmails */
            /* für automatischen Webuser */
            $vue = new VerbrauchsinfoUserEmail;
            $vue->email = $save->unvid . '@e-neko.de';
            $vue->firstinitusername = $save->nachname;
            $vue->occupant_id = $save->id;
            $vue->realestate_id = $save->realestate->id;
            $vue->createdFromWebForOccupant = $save->id;
            $vue->anonym = true;
            $vue->OptimisticLockField = 0;
            $vue->nutzeinheitNo = $save->nutzeinheitNo;
            $vue->save();

            /* erstellen der Sicht-Berechtigungen des neuen Nutzers */
            /* für automatischen Webuser */
            for ($i = 0; $i < 12; $i++) {
                $jahr_monat = carbon::now()->addMonth(0 - $i)->isoFormat('YYYY-M');
                if ($save->dateFrom < carbon::now()->addMonth(0 - $i)) {
                    $uVAcc = UserVerbrauchsinfoAccessControl::updateOrcreate(
                        ['jahr_monat' => $jahr_monat, 'user_id' => $nU->id, 'occupant_id' => $save->id],
                        [
                            'neko_id' => 0,
                        ]
                    );
                }
            }

            /* erstellen des WebUsers aus. Email */
            if ($save->email) {
                $nU = new User;
                $nU->email = $save->email;
                $nU->name = $save->nachname;
                $nU->password = Hash::make($save->nachname);
                $nU->createdFromWebForOccupant = $save->id;
                $nU->isMieter = true;
                $nU->isUser = false;
                $nU->isAdmin = false;
                $nU->save();

                /* erstellen VerbrauchinfosUserEmails */
                /* für automatischen Webuser */
                $vue = new VerbrauchsinfoUserEmail;
                $vue->email = $save->email;
                $vue->firstinitusername = $save->nachname;
                $vue->realestate_id = $save->realestate->id;
                $vue->occupant_id = $save->id;
                $vue->anonym = false;
                $vue->createdFromWebForOccupant = $save->id;
                $vue->OptimisticLockField = 0;
                $vue->nutzeinheitNo = $save->nutzeinheitNo;
                $vue->save();

                /* erstellen der Sicht-Berechtigungen des neuen Nutzers */
                /* für automatischen Webuser */
                for ($i = 0; $i < 12; $i++) {
                    $jahr_monat = carbon::now()->addMonth(0 - $i)->isoFormat('YYYY-M');
                    if ($save->dateFrom < carbon::now()->addMonth(0 - $i)) {
                        $uVAcc = UserVerbrauchsinfoAccessControl::updateOrcreate(
                            ['jahr_monat' => $jahr_monat, 'user_id' => $nU->id, 'occupant_id' => $save->id],
                            [
                                'neko_id' => 0,
                            ]
                        );
                    }
                }
            }

            /* kopieren der Verbrauchsinformationen und CounterMeters zu neuem Nutzer */
            foreach ($initOccupant->verbrauchsinfos as $vbi) {
                if ($vbi->datum >= $newOccupant['dateFrom']) {
                    $vbiN = new Verbrauchsinfo;
                    $vbiN->occupant_id = $save->id;
                    $vbiN->art = $vbi->art;
                    $vbiN->einheit_id = $vbi->einheit_id;
                    $vbiN->nutzergrup_id = $vbi->nutzergrup_id;
                    $vbiN->nutzergrup_name = $vbi->nutzergrup_name;
                    $vbiN->datum = $vbi->datum;
                    $vbiN->jahr_monat = $vbi->jahr_monat;
                    $vbiN->durchschnitt = $vbi->durchschnitt;
                    $vbiN->zeitraum_akt = $vbi->zeitraum_akt;
                    $vbiN->zeitraum_mon = $vbi->zeitraum_mon;
                    $vbiN->zeitraum_vorj = $vbi->zeitraum_vorj;
                    $vbiN->verbrauch_akt = $vbi->verbrauch_akt;
                    $vbiN->verbrauch_mon = $vbi->verbrauch_mon;
                    $vbiN->verbrauch_vorj = $vbi->verbrauch_vorj;
                    $vbiN->hk = $vbi->hk;
                    $vbiN->ww = $vbi->ww;
                    $vbiN->save();
                }
            }
            foreach ($initOccupant->counterMeters as $cm) {
                if ($cm->datum >= $newOccupant['dateFrom']) {
                    $cmN = new VerbrauchsinfoCounterMeter;
                    $cmN->occupant_id = $save->id;
                    $cmN->art = $cm->art;
                    $cmN->nekoId = $cm->nekoId;
                    $cmN->nr = $cm->nr;
                    $cmN->funkNr = $cm->funkNr;
                    $cmN->art = $cm->art;
                    $cmN->einheit_id = $cm->einheit_id;
                    $cmN->nutzergrup_id = $cm->nutzergrup_id;
                    $cmN->nutzergrup_name = $cm->nutzergrup_name;
                    $cmN->datum = $cm->datum;
                    $cmN->stand_anfang = $cm->stand_anfang;
                    $cmN->stand_ende = $cm->stand_ende;
                    $cmN->faktor = $cm->faktor;
                    $cmN->zeitraum_akt = $cm->zeitraum_akt;
                    $cmN->zeitraum_mon = $cm->zeitraum_mon;
                    $cmN->zeitraum_vorj = $cm->zeitraum_vorj;
                    $cmN->verbrauch_akt = $cm->verbrauch_akt;
                    $cmN->verbrauch_mon = $cm->verbrauch_mon;
                    $cmN->verbrauch_vorj = $cm->verbrauch_vorj;
                    $cmN->jahr_monat = $cm->jahr_monat;
                    $cmN->hk = $cm->hk;
                    $cmN->ww = $cm->ww;
                    $cmN->save();
                }
            }
        }

        return $save;
    }

    public function editOccupant($occupant)
    {
        $ret_val = Occupant::updateOrcreate(
            ['id' => $occupant['id']],
            [
                'nekoId' => $occupant['nekoId'],
                'realestate_id' => $occupant['realestate_id'],
                'unvid' => $occupant['unvid'],
                'budguid' => $occupant['budguid'],
                'nutzeinheitNo' => $occupant['nutzeinheitNo'],
                'dateFrom' => new Carbon($occupant['dateFrom']),
                'dateTo' => $occupant['dateTo'],
                'anrede' => $occupant['anrede'],
                'title' => $occupant['title'],
                'nachname' => $occupant['nachname'],
                'vorname' => $occupant['vorname'],
                'address' => $occupant['address'],
                'street' => $occupant['street'],
                'postcode' => $occupant['postcode'],
                'houseNr' => $occupant['houseNr'],
                'city' => $occupant['city'],
                'vat' => $occupant['vat'],
                'uaw' => $occupant['uaw'],
                'qmkc' => $occupant['qmkc'],
                'qmww' => $occupant['qmww'],
                'bemerkung' => $occupant['bemerkung'],
                'lokalart' => $occupant['lokalart'],
                'customEinheitNo' => $occupant['customEinheitNo'],
                'lage' => $occupant['lage'],
                'leerstand' => $occupant['leerstand'],
                'email' => $occupant['email'],
                'telephone_number' => $occupant['telephone_number'],
                'eigentumer' => $occupant['eigentumer'],
                'OptimisticLockField' => $occupant['OptimisticLockField'] + 1,
            ]
        );

        if (array_key_exists('dateFrom', $ret_val->getChanges())) {

            // Auszugsdatum
            $datum = $occupant->getOriginal()['dateFrom']->addDays(-1);

            // change dateTo for previous Occupant
            $qOccupants = $occupant->realestate->occupants
                ->where('nutzeinheitNo', '=', $occupant->nutzeinheitNo)
                ->where('dateTo', '=', $datum->toDateString() . ' 00:00:00');

            foreach ($qOccupants as $occupant) {
                $occupant->dateTo = $ret_val->dateFrom->addDays(-1)->toDateString();
                $occupant->save();
            }
        }

        return $ret_val;
    }
}
