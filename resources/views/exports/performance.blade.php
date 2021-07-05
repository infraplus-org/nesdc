<table>
    <tr>
        <td>รายงานการติดตามผลการดำเนินงาน จำแนกรายกิจกรรม</td>
    </tr>
    <tr>
        <td>ปีงบประมาณ {{ $period }}</td>
    </tr>
    <tr>
        <td>{{ $project->description }}</td>
    </tr>
</table>
<table>
    <thead>
        <tr>
            <th>กิจกรรม</th>
            <th>แผนและผลการดำเนินงาน (% งาน)</th>
            @foreach ($config_nesdc_months as $month)
                <td>{{ $month }}</td>
            @endforeach
            <th>รวม (% งาน)</th>
        </tr>
    </thead>
    <tbody style="border: 1px solid #000000;">
        @php $i = 6 @endphp
        @foreach ($activities_actual as $activity)
            <tr>
                <td rowspan="2">{{ $activity->description }}</td>
                <td>แผนตั้งต้น</td>
                @php $subtotal = 0 @endphp
                @foreach ($activity->detail as $detail)
                    @php $subtotal += $detail['budget'] @endphp
                    <td>{{ number_format($detail['budget'], 2) }}</td>
                @endforeach
                <!-- <td>{{ number_format($subtotal, 2) }}</td> -->
                <td>{{ '=SUM(C' . $i . ':N' . $i . ')' }}</td>
            </tr>
            @php $i++ @endphp
            <tr>
                <td>ผลการดำเนินงาน</td>
                @php $subtotal = 0 @endphp
                @foreach ($activity->detail as $detail)
                    @php $subtotal += $detail['actual'] @endphp
                    <td>{{ number_format($detail['actual'], 2) }}</td>
                @endforeach
                <td>{{ '=SUM(C' . $i . ':N' . $i . ')' }}</td>
            </tr>
            @php $i++ @endphp
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td></td>
            <td>รวม (% งาน)</td>
            @foreach (array_values($config_nesdc_months) as $idx => $month)
                @php $columns = []; @endphp
                @for ($j=0; $j<count($activities_actual); $j++)
                    @php $columns[] = $config_excel_columns[$idx] . ($actual_first_row + ($j * 2)); @endphp
                @endfor
                <td>{{ '=SUM(' . implode(',', $columns) . ')' }}</td>
            @endforeach
            <td>{{ '=SUM(C' . $i . ':N' . $i . ')' }}</td>
        </tr>
        <tr>
            <td></td>
            <td>ปัญหา / อุปสรรค</td>
            @php $i = 0 @endphp
            @foreach ($config_nesdc_months as $idx => $month)
                @if (isset($issues[$i]) && $idx == substr($issues[$i]->issue_date, -2))
                    <td>{{ $issues[$i]->issue_desc }}</td>
                    @php $i++ @endphp
                @else
                    <td></td>
                @endif
            @endforeach
        </tr>
    </tfoot>
</table>