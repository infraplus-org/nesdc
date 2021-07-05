@extends('layouts.app')

@section('css')
    <!-- Bootstrap Select Css -->
    <link rel="stylesheet" href="{{ asset('Content/Assets/plugins/bootstrap-select/css/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('Content/Assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Content/Assets/css/modal.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="block-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <h2>
                        บริหารจัดการข้อมูลมาสเตอร์
                        <small class="text-muted">ระบบบริหารจัดการข้อมูลมาสเตอร์</small>
                    </h2>
                </div>
                <div class="col-md-6 col-sm-12">
                    <ul class="breadcrumb float-md-right">
                        <li class="breadcrumb-item">
                            <a href="#"><i class="zmdi zmdi-home"></i> หน้าหลัก</a>
                        </li>
                        <li class="breadcrumb-item active">บริหารจัดการข้อมูลมาสเตอร์</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="body table-responsive">
                            <div class="row clearfix">
                                <!-- <div class="col-sm-3" data-column="1">
                                    <label class="font-weight-bold mb-1 pl-1">ประเภท</label>
                                    <select id="type" name="type" class="form-control show-tick column_filter">
                                        <option value="">-- เลือก ประเภท --</option>
                                        @foreach ($master_type as $type)
                                            <option value="{{ $type->type }}">{{ $type->type }}</option>
                                        @endforeach
                                    </select>
                                </div> -->
                                <div class="col-sm-12">
                                    <button id="btn-add-master" class="btn btn-primary btn-round float-right m-l-10" type="button" data-toggle="modal" data-target="#modal-content" data-id="0">
                                        <i class="zmdi zmdi-plus"></i> เพิ่ม
                                    </button>
                                </div>
                            </div>

                            <table id="list-master" class="table table-hover">
                                <thead>
                                    <tr class="text-center">
                                        <th class="text-nowrap">#</th>
                                        <th class="text-nowrap">ประเภท</th>
                                        <th class="text-nowrap">รหัส</th>
                                        <th class="text-nowrap">รายละเอียด</th>
                                        <th class="text-nowrap">การเปิดใช้งาน</th>
                                        <th class="text-nowrap">ลำดับ</th>
                                        <th class="text-nowrap">จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($masters as $data)
                                        <tr class="text-center">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->type }}</td>
                                            <td>{{ $data->code }}</td>
                                            <td class="text-left">{{ $data->description }}</td>
                                            <td>{{ ($data->actived == 1) ? "เปิด" : "-" }}</td>
                                            <td>{{ $data->ranking }}</td>
                                            <td>
                                                <span class="mr-3" data-toggle="tooltip" data-placement="top" title="แก้ไขข้อมูล">
                                                    <i data-toggle="modal" data-target="#modal-content" class="zmdi zmdi-hc-2x zmdi-settings text-secondary" data-id="{{ $data->id }}"></i>
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
    <script src="{{ asset('Content/Assets/plugins/ol-v6.5.0-dist/ol.js') }}"></script>
@endsection

@section('jsscript')
    <script>
        $(document).ready(function(){
            var tproject = $('#list-master').DataTable({
                bLengthChange: false,
                language: { 
                    loadingRecords: '<h3 class="text-center text-secondary p-3">กำลังโหลด...</h3>', 
                    zeroRecords: '<h3 class="text-center text-muted p-3">ไม่พบข้อมูล</h3>' 
                }    
            });

            // $('[name="type"]').on("keyup change", function () {
            //     tproject.search(this.value).draw();
            // });
        });

        $('[data-toggle="modal"]').on('click', function(){
            $.ajax({
                type: "GET",
                url: "{{ url('master') }}/" + $(this).data('id') + '/update',
                success: function(data){
                    $('#modal-content').html(data);
                    new bootstrap.Modal(document.getElementById('modal-content'));
                },
            });
        });
    </script>
@endsection