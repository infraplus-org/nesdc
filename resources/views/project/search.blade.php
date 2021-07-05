@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('Content/Assets/plugins/morrisjs/morris.css') }}" />
    <!-- Bootstrap Select Css -->
    <link rel="stylesheet" href="{{ asset('Content/Assets/plugins/bootstrap-select/css/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('Content/Assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Content/Assets/css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('Content/Assets/plugins/ol-v6.5.0-dist/ol.css') }}">
    <style type="text/css">
        .f-9{
            font-size: .9rem !important;
        }
        .display-6{
            font-size: 1rem !important;
        }
        #map{
            width: 100%;
            height: 300px;
        }
        .dataTables_filter { display: none; }
    </style>
@endsection

@section('content')
    <section class="content">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>
                        ค้นหาโครงการ
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
                        <li class="breadcrumb-item active">ค้นหาโครงการ</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>ตัวกรอก</strong> โครงการ</h2>
                        </div>
                        <div class="body">
                            <form method="POST" action="{{ url('project/search') }}">
                            @csrf
                            <div class="row mb-2">
                                <div class="col-sm-3">
                                    <label class="font-weight-bold mb-1 pl-1">ปีงบประมาณ</label>
                                    <select class="form-control show-tick" name="year">
                                        <option value="">-- Please select --</option>
                                        @php $year = date('Y') + 546 @endphp
                                        @for ($i=2557; $i<=$year; $i++)
                                            <option value="{{ $i }}"  {{ Request::get('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-sm-9">
                                    <label class="font-weight-bold">ชื่อโครงการ</label>
                                    <div class="d-flex">
                                        <input type="text" class="f-9 form-control border-secondary" name="nameproject" placeholder="ชื่อโครงการ" value="{{ Request::get('nameproject') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-3">
                                    <label class="font-weight-bold mb-1 pl-1">กระทรวง</label>
                                    <select class="form-control show-tick" name="ministry_code">
                                        <option value="">-- Please select --</option>
                                        @foreach ($ministrys as $ministry)
                                            <option value="{{ $ministry->code }}" {{ Request::get('ministry_code') == $ministry->code ? 'selected' : '' }}>{{ $ministry->description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label class="font-weight-bold mb-1 pl-1">หน่วยงาน</label>
                                    <select class="form-control show-tick" name="department_code">
                                        <option value="">-- Please select --</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->code }}" {{ Request::get('department_code') == $department->code ? 'selected' : '' }}>{{ $department->description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label class="font-weight-bold mb-1 pl-1">สาขาการลงทุน</label>
                                    <select class="form-control show-tick" name="investment_code">
                                        <option value="">-- Please select --</option>
                                        @foreach ($investments as $investment)
                                            <option value="{{ $investment->code }}" {{ Request::get('investment_code') == $investment->code ? 'selected' : '' }}>{{ $investment->description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label class="font-weight-bold mb-1 pl-1">พื้นที่ (จังหวัด)</label>
                                    <select class="form-control show-tick" name="area">
                                        <option value="">-- Please select --</option>
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province->description }}" {{ Request::get('area') == $province->description ? 'selected' : '' }}>{{ $province->description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-12 text-right">
                                    <button class="btn btn-primary btn-round"><i class="zmdi zmdi-search"></i> ค้นหา</button>
                                </div>
                            </div>               
                        </div>
                        </form>
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
                                        <th class="text-nowrap">#</th>
                                        <th class="text-nowrap">สาขาการลงทุน</th>
                                        <th class="text-nowrap">หน่วยงาน</th>
                                        <th class="text-nowrap">ชื่อโครงการ</th>
                                        <th class="text-nowrap">วงเงินลงทุน</th>
                                        <th class="text-nowrap">ช่วงปี</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($projects as $project)
                                        <tr class="text-center" data-toggle="modal" data-target="#modal-content-fullscreen-xl" data-id="{{ $project->project_id }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $project->investment_desc }}</td>
                                            <td>{{ $project->department_desc }}</td>
                                            <td>{{ $project->description }}</td>
                                            <td class="text-right">{{ ($project->budget != '') ? $project->budget . ' ลบ.' : '' }}</td>
                                            <td>{{ ($project->plan_begin_year != '' && $project->plan_end_year != '') ? $project->plan_begin_year . '-' . $project->plan_end_year : $project->plan_begin_year . $project->plan_end_year }}</td>
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
    <script src="{{ asset('Content/Assets/plugins/ol-v6.5.0-dist/ol.js') }}"></script>
@endsection

@section('jsscript')
    <script>
        $(document).ready(function(){
            var tproject = $('#list-project').DataTable({
                bLengthChange: false,
                rowCallback: function (row,data) {
                    $('td', row).click(function (e) {
                        $.ajax({
                            type: "GET",
                            url: "{{ url('project') }}/" + $(this).parent('tr').attr('data-id') + "/info",
                            success: function(data){
                                $('#modal-content-fullscreen-xl').html(data);
                                new bootstrap.Modal(document.getElementById('modal-content-fullscreen-xl'));
                            },
                        });

                        const anchor = data[0];
                        $('#view-project').modal('show');
                        setTimeout(function(){
                            reloadMap(); 
                        },500);
                    });
                },
                language: { 
                    loadingRecords: '<h3 class="text-center text-secondary p-3">กำลังโหลด...</h3>', 
                    zeroRecords: '<h3 class="text-center text-muted p-3">ไม่พบข้อมูล</h3>' 
                }    
            });
           
            $('[name="nameproject"]').on("keyup change", function () {
                tproject.search(this.value).draw();
            });
        });
    </script>
@endsection


