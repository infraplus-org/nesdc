<form method="POST" action="{{ url('master/updating') }}">
@csrf
<input type="hidden" name="id" value="{{ $master->id }}">
<section>
<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header pb-3">
            <h5 class="modal-title text-white" id="">
                <div class="header"><i class="zmdi zmdi-plus"></i> การจัดการข้อมูล</div>
            </h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">ปิด <span aria-hidden="true">&times;</span></button>
        </div>
        <hr class="border-muted w-100 my-0" />
        <div class="modal-body">
            <div class="card">
                <div class="body display-6">
                    <div class="card">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <label class="font-weight-bold">ประเภท <i class="required-field">*</i></label>
                                <input type="hidden" name="type" value="{{ $master->type }}">
                                <select class="form-control show-tick" name="type" {{ ( ! empty($master->id)) ? "disabled" : "" }} required>
                                    <option value="">-- เลือก ประเภท --</option>
                                    @foreach ($types as $data)
                                        <option value="{{ $data->type }}" {{ $data->type == $master->type ? 'selected="selected"' : '' }}>{{ $data->type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label class="font-weight-bold">รหัส <i class="required-field">*</i></label>
                                <div class="form-group">
                                    <input type="hidden" name="code" value="{{ $master->code }}">
                                    <input type="text" class="form-control border-secondary" name="code" placeholder="รหัส" value="{{ $master->code }}" {{ ( ! empty($master->id)) ? "disabled" : "" }} required>
                                    <small id="code-help-text" class="text-muted"></small>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <label class="font-weight-bold">ลำดับ</label>
                                <div class="form-group">
                                    <input type="number" class="form-control border-secondary" name="ranking" value="{{ $master->ranking }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12">
                                <label class="font-weight-bold">รายละเอียด <i class="required-field">*</i></label>
                                <div class="form-group">
                                    <input type="text" class="form-control border-secondary" name="description" placeholder="รายละเอียด" value="{{ $master->description }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <div class="form-group d-inline-flex">
                                    <div class="checkbox text-nowrap mb-0 align-self-center">
                                        <input id="checkbox" type="checkbox" name="actived" value="1" {{ ($master->actived == 0) ? '' : 'checked="checked"'}}>
                                        <label for="checkbox">เปิดใช้งาน</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12 pr-4 text-right">
                            <button type="submit" class="btn btn-primary btn-round"><i class="zmdi zmdi-save"></i> บันทึก</button>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>
</section>
</form>

<script src="{{ asset('Content/Assets/bundles/mainscripts.bundle.js') }}"></script>

<script>
    $(document).ready(function(){
        var master_types = JSON.parse('@php echo json_encode($types) @endphp')
        $('select[name="type"]').on('change', function(){
            var index = master_types.findIndex(x => x.type === $(this).find('option:selected').val())
            $('#code-help-text').html("รหัสที่ใช้งานล่าสุด: " + master_types[index].code);
        });
    });
</script>
