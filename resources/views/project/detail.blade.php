@extends('layouts.app')

@section('css')
    <!-- Bootstrap Select Css -->
    <link rel="stylesheet" href="{{ asset('Content/Assets/plugins/ol-v6.5.0-dist/ol.css') }}">
    <link rel="stylesheet" href="{{ asset('Content/Assets/css/modal.css') }}">
    
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
        #map{
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
        .table#activity input[type="number"] {
            text-align: right;
        }
    </style>
@endsection

@section('content')
    <section class="content">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>
                        ข้อมูลโครงการ
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
                        <li class="breadcrumb-item active">ข้อมูลโครงการ</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>รายละเอียดโครงการ </strong></h2>
                        </div>
                        <div class="body table-responsive">
                            <div class="display-6">
                                <div class="row clearfix">
                                    <div class="col-sm-12 form-row mb-2">
                                        <div class="col-sm-3 form-control-label text-sm-right align-self-center">
                                            <label class="font-weight-bold">เรื่อง / ดำเนินการ</label>
                                        </div>
                                        <div class="col-sm-7">
                                            <label class="form-control-label">{{ $project->description }}</label>
                                        </div>
                                    </div>   
                                    <div class="col-sm-12 form-row mb-2">
                                        <div class="col-sm-3 form-control-label text-sm-right align-self-center">
                                            <label class="font-weight-bold">หน่วยงาน</label>
                                        </div>
                                        <div class="col-sm-7">
                                            <label class="form-control-label">{{ $project->department_desc }}</label>
                                        </div>
                                    </div> 
                                    <div class="col-sm-12 form-row mb-2">
                                        <div class="col-sm-3 form-control-label text-sm-right align-self-center">
                                            <label class="font-weight-bold">สาขาการลงทุน</label>
                                        </div>
                                        <div class="col-sm-7">
                                            <label class="form-control-label">{{ $project->investment_desc }}</label>
                                        </div>
                                    </div>    
                                    <div class="col-sm-12 form-row mb-2">
                                        <div class="col-sm-3 form-control-label text-sm-right align-self-center">
                                            <label class="font-weight-bold">พื้นที่การดำเนินการ</label>
                                        </div>
                                        <div class="col-sm-7">
                                            @php $areas = Str::of($project->area)->split('/;/'); @endphp
                                            @foreach ($areas as $area)
                                                @if ( ! is_null($area) && $area != '')
                                                    <label class="btn btn-simple btn-warning btn-round align-self-center tag-prv btn-sm">{{ $area }}</label>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div> 
                                    <div class="col-sm-12 form-row mb-2">
                                        <div class="col-sm-3 form-control-label text-sm-right align-self-center">
                                            <label class="font-weight-bold">รายละเอียดพื้นที่การดำเนินการ</label>
                                        </div>
                                        <div class="col-sm-7">
                                            <label class="form-control-label">{{ $project->area_detail }}</label>
                                        </div>
                                    </div>  
                                </div>
                                <!-- end row detail -->
                                <hr>
                                <div class="col-sm-12 px-0">
                                    <div id="map"></div>
                                </div>
                            </div>
                            <!-- end card 1 -->
                            <div class="card border border-info">
                                <div class="header">
                                    <h2><strong>ข้อเสนอพิจารณา</strong></h2>
                                </div>
                                <div class="col-12">
                                    <label class="form-control-label lbl-textarea">{{ $project->proposal }}</label>
                                </div>
                            </div>
                            <!-- end ข้อเสนอพิจารณา -->
    
                            <div class="card border border-info">
                                <div class="header">
                                    <h2><strong>ความเป็นมา</strong></h2>
                                </div>
                                <div class="col-12">
                                    <label class="form-control-label lbl-textarea">{{ $project->story }}</label>
                                </div>
                            </div>
                            <!-- end ความเป็นมา -->
    
                            <div class="card border border-info">
                                <div class="header">
                                    <h2><strong>วัตถุประสงค์</strong></h2>
                                </div>
                                <div class="col-12">
                                    <label class="form-control-label lbl-textarea">{{ $project->objective }}</label>
                                </div>
                            </div>
                            <!-- end วัตถุประสงค์ -->
    
                            <div class="card border border-info">
                                <div class="header">
                                    <h2><strong>เป้าหมาย</strong></h2>
                                </div>
                                <div class="col-12">
                                    <label class="form-control-label lbl-textarea">{{ $project->goal }}</label>
                                </div>
                            </div>
                            <!-- end เป้าหมาย -->

                            <div class="card border border-info">
                                <div class="header">
                                    <h2><strong>เงินลงทุนและแหล่งเงินทุน</strong></h2>
                                </div>
                                <div class="body display-6">
                                    <div class="row mb-2">
                                        <div class="col-sm-12 form-row">
                                            <div class="col-sm-3 col-lg-2 form-control-label text-sm-right align-self-center">
                                                <label class="font-weight-bold">กรอบการลงทุน ทั้งหมด</label>
                                            </div>
                                            <div class="col-sm-9 col-lg-8">
                                                <div class="form-group d-inline-flex align-self-center">
                                                    <label class="form-control-label align-self-center mr-2 mb-0">{{ $budget->budget_all }}</label>
                                                    <label class="form-control-label align-self-center mr-3 mb-0"> ล้านบาท</label>
                                                    <div class="checkbox text-nowrap mb-0 align-self-center disabled-normal">
                                                        <input id="checkbox4" type="checkbox" name="included_vat" {{ ($budget->included_vat == 1) ? 'checked=""' : '' }} disabled>
                                                        <label for="checkbox4">รวมภาษีมูลค่าเพิ่ม 7%</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="col-sm-12 form-row">
                                            <div class="col-sm-3 col-lg-2 form-control-label text-sm-right align-self-center">
                                                <label class="font-weight-bold">รูปแบบการลงทุน</label>
                                            </div>
                                            <div class="col-sm-9 col-lg-8">
                                                <label class="form-control-label">{{ $budget->investment_type }}</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 form-row">
                                            <div class="col-sm-2 form-control-label text-sm-right">
                                                <label class="font-weight-bold">แหล่งเงินลงทุน</label>
                                            </div>
                                            <div class="col-sm-8 form-row no-gutters">
                                                <div class="col-sm-12">
                                                    @foreach ($investments as $detail)
                                                        <div class="text-nowwrap row mb-2">
                                                            <div class="col-sm-4">
                                                                <label class="px-2 align-self-center mb-0">{{ $detail->fund_desc }}</label>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <label class="px-2 align-self-center mb-0">วงเงิน</label>
                                                            </div>
                                                            <div class="col-sm-5 d-flex">
                                                                <input type="number" name="investments[{{ $detail->fund_code }}]" class="form-control text-right border-secondary readonly-normal" placeholder="-" value="{{ number_format($detail->fund_value, 4) }}" readonly>
                                                                <label class="text-nowrap align-self-center mb-0">ล้านบาท</label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="text-nowwrap row mb-2">
                                                        <div class="col-sm-4">
                                                            <label class="px-2 align-self-center mb-0">ระบุ</label>
                                                        </div>
                                                        <div class="col-sm-8 d-flex">
                                                            <input type="text" name="budget[others_desc]" class="form-control border-secondary readonly-normal" placeholder="-" value="{{ $budget->others_desc }}" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                        <!-- แหล่งเงินลงทุน -->
                                    </div>
                                </div>
                            </div>
                            <!-- end เงินลงทุนและแหล่งเงินทุน -->

                            <input type="hidden" id="begin_year" name="begin_year" value="{{ $project->plan_begin_year }}">
                            <input type="hidden" id="end_year" name="end_year" value="{{ $project->plan_end_year }}">
                            <div class="card border border-info">
                                <div class="header pb-0">
                                    <h2><strong>แผนการดำเนินงาน</strong></h2>
                                </div>
                                <div class="body display-6 table-responsive">
                                    <div class="row">
                                        <div class="mt-4">
                                            <table id="table-plan" class="table table-bordered table-sm f-9">
                                                <thead>
                                                    <tr class="text-center head-list">
                                                        <th class="align-middle w-px-420" rowspan="2">รายการ</th>
                                                        {{-- auto generate [TH] FROM select date_start, date_end and submit button ยืนยันข้อมูล--}}
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($activities as $activity)
                                                        @if ( ! is_null($activity->sub_activity_desc))
                                                            <tr class="box-plan-{{ $loop->iteration }}" data-content="sub" data-activity="{{ $activity->sub_activity_desc }}" data-parent="{{ $activity->code }}">
                                                                <input type="hidden" name="activities[{{ $activity->code . '_' . $loop->index }}][activity_code]" value="{{ $activity->code }}">
                                                                <td class="box-plan-header"><input type="text" class="form-control border-secondary text-right" placeholder="กิจกรรมย่อย" name="activities[{{ $activity->code . '_' . $loop->index }}][sub_activity_desc]" value="{{ $activity->sub_activity_desc }}" required></td>
                                                                {{-- Auto generate [TD] FROM event "on change" dropdown begin_year, end_year --}}
                                                            </tr>
                                                        @else
                                                            <tr class="box-plan-{{ $loop->iteration }}" data-content="main" data-activity="{{ $activity->code }}">
                                                                <input type="hidden" name="activities[{{ $activity->code }}][activity_code]" value="{{ $activity->code }}">
                                                                <input type="hidden" name="activities[{{ $activity->code }}][sub_activity_desc]" value="">
                                                                <td class="box-plan-header">
                                                                    <div class="checkbox text-nowrap mb-0">
                                                                        <input id="t-plan-{{ $loop->iteration }}" type="checkbox" name="activities[{{ $activity->code }}][selected]" value="1">
                                                                        <label for="t-plan-{{ $loop->iteration }}">{{ $activity->description }}</label>
                                                                        <button type="button" class="btn btn-sm btn-mini btn-secondary float-right btn-sub-activity">
                                                                            <i class="zmdi zmdi-plus"></i> เพิ่มกิจกรรมย่อย
                                                                        </button>
                                                                    </div>
                                                                </td>
                                                                {{-- Auto generate [TD] FROM event "on change" dropdown begin_year, end_year --}}
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end แผนการดำเนินงาน -->

                            <div class="card border border-info">
                                <div class="header">
                                    <h2><strong>กรอบเงินลงทุนกิจกรรม</strong></h2>
                                </div>
                                <div class="body display-6">
                                    <div class="row">
                                        <div class="col-sm-12 form-row">
                                            @if ($project->plan_begin_year != "" && $project->plan_end_year != "")
                                                <div class="col-sm-12 form-row no-gutters">
                                                    <p class="text-right w-100">หน่วย: ล้านบาท</p>
                                                    <table id="activity" class="table table-sm table-align-center f-9">
                                                        <thead>
                                                            <tr class="text-center head-list">
                                                                <th class="w-px-420 head-list-freeze" rowspan="2">รายการ</th>
                                                                <!-- auto generate [TH] FROM select date_start, date_end and submit button ยืนยันข้อมูล-->
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($activities as $activity)
                                                                @if ( ! is_null($activity->sub_activity_desc))
                                                                    <tr class="box-plan activity-child" data-activity="{{ $activity->sub_activity_desc }}" data-parent="{{ $activity->code }}">
                                                                        <input type="hidden" name="activities[{{ $activity->code . '_' . $loop->index }}][activity_code]" value="{{ $activity->code }}">
                                                                        <td class="box-plan-header"><input type="text" class="form-control border-secondary text-right readonly-normal" placeholder="กิจกรรมย่อย" name="activities[{{ $activity->code . '_' . $loop->index }}][sub_activity_desc]" value="{{ $activity->sub_activity_desc }}" readonly></td>
                                                                        <!-- Auto generate [TD] FROM event "on change" dropdown begin_year, end_year -->
                                                                    </tr>
                                                                @else
                                                                    <tr class="box-plan activity-parent" data-activity="{{ $activity->code }}">
                                                                        <input type="hidden" name="activities[{{ $activity->code }}][activity_code]" value="{{ $activity->code }}">
                                                                        <input type="hidden" name="activities[{{ $activity->code }}][sub_activity_desc]" value=""></td>
                                                                        <td class="box-plan-header">
                                                                            <div class="text-nowrap mb-0">
                                                                                <label for="t-plan1">{{ $activity->description }}</label>
                                                                            </div>
                                                                        </td>
                                                                        <!-- Auto generate [TD] FROM event "on change" dropdown begin_year, end_year -->
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <div class="col-sm-10 form-control-label text-sm-right"></div>
                                                <div class="col-sm-3 form-control-label text-sm-right"></div>
                                                <div class="col-sm-6 form-control-label text-sm-right">
                                                    <div class="alert alert-dark text-center">ยังไม่มีข้อมูล</div>
                                                </div>
                                                <div class="col-sm-3 form-control-label text-sm-right"></div>
                                            @endif
                                        </div> 
                                    </div>
                                </div>
                            </div>
                            <!-- End กรอบเงินลงทุนกิจกรรม -->
                                        
                            <div class="card border border-info">
                                <div class="header">
                                    <h2><strong>ผลตอบแทนการลงทุนโครงการ</strong></h2>
                                </div>
                                <div class="body display-6">
                                    <h6>ผลตอบแทนทางการเงิน</h6>
                                    @foreach ($finances as $finance)
                                        <div class="text-nowwrap row mb-2">
                                            <div class="col-sm-6 row">
                                                <div class="col-sm-3">
                                                    <label class="text-nowrap px-2 align-self-center mb-0">{{ $finance->description }}</label>
                                                </div>
                                                <div class="col-sm-9 d-flex">
                                                    <input type="number" name="returns[finance][{{ $loop->index }}][value]" class="form-control text-right border-secondary readonly-normal" value="{{ $finance->value }}" readonly>
                                                    <label class="text-nowrap px-2 align-self-center mb-0 w-px-100">{{ $finance->unit }}</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 row">
                                                <div class="col-sm-3">
                                                    <label class="text-nowrap px-2 align-self-center mb-0">หมายเหตุ</label>
                                                </div>
                                                <div class="col-sm-9 d-flex">
                                                    <input type="text" name="returns[finance][{{ $loop->index }}][remark]" class="form-control border-secondary readonly-normal" value="{{ $finance->remark }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <!-- End ผลตอบแทนทางการเงิน -->
    
                                    <h6>ผลตอบแทนทางเศรษฐกิจ</h6>
                                    @foreach ($economics as $economic)
                                        <div class="text-nowwrap row mb-2">
                                            <div class="col-sm-6 row">
                                                <div class="col-sm-3">
                                                    <label class="text-nowrap px-2 align-self-center mb-0">{{ $economic->description }}</label>
                                                </div>
                                                <div class="col-sm-9 d-flex">
                                                    <input type="number" name="returns[economic][{{ $loop->index }}][value]" class="form-control text-right border-secondary readonly-normal" value="{{ $economic->value }}" readonly>
                                                    <label class="text-nowrap px-2 align-self-center mb-0 w-px-100">{{ $economic->unit }}</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 row">
                                                <div class="col-sm-3">
                                                    <label class="text-nowrap px-2 align-self-center mb-0">หมายเหตุ</label>
                                                </div>
                                                <div class="col-sm-9 d-flex">
                                                    <input type="text" name="returns[economic][{{ $loop->index }}][remark]" class="form-control border-secondary readonly-normal" value="{{ $economic->remark }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <!-- End ผลตอบแทนทางการเงิน -->
                                </div>
                            </div>
                            <!-- End card ผลตอบแทนการลงทุนโครงการ -->
    
                            <!-- <div class="card">
                                <div class="header">
                                    <h2><strong>ความสอดคล้องกับนโยบายและแผน</strong></h2>
                                </div>
                                <div class="body display-6">รอรายละเอียด Mockup
                                    
                                    <hr>
                                    <a href="{{ url('project/manage') }}">
                                        <button type="button"class="btn btn-secondary float-right d-flex">
                                        <i class="zmdi zmdi-hc-2x zmdi-long-arrow-left"></i> <span class="d-flex align-self-center ml-2">ย้อนกลับ</span>
                                        </button>
                                    </a>
                                </div>
                            </div> -->
                            <!-- End card ความสอดคล้องกับนโยบายและแผน -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="{{ asset('Content/Assets/plugins/ol-v6.5.0-dist/ol.js') }}"></script>
@endsection

@section('jsscript')
    <script>
        $(document).ready(function(){
            const arr_m = [
                [10,"ต.ค."],
                [11,"พ.ย."],
                [12,"ธ.ค."],
                [1,"ม.ค."],
                [2,"ก.พ."],
                [3,"มี.ค."],
                [4,"เม.ย."],
                [5,"พ.ค."],
                [6,"มิ.ย."],
                [7,"ก.ค."],
                [8,"ส.ค."],
                [9,"ก.ย."]
            ];

            $('#prv').selectpicker();

            $('#view-project-info').on('show.bs.modal', function (e) {
                setTimeout(function(){
                    reloadMap();
                },500);
            });

            var activities = JSON.parse('@php echo json_encode($activities) @endphp');
            createThead = function(thead){
                $('.' + thead).find('.new-header').remove();
                $('#table-inv tfoot tr').find('.new-header').remove();
                let len = [$("#begin_year").val(), $("#end_year").val()];
                console.log(len);
            
                // if(!isNaN(len[0]) && !isNaN(len[1])){
                if(len[0] != "" && len[1] != ""){
                    // กรอบเงินลงทุนรายกิจกรรม
                    if(thead == "header-inv")
                    {
                        for(i=len[0];i<=len[1];i++){
                            //console.log(i);
                            $('tr.'+thead).append('<th class="new-header">' + parseInt(i) + '</th>');
                            $('#table-inv tfoot tr').append('<th class="new-header"><input type="number" step="0.01" value="0" class="form-control text-right"></th>');
                        }

                        $('tr.'+thead).append('<th class="new-header">รวมงบประมาณ</th>');
                        $('#table-inv tfoot tr').append('<th class="new-header"><input type="number" step="0.01" value="0" class="form-control text-right"></th>');
                    }
                    // แผนการดำเนินการโครงการ
                    else
                    {
                        for(i=len[0];i<=len[1];i++){
                            // console.log(i);
                            $('tr.' + thead).append('<th colspan="12" class="new-header">ปีงบประมาณ ' + parseInt(i) + '</th>');
                        }
                    
                        $('tr.'+thead).after('<tr class="tr-m-mini"></tr>');
                    }
                    
                    return len;
                }
            };

            callTablePlan = function(){
                $('.tr-m-mini,.child-range-year').remove();
                // $('[id^="t-plan"]').prop('checked',false).parent().find('button').hide();
                $('[id^="t-plan"]').parent().find('button').hide();
                let len = createThead('head-list');

                // if(!isNaN(len[0]) && !isNaN(len[1])){
                if(len[0] != "" && len[1] != ""){
                    var hidden_val, slider_val, period;
                    var content;
                    
                    for (i=len[0]; i<=len[1]; i++)
                    {
                        $.each(arr_m,function(k, v){
                            $('.tr-m-mini').append('<th class="focus-'+v[0]+'-'+i+'">'+v[1]+'</th>');
                        });
                    }

                    $.each(activities, function(idx, activity){
                        // Skip sub activity
                        if (activity['sub_activity_desc'] !== null) return;
                        
                        var objSlider, begin_year, end_year;
                        var obj = $('table#table-plan tbody tr:nth-child(' + (idx + 1) + ')')
                        for (i=len[0]; i<=len[1]; i++)
                        {
                            obj.append('<td data-plan="plan' + activity['code'] + '" data-year="' + i + '" class="px-2 child-range-year align-middle td-slider-range" colspan="12">'+
                                '<input type="hidden" name="activities[' + activity['code'] + '][period][' + i + '][begin]" value="' + (activity[i + '_month_begin'] && typeof activity[i + '_month_begin'] !== 'undefined' ? activity[i + '_month_begin'] : '') + '">'+
                                '<input type="hidden" name="activities[' + activity['code'] + '][period][' + i + '][end]" value="' + (activity[i + '_month_begin'] && typeof activity[i + '_month_end'] !== 'undefined' ? activity[i + '_month_end'] : '') + '">'+
                                // '<input type="number" name="activities[' + activity['code'] + '][period][' + i + '][budget]" class="form-control border-secondary w-px-100" data-name="valact3_1[]" value="' + (!isNaN(activity[i]) ? activity[i] : 0) + '">' +
                                '<div class="slider-range"></div>'+
                            '</td>');

                            objSlider = $('td[data-plan="plan' + activity['code'] + '"][data-year="' + i + '"] > .slider-range');
                            begin_year = objSlider.parent().find('input[name$="[begin]"]').val();
                            end_year = objSlider.parent().find('input[name$="[end]"]').val();
                            if (begin_year > 0 && end_year > 0)
                            {
                                // slider-range in table follow in month
                                slider_val = [ arr_m.findIndex(x => x[0] == begin_year), arr_m.findIndex(x => x[0] == end_year) ];
                                //console.log(slider_val);

                                objSlider.slider({
                                    range: true,
                                    min: 0,
                                    max: 11,
                                    step: 1,
                                    // values: [ 0, 11 ],
                                    values: slider_val,
                                    create: function(){
                                        $(this).closest('td').addClass('slider-created');
                                    },
                                    slide: function(event, ui) { 
                                        var year = $(this).parent().data('year');
                                        var activity = $(this).closest('tr').data('activity');
                                        $(this).parent().find('[name="activities[' + activity + '][period][' + year + '][begin]"]').val(arr_m[ui.values[0]][0]);
                                        $(this).parent().find('[name="activities[' + activity + '][period][' + year + '][end]"]').val(arr_m[ui.values[1]][0]);
                                        $('[class$="-' + year + '"]').removeAttr('style');
                                        $('.focus-' + arr_m[ui.values[0]][0] + '-' + year + ',.focus-' + arr_m[ui.values[1]][0] + '-' + year).css('background','#a3e7ee');
                                    }
                                });
                            }
                        }
                    });
                }
            };

            calculateTotalActivity = function(){
                var element, result;

                // Re-calculate total budget by activity
                $.each($('table#activity tbody tr'), function(id, tr){
                    result = 0;
                    element = $(tr).find('td[data-year] input');
                    $.each(element, function(idx, obj){
                        result = result + parseFloat($(obj).val());
                        //console.log(result);
                    });

                    $(tr).find('input[name^="total"').val(result);
                    $(tr).find('label[for^="total"').text(parseFloat(result).toFixed(4));
                });
            }

            // Initial on load page
            callTablePlan();
            // $('table#activity td:last-child').attr('display', 'none');
            $.each(activities, function(idx, activity){
                if (activity['selected'] == 1)
                {
                    // console.log('trigger: ' + activity['code']);
                    $('table#table-plan tr[data-activity="' + activity['code'] + '"] input[id^="t-plan"]').trigger('click');
                }
            });
        });
        
        function initMap(t="map"){
           var map = new ol.Map({
               layers: [
                   new ol.layer.Tile({
                       source: new ol.source.OSM(),
                   }),
               ],
               controls: ol.control.defaults({
                   attributionOptions: /** @type {olx.control.AttributionOptions} */ ({
                       collapsible: false,
                   }),
               }),
               target: t,
               view: new ol.View({
                   center: ol.proj.fromLonLat([100, 13]),
                   zoom: 7,
               }),
           });
           
           reloadMap = function() {
               map.updateSize();
           };
        }
        initMap();
    </script>
@endsection
