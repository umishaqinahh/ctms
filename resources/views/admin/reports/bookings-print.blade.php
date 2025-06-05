<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="text-center mb-4">
            <h2>Bicycle Booking Report</h2>
            <p>Period: {{ $period === 'weekly' ? 'Weekly' : 'Monthly' }} Report</p>
            <p>From {{ $startDate->format('Y-m-d') }} to {{ $endDate->format('Y-m-d') }}</p>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>User</th>
                        <th>Bicycle</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Status</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                    <tr>
                        <td>{{ $booking->id }}</td>
                        <td>{{ $booking->user->name }}</td>
                        <td>{{ $booking->bicycle->name }}</td>
                        <td>{{ $booking->start_time->format('Y-m-d H:i') }}</td>
                        <td>{{ $booking->end_time->format('Y-m-d H:i') }}</td>
                        <td>{{ ucfirst($booking->status) }}</td>
                        <td>{{ $booking->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-center mt-4">
            <button class="btn btn-primary no-print" onclick="window.print()">Print Report</button>
        </div>
    </div>
</body>
</html>