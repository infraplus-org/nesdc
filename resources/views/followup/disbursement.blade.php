@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('Content/Assets/plugins/morrisjs/morris.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('Content/Assets/css/color_skins.css') }}" />
    <link rel="stylesheet" href="{{ asset('Content/Assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
@endsection 

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="body">
                <div class="row">
                    <div class="col-8">
                        <p class="h5">{{ $project->description }}</p>
                    </div>
                    <div class="col-4">
                        <div class="row">
                            <label class="col-6">ระยะเวลาดำเนินงาน</label>
                            <label class="col-6">
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
                        <div class="row">
                            <label class="col-6">งบประมาณทั้งสิ้น</label>
                            <label class="col-6">{{ number_format($project->budget, 2) . ' ล้านบาท' }}</label>
                        </div>
                        <div class="row">
                            <label class="col-6">ผลการเบิกจ่ายทั้งสิ้น</label>
                            <label class="col-6">{{ $total_disbursement . ' ล้านบาท' }}</label>
                        </div>
                    </div>
                </div>
                
                <ul class="nav nav-tabs justify-content-center">
                    <li class="nav-item"><a class="nav-link {{ preg_match('/followup\/.*\/disbursement\/money/', $uri) ? 'active' : '' }}" href="{{ url('followup/' . $project->project_id . '/disbursement/money') }}">แหล่งเงิน</a></li>
                    <li class="nav-item"><a class="nav-link {{ preg_match('/followup\/.*\/disbursement\/activity/', $uri) ? 'active' : '' }}" href="{{ url('followup/' . $project->project_id . '/disbursement/activity') }}">กิจกรรม</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane {{ preg_match('/followup\/.*\/disbursement\/money/', $uri) ? 'in active' : '' }}" id="tab_money">
                        @if (preg_match('/followup\/.*\/disbursement\/money/', $uri))
                            @include('followup.disbursement_money')
                        @endif
                    </div>
                    <div role="tabpanel" class="tab-pane {{ preg_match('/followup\/.*\/disbursement\/activity/', $uri) ? 'in active' : '' }}" id="tab_activity">
                        @if (preg_match('/followup\/.*\/disbursement\/activity/', $uri))
                            @include('followup.disbursement_activity')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
            // Event สำหรับสร้างกราฟตอนเปลี่ยน tab
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                ChartDisbursementMoney.redraw();
                $(window).trigger('resize');
            });
        });
    </script>
@endsection