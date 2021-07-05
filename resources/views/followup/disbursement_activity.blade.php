<form method="POST" action="{{ url('followup/' . $project->project_id . '/disbursement/activity/save') }}">
@csrf
<input type="hidden" name="project_id" value="{{ $project->project_id }}">
<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="card border border-info">
            <div class="body">
                <label>การเบิกจ่าย (ล้านบาท)</label>
                <div id="chart-disbursement-activity" class="graph"></div>
                <label class="col-12 text-center">ปีงบประมาณ</label>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="table-responsive">
        <table id="tbl-disbursement-activity" class="table table-sm table-bordered">
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
                    <td class="text-nowrap text-left">แผนตั้งต้น (ล้านบาท)</td>
                    @if ( ! empty($disbursements))
                        @foreach ($disbursements as $disbursement)
                            <td data-period="{{ $disbursement->period }}">{{ number_format($disbursement->budget, 2) }}</td>
                        @endforeach
                    @else
                        @for ($i=$actual_begin_year; $i<=$actual_end_year; $i++) 
                            <td data-period="{{ $i }}">{{ number_format(0, 2) }}</td>
                        @endfor
                    @endif
                </tr>
                @if ( ! empty($disbursements))
                    <tr class="tr-actual" data-content="actual">
                        <td class="text-nowrap text-left">ผลการเบิกจ่าย (ล้านบาท)</td>
                        @foreach ($disbursements as $disbursement)
                            <td data-period="{{ $disbursement->period }}">{{ number_format($disbursement->actual, 2) }}</td>
                        @endforeach
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="table-responsive">
        <input type="hidden" name="disbursement-activity-content" value="{{ ( ! empty($disbursements)) ? 'actual' : 'budget' }}">
        <input type="hidden" name="disbursement-activity-period" value="">
        <table id="tbl-disbursement-activity-detail" class="table table-sm" style="display: none;">
            <thead>
                <tr>
                    <th class="col-sm-6 table-dark align-middle" colspan="14">กิจกรรม (ปีงบประมาณ xxxx)</th>
                    <th class="col-sm-6"><button type="button" name="btn-disbursement-activity-confirm" class="btn btn-success text-nowrap">ยืนยันข้อมูล</button></th>
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
                                    <input type="number" step="0.01" data-name="disbursements[{{ $activity->period }}][{{ $detail['month'] }}][{{ $activity->code }}][budget]" value="{{ number_format($detail['budget'], 2) }}" class="form-control" readonly>
                                    <input type="hidden" name="disbursements[{{ $activity->period }}][{{ $detail['month'] }}][{{ $activity->code }}][budget]" value="{{ number_format($detail['budget'], 2) }}">
                                </td>
                            @endforeach
                        @else
                            @foreach ($config_nesdc_months as $id => $month)
                                <td>
                                    <input type="number" step="0.01" data-name="disbursements[{{ $activity->period }}][{{ $id }}][{{ $activity->code }}][budget]" value="{{ number_format(0, 2) }}" class="form-control">
                                    <input type="hidden" name="disbursements[{{ $activity->period }}][{{ $id }}][{{ $activity->code }}][budget]" value="0">
                                </td>
                            @endforeach
                        @endif
                        <td class="tr-budget">{{ number_format($subtotal, 2) }}</td>
                    </tr>
                    @if ( ! empty($disbursements))
                    <tr data-content="actual" data-period="{{ $activity->period }}">
                        <td>&nbsp;</td>
                        <td class="tr-actual">ผลการดำเนินงาน</td>
                        @php $subtotal = 0 @endphp
                        @foreach ($activity->detail as $detail)
                            @php $subtotal += $detail['actual'] @endphp
                            <td>
                                <input type="number" step="0.01" data-name="disbursements[{{ $activity->period }}][{{ $detail['month'] }}][{{ $activity->code }}][actual]" value="{{ number_format($detail['actual'], 2) }}" class="form-control {{ ($detail['actual'] < $detail['budget']) ? 'bg-red' : '' }}">
                                <input type="hidden" name="disbursements[{{ $activity->period }}][{{ $detail['month'] }}][{{ $activity->code }}][actual]" value="{{ number_format($detail['actual'], 2) }}">
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
        <table id="tbl-disbursement-activity-issues" class="table table-sm table-bordered" style="display: none;">
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
<div id="btn-disbursement-activity" class="row" style="display: none;">
    <div class="col-sm-12 text-right">
        @if ( ! empty($disbursements))
            <a href="" data-href="{{ url('followup/' . $project_id . '/disbursement/export') }}" class="btn btn-info btn-round"><i class="zmdi zmdi-download"></i> ส่งออกข้อมูล</a>
            <!-- <button type="button" class="btn btn-info btn-round"><i class="zmdi zmdi-download"></i> ส่งออกข้อมูล</button> -->
            <button type="button" class="btn btn-info btn-round"><i class="zmdi zmdi-upload"></i> นำเข้าข้อมูล</button>
            <button type="button" id="btn-disbursement-activity-issue" class="btn btn-warning btn-round" data-toggle="modal" data-target="#modal-content-fullscreen-xl"><i class="zmdi zmdi-info"></i> ปัญหา / อุปสรรค</button>
        @endif
        <button type="button" id="btn-disbursement-activity-save" class="btn btn-primary btn-round" data-toggle="modal" data-target="#modal-content"><i class="zmdi zmdi-save"></i> จัดเก็บข้อมูล</button>
    </div>
</div>
</form>

@section('jsscript')
    @parent
    <script>
        $(function() {
            let ChartDisbursementActivity;

            function initChartDisbursement(target) {
                "use strict";
                return Morris.Area({
                    element: target,
                    xkey: 'period',
                    @if(!empty($disbursements))
                    ykeys: ['แผนตั้งต้น', 'ผลการเบิกจ่าย'],
                    labels: ['แผนตั้งต้น', 'ผลการเบิกจ่าย'],
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
                });
            }

            function getChartData(target) {
                let graph_data = [];
                let year, budget_accu = 0, actual_accu = 0;
                $(target + ' thead tr').find('th > a').each(function(idx, td) {
                    year = $(td).text();
                    budget_accu = parseFloat($(target + ' tbody tr[data-content="budget"] td[data-period="' + year + '"]').text())
                    actual_accu = parseFloat($(target + ' tbody tr[data-content="actual"] td[data-period="' + year + '"]').text())
                    graph_data[idx] = {
                        period: year,
                        'แผนตั้งต้น': budget_accu,
                        @if(!empty($disbursements))
                        'ผลการเบิกจ่าย': actual_accu
                        @endif
                    };
                });

                // console.log(graph_data);
                return graph_data;
            }

            // สร้างกราฟ
            ChartDisbursementActivity = initChartDisbursement('chart-disbursement-activity');
            ChartDisbursementActivity.setData(getChartData('#tbl-disbursement-activity'));

            // เริ่มต้น plugin datatable
            var tbl = $('#tbl-disbursement-activity-issues').DataTable({
                bLengthChange: false,
                language: { 
                    loadingRecords: '<h3 class="text-center text-secondary p-3">กำลังโหลด...</h3>', 
                    zeroRecords: '<h3 class="text-center text-muted p-3">ไม่พบข้อมูล</h3>' 
                }    
            });
            
            // // Event สำหรับสร้างกราฟตอนเปลี่ยน tab
            // $('a#tab_activity[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            //     ChartDisbursementActivity.redraw();
            //     $(window).trigger('resize');
            // });

            // กดเลือกปีงบประมาณ
            $(document).on('click', '#tbl-disbursement-activity a', function() {
                var period = $(this).text();
                $('input[name="disbursement-activity-period"]').val(period);
                // ตารางรายกิจกรรม
                $('#tbl-disbursement-activity-detail').css('display', 'table');
                $('#tbl-disbursement-activity-detail thead tr:eq(0) th:eq(0)').text('กิจกรรม (ปีงบประมาณ ' + period + ')');
                $('#tbl-disbursement-activity-detail tbody tr').css('display', 'none');
                $('#tbl-disbursement-activity-detail tbody tr[data-period="' + period + '"]').css('display', 'table-row');
                // ตารางปัญหา/อุปสรรค
                $('#tbl-disbursement-activity-issues').css('width', '100%').show();
                tbl.column(0).search(period).draw();
                // แถบปุ่มกดต่างๆ
                $('#btn-disbursement-activity').show();
                $('#btn-disbursement-activity a').attr('href', $('#btn-disbursement-activity a').attr('data-href') + '/' + period);
            });

            // กดปุ่ม "ยืนยันข้อมูล"
            $(document).on('click', 'button[name="btn-disbursement-activity-confirm"]', function() {
                let content = $('input[name="disbursement-activity-content"]').val();
                const period = $('input[name="disbursement-activity-period"]').val();
                const $this = $('#tbl-disbursement-activity-detail tbody tr[data-content="' + content + '"]').filter(function() {
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
                        (parseFloat(val) < parseFloat($('input[name="' + $(item).data('name').replace('[actual]', '[budget]') + '"]').val())) ? $(this).addClass('bg-red') : $(this).removeClass('bg-red')
                    });

                    // console.log(content + ':' + period + ':' + subtotal);
                    total = total + subtotal;
                    $(this).find('td:last-child').text(subtotal.toFixed(2));
                })

                // console.log('total: ' + content + ':' + period + ':' + total);
                $('#tbl-disbursement-activity tr[data-content="' + content + '"]').find('td[data-period="' + period + '"]').text(total.toFixed(2));

                // สร้างกราฟใหม่
                ChartDisbursementActivity.setData(getChartData('#tbl-disbursement-activity'));
            });

            // กดปุ่ม "ปัญหา / อุปสรรค"
            $(document).on('click', '#btn-disbursement-activity-issue', function() {
                $.ajax({
                    type: "GET",
                    url: "{{ url('followup') }}/" + $('input[name="project_id"]').val() + "/disbursement/activity/issue",
                    success: function(data){
                        $('#modal-content-fullscreen-xl').html(data);
                        new bootstrap.Modal(document.getElementById('modal-content-fullscreen-xl'));
                    },
                });
            });

            // กดปุ่ม "จัดเก็บข้อมูล"
            $(document).on('click', '#btn-disbursement-activity-save', function() {
                $.ajax({
                    type: "GET",
                    url: "{{ url('followup') }}/" + $('input[name="project_id"]').val() + "/disbursement/activity/confirm",
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