<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use  App\User;
use  App\Models\Company;

class UserController extends Controller
{
     /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get the authenticated User.
     *
     * @return Response
     */
    public function profile()
    {
        return response()->json(['user' => Auth::user()], 200);
    }

    /**
     * Get the list of employer users
     *
     * @return Response
     */
    public function users(Request $request) 
    {
        $authId = Auth::id();

        // Page Limit
        $pageLimit = isset($request->page_limit) ? (int)$request->page_limit : 10;

        $query  = User::with('role')->where('employer_id', $authId)->where('role_id', 3);

        // Filters
        if (isset($request->name) && $request->name !=='') {
            $query->where('name', 'LIKE', '%'.$request->name.'%');
        }

        if (isset($request->email) && $request->email !=='') {
            $query->where('email', 'LIKE', '%'.$request->email.'%');
        }

        if (isset($request->status) && $request->status !=='') {
            if ($request->status == 1) {
                $query->where('status', 1);
            } elseif ($request->status == 0) {
                $query->where('status', 0);
            } else {}
        }
        // if (isset($request->role) && $request->role !=='') {
        //     $query->where('role_id', $request->role);
        // }

        $users = $query->paginate($pageLimit);

        return response()->json(['users' =>  $users], 200);
    }

    /**
     * Get the list of employers & admins
     *
     * @return Response
     */
    public function employers(Request $request)
    {
        $authId = Auth::id();

        // Page Limit
        $pageLimit = isset($request->page_limit) ? (int)$request->page_limit : 10;

        $query  = User::with('role')->with('company')->where('role_id', 2);

        // Filters
        if (isset($request->name) && $request->name !=='') {
            $query->where('name', 'LIKE', '%'.$request->name.'%');
        }

        if (isset($request->email) && $request->email !=='') {
            $query->where('email', 'LIKE', '%'.$request->email.'%');
        }

        if (isset($request->status) && $request->status !=='') {
            if ($request->status == 1) {
                $query->where('status', 1);
            } elseif ($request->status == 0) {
                $query->where('status', 0);
            } else {}
        }
        // if (isset($request->role) && $request->role !=='') {
        //     $query->where('role_id', $request->role);
        // }

        $users = $query->paginate($pageLimit);

        return response()->json(['employers' =>  $users], 200);        
    }

    /**
     * Create User/Recruiter
     *
     * @return Response
     */
    public function create(Request $request)
    {

        $authId = Auth::id();

        //validate incoming request 
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|max:16|confirmed',
        ]);

        try {

            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->role_id = 3; // role recruiter
            $user->api_token = Str::random(80);
            $user->employer_id = $authId;
            $user->password = app('hash')->make($request->input('password'));

            $user->save();

            //return successful response
            return response()->json(['user' => $user, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'User Registration Failed!'], 409);
        }

    }


    /**
     * Create Employer or Admin
     *
     * @return Response
     */
    public function adminCreate(Request $request)
    {

        $authId = Auth::id();

        $role = '';
        if (null !== $request->input('role')) {
            $role = $request->input('role');
        }


        //validate incoming request
        if ($role == 'admin') {
             $this->validate($request, [
                'name' => 'required|string|max:100',
                'email' => 'required|email|unique:users',
                'role' => 'required',
                'password' => 'required|string|min:8|max:16|confirmed',
            ]);
        } elseif ($role == 'employer') {
            $this->validate($request, [
                'name' => 'required|string|max:100',
                'email' => 'required|email|unique:users',
                'role' => 'required',
                'company_name' => 'required|string|max:100|unique:companies,name',
                'password' => 'required|string|min:8|max:16|confirmed',
            ]);
        } else {
            $this->validate($request, [
                'name' => 'required|string|max:100',
                'email' => 'required|email|unique:users',
                'role' => 'required',
                'password' => 'required|string|min:8|max:16|confirmed',
            ]);                
        }
        

        try {

            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->role_id = 2; // role employer
            $user->api_token = Str::random(80);
            $user->employer_id = null;
            $user->password = app('hash')->make($request->input('password'));

            $user->save();

            if ($role === 'employer') {
                $company = new Company;
                $company->name = $request->input('company_name');
                $company->employer_id = $user->id;
                $company->save();                
            }

            //return successful response
            return response()->json(['user' => $user, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'User Registration Failed!'], 409);
        }

    }


    public function delete($id)
    {

        $authId = Auth::id();

        if (Auth::user()->role_id == 1) {

            $user = User::findOrFail($id);
            $user->delete();

            return response()->json(['message' => 'DELETED'], 200);

        } elseif (Auth::user()->role_id == 2) {

            $user = User::where('id', $id)->where('employer_id', $authId)->firstOrFail();    
            $user->delete();

            return response()->json(['message' => 'DELETED'], 200);
            
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);   
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

}
