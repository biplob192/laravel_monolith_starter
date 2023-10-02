<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Variety;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class VarietyController extends BaseController
{
    public function certainCrop($id)
    {
        try {
            $varieties = Variety::where('crop_id', $id)->latest()->get();
            return $varieties;
            return view('crop_requirement.index', compact('varieties'));
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }
}
