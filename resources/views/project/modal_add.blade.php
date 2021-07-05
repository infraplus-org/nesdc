<form method="POST" action="{{ url('project/adding') }}">
@csrf
<input type="hidden" name="project_id" value="{{ $project->project_id }}">
<section>
<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header pb-3">
            <h5 class="modal-title text-white" id="">
                <div class="header"><i class="zmdi zmdi-plus"></i> เพิ่มรายละเอียดโครงการ</div>
            </h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">ปิด <span aria-hidden="true">&times;</span></button>
        </div>
        <hr class="border-muted w-100 my-0" />
        <div class="modal-body">
            <div class="card">
                <div class="body display-6">
                    <div class="card">
                        <div class="header">
                            <h2><strong>ผู้ประสานงานภายใน</strong> กคพ.</h2>
                        </div>
                        <div class="body">
                            <div class="row mb-2">
                                <div class="col-sm-2">
                                    <label class="font-weight-bold mb-1 pl-1">คำนำหน้า</label>
                                    <select class="form-control show-tick" name="prefix">
                                        <option value="">-- เลือก คำนำหน้า --</option>
                                        @foreach ($prefixes as $prefix)
                                            <option value="{{ $prefix->code }}" {{ $prefix->code == $contact->prefix_code ? 'selected="selected"' : '' }}>{{ $prefix->description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-5">
                                    <label class="font-weight-bold">ชื่อ <i class="required-field">*</i></label>
                                    <div class="d-flex">
                                        <input type="text" class="f-9 form-control border-secondary" name="fname" placeholder="ชื่อ" value="{{ $contact->fname }}" required>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <label class="font-weight-bold">นามสกุล</label>
                                    <div class="d-flex">
                                        <input type="text" class="f-9 form-control border-secondary" name="lname" placeholder="นามสกุล" value="{{ $contact->lname }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <label class="font-weight-bold">ตำแหน่ง <i class="required-field">*</i></label>
                                    <div class="d-flex">
                                        <input type="text" class="f-9 form-control border-secondary" name="position" placeholder="ตำแหน่ง" value="{{ $contact->position }}" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="font-weight-bold mb-1 pl-1">ฝ่ายงาน <i class="required-field">*</i></label>
                                    <select class="form-control show-tick" name="department" required>
                                        <option value="">-- เลือก ฝ่ายงาน --</option>
                                        @foreach ($departments_contact as $department)
                                            <option value="{{ $department->code }}" {{ $department->code == $contact->department_code ? 'selected="selected"' : '' }}>{{ $department->description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-3">
                                    <label class="font-weight-bold">อีเมล (หน่วยงาน)</label>
                                    <div class="d-flex">
                                        <input type="text" class="f-9 form-control border-secondary" name="email_division" placeholder="อีเมล (หน่วยงาน)" value="{{ $contact->email_division }}">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <label class="font-weight-bold">อีเมล (ส่วนตัว / สำรอง)</label>
                                    <div class="d-flex">
                                        <input type="text" class="f-9 form-control border-secondary" name="email" placeholder="อีเมล (ส่วนตัว / สำรอง)" value="{{ $contact->email }}">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <label class="font-weight-bold">โทรศัพท์</label>
                                    <div class="d-flex">
                                        <input type="text" class="f-9 form-control border-secondary" name="tel" placeholder="โทรศัพท์" value="{{ $contact->tel }}">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <label class="font-weight-bold">โทรสาร</label>
                                    <div class="d-flex">
                                        <input type="text" class="f-9 form-control border-secondary" name="fax" placeholder="โทรสาร" value="{{ $contact->fax }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card bg-transparent">
                <div class="body display-6 pb-2 bg-white">
                    <!-- ทะเบียนเลขรับ -->
                    <div class="row mb-2">
                        <div class="col-sm-3">
                            <label class="font-weight-bold">เลขทะเบียนรับ</label>
                            <div class="d-flex">
                                <input type="number" class="f-9 form-control border-secondary" name="regis" placeholder="เลขทะเบียนรับ" value="{{ $project->registration_number }}">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label class="font-weight-bold">วัน/เดือน/ปีที่รับ</label>
                            <div class="d-flex position-relative">
                                <input type="text" class="f-9 form-control border-secondary datetimepicker" name="date_book" placeholder="วัน/เวลาที่รับ" value="{{ $project->book_issued_at }}">
                                <span class="float-icon-right"><i class="zmdi zmdi-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label class="font-weight-bold">เลขที่หนังสือ</label>
                            <div class="d-flex">
                                <input type="text" class="f-9 form-control border-secondary" name="book_number" placeholder="เลขที่หนังสือ" value="{{ $project->book_number }}">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label class="font-weight-bold mb-1 pl-1">หมวดหมู่หนังสือ</label>
                            <select class="form-control show-tick" name="cat_book">
                                <option value="">-- เลือก หมวดหมู่หนังสือ --</option>
                                @foreach ($books as $book)
                                    <option value="{{ $book->code }}" {{ $book->code == $project->book_code ? 'selected="selected"' : '' }}>{{ $book->description }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <hr class="mt-0">
                <div class="row justify-content-between mx-0">
                    <div class="col-sm-6 bg-white border-right">
                        <div class="header">
                            <h2><strong>ประเภทโครงการ</strong></h2>
                        </div>
                        <!-- ประเภทโครงการ -->
                        <div class="body display-6 py-0">
                            <div class="card mb-0">
                                <div class="body pb-0">
                                    <div class="row mb-2">
                                        <div class="col-sm-12">
                                            @foreach ($project_types as $type)
                                                <div class="radio">
                                                    <input type="radio" name="project_type" id="r{{ $type->id }}" value="{{ $type->code }}" class="form-control" {{ $type->code == $project->type_code ? 'checked="checked"' : '' }}>
                                                    <label for="r{{ $type->id }}">{{ $type->description }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 pb-5 bg-white">
                        <div class="header">
                            <h2><strong>หน่วยงาน</strong></h2>
                        </div>
                        <!-- หน่วยงาน -->
                        <div class="body display-6 py-0">
                            <div class="row mb-2">
                                <div class="col-sm-12">
                                    <div class="radio">
                                        @foreach ($divisions as $division)
                                            <input type="radio" name="cat_division" id="cd{{ $division->id }}" value="{{ $division->code }}" {{ $division->code == $project->division_code ? 'checked="checked"' : '' }}>
                                            <label for="cd{{ $division->id }}">{{ $division->description }}</label>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <label class="font-weight-bold mb-1 pl-1">กระทรวง</label>
                                    <select class="form-control show-tick" name="cat_ministry">
                                        <option value="">-- เลือก กระทรวง --</option>
                                        @foreach ($ministrys as $ministry)
                                            <option value="{{ $ministry->code }}" {{ $ministry->code == $project->ministry_code ? 'selected="selected"' : '' }}>{{ $ministry->description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-12">
                                    <label class="font-weight-bold mb-1 pl-1">หน่วยงานต้นทาง</label>
                                    <select class="form-control show-tick" name="cat_department">
                                        <option value="">-- เลือก หน่วยงานต้นทาง --</option>
                                        @foreach ($departments_project as $department)
                                            <option value="{{ $department->code }}" {{ $department->code == $project->department_code ? 'selected="selected"' : '' }}>{{ $department->description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-12">
                                    <label class="font-weight-bold mb-1 pl-1">สาขาการลงทุน</label>
                                    <select class="form-control show-tick" name="cat_investment">
                                        <option value="">-- เลือก สาขาการลงทุน --</option>
                                        @foreach ($investments as $investment)
                                            <option value="{{ $investment->code }}" {{ $investment->code == $project->investment_code ? 'selected="selected"' : '' }}>{{ $investment->description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="body display-6">
                    <div class="row clearfix">
                        <div class="col-sm-12 form-row" style="{{ !empty($project->project_parent) ? '' : 'display: none;' }}" id="div-project-main">
                            <div class="col-sm-2 form-control-label text-center align-self-center">
                                <label class="font-weight-bold">โครงการหลัก</label>
                            </div>
                            <div class="col-sm-10">
                                <div class="form-group">
                                    <input type="text" name="project_parent" value="{{ $project->project_parent_desc }}" class="form-control border-secondary" data-toggle="typeahead" placeholder="โครงการหลัก">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 form-row">
                            <div class="col-sm-2 form-control-label text-center align-self-center">
                                <label class="font-weight-bold">ชื่อโครงการ <i class="required-field">*</i></label>
                            </div>
                            <div class="col-sm-10">
                                <div class="form-group">
                                    <input type="text" name="description" class="form-control border-secondary" placeholder="ชื่อโครงการ" value="{{ $project->description }}" required>
                                </div>
                            </div>
                        </div>
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
<script src="{{ asset('Content/Assets/plugins/momentjs/moment.js') }}"></script>
<script src="{{ asset('Content/Assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script> 
<script src="{{ asset('Content/Assets/plugins/bootstrap-material-datetimepicker/js/th.min.js') }}"></script>
<script src="{{ asset('Content/Assets/js/typeahead.bundle.js') }}"></script>

<script>
    $(document).ready(function(){
        $(function () {
            //Datetimepicker plugin
            var m = moment().add(543, 'year');
            $('.datetimepicker').bootstrapMaterialDatePicker({
                format: 'YYYY-MM-DD HH:mm',
                clearButton: false,
                // minDate: m,
                // currentDate: m,
                weekStart: 0,
                lang: 'th',
                okText: 'ตกลง',
                cancelText: 'ยกเลิก'
            });

            $(document).on('change', '[name="project_type"]', function(){
                $('#div-project-main').hide();
                if ($(this).val() == '10002')
                {
                    $('#div-project-main').show();
                }
            });
            
            // Defining the local dataset
            var projects = ['@php echo implode("','", \Arr::pluck($projects_parent, "description")) @endphp'];

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
        });
    });
</script>
