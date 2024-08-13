<!DOCTYPE html>
<html>
<head>
    <title>Eventopia Contract</title>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans;
            background-color: #FFFFFF;
            direction: rtl;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #ffffff;
            width: 80%;
            max-width: 800px;
            padding-left: 40px;
            padding-right: 80px;
            padding-top: 200px;
            padding-bottom: 40px;
            /* box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px; */
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 32px;
            color: #D03171;
        }
        .header h2 {
            margin: 0;
            font-size: 18px;
            color: #777;
        }
        .section-title {
            font-weight: bold;
            margin-top: 20px;
            font-size: 20px;
            color: #555;
        }
        .info-table {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 12px;
            vertical-align: top;
            border-bottom: 1px solid #ddd;
        }
        .info-table td:first-child {
            font-weight: bold;
            width: 30%;
            color: #333;
        }
        .info-table td:last-child {
            width: 70%;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Eventopia</h1>
            <h2>For events management</h2>
        </div>

        <div class="section-title">Client Information</div>
        <table class="info-table">
            <tr>
                <td>Client Name:</td>
                <td>{{ $user->first_name }}</td>
            </tr>
            <tr>
                <td>Role:</td>
                <td>{{ $user->getRoleNames()[0] }}</td>
            </tr>
            <tr>
                <td>Phone Number:</td>
                <td>{{ $user->phone_number }}</td>
            </tr>
            <tr>
                <td>Lounge Address:</td>
                <td>{{ $user->address }}</td>
            </tr>
        </table>

        <div class="section-title">Contract Information</div>
        <table class="info-table">
            <tr>
                <td>Start Date:</td>
                <td>{{ $user->contracts->last()->start_date }}</td>
            </tr>
            <tr>
                <td>End Date:</td>
                <td>{{ $user->contracts->last()->end_date }}</td>
            </tr>
            <tr>
                <td>Agreed Value:</td>
                <td>{{ $user->contracts->last()->price }}</td>
            </tr>
        </table>
    </div>
</body>
</html>
