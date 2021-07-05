<section>
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header pb-3">
                <h5 class="modal-title text-white" id="">
                    <div class="header"><i class="zmdi zmdi-info-outline"></i> รายละเอียดโครงการ</div>
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">ปิด <span aria-hidden="true">&times;</span></button>
            </div>
            <hr class="border-muted w-100 my-0" />
            <div class="modal-body">
                <div class="card">
                    <div class="body display-6">
                        <div class="row clearfix">
                            <dl class="row col-sm-12 mb-0">
                                <dt class="col-sm-2">ชื่อโครงการ</dt>
                                <dd class="col-sm-10">{{ $project->description }}</dd>
                            </dl>
                            <div class="w-100"></div>
                            <dl class="row col-sm-6 mb-0">
                                <dt class="col-sm-4">สถานะโครงการ</dt>
                                <dd class="col-sm-8">{{ $project->status_desc }}</dd>
                            </dl>
                            <dl class="row col-sm-6 mb-0">
                                <dt class="col-sm-4">หน่วยงาน</dt>
                                <dd class="col-sm-8">{{ $project->department_desc }}</dd>
                            </dl>
                            <dl class="row col-sm-6 mb-0">
                                <dt class="col-sm-4">วันที่เริ่มต้น</dt>
                                <dd class="col-sm-8">{{
                                    (($project->plan_begin_day != '') ? $project->plan_begin_day . ' ' : '') . 
                                    (($project->plan_begin_month != '') ? getFullMonthThai($project->plan_begin_month) . ' ' : '') . 
                                    $project->plan_begin_year
                                }}</dd>
                            </dl>
                            <dl class="row col-sm-6 mb-0">
                                <dt class="col-sm-4">วันที่สิ้นสุด</dt>
                                <dd class="col-sm-8">
                                {{
                                    (($project->plan_end_day != '') ? $project->plan_end_day . ' ' : '') . 
                                    (($project->plan_end_month != '') ? getFullMonthThai($project->plan_end_month) . ' ' : '') . 
                                    $project->plan_end_year 
                                }}
                                </dd>
                            </dl>
                            <dl class="row col-sm-6 mb-0">
                                <dt class="col-sm-4">สาขาการลงทุน</dt>
                                <dd class="col-sm-8">{{ $project->investment_desc }}</dd>
                            </dl>
                            <dl class="row col-sm-6 mb-0">
                                <dt class="col-sm-4">กรอบวงเงิน</dt>
                                <dd class="col-sm-8">{{ ($project->budget != '') ? $project->budget . ' ลบ.' : '' }}</dd>
                            </dl>
                            <dl class="row col-sm-6 mb-0">
                                <dt class="col-sm-4">พื้นที่ดำเนินการ</dt>
                                <dd class="col-sm-8">
                                    @php $areas = Str::of($project->area)->split('/;/'); @endphp
                                    @foreach ($areas as $area)
                                        @if ( ! is_null($area) && $area != '')
                                            <label class="btn btn-simple btn-warning btn-round align-self-center tag-prv btn-sm">{{ $area }}</label>
                                        @endif
                                    @endforeach
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="body p-0">
                        <div id="map" class="map"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>            
</section>

<script>
    function initMap(){
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
            target: "map",
            view: new ol.View({
                center: ol.proj.fromLonLat([100, 13]),
                zoom: 7,
            }),
        });
        
        reloadMap = function() {
            startMap();
            map.updateSize();
        };
        startMap = function(){
            var h = $('.modal-header').outerHeight();
            var w = $('.modal-body .body').outerHeight();
            var s = 120;
            var c = ($(window).width() < 768) ? 300 : ($(window).outerHeight()-(h+w+s));
            $('#map').height(c);
        };
        startMap();
    }
    initMap();
</script>

