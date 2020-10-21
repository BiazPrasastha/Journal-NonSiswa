@extends('Template.template')

@section('title')
Data Siswa | Journal
@endsection
@section('content')
<div class="container">
    <!-- Header -->
    <div class="header" style="border-bottom: 2px solid #81A1C1">
        <h3>Jurnal</h3>
        <div class="form-group" style="width: 98%">
            <select class="form-control datepicker" name="kelas"
                onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);"
                required>
                <option value="">Kelas</option>
                @foreach ($cls as $kelas)
                @if ( request()->is('jurnal/kelas/*'))
                <option value="{{$kelas->id}}" @if ($kelas->id == $id->id)
                    selected
                    @endif>
                    {{$kelas->kelas}}
                </option>
                @else
                <option value="jurnal/kelas/{{$kelas->id}}">{{$kelas->kelas}}</option>
                @endif
                @endforeach
            </select>
            <div class="invalid-feedback">Kelas Harus Diisi !</div>
        </div>
        <form action="" method="get">
            <div class="form-group">
                <input type="date" class="form-control datepicker" id="date" name="date" value="{{$dx}}">
                <button type="submit" class="btn filters">
                    <i class="fas fa-filter"></i>
                </button>
            </div>
        </form>
    </div>
    <!-- Content -->
    <div class="konten">
        <a href="#modalx" class="btn btn-print" data-toggle="modal" id="printModal">
            <i class="material-icons print-icon">print</i> <span>Print PDF</span>
        </a>
        <div class="unverify mb-4">

            @forelse ($jurnal as $jurnals)
            <div class="list">
                <div class="item">
                    @if (Auth::user()->role == 1)
                    <a class="item-swipe itemDesk" href="#navCtrl" data-toggle="modal">
                        <div class="jamke">
                            {{$jurnals->jam}}
                        </div>
                        <div class="mapel">{{$jurnals->mapel->mapel}}</div>
                    </a>
                    <div class="modal fade" id="navCtrl" tabindex="-1" role="modal" aria-labelledby="myModal"
                        width="100%">
                        <div class="modal-dialog modal-sm modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    {{-- <h4 class="modal-title" id="myModal">Navigasi Jurnal</h4> --}}
                                </div>
                                <div class="modal-body">
                                    <div class="form-group text-center" style="display: flex">
                                        <button class="btn btn-detail mr-2" type="button" style="flex: 1;">
                                            <a href="/jurnal/{{$jurnals->id}}/info">
                                                <span class="material-icons">info</span>
                                                <div class="link-action">
                                                    <h6>
                                                        Detail
                                                    </h6>
                                                </div>
                                            </a>
                                        </button>
                                        <button class="btn btn-acc mr-2" type="button" style="flex: 1;">
                                            <a href="/jurnal/{{$jurnals->id}}/edit">
                                                <span class="material-icons">assignment_turned_in</span>
                                                <div class="link-action">
                                                    <h6>
                                                        Accept
                                                    </h6>
                                                </div>
                                            </a>
                                        </button>
                                        <button class="btn btn-edit delete-confirm" type="button" style="flex: 1;">
                                            <a href="/jurnal/{{$jurnals->id}}/edit">
                                                <span class="material-icons">edit</span>
                                                <div class="link-action">
                                                    <h6>
                                                        Edit
                                                    </h6>
                                                </div>
                                            </a>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a class="item-swipe swipe-two itemMobile" href="/jurnal/{{$jurnals->id}}/info">
                        <div class="jamke">
                            {{$jurnals->jam}}
                        </div>
                        <div class="mapel">{{$jurnals->mapel->mapel}}</div>
                    </a>
                    <div class="item-back">
                        <button class="action second btn-acc" type="button">
                            <a href="/jurnal/{{$jurnals->id}}/edit">
                                <span class="material-icons">assignment_turned_in</span>
                            </a>
                        </button>
                        <button class="action first btn-edit" type="button">
                            <a href="/jurnal/{{$jurnals->id}}/edit">
                                <span class="material-icons">edit</span>
                            </a>
                        </button>
                    </div>
                    @else
                    <a class="item-swipex" href="/jurnal/{{$jurnals->id}}/info">
                        <div class="jamke">
                            {{$jurnals->jam}}
                            - {{$jurnals->kelas->kelas}}
                        </div>
                        <div class="mapel">{{$jurnals->mapel->mapel}}</div>
                    </a>
                    @endif
                </div>
            </div>
            @empty
            <div class="list">
                <div class="item">
                    <a class="item-swipex" href="#">
                        <center>
                            Jurnal Hari ini Kosong
                        </center>
                    </a>
                </div>
            </div>
            @endforelse
            @if (Auth::user()->role == 2)
            {{$jurnal->links()}}
            @endif
        </div>
        @if (Auth::user()->role == 1)
        <!-- Modal Section -->
        <div class="modal fade" id="modalscrollable" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true" width="100%">
            <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">
                            Tambah Jurnal.
                        </h4>
                    </div>
                    <div class="modal-body">
                        <form class="needs-validation" action="/jurnal/create-post" method="POST" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <div class="form-group col-sm-12">
                                        <select class="form-control m-input" name="mapel" required>
                                            <option value="">Mata Pelajaran</option>
                                            @foreach ($mpl as $mapels)
                                            <option value="{{$mapels->id}}">{{$mapels->mapel}}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">Mapel Harus Diisi !</div>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <select class="form-control m-input" name="guru" required>
                                            <option value="">Guru Mata Pelajaran</option>
                                            @foreach ($gr as $gurus)
                                            <option value="{{$gurus->id}}">{{$gurus->nama}}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">Guru Mapel Harus Diisi !</div>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <input type="text" class="form-control" name="materi"
                                            placeholder="Materi Yang Diberikan" autocomplete="off" required>
                                        <div class="invalid-feedback">Materi Harus Diisi !</div>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <input type="text" class="form-control" name="keterangan"
                                            placeholder="Keterangan" autocomplete="off">
                                    </div>
                                    <div class="form-group col-sm-12" style="align-items: flex-end">
                                        <div class="input-group btn-form">
                                            <button type="submit" class="btn btn-success btn-submit mr-3">
                                                <i class="fas fa-plus"></i>Tambah Jurnal
                                            </button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                Batal
                                            </button>
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
        {{-- end --}}
    </div>
    <div class="modal fade" id="modalx" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
        width="100%">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">
                        Print Jurnal
                    </h4>
                </div>
                <div class="modal-body">
                    <form action="/jurnal/print" method="POST">
                        @csrf
                        <input class=" form-control" name="bulan" type="month" value="{{$month}}">
                        <br>
                        @if (Auth::user()->role == 2)
                        <select class="form-control datepicker" name="kelas" required>
                            <option value="00">Semua</option>
                            @foreach ($cls as $kelas)
                            <option value="{{$kelas->id}}">{{$kelas->kelas}}</option>
                            @endforeach
                        </select>
                        @endif
                        <br>
                        <div class="dropdown">
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-success btn-block">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    @endsection
