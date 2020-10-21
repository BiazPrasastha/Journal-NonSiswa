<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use DB;
use Carbon\Carbon;

class isExist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $dt = Carbon::now();
        $jam = $dt->isoFormat('HHmm');
        $hari = $dt->isoFormat('dddd');
        $setting = DB::select('select type_jam from users where role = ?', [2]);
        $setting = $setting[0]->type_jam;
        if($setting == "PJJ"){
            if ($hari == "Saturday" | $hari == "Sunday") {
                $this->jamke = 'home';
            }
            else{
                if ($jam > '0800' & $jam <= '0900') {
                    $this->jamke = 1;
                }
                elseif ($jam > '0900' & $jam <= '1000') {
                    $this->jamke = 2;
                }
                elseif($jam >'1000' & $jam <= '1100'){
                    if($hari == "Friday"){
                        $this->jamke = 'home';
                    }
                    else{
                        $this->jamke =3;
                    }
                }
                elseif($jam >'1100' & $jam <= '1200'){
                    if ($hari == "Monday" | $hari == "Friday") {
                        $this->jamke = 'home';
                    }
                    else{
                        $this->jamke =4;
                    }
                }
                else {
                    $this->jamke = 'home';
                }

            }
        }
        elseif($setting == "Reguler"){
            if ($hari == "Saturday" | $hari == "Sunday") {
                $this->jamke = 'home';
            }
            elseif ($hari == "Friday") {
                if ($jam > '0700' & $jam <= '0745') {
                    $this->jamke = 1;
                }
                elseif ($jam > '0745' & $jam <= '0830') {
                    $this->jamke = 2;
                }
                elseif ($jam > '0830' & $jam <= '0915') {
                    $this->jamke = 3;
                }
                elseif ($jam > '0915' & $jam <= '0930') {
                    $this->jamke = "break";
                }
                elseif ($jam > '0930' & $jam <= '1015') {
                    $this->jamke = 4;
                }
                elseif ($jam > '1015' & $jam <= '1100') {
                    $this->jamke = 5;
                }
                elseif ($jam > '1100' & $jam <= '1145') {
                    $this->jamke = 6;
                }
                elseif ($jam > '1145' & $jam <= '1215') {
                    $this->jamke = "break";
                }
                elseif ($jam > '1215' & $jam <= '1300') {
                    $this->jamke = 7;
                }
                elseif ($jam > '1300' & $jam <= '1340') {
                    $this->jamke = 8;
                }
                else {
                    $this->jamke = "home";
                }
            }
            else{
                $jam = $dt->isoFormat('HHmm');
                if ($jam > '0700' & $jam <= '0745') {
                    if ($hari == "Monday") {
                        $this->jamke = "break";
                    }
                    else{
                        $this->jamke = 1;
                    }
                }
                elseif ($jam > '0745' & $jam <= '0830') {
                    if ($hari == "Monday") {
                        $this->jamke = "break";
                    }
                    else{
                        $this->jamke = 2;
                    }
                }
                elseif ($jam > '0830' & $jam <= '0915') {
                    $this->jamke = 3;
                }
                elseif ($jam > '0915' & $jam <= '0930') {
                    $this->jamke = "break";
                }
                elseif ($jam > '0930' & $jam <= '1015') {
                    $this->jamke = 4;
                }
                elseif ($jam > '1015' & $jam <= '1100') {
                    $this->jamke = 5;
                }
                elseif ($jam > '1100' & $jam <= '1145') {
                    $this->jamke = 6;
                }
                elseif ($jam > '1145' & $jam <= '1215') {
                    $this->jamke = "break";
                }
                elseif ($jam > '1215' & $jam <= '1300') {
                    $this->jamke = 7;
                }
                elseif ($jam > '1300' & $jam <= '1340') {
                    $this->jamke = 8;
                }
                elseif ($jam > '1340' & $jam <= '1420') {
                    $this->jamke = 9;
                }
                elseif ($jam > '1420' & $jam <= '1500') {
                    $this->jamke = 10;
                }
                elseif ($jam > '1500' & $jam <= '1515') {
                    $this->jamke = "break";
                }
                elseif ($jam > '1515' & $jam <= '1600') {
                    $this->jamke = 11;
                }
                else {
                    $this->jamke = "home";
                }
            }
        }

        if (Auth::user()->role == 1){
            $dt =Carbon::now();
            $kelas = Auth::user()->kelas_id;
            $tombol = DB::table('jurnal')->where('kelas_id','=',$kelas)->where('tanggal', '=', $dt->toDateString())->where('jam','=',$this->jamke)->first();
            if($tombol !== null){
                $tombol =  "disable";
            }
        }elseif (Auth::user()->role == 3) {
            $dt =Carbon::now();
            $guru = Auth::user()->guru_id;
            $tombol = DB::table('jurnal')->where('guru_id','=',$guru)->where('tanggal', '=', $dt->toDateString())->where('jam','=',$this->jamke)->first();
            if($tombol !== null){
                $tombol =  "disable";
            }
        }
        if ($tombol == "disable") {
            alert()->error('','Eitss Tidak Bisa')->background('#3B4252')->autoClose(2000);
            return redirect('/jurnal');
        }
        else{
            return $next($request);
        }
    }
}
