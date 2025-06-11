<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7b/KYB_Corporation_company_logo.svg/135px-KYB_Corporation_company_logo.svg.png">
  <title>
    Input Data Karyawan
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

  <style>
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
      <div class="row">
        <div class="col-12">
          <div class="card shadow-sm rounded">
            <div class="card-header py-3 bg-primary border-bottom">
              <h5 class="mb-0 fw-bold text-white">Input Data Karyawan</h5>
            </div>
            <div class="card-body p-5">
              <form id="inputEmployeeForm">
                <div class="mb-3">
                  <label for="inputEmployeeName" class="form-label">Nama</label>
                  <input type="text" class="form-control" id="inputEmployeeName" placeholder="Masukkan nama karyawan" required>
                </div>
                <div class="mb-3">
                  <label for="inputEmployeeNpk" class="form-label">NPK</label>
                  <input type="text" class="form-control" id="inputEmployeeNpk" placeholder="Masukkan NPK" required>
                </div>
                <div class="mb-3">
                  <label for="inputEmployeeDepartment" class="form-label">Departemen</label>
                  <select class="form-select" id="inputEmployeeDepartment" required>
                    <option selected disabled value="">-- Pilih Departemen --</option>
                    <!-- Opsi departemen akan diisi melalui AJAX -->
                  </select>
                </div>
                <div class="mb-3">
                  <label for="inputEmployeeRfid" class="form-label">RFID</label>
                  <select class="form-select" id="inputEmployeeRfid" required>
                    <option selected disabled value="">-- Pilih RFID --</option>
                    <!-- Opsi RFID akan diisi melalui AJAX -->
                  </select>
                </div>
                <div class="d-flex justify-content-end">
                  <button type="button" class="btn btn-primary" onclick="submitNewEmployee()">Kirim</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal untuk hasil -->
      <div class="modal fade" id="resultModal" tabindex="-1" aria-labelledby="resultModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="resultModalLabel">Hasil</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="resultMessage">
              <!-- Pesan hasil akan ditampilkan di sini -->
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
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

    // Ambil data departemen dari backend saat halaman dimuat
    $(document).ready(function () {
      // Fetch departemen
      fetch('get_departements.php')
        .then(response => {
          if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
          }
          return response.json();
        })
        .then(data => {
          console.log('Respons dari get_departements.php:', data);
          const departmentSelect = document.getElementById('inputEmployeeDepartment');
          if (data.success && data.departments.length > 0) {
            data.departments.forEach(dept => {
              const option = document.createElement('option');
              option.value = dept.id;
              option.text = dept.name;
              departmentSelect.appendChild(option);
            });
          } else {
            const option = document.createElement('option');
            option.value = '';
            option.text = 'Tidak ada departemen tersedia';
            departmentSelect.appendChild(option);
          }
        })
        .catch(error => {
          console.error('Kesalahan saat mengambil data departemen:', error);
          const departmentSelect = document.getElementById('inputEmployeeDepartment');
          const option = document.createElement('option');
          option.value = '';
          option.text = 'Kesalahan saat memuat departemen';
          departmentSelect.appendChild(option);
        });

      // Fetch RFID
      fetch('get_rfids.php')
        .then(response => {
          if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
          }
          return response.json();
        })
        .then(data => {
          console.log('Respons dari get_rfids.php:', data);
          const rfidSelect = document.getElementById('inputEmployeeRfid');
          if (data.success && data.rfids.length > 0) {
            data.rfids.forEach(item => {
              const option = document.createElement('option');
              option.value = item.rfid;
              option.text = item.rfid;
              rfidSelect.appendChild(option);
            });
          } else {
            const option = document.createElement('option');
            option.value = '';
            option.text = 'Tidak ada RFID tersedia';
            rfidSelect.appendChild(option);
          }
        })
        .catch(error => {
          console.error('Kesalahan saat mengambil data RFID:', error);
          const rfidSelect = document.getElementById('inputEmployeeRfid');
          const option = document.createElement('option');
          option.value = '';
          option.text = 'Kesalahan saat memuat RFID';
          rfidSelect.appendChild(option);
        });
    });

    // Fungsi untuk mengirim data karyawan baru dan update status RFID
    function submitNewEmployee() {
      const name = document.getElementById('inputEmployeeName').value;
      const npk = document.getElementById('inputEmployeeNpk').value;
      const department = document.getElementById('inputEmployeeDepartment').value;
      const rfid = document.getElementById('inputEmployeeRfid').value;
      const resultModal = new bootstrap.Modal(document.getElementById('resultModal'));
      const resultMessage = document.getElementById('resultMessage');

      if (!name || !npk || !department || !rfid) {
        alert('Harap isi semua kolom.');
        return;
      }

      // Kirim data karyawan ke backend
      fetch('add_employee_data.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          name: name,
          npk: npk,
          department: department,
          rfid: rfid
        })
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Jika penambahan karyawan berhasil, update status RFID
            return fetch('update_rfid_status.php', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json'
              },
              body: JSON.stringify({
                rfid: rfid
              })
            });
          } else {
            throw new Error(`Kesalahan saat menambahkan karyawan: ${data.message}`);
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            resultMessage.innerHTML = `<p class="text-success">Karyawan baru '${name}' berhasil ditambahkan dan status RFID diperbarui! Halaman akan diperbarui dalam 2 detik.</p>`;
            resultModal.show();
            setTimeout(() => {
              window.location.reload();
            }, 2000);
          } else {
            throw new Error(`Kesalahan saat memperbarui status RFID: ${data.message}`);
          }
        })
        .catch(error => {
          console.error('Kesalahan:', error);
          resultMessage.innerHTML = `<p class="text-danger">${error.message || 'Kesalahan saat menambahkan data karyawan atau memperbarui RFID. Silakan coba lagi.'}</p>`;
          resultModal.show();
        });
    }
  </script>
  <script src="../assets/js/soft-ui-dashboard.min.js?v=1.0.3"></script>
</body>

</html>