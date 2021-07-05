<form method="POST" action="{{ url('user/updating') }}">
@csrf
<input type="hidden" name="id" value="{{ $user->id }}">
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
                            <div class="col-sm-8">
                                <label class="font-weight-bold">ชื่อ <i class="required-field">*</i></label>
                                <div class="form-group">
                                    <input type="text" class="form-control border-secondary" name="name" placeholder="ชื่อ" value="{{ $user->name }}" required>
                                    <small id="code-help-text" class="text-muted"></small>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label class="font-weight-bold">สิทธิ์ผู้ใช้งาน <i class="required-field">*</i></label>
                                <select class="form-control show-tick" name="role" required>
                                    <option value="">-- เลือก สิทธิ์ผู้ใช้งาน --</option>
                                    @foreach ($roles as $data)
                                        <option value="{{ $data->code }}" {{ $data->code == $user->role ? 'selected="selected"' : '' }}>{{ $data->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12">
                                <label class="font-weight-bold">อีเมล <i class="required-field">*</i></label>
                                <div class="form-group">
                                    <input type="text" class="form-control border-secondary" name="email" placeholder="อีเมล" value="{{ $user->email }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <label class="font-weight-bold">รหัสผ่าน <i class="required-field">*</i></label>
                                <div class="form-group">
                                    <input type="password" class="form-control border-secondary" name="password" placeholder="รหัสผ่าน" value="">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="font-weight-bold">ยืนยันรหัสผ่าน <i class="required-field">*</i></label>
                                <div class="form-group">
                                    <input type="password" class="form-control border-secondary" name="password_confirmation" placeholder="ยืนยันรหัสผ่าน" value="">
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
    });
</script>
