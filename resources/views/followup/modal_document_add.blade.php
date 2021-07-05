<form method="POST" action="{{ url('followup') . '/' . $project_id . '/document/adding' }}" enctype="multipart/form-data">
@csrf
<input type="hidden" name="project_id" value="{{ $project_id }}">
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
                                    <ul class="nav nav-tabs" id="projects-document-type">
                                        <input type="hidden" name="doc_type" value="{{ $documents[0]->code }}">
                                        @foreach ($documents as $document)
                                            <li class="nav-item">
                                                <a class="border-bottom-warning nav-link {{ $loop->iteration == 1 ? 'active' : '' }}" data-toggle="tab" href="#subtab1" data-code="{{ $document->code }}">{{ $document->description }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <hr class="mt-0">
                                    <div class="tab-content">
                                        <div role="tabpanel"  class="tab-pane in active"  id="subtab1"> 
                                            <div class="row">
                                                <div class="col-sm-12 form-row mb-2">
                                                    <div class="col-sm-3 form-control-label align-self-center text-sm-right">
                                                        <label class="font-weight-bold">นำเข้า ณ วันที่</label>
                                                    </div>
                                                    <div class="col-sm-7">
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

