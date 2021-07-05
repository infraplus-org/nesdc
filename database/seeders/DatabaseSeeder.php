<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        DB::table('masters')->insert([
            // Type of project
            ['type' => 'ProjectType', 'code' => '10001', 'ranking' => 1, 'description' => 'ขออนุมัติโครงการ',],
            ['type' => 'ProjectType', 'code' => '10002', 'ranking' => 2, 'description' => 'ขอความคิดเห็นประกอบการพิจารณาของ ครม./หน่วยงาน',],
            ['type' => 'ProjectType', 'code' => '10003', 'ranking' => 3, 'description' => 'ขอความเห็นของแผนระดับที่ 3 (ไม่มีบทบัญญัติตามกฏหมาย)',],
            ['type' => 'ProjectType', 'code' => '10004', 'ranking' => 4, 'description' => 'ขอความเห็นของแผนระดับที่ 3 (มีบทบัญญัติตามกฏหมาย)',],
            ['type' => 'ProjectType', 'code' => '10005', 'ranking' => 5, 'description' => 'ไม่พิจารณา',],
            // Division
            ['type' => 'Division', 'code' => '11001', 'ranking' => 1, 'description' => 'หน่วยงานราชการ',],
            ['type' => 'Division', 'code' => '11002', 'ranking' => 2, 'description' => 'รัฐวิสาหกิจ',],
            // Department of project
            ['type' => 'DepartmentProject', 'code' => '12001', 'ranking' => 1, 'description' => 'การท่าเรือแห่งประเทศไทย',],
            ['type' => 'DepartmentProject', 'code' => '12002', 'ranking' => 2, 'description' => 'รฟม.',],
            // Ministry
            ['type' => 'Ministry', 'code' => '13000', 'ranking' =>  1, 'description' => 'สำนักนายกรัฐมนตรี',],
            ['type' => 'Ministry', 'code' => '13001', 'ranking' =>  2, 'description' => 'กระทรวงกลาโหม',],
            ['type' => 'Ministry', 'code' => '13002', 'ranking' =>  3, 'description' => 'กระทรวงการคลัง',],
            ['type' => 'Ministry', 'code' => '13003', 'ranking' =>  4, 'description' => 'กระทรวงการต่างประเทศ',],
            ['type' => 'Ministry', 'code' => '13004', 'ranking' =>  5, 'description' => 'กระทรวงการท่องเที่ยวและกีฬา',],
            ['type' => 'Ministry', 'code' => '13005', 'ranking' =>  6, 'description' => 'กระทรวงการพัฒนาสังคมและความมั่นคงของมนุษย์',],
            ['type' => 'Ministry', 'code' => '13006', 'ranking' =>  7, 'description' => 'กระทรวงเกษตรและสหกรณ์',],
            ['type' => 'Ministry', 'code' => '13007', 'ranking' =>  8, 'description' => 'กระทรวงคมนาคม',],
            ['type' => 'Ministry', 'code' => '13008', 'ranking' =>  9, 'description' => 'กระทรวงดิจิทัลเพื่อเศรษฐกิจและสังคม',],
            ['type' => 'Ministry', 'code' => '13009', 'ranking' => 10, 'description' => 'กระทรวงทรัพยากรธรรมชาติและสิ่งแวดล้อม',],
            ['type' => 'Ministry', 'code' => '13010', 'ranking' => 11, 'description' => 'กระทรวงพลังงาน',],
            ['type' => 'Ministry', 'code' => '13011', 'ranking' => 12, 'description' => 'กระทรวงพาณิชย์',],
            ['type' => 'Ministry', 'code' => '13012', 'ranking' => 13, 'description' => 'กระทรวงมหาดไทย',],
            ['type' => 'Ministry', 'code' => '13013', 'ranking' => 14, 'description' => 'กระทรวงยุติธรรม',],
            ['type' => 'Ministry', 'code' => '13014', 'ranking' => 15, 'description' => 'กระทรวงแรงงาน',],
            ['type' => 'Ministry', 'code' => '13015', 'ranking' => 16, 'description' => 'กระทรวงวัฒนธรรม',],
            ['type' => 'Ministry', 'code' => '13016', 'ranking' => 17, 'description' => 'กระทรวงการอุดมศึกษา วิทยาศาสตร์ วิจัยและนวัตกรรม',],
            ['type' => 'Ministry', 'code' => '13017', 'ranking' => 18, 'description' => 'กระทรวงศึกษาธิการ',],
            ['type' => 'Ministry', 'code' => '13018', 'ranking' => 19, 'description' => 'กระทรวงสาธารณสุข',],
            ['type' => 'Ministry', 'code' => '13019', 'ranking' => 20, 'description' => 'กระทรวงอุตสาหกรรม',],
            // Investment
            ['type' => 'Investment', 'code' => '14001', 'ranking' => 1, 'description' => 'ขนส่งทางถนน',],
            ['type' => 'Investment', 'code' => '14002', 'ranking' => 2, 'description' => 'ขนส่งทางราง',],
            ['type' => 'Investment', 'code' => '14003', 'ranking' => 3, 'description' => 'ขนส่งสาธารณะ',],
            ['type' => 'Investment', 'code' => '14004', 'ranking' => 4, 'description' => 'ขนส่งทางอากาศ',],
            ['type' => 'Investment', 'code' => '14005', 'ranking' => 5, 'description' => 'ขนส่งทางน้ำ',],
            ['type' => 'Investment', 'code' => '14006', 'ranking' => 6, 'description' => 'พลังงาน',],
            ['type' => 'Investment', 'code' => '14007', 'ranking' => 7, 'description' => 'ดิจิทัล',],
            ['type' => 'Investment', 'code' => '14008', 'ranking' => 8, 'description' => 'น้ำประปา',],
            ['type' => 'Investment', 'code' => '14009', 'ranking' => 9, 'description' => 'ที่อยู่อาศัย',],
            // Book
            ['type' => 'Book', 'code' => '15001', 'ranking' => 1, 'description' => 'เพื่อพิจารณาและสั่งการ',],
            // Document
            ['type' => 'Document', 'code' => '16001', 'ranking' => 1, 'description' => 'หนังสือต้นเรื่อง',],
            ['type' => 'Document', 'code' => '16002', 'ranking' => 2, 'description' => 'รายงานการศึกษาความเหมาะสมฯ',],
            ['type' => 'Document', 'code' => '16003', 'ranking' => 3, 'description' => 'ข้อมูลเพิ่มเติม (ถ้ามี)',],
            ['type' => 'Document', 'code' => '16004', 'ranking' => 4, 'description' => 'รายงานวิเคราะห์โครงการฯ',],
            ['type' => 'Document', 'code' => '16005', 'ranking' => 5, 'description' => 'หนังสือขอข้อมูลเพิ่มเติม',],
            ['type' => 'Document', 'code' => '16006', 'ranking' => 6, 'description' => 'หนังสือรับข้อมูลเพิ่มเติม',],
            ['type' => 'Document', 'code' => '16007', 'ranking' => 7, 'description' => 'ประเด็นอภิปรายและมติคณะอนุกรรมการ',],
            ['type' => 'Document', 'code' => '16008', 'ranking' => 8, 'description' => 'ประเด็นอภิปรายและมติสภาฯ สศช.',],
            ['type' => 'Document', 'code' => '16009', 'ranking' => 9, 'description' => 'ใบนำส่ง',],
            ['type' => 'Document', 'code' => '16010', 'ranking' => 10, 'description' => 'บันทึกข้อความ',],
            ['type' => 'Document', 'code' => '16011', 'ranking' => 11, 'description' => 'หนังสือครุฑแจ้งความเห็น',],
            ['type' => 'Document', 'code' => '16012', 'ranking' => 12, 'description' => 'อื่นๆ',],
            ['type' => 'Document', 'code' => '16013', 'ranking' => 13, 'description' => 'มติ ครม.',],
            // Status of project
            ['type' => 'Status', 'code' => '17001', 'ranking' => 1, 'description' => 'โครงการใหม่',],
            ['type' => 'Status', 'code' => '17002', 'ranking' => 2, 'description' => 'วิเคราะห์โครงการ',],
            ['type' => 'Status', 'code' => '17003', 'ranking' => 3, 'description' => 'เห็นชอบและลงนาม',],
            ['type' => 'Status', 'code' => '17004', 'ranking' => 4, 'description' => 'ครม.อนุมัติโครงการ',],
            ['type' => 'Status', 'code' => '17005', 'ranking' => 5, 'description' => 'อยู่ระหว่างดำเนินการ',],
            ['type' => 'Status', 'code' => '17009', 'ranking' => 9, 'description' => 'ลบ',],
            // Project activities
            ['type' => 'Activity', 'code' => '18001', 'ranking' => 1, 'description' => 'งานจัดกิจกรรมสิทธิ์ที่ดิน / จัดหาที่ดิน',],
            ['type' => 'Activity', 'code' => '18002', 'ranking' => 2, 'description' => 'ประกวดราคา / คัดเลือกเอกชนร่วมลงทุนในโครงการ',],
            ['type' => 'Activity', 'code' => '18003', 'ranking' => 3, 'description' => 'ก่อสร้างงานโยธาและติดตั้งงานระบบ',],
            ['type' => 'Activity', 'code' => '18004', 'ranking' => 4, 'description' => 'จัดหาอุปกรณ์อื่นๆ',],
            ['type' => 'Activity', 'code' => '18005', 'ranking' => 5, 'description' => 'ทดสอบระบบ / เปิดให้บริการ หรือเริ่มดำเนินงานโครงการ',],
            ['type' => 'Activity', 'code' => '18006', 'ranking' => 6, 'description' => 'อื่นๆ (ถ้ามี)',],
            // Document Group
            ['type' => 'DocumentGroup', 'code' => '19001', 'ranking' => 1, 'description' => 'เอกสารอนุมัติโครงการ',],
            ['type' => 'DocumentGroup', 'code' => '19002', 'ranking' => 2, 'description' => 'เอกสารขอความเห็นประกอบการพิจารณาของ ครม./หน่วยงาน',],
            ['type' => 'DocumentGroup', 'code' => '19003', 'ranking' => 3, 'description' => 'การติดตามโครงการ',],

            // Prefix
            ['type' => 'Prefix', 'code' => '20001', 'ranking' => 1, 'description' => 'นาย',],
            ['type' => 'Prefix', 'code' => '20002', 'ranking' => 2, 'description' => 'นาง',],
            ['type' => 'Prefix', 'code' => '20003', 'ranking' => 3, 'description' => 'นางสาว',],
            // Department of contact
            ['type' => 'DepartmentContact', 'code' => '21001', 'ranking' => 1, 'description' => 'ส่วนขนส่งทางบก',],
            ['type' => 'DepartmentContact', 'code' => '21002', 'ranking' => 2, 'description' => 'ส่วนขนส่งทางน้ำและทางอากาศ',],
            ['type' => 'DepartmentContact', 'code' => '21003', 'ranking' => 3, 'description' => 'ส่วนพลังงาน',],
            ['type' => 'DepartmentContact', 'code' => '21004', 'ranking' => 4, 'description' => 'ส่วนดิจิทัล',],
            ['type' => 'DepartmentContact', 'code' => '21005', 'ranking' => 5, 'description' => 'ส่วนสาธารณูปโภคและสาธารณูปการ',],
            // Source of Fund
            ['type' => 'SourceOfFund', 'code' => '22001', 'ranking' => 1, 'description' => 'เงินงบประมาณแผ่นดิน',],
            ['type' => 'SourceOfFund', 'code' => '22002', 'ranking' => 2, 'description' => 'เงินกู้ภายในประเทศ',],
            ['type' => 'SourceOfFund', 'code' => '22003', 'ranking' => 3, 'description' => 'เงินรายได้',],
            ['type' => 'SourceOfFund', 'code' => '22004', 'ranking' => 4, 'description' => 'เงินกองทุน',],
            ['type' => 'SourceOfFund', 'code' => '22005', 'ranking' => 5, 'description' => 'เอกชนร่วมลงทุน (PPP)',],
            ['type' => 'SourceOfFund', 'code' => '22006', 'ranking' => 6, 'description' => 'แหล่งเงินอื่นๆ',],

            // Area
            ['type' => 'AreaLevel', 'code' => '30001', 'ranking' => 1, 'description' => 'ระดับประเทศ',],
            ['type' => 'AreaLevel', 'code' => '30002', 'ranking' => 2, 'description' => 'ระดับภูมิภาค/กลุ่มจังหวัด',],
            ['type' => 'AreaLevel', 'code' => '30003', 'ranking' => 3, 'description' => 'ระดับจังหวัด',],
            ['type' => 'AreaLevel', 'code' => '30004', 'ranking' => 4, 'description' => 'ระดับอำเภอ',],
            ['type' => 'AreaLevel', 'code' => '30005', 'ranking' => 5, 'description' => 'ระดับตำบล',],
            ['type' => 'AreaLevel', 'code' => '30006', 'ranking' => 6, 'description' => 'ระดับหมู่บ้าน',],
            ['type' => 'AreaLevel', 'code' => '30007', 'ranking' => 7, 'description' => 'ระดับอื่นๆ',],
            // Province
            ['type' => 'Province', 'code' => '31001', 'ranking' => 1, 'description' => 'กรุงเทพมหานคร',],
            ['type' => 'Province', 'code' => '31002', 'ranking' => 2, 'description' => 'กระบี่',],
            ['type' => 'Province', 'code' => '31003', 'ranking' => 3, 'description' => 'กาญจนบุรี',],
            ['type' => 'Province', 'code' => '31004', 'ranking' => 4, 'description' => 'กาฬสินธุ์',],
            ['type' => 'Province', 'code' => '31005', 'ranking' => 5, 'description' => 'กำแพงเพชร',],
            ['type' => 'Province', 'code' => '31006', 'ranking' => 6, 'description' => 'ขอนแก่น',],
            ['type' => 'Province', 'code' => '31007', 'ranking' => 7, 'description' => 'จันทบุรี',],
            ['type' => 'Province', 'code' => '31008', 'ranking' => 8, 'description' => 'ฉะเชิงเทรา',],
            ['type' => 'Province', 'code' => '31009', 'ranking' => 9, 'description' => 'ชัยนาท',],
            ['type' => 'Province', 'code' => '31010', 'ranking' => 10, 'description' => 'ชัยภูมิ',],
            ['type' => 'Province', 'code' => '31011', 'ranking' => 11, 'description' => 'ชุมพร',],
            ['type' => 'Province', 'code' => '31012', 'ranking' => 12, 'description' => 'ชลบุรี',],
            ['type' => 'Province', 'code' => '31013', 'ranking' => 13, 'description' => 'เชียงใหม่',],
            ['type' => 'Province', 'code' => '31014', 'ranking' => 14, 'description' => 'เชียงราย',],
            ['type' => 'Province', 'code' => '31015', 'ranking' => 15, 'description' => 'ตรัง',],
            ['type' => 'Province', 'code' => '31016', 'ranking' => 16, 'description' => 'ตราด',],
            ['type' => 'Province', 'code' => '31017', 'ranking' => 17, 'description' => 'ตาก',],
            ['type' => 'Province', 'code' => '31018', 'ranking' => 18, 'description' => 'นครนายก',],
            ['type' => 'Province', 'code' => '31019', 'ranking' => 19, 'description' => 'นครปฐม',],
            ['type' => 'Province', 'code' => '31020', 'ranking' => 20, 'description' => 'นครพนม',],
            ['type' => 'Province', 'code' => '31021', 'ranking' => 21, 'description' => 'นครราชสีมา',],
            ['type' => 'Province', 'code' => '31022', 'ranking' => 22, 'description' => 'นครศรีธรรมราช',],
            ['type' => 'Province', 'code' => '31023', 'ranking' => 23, 'description' => 'นครสวรรค์',],
            ['type' => 'Province', 'code' => '31024', 'ranking' => 24, 'description' => 'นราธิวาส',],
            ['type' => 'Province', 'code' => '31025', 'ranking' => 25, 'description' => 'น่าน',],
            ['type' => 'Province', 'code' => '31026', 'ranking' => 26, 'description' => 'นนทบุรี',],
            ['type' => 'Province', 'code' => '31027', 'ranking' => 27, 'description' => 'บึงกาฬ',],
            ['type' => 'Province', 'code' => '31028', 'ranking' => 28, 'description' => 'บุรีรัมย์',],
            ['type' => 'Province', 'code' => '31029', 'ranking' => 29, 'description' => 'ประจวบคีรีขันธ์',],
            ['type' => 'Province', 'code' => '31030', 'ranking' => 30, 'description' => 'ปทุมธานี',],
            ['type' => 'Province', 'code' => '31031', 'ranking' => 31, 'description' => 'ปราจีนบุรี',],
            ['type' => 'Province', 'code' => '31032', 'ranking' => 32, 'description' => 'ปัตตานี',],
            ['type' => 'Province', 'code' => '31033', 'ranking' => 33, 'description' => 'พะเยา',],
            ['type' => 'Province', 'code' => '31034', 'ranking' => 34, 'description' => 'พระนครศรีอยุธยา',],
            ['type' => 'Province', 'code' => '31035', 'ranking' => 35, 'description' => 'พังงา',],
            ['type' => 'Province', 'code' => '31036', 'ranking' => 36, 'description' => 'พิจิตร',],
            ['type' => 'Province', 'code' => '31037', 'ranking' => 37, 'description' => 'พิษณุโลก',],
            ['type' => 'Province', 'code' => '31038', 'ranking' => 38, 'description' => 'เพชรบุรี',],
            ['type' => 'Province', 'code' => '31039', 'ranking' => 39, 'description' => 'เพชรบูรณ์',],
            ['type' => 'Province', 'code' => '31040', 'ranking' => 40, 'description' => 'แพร่',],
            ['type' => 'Province', 'code' => '31041', 'ranking' => 41, 'description' => 'พัทลุง',],
            ['type' => 'Province', 'code' => '31042', 'ranking' => 42, 'description' => 'ภูเก็ต',],
            ['type' => 'Province', 'code' => '31043', 'ranking' => 43, 'description' => 'มหาสารคาม',],
            ['type' => 'Province', 'code' => '31044', 'ranking' => 44, 'description' => 'มุกดาหาร',],
            ['type' => 'Province', 'code' => '31045', 'ranking' => 45, 'description' => 'แม่ฮ่องสอน',],
            ['type' => 'Province', 'code' => '31046', 'ranking' => 45, 'description' => 'ยโสธร',],
            ['type' => 'Province', 'code' => '31047', 'ranking' => 47, 'description' => 'ยะลา',],
            ['type' => 'Province', 'code' => '31048', 'ranking' => 48, 'description' => 'ร้อยเอ็ด',],
            ['type' => 'Province', 'code' => '31049', 'ranking' => 49, 'description' => 'ระนอง',],
            ['type' => 'Province', 'code' => '31050', 'ranking' => 50, 'description' => 'ระยอง',],
            ['type' => 'Province', 'code' => '31051', 'ranking' => 51, 'description' => 'ราชบุรี',],
            ['type' => 'Province', 'code' => '31052', 'ranking' => 52, 'description' => 'ลพบุรี',],
            ['type' => 'Province', 'code' => '31053', 'ranking' => 53, 'description' => 'ลำปาง',],
            ['type' => 'Province', 'code' => '31054', 'ranking' => 54, 'description' => 'ลำพูน',],
            ['type' => 'Province', 'code' => '31055', 'ranking' => 55, 'description' => 'เลย',],
            ['type' => 'Province', 'code' => '31056', 'ranking' => 56, 'description' => 'ศรีสะเกษ',],
            ['type' => 'Province', 'code' => '31057', 'ranking' => 57, 'description' => 'สกลนคร',],
            ['type' => 'Province', 'code' => '31058', 'ranking' => 58, 'description' => 'สงขลา',],
            ['type' => 'Province', 'code' => '31059', 'ranking' => 59, 'description' => 'สมุทรสาคร',],
            ['type' => 'Province', 'code' => '31060', 'ranking' => 60, 'description' => 'สมุทรปราการ',],
            ['type' => 'Province', 'code' => '31061', 'ranking' => 61, 'description' => 'สมุทรสงคราม',],
            ['type' => 'Province', 'code' => '31062', 'ranking' => 62, 'description' => 'สระแก้ว',],
            ['type' => 'Province', 'code' => '31063', 'ranking' => 63, 'description' => 'สระบุรี',],
            ['type' => 'Province', 'code' => '31064', 'ranking' => 64, 'description' => 'สิงห์บุรี',],
            ['type' => 'Province', 'code' => '31065', 'ranking' => 65, 'description' => 'สุโขทัย',],
            ['type' => 'Province', 'code' => '31066', 'ranking' => 66, 'description' => 'สุพรรณบุรี',],
            ['type' => 'Province', 'code' => '31067', 'ranking' => 67, 'description' => 'สุราษฎร์ธานี',],
            ['type' => 'Province', 'code' => '31068', 'ranking' => 68, 'description' => 'สุรินทร์',],
            ['type' => 'Province', 'code' => '31069', 'ranking' => 69, 'description' => 'สตูล',],
            ['type' => 'Province', 'code' => '31070', 'ranking' => 70, 'description' => 'หนองคาย',],
            ['type' => 'Province', 'code' => '31071', 'ranking' => 71, 'description' => 'หนองบัวลำภู',],
            ['type' => 'Province', 'code' => '31072', 'ranking' => 72, 'description' => 'อำนาจเจริญ',],
            ['type' => 'Province', 'code' => '31073', 'ranking' => 73, 'description' => 'อุดรธานี',],
            ['type' => 'Province', 'code' => '31074', 'ranking' => 74, 'description' => 'อุตรดิตถ์',],
            ['type' => 'Province', 'code' => '31075', 'ranking' => 75, 'description' => 'อุทัยธานี',],
            ['type' => 'Province', 'code' => '31076', 'ranking' => 76, 'description' => 'อุบลราชธานี',],
            ['type' => 'Province', 'code' => '31077', 'ranking' => 77, 'description' => 'อ่างทอง',],
            ['type' => 'Province', 'code' => '31078', 'ranking' => 78, 'description' => 'อื่นๆ',],

            // Expansion
            ['type' => 'Expansion', 'code' => '40001', 'ranking' => 1, 'description' => 'เริ่มติดตาม',],
            ['type' => 'Expansion', 'code' => '40002', 'ranking' => 2, 'description' => 'แก้ไขข้อมูลการติดตาม',],
        ]);

        DB::table('masters')->where('type', 'Ministry')
            ->whereIn('description', [
                'สำนักนายกรัฐมนตรี',
                'กระทรวงกลาโหม',
                'กระทรวงการคลัง',
                'กระทรวงการต่างประเทศ',
                'กระทรวงการท่องเที่ยวและกีฬา',
                'กระทรวงการพัฒนาสังคมและความมั่นคงของมนุษย์',
                'กระทรวงเกษตรและสหกรณ์',
                'กระทรวงทรัพยากรธรรมชาติและสิ่งแวดล้อม',
                'กระทรวงพาณิชย์',
                'กระทรวงมหาดไทย',
                'กระทรวงยุติธรรม',
                'กระทรวงแรงงาน',
                'กระทรวงวัฒนธรรม',
                'กระทรวงการอุดมศึกษา วิทยาศาสตร์ วิจัยและนวัตกรรม',
                'กระทรวงศึกษาธิการ',
                'กระทรวงสาธารณสุข',
                'กระทรวงอุตสาหกรรม',
            ])->update(['actived' => 0]);

        DB::table('config_project')->insert([
            ['type_code' => '10001', 'operating_duration' => 45],
            ['type_code' => '10002', 'operating_duration' => 7],
            ['type_code' => '10003', 'operating_duration' => 7],
            ['type_code' => '10004', 'operating_duration' => 45],
            ['type_code' => '10005', 'operating_duration' => 0],
        ]);

        DB::table('config_project_document')->insert([
            ['type_code' => '10001', 'document_code' => '16001', 'operating_duration_reset' => 0],
            ['type_code' => '10001', 'document_code' => '16002', 'operating_duration_reset' => 0],
            ['type_code' => '10001', 'document_code' => '16003', 'operating_duration_reset' => 0],
            ['type_code' => '10001', 'document_code' => '16004', 'operating_duration_reset' => 0],
            ['type_code' => '10001', 'document_code' => '16005', 'operating_duration_reset' => 0],
            ['type_code' => '10001', 'document_code' => '16006', 'operating_duration_reset' => 1],
            ['type_code' => '10001', 'document_code' => '16007', 'operating_duration_reset' => 0],
            ['type_code' => '10001', 'document_code' => '16008', 'operating_duration_reset' => 0],
            ['type_code' => '10001', 'document_code' => '16009', 'operating_duration_reset' => 0],
            ['type_code' => '10001', 'document_code' => '16010', 'operating_duration_reset' => 0],
            ['type_code' => '10001', 'document_code' => '16011', 'operating_duration_reset' => 0],
            ['type_code' => '10001', 'document_code' => '16012', 'operating_duration_reset' => 0],
            ['type_code' => '10002', 'document_code' => '16001', 'operating_duration_reset' => 0],
            ['type_code' => '10002', 'document_code' => '16002', 'operating_duration_reset' => 0],
            ['type_code' => '10002', 'document_code' => '16003', 'operating_duration_reset' => 0],
            ['type_code' => '10002', 'document_code' => '16004', 'operating_duration_reset' => 0],
            ['type_code' => '10002', 'document_code' => '16005', 'operating_duration_reset' => 0],
            ['type_code' => '10002', 'document_code' => '16006', 'operating_duration_reset' => 0],
            ['type_code' => '10002', 'document_code' => '16007', 'operating_duration_reset' => 0],
            ['type_code' => '10002', 'document_code' => '16008', 'operating_duration_reset' => 0],
            ['type_code' => '10002', 'document_code' => '16009', 'operating_duration_reset' => 0],
            ['type_code' => '10002', 'document_code' => '16010', 'operating_duration_reset' => 0],
            ['type_code' => '10002', 'document_code' => '16011', 'operating_duration_reset' => 0],
            ['type_code' => '10002', 'document_code' => '16012', 'operating_duration_reset' => 0],
            ['type_code' => '10003', 'document_code' => '16001', 'operating_duration_reset' => 0],
            ['type_code' => '10003', 'document_code' => '16002', 'operating_duration_reset' => 0],
            ['type_code' => '10003', 'document_code' => '16003', 'operating_duration_reset' => 0],
            ['type_code' => '10003', 'document_code' => '16004', 'operating_duration_reset' => 0],
            ['type_code' => '10003', 'document_code' => '16005', 'operating_duration_reset' => 0],
            ['type_code' => '10003', 'document_code' => '16006', 'operating_duration_reset' => 0],
            ['type_code' => '10003', 'document_code' => '16007', 'operating_duration_reset' => 0],
            ['type_code' => '10003', 'document_code' => '16008', 'operating_duration_reset' => 0],
            ['type_code' => '10003', 'document_code' => '16009', 'operating_duration_reset' => 0],
            ['type_code' => '10003', 'document_code' => '16010', 'operating_duration_reset' => 0],
            ['type_code' => '10003', 'document_code' => '16011', 'operating_duration_reset' => 0],
            ['type_code' => '10003', 'document_code' => '16012', 'operating_duration_reset' => 0],
            ['type_code' => '10004', 'document_code' => '16001', 'operating_duration_reset' => 0],
            ['type_code' => '10004', 'document_code' => '16002', 'operating_duration_reset' => 0],
            ['type_code' => '10004', 'document_code' => '16003', 'operating_duration_reset' => 0],
            ['type_code' => '10004', 'document_code' => '16004', 'operating_duration_reset' => 0],
            ['type_code' => '10004', 'document_code' => '16005', 'operating_duration_reset' => 0],
            ['type_code' => '10004', 'document_code' => '16006', 'operating_duration_reset' => 1],
            ['type_code' => '10004', 'document_code' => '16007', 'operating_duration_reset' => 0],
            ['type_code' => '10004', 'document_code' => '16008', 'operating_duration_reset' => 0],
            ['type_code' => '10004', 'document_code' => '16009', 'operating_duration_reset' => 0],
            ['type_code' => '10004', 'document_code' => '16010', 'operating_duration_reset' => 0],
            ['type_code' => '10004', 'document_code' => '16011', 'operating_duration_reset' => 0],
            ['type_code' => '10004', 'document_code' => '16012', 'operating_duration_reset' => 0],
        ]);

        /*******************
         * For test
         ********************/
        DB::table('contacts')->insert([[
            'prefix_code' => '20001', 
            'fname' => 'สมชาย',
            'lname' => 'ใจดี', 
            'position' => 'Manager',
            'department_code' => '21002',
            'email_division' => 'demo@nesdc.com',
            'email' => 'demo@hotmail.com',
            'tel' => '0811234567',
            'fax' => '022223333',
            'created_by' => '123',
            'updated_by' => '123',
        ],[
            'prefix_code' => '20001', 
            'fname' => 'สมหญิง',
            'lname' => 'คิดดี', 
            'position' => 'Supervisor',
            'department_code' => '21001',
            'email_division' => 'test@nesdc.com',
            'email' => 'test@hotmail.com',
            'tel' => '0811234567',
            'fax' => '022223333',
            'created_by' => '123',
            'updated_by' => '123',
        ]]);

        DB::table('projects')->insert([[
            'description' => 'โครงการพัฒนาท่าเทียบเรือชายฝั่ง(ท่าเทียบเรือ A) ที่ท่าเรือแหลมฉบัง',
            'contact_id' => 1,
            'type_code' => '10001',
            'status_code' => '17004',
            'registration_number' => '2927/2556',
            'book_issued_at' => '2021-03-24 11:50',
            'book_code' => '15001',
            'book_number' => 'นร 0506/ว(ล) 18113',
            'ministry_code' => '13007',
            'division_code' => '11001',
            'department_code' => '12001',
            'investment_code' => '14005',
            'operating_begin' => Carbon::now()->addDays(-2),
            'operating_deadline' => Carbon::now()->addDays(5),
            'budget' => 200,
            'area_level_code' => '30003',
            'area' => 'ชลบุรี;กรุงเทพมหานคร;',
            'area_detail' => 'ท่าเรือแหลมฉบัง',
            'plan_begin_day' => '1',
            'plan_begin_month' => '1',
            'plan_begin_year' => '2559',
            'plan_end_day' => '30',
            'plan_end_month' => '12',
            'plan_end_year' => '2561',
            'proposal' => 'ข้อเสนอพิจารณา (Lorem yipsum)',
            'story' => 'ความเป็นมา (Lorem yipsum)',
            'objective' => 'วัตถุประสงค์ (Lorem yipsum)',
            'goal' => 'เป้าหมาย (Lorem yipsum)',
            'created_by' => '1',
            'updated_by' => '1',
        ],[
            'description' => 'ก่อสร้างทางหลวง',
            'contact_id' => 1,
            'type_code' => '10002',
            'status_code' => '17002',
            'registration_number' => '2927/2560',
            'book_issued_at' => '2021-03-24 11:50',
            'book_code' => '15001',
            'book_number' => 'นร 0506/ว(ล) 18113',
            'ministry_code' => '13007',
            'division_code' => '11001',
            'department_code' => '12002',
            'investment_code' => '14001',
            'operating_begin' => Carbon::now()->addDays(-15),
            'operating_deadline' => Carbon::now()->addDays(30),
            'budget' => 1000,
            'area_level_code' => '30003',
            'area' => 'ชลบุรี;',
            'area_detail' => '',
            'plan_begin_day' => null,
            'plan_begin_month' => null,
            'plan_begin_year' => '2560',
            'plan_end_day' => null,
            'plan_end_month' => null,
            'plan_end_year' => '2562',
            'proposal' => 'ข้อเสนอพิจารณา (Lorem yipsum)',
            'story' => 'ความเป็นมา (Lorem yipsum)',
            'objective' => 'วัตถุประสงค์ (Lorem yipsum)',
            'goal' => 'เป้าหมาย (Lorem yipsum)',
            'created_by' => '1',
            'updated_by' => '1',
        ],[
            'description' => 'ก่อสร้างรถไฟฟ้าสายสีเขียว',
            'contact_id' => 2,
            'type_code' => '10002',
            'status_code' => '17001',
            'registration_number' => '2927/2556',
            'book_issued_at' => '2021-02-21 11:50',
            'book_code' => '15001',
            'book_number' => 'นร 0506/ว(ล) 18113',
            'ministry_code' => '13007',
            'division_code' => '11001',
            'department_code' => '12002',
            'investment_code' => '14002',
            'operating_begin' => Carbon::now(),
            'operating_deadline' => Carbon::now()->addDays(45),
            'budget' => 0,
            'area_level_code' => '30002',
            'area' => 'กรุงเทพมหานคร;สมุทรปราการ;',
            'area_detail' => '',
            'plan_begin_day' => null,
            'plan_begin_month' => null,
            'plan_begin_year' => null,
            'plan_end_day' => null,
            'plan_end_month' => null,
            'plan_end_year' => null,
            'proposal' => 'ข้อเสนอพิจารณา (Lorem yipsum)',
            'story' => 'ความเป็นมา (Lorem yipsum)',
            'objective' => 'วัตถุประสงค์ (Lorem yipsum)',
            'goal' => 'เป้าหมาย (Lorem yipsum)',
            'created_by' => '1',
            'updated_by' => '1',
        ]]);
/*
        DB::table('projects_activity')->insert([
            ['project_id' => 1, 'description' => 'งานจัดกิจกรรมสิทธิ์ที่ดิน / จัดหาที่ดิน', 'period' => 2014, 'budget' => 0],
            ['project_id' => 1, 'description' => 'งานจัดกิจกรรมสิทธิ์ที่ดิน / จัดหาที่ดิน', 'period' => 2015, 'budget' => 0],
            ['project_id' => 1, 'description' => 'ประกวดราคา / คัดเลือกเอกชนร่วมลงทุนในโครงการ', 'period' => 2014, 'budget' => 0],
            ['project_id' => 1, 'description' => 'ประกวดราคา / คัดเลือกเอกชนร่วมลงทุนในโครงการ', 'period' => 2015, 'budget' => 0],
            ['project_id' => 1, 'description' => 'ก่อสร้างงานโยธาและติดตั้งงานระบบ', 'period' => 2014, 'budget' => 0],
            ['project_id' => 1, 'description' => 'ก่อสร้างงานโยธาและติดตั้งงานระบบ', 'period' => 2015, 'budget' => 0],
            ['project_id' => 1, 'description' => 'จัดหาอุปกรณ์อื่นๆ', 'period' => 2014, 'budget' => 0],
            ['project_id' => 1, 'description' => 'จัดหาอุปกรณ์อื่นๆ', 'period' => 2015, 'budget' => 0],
            ['project_id' => 1, 'description' => 'ทดสอบระบบ / เปิดให้บริการ หรือเริ่มดำเนินงานโครงการ', 'period' => 2014, 'budget' => 0],
            ['project_id' => 1, 'description' => 'ทดสอบระบบ / เปิดให้บริการ หรือเริ่มดำเนินงานโครงการ', 'period' => 2015, 'budget' => 0],
            ['project_id' => 1, 'description' => 'อื่นๆ (ถ้ามี)', 'period' => 2014, 'budget' => 0],
            ['project_id' => 1, 'description' => 'อื่นๆ (ถ้ามี)', 'period' => 2015, 'budget' => 0]
        ]);

        DB::table('projects_activity_sub')->insert([
            ['activity_id' => 3, 'description' => 'ค่าก่อสร้าง', 'budget' => 478.20],
            ['activity_id' => 3, 'description' => 'ค่าก่อสร้าง', 'budget' => 628.86],
            ['activity_id' => 3, 'description' => 'ค่าเครื่องมือยกขนหลัก', 'budget' => 279.91],
            ['activity_id' => 3, 'description' => 'ค่าเครื่องมือยกขนหลัก', 'budget' => 419.87],
            ['activity_id' => 3, 'description' => 'ค่าควบคุมงานก่อสร้าง', 'budget' => 22.14],
            ['activity_id' => 3, 'description' => 'ค่าควบคุมงานก่อสร้าง', 'budget' => 33.21],
            ['activity_id' => 3, 'description' => 'ค่าตรวจสอบผลกระทบสิ่งแวดล้อมระหว่างก่อสร้าง', 'budget' => 2],
            ['activity_id' => 3, 'description' => 'ค่าตรวจสอบผลกระทบสิ่งแวดล้อมระหว่างก่อสร้าง', 'budget' => 0]
        ]);
*/

        DB::table('projects_activity')->insert([
            ['project_id' => 1, 'activity_code' => '18001', 'sub_activity_desc' => null, 'period' => 2559, 'budget' => 0],
            ['project_id' => 1, 'activity_code' => '18001', 'sub_activity_desc' => null, 'period' => 2560, 'budget' => 0],
            ['project_id' => 1, 'activity_code' => '18002', 'sub_activity_desc' => null, 'period' => 2559, 'budget' => 0],
            ['project_id' => 1, 'activity_code' => '18002', 'sub_activity_desc' => null, 'period' => 2560, 'budget' => 0],
            ['project_id' => 1, 'activity_code' => '18003', 'sub_activity_desc' => null, 'period' => 2559, 'budget' => 782.25],
            ['project_id' => 1, 'activity_code' => '18003', 'sub_activity_desc' => null, 'period' => 2560, 'budget' => 1081.94],
            ['project_id' => 1, 'activity_code' => '18003', 'sub_activity_desc' => 'ค่าก่อสร้าง', 'period' => 2559, 'budget' => 478.20],
            ['project_id' => 1, 'activity_code' => '18003', 'sub_activity_desc' => 'ค่าก่อสร้าง', 'period' => 2560, 'budget' => 628.86],
            ['project_id' => 1, 'activity_code' => '18003', 'sub_activity_desc' => 'ค่าเครื่องมือยกขนหลัก', 'period' => 2559, 'budget' => 279.91],
            ['project_id' => 1, 'activity_code' => '18003', 'sub_activity_desc' => 'ค่าเครื่องมือยกขนหลัก', 'period' => 2560, 'budget' => 419.87],
            ['project_id' => 1, 'activity_code' => '18003', 'sub_activity_desc' => 'ค่าควบคุมงานก่อสร้าง', 'period' => 2559, 'budget' => 22.14],
            ['project_id' => 1, 'activity_code' => '18003', 'sub_activity_desc' => 'ค่าควบคุมงานก่อสร้าง', 'period' => 2560, 'budget' => 33.21],
            ['project_id' => 1, 'activity_code' => '18003', 'sub_activity_desc' => 'ค่าตรวจสอบผลกระทบสิ่งแวดล้อมระหว่างก่อสร้าง', 'period' => 2559, 'budget' => 2],
            ['project_id' => 1, 'activity_code' => '18003', 'sub_activity_desc' => 'ค่าตรวจสอบผลกระทบสิ่งแวดล้อมระหว่างก่อสร้าง', 'period' => 2560, 'budget' => 0],
            ['project_id' => 1, 'activity_code' => '18004', 'sub_activity_desc' => null, 'period' => 2559, 'budget' => 0],
            ['project_id' => 1, 'activity_code' => '18004', 'sub_activity_desc' => null, 'period' => 2560, 'budget' => 0],
            ['project_id' => 1, 'activity_code' => '18005', 'sub_activity_desc' => null, 'period' => 2559, 'budget' => 0],
            ['project_id' => 1, 'activity_code' => '18005', 'sub_activity_desc' => null, 'period' => 2560, 'budget' => 0],
            ['project_id' => 1, 'activity_code' => '18006', 'sub_activity_desc' => null, 'period' => 2559, 'budget' => 0],
            ['project_id' => 1, 'activity_code' => '18006', 'sub_activity_desc' => null, 'period' => 2560, 'budget' => 0],
        ]);

        DB::table('projects_budget')->insert([[
            'project_id' => 1, 
            'investment_type' => 'รัฐลงทุน', 
            'included_vat' => 1, 
            'capital' => 0, 
            'subsidy' => 200, 
            'loan' => 0, 
            'borrow' => 0, 
            'finance' => 0, 
            'bank' => 0, 
            'bond' => 0, 
            'revenue' => 0, 
            'fund' => 0, 
            'ppp' => 0, 
            'others' => 0, 
            'others_desc' => 'Lorem yipsum...', 
        ]]);

        DB::table('projects_document')->insert([
            ['project_id' => 1, 'book_code' => '16001', 'imported_at' => '2021-02-08', 'detail' => 'รายละเอียดเพิ่มเติม...', 'filename' => '1/demo.pdf', 'extension' => 'pdf', 'created_by' => 1, 'updated_by' => 1],
            ['project_id' => 1, 'book_code' => '16002', 'imported_at' => '2021-02-08', 'detail' => 'รายละเอียดเพิ่มเติม...', 'filename' => '1/demo.png', 'extension' => 'png', 'created_by' => 1, 'updated_by' => 1],
            ['project_id' => 1, 'book_code' => '16008', 'imported_at' => '2021-02-28', 'detail' => 'รายละเอียดเพิ่มเติม...', 'filename' => '1/demo.txt', 'extension' => 'txt', 'created_by' => 1, 'updated_by' => 1],
        ]);
        
        DB::table('projects_plan')->insert([
            ['project_id' => 1, 'description' => 'แผน 1', 'duration' => '2559'],
            ['project_id' => 1, 'description' => 'แผน 2', 'duration' => '1 มกราคม 2560 - 30 มิถุนายน 2561'],
            ['project_id' => 1, 'description' => 'แผน 3', 'duration' => '2560 - 2561'],
        ]);

        DB::table('projects_return')->insert([
            ['project_id' => 1, 'type' => 'Finance', 'description' => 'FIRR', 'value' => 10.19, 'unit' => '%', 'remark' => ''],
            ['project_id' => 1, 'type' => 'Finance', 'description' => 'NPV', 'value' => 378.69, 'unit' => 'ล้านบาท', 'remark' => 'Discount Rate ร้อยละ 8'],
            ['project_id' => 1, 'type' => 'Finance', 'description' => 'B/C Ratio', 'value' => 1.22, 'unit' => 'เท่า', 'remark' => ''],
            ['project_id' => 1, 'type' => 'Economic', 'description' => 'EIRR', 'value' => 10.19, 'unit' => '%', 'remark' => ''],
            ['project_id' => 1, 'type' => 'Economic', 'description' => 'NPV', 'value' => 378.69, 'unit' => 'ล้านบาท', 'remark' => 'Discount Rate ร้อยละ 8'],
            ['project_id' => 1, 'type' => 'Economic', 'description' => 'B/C Ratio', 'value' => 1.22, 'unit' => 'เท่า', 'remark' => ''],
        ]);

        DB::table('users')->insert([
            ['name' => 'Admin', 'email' => 'admin@nesdc.com', 'role' => '23001', 'password' => '$2y$10$QnMduITzq6c2yea/9J2jfuG1Hdv6apsVa6YOD6Kf.yNrb/7FKmjHa',],
            ['name' => 'Management', 'email' => 'management@nesdc.com', 'role' => '23002', 'password' => '$2y$10$QnMduITzq6c2yea/9J2jfuG1Hdv6apsVa6YOD6Kf.yNrb/7FKmjHa',],
            ['name' => 'User', 'email' => 'user@nesdc.com', 'role' => '23003', 'password' => '$2y$10$QnMduITzq6c2yea/9J2jfuG1Hdv6apsVa6YOD6Kf.yNrb/7FKmjHa',],
            ['name' => 'UserOther', 'email' => 'userother@nesdc.com', 'role' => '23004', 'password' => '$2y$10$QnMduITzq6c2yea/9J2jfuG1Hdv6apsVa6YOD6Kf.yNrb/7FKmjHa',],
        ]);
    }
}


