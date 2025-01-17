<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style>
        html * {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
        }
        body {
            margin: 10px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 10px 0;
        }

        table {
            width: 100%; /* Full width for the signature table */
            border-collapse: collapse; /* Collapse borders for a cleaner look */
        }

        td {
            text-align: center; /* Center the text in each cell */
            padding: 10px; /* Add padding for better spacing */
            width: 33.3%; /* Equal width for each signature column */
        }

        .wew table,
        .wew td,
        .wew th {
            border: .5px solid black;
        }
        .wew table {
            width: 100%;
            border-collapse: collapse;
        }
        .wew th {
            padding: 3px;
            vertical-align: top;
        }
        .wew td {
            padding: 3px;
            /* vertical-align: top; */
            /* text-align: center; */
        }

        .signature-line {
            margin-top: 10px; /* Space above the signature line */
            border-top: 0.5px solid black; /* A line for the signature */
            width: 95%;
            text-align: center;
        }

        .signature {
            margin-top: 5px; /* Space above the label */
            font-size: 8px;
            text-transform: uppercase;
        }

        .signature span {
            font-weight: bold;
            font-size: 10px;
            color: #072388;
            text-transform: uppercase;
            display: block; /* Ensure the label is on a new line */
            margin-top: 5px; /* Space above the label */
        }
        .name {
            font-size: 10px;
            margin-bottom: -20px;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <!-- Your main content -->

    <!-- Footer for signatures -->
    <div class="footer">
        <table>
            <tr style="font-size: 9px;">
                <!-- <td>
                    <span class="name">{{$data['log']['prepared']['profile']['firstname']}} {{$data['log']['prepared']['profile']['lastname']}}</span>
                    <div class="signature-line"></div>
                    <span class="signature">Prepared By</span>
                </td> -->
                <td width="33.3%">
                    <span style="font-weight: bold; font-size: 9px; color: #072388;">{{$data['log']['prepared']['profile']['firstname']}} {{$data['log']['prepared']['profile']['lastname']}}</span>
                    <hr style="margin-top: 0px; margin-bottom: 1px; border: .1px solid black; width: 95%;">Prepared by
                </td>
                <td width="33.3%">
                    <span style="font-weight: bold; font-size: 9px; color: #072388;">-</span>
                    <hr style="margin-top: 0px; margin-bottom: 1px; border: .1px solid black; width: 95%;">Approved by
                </td>
                <td width="33.3%">
                    <span style="font-weight: bold; font-size: 9px; color: #072388;">-</span>
                    <hr style="margin-top: 0px; margin-bottom: 1px; border: .1px solid black; width: 100%;">Received by
                </td>
            </tr>
        </table>
    </div>

    <p style="text-align:center; margin-top: -10px; font-size: 10px;">Ateneo de Zamboanga University</p>
    <p style="text-align:center; margin-top: 3px; margin-bottom: 15px; font-size: 12px; font-weight: bold;">PAYMENT SLIP</p>

    <p style="font-size:10px;">To: <span style="font-size: 11px; font-weight: bold; margin-left: 18px;">FINANCE OFFICE</span></p>
    <p style="font-size:10px;">From: <span style="font-size: 11px; font-weight: bold; margin-left: 6px;">COLLEGE REGISTRAR'S OFFICE</span></p>

    <p style="text-align:center; margin-top: 10px; margin-bottom: 15px; font-weight: bold; font-size: 10px;"><i>Please accept payment from:</i></p>
    <center style="margin-top: -10px; margin-bottom: 10px; font-size: 9px; border: 1px solid; text-transform: uppercase; color:#000; font-weight: bold; padding: 2px;">{{$data['user']['student']['lastname']}}, {{$data['user']['student']['firstname']}} {{$data['user']['student']['middlename'][0]}}.</center>
    <center style="font-size: 9px; background-color: black; color:#fff; font-weight: bold; padding: 2px;">REQUESTS</center>
    <div class="wew">
    <table style="border: 1px solid black; font-size: 10px;">
        <thead style="background-color:#c8c8c8; padding: 5px; font-size: 9px;">
            <tr>    
                <th style="text-align: left; vertical-align: middle;" width="80%">Particulars</th>
                <th style="text-align: center; vertical-align: middle;" width="20%">Amount</th>
            </tr>
        </thead>
        <tbody>
        @foreach($data['lists'] as $index=>$list)
            <tr style="text-align: center; font-size: 9px; color: #072388;">
                <td style="text-align: left;">{{$list['document']['name']['name']}}</td>
                <td><span style="font-family: DejaVu Sans;">&#8369;</span>{{number_format(trim(str_replace(',','',$list['total']),'₱ '),2,".",",")}}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot style=" padding: 3px; font-weight: bold; background-color:#c8c8c8;">
            <tr>
                <td></td>
                <td style="font-size: 9px;"><span style="font-family: DejaVu Sans;">&#8369;</span>{{number_format(trim(str_replace(',','',$data['payment']['total']),'₱ '),2,".",",")}}</td>
            </tr>
        </tfoot>
    </table>
    </div>
</body>
</html>
