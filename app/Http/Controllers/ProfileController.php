<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Kelas;
use App\User;
use App\Guru;
use App\Rules\MatchOldPassword;
use DB;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{
    public function index()
    {
        $cls = Kelas::all();

        if (Auth::user()->role==2) {
            $role = "Admin";
            $jam = Auth::user()->type_jam;
            $kelas = "Kelas Atas - ".$jam;
        } elseif(Auth::user()->role==1) {
            $role = "Ketua Kelas";
            $y = Auth::user()->kelas_id;
            $z = Kelas::find($y);
            $kelas = $z->kelas;
        }
        elseif (Auth::user()->role==3) {
            $role = "Guru";
            $kelas = Guru::where('id','=',Auth::user()->guru_id)->first();
            $kelas = $kelas->nama;
        }
        return view('Auth.profile',compact('role','kelas','cls'));
    }

    public function change(Request $req)
    {
        $validate = $req->validate([
            'oldPass' => ['required', new MatchOldPassword],
            'newPass1' => ['required'],
            'newPass2' => ['same:newPass1'],
        ]);

        User::find(Auth::user()->id)
            ->update(['password'=> Hash::make($req->newPass1)]);

        alert()->success('','Password Berhasil Diubah')->background('#3B4252')->autoClose(1700);
        return redirect('/profile');
    }

    public function setjam(Request $req)
    {
        $jam = $req->type_jam;
        DB::update('update users set type_jam = ? where role = ?', [$jam,'2']);
        alert()->success('','Setting Jam Berhasil Diubah')->background('#3B4252')->autoClose(1700);
        return redirect()->back();
    }
}
