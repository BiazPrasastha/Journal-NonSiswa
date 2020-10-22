@extends('Template.template')

@section('title')
Detail Jurnal | Journal
@endsection

@section('content')

<div class="container">
    <!-- Header -->
    <div class="header" style="border-bottom: none;">
        <h3>
            <div style="border-bottom: 2px solid #81A1C1;margin-bottom:10px;padding-bottom:10px">
                {{$id->mapel->mapel}}
            </div>
            <div style="font-size: 2.2rem">

                Jam ke-{{$id->jam}}
            </div>
        </h3>
        <h6 style="margin-bottom: 50px;margin-top:-20px">{{$id->tanggal}}</h6>
    </div>

    <!-- Content -->
    <div class=" konten">
        <form class="needs-validation" action="" method="" novalidate>
            <div class="form col-sm-12 mb-4">
                <label>Guru</label>
                <div class="xlxx">
                    <li class="text-light" style="text-transform: capitalize">
                        {{$id->guru->nama}}
                    </li>
                </div>
            </div>

            <div class="form col-sm-12 mb-4">
                <label>Materi</label>
                <div class="xlxx">
                    <li class="text-light" style="text-transform: capitalize">
                        {{$id->materi}}
                    </li>
                </div>
            </div>

            <div class="form col-sm-12 mb-4">
                <label>Keterangan</label>
                <div class="xlxx">
                    @if ($id->keterangan == null)
                    <center> - </center>
                    @else
                    <li class="text-light" style="text-transform: capitalize">
                        {{$id->keterangan}}
                    </li>
                    @endif
                </div>
            </div>
            <div class="form col-sm-12 mb-4">
                <label>Absensi</label>
                <div class="xlxx">
                    @forelse ($id->siswa as $jurnalx)
                    @if ($jurnalx->pivot->keterangan == "Sakit")
                    <li class="text-danger">{{$jurnalx->nama}}
                        <div style="float:right" class="text-danger">
                            {{$jurnalx->pivot->keterangan}}
                        </div>
                    </li>
                    @endif
                    @if ($jurnalx->pivot->keterangan == "Ijin")
                    <li class="text-warning">{{$jurnalx->nama}}
                        <div style="float:right" class="text-warning">
                            {{$jurnalx->pivot->keterangan}}
                        </div>
                    </li>
                    @endif
                    @if ($jurnalx->pivot->keterangan == "Alpha")
                    <li class="text-info">{{$jurnalx->nama}}
                        <div style="float:right" class="text-info">
                            {{$jurnalx->pivot->keterangan}}
                        </div>
                    </li>
                    @endif
                    @empty
                    <li class="text-success">Nihil</li>

                    @endforelse
                </div>
            </div>
        </form>
    </div>

</div>


@endsection
