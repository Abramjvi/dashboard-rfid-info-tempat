<?php
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
header('Expires: Thu, 01 Jan 1970 00:00:00 GMT');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <link 
      rel="apple-touch-icon"
      sizes="76x76"
      href="../assets/img/apple-icon.png"
    />
    <link
      rel="icon"
      type="image/png"
      href="https://www.ifpusa.com/wp-content/uploads/2021/11/KYB%20DRUPAL%20LOGO.png"
    />
    <title>Kayaba Indonesia</title>
    <!-- Fonts and icons -->
    <link
      href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700"
      rel="stylesheet"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Host+Grotesk:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />
    <!-- Nucleo Icons -->
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <link href="../assets/css/login.css" rel="stylesheet" />
    <style>
      .otp-input {
        width: 40px;
        height: 50px;
        font-size: 24px;
        text-align: center;
        margin: 5px;
        border: 2px solid #ced4da;
        border-radius: 8px;
      }

      .otp-input:focus {
        border-color: #007bff;
        outline: none;
      }

      footer.footer {
        position: sticky;
        bottom: 0;
        background: white;
        z-index: 1000;
      }

      @media (max-height: 500px) {
        footer.footer {
          display: none;
        }
      }
    </style>
  </head>

  <body class="d-flex flex-column min-vh-100">
    <main class="d-flex flex-grow-1 align-items-center justify-content-center">
      <section class="flex-grow-1">
        <div class="page-header min-vh-75">
          <div class="wrapper">
            <div class="title text-center mb-4">
              <img
                src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7b/KYB_Corporation_company_logo.svg/2560px-KYB_Corporation_company_logo.svg.png"
                alt=""
              />
            </div>
            <div class="row no-gutters d-flex flex-column align-items-center">
              <div class="container-main shadow-lg">
                <div class="bottom w-100">
                  <header class="mb-4">SIGN IN</header>
                  <form id="loginForm" method="POST">
                    <div class="form-group mb-4">
                      <input
                        type="text"
                        class="form-control"
                        id="exampleInputUsername1"
                        placeholder=""
                        name="npk"
                      />
                      <label for="exampleInputUsername1" class="form-label"
                        >Username</label
                      >
                    </div>
                    <div class="form-group mb-4">
                      <input
                        type="password"
                        class="form-control"
                        id="exampleInputPassword1"
                        name="password"
                        placeholder=""
                      />
                      <label for="exampleInputPassword1" class="form-label"
                        >Password</label
                      >
                    </div>
                    <div class="form-group mb-4">
                      <div class="d-flex align-items-center">
                        <img
                          id="captcha-img"
                          src="../vendor/securimage-nextgen/securimage_show.php"
                          alt="CAPTCHA Image"
                          class="me-2"
                        />
                        <button
                          type="button"
                          id="refresh-captcha"
                          class="btn btn-outline-secondary btn-sm"
                        >
                          <i class="fas fa-sync-alt"></i>
                        </button>
                      </div>
                      <input
                        type="text"
                        class="form-control mt-2"
                        id="captcha_code"
                        name="captcha_code"
                        placeholder="Enter CAPTCHA"
                      />
                    </div>
                    <button type="submit" class="btn btn-login w-100 mt-3">
                      Submit
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>

    <footer class="footer text-center mt-auto py-3">
      <div class="container">
        <div class="row">
          <div class="col-12 mx-auto text-center">
            <p class="mb-0 text-secondary">
              Copyright ©
              <script>
                document.write(new Date().getFullYear());
              </script>
              PT Kayaba Indonesia
            </p>
          </div>
        </div>
      </div>
    </footer>

    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="assets/js/soft-ui-dashboard.min.js?v=1.0.3"></script>

    <script>
      document.addEventListener("DOMContentLoaded", function () {
        let captchaImg = document.getElementById("captcha-img");
        let refreshBtn = document.getElementById("refresh-captcha");

        if (captchaImg && refreshBtn) {
          refreshBtn.addEventListener("click", function () {
            captchaImg.src =
              "../vendor/securimage-nextgen/securimage_show.php?_=" +
              new Date().getTime();
          });
        }
      });
    </script>
    <script>
      window.addEventListener("resize", function () {
        const footer = document.querySelector("footer.footer");
        if (window.innerHeight < 500) {
          footer.style.display = "none";
        } else {
          footer.style.display = "block";
        }
      });
    </script>
    <script>
      document.getElementById('loginForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent default form submission

        const formData = new FormData(this);

        fetch('../login-post.php', {
          method: 'POST',
          body: formData
        })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              window.location.href = data.redirect || 'pages/dashboard.html';
            } else {
              alert(data.message || 'Login failed. Please try again.');
              // Refresh CAPTCHA on failed login
              document.getElementById('captcha-img').src =
                '../vendor/securimage-nextgen/securimage_show.php?_=' + new Date().getTime();
              document.getElementById('captcha_code').value = '';
            }
          })
          .catch(error => {
            alert('An error occurred during login. Please try again.');
            console.error('Error:', error);
            // Refresh CAPTCHA on error
            document.getElementById('captcha-img').src =
              '../vendor/securimage-nextgen/securimage_show.php?_=' + new Date().getTime();
            document.getElementById('captcha_code').value = '';
          });
      });
    </script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
    <script>
      // Periksa parameter query 'alert' di URL
      const urlParams = new URLSearchParams(window.location.search);
      const alertMessage = urlParams.get('alert');
      if (alertMessage) {
        alert(decodeURIComponent(alertMessage));
        // Hapus parameter alert dari URL tanpa reload halaman
        window.history.replaceState({}, document.title, window.location.pathname);
      }
    </script>
  </body>
</html>