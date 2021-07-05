@extends('layouts.app')

@section('css')
    <!-- Bootstrap Select Css -->
    <link rel="stylesheet" href="{{ asset('Content/Assets/plugins/bootstrap-select/css/bootstrap-select.css') }}">
    <link rel="stylesheet" href="{{ asset('Content/Assets/plugins/ol-v6.5.0-dist/ol.css') }}">
    <link rel="stylesheet" href="{{ asset('Content/Assets/css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('Content/Assets/css/timeline.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Content/Assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('Content/Assets/css/jquery-ui.css') }}">
    <style type="text/css">
        .float-icon-right{
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translate(0, -50%);
        }
        .dataTables_filter { display: none; }
        .dtp-buttons button {
            padding: 2px 10px;
        }
        .custom-group-item{
            border: initial;
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .access-theme  a.border-bottom-warning.nav-link{
            border-radius: initial !important;
            border: initial;
        }
        .access-theme  a.border-bottom-warning.nav-link.active,
        .access-theme  a.border-bottom-warning.nav-link:hover {
            border-bottom: 1px solid #FFB236 !important;
            border-top: 0 !important;
            border-left: 0 !important;
            border-right: 0 !important;
            border-radius: 0 !important;
        }
        .table.table-align-center td, .table.table-aligne-center {
            vertical-align: middle;
        }
        .table#activity input[type="number"] {
            text-align: right;
        }
    </style>
@endsection

@section('content')
    <section class="content access-theme">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>
                        แก้ไขรายละเอียด: ข้อเสนอเพื่อพิจารณา
                        <small class="text-muted">ระบบบริหารจัดการโครงการพัฒนาโครงสร้างพื้นฐาน</small>
                    </h2>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <ul class="breadcrumb float-md-right">
                        <li class="breadcrumb-item">
                            <a href="#"><i class="zmdi zmdi-home"></i> หน้าหลัก</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">โครงการ</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">พิจารณาโครงการ</a>
                        </li>
                        <li class="breadcrumb-item active">แก้ไขรายละเอียด</li>
                    </ul>
                </div>
            </div>
        </div>  
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="body"> 
                            <div class="header">
                                <h2><strong>รายละเอียดโครงการ </strong></h2>
                            </div>
                            <div class="body table-responsive">
                                <div class="display-6">
                                    <div class="row clearfix">
                                        <div class="col-sm-12 form-row">
                                            <div class="col-sm-3 form-control-label text-sm-right align-self-center">
                                                <label class="font-weight-bold">เรื่อง / ดำเนินการ</label>
                                            </div>
                                            <div class="col-sm-7">
                                                <div class="form-group">
                                                    <input type="text" name="project_desc" class="form-control border-secondary" placeholder="เรื่อง / ดำเนินการ" value="{{ $project->description }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 form-row">
                                            <div class="col-sm-3 form-control-label text-sm-right align-self-center">
                                                <label class="font-weight-bold">หน่วยงาน</label>
                                            </div>
                                            <div class="col-sm-7">
                                                <div class="form-group">
                                                    <input type="text" name="department_desc" class="form-control border-secondary" placeholder="หน่วยงาน" value="{{ $project->department_desc }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab1">ข้อเสนอเพื่อพิจารณา</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab2">ความเป็นมา</a></li>
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tab3">สาระสำคัญของโครงการ</a></li>
                                <!-- <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab4">ความสอดคล้องกับนโยบายและแผน</a></li> -->
                                @if ($project->department_code == '12027')
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab5">โครงการย่อย</a></li>
                                @endif
                            </ul>

                            <!-- Tab panes -->
                            <form method="POST" action="{{ url('project/' . $project->project_id . '/editing') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="project_id" value="{{ $project->project_id }}">
                            <div class="tab-content">
                                
                                <div role="tabpanel" class="tab-pane" id="tab1">
                                    @include('project.edit_proposal')
                                </div>
                                <!-- end tab1 -->

                                <div role="tabpanel" class="tab-pane" id="tab2">
                                    @include('project.edit_story')
                                </div>
                                <!-- end tab2 -->

                                <div role="tabpanel" class="tab-pane in active" id="tab3">
                                    @include('project.edit_essence')
                                </div>
                                <!-- end tab3 -->
                                
                                <!-- 
                                <div role="tabpanel" class="tab-pane" id="tab4"> <b>รอสรุป</b>
                                </div> 
                                -->
                                <!-- end tab4 -->

                                <div role="tabpanel" class="tab-pane" id="tab5">
                                    @include('project.edit_project')
                                </div>
                                <!-- end tab5 -->
                            </div>
                            <div class="col-sm-12 pr-4 text-right">
                                <button type="submit" class="btn btn-primary btn-round"><i class="zmdi zmdi-save"></i> บันทึก</button>
                            </div>    
                            </form>
                        </div>
                    </div>
                    <!-- end tab -->
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="{{ asset('Content/Assets/plugins/ol-v6.5.0-dist/ol.js') }}"></script>
    <script src="{{ asset('Content/Assets/plugins/momentjs/moment.js') }}"></script>
    <script src="{{ asset('Content/Assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script> 
    <script src="{{ asset('Content/Assets/plugins/bootstrap-material-datetimepicker/js/th.min.js') }}"></script>
    <script src="{{ asset('Content/Assets/js/jquery-ui.js') }}"></script>
@endsection
