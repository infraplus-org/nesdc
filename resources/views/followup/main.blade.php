@extends('layouts.app')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('Content/Assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('Content/Assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Content/Assets/css/timeline.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Content/Assets/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('Content/Assets/plugins/bootstrap-select/css/bootstrap-select.css') }}">
    <style type="text/css">
        .float-icon-right{
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translate(0, -50%);
        }
        
        .custom-group-item{
            border: initial;
            padding-top: 5px;
            padding-bottom: 5px;
        }
        .activity-child{
            text-align: right;
        }

        /* custom filter table */
        .dataTables_filter { display: none; }
        .dtp-buttons button {
            padding: 2px 10px;
        }

        tr.tr-m-mini th {
            font-size: .8rem;
            padding: 0px 3px;
            font-weight: 400;
            text-align: center;
        }
        /* End custom filter table*/

        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* custom button */
        .btn-upload {
            position: relative;
        }
        .btn-upload input[type="file"]{
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        /* End custom button upload */

        /* custom checkbox */
        .checkbox label{
            line-height: inherit !important;
        }
        .checkbox label::before, .checkbox label::after{
            width: 20px !important;
            height: 20px !important;
        }
        .checkbox label, .radio label{
            padding-left: 25px !important;
        }
        /* end custom checkbox*/

        /* range sidebar */
        .ui-widget-header{
            background: #0ebfd3 !important;
        }
        .slider-range{
            /* width: 95%; */
            width: 100%;
            margin: 0 auto;
        }
        /* .slider-range, */
        .btn-sub-activity {
            display: none !important;
        }
        div.box-inv {
            display: none;
        }
    </style>
@endsection

@section('content')
    <section class="content">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>
                        การติดตามและประเมินผล
                        <small class="text-muted">ระบบบริหารจัดการโครงการพัฒนาโครงสร้างพื้นฐาน</small>
                    </h2>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <ul class="breadcrumb float-md-right">
                        <li class="breadcrumb-item">
                            <a href="#"><i class="zmdi zmdi-home"></i> หน้าหลัก</a>
                        </li>
                        <li class="breadcrumb-item active">การติดตามและประเมินผล</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- end topic  -->

        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <!-- <li class="nav-item"><a class="nav-link {{ preg_match('/followup\/.*\/general/', $uri) ? 'active' : '' }}" data-toggle="tab" href="#tab1">ข้อมูลทั่วไป</a></li> -->
                                <li class="nav-item"><a class="nav-link {{ preg_match('/followup\/.*\/general/', $uri) ? 'active' : '' }}" href="{{ url('followup/' . $project->project_id . '/general') }}">ข้อมูลทั่วไป</a></li>
                                <li class="nav-item"><a class="nav-link {{ preg_match('/followup\/.*\/performance/', $uri) ? 'active' : '' }}" href="{{ url('followup/' . $project->project_id . '/performance') }}">แผนและผลการดำเนินงาน</a></li>
                                <li class="nav-item"><a class="nav-link {{ preg_match('/followup\/.*\/disbursement/', $uri) ? 'active' : '' }}" href="{{ url('followup/' . $project->project_id . '/disbursement/money') }}">แผนและผลการเบิกจ่าย</a></li>
                            </ul>  

                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane {{ preg_match('/followup\/.*\/general/', $uri) ? 'in active' : '' }}" id="tab1">
                                    @if (preg_match('/followup\/.*\/general/', $uri))
                                        @if ($project->status_code == '17005')
                                            @include('followup.general_final')
                                        @else
                                            @include('followup.general')
                                        @endif
                                    @endif
                                </div>
                                <!-- end tab1 -->

                                <div role="tabpanel" class="tab-pane {{ preg_match('/followup\/.*\/performance/', $uri) ? 'in active' : '' }}" id="tab2">
                                    @if (preg_match('/followup\/.*\/performance/', $uri))
                                        @if ( ! empty($project->project_id))
                                            @include('followup.performance')
                                        @else
                                            <div class="col-sm-6 form-control-label text-center" style="margin: 0 auto;">
                                                <div class="alert alert-warning text-center">กรุณาเลือกโครงการ</div>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                                <!-- end tab2 -->

                                <div role="tabpanel" class="tab-pane {{ preg_match('/followup\/.*\/disbursement/', $uri) ? 'in active' : '' }}" id="tab3">
                                    @if (preg_match('/followup\/.*\/disbursement/', $uri))
                                        @include('followup.disbursement')
                                    @endif
                                </div>
                                <!-- end tab3 -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
