@extends('Template.template')

@section('title')
Data Guru | Journal
@endsection
@section('content')
<div class="container" style="margin-bottom: 110px">
    <!-- Header -->
    <div class="header">
        <h3>Data Guru</h3>
        <form action="{{\Request::url()}}" method="GET">
            <div class="form-group">
                <input type="text" class="search" name="search" placeholder="Mau Cari Siapa?"
                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'Mau Cari Siapa?'" autocomplete="off" />
                <button type="submit" class="btn caris">
                    <i class="fas fa-search"></i>
                </button>
                @if(Auth::user()->role == "2")
                <button type="button" class="btn tambah" data-toggle="modal" data-target="#modalscrollable">
                    <i class="fas fa-plus"></i>
                </button>
                @endif
            </div>
        </form>
    </div>

    <!-- Content -->
    <div class="konten">
        @forelse ($guru as $key => $gurus)
        <div class="list">
            <div class="item">

                @if (Auth::user()->role == "2")
                <a class="item-swipe itemDesk" href="#navCtrl" data-toggle="modal">{{$gurus->id}}. {{$gurus->nama}}</a>
                <div class="modal fade" id="navCtrl" tabindex="-1" role="modal" aria-labelledby="myModal" width="100%">
                    <div class="modal-dialog modal-sm modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModal">Navigasi Jurnal</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group text-center">
                                    <button class="btn btn-edit" type="button">
                                        <a href="guru/{{$gurus->id}}/edit">
                                            <span class="material-icons">edit</span>
                                        </a>
                                    </button>
                                    <button class="btn btn-delete" type="button">
                                        <a href="guru/{{$gurus->id}}/delete">
                                            <span class="material-icons">delete</span>
                                        </a>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="item-swipe itemMobile swipe-two" href="#"> {{$gurus->id}}. {{$gurus->nama}}</a>
                <div class="item-back">
                    <button class="action second btn-edit" type="button">
                        <a href="guru/{{$gurus->id}}/edit">
                            <span class="material-icons">edit</span>
                        </a>
                    </button>
                    <button class="action first btn-delete" type="button">
                        <a href="guru/{{$gurus->id}}/delete">
                            <span class="material-icons">delete</span>
                        </a>
                    </button>
                </div>
                @else
                <a class="item-swipex" href="#"> {{$gurus->id}}. {{$gurus->nama}}</a>
                @endif
            </div>
        </div>
        @empty
        @if (\Request::has('search'))
        <div class="list">
            <div class="item">
                <a class="item-swipex" href="#">
                    <center>
                        Data Guru Bernama <u>{{$src}}</u> Tidak Ditemukan
                    </center>
                </a>
            </div>
        </div>
        @else
        <div class="list">
            <div class="item">
                <a class="item-swipex" href="#">
                    <center>
                        Data Guru Kosong
                    </center>
                </a>
            </div>
        </div>
        @endif
        @endforelse
        {{$guru->links()}}
    </div>


    <!-- Modal Section -->
    <div class="modal fade mod1" id="modalscrollable" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" width="100%">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">
                        Tambah Data Guru.
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="form-box">
                        <form action="/guru/create-post" method="post" class="form-horizontal needs-validation"
                            novalidate>
                            @csrf
                            <div class="form-group col-md-12">
                                <label>Nama Guru</label>
                                <input type="text" class="form-control" name="nama" autocomplete="off" required>
                                <div class="invalid-feedback">Nama Guru Tidak Boleh Kosong.</div>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Kode Guru</label>
                                <input type="text" class="form-control" name="kode" autocomplete="off" required>
                                <div class="invalid-feedback">Kode Guru Tidak Boleh Kosong.</div>
                            </div>
                            <div class="bottom-button">
                                <input type="reset" class="btn btn-danger" id="danger">
                                <button type="submit" name="signup" class="btn btn-success">
                                    Tambah
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade mod2" id="modalfade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" width="100%">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">
                        Pilih Data
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="container" style="width: 100%">
                        <div class="konten-data mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <a class="isi-data" href="/siswa">
                                        <i class="fas fa-user-graduate mb-3"></i>
                                        <span>Data Siswa</span>
                                    </a>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <a class="isi-data" href="/guru">
                                        <i class="fas fa-user-tie mb-3"></i>
                                        <span>Data Guru</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
