<form method="POST" action="{{ url('project/updating') }}" enctype="multipart/form-data">
@csrf
<input type="hidden" name="project_id" value="{{ $project->project_id }}">
<section>
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header pb-3">
                <h5 class="modal-title text-white" id="">
                    <div class="header"><i class="zmdi zmdi-info-outline"></i> บริหารจัดการสถานะการพิจารณาโครงการ</div>
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">ปิด <span aria-hidden="true">&times;</span></button>
            </div>
            <hr class="border-muted w-100 my-0" />
            <div class="modal-body">
                <div class="card">
                    <div class="body display-6">
                        <div class="card border border-info">
                            <div class="header pb-0">
                                <h2><b>เอกสารที่เกี่ยวข้อง</b></h2>
                            </div>
                            <div class="body row">
                                <div class="col-sm-12">
                                    <div role="tabpanel"  class="tab-pane in active"  id="subtab1"> 
                                        <div class="row">
                                            <div class="col-sm-12 form-row mb-1">
                                                <div class="col-sm-3 form-control-label align-self-center text-sm-right">
                                                    <label class="font-weight-bold">ประเภทเอกสาร</label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <select name="doc_type" class="form-control">
                                                        <option value="">-- เลือก ประเภทเอกสาร --</option>
                                                        @foreach ($documents as $document)
                                                            <option value="{{ $document->code }}">{{ $document->description }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 form-row mb-2">
                                                <div class="col-sm-3 form-control-label align-self-center text-sm-right">
                                                    <label class="font-weight-bold">นำเข้า ณ วันที่</label>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="d-flex position-relative">
                                                        <input type="text" class="f-9 form-control border-secondary datetimepicker" name="doc_imported_at" placeholder="นำเข้า ณ วันที่" required>
                                                        <span class="float-icon-right"><i class="zmdi zmdi-calendar"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 form-row">
                                                <div class="col-sm-3 form-control-label align-self-center text-sm-right">
                                                    <label class="font-weight-bold">รายละเอียด</label>
                                                </div>
                                                <div class="col-sm-7">
                                                    <input type="text" name="doc_detail" class="f-9 form-control border-secondary" placeholder="หนังสือต้นเรื่อง">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 text-center">
                                                <label class="btn btn-sm btn-secondary">
                                                    <i class="zmdi zmdi-collection-plus"></i> นำเข้าเอกสาร
                                                    <input type="file" name="document" hidden required>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <hr >
                                    <div id="content">
                                        <ul class="timeline">
                                            @for ($i=0; $i<count($project_documents); $i++)
                                                @if ($i == 0 || substr($project_documents[$i-1]->imported_at, 0, 10) != substr($project_documents[$i]->imported_at, 0, 10))
                                                <li class="event" data-date="{{ 'วันที่ ' . FullDateFormat($project_documents[$i]->imported_at) }}">
                                                @endif
                                                    <span class="d-block mb-3">
                                                        <h3>{{ $project_documents[$i]->book_desc }}</h3>
                                                        <p class="mb-0">{{ $project_documents[$i]->detail }}</p>
                                                        @if ( ! empty($project_documents[$i]->filename))
                                                            <a href="{{ Storage::url($project_documents[$i]->filename) }}" target="_blank"><img class="w-2" src="{{ asset('Content/Assets/images/icons/' . $project_documents[$i]->extension . '-30.png') }}"></a>
                                                        @endif
                                                    </span>
                                                @if (isset($project_documents[$i+1]->imported_at) && $project_documents[$i+1]->imported_at != $project_documents[$i]->imported_at)
                                                </li>
                                                @endif
                                            @endfor
                                        </ul>
                                    </div>  
                                </div>                                 
                            </div>
                        </div>
                        <div class="col-sm-12 pr-4 text-right">
                            <button class="btn btn-primary btn-round"><i class="zmdi zmdi-save"></i> บันทึก</button>
                        </div>   
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</form>

<script src="{{ asset('Content/Assets/bundles/mainscripts.bundle.js') }}"></script>
<script src="{{ asset('Content/Assets/plugins/momentjs/moment.js') }}"></script>
<script src="{{ asset('Content/Assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script> 
<script src="{{ asset('Content/Assets/plugins/bootstrap-material-datetimepicker/js/th.min.js') }}"></script>

<script>
    $(document).ready(function(){
        $(function () {
            //Datetimepicker plugin
            var m = moment();
            $('.datetimepicker').bootstrapMaterialDatePicker({
                format: 'YYYY-MM-DD HH:mm',
                clearButton: false,
                // minDate: moment(),
                weekStart: 0,
                lang: 'th',
                okText: 'ตกลง',
                cancelText: 'ยกเลิก'
            });
            $('[data-toggle="tooltip"]').tooltip();
        });

        $('#projects-document-type a').on('click', function(){
            $('#projects-document-type input[name="doc_type"]').val($(this).data('code'));
        });
    });
</script>

