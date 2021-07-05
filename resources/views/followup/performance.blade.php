@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('Content/Assets/plugins/morrisjs/morris.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('Content/Assets/css/color_skins.css') }}" />
    <link rel="stylesheet" href="{{ asset('Content/Assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
@endsection 

<form method="POST" action="{{ url('followup/' . $project->project_id . '/performance/save') }}">
@csrf
<input type="hidden" name="project_id" value="{{ $project->project_id }}">
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="body">
                <div class="row">
                    <div class="col-sm-12">
                        <p class="h5">{{ $project->description }}</p>
                    </div>
                </div>
                <div class="row">
                    <label for="operating_duration" class="col-sm-3 col-form-label"><strong>ระยะเวลาดำเนินการ (ตาม มติ ครม.)</strong></label>
                    <div class="col-sm-9 col-form-label">
                        <label>
                            {{ ! empty($expansion)
                                ? $expansion->begin_date . ' - ' . $expansion->end_date 
                                : (($project->plan_begin_day != '') ? $project->plan_begin_day . ' ' : '') . 
                                        (($project->plan_begin_month != '') ? getFullMonthThai($project->plan_begin_month) . ' ' : '') . 
                                        $project->plan_begin_year . ' - ' .
                                    (($project->plan_end_day != '') ? $project->plan_end_day . ' ' : '') . 
                                        (($project->plan_end_month != '') ? getFullMonthThai($project->plan_end_month) . ' ' : '') . 
                                        $project->plan_end_year }}
                        </label>
                    </div>
                </div>
                <div class="row">
                    <!-- <div class="col-md-8 offset-md-2 col-sm-10 offset-sm-1 col-xs-12"> -->
                    <div class="col-md-10 offset-md-1">
                        <div class="card border border-info">
                            <div class="body">
                                <div id="chart-performance" class="graph"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="table-responsive">
                        <table id="performance" class="table table-sm table-bordered">
                            <thead class="table-dark">
                                <tr class="text-center">
                                    <th class="align-middle w-px-420">ปีงบประมาณ</th>
                                    @for ($i=$actual_begin_year; $i<=$actual_end_year; $i++)
                                        <th><a>{{ $i }}</a></th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr class="tr-budget" data-content="budget">
                                    <td class="text-nowrap text-left">แผนตั้งต้น (ร้อยละ)</td>
                                    @if ( ! empty($performances))
                                        @foreach ($performances as $performance)
                                            <td data-period="{{ $performance->period }}">{{ number_format($performance->budget, 2) }}</td>
                                        @endforeach
                                    @else
                                        @for ($i=$actual_begin_year; $i<=$actual_end_year; $i++) 
                                            <td data-period="{{ $i }}">{{ number_format(0, 2) }}</td>
                                        @endfor
                                    @endif
                                </tr>
                                @if ( ! empty($performances))
                                    <tr class="tr-actual" data-content="actual">
                                        <td class="text-nowrap text-left">ผลการดำเนินงาน (ร้อยละ)</td>
                                        @foreach ($performances as $performance)
                                            <td data-period="{{ $performance->period }}">{{ number_format($performance->actual, 2) }}</td>
                                        @endforeach
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="table-responsive">
                        <input type="hidden" name="performance-content" value="{{ ( ! empty($performances)) ? 'actual' : 'budget' }}">
                        <input type="hidden" name="performance-period" value="">
                        <table id="performance-detail" class="table table-sm" style="display: none;">
                            <thead>
                                <tr>
                                    <th class="col-sm-6 table-dark align-middle" colspan="14">กิจกรรม (ปีงบประมาณ xxxx)</th>
                                    <th class="col-sm-6"><button type="button" name="confirm" class="btn btn-success text-nowrap">ยืนยันข้อมูล</button></th>
                                </tr>
                                <tr class="row-space">
                                    <td>&nbsp;</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($activities_actual as $activity)
                                    <tr data-period="{{ $activity->period }}">
                                        <td class="text-nowrap  w-px-420" colspan="2">{{ $activity->description }}</td>
                                        @foreach ($config_nesdc_months as $id => $month)
                                            <td class="mini">{{ $month }}</td>
                                        @endforeach
                                        <td></td>
                                    </tr>
                                    <tr data-content="budget" data-period="{{ $activity->period }}">
                                        <td>&nbsp;</td>
                                        <td class="tr-budget">แผนตั้งต้น</td>
                                        @php $subtotal = 0 @endphp
                                        @if ( ! empty($activity->detail))
                                            @foreach ($activity->detail as $detail)
                                                @php $subtotal += $detail['budget'] @endphp
                                                <td>
                                                    <input type="number" step="0.01" data-name="performances[{{ $activity->period }}][{{ $detail['month'] }}][{{ $activity->code }}][budget]" value="{{ number_format($detail['budget'], 2) }}" class="form-control" readonly>
                                                    <input type="hidden" name="performances[{{ $activity->period }}][{{ $detail['month'] }}][{{ $activity->code }}][budget]" value="{{ number_format($detail['budget'], 2) }}">
                                                </td>
                                            @endforeach
                                        @else
                                            @foreach ($config_nesdc_months as $id => $month)
                                                <td>
                                                    <input type="number" step="0.01" data-name="performances[{{ $activity->period }}][{{ $id }}][{{ $activity->code }}][budget]" value="{{ number_format(0, 2) }}" class="form-control">
                                                    <input type="hidden" name="performances[{{ $activity->period }}][{{ $id }}][{{ $activity->code }}][budget]" value="0">
                                                </td>
                                            @endforeach
                                        @endif
                                        <td class="tr-budget">{{ number_format($subtotal, 2) }}</td>
                                    </tr>
                                    @if ( ! empty($performances))
                                    <tr data-content="actual" data-period="{{ $activity->period }}">
                                        <td>&nbsp;</td>
                                        <td class="tr-actual">ผลการดำเนินงาน</td>
                                        @php $subtotal = 0 @endphp
                                        @foreach ($activity->detail as $detail)
                                            @php $subtotal += $detail['actual'] @endphp
                                            <td>
                                                <input type="number" step="0.01" data-name="performances[{{ $activity->period }}][{{ $detail['month'] }}][{{ $activity->code }}][actual]" value="{{ number_format($detail['actual'], 2) }}" class="form-control {{ ($detail['actual'] < $detail['budget']) ? 'bg-red' : '' }}">
                                                <input type="hidden" name="performances[{{ $activity->period }}][{{ $detail['month'] }}][{{ $activity->code }}][actual]" value="{{ number_format($detail['actual'], 2) }}">
                                            </td>
                                        @endforeach
                                        <td class="tr-actual">{{ number_format($subtotal, 2) }}</td>
                                    </tr>
                                    @endif
                                    <tr class="row-space" data-period="{{ $activity->period }}">
                                        <td>&nbsp;</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="table-responsive">
                        <table id="tbl-issues" class="table table-sm table-bordered" style="display: none;">
                            <thead class="table-dark">
                                <tr>
                                    <td>วันที่พบปัญหา / อุปสรรค</td>
                                    <td>ปัญหา / อุปสรรค</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($issues as $issue)
                                    <tr>
                                        <td>{{ DateFormat($issue->issue_date, 'MMM YYYY', false) }}</td>
                                        <td>{{ $issue->issue_desc }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="btn-performance" class="row" style="display: none;">
                    <div class="col-sm-12 text-right">
                        @if ( ! empty($performances))
                            <a href="" data-href="{{ url('followup/' . $project_id . '/performance/export') }}" class="btn btn-info btn-round"><i class="zmdi zmdi-download"></i> ส่งออกข้อมูล</a>
                            <!-- <button type="button" class="btn btn-info btn-round"><i class="zmdi zmdi-download"></i> ส่งออกข้อมูล</button> -->
                            <button type="button" class="btn btn-info btn-round"><i class="zmdi zmdi-upload"></i> นำเข้าข้อมูล</button>
                            <button type="button" id="btn-issue" class="btn btn-warning btn-round" data-toggle="modal" data-target="#modal-content-fullscreen-xl"><i class="zmdi zmdi-info"></i> ปัญหา / อุปสรรค</button>
                        @endif
                        <button type="button" id="btn-save" class="btn btn-primary btn-round" data-toggle="modal" data-target="#modal-content"><i class="zmdi zmdi-save"></i> จัดเก็บข้อมูล</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

@section('js')
    @parent
    <script src="{{ asset('Content/Assets/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('Content/Assets/plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('Content/Assets/plugins/morrisjs/morris.min.js') }}"></script>
    <script src="{{ asset('Content/Assets/plugins/momentjs/moment.js') }}"></script>
    <script src="{{ asset('Content/Assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script> 
    <script src="{{ asset('Content/Assets/plugins/bootstrap-material-datetimepicker/js/th.min.js') }}"></script>
    <script src="{{ asset('Content/Assets/bundles/datatablescripts.bundle.js') }}"></script>
    <script src="{{ asset('Content/Assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('Content/Assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('Content/Assets/js/pages/tables/jquery-datatable.js') }}"></script>
@endsection

@section('jsscript')
    @parent
    <script>
        $(function() {
            let ChartPerformance;

            function initChartPerformance() {
                "use strict";
                ChartPerformance = Morris.Area({
                    element: 'chart-performance',
                    xkey: 'period',
                    @if(!empty($performances))
                    ykeys: ['แผนตั้งต้น', 'ผลการดำเนินงาน'],
                    labels: ['แผนตั้งต้น', 'ผลการดำเนินงาน'],
                    @else
                    ykeys: ['แผนตั้งต้น'],
                    labels: ['แผนตั้งต้น'],
                    @endif
                    pointStrokeColors: ['#ffd147', '#00d3e2'],
                    lineColors: ['#ffd147', '#00d3e2'],
                    behaveLikeLine: true,
                    gridLineColor: '#e0e0e0',
                    pointSize: 4,
                    fillOpacity: 0,
                    lineWidth: 2,
                    hideHover: 'auto',
                    resize: true,
                    xLabel: 'year',
                    axis: true,
                    yLabelFormat: function(y) {
                        return y.toString() + '%';
                    }
                });
            }

            function setChartData(data) {
                ChartPerformance.setData(data);
            }

            function getChartData() {
                let graph_data = [];
                let year, budget_accu = 0, actual_accu = 0;
                $('#performance thead tr').find('th > a').each(function(idx, td) {
                    year = $(td).text();
                    budget_accu = budget_accu + parseFloat($('#performance tbody tr[data-content="budget"] td[data-period="' + year + '"]').text())
                    actual_accu = actual_accu + parseFloat($('#performance tbody tr[data-content="actual"] td[data-period="' + year + '"]').text())
                    graph_data[idx] = {
                        period: year,
                        'แผนตั้งต้น': budget_accu,
                        @if(!empty($performances))
                        'ผลการดำเนินงาน': actual_accu
                        @endif
                    };
                });

                setChartData(graph_data);
            }

            // สร้างกราฟ
            initChartPerformance();
            getChartData();

            // เริ่มต้น plugin datatable
            var tbl = $('#tbl-issues').DataTable({
                bLengthChange: false,
                // columnDefs: [
                //     { "width": "30%", targets: 0 },
                // ],
                language: { 
                    loadingRecords: '<h3 class="text-center text-secondary p-3">กำลังโหลด...</h3>', 
                    zeroRecords: '<h3 class="text-center text-muted p-3">ไม่พบข้อมูล</h3>' 
                }    
            });
            
            // Event สำหรับสร้างกราฟตอนเปลี่ยน tab
            // $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            //     ChartPerformance.redraw();
            //     $(window).trigger('resize');
            // });

            // กดปุ่มที่ปีงบประมาณ
            $(document).on('click', '#performance a', function() {
                var period = $(this).text();
                $('input[name="performance-period"]').val(period);
                // ตารางรายกิจกรรม
                $('#performance-detail').css('display', 'table');
                $('#performance-detail thead tr:eq(0) th:eq(0)').text('กิจกรรม (ปีงบประมาณ ' + period + ')');
                $('#performance-detail tbody tr').css('display', 'none');
                $('#performance-detail tbody tr[data-period="' + period + '"]').css('display', 'table-row');
                // ตารางปัญหา/อุปสรรค
                $('#tbl-issues').css('width', '100%').show();
                tbl.column(0).search(period).draw();
                // แถบปุ่มกดต่างๆ
                $('#btn-performance').show();
                $('#btn-performance a').attr('href', $('#btn-performance a').attr('data-href') + '/' + period);
            });

            // กดปุ่ม "ยืนยันข้อมูล"
            $(document).on('click', 'button[name="confirm"]', function() {
                let content = $('input[name="performance-content"]').val();
                const period = $('input[name="performance-period"]').val();
                const $this = $('#performance-detail tbody tr[data-content="' + content + '"]').filter(function() {
                    return this.style.display == 'table-row';
                });

                let subtotal;
                let total = 0;
                let val;
                $this.each(function() {
                    subtotal = 0;
                    $(this).find('input[type="number"]').each(function(idx, item) {
                        val = $(item).val();
                        $('input[name="' + $(item).data('name') + '"]').val(val);
                        subtotal = subtotal + parseFloat(val);
                    });

                    // console.log(content + ':' + period + ':' + subtotal);
                    total = total + subtotal;
                    $(this).find('td:last-child').text(subtotal.toFixed(2));
                })

                // console.log('total: ' + content + ':' + period + ':' + total);
                $('#performance tr[data-content="' + content + '"]').find('td[data-period="' + period + '"]').text(total.toFixed(2));

                // สร้างกราฟใหม่
                getChartData();
            });

            // กดปุ่ม "ปัญหา / อุปสรรค"
            $(document).on('click', '#btn-issue', function() {
                $.ajax({
                    type: "GET",
                    url: "{{ url('followup') }}/" + $('input[name="project_id"]').val() + "/performance/issue",
                    success: function(data){
                        $('#modal-content-fullscreen-xl').html(data);
                        new bootstrap.Modal(document.getElementById('modal-content-fullscreen-xl'));
                    },
                });
            });

            // กดปุ่ม "จัดเก็บข้อมูล"
            $(document).on('click', '#btn-save', function() {
                $.ajax({
                    type: "GET",
                    url: "{{ url('followup') }}/" + $('input[name="project_id"]').val() + "/performance/confirm",
                    success: function(data){
                        $('#modal-content').html(data);
                        new bootstrap.Modal(document.getElementById('modal-content'));
                    },
                });
            });

            // กดปุ่ม "บันทึก" ใน modal
            $(document).on('click', '#modal-content button[data-confirm]', function(){
                $('form').submit();
            })
        });
    </script>
@endsection