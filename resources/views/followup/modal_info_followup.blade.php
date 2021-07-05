<link rel="stylesheet" href="{{ asset('Content/Assets/css/jquery-ui.css') }}">
<style>
    .checkbox input[type="checkbox"]:disabled + label, .radio input[type="radio"]:disabled + label {
        color: #424242;
        opacity: 1;
    }
</style>

<div class="card border border-info">
    <div class="header pb-0">
        <h2><strong>ข้อมูลโครงการ</strong></h2>
    </div>
    <div class="body display-6">
        <div class="row">
            <label class="col-sm-2 col-form-label"><strong>เรื่อง / การดำเนินการ</strong></label>
            <div class="col-sm-10">
                <label class="col-form-label">{{ $project->description }}</label>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-2 col-form-label"><strong>หน่วยงาน</strong></label>
            <div class="col-sm-10">
                <label class="col-form-label">{{ $project->division_desc }}</label>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-2 col-form-label"><strong>สาขาการลงทุน</strong></label>
            <div class="col-sm-10">
                <label class="col-form-label">{{ $project->investment_desc }}</label>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-2 col-form-label"><strong>พื้นที่การดำเนินการ</strong></label>
            <div class="col-sm-4">
                <span>
                    @php $areas = Str::of($project->area)->split('/;/'); @endphp
                    @foreach ($areas as $area)
                        @if ( ! is_null($area) && $area != '')
                            <label class="btn btn-simple btn-warning btn-round align-self-center tag-prv btn-sm">{{ $area }}
                                <input type="hidden" name="areas[]" value="{{ $area }}">
                            </label>
                        @endif
                    @endforeach
                </span>
            </div>
            <label class="col-sm-2 col-form-label"><strong>รายละเอียดพื้นที่การดำเนินการ</strong></label>
            <div class="col-sm-4">
                <label class="col-form-label">{{ $project->area_detail }}</label>
            </div>
        </div>
        <div class="row">
            <div id="map"></div>
        </div>
    </div>
</div>
<!-- End ข้อมูลโครงการ -->

<div class="card border border-info">
    <div class="header pb-0">
        <h2><strong>แผนการดำเนินงาน</strong></h2>
    </div>
    <div class="body display-6">
        <div class="row">
            <div class="col-md-12 form-row">
                <input type="hidden" id="setdate" value="{{ $project->plan_begin_year . ',' . $project->plan_end_year }}">
                <div class="col-sm-12 form-check-inline">
                    <label class="col-sm-2 col-form-label"><strong>วันที่เริ่มต้น</strong></label>
                    <div class="col-sm-3">
                        <label>{{ !empty($expansion->begin_date) ? $expansion->begin_date : '' }}</label>
                    </div>
                    <label class="col-sm-2 col-form-label"><strong>วันที่สิ้นสุด</strong></label>
                    <div class="col-sm-3">
                        <label>{{ !empty($expansion->end_date) ? $expansion->end_date : '' }}</label>
                    </div>
                </div>
            </div>
        </div>
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
                                    <!-- <button type="button" class="btn btn-sm btn-mini btn-secondary float-right btn-sub-activity">
                                        <i class="zmdi zmdi-plus"></i> เพิ่มกิจกรรมย่อย
                                    </button> -->
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
<!-- end แผนการดำเนินงาน -->

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
                        <label class="text-nowrap px-2 align-self-center mb-0">{{ $project->actual }}</label>
                        <label class="text-nowrap px-2 align-self-center mb-0">ล้านบาท</label>
                        <div class="checkbox text-nowrap mb-0 align-self-center">
                            <input id="checkbox4" type="checkbox" name="included_vat" value="1" {{ ($investment_header->included_vat == 1) ? 'checked=""' : '' }}>
                            <label for="checkbox4">
                                รวมภาษีมูลค่าเพิ่ม 7%
                            </label>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="col-sm-12 form-row">
                <label class="col-sm-3 col-lg-2 form-control-label text-sm-right"><strong>รูปแบบการลงทุน</strong></label>
                <div class="col-sm-9 col-lg-8">
                    <label class="col-sm-12 form-control-label">{{ $investment_header->investment_type }}</label>
                </div>
            </div> 

            <div class="col-sm-12 form-row">
                <div class="col-sm-2 form-control-label text-sm-right">
                    <label class="font-weight-bold">แหล่งเงินลงทุน</label>
                </div>
                <div class="col-sm-8 form-row no-gutters">
                    @foreach ($investments as $investment)
                        @php if (is_null($investment->fund_value)) continue @endphp
                        <div class="col-sm-12">
                            <div class="text-nowwrap row mb-2">
                                <div class="col-sm-6">
                                    <label class="text-nowrap px-2 align-self-center mb-0">{{ $investment->fund_desc }}</label>
                                </div>
                                <div class="col-sm-2 d-flex">
                                    <label class="text-nowrap px-2 align-self-center mb-0">{{ number_format($investment->fund_value, 4) }}</label>
                                </div>
                                <div class="col-sm-4 d-flex">
                                    <!-- <input type="number" name="investments[{{ $investment->fund_code }}][actual]" value="{{ $investment->fund_value }}" class="form-control text-right border-secondary" placeholder="-"> -->
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
    <div class="header pb-0">
        <h2><strong>กรอบเงินลงุทนรายกิจกรรม</strong></h2>
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
<!-- End  กรอบเงินลงุทนรายกิจกรรม -->

<script src="{{ asset('Content/Assets/plugins/momentjs/moment.js') }}"></script>
<script src="{{ asset('Content/Assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script> 
<script src="{{ asset('Content/Assets/plugins/bootstrap-material-datetimepicker/js/th.min.js') }}"></script>
<script src="{{ asset('Content/Assets/plugins/ol-v6.5.0-dist/ol.js') }}"></script>
<script src="{{ asset('Content/Assets/bundles/datatablescripts.bundle.js') }}"></script>
<script src="{{ asset('Content/Assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('Content/Assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('Content/Assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('Content/Assets/plugins/jquery-datatable/buttons/buttons.flash.min.js') }}"></script>
<script src="{{ asset('Content/Assets/plugins/jquery-datatable/buttons/buttons.html5.min.js') }}"></script>
<script src="{{ asset('Content/Assets/plugins/jquery-datatable/buttons/buttons.print.min.js') }}"></script>
<script src="{{ asset('Content/Assets/js/pages/tables/jquery-datatable.js') }}"></script>
<script src="{{ asset('Content/Assets/js/jquery-ui.js') }}"></script>

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
    initMap("map");
    $(function () {
        // สร้างพื้นที่การดำเนินการ
        $('#prv').selectpicker();
        $('[href="#tab1"]').on('click',function(){
            setTimeout(function(){
                reloadMap();
            },500);
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
        callTable = function(){
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
                                '<input type="hidden" name="activities[' + activity['code'] + '][period][' + i + '][begin]" value="' + (typeof activity[i + '_month_begin'] !== "undefined" ? activity[i + '_month_begin'] : '') + '">'+
                                '<input type="hidden" name="activities[' + activity['code'] + '][period][' + i + '][end]" value="' + (typeof activity[i + '_month_end'] !== "undefined" ? activity[i + '_month_end'] : '') + '">'+
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
                                    values: slider_val,
                                });
                                objSlider.slider("disable");
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
        callTable();
        $.each(activities, function(idx, activity){
            if (activity['selected'] == 1)
            {
                // console.log('trigger: ' + activity['code']);
                $('table#activity tr[data-activity="' + activity['code'] + '"] input[id^="t-plan"]').trigger('click');
            }
        });
        calculateTableInv();
        $('[type="checkbox"]').attr('disabled', true);
    });
</script>

