<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Bootstap S icons CDN-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <title>JetSetGo</title>

    <link rel="stylesheet" href="admin-style.css">

  </head>
  <body>

    <body style="margin: 0;">
        <!-- Sidebar -->
        <div id="sidebar-container">
            <script>
                fetch("sidebar.html")
                  .then(res => res.text())
                  .then(data => {
                    document.getElementById("sidebar-container").innerHTML = data;
                  });
              </script>
        </div>


        <!-- Main Content -->
        <div style="margin-left: 225px; padding: 20px;">
            <h1>JeSetGo</h1>
                <section class="p-3">
                    <div class="col-8">
                        <button class="btn btn-prim"><i class="bi bi-people"></i>+ New Flights </button>
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
                              <th>STATUS
                              <th>ACTION</th>
                            </tr>

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
                                  <button class="btn btn-success"><i class="bi bi-eye"></i></button>
                                  <button class="btn btn-primary"><i class="bi bi-pencil-square"></i></button>
                                  <button class="btn btn-danger"><i class="bi bi-trash"></i></button>
                                </td>
                              </tr>
                            </tbody>
                          </thead>
                        </table>
                      </div>
                    </div>
                </section>


        </div>



    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="app.js"></script>

  </body>
</html>
goooo