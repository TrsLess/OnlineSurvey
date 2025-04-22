<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    />
    <link rel="stylesheet" href="./style.css" />
  </head>
  <body class="d-flex align-items-center justify-content-center vh-100">
    <div class="card p-4 shadow-lg opacity-" style="width: 400px">
      <h2 class="text-center mb-4">Login</h2>
      <form action="login.php" method="POST">
        <div class="mb-3">
          <label class="form-label">Email:</label>
          <input type="email" name="email" class="form-control" required />
        </div>

        <div class="mb-3">
          <label class="form-label">Password:</label>
          <input
            type="password"
            name="password"
            class="form-control"
            required
          />
        </div>

        <button type="submit" class="btn btn-success w-100">Login</button>
        <p class="text-center mt-2">
          Don't have an account? <a href="./register_page.html">Register</a>
        </p>
      </form>
    </div>
  </body>
</html>
