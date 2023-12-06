<?php
use App\Helpers\FuncionesComunes;
?>
@extends('admin.templates.contenido')

@section('link')
    <link href="{{ url('') }}/assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link href="{{ url('') }}/assets/plugins/DataTables/extensions/Buttons/css/buttons.bootstrap.min.css"
        rel="stylesheet" />
    <link href="{{ url('') }}/assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css"
        rel="stylesheet" />
    <style>
        .no_atendido {
            background: rgb(218, 28, 28) !important;
            color: white;
        }

        .atendido {
            background: rgb(0, 135, 27) !important;
            color: white;
        }

        .pendiente {
            background: rgb(253, 245, 0) !important;
            color: black;
        }
    </style>
@endsection

@section('content_contenido')
    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-md-12">

            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default"
                            data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success"
                            data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning"
                            data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger"
                            data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Panel</h4>
                </div>
                <div class="row">
                    <div class="col-md-9 text-center" style="">
                        <h2 style="margin-bottom:0">Conceptos Nuevo</h2>
                    </div>
                    <div class="col-md-12" style="">
                        @if (Session::has('mensaje'))
                            <div class="alert alert-{{ Session::get('class-alert') }} fade in m-b-15"
                                style="margin-bottom:0">
                                {{ Session::get('mensaje') }}
                                <span class="close" data-dismiss="alert">×</span>
                            </div>
                        @endif
                    </div>
                    @if (Session::has('error'))
                        <div class="alert alert-danger fade in">
                            {{ Session::get('error') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>
                <div class="panel-body">
                    <form action="{{ route('conceptos.store') }}" method="post">
                        @csrf
                        @include('conceptos.form.form')
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{ route('conceptos.index') }}" class="btn btn-default">Volver</a>
                                <button type="submit" class="btn btn-success">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-10 -->
    </div>
@endsection


@section('script_1')
@endsection

@section('script_3')
@endsection
