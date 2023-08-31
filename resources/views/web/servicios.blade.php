@extends('layouts.web')


@section('css')
    <style>
        .contenedor_especialidades .doctor {
            display: flex;
            margin-bottom: 20px;
        }

        .contenedor_especialidades .doctor .foto {
            width: 35%;
        }

        .contenedor_especialidades .doctor .foto img {
            width: 100%;
        }

        .contenedor_especialidades .doctor .descripcion {
            padding: 10px;
        }

        .contenedor_especialidades .doctor .descripcion p{
            font-weight: normal;
        }

        @media(max-width:765px) {
            .contenedor_especialidades .doctor {
                flex-direction: column;
            }

            .contenedor_especialidades .doctor .foto {
                width: 100%;
                text-align: center;
            }

            .contenedor_especialidades .doctor .foto img {
                width: 50%;
            }

            .contenedor_especialidades .doctor .descripcion p {
                font-size: 0.9em;
                margin-bottom: 3px;
            }
        }
    </style>
@endsection

@section('contenido')
    <div id="theme-page" class="master-holder  clearfix" itemscope="itemscope" itemtype="https://schema.org/Blog">

        <div class="master-holder-bg-holder">
            <div id="theme-page-bg" class="master-holder-bg js-el"></div>
        </div>

        <div class="mk-main-wrapper-holder">

            <div id="mk-page-id-15" class="theme-page-wrapper mk-main-wrapper mk-grid full-layout  no-padding">
                <div class="theme-content no-padding" itemprop="mainEntityOfPage">

                    <div class="mk-page-section-wrapper" data-mk-full-width="true" data-mk-full-width-init="true"
                        data-mk-stretch-content="true">
                        <div id="page-section-610d572d2b3ba"
                            class="mk-page-section self-hosted   full_layout full-width-610d572d2b3ba js-el js-master-row"
                            data-intro-effect="false">



                            <div class="mk-page-section-inner">



                                <div class="mk-video-color-mask"></div>



                                <div class="mk-section-preloader js-el" data-mk-component="Preloader">
                                    <div class="mk-section-preloader__icon"></div>
                                </div>

                                @php
                                    $desktop = url('img/portal/Nosotros/medicos-color-1.jpg');
                                    $tablet = url('img/portal/Nosotros/medicos-color-2.jpg');
                                    $movile = url('img/portal/Nosotros/medicos-color-3.jpg');
                                @endphp

                                <div class="background-layer-holder">
                                    <div id="background-layer--610d572d2b3ba" data-mk-lazyload="false"
                                        class="background-layer mk-background-stretch none-blend-effect js-el"
                                        data-mk-component="Parallax" data-parallax-config='{"speed" : 0.3 }'
                                        data-mk-img-set='{"landscape":{"desktop":"{{ $desktop }}","tablet":"{{ $tablet }}","mobile":"{{ $movile }}"},"responsive":"true"}'>
                                        <div class="mk-color-layer"></div>
                                    </div>
                                </div>

                            </div>


                            <div class="page-section-content vc_row-fluid mk-grid ">
                                <div class="mk-padding-wrapper wpb_row">
                                    <div style="" class="vc_col-sm-12 wpb_column column_container  _ height-full">

                                        <div id="padding-2" class="mk-padding-divider   clearfix"></div>

                                        <style id="mk-shortcode-style-2" type="text/css">
                                            #padding-2 {
                                                height: 40px;
                                            }
                                        </style>
                                        <h2 id="fancy-title-610d572d2fd6e"
                                            class="mk-fancy-title  simple-style   color-single">
                                            <span>

                                                <p style="text-align: left;">SERVICIOS</p>
                                            </span>
                                        </h2>
                                        <div class="clearboth"></div>



                                        <style id="mk-shortcode-style-610d572d2fd6e" type="text/css">
                                            #fancy-title-610d572d2fd6e {
                                                letter-spacing: 0px;
                                                text-transform: initial;
                                                font-size: 32px;
                                                color: #ffffff;
                                                text-align: left;
                                                font-style: inherit;
                                                font-weight: bold;
                                                padding-top: 0px;
                                                padding-bottom: 0px;
                                            }

                                            #fancy-title-610d572d2fd6e span {}

                                            #fancy-title-610d572d2fd6e span i {
                                                font-style: inherit;
                                            }

                                            @media handheld,
                                            only screen and (max-width:767px) {
                                                #fancy-title-610d572d2fd6e {
                                                    text-align: center !important;
                                                }
                                            }
                                        </style>
                                        <div
                                            class="vc_separator wpb_content_element vc_separator_align_center vc_sep_width_10 vc_sep_border_width_3 vc_sep_pos_align_left vc_separator_no_text vc_sep_color_grey">
                                            <span class="vc_sep_holder vc_sep_holder_l"><span
                                                    class="vc_sep_line"></span></span><span
                                                class="vc_sep_holder vc_sep_holder_r"><span
                                                    class="vc_sep_line"></span></span>
                                        </div>
                                        <h2 id="fancy-title-610d572d3196a"
                                            class="mk-fancy-title  simple-style   color-single">
                                            <span>

                                                <p style="text-align: left;">Conoce las especialidades</p>
                                            </span>
                                        </h2>
                                        <div class="clearboth"></div>



                                        <style id="mk-shortcode-style-610d572d3196a" type="text/css">
                                            #fancy-title-610d572d3196a {
                                                letter-spacing: 0px;
                                                text-transform: initial;
                                                font-size: 14px;
                                                color: #ffffff;
                                                text-align: left;
                                                font-style: inherit;
                                                font-weight: inherit;
                                                padding-top: 0px;
                                                padding-bottom: 0px;
                                            }

                                            #fancy-title-610d572d3196a span {}

                                            #fancy-title-610d572d3196a span i {
                                                font-style: inherit;
                                            }

                                            @media handheld,
                                            only screen and (max-width:767px) {
                                                #fancy-title-610d572d3196a {
                                                    text-align: center !important;
                                                }
                                            }
                                        </style>
                                        <div id="padding-3" class="mk-padding-divider   clearfix"></div>

                                        <style id="mk-shortcode-style-3" type="text/css">
                                            #padding-3 {
                                                height: 40px;
                                            }
                                        </style>
                                    </div>
                                </div>
                                <div class="clearboth"></div>
                            </div>






                            <div class="clearboth"></div>
                        </div>
                    </div>
                    <div class="vc_row-full-width vc_clearfix"></div>

                    <div class="vc_col-md-12 mi-img" style="margin-top:10px;min-height:auto;">
                        <h4>Especialidades médicas</h4>
                        <div class="contenedor_especialidades">
                            <div class="doctor">
                                <div class="foto">
                                    <img src="{{ asset('img/d1.jpeg') }}" alt="Foto">
                                </div>
                                <div class="descripcion">
                                    <p><strong>DR. JORGE RIVERA BUITRAGO – OTORRINOLARINGOLOGO</strong></p>
                                    <p><strong>CEL: 73440044</strong></p>
                                    <p>ESPECIALIZADO EN EL HOSPITAL DE BS. AS. ARGENTINA</p>
                                    <p>POSTGRADO EN LA UNIVERSIDAD DE BS. AS. ARGENTINA</p>
                                    <p>POSTGRADO EN LA ASOCIACIÓN MEDICA ARGENTINA (AMA)</p>
                                </div>
                            </div>
                            <div class="doctor">
                                <div class="foto">
                                    <img src="{{ asset('img/d6.jpeg') }}" alt="Foto">
                                </div>
                                <div class="descripcion">
                                    <p><strong>DRA. LISBETH BORJA REYES – DERMATOLOGA</strong></p>
                                    <p><strong>CEL: 74409540</strong></p>
                                    <p>ESPECIALISTA EN DERMATOLOGIA Y ESTÉTICA FACIAL EN LA CIUDAD DE BUENOS AIRES</p>
                                    <p>(RANGO DE ATENCION VARIABLE - 30 MINUTOS APROX.)</p>
                                </div>
                            </div>
                            <div class="doctor">
                                <div class="foto">
                                    <img src="{{ asset('img/d2.jpeg') }}" alt="Foto">
                                </div>
                                <div class="descripcion">
                                    <p><strong>DRA. CARLA JIMENEZ – GINECOLOGA OBSTETRA</strong></p>
                                    <p><strong>CEL: 75763635</strong></p>
                                    <p>MÁS DE 5 AÑOS DE EXPERIENCIA</p>
                                    <p>OBSTETRA, CONTROL PRENATAL Y CONTROL PRE CONCEPCIONAL</p>
                                    <p>TRATAMIENTO DE ENFERMEDADES</p>
                                </div>
                            </div>
                            <div class="doctor">
                                <div class="foto">
                                    <img src="{{ asset('img/d3.jpeg') }}" alt="Foto">
                                </div>
                                <div class="descripcion">
                                    <p><strong>DR. PABLO NAVARRO VASQUEZ – MEDICINA INTERNA</strong></p>
                                    <p><strong>CEL: 70318137</strong></p>
                                    <p>ESPECIALIZADO EN EL HOSPITAL JAIME MENDOZA</p>
                                    <p>POSTGRADO EN MEDICINA INTERNA</p>
                                    <p>(RANGO DE ATENCION VARIABLE - 30 MINUTOS APROX.)</p>
                                </div>
                            </div>
                            <div class="doctor">
                                <div class="foto">
                                    <img src="{{ asset('img/d4.jpeg') }}" alt="Foto">
                                </div>
                                <div class="descripcion">
                                    <p><strong>DRA. HEIDI ALURRALDE SAAVEDRA – CARDIOLOGA/strong></p>
                                    <p><strong>CEL: 77137939</strong></p>
                                    <p>MIEMBRO TITULAR Y PRESIDENTE DE LA SOCIEDAD BOLIVIANA DE CARDIOLOGIA</p>
                                    <p>ESPECIALISTA EN TRATAMIENTO DE ENFERMEDADES CARDIOVASCULARES</p>
                                </div>
                            </div>
                            <div class="doctor">
                                <div class="foto">
                                    <img src="{{ asset('img/d5.jpeg') }}" alt="Foto">
                                </div>
                                <div class="descripcion">
                                    <p><strong>DR. JOSE OROPEZA - PEDIATRA</strong></p>
                                    <p><strong>CEL: 77681445</strong></p>
                                    <p>TERAPISTA INFANTIL</p>
                                    <p>POSTGRADO EN PEDIATRIA UNIVERSIDAD DE SALTA</p>
                                </div>
                            </div>
                        </div>
                        {{-- <img src="{{url('img/portal/Servicios/especialidades.jpeg')}}" alt="" style="width:100%"> --}}
                    </div>

                    {{-- <div class="vc_col-md-12 mi-img-movile" style="margin-top:10px;" >
                    <img src="{{url('img/portal/Servicios/especialidades-480x375.jpg')}}" alt="" style="width:100%">
                </div> --}}



                    <div class="vc_col-md-6" style="margin-top:10px">
                        <img src="{{ url('img/portal/Servicios/dermatologia.jpg') }}" alt="" style="width:100%">
                    </div>

                    <div class="vc_col-md-6" style="margin-top:10px">
                        <img src="{{ url('img/portal/Servicios/cirugano-otorrinolaringologo.jpg') }}" alt=""
                            style="width:100%">
                    </div>

                    <div class="vc_col-md-6" style="margin-top:10px">
                        <img src="{{ url('img/portal/Servicios/ginecologa-obstetra.jpg') }}" alt=""
                            style="width:100%">
                    </div>

                    <div class="vc_col-md-6" style="margin-top:10px">
                        <img src="{{ url('img/portal/Servicios/marcelo-rios.jpg') }}" alt="" style="width:100%">
                    </div>

                    <div class="vc_col-md-6" style="margin-top:10px">
                        <img src="{{ url('img/portal/Servicios/raumatologa.jpg') }}" alt="" style="width:100%">
                    </div>

                    <div class="vc_col-md-6" style="margin-top:10px">
                        <img src="{{ url('img/portal/Servicios/cardiologa-ecografia.jpg') }}" alt=""
                            style="width:100%">
                    </div>

                    <div class="vc_col-md-6" style="margin-top:10px">
                        <img src="{{ url('img/portal/Servicios/cirujano-general-laparaloscopica.jpg') }}" alt=""
                            style="width:100%">
                    </div>

                    <div class="vc_col-md-6" style="margin-top:10px">
                        <img src="{{ url('img/portal/Servicios/pablo-navarro.jpg') }}" alt=""
                            style="width:100%">
                    </div>

                    <div class="vc_col-md-6" style="margin-top:10px">
                        <img src="{{ url('img/portal/Servicios/jorge-sanchez.jpg') }}" alt=""
                            style="width:100%">
                    </div>

                    <div class="vc_col-md-6" style="margin-top:10px">
                        <img src="{{ url('img/portal/Servicios/pediatra-infantil.jpg') }}" alt=""
                            style="width:100%">
                    </div>

                    <div class="vc_col-md-6" style="margin-top:10px">
                        <img src="{{ url('img/portal/Servicios/endocrinologo.jpg') }}" alt=""
                            style="width:100%">
                    </div>

                    <div class="vc_col-md-6" style="margin-top:10px">
                        <img src="{{ url('img/portal/Servicios/jhony-salinas.jpg') }}" alt=""
                            style="width:100%">
                    </div>

                    <div class="clearboth"></div>


                    <div class="clearboth"></div>
                </div>
                <div class="clearboth"></div>

            </div>
        </div>



    </div>
@endsection
