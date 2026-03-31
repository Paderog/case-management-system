<!DOCTYPE html>
<html>
<head>
    <title>Administrative Cases</title>

    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 12px;
            margin: 30px;
        }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid black;
            padding: 6px;
            vertical-align: top;
        }

        th {
            text-align: center;
            font-weight: bold;
        }

        td {
            line-height: 1.4;
            padding: 5px;
        }

        .name { width: 22%; }
        .station { width: 23%; }
        .docket { width: 15%; }
        .nature { width: 25%; }
        .status { width: 15%; }

        @page {
            margin: 20px;
            size: A4 landscape;
        }

        /* 🔥 AUTO PAGE BREAK (NO NEED MANUAL) */
        thead {
            display: table-header-group;
        }

        tr {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>

    <div class="title">
        {{ $report->report_title }}
    </div>

    <table>
        <thead>
            <tr>
                <th class="name">Name</th>
                <th class="station">Station</th>
                <th class="docket">Docket No.</th>
                <th class="nature">Nature</th>
                <th class="status">Status</th>
            </tr>
        </thead>

        <tbody>
            @foreach($cases as $item)
            <tr>
                <td class="name">{{ $loop->iteration }}. {{ $item->name }}</td>
                <td class="station">{{ $item->station }}</td>
                <td class="docket">{{ $item->docket_no }}</td>
                @php
                    $parts = explode('||', $item->nature);
                    $text = $parts[0];
                    $color = $parts[1] ?? null;

                    $bgColor = match($color) {
                        'yellow' => '#FFD700',
                        'green' => '#28a745',
                        'red' => '#dc3545',
                        default => 'transparent'
                    };

                    $textColor = 'black';   
                @endphp

                <td class="nature" style="background-color: {{ $bgColor }}; color: {{ $textColor }};">
                    {{ $text }}
                </td>
                <td class="status">{{ $item->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
<style>
    td {
    line-height: 1.4;
    padding: 5px;
    -webkit-print-color-adjust: exact;
}
table {
    width: 100%;
    border-collapse: collapse;
    -webkit-print-color-adjust: exact;
}
</style>
</body>
</html>