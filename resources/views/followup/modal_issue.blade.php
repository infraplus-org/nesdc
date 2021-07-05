<input type="hidden" name="project_id" value="{{ $project_id }}">
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header pb-3">
            <h5 class="modal-title text-white"  >
                <div class="header"><i class="zmdi zmdi-alert-triangle"></i> ปัญหา / อุปสรรค</div>
            </h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">ปิด <span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body body display-6">
            <div class="row col-12 justify-content-center">
                <div id="lbl-response" role="alert"></div>
            </div>
            <div class="row">
                <label for="division" class="col-sm-3 col-form-label">วันที่พบปัญหา / อุปสรรค</label>
                <div class="col-sm-6">
                    <div class="d-flex position-relative">
                        <input type="text" id="datepicker" class="f-9 form-control border-secondary datetimepicker" name="issue_date" placeholder="วันที่พบปัญหา / อุปสรรค" value="">
                        <span class="float-icon-right"><i class="zmdi zmdi-calendar"></i></span>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <label for="division" class="col-sm-3 col-form-label">ปัญหา / อุปสรรค</label>
                <div class="col-sm-9">
                    <textarea name="issue_desc" cols="10" rows="5" class="form-control" placeholder="ปัญหา / อุปสรรค"></textarea>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 text-right">
                    <button type="button" class="btn btn-secondary btn-round" data-dismiss="modal">ยกเลิก</button>
                    <button type="button" class="btn btn-primary btn-round" id="btn-issue-save">บันทึก</button>
                </div>
            </div>
            <div class="row">
                <div class="body table-responsive col-12">
                    <table id="tbl-issues-add" class="table table-sm table-bordered" style="width: 100%;">
                        <thead class="table-dark">
                            <tr>
                                <td>วันที่พบปัญหา / อุปสรรค</td>
                                <td>ปัญหา / อุปสรรค</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($issues as $issue)
                                <tr>
                                    <td>{{ DateFormat($issue->issue_date, 'MMM YYYY', false) }}</td>
                                    <td>{{ $issue->issue_desc }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        var m = moment().add(543, 'year');
        $('.datetimepicker').bootstrapMaterialDatePicker({
            format: 'YYYY-MM',
            clearButton: false,
            time: false,
            currentDate: m,
            // minDate: m,
            lang: 'th',
            okText: 'ตกลง',
            cancelText: 'ยกเลิก'
        });
        
        var tbl = $('#tbl-issues-add').DataTable({
            bLengthChange: false,
            columnDefs: [
                { width: "30%", targets: 0 },
            ],
            language: { 
                loadingRecords: '<h3 class="text-center text-secondary p-3">กำลังโหลด...</h3>', 
                zeroRecords: '<h3 class="text-center text-muted p-3">ไม่พบข้อมูล</h3>' 
            }    
        }).column(0).search(m.year()).draw();

        // กดปุ่ม "บันทึก"
        $(document).on('click', '#btn-issue-save', function() {
            $.ajax({
                type: "POST",
                url: "{{ $url_add }}",
                data: {
                    issue_date: $('[name="issue_date"]').val(),
                    issue_desc: $('[name="issue_desc"]').val()
                },
                success: function(data){
                    if (data.result === true)
                    {
                        tbl.row.add(data.data).draw(false);
                        $('#lbl-response').removeClass().addClass('alert alert-success');
                        $('#lbl-response').text(data.message);
                    }
                    else
                    {
                        $('#lbl-response').removeClass().addClass('alert alert-danger');
                        $('#lbl-response').text(data.message);
                    }
                },
            });
        });
    });
</script>


