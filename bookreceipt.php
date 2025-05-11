<?php
$bookingDetails = [
    'status' => 'CONFIRMED',
    'bookingDate' => 'Sun, 11 May, 2025',
    'reference' => 'DGC9S5A'
];

$flights = [
    [
        'flightNo' => 'DG 421',
        'airline' => 'Cebu Pacific Air',
        'departure' => [
            'location' => 'MANILA | MNL',
            'airport' => 'Ninoy Aquino International Airport',
            'terminal' => 'Terminal 3',
            'datetime' => 'Mon, 19 May, 2025, 08:40AM (08:40AM)'
        ],
        'arrival' => [
            'location' => 'CEBU | CEB',
            'airport' => 'Mactan-Cebu International Airport',
            'terminal' => 'Terminal 2',
            'datetime' => 'Mon, 19 May, 2025, 09:55AM (09:55AM)'
        ]
    ],
    [
        'flightNo' => 'DG 468',
        'airline' => 'Cebu Pacific Air',
        'departure' => [
            'location' => 'CEBU | CEB',
            'airport' => 'Mactan-Cebu International Airport',
            'terminal' => 'Terminal 2',
            'datetime' => 'Fri, 23 May, 2025, 02:15PM (14:15PM)'
        ],
        'arrival' => [
            'location' => 'MANILA | MNL',
            'airport' => 'Ninoy Aquino International Airport',
            'terminal' => 'Terminal 3',
            'datetime' => 'Fri, 23 May, 2025, 03:30PM (15:30PM)'
        ]
    ]
];
        $reminders = "Please arrive at the airport 2 hours before departure. Don’t forget your valid ID and passport to ensure a smooth travel process.";
        ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <title>Booking Receipt</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <style>
            body {
                font-family: Arial, sans-serif;
                padding: 20px;
            }
            .header {
                background-color:#FFDD00;
                color:rgb(0, 0, 0);
                padding: 15px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .receipt-title {
            font-size: 30px;
            font-family: 'Courier New', Courier, monospace;
            font-weight: bold;
            }
            .logo {
            font-size: 35px;
            font-weight: bold;
            }       
            .logo-icon {
            background-color: #2196F3;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            }
            .booking-card {
                margin-top: 15px;
            }
            .section-header {
                background-color: #FFDD00;
                color: #000;
                padding: 5px 10px;
                font-weight: bold;
            }
            .flight-row {
                margin-bottom: 20px;
            }
            .flight-details {
                display: flex;
                align-items: center;
            }
            .arrow {
                color: #0275BB;
                font-size: 24px;
                margin: 0 15px;
            }
            hr.dotted {
                border-top: 2px dotted #ccc;
                margin: 10px 0;
            }
            .airline-icon {
                color: #0275BB;
                font-size: 18px;
                margin-right: 5px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    <div class="header rounded">
                        <div class="logo">
                            <img src="assets/logo.png" alt="JetSetGo Logo" width="30" class="me-2" />JetSetGo</a>
                </div>
                    <div class="receipt-title">BOOKING RECEIPT</div>
                </div>

                <div class="card booking-card">
                    <div class="section-header">Booking Details</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                Status:<br>
                                <span class="fw-bold"><?php echo $bookingDetails['status']; ?></span>
                            </div>
                            <div class="col-md-4">
                                Booking Date:<br>
                                <span class="fw-bold"><?php echo $bookingDetails['bookingDate']; ?></span>
                            </div>
                                <div class="col-md-4 d-flex justify-content-between">
                            <div>
                                Booking Reference:<br>
                                <span class="fw-bold"><?php echo $bookingDetails['reference']; ?></span>
                            </div>
                            <div class="qr code me-5">
                                <i class="bi bi-upc-scan fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card booking-card">
                    <div class="section-header">Flight Details</div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-4">Flight No./ Airline</div>
                            <div class="col-4">Departure Location</div>
                            <div class="col-4">Arrival Location</div>
                        </div>
                        <?php foreach ($flights as $index => $flight): ?>
                        <div class="flight-row">
                            <div class="row">
                                <div class="col-4">
                                    <span class="airline-icon">
                                    <i class="bi bi-airplane-fill"></i>
                                    </span>
                                    <span class="fw-bold"><?php echo $flight['flightNo']; ?></span><br>
                                    <b><?php echo $flight['airline']; ?></b>
                                    </div>
                                    <div class="col-4">
                                    <strong><?php echo $flight['departure']['location']; ?></strong><br>
                                    <small><?php echo $flight['departure']['airport']; ?></small>
                                    <?php if (isset($flight['departure']['terminal'])): ?>
                                    <br><small><?php echo $flight['departure']['terminal']; ?></small>
                                    <?php endif; ?>
                                    <br><small><?php echo $flight['departure']['datetime']; ?></small>
                                </div>
                                <div class="col-4 d-flex">
                                    <div class="arrow me-2">▶</div>
                                    <div>
                                        <strong><?php echo $flight['arrival']['location']; ?></strong><br>
                                        <small><?php echo $flight['arrival']['airport']; ?></small>
                                        <?php if (isset($flight['arrival']['terminal'])): ?>
                                        <br><small><?php echo $flight['arrival']['terminal']; ?></small>
                                        <?php endif; ?>
                                        <br><small><?php echo $flight['arrival']['datetime']; ?></small>
                                    </div>
                                    </div>
                                    </div>
                                    </div>

                                    <?php if ($index < count($flights) - 1): ?>
                        <hr class="dotted">
                        <?php endif; ?>

                        <?php endforeach; ?> 
                    </div>
                </div>

                <!-- !-- Reminders -->
                <div class="card booking-card">
                    <div class="section-header">Reminders</div>
                    <div class="card-body">
                        <p><?php echo $reminders; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
            </body>
</html>