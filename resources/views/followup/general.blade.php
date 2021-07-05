@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('Content/Assets/plugins/ol-v6.5.0-dist/ol.css') }}">
@endsection

<form id="frm-search" method="POST" action="{{ url('followup/general') }}">
@csrf
<input type="hidden" name="current_project_desc" value="">
</form>

<form method="POST" action="{{ url('followup/general/confirm') }}" enctype="multipart/form-data">
@csrf
<input type="hidden" name="project_id" value="{{ $project->project_id }}">
<input type="hidden" name="expansion_code" value="40001">
<div class="card">
    @if (isset($project_expansion) && $project_expansion == 1)
        <div class="row mb-3">
            <div class="col-md-9 margin-top-10">
                <div class="input-group">
                    <div class="input-group-append mb-0">
                        <span class="input-group-text bg-white text-dark">
                            @foreach ($expansions as $data)
                                <div class="radio inlineblock m-r-20 mb-0">
                                    <input type="radio" name="expansion_code" id="expansion{{ $loop->iteration }}" class="with-gap" value="{{ $data->code }}"  {{ (($expansion_code == "" && $loop->index == 0) || $data->code == $expansion_code) ? "checked" : "" }}>&nbsp;
                                    <label for="expansion{{ $loop->iteration }}">{{ $expansion->description }}</label>
                                </div>
                            @endforeach
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3" style="position: relative;">
                @csrf
                <input type="hidden" name="project_expansion" value="1">
                <button type="button" class="btn btn-warning btn-lg float-right"><strong>ขยายสัญญา / ขยายวงเงิน</strong></button>
            </div>
        </div>
    @endif
    <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text">ชื่อโครงการ</span>
        </div>
        <input type="text" class="form-control" name="project_desc" placeholder="ชื่อโครงการ" value="{{ $project->description }}" required>
        <input type="hidden" name="current_project_desc" value="{{ $project->description }}">
    </div>
    <!-- end ชื่อโครงการ -->

    <!--
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">
                ค้นหาโครงการที่ผ่านอนุมัติ ครม.
            </span>
        </div>
        <input type="text" name="search" data-toggle="typeahead" class="form-control typeahead-group" placeholder="ค้นหาโครงการที่ผ่านอนุมัติ ครม." autocomplete="off">
        <div class="input-group-append">
            <button type="button" id="search" class="input-group-text" role="button">
                <i class="zmdi zmdi-search"></i>
            </button>
            <span class="input-group-text bg-white text-dark">
                <div class="checkbox inlineblock mb-0">
                    <input type="checkbox" name="project_notfound" id="project_notfound" value="1">
                    <label for="project_notfound">ไม่พบข้อมูล</label>
                </div>
            </span>
        </div>
    </div>
    -->
    <!-- end  ค้นหาโครงการที่ผ่านอนุมัติ -->

    <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text">หน่วยงาน</span>
        </div>
        <div class="input-group-append mb-0">
            <span class="input-group-text bg-white text-dark">
                @foreach ($divisions as $division)
                    <div class="radio inlineblock m-l-30 m-r-20 mb-0">
                        <input type="radio" name="division_code" id="division{{ $loop->iteration }}" class="with-gap" value="{{ $division->code }}" {{ ($division->code == $project->division_code) ? "checked" : "" }}>
                        <label for="division{{ $loop->iteration }}">{{ $division->description }}</label>
                    </div>
                @endforeach
            </span>
        </div>
    </div>
    <!-- end หน่วยงาน -->
</div>
<!-- End topic detail project -->

<div class="card border border-info">
    <div class="header pb-0">
        <h2><b>ระยะเวลาดำเนินการ (ตาม มติ ครม.)</b></h2>
    </div>
    <div class="body display-6">
        <div class="row mb-2">
            <div class="col-md-7 form-row">
                <input type="hidden" id="setdate" value="{{ $actual_begin_year . ',' . $actual_end_year }}">
                <div class="col-sm-6">
                    <label class="font-weight-bold">วันที่เริ่มต้น</label>
                    <div class="d-flex position-relative">
                        <input type="text" name="date_start" class="f-9 form-control border-secondary datetimepicker" placeholder="วันที่เริ่มต้น" value="{{ !empty($expansion->begin_date) ? $expansion->begin_date : ShortDateFormat() }}" data-date="{{ !empty($expansion->begin_date) ? substr($expansion->begin_date, -4) : \Carbon\Carbon::now()->add(543, 'year')->format('Y') }}">
                        <span class="float-icon-right"><i class="zmdi zmdi-calendar"></i></span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <label class="font-weight-bold">วันที่สิ้นสุด</label>
                    <div class="d-flex position-relative">
                        <input type="text" name="date_end" class="f-9 form-control border-secondary datetimepicker" placeholder="วันที่สิ้นสุด" value="{{ !empty($expansion->end_date) ? $expansion->end_date : ShortDateFormat() }}" data-date="{{ !empty($expansion->end_date) ? substr($expansion->end_date, -4) : \Carbon\Carbon::now()->add(543, 'year')->format('Y') }}">
                        <span class="float-icon-right"><i class="zmdi zmdi-calendar"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-md-5 align-self-end">
                <button type="button" class="btn btn-warning btn-upload btn-sm text-dark">
                    <i class="zmdi zmdi-file-plus"></i> ไฟล์แนบ
                    <input type="file" name="document">
                    <input type="hidden" name="document_path" value="{{ isset($document_path) ? $document_path : '' }}">
                    <input type="hidden" name="document_name" value="{{ isset($document_name) ? $document_name : '' }}">
                </button>
                <button type="button" id="confirm-date" class="btn btn-sm g-bg-cgreen">
                    <i class="zmdi zmdi-save"></i> ยืนยันข้อมูล
                </button>
            </div>
        </div>
    </div>
</div>
<!-- end ระยะเวลาดำเนินการ (ตาม มติ ครม.) -->

<div class="card border border-info">
    <div class="header pb-0">
        <h2><b>พื้นที่ดำเนินการ</b></h2>
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
<!-- end พื้นที่การดำเนินการ -->

<div class="card border border-info">
    <div class="header pb-0">
        <h2><b>เงินลงทุนและแหล่งเงินทุน</b></h2>
    </div>
    <div class="body display-6">
        <div class="row mb-2">
            <div class="col-sm-12 form-row">
                <div class="col-sm-3 col-lg-2 form-control-label text-sm-right align-self-center">
                    <label class="font-weight-bold">กรอบการลงทุน ทั้งหมด</label>
                </div>
                <div class="col-sm-9 col-lg-8">
                    <div class="form-group d-inline-flex">
                        <input type="number" name="actual_all" value="{{ $project->actual }}" class="form-control text-right" placeholder="กรอบการลงทุน ทั้งหมด">
                        <label class="text-nowrap px-2 align-self-center mb-0">ล้านบาท</label>
                        <div class="checkbox text-nowrap mb-0 align-self-center">
                            <input id="checkbox4" type="checkbox" name="included_vat" value="1" {{ (isset($investment->included_vat) && $investment->included_vat == 1) ? 'checked=""' : '' }}>
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
                        <input type="text" name="investment_type" value="{{ $investment->investment_type }}" class="form-control" placeholder="รูปแบบการลงทุน">
                    </div>
                </div>
            </div> 
            <div class="col-sm-12 form-row">
                <div class="col-sm-2 form-control-label text-sm-right">
                    <label class="font-weight-bold">แหล่งเงินลงทุน</label>
                </div>
                <div class="col-sm-8 form-row no-gutters">
                    @foreach ($investments as $detail)
                        <div class="col-sm-12">
                            <div class="text-nowwrap row mb-2">
                                <div class="col-sm-7">
                                    <label class="text-nowrap px-2 align-self-center mb-0">{{ $detail->fund_desc }}</label>
                                </div>
                                <div class="col-sm-3 d-flex">
                                    <input type="hidden" name="investments[{{ $detail->fund_code }}][description]" value="{{ $detail->fund_desc }}">
                                    <input type="number" name="investments[{{ $detail->fund_code }}][actual]" value="{{ $detail->fund_value }}" class="form-control text-right border-secondary" placeholder="-">
                                    <label class="text-nowrap px-2 align-self-center mb-0">ล้านบาท</label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div> 
            <!-- แหล่งเงินลงทุน -->
        </div>
    </div>
</div>
<!-- end เงินลงทุนและแหล่งเงินทุน -->

<div class="card border border-info">
    <div class="header pb-0">
        <h2><strong>แผนการดำเนินโครงการ</strong></h2>
    </div>
    <div class="body display-6 table-responsive">
        <table id="activity" class="table table-bordered table-sm f-9">
            <thead>
                <tr class="text-center head-list">
                    <th class="align-middle w-px-420" rowspan="2">รายการ</th>
                    <!-- auto generate [TH] FROM select date_start, date_end and submit button ยืนยันข้อมูล-->
                </tr>
            </thead>
            <tbody>
                @foreach ($activities as $activity)
                    @if ( ! is_null($activity->sub_activity_desc))
                        <tr class="box-plan-{{ $loop->iteration }}" data-content="sub" data-activity="{{ $activity->sub_activity_desc }}" data-parent="{{ $activity->code }}">
                            <input type="hidden" name="activities[{{ $activity->code . '_' . $loop->index }}][activity_code]" value="{{ $activity->code }}">
                            <td class="box-plan-header"><input type="text" class="form-control border-secondary text-right" placeholder="กิจกรรมย่อย" name="activities[{{ $activity->code . '_' . $loop->index }}][sub_activity_desc]" value="{{ $activity->sub_activity_desc }}" required></td>
                            <!-- Auto generate [TD] FROM event "on change" dropdown begin_year, end_year -->
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
                            <!-- Auto generate [TD] FROM event "on change" dropdown begin_year, end_year -->
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- end แผนการดำเนินโครงการ -->

<div class="card border border-info box-inv">
    <div class="header pb-0">
        <h2><b>กรอบเงินลงทุนรายกิจกรรม</b></h2>
    </div>
    <div class="body display-6 table-responsive">
        <table id="table-inv" class="table table-bordered table-sm f-9">
            <thead class="text-center">
                <tr class="header-inv">
                    <th>รายการกิจกรรม</th>
                    <!-- Auto generate from select year -->
                </tr>
            </thead>
            <tbody>
                <!-- Auto genarate from checked in plan activity -->
            </tbody>
            <tfoot>
                <tr class="foot-inv">
                    <th>รวมงบประมาณ</th>
                    <!-- Auto generate from select year -->
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<!-- End  กรอบเงินลงทุนรายกิจกรรม -->

<div class="col-sm-12 text-right">
    <button type="submit" class="btn btn-primary btn-round"><i class="zmdi zmdi-save"></i> จัดเก็บข้อมูล</button>
</div>    
</form>


@section('js')
    @parent
    <script src="{{ asset('Content/Assets/bundles/datatablescripts.bundle.js') }}"></script>
    <script src="{{ asset('Content/Assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('Content/Assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('Content/Assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('Content/Assets/plugins/jquery-datatable/buttons/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('Content/Assets/plugins/jquery-datatable/buttons/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('Content/Assets/plugins/jquery-datatable/buttons/buttons.print.min.js') }}"></script>
    <script src="{{ asset('Content/Assets/js/pages/tables/jquery-datatable.js') }}"></script>
    <script src="{{ asset('Content/Assets/plugins/momentjs/moment.js') }}"></script> <!-- Moment Plugin Js --> 
    <script src="{{ asset('Content/Assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script> 
    <script src="{{ asset('Content/Assets/plugins/bootstrap-material-datetimepicker/js/th.min.js') }}"></script>
    <script src="{{ asset('Content/Assets/js/typeahead.bundle.js') }}"></script>
    <script src="{{ asset('Content/Assets/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('Content/Assets/plugins/ol-v6.5.0-dist/ol.js') }}"></script>
@endsection

@section('jsscript')
    @parent
    <script>
        (function ( $ ) {
            $.fn.show = function() {
                this.attr( "style", "display: inline-block !important" );
                return this;
            };
        }( jQuery ));

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

        $(function () {
            // สร้างพื้นที่การดำเนินการ
            $('#prv').selectpicker();

            // เพิ่มพื้นที่การดำเนินการ
            $('#prv').change(function(){
                var v = $(this).val();
                $(this).val('').selectpicker('refresh');
                $(this).parents('span').prepend('<label class="btn btn-simple btn-warning btn-round align-self-center btn-sm tag-prv">' + v + '<input type="hidden" name="areas[]"value="'+ v +'"> <i class="zmdi zmdi-close-circle"></i></label>');
            });

            // ลบพื้นที่การดำเนินการ
            $(document).on('click','.tag-prv i',function(){
                $(this).parent().remove();
            })

            $('[href="#tab1"]').on('click',function(){
                setTimeout(function(){
                    reloadMap();
                },500);
            });

            // Defining the local dataset
            var projects = ['@php echo implode("','", \Arr::pluck($projects_desc, "description")) @endphp'];

            var substringMatcher = function(strs) {
                return function findMatches(q, cb) {
                    var matches, substringRegex;

                    // an array that will be populated with substring matches
                    matches = [];

                    // regex used to determine if a string contains the substring `q`
                    substrRegex = new RegExp(q, 'i');

                    // iterate through the pool of strings and for any string that
                    // contains the substring `q`, add it to the `matches` array
                    $.each(strs, function(i, str) {
                    if (substrRegex.test(str)) {
                        matches.push(str);
                    }
                    });

                    cb(matches);
                };
            };
            
            // Initializing the typeahead
            $('[data-toggle="typeahead"]').typeahead({
                hint: true,
                highlight: true, /* Enable substring highlighting */
                minLength: 1 /* Specify minimum characters required for showing result */
            },
            {
                name: 'projects',
                source: substringMatcher(projects)
            });

            // ค้นหาโครงการที่ผ่านอนุมัติ ครม.
            $(document).on('click', 'button#search', function(){
                var form = $('#frm-search');
                form.find('input[name="current_project_desc"]').val($('input[name="search"]').val());
                form.submit();
            });

            //Datetimepicker plugin
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
            $('.datetimepicker').bootstrapMaterialDatePicker({
                format: 'DD MMM YYYY',
                time: false,
                clearButton: false,
                weekStart: 0,
                year: true,
                lang: 'th',
                okText: 'ตกลง',
                cancelText: 'ยกเลิก'
            })
            //.on('change',function(e, date){
            //     /* calculate date for get year
            //     * เก็บค่าเพื่อเอาปีไปสร้างรายการปีีใน table
            //     */
            //     var t = e.target.name;
            //     $('[name="'+t+'"]').attr('data-date',date._d);
            //     $("#begin_date_year").val(function() {
            //         var s = new Date($('[name="date_start"]').attr('data-date'));
            //         var e = new Date($('[name="date_end"]').attr('data-date'));
            //         return s.getFullYear() +','+ e.getFullYear();
            //     });
            // });
            @php $default_date = date('j') . ' ' . getShortMonthThai(date('n')) . ' ' . \Carbon\Carbon::now()->add(543, 'year')->format('Y') @endphp
            $('[name="date_start"]').bootstrapMaterialDatePicker('setDate', '{{ $default_date }}');
            $('[name="date_end"]').bootstrapMaterialDatePicker('setDate', '{{ $default_date }}');
            
            // กดปุ่ม "ยืนยันข้อมูล"
            $('#confirm-date').click(function(){
                var date_start = $('[name="date_start"]').val();
                var date_end = $('[name="date_end"]').val();
                $('#setdate').val(date_start.substr(date_start.length - 4) + ',' + date_end.substr(date_end.length - 4))
                callTablePlan();

                createThead('header-inv');
                callTableInv();
                calculateTableInv();
                // $('.box-inv').hide();
                // $('table#table-inv tbody tr').remove();
            });

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
                            $('tr.'+thead).append('<th colspan="12" class="new-header">ปีงบประมาณ ' + parseInt(i) + '</th>');
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

                    $.each(activities, function(idx, activity){
                        // Skip sub activity
                        if (activity['sub_activity_desc'] !== null) return;
                        
                        var objSlider, begin_year, end_year;
                        var obj = $('table#activity tbody tr:nth-child(' + (idx + 1) + ')')
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
                var childinv, total;
                var pr = $('#activity tbody tr[data-content="main"]');
                var len =  $("#setdate").val().split(',');
                // console.log(len);
                if (len[0] == "" || len[1] == "") {
                    return;
                }

                $('#table-inv tbody tr td:not(:first-child)').remove();

                var idx;
                total = 0;
                for (i=len[0]; i<=len[1]; i++)
                {
                    childinv = ''
                    pr.each(function(idx, activity){
                        if ($(activity).find('[type="checkbox"]:checked').length == 0) return;
                        idy = (activities.findIndex(function(tmp){
                            return tmp['code'] == $(activity).closest('tr').data('activity');
                        }));

                        val = (!isNaN(activities[idy][i])) ? activities[idy][i] : '';
                        childinv = '<td data-period="' + i + '"><input type="number" step="0.01" name="activities[' +  $(activity).data('activity') + '][period][' + i + '][actual]" value="' + val + '" class="form-control text-right" placeholder="งบประมาณ"></td>';
                        // childinv = '<td data-period="' + i + '"><input type="text" step="0.01" name="activities[' +  $(activity).data('activity') + '][period][' + i + '][actual]" value="' + i + ':' + $(activity).data('activity') + '" class="form-control text-right" placeholder="งบประมาณ"></td>';
                        $('#table-inv tbody tr[data-activity="' + $(activity).data('activity') + '"]').append(childinv);
                    });
                }

                childinv = '<td><input type="number" step="0.01" name="activities[' +  $(activity).data('activity') + '][period][' + i + '][actual]" value="0" class="form-control text-right" placeholder="งบประมาณ"></td>';
                $('#table-inv tbody tr').append(childinv);
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
                    $(row).find('td:last-child input').val(total.toFixed(2));
                });

                // ยอดรวมรายปีงบประมาณ (summary by column)
                $('#table-inv tfoot').find('th > input').each(function(idx, obj){
                    total = 0;
                    $('#table-inv tbody').find('tr').each(function(idy, row){
                        val = ($.isNumeric($(row).find('td:eq(' + (idx + 1) + ') input').val())) ? $(row).find('td:eq(' + (idx + 1) + ') input').val() : 0;
                        total = total + parseFloat(val);
                    });
                    
                    // console.log(total);
                    $(obj).val(total.toFixed(2));
                });
            };
            
            // เพิ่มกิจกรรมย่อย
            $(document).on('click', '.btn-sub-activity', function(){
                var len =  $("#setdate").val().split(',');
                var begin_year = len[0];
                var end_year = len[1];
                var row = $(this).closest('tr');
                var act = row.data('activity');
                var l = $('table#activity tr[data-activity="' + act + '"], table#activity tr[data-parent="' + act + '"]').length;

                var contentrow;
                contentrow = '<tr class="new-header child-range-year" data-activity="" data-parent="' + act + '">';
                contentrow = contentrow + '<input type="hidden" name="activities[' + act + '_N' + l + '][activity_code]" value="' + act + '">';
                contentrow = contentrow + '<td><input type="text" name="activities[' + act + '_N' + l + '][sub_activity_desc]" class="form-control border-secondary text-right" placeholder="กิจกรรมย่อย" required></td>';
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

            // Click สำหรับสร้าง slider
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

            // Double click เพื่อยกเลิกการสร้าง slider
            $(document).on('dblclick', 'td.slider-created', function(e){
                $(this).find('.slider-range').remove();
                $(this).append('<div class="slider-range"></div>');
                $(this).removeClass('slider-created');
                $(this).find('[name$="[begin]"]').val(null);
                $(this).find('[name$="[end]"]').val(null);
            });

            // สร้างรายการของกรอบลงทุนรายกิจกรรม
            $(document).on('click','[id^="t-plan"]',function(){
                /* [ id t-plan * ] checked to show and not checked to hide 
                *
                * and link table id inv
                */
                var pr = $(this).closest('tr');
                var p = pr.attr('class');
                var label = $.trim($(this).next("label").text());
    
                if($('[id^="t-plan"]:checked').length === 0){
                    $('.box-inv').hide();
                    //$('.box-inv tbody').remove();
                }

                if($(this).is(":checked")){
                    var len =  $("#setdate").val().split(',');
                    pr.find('.btn-sub-activity,.slider-range').show();
                    
                    /* for table inv */
                    createThead('header-inv');

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
                            childinv += '<td data-period="' + i + '"><input type="number" step="0.01" name="activities[' + pr.data('activity') + '][period][' + i + '][actual]" value="' + val + '" class="form-control text-right" placeholder="งบประมาณ"></td>';
                        }

                        childinv += '<td><input type="number" step="0.01" value="' + total + '" class="form-control text-right" placeholder="รวมงบประมาณ"></td>';
                    });
                            
                    $('table#table-inv tbody').append(
                        `<tr class="${p}" data-activity="${pr.data('activity')}">
                            <td>${label}</td>
                            ${childinv}
                        </tr>`
                    );
                    
                    $('.box-inv').show();
                }
                else{
                    $('table#table-inv tbody').find('tr.'+p).remove();
                    pr.find('.btn-sub-activity,.slider-range').hide();
                } 
            });

            // คำนวณยอดรวมงบประมาณ
            $(document).on('keyup', 'table#table-inv input', function(){
                calculateTableInv();
            });

            // เริ่มต้นโหลด "แผนการดำเนินโครงการ"
            callTablePlan();
            $.each(activities, function(idx, activity){
                if (activity['selected'] == 1)
                {
                    // console.log('trigger: ' + activity['code']);
                    $('table#activity tr[data-activity="' + activity['code'] + '"] input[id^="t-plan"]').trigger('click');
                }
            });
            calculateTableInv();
        });
    </script>
@endsection


