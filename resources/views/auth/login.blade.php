<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign In - {{ config('app.name', 'Rel-Book') }}</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', sans-serif;
    height: 100vh;
    background: #f3eadf;
}

/* LAYOUT */
.container {
    display: flex;
    height: 100vh;
}

/* LEFT */
.left {
    width: 60%;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    padding-right: 40px;
    padding-top: 40px;
}

/* FORM SUPER BESAR */
.form-box {
    width: 700px;
    padding: 50px 60px;
    background: rgba(255,255,255,0.4);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border-radius: 26px;
    border: 1px solid rgba(255,255,255,0.5);
    box-shadow: 0 20px 50px rgba(0,0,0,0.1);
}

.form-box h1 {
    font-size: 2rem;
    color: #e6a56d;
    margin-bottom: 12px;
    font-weight: 700;
}

.or {
    font-size: 0.85rem;
    color: #777;
    margin-bottom: 12px;
}

/* SOCIAL */
.social {
    display: flex;
    gap: 12px;
    margin-bottom: 18px;
}

.social div {
    width: 48px;
    height: 48px;
    background: #fff;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 3px 8px rgba(0,0,0,0.06);
    cursor: pointer;
    transition: 0.2s;
}

.social div:hover {
    transform: translateY(-2px);
}

/* INPUT */
.group {
    margin-bottom: 14px;
}

.group input {
    width: 100%;
    padding: 12px;
    border-radius: 12px;
    border: none;
    outline: none;
    background: rgba(255,255,255,0.65);
    font-family: 'Inter', sans-serif;
    font-size: 0.9rem;
}

.group input:focus {
    background: rgba(255,255,255,0.85);
    box-shadow: 0 0 0 2px #e6a56d;
}

/* PASSWORD */
.pass {
    display: flex;
    background: rgba(255,255,255,0.65);
    border-radius: 12px;
}

.pass input {
    border: none;
    flex: 1;
    background: transparent;
}

.pass button {
    border: none;
    background: none;
    padding: 0 12px;
    cursor: pointer;
    font-size: 1rem;
    color: #888;
}

/* CHECKBOX */
.checkbox-group {
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 12px 0;
}

.checkbox-group input {
    width: 16px;
    height: 16px;
    cursor: pointer;
    accent-color: #e6a56d;
}

.checkbox-group label {
    font-size: 0.8rem;
    color: #555;
    cursor: pointer;
}

/* BUTTON */
.btn {
    width: 100%;
    padding: 14px;
    border-radius: 28px;
    background: #e6a56d;
    color: white;
    border: none;
    margin-top: 12px;
    cursor: pointer;
    transition: 0.2s;
    font-size: 0.95rem;
    font-weight: 600;
}

.btn:hover {
    background: #d1905c;
    transform: translateY(-1px);
}

/* LINK */
.link {
    text-align: center;
    margin-top: 14px;
    font-size: 0.8rem;
    color: #777;
}

.link a {
    color: #e6a56d;
    text-decoration: none;
    font-weight: 600;
}

.link a:hover {
    text-decoration: underline;
}

/* FORGOT PASSWORD */
.forgot-link {
    display: block;
    text-align: right;
    font-size: 0.7rem;
    color: #e6a56d;
    text-decoration: none;
    margin-top: 4px;
}

.forgot-link:hover {
    text-decoration: underline;
}

/* ERROR */
.error {
    font-size: 0.7rem;
    color: #dc2626;
    margin-top: 4px;
    display: none;
}
.error.show {
    display: block;
}

/* RIGHT */
.right {
    width: 60%;
    position: relative;
    background-image: url('{{ asset("images/remove.png") }}');
    background-repeat: no-repeat;
    background-size: contain;
    background-position: center left;
}

/* OVERLAY BIAR SOFT */
.right::after {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(243, 234, 223, 0.55);
}

/* TEXT */
.text {
    position: absolute;
    left: 25%;
    top: 50%;
    transform: translate(-50%, -50%);
    font-family: serif;
    color: #d19173;
    z-index: 1;
    text-shadow: 2px 2px 8px rgba(0,0,0,0.05);
}

.text h1 {
    font-size: 120px;
    margin-bottom: -20px;
    text-shadow:
        4px 4px 0px rgba(139,94,60,.25),
        8px 8px 0px rgba(139,94,60,.15),
        12px 12px 20px rgba(92,61,30,.2),
        0 0 40px rgba(196,154,108,.3);
    letter-spacing: -2px;
}
.text h2 {
    font-size: 100px;
    margin-bottom: -20px;
    text-shadow:
        4px 4px 0px rgba(139,94,60,.25),
        8px 8px 0px rgba(139,94,60,.15),
        12px 12px 20px rgba(92,61,30,.2),
        0 0 40px rgba(196,154,108,.3);
    letter-spacing: -2px;
}
.text h3 {
    font-size: 120px;
    text-shadow:
        4px 4px 0px rgba(139,94,60,.25),
        8px 8px 0px rgba(139,94,60,.15),
        12px 12px 20px rgba(92,61,30,.2),
        0 0 40px rgba(196,154,108,.3);
    letter-spacing: -2px;
}

/* RESPONSIVE */
@media (max-width: 900px) {
    .container {
        flex-direction: column;
    }
    .left, .right {
        width: 100%;
        height: auto;
        min-height: 50vh;
    }
    .left {
        justify-content: center;
        padding-right: 0;
        padding: 20px;
    }
    .form-box {
        width: 100%;
        max-width: 500px;
        padding: 30px;
    }
    .text {
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }
    .text h1, .text h2, .text h3 {
        font-size: 40px;
    }
}
</style>
</head>
<body>

{{-- Logo --}}
<div style="position:fixed;top:20px;left:44px;z-index:999;display:flex;align-items:center;gap:1px">
    <div style="
        width:200x;height:150px;
        padding:6px;
    ">
        <img src="{{ asset('images/pipi.png') }}"
             style="width:100%;height:100%;object-fit:contain"
             alt="Logo">
    </div>
    <div style="line-height:1.3">
        <div style="
            font-family:'Georgia',serif;
            font-weight:700;
            font-size:1.15rem;
            color:#d19173;
            text-shadow:0 1px 4px rgba(255,255,255,.6);
            letter-spacing:.01em;
        ">Rell-Book</div>
        <div style="
            font-size:.8rem;
            color:#9c7c5c;
            font-style:italic;
            letter-spacing:.04em;
        ">Digital Library</div>
    </div>
</div>

<div class="container">

    <!-- LEFT - FORM LOGIN -->
    <div class="left">
        <div class="form-box">

            <h1>Sign In</h1>

            <div class="social">
                <div id="googleBtn"><i class="bi bi-google"></i></div>
                <div id="facebookBtn"><i class="bi bi-facebook"></i></div>
                <div id="appleBtn"><i class="bi bi-apple"></i></div>
            </div>

            <!-- FORM LOGIN LARAVEL -->
            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <!-- EMAIL -->
                <div class="group">
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required autofocus>
                    @error('email')
                        <div class="error show">{{ $message }}</div>
                    @enderror
                </div>

                <!-- PASSWORD -->
                <div class="group">
                    <div class="pass">
                        <input type="password" id="password" name="password" placeholder="Password" required>
                        <button type="button" id="togglePassBtn">
                            <i class="bi bi-eye-slash"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="error show">{{ $message }}</div>
                    @enderror
                </div>

                <!-- REMEMBER ME & FORGOT PASSWORD -->
                <div class="checkbox-group">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Ingat Aku</label>
                </div>
                <a href="{{ route('password.request') }}" class="forgot-link">Lupa Password?</a>

                <button type="submit" class="btn">Sign In</button>
            </form>

            <div class="link">
                Belum Punya Akun Yaaa? <a href="{{ route('register') }}">Registrasi Mari</a>
            </div>

        </div>
    </div>

    <!-- RIGHT - IMAGE + TEXT -->
    <div class="right">
        <div class="text">
            <h1>Let's</h1>
            <h2>read the</h2>
            <h3>book</h3>
        </div>
    </div>

</div>

<script>
// ============ TOGGLE PASSWORD ============
const togglePassBtn = document.getElementById('togglePassBtn');
const passwordInput = document.getElementById('password');

if (togglePassBtn && passwordInput) {
    togglePassBtn.addEventListener('click', function() {
        const type = passwordInput.type === 'password' ? 'text' : 'password';
        passwordInput.type = type;
        const icon = this.querySelector('i');
        if (type === 'text') {
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        } else {
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        }
    });
}

// ============ SOCIAL LOGIN (DEMO) ============
document.getElementById('googleBtn')?.addEventListener('click', () => alert('Google login coming soon'));
document.getElementById('facebookBtn')?.addEventListener('click', () => alert('Facebook login coming soon'));
document.getElementById('appleBtn')?.addEventListener('click', () => alert('Apple login coming soon'));
</script>

</body>
</html>