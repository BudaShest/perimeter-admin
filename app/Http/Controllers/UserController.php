<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\User;

class UserController extends Controller
{

    public function unlinkArea(int $userID, int $areaID) {
        $user = User::where(['id' => $userID])->firstOrFail();

        $area = Area::where([
            'id' => $areaID
        ])->firstOrFail();

        $user->areas()->detach($area);

        return redirect()->back();
    }
}
