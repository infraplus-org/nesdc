<section>
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header pb-3">
                <h5 class="modal-title text-white" id="">
                    <div class="header">แสดงข้อมูลโครงการ</div>
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">ปิด <span aria-hidden="true">&times;</span></button>
            </div>
            <hr class="border-muted w-100 my-0" />
            <div class="modal-body">
                <div class="card">
                    <div class="body display-6">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs">
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tab1">{{ $project->description }}</a></li>
                            @if ( ! empty($project->project_parent))
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab2">โครงการหลัก</a></li>
                            @endif
                        </ul>  
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane in active" id="tab1">
                                @include('followup.modal_info_followup')
                            </div>
                            @if ( ! empty($project->project_parent))
                                <div role="tabpanel" class="tab-pane" id="tab2">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

