<?php
/**
 * Created by PhpStorm.
 * User: mary
 * Date: 25-12-15
 * Time: 04:30
 */

namespace App\Http\Controllers;


use App\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class GuestController extends Controller

{
    public function __construct()
    {
    }

    public function postGuest(Request $request)
    {
        $persona = new Persona(["firstname" => $request->input("firstname"),
            "lastname" => $request->input("lastname"),
            "email" => $request->input("email"),
            "phonenumber" => $request->input("phonenumber"),
            "quota" => $request->input("quota")]);

        $inviteur = User::where("email", Auth::user()->email)->get()->first();

        $guest = new Guest($request->input("email"), $persona);

        $guest->getInvitationFrom(Auth::user()->email);
    }


}