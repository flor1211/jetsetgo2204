<?php

session_start();

require_once 'database/booking-crud.php';

$user = new BookingCrud();

$bookingDetails = [
    'status' => 'CONFIRMED',
    'bookingDate' => 'Sun, 11 May, 2025',
    'reference' => 'JSG0001'
];


$flightType = $_SESSION['trip_type'];

if ($flightType == 'onewaytrip'){
    $_SESSION['selected_depflight'] ?? null;
    
$_SESSION['depfligtInfo'] ?? null;

$_SESSION['depFlightInfo'] = $user->getSelectedFlight($_SESSION['selected_depflight']) ?? null;


$depFlight = $_SESSION['depFlightInfo'] ?? null;
$retFlight = $_SESSION['retFlightInfo'] ?? null;


} elseif ($flightType == 'roundtrip') {
    $_SESSION['selected_depflight'] ?? null;
    $_SESSION['selected_retflight'] ?? null;

    $_SESSION['depfligtInfo'] ?? null;
    $_SESSION['retfligtInfo'] ?? null;

    $_SESSION['depFlightInfo'] = $user->getSelectedFlight($_SESSION['selected_depflight']) ?? null;
$_SESSION['retFlightInfo'] = $user->getSelectedFlight($_SESSION['selected_retflight']) ?? null;

$depFlight = $_SESSION['depFlightInfo'] ?? null;
$retFlight = $_SESSION['retFlightInfo'] ?? null;
}





$_SESSION['guest_details'] ?? null;

$_SESSION['numberofpassenger'] ?? null;
$_SESSION['departing_price'] ?? null;
$_SESSION['returning_price'] ?? null;
$_SESSION['total_price'] ?? null;
$_SESSION['payment'] ?? null;
$_SESSION['onsite_name'] ?? null;
$_SESSION['onsite_idnum'] ?? null;
$_SESSION['card_holder'] ?? null;
$_SESSION['card_number'] ?? null;
$_SESSION['card_expiry'] ?? null;
$_SESSION['card_cvv'] ?? null;



    // echo "<pre>";

    // print_r ($_SESSION['trip_type']);

    // echo "</pre>";
    // print_r($depFlight);
    // print_r($flightType);
    // print_r($_SESSION['selected_depflight']);
    // print_r($_SESSION['selected_retflight']);
    // print_r($_SESSION['numberofpassenger']);
    // print_r($_SESSION['depfligtInfo']);
    // print_r($_SESSION['retfligtInfo']);
    // print_r($_SESSION['guest_details']);
    // print_r($_SESSION['total_price']);
    // print_r($_SESSION['payment']);
    // print_r($_SESSION['onsite_name']);
    // print_r($_SESSION['onsite_idnum']);
    // print_r($_SESSION['card_holder']);
    // print_r($_SESSION['card_number']);
    // print_r($_SESSION['card_expiry']);
    // print_r($_SESSION['card_cvv']);

    // echo "</pre>";


$flights = [
    [
        'flightNo' => 'JSG' . $depFlight[0]['flight_id'],
        'airline' => 'JetSetGo Air',
        'departure' => [
            'location' => $depFlight[0]['departure_code'],
            'airport' => $depFlight[0]['departure_location'],
            'datetime' => $depFlight[0]['date'] . " - " . $depFlight[0]['departure_time'],
        ],
        'arrival' => [
            'location' => $depFlight[0]['arrival_code'],
            'airport' => $depFlight[0]['arrival_location'],
            'datetime' => $depFlight[0]['date'] . " - " . $depFlight[0]['arrival_time'],
        ]
    ],
    [
        'flightNo' => "JSG" .  @$retFlight[0]['flight_id'] ?? null,
        'airline' => 'JetSetGo Air',
        'departure' => [
            'location' =>  @$retFlight[0]['departure_code']  ?? null,
            'airport' =>  @$retFlight[0]['departure_location']  ?? null,
            'datetime' =>  @$retFlight[0]['date'] ?? null . " - " .  @$retFlight[0]['departure_time']  ?? null,
        ],
        'arrival' => [
            'location' =>  @$retFlight[0]['arrival_code'] ?? null,
            'airport' =>  @$retFlight[0]['arrival_location'] ?? null,
            'datetime' =>  @$retFlight[0]['date'] ?? null . " - " .  @$retFlight[0]['arrival_time'] ?? null,
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


        <div class="container" style="margin-left: 180px">
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

                        <?php if ($flightType === 'onewaytrip'): ?>
                            <?php $flight = $flights[0]; ?>
                            <div class="flight-row">
                                <div class="row">
                                    <div class="col-4">
                                        <span class="airline-icon"><i class="bi bi-airplane-fill"></i></span>
                                        <span class="fw-bold"><?php echo $flight['flightNo']; ?></span><br>
                                        <b><?php echo $flight['airline']; ?></b>
                                    </div>
                                    <div class="col-4">
                                        <strong><?php echo $flight['departure']['location']; ?></strong><br>
                                        <small><?php echo $flight['departure']['airport']; ?></small><br>
                                        <small><?php echo $flight['departure']['datetime']; ?></small>
                                    </div>
                                    <div class="col-4 d-flex">
                                        <div class="arrow me-2">▶</div>
                                        <div>
                                            <strong><?php echo $flight['arrival']['location']; ?></strong><br>
                                            <small><?php echo $flight['arrival']['airport']; ?></small><br>
                                            <small><?php echo $flight['arrival']['datetime']; ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php elseif ($flightType === 'roundtrip'): ?>
                            <?php foreach ($flights as $index => $flight): ?>
                                <div class="flight-row">
                                    <div class="row">
                                        <div class="col-4">
                                            <span class="airline-icon"><i class="bi bi-airplane-fill"></i></span>
                                            <span class="fw-bold"><?php echo $flight['flightNo']; ?></span><br>
                                            <b><?php echo $flight['airline']; ?></b>
                                        </div>
                                        <div class="col-4">
                                            <strong><?php echo $flight['departure']['location']; ?></strong><br>
                                            <small><?php echo $flight['departure']['airport']; ?></small><br>
                                            <small><?php echo $flight['departure']['datetime']; ?></small>
                                        </div>
                                        <div class="col-4 d-flex">
                                            <div class="arrow me-2">▶</div>
                                            <div>
                                                <strong><?php echo $flight['arrival']['location']; ?></strong><br>
                                                <small><?php echo $flight['arrival']['airport']; ?></small><br>
                                                <small><?php echo $flight['arrival']['datetime']; ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($index < count($flights) - 1): ?>
                                    <hr class="dotted">
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <div class="d-flex justify-content-between fw-bold px-4 py-2" style="background-color:rgb(154, 167, 231); color: #000;">
                            <span class="ms-5">Total</span>
                            <span class="me-5">PHP <?php echo $_SESSION['total_price']+($_SESSION['total_price']*0.10)?> </span>
                        </div>
                       
                    </div>
                </div>

                <!-- Guest Details -->
                <div class="card booking-card">
                    <div class="section-header">Guest Details</div>
                    <div class="card-body" style="font-size: 15px;">
                        <?php foreach ($_SESSION['guest_details'] as $index => $guest): ?>
                            <div class="mb-4">
                                <h5 class="fw-bold">Passenger <?php echo $index; ?></h5>
                                <div class="row align-items-start">
                                    <div class="col-md-3 mb-2">
                                        <strong>Name:</strong><br>
                                        <?php echo $guest['title'] . ' ' . $guest['first_name'] . ' ' . $guest['last_name']; ?>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <strong>Birth Date:</strong><br>
                                        <?php echo $guest['year'] . '-' . str_pad($guest['month'], 2, '0', STR_PAD_LEFT) . '-' . str_pad($guest['day'], 2, '0', STR_PAD_LEFT); ?>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <strong>Contact:</strong><br>
                                        <?php echo $guest['contact']; ?>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <strong>Email:</strong><br>
                                        <?php echo $guest['email']; ?>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <strong>Nationality:</strong><br>
                                        <?php echo $guest['nationality']; ?>
                                    </div>
                                </div>

                            </div>
                            

                            <?php if ($index < count($_SESSION['guest_details']) - 1): ?>
                                <hr class="dotted">
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>


                <!-- Reminders -->
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
