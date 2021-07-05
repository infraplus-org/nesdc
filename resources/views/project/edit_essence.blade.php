<div class="card border border-info">
    <div class="header pb-0">
        <h2><strong>วัตถุประสงค์ (ถ้ามี)</strong></h2>
    </div>
    <div class="body display-6">
        <textarea name="objective" class="form-control" placeholder="วัตถุประสงค์ (ถ้ามี)" rows="5">{{ $project->objective }}</textarea>
    </div>
</div>
{{-- วัตถุประสงค์ --}}

<div class="card border border-info">
    <div class="header pb-0">
        <h2><strong>เป้าหมาย (ถ้ามี)</strong></h2>
    </div>
    <div class="body display-6">
        <textarea name="goal" class="form-control" placeholder="เป้าหมาย (ถ้ามี)" rows="5">{{ $project->goal }}</textarea>
    </div>  
</div>
{{-- เป้าหมาย --}}

<div class="card border border-info">
    <div class="header pb-0">
        <h2><strong>พื้นที่ดำเนินการ</strong></h2>
    </div>
    <div class="body display-6">
        <label for="">ระดับพื้นที่การดำเนินการ</label>
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
            @foreach ($arealevels as $arealevel)
                <label class="btn btn-info btn-round align-self-center btn-sm">
                    <input type="radio" name="area_level_code" id="opt1" autocomplete="off" value="{{ $arealevel->code }}" {{ ($project->area_level_code == $arealevel->code) ? 'checked' : '' }}> {{ $arealevel->description }}
                </label>
            @endforeach
        </div>
        <div class="row mt-4">
            <div class="col-sm-6">
                <div class="form-group mt-3">
                    <label for="">พื้นที่การดำเนินการ</label>
                    <span>
                        @php $areas = Str::of($project->area)->split('/;/'); @endphp
                        @foreach ($areas as $area)
                            @if ( ! is_null($area) && $area != '')
                                <label class="btn btn-simple btn-warning btn-round align-self-center tag-prv btn-sm">{{ $area }}
                                    <input type="hidden" name="areas[]" value="{{ $area }}">
                                    <i class="zmdi zmdi-close-circle"></i>
                                </label>
                            @endif
                        @endforeach
                        <select name="province" id="prv" class="form-control show-tick show-menu-arrow" data-style="btn-round btn-warning btn-sm text-white" data-width="fit" data-live-search="true">
                            <option data-icon="zmdi zmdi-plus-circle" value=""> เพิ่มจังหวัด </option>
                            @foreach ($provinces as $province)
                                <option value="{{ $province->description }}">{{ $province->description }}</option>
                            @endforeach
                        </select>
                    </span>
                </div>
                <div class="form-group mt-3">
                    <label for="">รายละเอียดพื้นที่การดำเนินการ</label>
                    <textarea name="area_detail" class="form-control" placeholder="รายละเอียดพื้นที่การดำเนินการ" rows="5">{{ $project->area_detail }}</textarea>
                </div>
            </div>
            <div class="col-sm-6">
                <div id="map"></div>
            </div>
        </div>
    </div>
</div>
{{-- พื้นที่ดำเนินการ --}}

<div class="card border border-info">
    <div class="header pb-0">
        <h2><strong>เงินลงทุนและแหล่งเงินทุน</strong></h2>
    </div>
    <div class="body display-6">
        <div class="row mb-2">
            <div class="col-sm-12 form-row">
                <div class="col-sm-3 col-lg-2 form-control-label text-sm-right align-self-center">
                    <label class="font-weight-bold">กรอบการลงทุน ทั้งหมด</label>
                </div>
                <div class="col-sm-9 col-lg-8">
                    <div class="form-group d-inline-flex">
                        <input type="number" name="budget_total" class="form-control text-right" placeholder="0" value="{{ $project->budget }}">
                        <label class="text-nowrap px-2 align-self-center mb-0">ล้านบาท</label>
                        <div class="checkbox text-nowrap mb-0 align-self-center">
                            <input id="checkbox4" type="checkbox" name="included_vat" {{ ($investment_header->included_vat == 1) ? 'checked=""' : '' }}>
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
                    <div class="form-group d-inline-flex">
                        <input type="text" name="investment_type" class="form-control" placeholder="รูปแบบการลงทุน" value="{{ $investment_header->investment_type }}">
                    </div>
                </div>
            </div> 
            <div class="col-sm-12 form-row" id="table-budget">
                <div class="col-sm-2 form-control-label text-sm-right">
                    <label class="font-weight-bold">แหล่งเงินลงทุน</label>
                </div>
                <div class="col-sm-8 form-row no-gutters">
                    <div class="col-sm-12">
                        @foreach ($investments as $detail)
                            <div class="text-nowwrap row mb-2">
                                <div class="col-sm-3">
                                    <label class="px-2 align-self-center mb-0">{{ $detail->fund_desc }}</label>
                                </div>
                                <div class="col-sm-3">
                                    <label class="px-2 align-self-center mb-0">วงเงิน</label>
                                </div>
                                <div class="col-sm-5 d-flex">
                                    <input type="number" name="investments[{{ $detail->fund_code }}][budget]" class="form-control text-right border-secondary col-6" placeholder="-" value="{{ number_format($detail->fund_value, 4) }}">
                                    <label class="text-nowrap align-self-center mb-0">&nbsp;ล้านบาท</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-sm-12">
                        <div class="text-nowwrap row mb-2">
                            <div class="col-sm-3">
                                <label class="text-nowrap px-2 align-self-center mb-0">ระบุ</label>
                            </div>
                            <div class="col-sm-9 d-flex">
                                <input type="text" name="budget_others_desc" class="form-control border-secondary" placeholder="-" value="{{ $investment_header->remark }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- เงินลงทุนและแหล่งเงินลงทุน --}}

<div class="card border border-info">
    <div class="header pb-0">
        <h2><strong>แผนการดำเนินงาน</strong></h2>
    </div>
    <div class="body display-6 table-responsive">
        <div class="row mt-2">
            <div class="col-sm-6">
                <div class="col-sm-2 form-control-label text-sm-right align-self-center">
                    <label class="font-weight-bold">เริ่มต้นแผน</label>
                </div>
                <div class="col-sm-10 border">
                    <div class="input-group px-1 mb-0">
                        <label class="d-flex align-self-center">วันที่</label>
                        <select name="begin_day" id="p_sbegin_daytart_day"class="form-control show-tick" data-style="btn-round btn-secondary btn-simple btn-sm text-center" data-width="fit">
                            <option value="">--วันที่--</option>
                            @for ($i=1; $i<=31; $i++)
                                <option value="{{ $i }}" {{ $i == $project->plan_begin_day ? 'selected="selected"' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                        <label class="d-flex align-self-center">เดือน</label>
                        <select name="begin_month" id="begin_month"class="form-control show-tick" data-style="btn-round btn-secondary btn-sm  btn-simple  text-center" data-width="fit">
                            <option value="">--เดือน--</option>
                            @php $months = config('custom.data_thai_months') @endphp
                            @foreach ($months as $i => $month)
                                <option value="{{ $i }}" {{ $i == $project->plan_begin_month ? 'selected="selected"' : '' }}>{{ $month }}</option>
                            @endforeach
                        </select>
                        <label class="d-flex align-self-center">ปี <i class="required-field">*</i></label>
                        <select name="begin_year" id="begin_year"class="form-control show-tick" data-style="btn-round btn-secondary btn-simple btn-sm text-center" data-width="fit" required>
                            <option value="">--ปี--</option>
                            @php $year = date('Y') + 543 @endphp
                            @for ($i=2557; $i<$year+7; $i++)
                                <option value="{{ $i }}" {{ ((empty($project->plan_begin_year) && $i == $year) || $i == $project->plan_begin_year) ? 'selected="selected"' : ''}}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="col-sm-2 form-control-label text-sm-right align-self-center">
                    <label class="font-weight-bold">สิ้นสุดแผน</label>
                </div>
                <div class="col-sm-10 border">
                    <div class="input-group px-1 mb-0">
                        <label class="d-flex align-self-center">วันที่</label>
                        <select name="end_day" id="end_day"class="form-control show-tick" data-style="btn-round btn-warning btn-simple btn-sm text-center " data-width="fit">
                            <option value="">--วันที่--</option>
                            @for ($i=1; $i<=31; $i++)
                                <option value="{{ $i }}" {{ $i == $project->plan_end_day ? 'selected="selected"' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                        <label class="d-flex align-self-center">เดือน</label>
                        <select name="end_month" id="end_month"class="form-control show-tick" data-style="btn-round btn-warning btn-sm btn-simple text-center"  data-width="fit">
                            <option value="">--เดือน--</option>
                            @foreach ($months as $i => $month)
                                <option value="{{ $i }}" {{ $i == $project->plan_end_month ? 'selected="selected"' : '' }}>{{ $month }}</option>
                            @endforeach
                        </select>
                        <label class="d-flex align-self-center">ปี <i class="required-field">*</i></label>
                        <select name="end_year" id="end_year"class="form-control show-tick" data-style="btn-round btn-warning btn-simple btn-sm text-center"  data-width="fit" data-dropup-auto="false" required>
                            <option value="">--ปี--</option>
                            @php $year = date('Y') + 543 @endphp
                            @for ($i=2557; $i<$year+7; $i++)
                                <option value="{{ $i }}" {{ ((empty($project->plan_end_year) && $i == $year) || $i == $project->plan_end_year) ? 'selected="selected"' : ''}}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
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
{{-- แผนการดำเนินงาน --}}

<div class="card border border-info">
    <div class="header pb-0">
        <h2><strong>กรอบเงินลงทุนกิจกรรม</strong></h2>
    </div>
    <div class="body display-6">
        <div class="row">
            <div class="col-sm-12 form-row">
                <div class="table-responsive">
                    <p class="text-right w-100">หน่วย: ล้านบาท</p>
                    <table id="table-inv" class="table table-bordered table-sm f-9">
                        <thead class="text-center">
                            <tr class="header-inv">
                                <th>รายการกิจกรรม</th>
                                {{-- Auto generate from select year --}}
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Auto genarate from checked in plan activity --}}
                        </tbody>
                        <tfoot>
                            <tr class="foot-inv">
                                <th>รวมงบประมาณ</th>
                                {{-- Auto generate from select year --}}
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div> 
        </div>
    </div>
</div>
{{-- กรอบเงินลงทุนกิจกรรม --}}

<div class="card border border-info">
    <div class="header pb-0">
        <h2><strong>ผลตอบแทนการลงทุนโครงการ</strong></h2>
    </div>
    <div class="body display-6">
        <h6>ผลตอบแทนทางการเงิน</h6>
        @foreach ($finances as $finance)
            <input type="hidden" name="returns[finances][{{ $loop->index }}][type]" value="{{ $finance->type }}">
            <div class="text-nowwrap row mb-2">
                <div class="col-sm-6 row">
                    <div class="col-sm-4">
                        <input type="hidden" name="returns[finances][{{ $loop->index }}][description]" value="{{ $finance->description }}">
                        <label class="text-nowrap px-2 align-self-center mb-0">{{ $finance->description }}</label>
                    </div>
                    <div class="col-sm-6 d-flex">
                        <input type="number" name="returns[finances][{{ $loop->index }}][value]" class="form-control text-right border-secondary" value="{{ $finance->value }}">
                        <input type="hidden" name="returns[finances][{{ $loop->index }}][unit]" value="{{ $finance->unit }}">
                    </div>
                    <div class="col-sm-2 d-flex">
                        <label class="text-nowrap px-2 align-self-center w-px-100">{{ $finance->unit }}</label>
                    </div>
                </div>
                <div class="col-sm-6 row">
                    <div class="col-sm-3">
                        <label class="text-nowrap px-2 align-self-center mb-0">หมายเหตุ</label>
                    </div>
                    <div class="col-sm-9 d-flex">
                        <input type="text" name="returns[finances][{{ $loop->index }}][remark]" class="form-control border-secondary" value="{{ $finance->remark }}">
                    </div>
                </div>
            </div>
        @endforeach
        <button type="button" class="btn btn-secondary btn-sm text-nowrap project-return" data-type="Finance">
            <i class="zmdi zmdi-plus"></i> เพิ่มรายการ
        </button>
        {{-- End ผลตอบแทนทางการเงิน --}}

        <h6 class="mt-3">ผลตอบแทนทางเศรษฐกิจ</h6>
        @foreach ($economics as $economic)
            <input type="hidden" name="returns[economics][{{ $loop->index }}][type]" value="{{ $economic->type }}">
            <div class="text-nowwrap row mb-2">
                <div class="col-sm-6 row">
                    <div class="col-sm-4">
                        <input type="hidden" name="returns[economics][{{ $loop->index }}][description]" value="{{ $economic->description }}">
                        <label class="text-nowrap px-2 align-self-center mb-0">{{ $economic->description }}</label>
                    </div>
                    <div class="col-sm-6">
                        <input type="number" name="returns[economics][{{ $loop->index }}][value]" step="0.01" class="form-control text-right border-secondary" value="{{ $economic->value }}">
                        <input type="hidden" name="returns[economics][{{ $loop->index }}][unit]" value="{{ $economic->unit }}">
                    </div>
                    <div class="col-sm-2">
                        <label class="text-nowrap px-2 align-self-center w-px-100">{{ $economic->unit }}</label>
                    </div>
                </div>
                <div class="col-sm-6 row">
                    <div class="col-sm-3">
                        <label class="text-nowrap px-2 align-self-center mb-0">หมายเหตุ</label>
                    </div>
                    <div class="col-sm-9 d-flex">
                        <input type="text" name="returns[economics][{{ $loop->index }}][remark]" class="form-control border-secondary" value="{{ $economic->remark }}">
                    </div>
                </div>
            </div>
        @endforeach
        <button type="button" class="btn btn-secondary btn-sm text-nowrap project-return" data-type="Economic">
            <i class="zmdi zmdi-plus"></i> เพิ่มรายการ
        </button>
        {{-- End ผลตอบแทนทางการเงิน --}}
    </div>
</div>
{{-- ผลตอบแทนการลงทุนโครงการ --}}

<div class="w-100">
    <button onclick="activeTab('tab4')" type="button" class="btn btn-secondary d-flex float-right">
        <span class="d-flex align-self-center mr-2"> หัวข้อถ้ดไป</span>
        <i class="zmdi zmdi-hc-2x zmdi-long-arrow-right"></i>  
    </button>
    <button onclick="activeTab('tab2')" type="button" class="btn btn-secondary d-flex float-right">
        <i class="zmdi zmdi-hc-2x zmdi-long-arrow-left"></i>
        <span class="d-flex align-self-center ml-2"> ย้อนกลับ</span> 
    </button>
</div>

@section('jsscript')
    @parent
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
            
            $('#prv').selectpicker();

            $('[href="#tab3"]').on('click',function(){
                setTimeout(function(){
                    reloadMap();
                },500);
            });

            // $('#projects-document-type a').on('click', function(){
            //     $('#projects-document-type input[name="doc_type"]').val($(this).data('code'));
            // });

            // เพิ่มพื้นที่ดำเนินงาน
            $('#prv').change(function(){
                var v = $(this).val();
                $(this).val('').selectpicker('refresh');
                $(this).parents('span').prepend('<label class="btn btn-simple btn-warning btn-round align-self-center btn-sm tag-prv">' + v + '<input type="hidden" name="areas[]"value="'+ v +'"> <i class="zmdi zmdi-close-circle"></i></label>');
            });

            // $('#add_plan').click(function(){
            //     var l = $('#tb_plan tr.chlid-plan').length;
            //     $('#tb_plan').append('<tr class="chlid-plan text-center">'+
            //         '<td><input type="text" name="plans[' + (l + 1) + '][description]" class="form-control text-center" value="แผน ' + (l + 1) + '" required></td>'+
            //         '<td><input type="text" name="plans[' + (l + 1) + '][duration]" class="form-control text-center"></td>'+
            //     '</tr>');
            // });

            $('[data-toggle="tooltip"]').tooltip();

            $(document).on('keyup focusout', '#table-budget input[type="number"]', function(){
                var element, result;
                var parent = $(this).closest('div[data-parent]').attr('data-parent');

                // Re-calculate budget
                if ($(this).closest('div[data-parent]').is('[data-parent]') === true)
                {
                    result = 0;
                    element = $('#table-budget div[data-parent="' + parent + '"] input');
                    $.each(element, function(idx, obj){
                        result = result + parseFloat($(obj).val());
                        //console.log(result);
                    });

                    $('#table-budget div[data-budget="' + parent + '"] input').val(result);
                }

                // Re-calculate summary of budget
                // result = 0;
                // $.each($('#table-budget div[data-budget]:not([data-parent]) input[type="number"]'), function(idx, obj){
                //     result = result + parseFloat($(obj).val());
                // });
                // $('input[name="budget_total"]').val(result);
            });

            var activities = JSON.parse('@php echo json_encode($activities) @endphp')
            createThead = function(thead){
                $('.' + thead).find('.new-header').remove();
                $('#table-inv tfoot tr').find('.new-header').remove();
                let len = [$("#begin_year").val(), $("#end_year").val()];
                // console.log(len);
            
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

            callTableInv = function(){
                var begin_year = $('#begin_year').val();
                var end_year = $('#end_year').val();

                $('.head-list').find('.new-header').remove();
                $('.tr-m-mini,.child-range-year').remove();

                if(!isNaN(begin_year) && !isNaN(end_year)){
                    {{-- Header --}}
                    for(i=begin_year;i<=end_year;i++){
                        $('tr.head-list').append('<th class="new-header">' + parseInt(i) + '</th>');
                        //console.log(i);
                    }
                    $('tr.head-list').append('<th class="new-header">รวมงบประมาณ</th>');
                    $('tr.head-list').append('<th class="new-header"></th>');
                    //$('tr.head-list').append('<tr class="tr-m-mini"><td></td></tr>');
                    
                    $.each(activities, function(idx, activity){
                        var obj = $('table#activity tbody tr:nth-child(' + (idx + 1) + ')')
                        for (i=begin_year; i<=end_year; i++)
                        {
                            obj.append('<td data-plan="plan" data-year="' + i + '" class="px-2 child-range-year align-middle">'+
                                '<input type="number" step="0.0001" name="activities[' + activity['code'] + (activity['sub_activity_desc'] !== null ? '_' + idx : '') + '][period][' + i + '][budget]" class="form-control border-secondary w-px-100" data-name="valact3_1[]" value="' + (!isNaN(activity[i]) ? activity[i] : 0) + '">' +
                            '</td>');
                        }

                        obj.append('<td class="child-range-year align-middle"><input type="number" step="0.0001" name="total[]" data-name="mainact_1_3" class="form-control border-secondary w-px-100" value=""></td>');
                        var subactivity = (obj.is('[data-parent]') === true) ? '<td class="child-range-year"></td>' : '<td class="child-range-year align-middle"><button type="button" class="btn btn-secondary btn-sm text-nowrap sub-activity"><i class="zmdi zmdi-plus"></i> เพิ่มกิจกรรมย่อย</button></td>';
                        obj.append(subactivity);
                    })

                    //$('table#activity tbody tr').append('<td class="child-range-year align-middle"><input type="number" step="0.01" name="total[]" data-name="mainact_1_3" class="form-control border-secondary w-px-100" value=""></td>');
                    //$('table#activity tbody tr:not([data-parent])').append('<td class="child-range-year align-middle"><button type="button" class="btn btn-secondary btn-sm text-nowrap sub-activity"><i class="zmdi zmdi-plus"></i> เพิ่มกิจกรรมย่อย</button></td>');

                    // Re-calculate total budget by activity
                    calculateTotalActivity();
                }
            };

            // แผนการดำเนินงาน - กด checkbox
            $(document).on('click','[id^="t-plan"]',function(){
                var pr = $(this).closest('tr');
                var p = pr.attr('class');
                var label = $.trim($(this).next("label").text());
    
                if($('[id^="t-plan"]:checked').length === 0){
                    $('.box-inv').hide();
                    //$('.box-inv tbody').remove();
                }

                if($(this).is(":checked")){
                    var len =  createThead('header-inv');
                    pr.find('.btn-sub-activity,.slider-range').show();

                    let childinv= '';
                    var total, val;
                    var obj = $('table#activity tbody tr');
                    $.each(activities, function(idx, activity){
                        // console.log(pr.data('activity') + '=' + activity['code'])
                        if (pr.data('activity') != activity['code']) return;
                        if (activity['sub_activity_desc'] != null) return;      // Ignore sub activity record

                        total = 0
                        for (i=len[0]; i<=len[1]; i++)
                        {
                            val = ($.isNumeric(activity[i]) ? activity[i] : '')
                            total = total + ($.isNumeric(activity[i]) ? parseFloat(activity[i]) : 0);
                            childinv += '<td data-period="' + i + '"><input type="number" step="0.01" name="activities[' + pr.data('activity') + '][period][' + i + '][actual]" value="' + parseFloat(val).toFixed(4) + '" class="form-control text-right" placeholder="งบประมาณ"></td>';
                        }

                        childinv += '<td><input type="number" step="0.01" value="' + parseFloat(total).toFixed(4) + '" class="form-control text-right" placeholder="รวมงบประมาณ"></td>';
                    });
                            
                    $('table#table-inv tbody').append(
                        `<tr class="${p}" data-activity="${pr.data('activity')}">
                            <td>${label}</td>
                            ${childinv}
                        </tr>`
                    );
                    
                    $('.box-inv').show();
                    calculateTableInv();
                }
                else{
                    $('table#table-inv tbody').find('tr.'+p).remove();
                    pr.find('.btn-sub-activity,.slider-range').hide();
                } 
            });

            // แผนการดำเนินงาน - Click สำหรับสร้าง slider
            $(document).on('click', 'td.td-slider-range:not(.slider-created)', function(e){
                if ($(this).closest('tr').find('[type="checkbox"]:checked').length == 0)
                {
                    e.preventDefault();
                    return false;
                }

                $(this).find('.slider-range').slider({
                    range: true,
                    min: 0,
                    max: 11,
                    step: 1,
                    values: [ 0, 11 ],
                    // values: slider_val,
                    create: function(event, ui){
                        $(this).closest('td').addClass('slider-created');
                        $(this).parent().find('[name$="[begin]"]').val(10);
                        $(this).parent().find('[name$="[end]"]').val(9);
                    },
                    slide: function(event, ui) { 
                        var year = $(this).parent().data('year');
                        var activity = $(this).closest('tr').data('activity');
                        $(this).parent().find('[name$="[begin]"]').val(arr_m[ui.values[0]][0]);
                        $(this).parent().find('[name$="[end]"]').val(arr_m[ui.values[1]][0]);
                        $('[class$="-' + year + '"]').removeAttr('style');
                        $('.focus-' + arr_m[ui.values[0]][0] + '-' + year + ',.focus-' + arr_m[ui.values[1]][0] + '-' + year).css('background','#a3e7ee');
                    }
                });
            });

            // แผนการดำเนินงาน - Double click เพื่อยกเลิกการสร้าง slider
            $(document).on('dblclick', 'td.slider-created', function(e){
                $(this).find('.slider-range').remove();
                $(this).append('<div class="slider-range"></div>');
                $(this).removeClass('slider-created');
                $(this).find('[name$="[begin]"]').val(null);
                $(this).find('[name$="[end]"]').val(null);
            });

            // แผนการดำเนินงาน - เพิ่มกิจกรรมย่อย
            $(document).on('click', '.btn-sub-activity', function(){
                let len = [$("#begin_year").val(), $("#end_year").val()];
                let begin_year = len[0];
                let end_year = len[1];
                let row = $(this).closest('tr');
                let act = row.data('activity');
                let l = $('table#activity tr[data-activity="' + act + '"], table#activity tr[data-parent="' + act + '"]').length;

                let contentrow;
                contentrow = '<tr class="new-header child-range-year" data-activity="" data-parent="' + act + '">';
                contentrow = contentrow + '<input type="hidden" name="activities[' + act + '_N' + l + '][activity_code]" value="' + act + '">';
                contentrow = contentrow + '<td>';
                contentrow = contentrow + '<i class="zmdi zmdi-delete float-left mt-2 pr-0"></i>';
                contentrow = contentrow + '<input type="text" name="activities[' + act + '_N' + l + '][sub_activity_desc]" class="form-control border-secondary text-right ml-4 col-11" placeholder="กิจกรรมย่อย" required>';
                contentrow = contentrow + '</td>';
                for (i=begin_year; i<=end_year; i++)
                {
                    contentrow = contentrow + '<input type="hidden" name="activities[' + act + '_N' + l + '][period][' + i + '][begin]"></td>';
                    contentrow = contentrow + '<input type="hidden" name="activities[' + act + '_N' + l + '][period][' + i + '][end]"></td>';
                    contentrow = contentrow + '<input type="hidden" name="activities[' + act + '_N' + l + '][period][' + i + '][actual]"></td>';
                    contentrow = contentrow + '<td colspan="12"></td>';
                }
                contentrow = contentrow + '</tr>'; 

                var subactivity = $(this).closest('table').find('tr[data-parent="' + act + '"]:last')
                $(contentrow).insertAfter((subactivity.length > 0) ? subactivity : row);
            });

            // แผนการดำเนินงาน - ลบกิจกรรมย่อย
            $(document).on('click', 'table#table-plan .zmdi-delete', function(){
                $(this).closest('tr').fadeOut(function(){
                    $(this).remove();
                });
            });

            $('#begin_year, #end_year').change(function(){
                callTable();
            });

            calculateTotalActivity = function(){
                var element, result;

                // Re-calculate total budget by activity
                $.each($('table#table-inv tbody tr'), function(id, tr){
                    result = 0;
                    element = $(tr).find('td[data-year] input');
                    $.each(element, function(idx, obj){
                        result = result + parseFloat($(obj).val());
                        //console.log(result);
                    });

                    $(tr).find('input[name^="total"').val(result);
                });
            }
            
            calculateTableInv = function(){
                var total, val;

                // ยอดรวมรายกิจกรรม (summary by row)
                $('#table-inv tbody').find('tr').each(function(idx, row){
                    total = 0;
                    $(row).find('td:not(:last-child) input').each(function(idy, column){
                        val = ($.isNumeric($(column).val())) ? $(column).val() : 0;
                        total = total + parseFloat(val);
                    });

                    // console.log(total);
                    $(row).find('td:last-child input').val(total.toFixed(4));
                });

                // ยอดรวมรายปีงบประมาณ (summary by column)
                $('#table-inv tfoot').find('th > input').each(function(idx, obj){
                    total = 0;
                    $('#table-inv tbody').find('tr').each(function(idy, row){
                        val = ($.isNumeric($(row).find('td:eq(' + (idx + 1) + ') input').val())) ? $(row).find('td:eq(' + (idx + 1) + ') input').val() : 0;
                        total = total + parseFloat(val);
                    });
                    
                    // console.log(total);
                    $(obj).val(total.toFixed(4));
                });
            };

            // กรอบเงินลงทุนกิจกรรม - คำนวณยอดรวม
            $(document).on('keyup', 'table#table-inv input', function(){
                var element, result;
                var parent = $(this).closest('tr').attr('data-parent');
                var year = $(this).closest('td').attr('data-year');

                // Re-calculate main activity if sub activity has been updated
                if ($(this).closest('tr').is('[data-parent]') === true)
                {
                    result = 0;
                    element = $('table#table-inv tr[data-parent="' + parent + '"] td[data-year="' + year + '"] input');
                    $.each(element, function(idx, obj){
                        result = result + parseFloat($(obj).val());
                        //console.log(result);
                    });

                    $('table#table-inv tr[data-activity="' + parent + '"] td[data-year="' + year + '"] input').val(result);
                }

                // Re-calculate total budget by activity
                calculateTotalActivity();
            });
            
            // ผลตอบแทนการลงทุน - เพิ่มรายการ
            $('.project-return').click(function(){
                var row = $(this).closest("div");
                var type = $(this).attr('data-type').toLowerCase();
                var idx = $('input[name^="returns[' + type + 's]"][name$="description]"').length;
                const contentrow = '<div class="text-nowwrap row mb-2 row-return">\
                    <input type="hidden" name="returns[' + type + 's][' + idx + '][type]" value="' + type + '">\
                    <div class="col-sm-6 row">\
                        <div class="col-sm-4">\
                            <i class="zmdi zmdi-delete float-left mt-2 pr-0"></i>\
                            <input type="text" name="returns[' + type + 's][' + idx + '][description]" class="form-control border-secondary px-2 mb-0 w-px-100 col-11" required>\
                            <small class="form-text text-muted">ตัวเลข/ตัวอักษร</small>\
                        </div>\
                        <div class="col-sm-6">\
                            <input type="number" step="0.01" name="returns[' + type + 's][' + idx + '][value]" class="form-control text-right border-secondary" required>\
                            <small class="form-text text-muted">ตัวเลข</small>\
                        </div>\
                        <div class="col-sm-2">\
                            <input type="text" name="returns[' + type + 's][' + idx + '][unit]" class="form-control border-secondary px-2 mb-0 w-px-100">\
                        </div>\
                    </div>\
                    <div class="col-sm-6 row">\
                        <div class="col-sm-3">\
                            <label class="text-nowrap px-2 align-self-center mb-0">หมายเหตุ</label>\
                        </div>\
                        <div class="col-sm-9">\
                            <input type="text" name="returns[' + type + 's][' + idx + '][remark]" class="form-control border-secondary">\
                        </div>\
                    </div>\
                </div>';
                $(contentrow).insertBefore($(this));
            });

            // ผลตอบแทนการลงทุน - ลบรายการ
            $(document).on('click', '.row-return .zmdi-delete', function(){
                $(this).closest('.row-return').fadeOut(function(){
                    $(this).remove();
                });
            });

            // Initial on load page
            callTablePlan();
            // callTableInv();
            $.each(activities, function(idx, activity){
                if (activity['selected'] == 1)
                {
                    // console.log('trigger: ' + activity['code']);
                    $('table#table-plan tr[data-activity="' + activity['code'] + '"] input[id^="t-plan"]').trigger('click');
                }
            });
            calculateTableInv();
        });

        $(document).on('click','.tag-prv i',function(){
            $(this).parent().remove();
        })
        // .on('click keyup','[data-name^="valact"]',function(){/* calculate value from sub activity */
        //     var sumact = 0,
        //         getact = $(this).attr('data-name');
        //     $('[data-name="'+getact+'"]').each(function(){
        //         var v = $(this).val();
        //         sumact+=(v=="" ? 0 : parseFloat(v));
        //     });
        //     var m = (getact.match(/(\d+)_(\d+)+/));
        //     $('[data-name="mainact_'+m[1]+'_'+m[2]+'"]').val(sumact);
        // });
    
        function activeTab(tab){
            $('[href="#'+tab+'"]').click();
        }

        function initMap(t="map"){
            var map = new ol.Map({
                layers: [
                    new ol.layer.Tile({
                       source: new ol.source.OSM(),
                    }),
                ],
                controls: ol.control.defaults({
                    attributionOptions: /** @type {olx.control.AttributionOptions} */ ({
                       collapsible: true,
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
 