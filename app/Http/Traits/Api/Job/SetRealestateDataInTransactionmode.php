<?php
namespace App\Http\Traits\Api\Job;

use App\Models\Realestate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

trait SetRealestateDataInTransactionmode
{
    public function setRealestateDataInTransactionmode(Array $data)
    {

    
        $validator = Validator::make($data, [
            'value' => 'required|boolean',
            'realestate_neko_id' => 'required|string|max:40',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'function' => 'JobController.setRealestateDataInTransactionmode',
                'result' => 'error',
                'errortype' => 'invalid data',
                'errors' => $validator->errors(),
                'data' => $data,
                'id' => 0,
                ]);
        }

        $realestate_id = Realestate::where('nekoId', $data['realestate_neko_id'])->first()->id;
        DB::table($data['dataTable'])->where('realestate_id', $realestate_id)->update(['sync' => $data['value']]);
      

        $tableResult = DB::table($data['dataTable'])->where('realestate_id', $realestate_id)->get();

        return response()->json([
            'result' => 'success',
            'id' => $realestate_id,
            'data' => $tableResult,
        ]);

    }
}