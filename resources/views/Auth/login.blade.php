<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login — E-Library SMKN 3 Banjar</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
* { margin:0; padding:0; box-sizing:border-box; font-family:'Plus Jakarta Sans', sans-serif; }

body {
    min-height: 100vh;
    display: flex;
    background: #0f0f1a;
    overflow: hidden;
}

/* ── LEFT PANEL ── */
.left-panel {
    flex: 1;
    background: linear-gradient(145deg, #2bb3c0 0%, #4a4e6d 60%, #1a1a2e 100%);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 60px 40px;
    position: relative;
    overflow: hidden;
}

.left-panel::before {
    content: '';
    position: absolute;
    width: 400px; height: 400px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
    top: -100px; left: -100px;
}

.left-panel::after {
    content: '';
    position: absolute;
    width: 300px; height: 300px;
    border-radius: 50%;
    background: rgba(255,255,255,0.04);
    bottom: -80px; right: -80px;
}

.brand-icon {
    font-size: 64px;
    margin-bottom: 24px;
    filter: drop-shadow(0 8px 20px rgba(0,0,0,0.3));
    animation: float 4s ease-in-out infinite;
}

@keyframes float {
    0%,100% { transform: translateY(0); }
    50%      { transform: translateY(-12px); }
}

.left-panel h1 {
    color: white;
    font-size: 28px;
    font-weight: 700;
    text-align: center;
    margin-bottom: 10px;
    line-height: 1.3;
}

.left-panel p {
    color: rgba(255,255,255,0.7);
    font-size: 14px;
    text-align: center;
    max-width: 280px;
    line-height: 1.7;
}

.dots {
    display: flex;
    gap: 8px;
    margin-top: 36px;
}

.dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    background: rgba(255,255,255,0.3);
}

.dot.active { background: white; width: 24px; border-radius: 4px; }

/* ── RIGHT PANEL ── */
.right-panel {
    width: 460px;
    flex-shrink: 0;
    background: #ffffff;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 60px 48px;
}

.right-panel h2 {
    font-size: 26px;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 6px;
}

.right-panel .tagline {
    font-size: 14px;
    color: #aaa;
    margin-bottom: 36px;
}

/* Input */
.input-wrap {
    position: relative;
    margin-bottom: 18px;
}

.input-wrap label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: #555;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 7px;
}

.input-wrap .icon {
    position: absolute;
    left: 14px;
    bottom: 13px;
    font-size: 16px;
    pointer-events: none;
}

.input-wrap input {
    width: 100%;
    padding: 13px 14px 13px 42px;
    border-radius: 12px;
    border: 1.5px solid #e8e8e8;
    font-size: 14px;
    color: #1a1a2e;
    background: #fafafa;
    transition: 0.2s;
    outline: none;
}

.input-wrap input:focus {
    border-color: #2bb3c0;
    background: white;
    box-shadow: 0 0 0 3px rgba(43,179,192,0.12);
}

.input-wrap input::placeholder { color: #ccc; }

/* Button */
.btn-login {
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 12px;
    background: linear-gradient(135deg, #2bb3c0, #4a4e6d);
    color: white;
    font-weight: 700;
    font-size: 15px;
    cursor: pointer;
    margin-top: 8px;
    transition: 0.3s;
    box-shadow: 0 6px 20px rgba(43,179,192,0.35);
    letter-spacing: 0.3px;
}

.btn-login:hover {
    opacity: 0.92;
    transform: translateY(-2px);
    box-shadow: 0 10px 28px rgba(43,179,192,0.45);
}

/* Error */
.alert-error {
    background: #fff0f0;
    border-left: 4px solid #e74c3c;
    color: #c0392b;
    padding: 11px 14px;
    border-radius: 10px;
    font-size: 13px;
    margin-bottom: 20px;
}

/* Footer */
.login-footer {
    margin-top: 32px;
    font-size: 12px;
    color: #ccc;
    text-align: center;
}

/* Responsive */
@media(max-width: 768px) {
    .left-panel { display: none; }
    .right-panel { width: 100%; padding: 40px 28px; }
}
</style>
</head>
<body>

<!-- LEFT -->
<div class="left-panel">
    <div class="brand-icon">📚</div>
    <h1>E-Library<br>SMKN 3 Banjar</h1>
    <p>Akses ribuan koleksi buku digital kapan saja dan di mana saja.</p>
    <div class="dots">
        <div class="dot active"></div>
        <div class="dot"></div>
        <div class="dot"></div>
    </div>
</div>

<!-- RIGHT -->
<div class="right-panel">

    <h2>Selamat Datang 👋</h2>
    <p class="tagline">Masuk menggunakan Email atau NIS kamu</p>

    @if($errors->any())
    <div class="alert-error">
        @foreach($errors->all() as $error)
        <div>{{ $error }}</div>
        @endforeach
    </div>
    @endif

    @if(session('error'))
    <div class="alert-error">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('login.process') }}">
        @csrf

        <div class="input-wrap">
            <label>Email atau NIS</label>
            <span class="icon">👤</span>
            <input type="text" name="email" placeholder="Masukkan email atau NIS" required value="{{ old('email') }}">
        </div>

        <div class="input-wrap">
            <label>Password</label>
            <span class="icon">🔒</span>
            <input type="password" name="password" placeholder="Masukkan password" required>
        </div>

        <button type="submit" class="btn-login">Masuk</button>

    </form>

    <div class="login-footer">
        Sistem Informasi Perpustakaan &copy; {{ date('Y') }}
    </div>

</div>

</body>
</html>
