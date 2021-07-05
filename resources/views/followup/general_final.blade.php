@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('Content/Assets/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('Content/Assets/plugins/bootstrap-select/css/bootstrap-select.css') }}" />
@endsection

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="body"> 
                <div class="row">
                    <div class="col-md-9">
                        <p class="h5 align-middle m-0">{{ $project->description }}</p>
                        @if (count($expansions) > 1)
                            <div class="row col-md-6 clearfix">
                                <select class="form-control show-tick" id="expansion">
                                    @foreach ($expansions as $data)
                                        <option value="{{ $data->id }}" {{ $data->id == $current_expansion ? 'selected' : '' }}>{{ $data->description_full . ' (' . DateFormatDDMMYYYY($data->created_at) . ')' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-3" style="position: relative;">
                        <form method="POST" action="{{ url('project/followup') }}">
                        @csrf
                        <input type="hidden" name="project_id" value="{{ $project->project_id }}">
                        <input type="hidden" name="current_project_desc" value="{{ $project->description }}">
                        <input type="hidden" name="expansion_code" value="40002">
                        <input type="hidden" name="project_expansion" value="1">
                        <input type="hidden" id="setdate" value="{{ $actual_begin_year . ',' . $actual_end_year }}">
                        <button type="submit" class="btn btn-warning btn-lg float-right"><strong>ขยายสัญญา / ขยายวงเงิน</strong></button>
                        </form>
                    </div>
                </div>
                
                <div class="row">
                    <label for="division" class="col-sm-3 col-form-label"><strong>หน่วยงาน</strong></label>
                    <div class="col-sm-9 col-form-label">
                        <input type="hidden" name="division_code" value="{{ $project->division_code }}">
                        <label>{{ $division->description }}</label>
                    </div>
                </div>
                <div class="row">
                    <label for="operating_duration" class="col-sm-3"><strong>ระยะเวลาดำเนินการ (ตาม มติ ครม.)</strong></label>
                    <div class="col-sm-2">
                        <label>{{ $expansion->begin_date . ' - ' . $expansion->end_date }}</label>
                    </div>
                    @if ( ! empty($document->filename))
                        <div class="col-sm-7">
                            <a href="{{ Storage::url($document->filepath) }}" target="_blank" class="link">
                                <img class="w-2" src="{{ asset('Content/Assets/images/icons/pdf-30.png') }}">
                                {{ $document->filename }}
                            </a>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <label for="investment_source" class="col-sm-3 col-form-label"><strong>เงินลงทุนและแหล่งเงินทุน</strong></label>
                    <div class="col-sm-9 col-form-label">
                        <label>{{ number_format($project->actual, 2) }} ล้านบาท</label>
                    </div>
                </div>
                <div class="row">
                    <div class="body col-sm-12">
                        <table class="table table-sm table-nesdc table-bordered col-sm-6 top-0 start-50 translate-middle">
                            <thead>
                                <tr class="text-center">
                                    <th>แหล่งเงินทุน</th>
                                    <th>วงเงินลงทุน (ล้านบาท)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($investments as $investment)
                                    @php if (is_null($investment->fund_value)) continue @endphp
                                    <tr>
                                        <td>{{ $investment->fund_desc }}</td>
                                        <td class="text-center">{{ number_format($investment->fund_value, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-secondary">
                                    <th>รวมงบประมาณ</th>
                                    <th class="text-center">{{ number_format($project->actual, 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <label for="project_plan" class="col-sm-12 col-form-label"><strong>แผนการดำเนินโครงการ</strong></label>
                    <div class="body display-6 table-responsive">
                        <table id="activity" class="table table-bordered table-sm f-9 table-nesdc">
                            <thead>
                                <tr class="text-center head-list">
                                    <th class="align-middle w-px-420" rowspan="2">รายการ</th>
                                    <!-- auto generate [TH] FROM select date_start, date_end and submit button ยืนยันข้อมูล-->
                                </tr>
                            </thead>
                            <tbody>
                                @php $keys = array_keys((array)$activities); @endphp
                                @foreach ($activities as $idx => $activity)
                                    @php $next_key = next($keys); @endphp
                                    @php if (empty($activity->sub_activity_desc) && $activity->selected == 0) continue; @endphp
                                    @if ($idx == 0 || empty($activity->sub_activity_desc))
                                    <tr class="box-plan-{{ $loop->iteration }}" data-activity="{{ $activity->code }}">
                                        <td class="box-plan-header text-nowrap mb-0">
                                    @endif
                                    @if (isset($activity->sub_activity_desc))
                                        <div>
                                            <label>{{ '- ' . $activity->sub_activity_desc }}</label>
                                        </div>
                                    @else
                                        <div>
                                            <label>{{ $activities[array_search_value($activities, $activity->code, 'code')]->description }}</label>
                                        </div>
                                    @endif
                                    @if (isset($activities[$idx + 1]) && empty($activities[$idx + 1]->sub_activity_desc))
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <label for="project_plan" class="col-sm-12 col-form-label"><strong>กรอบเงินลงทุนรายกิจกรรม</strong></label>
                    <div class="body table-responsive">
                        <table id="table-inv" class="table table-bordered table-sm table-nesdc f-9">
                            <thead class="text-center">
                                <tr class="header-inv">
                                    <th class="align-middle w-px-420" rowspan="2">รายการกิจกรรม</th>
                                    <th colspan="{{ $actual_end_year - $actual_begin_year + 2 }}">วงเงินลงทุน (ล้านบาท)</th>
                                </tr>
                                <tr>
                                    @for ($i=$actual_begin_year; $i<=$actual_end_year; $i++)
                                        <th>{{ $i }}</th>
                                    @endfor
                                    <th>รวมงบประมาณ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($activities as $idx => $activity)
                                    @php if ($activity->selected == 0) continue; @endphp

                                    <tr>
                                        <td>{{ $activities[array_search_value($activities, $activity->code, 'code')]->description }}</td>
                                        @php $total = 0 @endphp
                                        @for ($i=$actual_begin_year; $i<=$actual_end_year; $i++)
                                            <td class="text-right">{{ number_format($activity->{$i}, 2) }}</td>
                                            @php $total += $activity->{$i} @endphp
                                        @endfor
                                        <td class="text-right">{{ number_format($total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="foot-inv">
                                    <th>รวมงบประมาณ</th>
                                    @php $total = 0 @endphp
                                    @for ($i=$actual_begin_year; $i<=$actual_end_year; $i++)
                                        <th class="text-right">{{ number_format($sum = array_sum(data_get($activities, "*.$i")), 2) }}</th>
                                        @php $total += $sum @endphp
                                    @endfor
                                    <td class="text-right">{{ number_format($total, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="col-sm-12 text-right">
                    <form method="POST" action="{{ url('project/followup/delete') }}">
                    @csrf
                    <input type="hidden" name="project_id" value="{{ $project->project_id }}">
                    <button type="submit" class="btn btn-danger btn-round"><i class="zmdi zmdi-delete"></i> ลบข้อมูล</button>
                    </form> 
                </div>
            </div>
        </div>
    </div>
</div>

<form method="POST" action="{{ url('project/followup') }}" id="frm-expansion">
@csrf
<input type="hidden" name="current_project_desc" value="{{ $project->description }}">
<input type="hidden" name="expansion_id" value="">
</form>

@section('js')
    @parent
    <script src="{{ asset('Content/Assets/js/jquery-ui.js') }}"></script>
@endsection

@section('jsscript')
    @parent
    <script>
        $(function(){
            var arr_m = [
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

            var activities = JSON.parse('@php echo json_encode($activities) @endphp')
            createThead = function(thead){
                $('.'+thead).find('.new-header').remove();
                $('#table-inv tfoot tr').find('.new-header').remove();
                let len =  $("#setdate").val().split(',');
            
                // if(!isNaN(len[0]) && !isNaN(len[1])){
                if(len[0] != "" && len[1] != ""){
                    // กรอบเงินลงทุนรายกิจกรรม
                    if(thead == "header-inv")
                    {
                        for(i=len[0];i<=len[1];i++){
                            // console.log(i);
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
                            $('tr.'+thead).append('<th colspan="12" class="new-header">ปีงบประมาณ ' + parseInt(i) + '</th>');
                        }
                    
                        $('tr.'+thead).after('<tr class="tr-m-mini"></tr>');
                    }
                    
                    return len;
                }
            };

            callTable = function(){
                $('.tr-m-mini,.child-range-year').remove();
                $('[id^="t-plan"]').parent().find('button').hide();
                let len =  $("#setdate").val().split(',');
                
                createThead('head-list');

                // if(!isNaN(len[0]) && !isNaN(len[1])){
                if(len[0] != "" && len[1] != ""){
                    var hidden_val, slider_val, period;
                    var content;
                    var ac = {{ count($activities) }};
                    
                    for (i=len[0]; i<=len[1]; i++)
                    {
                        $.each(arr_m,function(k, v){
                            $('.tr-m-mini').append('<th class="focus-'+v[0]+'-'+i+'">'+v[1]+'</th>');
                        });
                    }

                    var index = 1;
                    var obj = $('table#activity tbody tr');
                    $.each(activities, function(idx, activity){
                        // Skip sub activity
                        if (activity['selected'] != 1) return;
                        // console.log(idx + ':' + activity['code']);

                        // var activity_code = $(activity).data('activity');
                        var objSlider, begin_year, end_year;
                        var obj = $('table#activity tbody tr:nth-child(' + index + ')')
                        for (i=len[0]; i<=len[1]; i++)
                        {
                            obj.append('<td data-plan="plan' + activity['code'] + '" data-year="' + i + '" class="px-2 child-range-year align-middle" colspan="12">'+
                                '<input type="hidden" name="activities[' + activity['code'] + '][period][' + i + '][begin]" value="' + activity[i + '_month_begin'] + '">'+
                                '<input type="hidden" name="activities[' + activity['code'] + '][period][' + i + '][end]" value="' + (activity[i + '_month_end'] != null ? activity[i + '_month_end'] : "") + '">'+
                                '<div class="slider-range"></div>'+
                            '</td>');
                            //console.log(activity['code'] + ':' + i + ':' + activity[i + '_month_begin']);

                            // slider-range in table follow in month
                            objSlider = $('td[data-plan="plan' + activity['code'] + '"][data-year="' + i + '"] > .slider-range');
                            begin_year = objSlider.parent().find('input[name$="[begin]"]').val();
                            end_year = objSlider.parent().find('input[name$="[end]"]').val();
                            if (begin_year > 0 && end_year > 0)
                            {
                                slider_val = [ arr_m.findIndex(x => x[0] == begin_year), arr_m.findIndex(x => x[0] == end_year) ];
                                //console.log(slider_val);

                                objSlider.slider({
                                    range: true,
                                    min: 0,
                                    max: 11,
                                    step: 1,
                                    // values: [ 0, 11 ],
                                    values: slider_val
                                });
                                objSlider.slider("disable");
                            }
                        }

                        index = index + 1;
                    });
                }
            };

            // เริ่มต้นโหลด "แผนการดำเนินโครงการ"
            callTable();

            // เปลี่ยน dropdown เพื่อดูข้อมูลการขยายสัญญา/การขยายวงเงิน
            $(document).on('change', '#expansion', function(){
                var expansion_id = $(this).val();
                $('[name="expansion_id"]').val(expansion_id);
                $('#frm-expansion').submit();
            });

            // กดปุ่ม "แก้ไขข้อมูล"
            $(document).on('click', 'button#btnBack', function(e){
                $(this).closest('form').attr('action', '{{ url("project/followup") }}');
                $(this).closest('form').append('<input type="hidden" name="rollback" value="1">');
            })
        });
    </script>
@endsection
