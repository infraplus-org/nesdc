@extends('layouts.app')

@section('css')
    <!-- Bootstrap Select Css -->
    <link href="{{ asset('Content/Assets/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('Content/Assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">

    <!-- Bootstrap Material Datetime Picker Css -->
    <link href="{{ asset('Content/Assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('Content/Assets/css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('Content/Assets/css/timeline.min.css') }}">
    
    <style type="text/css">
        .f-9{
            font-size: .9rem !important;
        }
        .display-6{
            font-size: 1rem !important;
        }
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
        #map,
        #map-edit{
            width: 100%;
            height: 300px;
        }
        .custom-group-item{
            border: initial;
            padding-top: 5px;
            padding-bottom: 5px;
        }
        .activity-child{
            text-align: right;
        }

        /*custom width*/
        .w-px-100{
            width: 100px;
        }
    </style>
@endsection

@section('content')
    <section class="content">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>
                        บริหารจัดการโครงการ
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
                        <li class="breadcrumb-item active">บริหารจัดการโครงการ</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>ตัวกรอง</strong> โครงการ</h2>
                        </div>
                        <div class="body">
                            <form method="POST" action="{{ url('project/manage') }}">
                            @csrf
                            <div class="row mb-2">
                                <div class="col-sm-3">
                                    <label class="font-weight-bold">เลขทะเบียนรับ</label>
                                    <div class="d-flex">
                                        <input type="text" class="f-9 form-control border-secondary" name="registration_number" placeholder="เลขทะเบียนรับ" value="{{ Request::get('registration_number') }}">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <label class="font-weight-bold">วัน/เดือน/ปีที่รับ</label>
                                    <div class="d-flex position-relative">
                                        <input type="text" class="f-9 form-control border-secondary datetimepicker" name="book_issued_at" placeholder="วันที่ส่งหนังสือ" value="{{ Request::get('book_issued_at') }}">
                                        <span class="float-icon-right"><i class="zmdi zmdi-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <label class="font-weight-bold">เลขที่หนังสือ</label>
                                    <div class="d-flex">
                                        <input type="text" class="f-9 form-control border-secondary " name="book_number" placeholder="เลขที่หนังสือ" value="{{ Request::get('book_number') }}">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <label class="font-weight-bold mb-1 pl-1">ประเภทโครงการ</label>
                                    <select class="form-control show-tick" name="type_code">
                                        <option value="">-- เลือก ประเภทโครงการ --</option>
                                        @foreach ($project_types as $type)
                                            <option value="{{ $type->code }}" {{ Request::get('type_code') == $type->code ? 'selected' : '' }}>{{ $type->description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <label class="font-weight-bold">เรื่อง</label>
                                    <div class="d-flex">
                                        <input type="text" class="f-9 form-control border-secondary" name="description" placeholder="เรื่อง" value="{{ Request::get('description') }}">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label class="font-weight-bold">ผู้รับผิดชอบ</label>
                                    <div class="d-flex">
                                        <input type="text" class="f-9 form-control border-secondary" name="contact" placeholder="ผู้รับผิดชอบ" value="{{ Request::get('contact') }}">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label class="font-weight-bold mb-1 pl-1">สถานะโครงการ</label>
                                    <select class="form-control show-tick" name="status_code">
                                        <option value="">-- เลือก สถานะโครงการ --</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->code }}" {{ Request::get('status_code') == $status->code ? 'selected' : '' }}>{{ $status->description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-12 text-right">
                                    <button class="btn btn-primary btn-round"><i class="zmdi zmdi-search"></i> ค้นหา</button>
                                </div>
                            </div>
                            </form>            
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>ผลการค้นหา </strong><span id="result-search">{{ count($projects) }}</span> โครงการ</h2>
                        </div>
                        <div class="body table-responsive">
                            <!--mainTable-->
                            <table id="list-project" class="table table-hover">
                                <thead>
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th class="text-nowrap">ประเภทโครงการ</th>
                                        <th class="text-nowrap">วัน/เดือน/ปีที่รับ</th>
                                        <th class="text-nowrap">เลขที่หนังสือ</th>
                                        <th class="text-nowrap">หน่วยงาน</th>
                                        <th class="text-nowrap">เรื่อง</th>
                                        <th class="text-nowrap">ผู้รับผิดชอบ</th>
                                        <th class="text-nowrap">สถานะ</th>
                                        <th class="text-nowrap">การจัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($projects as $project)
                                        <tr class="text-center">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $project->type_desc }}</td>
                                            <td>{{ date(config('custom.format_datetime'), strtotime($project->book_issued_at)) }}</td>
                                            <td>{{ $project->book_number }}</td>
                                            <td>{{ $project->department_desc }}</td>
                                            <td style="min-width: 180px;">{{ $project->description }}</td>
                                            <td>{{ $project->fname . ' ' . $project->lname }}</td>
                                            <td class="text-nowrap">
                                                @if ($project->status_code == '17001')
                                                <i data-toggle="tooltip" data-placement="top" title="{{ $project->status_desc }}" class="zmdi zmdi-hc-2x zmdi-file-text text-secondary mr-3 text-primary"></i>
                                                @elseif ($project->status_code == '17002')
                                                <i data-toggle="tooltip" data-placement="top" title="{{ $project->status_desc }}" class="zmdi zmdi-hc-2x zmdi-file-text text-secondary mr-3 text-warning"></i>
                                                @elseif ($project->status_code == '17003')
                                                <i data-toggle="tooltip" data-placement="top" title="{{ $project->status_desc }}" class="zmdi zmdi-hc-2x zmdi-file-text text-secondary mr-3 text-success"></i>
                                                @elseif ($project->status_code == '17005')
                                                <i data-toggle="tooltip" data-placement="top" title="{{ $project->status_desc }}" class="zmdi zmdi-hc-2x zmdi-file-text text-secondary mr-3 text-info"></i>
                                                @else
                                                <i data-toggle="tooltip" data-placement="top" title="{{ $project->status_desc }}" class="zmdi zmdi-hc-2x zmdi-file-text text-secondary mr-3"></i>
                                                @endif
                                            </td>
                                            <td class="text-nowrap">
                                                <a href="{{ url('project/' . $project->project_id . '/detail/') }}">
                                                    <i data-toggle="tooltip" data-placement="top" title="ข้อมูลโครงการ" class="zmdi zmdi-hc-2x zmdi-file-text text-secondary mr-3"></i>
                                                </a>
                                                <a href="{{ url('project/' . $project->project_id . '/edit') }}">
                                                    <i data-toggle="tooltip" data-placement="top" title="แก้ไขรายละเอียด" class="zmdi zmdi-hc-2x zmdi-border-color text-secondary mr-3"></i>
                                                </a>
                                                <span data-toggle="tooltip" data-placement="top" title="บริหารจัดการสถานะการพิจารณาโครงการ">
                                                    <i data-toggle="modal" data-target="#modal-content-fullscreen-xl"  class="zmdi zmdi-hc-2x zmdi-settings text-secondary" data-id="{{ $project->project_id }}"></i>
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="{{ asset('Content/Assets/bundles/datatablescripts.bundle.js') }}"></script>
    <script src="{{ asset('Content/Assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('Content/Assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('Content/Assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('Content/Assets/plugins/jquery-datatable/buttons/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('Content/Assets/plugins/jquery-datatable/buttons/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('Content/Assets/plugins/jquery-datatable/buttons/buttons.print.min.js') }}"></script>
    <script src="{{ asset('Content/Assets/js/pages/tables/jquery-datatable.js') }}"></script>
    <script src="{{ asset('Content/Assets/plugins/momentjs/moment.js') }}"></script> <!-- Moment Plugin Js --> 
    <!-- Bootstrap Material Datetime Picker Plugin Js --> 
    <script src="{{ asset('Content/Assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script> 
    <!-- Bootstrap Material Datetime Picker Plugin Language Js --> 
    <script src="{{ asset('Content/Assets/plugins/bootstrap-material-datetimepicker/js/th.min.js') }}"></script>
@endsection

@section('jsscript')
    <script>
        $(function () {
            //Datetimepicker plugin
            var m = moment();
            $('.datetimepicker').bootstrapMaterialDatePicker({
                format: 'YYYY-MM-DD HH:mm',
                clearButton: false,
                minDate: moment(),
                weekStart: 0,
                lang: 'th',
                okText: 'ตกลง',
                cancelText: 'ยกเลิก'
            });
            $('[data-toggle="tooltip"]').tooltip();
        });

        $(document).ready(function(){
            var tproject = $('#list-project').DataTable({
                bLengthChange: false,
                language: { 
                    loadingRecords: '<h3 class="text-center text-secondary p-3">กำลังโหลด...</h3>', 
                    zeroRecords: '<h3 class="text-center text-muted p-3">ไม่พบข้อมูล</h3>' 
                }    
            });
        });
        
        $('[data-toggle="modal"]').on('click', function() {
            $.ajax({
                type: "GET",
                url: "{{ url('project') }}/" + $(this).attr('data-id') + "/update",
                success: function(data){
                    $('#modal-content-fullscreen-xl').html(data);
                    new bootstrap.Modal(document.getElementById('modal-content-fullscreen-xl'));
                },
            });
        });
    </script>
@endsection
