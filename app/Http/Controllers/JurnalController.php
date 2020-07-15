<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Jurnal;
use App\Mapel;
use App\Kelas;
use App\Siswa;
use Auth;
use Arr;
use App\Guru;
use Carbon\Carbon;
use PDF;
use DB;
class JurnalController extends Controller
{
    private $jamke;
    public function __construct()
    {
        $dt =Carbon::now();
        $jam = $dt->isoFormat('HHmm');
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
        elseif ($jam > '1300' & $jam <= '1345') {
            $this->jamke = 8;
        }
        elseif ($jam > '1345' & $jam <= '1430') {
            $this->jamke = 9;
        }
        elseif ($jam > '1430' & $jam <= '1500') {
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

    public function index(Request $req,Jurnal $jurnal)
    {
        $dt =Carbon::now();
        $mpl = Mapel::orderBy('mapel','asc')->get();
        $gr = Guru::all();
        $kelas = Auth::user()->kelas_id;
        $siswa = Siswa::where('kelas_id','=',$kelas)->get();
        $kls = Kelas::find($kelas);
        $cls = Kelas::all();
        if (Auth::user()->role == 1){
            if ($req->has('date') ) {
                $jurnal = Jurnal::with('mapel')
                ->with('guru')->with('siswa')->orderBy('tanggal', 'desc')->where('tanggal', '=', $req->date)->where('kelas_id', '=',$kls->id )
                ->get();
                $dx =$req->date;

            }else{
                $jurnal = Jurnal::with('mapel')
                ->with('guru')->with('siswa')->orderBy('tanggal', 'desc')->where('tanggal', '=', $dt->toDateString())->where('kelas_id', '=',$kls->id )
                ->get();
                $dx =$dt->toDateString();
            }
        }
        else {
            if ($req->has('date') ) {
                $jurnal = Jurnal::with('mapel')
                ->with('guru')->with('siswa')->orderBy('tanggal', 'desc')->where('tanggal', '=', $req->date)->simplePaginate(10);
                $dx =$req->date;
                $jurnal->appends(['date' => $req->date]);
            }else{
                $jurnal = Jurnal::with('mapel')
                ->with('guru')->with('siswa')->orderBy('tanggal', 'desc')->where('tanggal', '=', $dt->toDateString())->simplePaginate(10);
                $dx =$dt->toDateString();
            }
        }
        $jam = $this->jamke;
        return view('Jurnal.index', compact('jurnal','mpl','gr','jam','siswa','dx','cls'));
    }

    public function createp(Request $req)
    {
        //Variabel
        $dt =Carbon::now();
        $kelas = Auth::user()->kelas_id;
        $kls = Kelas::find($kelas);

        //Input Tabel Jurnal
        $jurnal = new Jurnal();
        $jurnal->kelas_id = $kls->id;
        $jurnal->tanggal = $dt->toDateString();
        $jurnal->jam = $this->jamke;
        $jurnal->mapel_id = $req->mapel;
        $jurnal->guru_id = $req->guru;
        $jurnal->materi = $req->materi;
        $jurnal->keterangan = $req->keterangan;

        //Validasi
        $valid = Jurnal::where('jam', '=',$this->jamke)->where('tanggal', '=', $dt->toDateString())->where('kelas_id', '=', $kls->id)->first();
        if ($valid == null) {
            $jurnal->save();
            return redirect('/jurnal');
        }
        else{
            return redirect()->back();
        }
    }

    public function add(Jurnal $id)
    {
        $dt =Carbon::now();
        $dt = $dt->toDateString();
        if($dt == $id->tanggal){
            $kelas = Auth::user()->kelas_id;
            $siswa = Siswa::where('kelas_id','=',$kelas)->get();
            return view('Jurnal.add',compact('id','siswa'));
        }
        else{
            alert()->error('','Batas Edit Kadaluarsa')->background('#3B4252')->autoClose(2000);
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
            $valid = DB::table('jurnal_siswa')->where('jurnal_id', $id->id)->where('siswa_id', $req->absen)->first();
            if ($valid == null) {
                for ($i=0; $i <$jumlah ; $i++) {
                    DB::insert('insert into jurnal_siswa (jurnal_id, siswa_id,keterangan) values (?, ?, ?)', [$id->id,$absen[$i], $keterangan[$i]]);
                }
                alert()->success('','Absen Siswa Berhasil Ditambahkan')->background('#3B4252')->autoClose(2000);
                return redirect('/jurnal');
            }
            else {

                $dx = array_search($valid->siswa_id, $req->absen);
                DB::table('jurnal_siswa')
                ->where('id', $valid->id)
                ->update(['keterangan' => $keterangan[$dx]]);
                return redirect('/jurnal');
            }
        }

    }
    public function edit(Jurnal $id)
    {
        $dt =Carbon::now();
        $dt = $dt->toDateString();
        if ($dt == $id->tanggal) {
            $mpl = Mapel::orderBy('mapel','asc')->get();
            $gr = Guru::all();
            return view('Jurnal.edit',compact('id','mpl','gr'));
        }
        else{
            alert()->error('','Batas Edit Kadaluarsa')->background('#3B4252')->autoClose(2000);
            return redirect()->back();
        }
    }
    public function editp(Request $req,Jurnal $id)
    {
        $id->fill($req->all());
        $id->mapel_id = $req->mapel_id;
        $id->guru_id = $req->guru_id;
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
        if ($dt == $id->tanggal) {
            DB::table('jurnal_siswa')->where('jurnal_id','=',$id->id)->delete();
            $id->delete();
            alert()->success('','Jurnal Jam ke - '. $id->id .' Berhasil Dihapus')->background('#3B4252')->autoClose(2000);
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
                            ->with('guru')->with('siswa')->with('kelas')->orderBy('tanggal', 'desc')->where('tanggal', 'LIKE', '%' . $req->search . '%')
                            ->paginate(15);
                $dt = $req->search;
            }
            else{
                $jurnal = Jurnal::with('mapel')
                            ->with('guru')->with('siswa')->with('kelas')->orderBy('tanggal', 'desc')
                            ->paginate(15);
            }
        }
        else {
            if ($req->has('search')) {
                $jurnal = Jurnal::with('mapel')
                            ->with('guru')->with('siswa')->with('kelas')->orderBy('tanggal', 'desc')->where('tanggal', 'LIKE', '%' . $req->search . '%')->where('kelas_id', '=', $kls->id)
                            ->paginate(15);
                $dt = $req->search;
            }
            else{
                $jurnal = Jurnal::with('mapel')
                            ->with('guru')->with('siswa')->with('kelas')->orderBy('tanggal', 'desc')->where('kelas_id', '=', $kls->id)
                            ->paginate(15);
            }
        }

        return view('Jurnal.bulanan',compact('jurnal','dt','month','year'));
    }

    public function print(Request $req)
    {
        if($req->kelas == 00){
            $jurnal = Jurnal::with('mapel')
            ->with('guru')->with('siswa')->with('kelas')->orderBy('tanggal', 'desc')->where('tanggal', 'LIKE', '%' . $req->bulan . '%')
            ->get();
            $kelas = "All";
        }else{
            $jurnal = Jurnal::with('mapel')
            ->with('guru')->with('siswa')->with('kelas')->orderBy('tanggal', 'desc')->where('tanggal', 'LIKE', '%' . $req->bulan . '%')->where('kelas_id','=',$req->kelas)
            ->get();
            $kelas = Kelas::find($req->kelas);
            $kelas = $kelas->kelas;
        }
        $month = Carbon::parse($req->bulan)->format("M");
        $year = Carbon::parse($req->bulan)->format("Y");
        $pdf = PDF::loadview('Jurnal.jurnal_pdf',compact('jurnal','month','year'));
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

        if ($req->has('date') ) {
            $jurnal = Jurnal::with('mapel')
            ->with('guru')->with('siswa')->orderBy('tanggal', 'desc')->where('tanggal', '=', $req->date)->where('kelas_id', '=',$id->id )
            ->simplePaginate(10);
            $jurnal->appends(['date' => $req->date]);
            $dx =$req->date;

        }else{
            $jurnal = Jurnal::with('mapel')
            ->with('guru')->with('siswa')->orderBy('tanggal', 'desc')->where('tanggal', '=', $dt->toDateString())->where('kelas_id', '=',$id->id )
            ->simplePaginate(10);
            $dx =$dt->toDateString();
        }
        $jam = $this->jamke;
        return view('Jurnal.index', compact('jurnal','mpl','gr','jam','siswa','dx','cls','id'));
    }
}