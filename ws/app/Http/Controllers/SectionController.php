<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Helpers\JwtAuth;
use App\Section;

class SectionController extends Controller {

    public function index() {
        $sections = Section::all();
        return response()->json(array(
                    'items' => $sections,
                    'status' => 200
                        ), 200);
    }

}
