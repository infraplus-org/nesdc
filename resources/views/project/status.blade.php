@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('Content/Assets/plugins/morrisjs/morris.css') }}" />
    <!-- Bootstrap Select Css -->
    <link rel="stylesheet" href="{{ asset('Content/Assets/plugins/bootstrap-select/css/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('Content/Assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Content/Assets/css/modal.css') }}">
    <style type="text/css">
        .f-9{
            font-size: .9rem !important;
        }
        .f1{
            font-size: 1rem;
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
                <div class="col-md-6 col-sm-12">
                    <h2>
                        ติดตามสถานะการพิจารณาโครงการ
                        <small class="text-muted">ระบบบริหารจัดการโครงการพัฒนาโครงสร้างพื้นฐาน</small>
                    </h2>
                </div>
                <div class="col-md-6 col-sm-12">
                   
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
                        <li class="breadcrumb-item active">ติดตามสถานะการพิจารณาโครงการ</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-4 mx-0 pr-sm-0">
                    <div class="card info-box-2 l-seagreen h-100">
                        <div class="body my-auto">
                            <div class="content">
                                <h3 class="">โครงการทั้งหมด</h3>
                                <div class="number" style="font-size: 5rem;">{{ $count_all_projects }}</div>
                                <label>โครงการ</label>
                            </div>
                        </div>
                    </div>  
                </div>
                <div class="col-sm-8 pl-sm-0">
                    <div class="card bg-white mb-0">
                        <div class="header">
                            <h2><strong>สถานะ</strong> โครงการ</h2>
                        </div>
                        <div class="body">
                            <canvas id="bar_chart"></canvas>
                        </div>
                    </div>
                </div>
                <!-- end dashborad -->
                
                <div class="col-sm-12">
                    <div class="card widget_2 mb-0 pt-3">
                        <ul class="row clearfix list-unstyled m-b-0 ">
                            @foreach ($projects_by_department as $data)
                                <li class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="body">
                                        <div class="row no-gutters">
                                            <div class="col-9">
                                                <h5 class="m-t-0 f1">{{ $data->department }}</h5>
                                            </div>
                                            <div class="col-3 text-right">
                                                <h2 class="">{{ $data->cnt }}</h2>
                                            </div>
                                            <div class="col-7">
                                                <div class="progress m-t-10">
                                                    <div class="progress-bar l-green" role="progressbar" style="width: {{ ($data->cnt * 100)/$count_all_projects }}%;"></div>
                                                </div>
                                            </div>
                                            <div class="col-5 text-right">
                                                <small class="info">โครงการ</small>
                                            </div>
                                            <div class="col-sm-12">
                                                <canvas id="bar_chart_{{ $loop->iteration }}" class="mt-5" data-value="[{{ $data->type_1 }}, {{ $data->type_2 }}, {{ $data->type_3 }}]"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="col-lg-12 mt-3">
                    <div class="card">
                        <div class="header">
                            <h2><strong>แจ้งเตือน</strong> โครงการ</h2>
                        </div>
                        <div class="body pt-0">
                            <ul class="row profile_state list-unstyled">
                                @foreach ($projects_warning as $data)
                                    <li class="col-lg-3 col-md-3 col-6">
                                        <div class="body">
                                            <h4>{{ number_format($data->cnt) }}</h4>
                                            <span>{{ $data->department }}</span>
                                        </div>
                                    </li>
                                @endforeach         
                            </ul>        
                        </div>
                    </div>
                </div>
                <!-- end แจ้งเตือนโครงการ -->
                
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>ติดตาม </strong>ดำเนินงาน</h2>
                        </div>
                        <div class="body table-responsive">
                            <div class="row clearfix">
                                <div class="col-sm-3" data-column="1">
                                    <label class="font-weight-bold mb-1 pl-1">ผู้รับผิดชอบ</label>
                                    <select id="col1_filter" class="form-control show-tick column_filter" name="ministry">
                                        <option value="">-- เลือกผู้รับผิดชอบ --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->fullname }}">{{ $user->fullname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-3"data-column="2">
                                    <label class="font-weight-bold mb-1 pl-1">ฝ่ายงาน</label>
                                    <select id="col2_filter" class="form-control show-tick column_filter" name="division">
                                        <option value="">-- เลือกฝ่ายงาน --</option>
                                        @foreach ($departments_contact as $department)
                                            <option value="{{ $department->description }}">{{ $department->description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!--mainTable-->
                            <table id="list-project" class="table table-hover">
                                <thead>
                                    <tr class="text-center">
                                        <th class="text-nowrap">#</th>
                                        <th class="text-nowrap">ผู้รับผิดชอบ</th>
                                        <th class="text-nowrap">ฝ่ายงาน</th>
                                        <th class="text-nowrap">โครงการทั้งหมด</th>
                                        <th class="text-nowrap">โครงการใหม่</th>
                                        <th class="text-nowrap">วิเคราะห์โครงการ</th>
                                        <th class="text-nowrap">เห็นชอบและลงนาม</th>
                                        <th class="text-nowrap">ครม.อนุมัติ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($projects_by_contact as $data)
                                        <tr class="text-center" data-toggle="modal" data-target="#modal-content" data-id="{{ $data->id }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->fullname }}</td>
                                            <td>{{ $data->department_desc }}</td>
                                            <td>{{ $data->cnt_all }}</td>
                                            <td>{{ $data->{'โครงการใหม่'} }}</td>
                                            <td>{{ $data->{'วิเคราะห์โครงการ'} }}</td>
                                            <td>{{ $data->{'เห็นชอบและลงนาม'} }}</td>
                                            <td>{{ $data->{'ครม.อนุมัติโครงการ'} }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- end ติดตามดำเนินงาน -->
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
    <script src="{{ asset('Content/Assets/plugins/chartjs/Chart.bundle.js') }}"></script> <!-- Chart Plugins Js --> 
    <script src="{{ asset('Content/Assets/plugins/chartjs/polar_area_chart.js') }}"></script><!-- Polar Area Chart Js --> 
    <script src="{{ asset('Content/Assets/bundles/knob.bundle.js') }}"></script>
@endsection

@section('jsscript')
    <script>
        $(document).ready(function(){
            var tproject = $('#list-project').DataTable({
                bLengthChange: false,
                rowCallback: function (row,data) {
                    $('td', row).click(function (e) {
                        const anchor = data[0];
                        // $('#follow-status-project').modal('show');
                        $.ajax({
                            type: "GET",
                            url: "{{ url('project/user') }}/" + $(this).parent('tr').attr('data-id'),
                            success: function(data){
                                $('#modal-content').html(data);
                                new bootstrap.Modal(document.getElementById('modal-content'));
                            },
                        });
                    });
                },
                language: { 
                    loadingRecords: '<h3 class="text-center text-secondary p-3">กำลังโหลด...</h3>', 
                    zeroRecords: '<h3 class="text-center text-muted p-3">ไม่พบข้อมูล</h3>' 
                }    
            });
            $(".column_filter").on("change click", function () {
                filterColumn($(this).parents("div").attr("data-column"));
            });
            filterColumn = function (i) {
                tproject
                    .column(i)
                    .search($("#col" + i + "_filter option:selected").val())
                    .draw();
            };

            // Chart
            $(function () {
                new Chart(document.getElementById("bar_chart").getContext("2d"), getChartJs('horizontalBar'));
                new Chart(document.getElementById("bar_chart_1").getContext("2d"), getChartJsStatus("bar_chart_1"));  
                new Chart(document.getElementById("bar_chart_2").getContext("2d"), getChartJsStatus("bar_chart_2"));  
                new Chart(document.getElementById("bar_chart_3").getContext("2d"), getChartJsStatus("bar_chart_3"));  
                new Chart(document.getElementById("bar_chart_4").getContext("2d"), getChartJsStatus("bar_chart_4"));   
            });
            
            function getChartJs(type) {
                var config = null;
                
                if(type == "horizontalBar"){
                    config = {
                        type: "horizontalBar",
                        data: {
                            labels: [
                                @foreach ($projects_by_status as $data)
                                    "{{ $data->status_desc }}",
                                @endforeach
                            ],
                            datasets: [{
                                label: "สถานะโครงการ",
                                data: [
                                    @foreach ($projects_by_status as $data)
                                        {{ $data->cnt }},
                                    @endforeach
                                ],
                                backgroundColor: '#8ddce6',
                                strokeColor: "#8ddce6",
                            }]
                        },
                        options: {
                            responsive: true,
                            legend: false,
                            scales: {
                                yAxes: [{
                                    barPercentage: 0.4,
                                    ticks: {
                                        fontSize: 16
                                    }
                                }],
                            }
                        }
                    }  
                }
                
                return config;
            }
            
            function getChartJsStatus(id){
                var config = {
                    type: "bar",
                    data: {
                        labels: [["ขออนุมัติ","โครงการ"], ["ขอความ","เห็นประกอบการ","พิจารณาของ","ครม./หน่วยงาน"], ["ขอความเห็น","ของแผน","ระดับที่3"]],
                        datasets: [{
                            data: $('#' + id).data('value'),
                            backgroundColor: '#8ddce6',
                            strokeColor: "#8ddce6",
                        }]
                    },
                    options: {
                        responsive: true,
                        legend: false,
                        barValueSpacing : 10,        // doesn't work; find another way
                        barDatasetSpacing : 10, 
                        scales: {
                            yAxes: [{
                                gridLines: {
                                    display:false
                                },
                                ticks: {
                                    display: false
                                }
                            }],
                            xAxes: [{
                                categoryPercentage: 1,
                                gridLines: {
                                    display:false
                                },
                                ticks: {
                                    autoSkip: false,
                                    maxRotation: 0,
                                    fontSize: 8
                                }
                            }]
                        }
                    }
                }
                return config;
            }
        });
    </script>
@endsection


