<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Dibatasi - Resto App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8fafc; font-family: 'Inter', sans-serif; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .error-container { text-align: center; max-width: 500px; padding: 40px; }
        .error-code { font-size: 120px; font-weight: 900; color: #ef4444; margin: 0; line-height: 1; }
        .error-title { font-size: 24px; font-weight: 800; color: #1e293b; margin: 20px 0 10px; }
        .error-msg { color: #64748b; margin-bottom: 30px; }
        .btn-home { background: #1e3a5f; color: white; font-weight: 700; padding: 12px 30px; border-radius: 12px; text-decoration: none; display: inline-block; transition: all 0.2s; }
        .btn-home:hover { background: #0f172a; color: white; transform: translateY(-2px); }
    </style>
</head>
<body>
    <div class="error-container">
        <h1 class="error-code">403</h1>
        <h2 class="error-title">Akses Dilarang</h2>
        <p class="error-msg">Maaf, Anda tidak memiliki izin untuk mengakses halaman ini. Ini adalah area terbatas.</p>
        <a href="{{ url('/dashboard') }}" class="btn-home"><i class="fas fa-shield-halved me-2"></i>Kembali</a>
    </div>
</body>
</html>
