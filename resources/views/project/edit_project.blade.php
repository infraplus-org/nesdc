<div class="card border border-info">
    <div class="header pb-0">
        <h2><strong>โครงการย่อย</strong></h2>
    </div>
    <div class="body display-6">
        @foreach ($project_children as $project)
            <label class="btn btn-simple btn-info align-self-center btn-sm">
                {{ $project->description }}
                <i class="zmdi zmdi-close ml-3"></i>
            </label>
        @endforeach
    </div>
    <div class="w-100">
        <button onclick="activeTab('tab3')" type="button" class="btn btn-secondary d-flex float-right">
            <i class="zmdi zmdi-hc-2x zmdi-long-arrow-left"></i>
            <span class="d-flex align-self-center ml-2"> ย้อนกลับ</span> 
        </button>
    </div>
</div>
