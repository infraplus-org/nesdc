<style>
    .timeline {
        margin-left: 30px;
        margin-right: 30px;
        padding-top: 30px;
        padding-bottom: 20px;
        max-width: inherit;
    }
    .timeline .event {
        margin-bottom: 0;
    }
</style>

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
                            @foreach ($doc_groups as $group)
                                <div class="header pb-0">
                                    <h2><b>{{ $group->description }}</b></h2>
                                </div>
                                <div class="body row">
                                    <div class="col-sm-12">
                                        <div id="content">
                                            <ul class="timeline col-md-12">
                                                @foreach ($documents[$group->code] as $document)
                                                    <li class="event">
                                                        <span class="d-block">
                                                            <h3>{{ $document->book_desc }}
                                                            @if ( ! empty($document->filename))
                                                                <a href="{{ Storage::url($document->filename) }}" download><img class="w-2" src="{{ asset('Content/Assets/images/icons/' . $document->extension . '-30.png') }}"> <small>Download</small></a>
                                                            @endif
                                                            </h3>
                                                        </span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>  
                                    </div>                                 
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

