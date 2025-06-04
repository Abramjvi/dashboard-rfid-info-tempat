<?php
session_start();

// Set header cache-control untuk mencegah caching
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
header('Expires: Thu, 01 Jan 1970 00:00:00 GMT'); // Pastikan cache kadaluarsa

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: /dashboard-rfid-employee/pages/index.php?alert=' . urlencode('Anda harus login terlebih dahulu!'));
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7b/KYB_Corporation_company_logo.svg/135px-KYB_Corporation_company_logo.svg.png">
  <title>
    Dashboard Safety Employee 
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.0.3" rel="stylesheet" />
  <style>
    #occupancyChart {
      max-height: 300px; /* Batasi tinggi maksimum chart */
      max-width: 100%; /* Pastikan chart tidak melar melebihi container */
    }
    .card-body {
      overflow: auto; /* Jika konten melebihi, tambahkan scrollbar lokal */
    }
  </style>
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="g-sidenav-show  bg-gray-100">
  <?php include 'components/sidebar.php'; ?>
  <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
    <!-- Navbar -->
      <?php include 'components/navbar.php'; ?>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <!-- KPI Section -->
      <div class="row mb-4">
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Orang</p>
                    <h5 class="font-weight-bolder mb-0">
                      5
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Orang di Dalam</p>
                    <h5 class="font-weight-bolder mb-0">
                      5
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Orang di luar</p>
                    <h5 class="font-weight-bolder mb-0">
                      0
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Chart Section -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Distribusi Orang per Area</h5>
              <div style="position: relative; height: 300px; width: 100%;">
                <canvas id="occupancyChart"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Existing Cards -->
      <div class="row">
        <div class="col-xl-4 col-sm-6 mb-4">     
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-sm-6 mb-4">
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-sm-6 mb-4">
           </div>
        </div>
        <div class="row mt-4">
          <div class="col-xl-4 col-sm-6 mb-4">
             </div>
            </div>
          </div>
          <div class="col-xl-4 col-sm-6 mb-4">
            </div>
          </div>
          <div class="col-xl-4 col-sm-6 mb-4">
            </div>
          </div>
        </div>
      </div>
    </div>
    <footer class="footer pt-3">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12 text-center">
            <div class="copyright text-sm text-muted">
              © <script>
                document.write(new Date().getFullYear())
              </script>,
              PT KAYABA INDONESIA
            </div>
          </div>
        </div>
      </div>
    </footer>
  </main>
  <!-- Core JS Files -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
    
    function updateDateTime() {
      const now = new Date();
      const options = {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        hour12: false,
        timeZone: 'Asia/Jakarta' // Mengatur zona waktu ke WIB
      };
      const dateTimeString = now.toLocaleString('en-GB', options).replace(',', '');
      document.getElementById('datetime').innerText = dateTimeString;
    }
    updateDateTime();
    setInterval(updateDateTime, 1000);

    // Chart Configuration
    var ctx = document.getElementById('occupancyChart').getContext('2d');
    var occupancyChart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: ['Office Atas', 'Plant', 'Koridor Kantin', 'Lobby Baru'],
        datasets: [{
          data: [1, 1, 2, 1],
          backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0']
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: true, // Pastikan rasio tetap dipertahankan
        aspectRatio: 1.5, // Atur rasio lebar terhadap tinggi (misalnya 1.5:1)
        plugins: {
          legend: {
            position: 'top'
          },
          title: {
            display: true,
            text: 'Distribusi Orang per Area'
          }
        }
      }
    });
  </script>

  <script>
  // ... (existing code: updateDateTime, Chart.js, etc.) ...

  // Handle logout
  document.querySelector('a[href="../logout.php"]').addEventListener('click', function (event) {
    event.preventDefault(); // Prevent default link behavior
    if (confirm('Are you sure you want to log out?')) {
      fetch('logout.php', {
        method: 'GET'
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            window.location.href = data.redirect || 'index.html';
          } else {
            alert(data.message || 'Logout failed. Please try again.');
          }
        })
        .catch(error => {
          alert('An error occurred during logout. Please try again.');
          console.error('Error:', error);
        });
    }
  });
</script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard -->
  <script src="../assets/js/soft-ui-dashboard.min.js?v=1.0.3"></script>
</body>

</html>