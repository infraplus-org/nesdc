<?php

namespace App\Exports;

// use App\ProjectsActivityPerformance;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Borders;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Support\Facades\DB;

use App\Models\ProjectsActivityExpansion;
use App\Models\ProjectsActivityIssue;
use App\Models\ProjectsActivityPerformance;
use App\Models\vProjects;

class ProjectsActivityPerformanceExport implements FromView, WithColumnWidths, WithColumnFormatting, WithStyles
{
    private $project_id;
    private $period;

    private $header_rows = 4;
    private $thead_rows = 1;
    private $tbody_rows;

    public function __construct($project_id, $period) 
    {
        $this->project_id = $project_id;
        $this->period = $period;
    }

    public function styles(Worksheet $sheet)
    {
        $table_rows = $this->header_rows + $this->thead_rows + $this->tbody_rows;
        $row_summary = $table_rows + 1;
        $row_issues = $row_summary + 1;

        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],

            // Styling a specific cell by coordinate.
            'B2' => ['font' => ['italic' => true]],

            // Styling an entire column.
            'C'  => ['font' => ['size' => 16]],

            'A:O' => [
                'font' => [
                    'name' => 'Angsana New',
                    'size' => 12
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_TOP,
                ],
            ],

            'C:O' => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
            ],

            // หัวตาราง
            'A5:O5' => [
                'font' => [
                    'bold' => true,
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => [
                        'argb' => 'FFD5D5D5',
                    ],
                ],
            ],

            // ตีเส้นตาราง
            'A5:O' . $table_rows => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
            ],
            'B' . $row_summary . ':O' . $row_summary => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
            ],
            'B' . $row_issues . ':N' . $row_issues => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
            ],

        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 40,
            'B' => 24,            
            'C' => 7,            
            'D' => 7,            
            'E' => 7,            
            'F' => 7,            
            'G' => 7,            
            'H' => 7,            
            'I' => 7,            
            'J' => 7,            
            'K' => 7,            
            'L' => 7,            
            'M' => 7,            
            'N' => 7,            
            'O' => 11,            
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_NUMBER_00,
            'D' => NumberFormat::FORMAT_NUMBER_00,
            'E' => NumberFormat::FORMAT_NUMBER_00,
            'F' => NumberFormat::FORMAT_NUMBER_00,
            'G' => NumberFormat::FORMAT_NUMBER_00,
            'H' => NumberFormat::FORMAT_NUMBER_00,
            'I' => NumberFormat::FORMAT_NUMBER_00,
            'J' => NumberFormat::FORMAT_NUMBER_00,
            'K' => NumberFormat::FORMAT_NUMBER_00,
            'L' => NumberFormat::FORMAT_NUMBER_00,
            'M' => NumberFormat::FORMAT_NUMBER_00,
            'N' => NumberFormat::FORMAT_NUMBER_00,
            'O' => NumberFormat::FORMAT_NUMBER_00,
        ];
    }

    public function view(): View
    {
        $data['config_excel_columns'] = ['C','D','E','F','G','H','I','J','K','L','M','N'];
        $data['config_nesdc_months'] = config('custom.data_nesdc_months');
        $data['period'] = $this->period;

        $data['project'] = vProjects::where('project_id', $this->project_id)->first();
        $data['current_expansion'] = ProjectsActivityExpansion::where('project_id', $this->project_id)->max('id');
        $data['activities_actual'] = DB::table('projects_activity_actual as a')
            ->leftJoin('masters as m', function ($join) {
                $join->on('m.type', '=', DB::Raw('"Activity"'));
                $join->on('m.code', '=', 'a.activity_code');
            })
            ->where('a.project_id', $this->project_id)
            ->where('a.selected', 1)
            ->where('a.expansion_id', $data['current_expansion'])
            ->where('a.period', $this->period)
            ->orderBy('a.period')
            ->orderBy('m.code')
            ->get();
        foreach ($data['activities_actual'] as $id => $tmpdata)
        {
            $data['activities_actual'][$id]->detail = ProjectsActivityPerformance::where('project_id', $this->project_id)
                ->where('period', $tmpdata->period)
                ->where('activity_code', $tmpdata->activity_code)
                ->orderBy(DB::Raw('
                    CASE month 
                        WHEN 10 THEN \'01\' 
                        WHEN 11 THEN \'02\' 
                        WHEN 12 THEN \'03\' 
                        WHEN  1 THEN \'04\' 
                        WHEN  2 THEN \'05\' 
                        WHEN  3 THEN \'06\' 
                        WHEN  4 THEN \'07\' 
                        WHEN  5 THEN \'08\' 
                        WHEN  6 THEN \'09\' 
                        WHEN  7 THEN \'10\' 
                        WHEN  8 THEN \'11\' 
                        WHEN  9 THEN \'12\' 
                    END
                '))
                ->get()
                ->toArray();
        }

        $data['issues'] = ProjectsActivityIssue::where('project_id', $this->project_id)
            ->where('issue_activity', 'ผลการดำเนินงาน')
            ->where('issue_date', 'LIKE', $this->period . '%')
            ->get();

        $this->tbody_rows = count($data['activities_actual']) * 2;
        $data['actual_first_row'] = $this->header_rows + $this->thead_rows + 2;
        return view('exports.performance', $data);
    }
}
