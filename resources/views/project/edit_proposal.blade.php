<div role="tabpanel" class="tab-pane" id="tab1">
    <div class="card border border-info">
        <div class="header pb-0">
            <h2><strong>ข้อเสนอพิจารณา</strong></h2>
        </div>
        <div class="body display-6">
            <textarea name="proposal" class="form-control" placeholder="ข้อเสนอพิจารณา" rows="5">{{ $project->proposal }}</textarea>
        </div>
    </div>
    <div class="card border border-info">
        <div class="header pb-0">
            <h2><strong>เอกสารที่เกี่ยวข้อง</strong></h2>
        </div>
        <div class="body row">
            <div class="col-sm-12">
                <div role="tabpanel" class="tab-pane in active" id="subtab1"> 
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
                                    <input type="text" class="f-9 form-control border-secondary datetimepicker" name="doc_imported_at" placeholder="นำเข้า ณ วันที่">
                                    <span class="float-icon-right"><i class="zmdi zmdi-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 form-row">
                            <div class="col-sm-3 form-control-label align-self-center text-sm-right">
                                <label class="font-weight-bold">รายละเอียด</label>
                            </div>
                            <div class="col-sm-7">
                                <div class="form-group">
                                    <input type="text" name="doc_detail" class="form-control border-secondary" placeholder="รายละเอียด">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 text-center">
                            <label class="btn btn-sm btn-secondary">
                                <i class="zmdi zmdi-collection-plus"></i> นำเข้าเอกสาร
                                <input type="file" name="document" hidden>
                            </label>
                        </div>
                    </div>
                </div> 
                <hr>
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
            <div class="col-sm-12">
                <button onclick="activeTab('tab2')" type="button" class="btn btn-secondary d-flex float-right">
                    <span class="d-flex align-self-center mr-2"> หัวข้อถ้ดไป</span>
                    <i class="zmdi zmdi-hc-2x zmdi-long-arrow-right"></i>  
                </button>
            </div>                                   
        </div>
    </div>
</div>
