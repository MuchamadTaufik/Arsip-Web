<!doctype html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Pengarsipan Digital Universitas Pasundan</title>
   <style>
      body, html {
         height: 100%;
         margin: 0;
         font-family: Arial, sans-serif;
         display: flex;
         justify-content: center;
         align-items: center;
      }
      .login-container {
         display: flex;
         flex-direction: row;
         width: 100%;
         max-width: 800px;
         height: auto;
         background-color: #34495e;
         border-radius: 8px;
         overflow: hidden;
         box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
         margin: 1rem;
      }
      .login-image {
         background-color: #2c3e50;
         color: white;
         display: flex;
         flex-direction: column;
         justify-content: center;
         align-items: center;
         padding: 2rem;
         flex: 1;
         text-align: center;
      }
      .login-image img {
         max-width: 80%;
         height: auto;
         margin-bottom: 1rem;
      }
      .login-image h2 {
         font-size: 1.5rem;
         line-height: 1.5;
         margin: 0;
      }
      .login-form {
         flex: 1;
         display: flex;
         flex-direction: column;
         justify-content: center;
         align-items: center;
         padding: 2rem;
         background-color: #ffffff;
         color: #2c3e50;
      }
      .login-form form {
         width: 100%;
         max-width: 300px;
      }
      .form-floating {
         margin-bottom: 1.5rem;
      }
      .form-floating input {
         width: 100%;
         padding: 0.75rem;
         border: 1px solid #ced4da;
         border-radius: 4px;
         font-size: 1rem;
         color: #495057;
         background-color: #fff;
      }
      .form-floating input::placeholder {
         color: #adb5bd;
      }
      .form-floating input:focus {
         border-color: #007bff;
         box-shadow: 0 0 5px rgba(0, 123, 255, 0.6);
         outline: none;
      }
      .form-floating label {
         color: #6c757d;
         margin-bottom: 0.5rem;
         display: block;
         font-size: 0.875rem;
      }
      .btn {
         background-color: #007bff;
         color: white;
         padding: 0.75rem;
         font-size: 1rem;
         border: none;
         border-radius: 4px;
         cursor: pointer;
         transition: background-color 0.3s ease;
      }
      .btn:hover {
         background-color: #0056b3;
      }
      .login-form p {
         margin-top: 1.5rem;
         font-size: 0.875rem;
         text-align: center;
         color: #adb5bd;
      }
      @media (max-width: 768px) {

         .login-container {
            flex-direction: column;
         }
         .login-image {
            padding: 1.5rem;
         }
         .login-form {
            padding: 1.5rem;
         }
      }

      @media (max-width: 480px) {
         .login-image img {
            max-width: 100px;
            margin-bottom: 0.7rem;
         }

         .form-floating input {
            width: 90%;
            padding: 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 1rem;
            color: #495057;
            background-color: #fff;
         }
      }
   </style>
</head>
<body>
   <div class="login-container">
      <div class="login-image">
         <img src="assets/img/logo.png" alt="Logo">
         <h3>Selamat Datang di Pengarsipan Digital Universitas Pasundan</h3>
      </div>
      <div class="login-form">
         <form class="form-log">
            <div class="text-center mb-4">
               <h1 class="h3 mb-3 fw-normal">Silahkan Login</h1>
            </div>
            <div class="form-floating">
               <label for="floatingInput">Email</label>
               <input type="email" id="floatingInput" placeholder="Masukan Alamat Email" required>
            </div>
            <div class="form-floating">
               <label for="floatingPassword">Password</label>
               <input type="password" id="floatingPassword" placeholder="Masukan Password" required>
            </div>
            <button class="btn" type="submit">Masuk</button>
            <p class="mt-3 mb-0 text-center">&copy; 2024 Universitas Pasundan</p>
         </form>
      </div>
   </div>
</body>
</html>
