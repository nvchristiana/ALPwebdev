@extends('products.layout')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header text-center fw-bold bg-success text-white">Daftar Akun Baru</div>
            <div class="card-body">
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <div class="input-group">
                            <input type="password" name="password" id="pass1" class="form-control" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePass('pass1', 'icon1')">
                                <i class="bi bi-eye" id="icon1"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Konfirmasi Password</label>
                        <div class="input-group">
                            <input type="password" name="password_confirmation" id="pass2" class="form-control" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePass('pass2', 'icon2')">
                                <i class="bi bi-eye" id="icon2"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Daftar</button>
                </form>
                <div class="text-center mt-3">
                    <a href="{{ route('login') }}">Sudah punya akun? Login</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePass(id, iconId) {
        var x = document.getElementById(id);
        var icon = document.getElementById(iconId);
        if (x.type === "password") {
            x.type = "text";
            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");
        } else {
            x.type = "password";
            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");
        }
    }
</script>
@endsection