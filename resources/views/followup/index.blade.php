@extends('layouts.app')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('Content/Assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('Content/Assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Content/Assets/css/timeline.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Content/Assets/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('Content/Assets/css/modal.css') }}">
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
                        <div class="header">
                            <h2><strong>ผลการค้นหา </strong><span id="result-search">{{ number_format($cnt_projects) }}</span> โครงการ</h2>
                        </div>
                        <div class="body table-responsive">
                            <table id="list-project" class="table table-hover table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th class="text-nowrap sorting_disabled">ลำดับ</th>
                                        <th class="text-nowrap">ชื่อโครงการ</th>
                                        <th class="text-nowrap">สถานะโครงการ</th>
                                        <th class="text-nowrap">เอกสาร</th>
                                        <th class="text-nowrap">การจัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach ($projects as $project)
                                        <tr class="text-center" data-id="{{ $project->project_id }}">
                                            <td>{{ $no++ }}</td>
                                            <td class="text-left">{{ $project->description }}</td>
                                            <td>{{ $project->status_desc }}</td>
                                            <td>
                                                <i id="modal-timeline" class="zmdi zmdi-file btn btn-link btn-link-custom" data-toggle="modal" data-target="#modal-content"></i>
                                                <!-- <i id="modal-document-add" class="zmdi zmdi-file-plus btn btn-link btn-link-custom" data-toggle="modal" data-target="#modal-content-fullscreen-xl"></i> -->
                                                @canany(['isAdmin'])
                                                <a href="#"><i class="zmdi zmdi-file-plus btn btn-link btn-link-custom"></i></a>
                                                @endcanany
                                            </td>
                                            <td>
                                                <i id="modal-info" class="zmdi zmdi-assignment btn btn-link btn-link-custom" data-toggle="modal" data-target="#modal-content-fullscreen-xl"></i>
                                                <div class="btn-group" role="group">
                                                    <button id="btnGroupFollowup" type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <a href="#" class="btn btn-link btn-link-custom"><i class="zmdi zmdi-chart"></i></a>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroupFollowup">
                                                        <a class="dropdown-item" href="{{ url('followup/' . $project->project_id . '/general') }}">ข้อมูลโครงการ</a>
                                                        <a class="dropdown-item" href="{{ url('followup/' . $project->project_id . '/performance') }}">แผนและผลดำเนินงาน</a>
                                                        <a class="dropdown-item" href="{{ url('followup/' . $project->project_id . '/disbursement') }}">แผนและผลการเบิกจ่าย</a>
                                                    </div>
                                                </div>
                                                <a href="#" class="btn btn-link btn-link-custom"><i class="zmdi zmdi-eye-off"></i></a>
                                            </td>
                                        </tr>
                                        @foreach ($project->children as $child)
                                            <tr class="text-center" data-id="{{ $project->project_id }}">
                                                <td></td>
                                                <td class="text-left"><label class="offset-md-1">&#9679;&nbsp;&nbsp;&nbsp;{{ $child->description }}</label></td>
                                                <td>{{ $child->status_desc }}</td>
                                                <td>
                                                    <i id="modal-timeline" class="zmdi zmdi-file btn btn-link btn-link-custom" data-toggle="modal" data-target="#modal-content"></i>
                                                    <!-- <i id="modal-document-add" class="zmdi zmdi-file-plus btn btn-link btn-link-custom" data-toggle="modal" data-target="#modal-content-fullscreen-xl"></i> -->
                                                    @canany(['isAdmin'])
                                                    <a href="#"><i class="zmdi zmdi-file-plus btn btn-link btn-link-custom"></i></a>
                                                    @endcanany
                                                </td>
                                                <td>
                                                    <i id="modal-info" class="zmdi zmdi-assignment btn btn-link btn-link-custom" data-toggle="modal" data-target="#modal-content-fullscreen-xl"></i>
                                                    <div class="btn-group" role="group">
                                                        <button id="btnGroupFollowup" type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <a href="#" class="btn btn-link btn-link-custom"><i class="zmdi zmdi-chart"></i></a>
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="btnGroupFollowup">
                                                            <a class="dropdown-item" href="{{ url('followup/' . $child->project_id . '/general') }}">ข้อมูลโครงการ</a>
                                                            <a class="dropdown-item" href="{{ url('followup/' . $child->project_id . '/performance') }}">แผนและผลดำเนินงาน</a>
                                                            <a class="dropdown-item" href="{{ url('followup/' . $child->project_id . '/disbursement') }}">แผนและผลการเบิกจ่าย</a>
                                                        </div>
                                                    </div>
                                                    <a href="#" class="btn btn-link btn-link-custom"><i class="zmdi zmdi-eye-off"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
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
    <!-- <script src="{{ asset('Content/Assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('Content/Assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('Content/Assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('Content/Assets/plugins/jquery-datatable/buttons/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('Content/Assets/plugins/jquery-datatable/buttons/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('Content/Assets/plugins/jquery-datatable/buttons/buttons.print.min.js') }}"></script> -->
    <!-- <script src="{{ asset('Content/Assets/js/pages/tables/jquery-datatable.js') }}"></script> -->
    <!-- <script src="{{ asset('Content/Assets/plugins/ol-v6.5.0-dist/ol.js') }}"></script> -->
@endsection


@section('jsscript')
    <script>
        $(document).ready(function(){
            var tproject = $('#list-project').DataTable({
                bLengthChange: false,
                //bFilter: false,
                ordering: false,
                language: { 
                    loadingRecords: '<h3 class="text-center text-secondary p-3">กำลังโหลด...</h3>', 
                    zeroRecords: '<h3 class="text-center text-muted p-3">ไม่พบข้อมูล</h3>' 
                },
                columnDefs: [
                    { targets: 0, searchable: false  },
                    { targets: 3, searchable: false  },
                    { targets: 4, searchable: false  }
                ]
            });

            // กดปุ่มดู timeline
            $(document).on('click', '#modal-timeline', function() {
                $.ajax({
                    type: "GET",
                    url: "{{ url('followup') }}/" + $(this).closest('tr').data('id') + "/timeline",
                    success: function(data){
                        $('#modal-content').html(data);
                        new bootstrap.Modal(document.getElementById('modal-content'));
                    },
                });
            });

            // กดปุ่มเพิ่มเอกสาร
            $(document).on('click', '#modal-document-add', function() {
                $.ajax({
                    type: "GET",
                    url: "{{ url('followup') }}/" + $(this).closest('tr').data('id') + "/document",
                    success: function(data){
                        $('#modal-content-fullscreen-xl').html(data);
                        new bootstrap.Modal(document.getElementById('modal-content-fullscreen-xl'));
                    },
                });
            });

            // กดปุ่มดูข้อมูลโครงการ
            $(document).on('click', '#modal-info', function() {
                var target = $(this).data('target');
                $.ajax({
                    type: "GET",
                    url: "{{ url('followup') }}/" + $(this).closest('tr').data('id') + "/info",
                    success: function(data){
                        $('#modal-content-fullscreen-xl').html(data);
                        new bootstrap.Modal(document.getElementById('modal-content-fullscreen-xl'));
                    },
                });
            });
        });
    </script>
@endsection
