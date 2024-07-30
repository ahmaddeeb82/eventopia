<!DOCTYPE html>
<html>
<head>
    <title>Eventopia Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #ffffff;
            width: 90%;
            max-width: 1000px;
            padding: 40px;
            border-radius: 10px;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            padding: 12px;
            text-align: left;
        }
        table th {
            background-color: #ffe4e1;
            color: #333;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>EVENTOPIA REPORT</h1>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Sales</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->first_name . ' ' . $user->last_name }}</td>
                    <td>{{ $user->getRoleNames()[0]=='Organizer'?$user->getRoleNames()[0]:'Hall Owner' }}</td>
                    <td>{{ $user->contracts->last()->price }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
