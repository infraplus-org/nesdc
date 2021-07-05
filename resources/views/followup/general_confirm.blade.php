@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('Content/Assets/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('Content/Assets/plugins/ol-v6.5.0-dist/ol.css') }}">
    <style>
        .btn-sm.btn-simple {
            margin-top: 0;
            margin-bottom: 0;
        }
    </style>
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

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="body"> 
                            <form method="POST" action="{{ url('followup/general/save') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="project_id" value="{{ $request->project_id }}">
                            <input type="hidden" name="project_desc" value="{{ $request->project_desc }}">
                            <input type="hidden" name="current_project_desc" value="{{ $request->current_project_desc }}">
                            <input type="hidden" name="project_expansion" value="{{ isset($request->project_expansion) ? $request->project_expansion : '' }}">
                            <input type="hidden" name="expansion_code" value="{{ $request->expansion_code }}">
                            <p class="h5">{{ $request->project_desc }}</p>
                            <div class="row">
                                <label for="division" class="col-sm-3 col-form-label"><strong>หน่วยงาน</strong></label>
                                <div class="col-sm-9 col-form-label">
                                    <input type="hidden" name="division_code" value="{{ isset($request->division_code) ? $request->division_code : '' }}">
                                    <label>{{ isset($division->description) ? $division->description : '' }}</label>
                                </div>
                            </div>
                            <div class="row">
                                <label for="operating_duration" class="col-sm-3 col-form-label"><strong>ระยะเวลาดำเนินการ (ตาม มติ ครม.)</strong></label>
                                <div class="col-sm-9 col-form-label">
                                    <input type="hidden" id="setdate" value="{{ substr($request->date_start, -4) . ',' . substr($request->date_end, -4) }}">
                                    <input type="hidden" name="date_start" value="{{ $request->date_start }}">
                                    <input type="hidden" name="date_end" value="{{ $request->date_end }}">
                                    <label>{{ $request->date_start . ' - ' . $request->date_end }}</label>
                                </div>
                                <input type="hidden" name="document_path" value="{{ $document_path }}">
                                <input type="hidden" name="document_name" value="{{ $document_name }}">
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label"><strong>พื้นที่การดำเนินการ</strong></label>
                                <div class="col-sm-3 col-form-label">
                                    <label>&nbsp;</label>
                                </div>
                            </div>
                            <div class="row">
                                <label for="area_level" class="col-sm-3 col-form-label"><strong>ระดับพื้นที่การดำเนินการ</strong></label>
                                <div class="col-sm-3 col-form-label">
                                    <input type="hidden" name="area_level_code" value="{{ $request->area_level_code }}">
                                    <label>{{ $area_level->description }}</label>
                                </div>
                                <label for="areas" class="col-sm-3 col-form-label"><strong>พื้นที่ดำเนินการ</strong></label>
                                <div class="col-sm-3 col-form-label">
                                    @foreach ($request->areas as $area)
                                        <input type="hidden" name="areas[]" value="{{ $area }}">
                                        <label class="btn btn-simple btn-warning btn-round align-self-center tag-prv btn-sm">{{ $area }}</label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="area_detail" class="col-sm-3 col-form-label"><strong>รายละเอียดพื้นที่ดำเนินการ</strong></label>
                                <div class="col-sm-9 col-form-label">
                                    <input type="hidden" name="area_detail" value="{{ $request->area_detail }}">
                                    <label>{{ $request->area_detail }}</label>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div id="map"></div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="investment_source" class="col-sm-3 col-form-label"><strong>เงินลงทุนและแหล่งเงินทุน</strong></label>
                                <div class="col-sm-9 col-form-label">
                                    <input type="hidden" name="actual_all" value="{{ $request->actual_all }}">
                                    <label>{{ number_format($request->actual_all, 2) }} ล้านบาท</label>
                                </div>
                            </div>
                            <div>
                                <input type="hidden" name="included_vat" value="{{ isset($request->included_vat) ? $request->included_vat : 0 }}">
                                <input type="hidden" name="investment_type" value="{{ $request->investment_type }}">
                                <table class="table table-sm table-bordered col-sm-6 top-0 start-50 translate-middle">
                                    <thead>
                                        <tr class="table-primary text-center">
                                            <th>แหล่งเงินทุน</th>
                                            <th>วงเงินลงทุน (ล้านบาท)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $total_actual = 0 @endphp
                                        @foreach ($request->investments as $idx => $investment)
                                            @php if ($investment['actual'] == '') continue @endphp
                                            @php $total_actual += $investment['actual'] @endphp
                                            <tr>
                                                <input type="hidden" name="investments[{{ $idx }}][actual]" value="{{ $investment['actual'] }}">
                                                <td>{{ $investment['description'] }}</td>
                                                <td class="text-center">{{ number_format($investment['actual'], 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-secondary">
                                            <th>รวมงบประมาณ</th>
                                            <th class="text-center">{{ number_format($total_actual, 2) }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="row mb-3">
                                <label for="project_plan" class="col-sm-12 col-form-label"><strong>แผนการดำเนินโครงการ</strong></label>
                                <div class="body display-6 table-responsive">
                                    <table id="activity" class="table table-bordered table-sm f-9">
                                        <thead class="table-primary">
                                            <tr class="text-center head-list">
                                                <th class="align-middle w-px-420" rowspan="2">รายการ</th>
                                                <!-- auto generate [TH] FROM select date_start, date_end and submit button ยืนยันข้อมูล-->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $keys = array_keys($request->activities); @endphp
                                            @foreach ($request->activities as $idx => $activity)
                                                @php $next_key = next($keys); @endphp
                                                @php if (empty($activity['sub_activity_desc']) && ! isset($activity['selected'])) continue; @endphp

                                                @if ($idx == "18001" || strpos($idx, '_') === false)
                                                <tr class="box-plan-{{ $loop->iteration }}" data-activity="{{ $activity['activity_code'] }}">
                                                    <input type="hidden" name="activities[{{ $activity['activity_code'] }}][activity_code]" value="{{ $activity['activity_code'] }}">
                                                    <input type="hidden" name="activities[{{ $activity['activity_code'] }}][sub_activity_desc]" value="">
                                                    <input type="hidden" name="activities[{{ $activity['activity_code'] }}][selected]" value="{{ isset($activity['selected']) ? $activity['selected'] : 0 }}">
                                                    <td class="box-plan-header text-nowrap mb-0">
                                                @endif
                                                @if (isset($activity['sub_activity_desc']))
                                                    <input type="hidden" name="activities[{{ $idx }}][activity_code]" value="{{ $activity['activity_code'] }}">
                                                    <input type="hidden" name="activities[{{ $idx }}][sub_activity_desc]" value="{{ $activity['sub_activity_desc'] }}">
                                                    <div>
                                                        <label>{{ '- ' . $activity['sub_activity_desc'] }}</label>
                                                    </div>
                                                @else
                                                    <div>
                                                        <label>{{ $activities[array_search_value($activities, $activity['activity_code'], 'code')]->description }}</label>
                                                    </div>
                                                @endif
                                                @if (strpos($next_key, '_') === false)
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
                                    <table id="table-inv" class="table table-bordered table-sm f-9">
                                        <thead class="table-primary text-center">
                                            <tr class="header-inv">
                                                <th class="align-middle w-px-420" rowspan="2">รายการกิจกรรม</th>
                                                <th colspan="{{ substr($request->date_end, -4) - substr($request->date_start, -4) + 2 }}">วงเงินลงทุน (ล้านบาท)</th>
                                            </tr>
                                            <tr>
                                                @foreach ($request->activities as $idx => $activity)
                                                    @if ( ! isset($activity['period']))
                                                        @php break; @endphp
                                                    @endif

                                                    @foreach ($activity['period'] as $year => $period)
                                                        <th>{{ $year }}</th>
                                                    @endforeach
                                                    @php break; @endphp
                                                @endforeach
                                                <th>รวมงบประมาณ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($request->activities as $idx => $activity)
                                                @php if ( ! isset($activity['selected'])) continue; @endphp

                                                <tr>
                                                    <td>{{ $activities[array_search_value($activities, $activity['activity_code'], 'code')]->description }}</td>
                                                    @php $total = 0 @endphp
                                                    @foreach ($activity['period'] as $year => $period)
                                                        <input type="hidden" name="activities[{{ $idx }}][period][{{ $year }}][actual]" value="{{ $period['actual'] }}">
                                                        <td class="text-right">{{ empty($period['actual']) ? '' : number_format($period['actual'], 2) }}</td>
                                                        @php $total += $period['actual'] @endphp
                                                    @endforeach
                                                    <td class="text-right">{{ number_format($total, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="foot-inv">
                                                <th>รวมงบประมาณ</th>
                                                @php $total = 0 @endphp
                                                @foreach ($request->activities as $idx => $activity)
                                                    @if ( ! isset($activity['period']))
                                                        @php break; @endphp
                                                    @endif

                                                    @foreach ($activity['period'] as $year => $period)
                                                        <th class="text-right">{{ number_format($sum = array_sum(data_get($request->activities, "*.period.{$year}.actual")), 2) }}</th>
                                                        @php $total += $sum @endphp
                                                    @endforeach
                                                    @php break; @endphp
                                                @endforeach
                                                <td class="text-right">{{ number_format($total, 2) }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <div class="col-sm-12 text-right">
                                <button type="submit" class="btn btn-secondary btn-round" id="btnBack"><i class="zmdi zmdi-hc zmdi-long-arrow-left"></i> แก้ไขข้อมูล</button>
                                <button type="submit" class="btn btn-primary btn-round"><i class="zmdi zmdi-save"></i> บันทึก</button>
                            </div> 
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="{{ asset('Content/Assets/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('Content/Assets/plugins/ol-v6.5.0-dist/ol.js') }}"></script>
@endsection

@section('jsscript')
    <script>
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

            var activities = JSON.parse('@php echo json_encode($request->activities) @endphp')
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
                    
                    for (i=len[0]; i<=len[1]; i++)
                    {
                        $.each(arr_m,function(k, v){
                            $('.tr-m-mini').append('<th class="focus-'+v[0]+'-'+i+'">'+v[1]+'</th>');
                        });
                    }

                    var index = 1;
                    var obj = $('table#activity tbody tr');
                    $.each(obj, function(idx, activity){
                        var activity_code = $(activity).data('activity');
                        var objSlider, begin_year, end_year;
                        // var obj = $('table#activity tbody tr:nth-child(' + index + ')')
                        for (i=len[0]; i<=len[1]; i++)
                        {
                            $(this).append('<td data-plan="plan' + activity_code + '" data-year="' + i + '" class="px-2 child-range-year align-middle" colspan="12">'+
                                '<input type="hidden" name="activities[' + activity_code + '][period][' + i + '][begin]" value="' + (activities[activity_code]['period'][i]['begin'] && typeof activities[activity_code]['period'][i]['begin'] !== 'undefined' ? activities[activity_code]['period'][i]['begin'] : "") + '">'+
                                '<input type="hidden" name="activities[' + activity_code + '][period][' + i + '][end]" value="' + (activities[activity_code]['period'][i]['end'] && typeof activities[activity_code]['period'][i]['end'] !== 'undefined'  ? activities[activity_code]['period'][i]['end'] : "") + '">'+
                                '<div class="slider-range"></div>'+
                            '</td>');
                            // console.log(activity_code + ':' + i + ':' + activities[activity_code]['period'][i]['begin']);

                            // slider-range in table follow in month
                            objSlider = $('td[data-plan="plan' + activity_code + '"][data-year="' + i + '"] > .slider-range');
                            begin_year = objSlider.parent().find('input[name$="[begin]"]').val();
                            end_year = objSlider.parent().find('input[name$="[end]"]').val();
                            if (begin_year > 0 && end_year > 0)
                            {
                                slider_val = [ arr_m.findIndex(x => x[0] == begin_year), arr_m.findIndex(x => x[0] == end_year) ];

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

            // กดปุ่ม "แก้ไขข้อมูล"
            $(document).on('click', 'button#btnBack', function(e){
                $(this).closest('form').attr('action', '{{ url("followup/" . $request->project_id . "/general") }}');
                $(this).closest('form').append('<input type="hidden" name="rollback" value="1">');
            })
        });
    </script>
@endsection
