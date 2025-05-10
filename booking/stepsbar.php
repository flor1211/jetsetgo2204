<?php
    $current = $_GET['page'] ?? '';
?>


<div style="
        background-color:rgb(39, 63, 122);
        padding: 0 10px;
        width: 100%;
        height: 80px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    ">

        <div class="progress-line"></div>

        <div class="steps"
            style="
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 60px;
                width: 100%;

            ">

            <div class="step <?= $current === 'selectflights.php' ? 'active' : '' ?>">
                <a href="selectflights.php">
                    <div class="icon"><i class="bi bi-airplane"></i></div>
                    <span>Select Flight</span>

                </a>
            </div>

            <div class="step <?= $current === 'guestdetails.php' ? 'active' : '' ?>">
                <a href="guestdetails.php">
                        <div class="icon"><i class="bi bi-person-square"></i></div>
                        <span>Guest Details</span>
                </a>
            </div>


            <div class="step <?= $current === 'payments.php' ? 'active' : '' ?>">
                <a href="payments.php">
                    <div class="icon"><i class="bi bi-credit-card"></i></div>
                    <span>Payment</span>
                </a>
            </div>

            <div class="step <?= $current === 'confirmation.php' ? 'active' : '' ?>">
                <a href="confirmation.php">
                    <div class="icon"><i class="bi bi-check-circle"></i></div>
                    <span>Confirmation</span>
                </a>
            </div>

        </div>
    </div>



    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="booking.js"></script>

<style>

style{
    flex: none;
}

                
.step a {
    text-decoration: none;
    color:rgb(255, 255, 255);
    display: flex;
    flex-direction: column; 
    align-items: center;
    text-decoration: none;
}

.step.active .icon {
  background:rgb(7, 36, 68);
  color: white;
}

.step.active span {
    color: #ffc107; /* or any highlight color */
}

.icon {
    width: 40px;
    height: 40px;
    border-radius: 25px;
    display: flex;
    align-items: center;  
    justify-content: center; 
    background: white;
    border: 2px solid black;
    color: #162447;
    font-size: 18px;
    z-index: 1;
}

.step span{
    display: block;
    font-weight: 600;
    font-size: 15px;
    padding: 0px 10px;
}


@media (max-width: 650px) {
  .step span {
    display: none;
  }

}

</style>