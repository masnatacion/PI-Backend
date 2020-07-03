<?php

namespace App\Http\Controllers;


use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use App\Entities\User;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        return $this->ok($user->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|max:255',
            'lastname'  => 'required|max:255',
            'email'     => ['required','email','max:255',
                            'unique:users,email',
                            ],
            'username'  => ['required','max:6',
                            'unique:users,username',
                            ],
            'password'  => 'required|max:255',
            'role'      => ['required',
                            Rule::in(['admin', 'employee']),
                        ],
            'status'    => ['required',
                            Rule::in(['active', 'inactive']),
                        ],
        ]);

        if ($validator->fails())
            return $this->bad_request($validator->errors());

        $user = User::create($request->all());

        return $this->created($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->ok($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'max:255',
            'lastname'  => 'max:255',
            'email'     => ['email','max:255',
                            'exists:App\Entities\User,email',
                            ],
            'password'  => 'max:255',
            'role'      => [
                            Rule::in(['admin', 'employee']),
                        ],
            'status'    => [
                            Rule::in(['active', 'inactive']),
                        ],
        ]);

        if ($validator->fails())
            return $this->bad_request($validator->errors());

        $user->update($request->all());
        return $this->ok($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return $this->deleted();
    }
}
