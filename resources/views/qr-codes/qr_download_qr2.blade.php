<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Codes</title>
    <style>
        /* Ensure that the page is in A4 size for printing */
        @page {
            size: A4;
            /* margin-top: 2mm;
            margin-right: 1.5mm;
            margin-left: 1.5mm; */
            /* Set consistent margins for all pages */
        }

        body {
            margin: 0 !important;
            font-family: Arial, sans-serif;
            font-size: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            text-align: center;
            padding: 0px;
            vertical-align: middle;
        }

        .qr-code {
            margin-bottom: 5px;
        }

        .qr-code img {
            margin-top: 9px;
            width: 100px;
            height: 100px;
        }

        .qr-code p {
            font-size: 8px;
            margin: 0;
        }

        /* Styling for the print view */
        @media print {
            body {
                margin: 0 !important;
                padding: 0 !important;
                font-size: 8px;
            }

            table {
                page-break-inside: avoid;
            }

            .qr-code {
                margin-bottom: 5px;
            }

            .qr-code img {
                margin-top: 9px;
                width: 100px;
                height: 100px;
            }

            .qr-code p {
                font-size: 8px;
                margin: 0;
            }
        }
    </style>
</head>

<body>
    <h1 style="text-align: center;">Office Name: {{ $officeName }}</h1>
    <table>
        @foreach ($qrCodes->chunk(5) as $chunk)
            <tr>
                @foreach ($chunk as $vehicle)
                    <td>
                        <div class="qr-code">
                            <img src="{{ Storage::Url($vehicle->qr_code) }}" alt="QR Code">
                            <h2>{{ $vehicle->vehicle->vehicle_number }}</h2>
                        </div>
                    </td>
                @endforeach
                {{-- Fill empty cells if less than 5 items in the last row --}}
                @for ($i = $chunk->count(); $i < 5; $i++)
                    <td></td>
                @endfor
            </tr>
        @endforeach
    </table>
</body>
<script>
    window.onload = function() {
        window.print(); // Automatically triggers the print dialog
    };
</script>

</html>
