<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::with('role')->get();

        return response()->json($accounts);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:accounts',
            'phone_number' => 'required|string',
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|string|same:password',
            'access' => 'exists:roles,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $account = Account::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'password' => bcrypt($request->input('password')),
            'user_id' => 1,
        ]);

        return response()->json(['message' => 'Account created successfully']);
    }

    public function getAccount($id)
    {
        $account = Account::find($id);
        
        if(!$account){
            return response()->json('Account not found', 404);
        }

        return response()->json($account);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'required|string',
            'access' => 'exists:roles,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $account = Account::find($id);

        if (!$account) {
            return response()->json(['error' => 'Account not found'], 404);
        }

        // Update the account fields
        $account->first_name = $request->input('first_name');
        $account->last_name = $request->input('last_name');
        $account->email = $request->input('email');
        $account->phone_number = $request->input('phone_number');
        $account->user_id = 1;

        $account->save();

        return response()->json(['message' => 'Account updated successfully']);
    }

    public function delete(Request $request, $id)
    {
        $account = Account::find($id);

        if(!$account){
            return response()->json('Account group not found', 404);
        }

        $account->delete();

        return response()->json('Account deleted successfully', 200);
    }

}
