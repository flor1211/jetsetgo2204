<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <title>JetSetGo</title>
    <link rel="stylesheet" href="admin-style.css">
  </head>

  <body style="margin: 0;">
    <div id="sidebar-container">
      <script>
        fetch("sidebar.php")
          .then(res => res.text())
          .then(data => {
            document.getElementById("sidebar-container").innerHTML = data;
          });
      </script>
    </div>

    <div style="margin-left: 225px; padding: 20px;">
      <h1>JetSetGo</h1>
      <section class="p-3">
        <div class="col-8">
          
          <button class="btn btn-prim" data-bs-toggle="modal" data-bs-target="#addNewFlight">
            <i class="bi bi-plus-circle-dotted"></i> New Flights
          </button>
        </div>

        <div class="row">
          <div class="col-12">
            <table class="table table-striped table-hover mt-3 text-center table-bordered">
              <thead>
                <tr>
                  <th>DATE</th>
                  <th>LOCATION</th>
                  <th>PLANE ID</th>
                  <th>SEATS</th>
                  <th>AVAILABLE</th>
                  <th>BOOKED</th>
                  <th>STATUS</th>
                  <th>ACTION</th>
                </tr>
              </thead>
              <tbody id="data">
                <tr>
                  <td>16/07/2025</td>
                  <td>Bukidnon</td>
                  <td>JSG016</td>
                  <td>150</td>
                  <td>120</td>
                  <td>30</td>
                  <td>Pending</td>
                  <td>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#viewFlight"><i class="bi bi-eye"> VIEW </i></button>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editFlight"><i class="bi bi-pencil-square"> EDIT </i></button>
                    <button class="btn btn-danger"><i class="bi bi-trash"> DELETE </i></button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </section>


  <div class="modal fade" id="addNewFlight" tabindex="-1" aria-labelledby="addNewFlight" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="addNewFlight">Adding New Flight</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              <form action="#" id="myForm">
              <h4 class="modal-title">Flight Details</h4>
              <hr>
                <div class="container">
                  <div class="row mb-3">
                    <div class="col-md-6">

                      <label for="departureLocation">DEPARTURE LOCATION</label>
                      <input type="text" class="form-control" id="text">
                    </div>
                    <div class="col-md-6">
                      <label for="arrivalLocation">ARRIVAL LOCATION</label>
                      <input type="text" class="form-control" id="text">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-6">
                      <label for="departureTime">DEPARTURE TIME</label>
                      <input type="time" class="form-control" id="time">
                    </div>
                    <div class="col-md-6">
                      <label for="arrivalTime">ARRIVAL TIME</label>
                      <input type="time" class="form-control" id="time">
                    </div>
                  </div>
               
                  <div class="row mb-3">
                    <div class="col-md-6">
                      <label for="date">DATE</label>
                      <input type="date" class="form-control" id="date">
                    </div>
                    <!-- <div class="col-md-6">
                      <label for="seats">SEATS</label>
                      <input type="text" class="form-control" id="text">
                    </div> -->
                  </div>
                  
                  <h4 class="modal-title">Plane Details</h4>
                <hr>

                <div class="d-flex gap-4">
                <div class="w-100">
                    <div class="mb-3">
                    <label for="planeNumber">PLANE #</label>
                    <select class="form-control" id="planeNumber">
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select>
                    </div>

                    <div class="mb-3">
                    <label for="seatsAvailable">SEATS AVAILABLE</label>
                    <input type="text" class="form-control" id="seatsAvailable">
                    </div>

                    <div class="mb-3">
                    <label for="price">PRICE</label>
                    <input type="text" class="form-control" id="price" placeholder="₱ 0.00">
                    </div>
                </div>

                <div class="flex-shrink-0">
                    <img 
                    src="https://images6.alphacoders.com/408/408258.jpg" 
                    alt="Plane Image" 
                    class="img-fluid rounded shadow" 
                    style="width: 250px; height: 170px; margin-top: 50px;">
                </div>
                </div>

                </div>
            </div>

                  

                  <form action="#" id="myForm"></form>

                  
                <div class="modal-footer">
                <button type="submit" class="btn btn-primary">ADD</button>
                <button type="cancel" class="btn btn-danger">CANCEL</button>


                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- MODAL FOR VIEWING -->
    <div class="modal fade" id="viewFlight" tabindex="-1" aria-labelledby="viewFlight" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="viewFlight">View Flight</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              <form action="#" id="myForm">
              <h4 class="modal-title">Flight Details</h4>
              <hr>
                <div class="container">
                  <div class="row mb-3">
                    <div class="col-md-6">

                      <label for="departureLocation">DEPARTURE LOCATION</label>
                      <input type="text" class="form-control" id="text" disabled>
                    </div>
                    <div class="col-md-6">
                      <label for="arrivalLocation">ARRIVAL LOCATION</label >
                      <input type="text" class="form-control" id="text" disabled>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-6">
                      <label for="departureTime">DEPARTURE TIME</label>
                      <input type="time" class="form-control" id="time" disabled>
                    </div>
                    <div class="col-md-6">
                      <label for="arrivalTime">ARRIVAL TIME</label>
                      <input type="time" class="form-control" id="time" disabled>
                    </div>
                  </div>
               
                  <div class="row mb-3">
                    <div class="col-md-6">
                      <label for="date">DATE</label>
                      <input type="date" class="form-control" id="date" disabled>
                    </div>
                    <!-- <div class="col-md-6">
                      <label for="seats">SEATS</label>
                      <input type="text" class="form-control" id="text">
                    </div> -->
                  </div>
                  
                  <h4 class="modal-title">Plane Details</h4>
                <hr>

                <div class="d-flex gap-4">
                <div class="w-100">
                    <div class="mb-3">
                    <label for="planeNumber">PLANE #</label>
                    <select class="form-control" id="planeNumber" disabled>
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select>
                    </div>

                    <div class="mb-3">
                    <label for="seatsAvailable">SEATS AVAILABLE</label>
                    <input type="text" class="form-control" id="seatsAvailable" disabled>
                    </div>

                    <div class="mb-3">
                    <label for="price">PRICE</label>
                    <input type="text" class="form-control" id="price" placeholder="₱ 0.00" disabled>
                    </div>
                </div>

                <div class="flex-shrink-0">
                    <img 
                    src="https://images6.alphacoders.com/408/408258.jpg" 
                    alt="Plane Image" 
                    class="img-fluid rounded shadow" 
                    style="width: 250px; height: 170px; margin-top: 50px;">
                </div>
                </div>

                </div>
            </div>
                  <form action="#" id="myForm"></form>

                  
                <div class="modal-footer">
                <button type="submit" class="btn btn-primary">ADD</button>
                <button type="cancel" class="btn btn-danger">CANCEL</button>


                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

        <!-- MODAL FOR EDITING FLIGHT -->
    
    <div class="modal fade" id="editFlight" tabindex="-1" aria-labelledby="editFlight" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="editFlight">Edit Flight</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              <form action="#" id="myForm">
              <h4 class="modal-title">Flight Details</h4>
              <hr>
                <div class="container">
                  <div class="row mb-3">
                    <div class="col-md-6">

                      <label for="departureLocation">DEPARTURE LOCATION</label>
                      <input type="text" class="form-control" id="text">
                    </div>
                    <div class="col-md-6">
                      <label for="arrivalLocation">ARRIVAL LOCATION</label>
                      <input type="text" class="form-control" id="text">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-6">
                      <label for="departureTime">DEPARTURE TIME</label>
                      <input type="time" class="form-control" id="time">
                    </div>
                    <div class="col-md-6">
                      <label for="arrivalTime">ARRIVAL TIME</label>
                      <input type="time" class="form-control" id="time">
                    </div>
                  </div>
               
                  <div class="row mb-3">
                    <div class="col-md-6">
                      <label for="date">DATE</label>
                      <input type="date" class="form-control" id="date">
                    </div>
                    <!-- <div class="col-md-6">
                      <label for="seats">SEATS</label>
                      <input type="text" class="form-control" id="text">
                    </div> -->
                  </div>
                  
                  <h4 class="modal-title">Plane Details</h4>
                <hr>

                <div class="d-flex gap-4">
                <div class="w-100">
                    <div class="mb-3">
                    <label for="planeNumber">PLANE #</label>
                    <select class="form-control" id="planeNumber">
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select>
                    </div>

                    <div class="mb-3">
                    <label for="seatsAvailable">SEATS AVAILABLE</label>
                    <input type="text" class="form-control" id="seatsAvailable">
                    </div>

                    <div class="mb-3">
                    <label for="price">PRICE</label>
                    <input type="text" class="form-control" id="price" placeholder="₱ 0.00">
                    </div>
                </div>

                <div class="flex-shrink-0">
                    <img 
                    src="https://images6.alphacoders.com/408/408258.jpg" 
                    alt="Plane Image" 
                    class="img-fluid rounded shadow" 
                    style="width: 250px; height: 170px; margin-top: 50px;">
                </div>
                </div>

                </div>
            </div>

                  

                  <form action="#" id="myForm"></form>

                  
                <div class="modal-footer">
                <button type="submit" class="btn btn-primary">ADD</button>
                <button type="cancel" class="btn btn-danger">CANCEL</button>


                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>



  </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="app.js"></script>
  </body>
</html>