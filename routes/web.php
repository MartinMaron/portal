<?php
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DownloadFileController;
use App\Http\Controllers\DownloadFileSpacesController;
use App\Http\Controllers\Web\RealestateController;
use App\Models\Occupant;
use App\Models\Realestate;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*

|--------------------------------------------------------------------------

| Web Routes

|--------------------------------------------------------------------------

|

| Here is where you can register web routes for your application. These

| routes are loaded by the RouteServiceProvider within a group which

| contains the "web" middleware group. Now create something great!

|

*/

Route::name('guest.')->group(function () {
    Route::get('/', function () {
        return view('guest.welcome');
    })->name('home');
    Route::get('/heizkostenabrechnung', function () {
        return view('guest.heizkostenabrechnung');
    })->name('heizkostenabrechnung');
    Route::get('/betriebskosten', function () {
        return view('guest.betriebskostenabrechnung');
    })->name('betriebskostenabrechnung');
    Route::get('/rauchmelderservice', function () {
        return view('guest.rauchmelderservice');
    })->name('rauchmelderservice');
    Route::get('/energieausweis', function () {
        return view('guest.energieausweis');
    })->name('energieausweis');
    Route::get('/heizkostenverteiler', function () {
        return view('guest.heizkostenverteiler');
    })->name('heizkostenverteiler');
    Route::get('/waermezaehler', function () {
        return view('guest.waermezaehler');
    })->name('waermezaehler');
    Route::get('/rauchmelder', function () {
        return view('guest.rauchmelder');
    })->name('rauchmelder');
    Route::get('/wasserzaehler', function () {
        return view('guest.wasserzaehler');
    })->name('wasserzaehler');
    Route::get('/kontakt', function () {
        return view('guest.kontakt');
    })->name('kontakt');
    Route::get('/messdienstwechsel', function () {
        return view('guest.messdienstwechsel');
    })->name('messdienstwechsel');
});

Route::get('/downloadpublicfile/{file_name}', [DownloadFileController::class, 'downloadFile'])->name('downloadpublicfile');
Route::get('/showpublicfile/{file_name}', [DownloadFileController::class, 'showFile'])->name('showpublicfile');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::name('user.')->group(function () {
        /* Startseite im user bereich */
        Route::middleware('isUser')->group(function () {

            Route::get('/realestates', function () {
                return view('backend.realestate.list');
            })->name('realestates');

            Route::controller(DownloadFileSpacesController::class)->group(function ($param) {
                Route::get('/downloadspacesfile/{param}', 'downloadFile')->name('downloadspacesfile');
                Route::get('/showspacesfile/{param}', 'showFile')->name('showspacesfile');
            });

            Route::controller(RealestateController::class)->group(function ($realestate) {
                Route::get('/realestate/{realestate}', 'show')->name('realestate');
            });

            Route::get('/realestateOccupantList/{id}', function ($id) {
                $realestate = Realestate::all()->find($id);

                return view('backend.realestate.show-occupant-list', compact('realestate'));
            })->name('realestateOccupantList');

            Route::get('/realestateVerbrauchsinfoUserEmails/{id}', function ($id) {
                $realestate = Realestate::all()->find($id);

                return view('backend.realestate.show-verbrauchsinfo-user-email', compact('realestate'));
            })->name('realestateVerbrauchsinfoUserEmails');

            Route::get('/invoicesList/{id}', function ($id) {
                $realestate = Realestate::all()->find($id);

                return view('backend.realestate.show-invoices-list', compact('realestate'));
            })->name('invoicesList');

            Route::get('/costs/{id}', function ($id) {
                $realestate = Realestate::all()->find($id);

                return view('backend.realestate.show-costs', compact('realestate'));
            })->name('costs');

            Route::get('/betriebskostenliste/{id}', function ($id) {
                $realestate = Realestate::all()->find($id);

                return view('backend.realestate.show-betriebskostenliste', compact('realestate'));
            })->name('betriebskostenliste');

            Route::get('/betriebskosteneingabe/{id}', function ($id) {
                $realestate = Realestate::all()->find($id);

                return view('backend.realestate.show-betriebskosteneingabe', compact('realestate'));
            })->name('betriebskosteneingabe');

            Route::get('/heizkostenliste/{id}', function ($id) {
                $realestate = Realestate::all()->find($id);

                return view('backend.realestate.show-heizkostenliste', compact('realestate'));
            })->name('heizkostenliste');
        });

        Route::get('/dashboard', function () {
            if (Auth::User()->isUser) {
                return redirect('/realestates');
            } else {
                if (Auth::User()->isMieter) {
                    if (Auth::User()->userVerbrauchsinfoAccessControls->count() > 0) {
                        return redirect('/verbrauchsinfos');
                    } else {
                        return redirect('/');
                    }
                }
            }
        })->name('dashboard');

        Route::middleware('isMieter')->group(function () {
            /* Verbrauchsinfos */
            Route::get('/verbrauchsinfos', function () {
                return view('backend.verbrauchsinfo.show-verbrauchsinfo');
            })->name('verbrauchsinfos');

            Route::get('/occupantVerbrauchsinfos/{id}', function ($id) {
                $occupant = Occupant::all()->find($id);

                return view('backend.verbrauchsinfo.show-verbrauchsinfo-list', compact('occupant'));
            })->name('occupantVerbrauchsinfos');

            Route::get('/occupantVerbrauchsinfoCounterMeters/{occupant_id}/{jahr_monat}', function ($occupant_id, $jahr_monat) {
                $occupant = Occupant::all()->find($occupant_id);

                return view('backend.verbrauchsinfo.show-verbrauchsinfo-counter-meters', compact('occupant', 'jahr_monat'));
            })->name('occupantVerbrauchsinfoCounterMeters');

            Route::get('/occupantVerbrauchsinfoCounterMetersReading/{occupant_id}/{id}', function ($occupant_id, $id) {
                $occupant = Occupant::all()->find($occupant_id);

                return view('backend.verbrauchsinfo.show-verbrauchsinfo-counter-meters-readings', compact('occupant', 'id'));
            })->name('occupantVerbrauchsinfoCounterMetersReading');
        });
    });
});
