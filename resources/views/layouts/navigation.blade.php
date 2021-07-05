<li>
    <a href="javascript:void(0)"><i class="zmdi zmdi-home"></i><span class="m-l-5">หน้าหลัก</span></a>
</li>
<li>
    <a href="javascript:void(0)">โครงการ</a>
    <ul>
        <li>
            <span>ภาพรวมและสถิติ</span>
            <ul>
                <li><a href="{{ url('dashboard') }}">Dashboard</a></li>
                <li><a href="{{ url('project/search') }}">ค้นหาโครงการ</a></li>
            </ul>
        </li>
        <li>
            <span>พิจารณาโครงการ</span>
            <ul>
                @canany(['isAdmin','isManagement','isNesdc'])
                    <li><a href="{{ url('project/list') }}">การจัดการโครงการ</a> </li>
                @endcanany
                <li><a href="{{ url('project/manage') }}">บริหารจัดการโครงการ</a></li>
                @canany(['isAdmin','isManagement','isNesdc'])
                    <li><a href="{{ url('project/status') }}">ติดตามสถานะการพิจารณาโครงการ</a></li>
                @endcanany
            </ul>
        </li>
    </ul>
</li>
<li>
    <a href="{{ url('followup') }}">ติดตามประเมินผลโครงการ</a>
</li>
<li>
    <a href="javascript:void(0)">ข้อมูลตัวชี้วัด</a>
</li>
@canany(['isAdmin','isManagement','isNesdc'])
    <li>
        <a href="{{ url('master') }}">ข้อมูลมาสเตอร์</a>
    </li>
    <li>
        <a href="{{ url('user') }}">ข้อมูลผู้ใช้งาน</a>
    </li>
@endcanany
