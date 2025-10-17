<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>AMS - Login</title>
  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body class="bg-gray-soft">
  <main class="center-page">
    <div class="card max-w-md">
        <div class="text-center mb-6">
          <h1 class="title">AMS: Academic Monitoring</h1>
          <p class="muted">Secure Login</p>
        </div>
        <div id="loginError" class="error-message" style="display:none;color:red;margin-bottom:10px;"></div>      <form id="loginForm" class="form-stack" method="POST">
        <div id="loginError" class="error-message" style="display:none;color:red;margin-bottom:10px;"></div>
        <label class="label">Username
          <input id="username" name="username" class="input" type="text" required />
        </label>

        <label class="label">Password
          <input id="password" name="password" class="input" type="password" required />
        </label>

        <label class="label">Role
          <select id="role" name="role" class="select">
            <option value="instructor">Instructor</option>
            <option value="admin">Admin</option>
            <option value="student">Student/Parent</option>
          </select>
        </label>

        <button type="submit" class="btn primary w-full">LOGIN</button>

        <p class="text-center mt-4">
            Don't have an account? <a href="register.php" class="link">Register here</a>
        </p>
      </form>
    </div>
  </main>

  <script src="assets/js/main.js"></script>
</body>
</html>
