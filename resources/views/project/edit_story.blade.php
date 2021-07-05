<div class="card border border-info">
    <div class="header pb-0">
        <h2><strong>ความเป็นมา</strong></h2>
    </div>
    <div class="body display-6">
        <textarea name="story" class="form-control" placeholder="ความเป็นมา" rows="5">{{ $project->story }}</textarea>
    </div>
    <div class="w-100">
        <button onclick="activeTab('tab3')" type="button" class="btn btn-secondary d-flex float-right">
            <span class="d-flex align-self-center mr-2"> หัวข้อถ้ดไป</span>
            <i class="zmdi zmdi-hc-2x zmdi-long-arrow-right"></i>  
        </button>
        <button onclick="activeTab('tab1')" type="button" class="btn btn-secondary d-flex float-right">
            <i class="zmdi zmdi-hc-2x zmdi-long-arrow-left"></i>
            <span class="d-flex align-self-center ml-2"> ย้อนกลับ</span> 
        </button>
    </div>  
</div>