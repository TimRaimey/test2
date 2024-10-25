<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserBalance;
use App\Models\Operation;

class UserDataController extends Controller
{
    public function getUserData()
    {
        $user = Auth::user();

        $balance = UserBalance::where('user_id', $user->id)->first()->balance;

        $operations = Operation::where('user_id', $user->id)->orderBy('created_at', 'desc')->take(5)->get();

        return response()->json([
            'balance' => $balance,
            'operations' => $operations
        ]);
    }

    public function getOperations(Request $request)
    {
        $user = Auth::user();

        $sort = $request->input('sort', 'desc');
        $search = $request->input('search', '');

        $operations = Operation::where('user_id', $user->id)
            //поиск в простом варианте, можно конечно сделать и поиск без учета пробелов, знаков препинания и тп
            ->where('description', 'like', '%' . $search . '%')->orderBy('created_at', $sort)->get();

        return response()->json([
            'operations' => $operations
        ]);
    }
}
