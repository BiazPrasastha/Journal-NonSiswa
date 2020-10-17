<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Jurnal;
use App\Mapel;
use App\Kelas;
use App\Siswa;
use App\User;
use Auth;
use Arr;
use App\Guru;
use Carbon\Carbon;
use PDF;
use SnappyImage;
use DB;

class JurnalController extends Controller
{
    private $jamke;
    public function __construct(){
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
    }

    public function index(Request $req,Jurnal $jurnal)
    {
        $dt =Carbon::now();
        $today = $dt->toDateString();
        $mpl = Mapel::orderBy('mapel','asc')->get();
        $gr = Guru::all();
        $cls = Kelas::all();
        $kelas = Auth::user()->kelas_id;
        $kls = Kelas::find($kelas);
        $siswa = Siswa::where('kelas_id','=',$kelas)->get();
        $guru = Auth::user()->guru_id;
        $jam = $this->jamke;
        $month = $dt->format('Y-m');

        //ketua
        if (Auth::user()->role == 1){
            if ($req->has('date') ) {
                $jurnal_valid = Jurnal::with('mapel')
                    ->with('guru')
                    ->with('siswa')
                    ->orderBy('tanggal', 'desc')
                    ->where('tanggal', '=', $req->date)
                    ->where('kelas_id', '=',$kls->id )
                    ->where('valid','=',1)
                    ->get();
                $jurnal_invalid = Jurnal::with('mapel')
                    ->with('guru')
                    ->with('siswa')
                    ->orderBy('tanggal', 'desc')
                    ->where('tanggal', '=', $req->date)
                    ->where('kelas_id', '=',$kls->id )
                    ->where('valid','=',0)
                    ->get();
                $dx =$req->date;
            }else{
                $jurnal_valid = Jurnal::with('mapel')
                    ->with('guru')
                    ->with('siswa')
                    ->orderBy('tanggal', 'desc')
                    ->where('tanggal', '=', $dt->toDateString())
                    ->where('kelas_id', '=',$kls->id )
                    ->where('valid','=',1)
                    ->get();
                $jurnal_invalid = Jurnal::with('mapel')
                    ->with('guru')
                    ->with('siswa')
                    ->orderBy('tanggal', 'desc')
                    ->where('tanggal', '=', $dt->toDateString())
                    ->where('kelas_id', '=',$kls->id )
                    ->where('valid','=',0)
                    ->get();
                $dx =$dt->toDateString();
            }
        }
        //admin
        elseif(Auth::user()->role == 2) {
            if ($req->has('date') ) {
                $jurnal = Jurnal::with('mapel')
                    ->with('guru')
                    ->with('siswa')
                    ->orderBy('tanggal', 'desc')
                    ->where('tanggal', '=', $req->date)
                    ->where('valid','=',1)
                    ->simplePaginate(10);
                $dx =$req->date;
                $jurnal->appends(['date' => $req->date]);
            }else{
                $jurnal = Jurnal::with('mapel')
                    ->with('guru')
                    ->with('siswa')
                    ->orderBy('tanggal', 'desc')
                    ->where('tanggal', '=', $dt->toDateString())
                    ->where('valid','=',1)
                    ->simplePaginate(10);
                $dx =$dt->toDateString();
            }
        }
        //guru
        elseif(Auth::user()->role == 3){
            if ($req->has('date') ) {
                $jurnal_valid = Jurnal::with('mapel')
                    ->with('guru')
                    ->with('siswa')
                    ->orderBy('tanggal', 'desc')
                    ->where('tanggal', '=', $req->date)
                    ->where('valid', '=', 1)
                    ->where('guru_id', '=', $guru)
                    ->get();
                $jurnal_invalid = Jurnal::with('mapel')
                    ->with('guru')
                    ->with('siswa')
                    ->orderBy('tanggal', 'desc')
                    ->where('tanggal', '=', $req->date)
                    ->where('valid', '=', 0)
                    ->where('guru_id', '=', $guru)
                    ->get();
                $dx =$req->date;
            }else{
                $jurnal_valid = Jurnal::with('mapel')
                    ->with('guru')
                    ->with('siswa')
                    ->orderBy('tanggal', 'desc')
                    ->where('tanggal', '=', $dt
                    ->toDateString())
                    ->where('valid', '=', 1)
                    ->where('guru_id', '=', $guru)
                    ->get();
                $jurnal_invalid = Jurnal::with('mapel')
                    ->with('guru')
                    ->with('siswa')
                    ->orderBy('tanggal', 'desc')
                    ->where('tanggal', '=', $dt->toDateString())
                    ->where('valid', '=', 0)
                    ->where('guru_id', '=', $guru)
                    ->get();
                $dx =$dt->toDateString();
            }
        }
        if (Auth::user()->role == 1) {
            return view('Jurnal.index[ketua]', compact('mpl','gr','jam','siswa','dx','cls','today','jurnal_valid','jurnal_invalid'));
        }
        elseif (Auth::user()->role == 2) {
            return view('Jurnal.index[admin]', compact('jurnal','mpl','gr','jam','siswa','dx','cls','today','month'));
        }
        elseif (Auth::user()->role == 3) {
            return view('Jurnal.index[guru]', compact('mpl','gr','jam','siswa','dx','cls','today','jurnal_valid','jurnal_invalid'));
        }
    }

    public function createp(Request $req)
    {
        $dt =Carbon::now();
        $kelas = Auth::user()->kelas_id;
        $kls = Kelas::find($kelas);
        $guru = Auth::user()->guru_id;
        $jurnal = new Jurnal();
        if (Auth::user()->role == 1) {
            $jurnal->kelas_id = $kls->id;
        }
        elseif (Auth::user()->role == 3) {
            $x = $req->kelas.' '.$req->jurusan.$req->urut;
            $all = Kelas::where('kelas', '=', $x)->get();
            if ($all->count() == 0) {
                alert()->error('','Kelas '.$x .' Tidak Valid')->background('#3B4252')->autoClose(2000);
                return redirect()->back();
            }
            else {
                $jurnal->kelas_id = $all[0]->id;
            }
        }
        else{
            return redirect()->back();
        }
        $jurnal->tanggal = $dt->toDateString();
        $jurnal->jam = $this->jamke;
        $jurnal->mapel_id = $req->mapel;
        if (Auth::user()->role == 1) {
            $jurnal->guru_id = $req->guru;
        }
        elseif (Auth::user()->role == 3) {
            $jurnal->guru_id = $guru;
        }
        $jurnal->materi = $req->materi;
        $jurnal->keterangan = $req->keterangan;
        if (Auth::user()->role == 1) {
            $jurnal->valid = 1;
        }
        elseif(Auth::user()->role ==3){
            $jurnal->valid = 0;
        }
        if (Auth::user()->role == 1) {
            $valid = Jurnal::where('jam', '=',$this->jamke)
            ->where('tanggal', '=', $dt->toDateString())
            ->where('kelas_id', '=', $kls->id)
            ->first();
        }
        elseif (Auth::user()->role == 3) {
            $valid = Jurnal::where('jam', '=',$this->jamke)
            ->where('tanggal', '=', $dt->toDateString())
            ->where('mapel_id', '=', $req->mapel)
            ->first();
        }
        if ($valid == null) {
            $jurnal->save();
            return redirect('/jurnal');
        }
        else{
            alert()->error('','Jurnal Sudah Ada')->background('#3B4252')->autoClose(2000);
            return redirect()->back();
        }
    }

    public function add(Jurnal $id)
    {
        $dt =Carbon::now();
        $dt = $dt->toDateString();
        $kelas = $id->kelas_id;

        if($dt == $id->tanggal){
            $siswa = Siswa::where('kelas_id','=',$kelas)->get();
            return view('Jurnal.add',compact('id','siswa'));
        }
        else{
            alert()->error('','Batas Absen Kadaluarsa')->background('#3B4252')->autoClose(2000);
            return redirect()->back();
        }
    }

    public function addp(Request $req, Jurnal $id)
    {
        $jurnal = Jurnal::find($id->id);
        $absen = collect($req->absen);
        $keterangan = collect($req->abs);
        $jumlah = $absen->count();

        if($keterangan->contains('#')){
            alert()->error('','Lengkapi Keterangan Absensi')->background('#3B4252')->autoClose(2000);
            return redirect()->back();
        }
        else{
            $valid = DB::table('jurnal_siswa')
                ->where('jurnal_id', $id->id)
                ->where('siswa_id', $req->absen)
                ->get();
            $valid = $valid->toArray();
            if ($valid == null) {
                for ($i=0; $i <$jumlah ; $i++) {
                    DB::insert('insert into jurnal_siswa (jurnal_id, siswa_id,keterangan) values (?, ?, ?)', [$id->id,$absen[$i], $keterangan[$i]]);
                }
                alert()->success('','Absen Siswa Berhasil Ditambahkan')->background('#3B4252')->autoClose(2000);
                return redirect('/jurnal');
            }
            else {
                for ($i=0; $i <$jumlah ; $i++) {
                    $query = DB::update('update jurnal_siswa set keterangan = ? where jurnal_id = ? AND siswa_id = ?', [$keterangan[$i],$id->id,$absen[$i]]);
                }
                alert()->success('','Absen Siswa Berhasil Diupdate')->background('#3B4252')->autoClose(2000);
                return redirect('/jurnal');
            }
        }

    }

    public function edit(Jurnal $id)
    {
        $dt =Carbon::now();
        $dt = $dt->toDateString();
        $absen = DB::table('jurnal_siswa')
                ->where('jurnal_id','=',$id->id)
                ->get();
        $siswa = Siswa::where('kelas_id','=',$id->kelas_id)->get();
        // if($id->valid == 1){
        //     alert()->error('','Eitss Tidak Bisa')->background('#3B4252')->autoClose(2000);
        //     return redirect('/jurnal');
        // }
        // else {
        // }
            if ($dt == $id->tanggal) {
                $mpl = Mapel::orderBy('mapel','asc')->get();
                $gr = Guru::all();
                $kls = Kelas::all();
                return view('Jurnal.edit',compact('id','mpl','gr','kls','absen','siswa'));
            }
            else{
                alert()->error('','Batas Edit Kadaluarsa')->background('#3B4252')->autoClose(2000);
                return redirect()->back();
            }
    }

    public function editp(Request $req,Jurnal $id)
    {
        // if($id->valid == 1 ){
        //     alert()->error('','Eitss Tidak Bisa')->background('#3B4252')->autoClose(2000);
        //     return redirect('/jurnal');
        // }
        // else {
        // }
        $absen = collect($req->absen);
        $keterangan = collect($req->abs);
        $absen_array = $absen->toArray();
        if(count(array_unique($absen_array))<count($absen_array))
        {
            alert()->error('','Absen Duplikat')->background('#3B4252')->autoClose(2000);
            return redirect()->back();
        }
        else
        {
            alert()->success('','Absen Berhasil')->background('#3B4252')->autoClose(2000);
            return redirect()->back();
        }
        $id->fill($req->all());
        $id->mapel_id = $req->mapel_id;
        $id->save();
        return redirect('/jurnal');
    }

    public function info(Jurnal $id)
    {
        return view('Jurnal.info',compact('id'));
    }

    public function delete(Jurnal $id)
    {
        $dt =Carbon::now();
        $dt = $dt->toDateString();

        // if ($id->valid == 1) {
        //     alert()->error('','Eitss Tidak Bisa')->background('#3B4252')->autoClose(2000);
        //     return redirect('/jurnal');
        // }
        // else {
        // }
            if ($dt == $id->tanggal) {
                DB::table('jurnal_siswa')
                    ->where('jurnal_id','=',$id->id)
                    ->delete();
                $id->delete();
                alert()->success('','Jurnal Jam ke - '. $id->jam . ' - ' .$id->tanggal .' Berhasil Dihapus')->background('#3B4252')->autoClose(2000);
                return redirect()->back();
            } else {
                alert()->error('','Batas Hapus Kadaluarsa')->background('#3B4252')->autoClose(2000);
                return redirect()->back();
            }
    }

    public function bulanan(Request $req,Jurnal $jurnal)
    {
        $dt = Carbon::now()->isoFormat('YYYY-MM');
        $month = Carbon::parse($req->search)->format("M");
        $year = Carbon::parse($req->search)->format("Y");
        $kelas = Auth::user()->kelas_id;
        $kls = Kelas::find($kelas);

        if (Auth::user()->role == 2) {
            if ($req->has('search')) {
                $jurnal = Jurnal::with('mapel')
                    ->with('guru')
                    ->with('siswa')
                    ->with('kelas')
                    ->orderBy('tanggal', 'desc')
                    ->where('tanggal', 'LIKE', '%' . $req->search . '%')
                    ->paginate(15);
                $dt = $req->search;
            }
            else{
                $jurnal = Jurnal::with('mapel')
                    ->with('guru')
                    ->with('siswa')
                    ->with('kelas')
                    ->orderBy('tanggal', 'desc')
                    ->paginate(15);
            }
        }
        else {
            if ($req->has('search')) {
                $jurnal = Jurnal::with('mapel')
                    ->with('guru')
                    ->with('siswa')
                    ->with('kelas')
                    ->orderBy('tanggal', 'desc')
                    ->where('tanggal', 'LIKE', '%' . $req->search . '%')
                    ->where('kelas_id', '=', $kls->id)
                    ->paginate(15);
                $dt = $req->search;
            }
            else{
                $jurnal = Jurnal::with('mapel')
                    ->with('guru')
                    ->with('siswa')
                    ->with('kelas')
                    ->orderBy('tanggal', 'desc')
                    ->where('kelas_id', '=', $kls->id)
                    ->paginate(15);
            }
        }
        return view('Jurnal.bulanan',compact('jurnal','dt','month','year'));
    }

    public function print(Request $req)
    {
        $month = Carbon::parse($req->bulan)->format("M");
        $year = Carbon::parse($req->bulan)->format("Y");
        $cls = Kelas::all();

        if($req->kelas == 00){
            $jurnal = Jurnal::with('mapel')
                ->with('guru')
                ->with('siswa')
                ->with('kelas')
                ->orderBy('kelas_id', 'desc')
                ->where('tanggal', 'LIKE', '%' . $req->bulan . '%')
                ->get()
                ->groupBy('kelas_id');
            $kelas = "All";
        }else{
            $jurnal = Jurnal::with('mapel')
                ->with('guru')
                ->with('siswa')
                ->with('kelas')
                ->orderBy('tanggal', 'desc')
                ->where('tanggal', 'LIKE', '%' . $req->bulan . '%')
                ->where('kelas_id','=',$req->kelas)
                ->get();
            $kelas = Kelas::find($req->kelas);
            $kelas = $kelas->kelas;
        }
        $pdf = PDF::loadview('Jurnal.jurnal_pdf',compact('jurnal','month','year','cls','kelas'));
        $pdf->setPaper('A4','landscape');
        return $pdf->stream('Jurnal_'. $req->bulan .'_'. $kelas);
    }

    public function kelas(Kelas $id, Request $req)
    {
        $dt =Carbon::now();
        $mpl = Mapel::orderBy('mapel','asc')->get();
        $gr = Guru::all();
        $kelas = Auth::user()->kelas_id;
        $siswa = Siswa::where('kelas_id','=',$kelas)->get();
        $kls = Kelas::find($kelas);
        $cls = Kelas::all();
        $jam = $this->jamke;
        $month = $dt->format('Y-m');

        if ($req->has('date') ) {
            $jurnal = Jurnal::with('mapel')
                ->with('guru')
                ->with('siswa')
                ->orderBy('tanggal', 'desc')
                ->where('tanggal', '=', $req->date)
                ->where('kelas_id', '=',$id->id )
                ->simplePaginate(10);
            $jurnal->appends(['date' => $req->date]);
            $dx =$req->date;

        }else{
            $jurnal = Jurnal::with('mapel')
                ->with('guru')
                ->with('siswa')
                ->orderBy('tanggal', 'desc')
                ->where('tanggal', '=', $dt->toDateString())
                ->where('kelas_id', '=',$id->id )
                ->simplePaginate(10);
            $dx =$dt->toDateString();
        }
        return view('Jurnal.index[admin]', compact('jurnal','mpl','gr','jam','siswa','dx','cls','id','month'));
    }
    public function acc(Jurnal $id)
    {
        $id->valid = 1;
        $id->save();

        alert()->success('','Jurnal Berhasil Di Accept')->background('#3B4252')->autoClose(2000);
        return redirect()->back();
    }
}
