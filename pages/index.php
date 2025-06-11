<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7b/KYB_Corporation_company_logo.svg/135px-KYB_Corporation_company_logo.svg.png">
  <title>
    Dashboard Keselamatan Karyawan
  </title>
  <!-- Fonts dan ikon -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.0.3" rel="stylesheet" />
  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

  <style>
    .map-container {
      position: relative;
      width: 100%;
      max-width: 700px;
      margin: auto;
    }

    .map-container img {
      width: 100%;
      height: auto;
      display: block;
    }

    .dot {
      position: absolute;
      width: 14px;
      height: 14px;
      background-color: red;
      border: 2px solid white;
      border-radius: 50%;
      transform: translate(-50%, -50%);
      cursor: pointer;
      z-index: 2;
    }

    .dot:hover {
      background-color: yellow;
    }

    .dot:hover::after {
      content: attr(title);
      position: absolute;
      top: -30px;
      left: 50%;
      transform: translateX(-50%);
      background-color: rgba(0, 0, 0, 0.75);
      color: white;
      padding: 4px 8px;
      border-radius: 4px;
      font-size: 12px;
      white-space: nowrap;
      z-index: 3;
    }

    .marker-wrapper {
      position: absolute;
      transform: translate(-50%, -50%);
    }

    .marker-dot {
      width: 12px;
      height: 12px;
      border-radius: 50%;
      background-color: red;
      border: 2px solid white;
    }

    .marker-card {
      position: absolute;
      top: -80px;
      left: 50%;
      transform: translateX(-50%);
      display: none;
      width: max-content;
      min-width: 120px;
      background-color: white;
      z-index: 10;
    }

    .marker-wrapper:hover .marker-card {
      display: block;
    }

    /* Memperbaiki masalah sidebar yang mempersempit konten */
    .main-content {
      margin-left: 250px; /* Sesuaikan dengan lebar sidebar */
      padding: 20px;
      transition: margin-left 0.3s ease;
    }

    @media (max-width: 991px) {
      .main-content {
        margin-left: 0; /* Hapus margin saat sidebar disembunyikan */
      }
      .sidenav {
        transform: translateX(-100%); /* Sembunyikan sidebar di luar layar */
      }
      .sidenav.toggled {
        transform: translateX(0); /* Tampilkan sidebar saat di-toggle */
      }
    }
  </style>
</head>

<body class="g-sidenav-show bg-gray-100">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3" id="sidenav-main">
    <?php include 'sidebar.php'; ?>
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
    <!-- Navbar -->
    <?php include 'components/navbar.php'; ?>
    <!-- Akhir Navbar -->
    <div class="container-fluid py-4">
      <div class="row mb-4">
        <div class="col-md-4">
          <div class="form-group">
            <label for="departmentSelect" class="form-label text-sm font-weight-bold">Pilih Lokasi</label>
            <select class="form-select" id="departmentSelect" aria-label="Pilih Lokasi">
              <option selected disabled value="">-- Pilih Lokasi --</option>
              <option value="lantai-1">Lantai 1</option>
              <option value="lantai-2">Lantai 2</option>
              <option value="plant">Plant</option>
            </select>
          </div>
        </div>
        <div class="col-md-8">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="readerId1" class="form-label text-sm font-weight-bold">Reader ID 1</label>
                <input type="number" class="form-control" id="readerId1" placeholder="Masukkan Reader ID 1" min="1">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="readerId2" class="form-label text-sm font-weight-bold">Reader ID 2</label>
                <input type="number" class="form-control" id="readerId2" placeholder="Masukkan Reader ID 2" min="1">
              </div>
            </div>
            <div class="col-md-4 d-flex align-items-end">
              <button class="btn btn-primary" onclick="checkLocation()">Cek Lokasi</button>
            </div>
          </div>
        </div>
      </div>
      <div class="d-flex justify-content-center mb-4">
        <div class="map-container">
          <img src="" id="floorPlan" class="img-fluid">
          <div id="pointContainer" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card shadow-sm rounded px-5">
            <div class="card-header py-3 bg-danger border-bottom">
              <div class="d-flex flex-column align-items-start">
                <div class="d-flex align-items-center">
                  <h5 class="mb-0 fw-bold text-white">Data Pembaca RFID</h5>
                </div>
              </div>
            </div>
            <div class="card-body p-5">
              <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle" id="dataTable">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nama Ruangan</th>
                      <th>Tanggal Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    include '../config.php';

                    try {
                        $stmt = $pdo_els->query('SELECT id, room_name, act_dt FROM readers');
                        $readers = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if ($readers) {
                            foreach ($readers as $reader) {
                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($reader['id']) . '</td>';
                                echo '<td>' . htmlspecialchars($reader['room_name']) . '</td>';
                                echo '<td>' . htmlspecialchars($reader['act_dt']) . '</td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="3">Tidak ada data tersedia</td></tr>';
                        }
                    } catch (PDOException $e) {
                        echo '<tr><td colspan="3">Kesalahan database: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal untuk hasil lokasi -->
      <div class="modal fade" id="locationModal" tabindex="-1" aria-labelledby="locationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="locationModalLabel">Hasil Lokasi</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="locationResult">
              <!-- Informasi lokasi akan ditampilkan di sini -->
            </div>
            <div class="modal-footer" id="locationModalFooter">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal untuk input data lokasi baru -->
      <div class="modal fade" id="inputDataModal" tabindex="-1" aria-labelledby="inputDataModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="inputDataModalLabel">Input Data Lokasi Baru</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form id="inputDataForm">
                <div class="mb-3">
                  <label for="inputReaderId1" class="form-label">Reader ID 1</label>
                  <input type="number" class="form-control" id="inputReaderId1" min="1" required>
                </div>
                <div class="mb-3">
                  <label for="inputReaderId2" class="form-label">Reader ID 2</label>
                  <input type="number" class="form-control" id="inputReaderId2" min="1" required>
                </div>
                <div class="mb-3">
                  <label for="inputNamaArea" class="form-label">Nama Area</label>
                  <input type="text" class="form-control" id="inputNamaArea" placeholder="Masukkan nama area" required>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="button" class="btn btn-primary" onclick="submitNewLocation()">Kirim</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <!-- Core JS Files -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <!-- jQuery (diperlukan untuk DataTables) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable({
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],
        language: {
          search: "Cari:",
          lengthMenu: "Tampilkan _MENU_ baris per halaman",
          zeroRecords: "Data tidak ditemukan",
          info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
          infoEmpty: "Tidak ada data tersedia",
          infoFiltered: "(disaring dari _MAX_ total data)",
          paginate: {
            previous: "<<",
            next: ">>"
          }
        }
      });
    });

    // Perbarui tanggal dan waktu
    function updateDateTime() {
      const now = new Date();
      const options = {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        hour12: false,
        timeZone: 'Asia/Jakarta'
      };
      const dateTimeString = now.toLocaleString('en-GB', options).replace(',', '');
      document.getElementById('datetime').innerText = dateTimeString;
    }
    updateDateTime();
    setInterval(updateDateTime, 1000);

    // Tangani pembaruan gambar dan titik berdasarkan dropdown
    document.getElementById('departmentSelect').addEventListener('change', function () {
      const selectedLocation = this.value;
      const floorPlan = document.getElementById('floorPlan');
      const pointContainer = document.getElementById('pointContainer');

      // Perbarui gambar berdasarkan pilihan
      const imageMap = {
        'lantai-1': '../assets/img/lantai-bawah.png',
        'lantai-2': '../assets/img/lantai-atas1.png',
        'plant': '../assets/img/evacuation1.png'
      };

      if (imageMap[selectedLocation]) {
        floorPlan.src = imageMap[selectedLocation];
        floorPlan.alt = `Peta ${selectedLocation.replace('-', ' ')}`;
      } else {
        floorPlan.src = '../assets/img/lantai-atas1.png';
        floorPlan.alt = 'Peta Lantai Atas';
      }

      // Ambil dan perbarui titik
      fetch(`get_locations.php?location=${selectedLocation}`)
        .then(response => response.json())
        .then(data => {
          pointContainer.innerHTML = ''; // Bersihkan titik yang ada
          if (data.success) {
            data.points.forEach(point => {
              const pointDiv = document.createElement('div');
              pointDiv.className = 'marker-wrapper';
              pointDiv.style.top = `${point.top}%`;
              pointDiv.style.left = `${point.left}%`;
              pointDiv.innerHTML = `
                <div class='marker-dot bg-danger border border-light'></div>
                <div class='card marker-card shadow-sm'>
                  <div class='card-body p-2'>
                    <h6 class='card-title mb-1'>ID: ${point.id}</h6>
                    <p class='card-text small mb-0'>${point.room_name}</p>
                  </div>
                </div>
              `;
              pointContainer.appendChild(pointDiv);
            });
          }
        })
        .catch(error => {
          console.error('Kesalahan saat mengambil titik:', error);
          pointContainer.innerHTML = '';
        });
    });

    // Fungsi untuk memeriksa lokasi berdasarkan ID pembaca
    function checkLocation() {
      const readerId1 = document.getElementById('readerId1').value;
      const readerId2 = document.getElementById('readerId2').value;
      const locationResult = document.getElementById('locationResult');
      const locationModalFooter = document.getElementById('locationModalFooter');
      const modal = new bootstrap.Modal(document.getElementById('locationModal'));

      if (!readerId1 || !readerId2) {
        locationResult.innerHTML = '<p class="text-danger">Harap masukkan Reader ID 1 dan Reader ID 2.</p>';
        locationModalFooter.innerHTML = `
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        `;
        modal.show();
        return;
      }

      // Ambil data lokasi dari backend
      fetch(`get_area_data.php?reader_id_1=${readerId1}&reader_id_2=${readerId2}`)
        .then(response => response.json())
        .then(data => {
          if (data.success && data.location) {
            locationResult.innerHTML = `
              <p><strong>Lokasi:</strong> ${data.location.nama_area}</p>
              <p><strong>Tipe Area:</strong> ${data.location.tipe_area}</p>
              <p><strong>Koordinat:</strong> (${data.location.pos_x}, ${data.location.pos_y})</p>
            `;
            locationModalFooter.innerHTML = `
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            `;
          } else {
            locationResult.innerHTML = '<p class="text-danger">Tidak ditemukan lokasi untuk ID pembaca yang diberikan.</p>';
            locationModalFooter.innerHTML = `
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#inputDataModal" onclick="prefillForm(${readerId1}, ${readerId2})">Input Data</button>
            `;
          }
          modal.show();
        })
        .catch(error => {
          console.error('Kesalahan saat mengambil lokasi:', error);
          locationResult.innerHTML = '<p class="text-danger">Kesalahan saat mengambil data lokasi. Silakan coba lagi.</p>';
          locationModalFooter.innerHTML = `
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          `;
          modal.show();
        });
    }

    // Fungsi untuk mengisi formulir input data
    function prefillForm(readerId1, readerId2) {
      document.getElementById('inputReaderId1').value = readerId1;
      document.getElementById('inputReaderId2').value = readerId2;
      document.getElementById('inputNamaArea').value = '';
    }

    // Fungsi untuk mengirim data lokasi baru
    function submitNewLocation() {
      const readerId1 = document.getElementById('inputReaderId1').value;
      const readerId2 = document.getElementById('inputReaderId2').value;
      const namaArea = document.getElementById('inputNamaArea').value;
      const inputDataModal = bootstrap.Modal.getInstance(document.getElementById('inputDataModal'));
      const locationModal = new bootstrap.Modal(document.getElementById('locationModal'));
      const locationResult = document.getElementById('locationResult');
      const locationModalFooter = document.getElementById('locationModalFooter');

      if (!readerId1 || !readerId2 || !namaArea) {
        alert('Harap isi semua kolom.');
        return;
      }

      // Kirim data ke backend
      fetch('add_area_data.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          reader_id_1: readerId1,
          reader_id_2: readerId2,
          nama_area: namaArea
        })
      })
        .then(response => response.json())
        .then(data => {
          inputDataModal.hide();
          if (data.success) {
            locationResult.innerHTML = `<p class="text-success">Lokasi baru '${namaArea}' berhasil ditambahkan! Halaman akan diperbarui dalam 2 detik.</p>`;
            locationModalFooter.innerHTML = `
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            `;
            locationModal.show();
            setTimeout(() => {
              window.location.reload();
            }, 2000);
          } else {
            locationResult.innerHTML = `<p class="text-danger">Kesalahan saat menambahkan lokasi: ${data.message}</p>`;
            locationModalFooter.innerHTML = `
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            `;
            locationModal.show();
          }
        })
        .catch(error => {
          console.error('Kesalahan saat menambahkan lokasi:', error);
          inputDataModal.hide();
          locationResult.innerHTML = '<p class="text-danger">Kesalahan saat menambahkan data lokasi. Silakan coba lagi.</p>';
          locationModalFooter.innerHTML = `
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          `;
          locationModal.show();
        });
    }
  </script>
  <script src="../assets/js/soft-ui-dashboard.min.js?v=1.0.3"></script>
</body>

</html>