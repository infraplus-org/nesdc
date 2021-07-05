<section>
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header pb-3">
                <h5 class="modal-title text-white" id="">
                    <div class="header"><i class="zmdi zmdi-chart"></i> สถานะพิจารณาโครงการ</div>
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">ปิด <span aria-hidden="true">&times;</span></button>
            </div>
            <hr class="border-muted w-100 my-0" />
            <div class="modal-body">
                <div class="card">
                    <div class="body">
                        <p class="mb-0">ชื่อผู้รับผิดชอบ: {{ $user->fullname }}</p>
                        <p>ฝ่ายงาน: {{ $user->department_desc }}</p>
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>เรื่องโครงการ</th>
                                    <th>ประเภทโครงการ</th>
                                    <th>สถานะโครงการ</th>
                                    <th>ระยะเวลาดำเนินการ (วัน)</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $project)
                                    <tr class="text-center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $project->description }}</td>
                                        <td>{{ $project->type_desc }}</td>
                                        <td>{{ $project->status_desc }}</td>
                                        <td>
                                            {{ $project->operating_days }}
                                            @if ( ! empty($project->operating_deadline) && $project->operating_deadline < Carbon\Carbon::now()->addDays(config('custom.warning_project_operating')))
                                                <i class="zmdi zmdi-alert-triangle text-warning"></i>
                                            @endif
                                        </td>
                                        <td><a href="{{ url('project/' . $project->project_id . '/edit') }}"><i class="zmdi zmdi-border-color"></i></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>            
</section>

