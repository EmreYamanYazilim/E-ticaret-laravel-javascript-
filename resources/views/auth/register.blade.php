@extends('layouts.auth')

@section('title','Kayıt Ol')

@push('css')

@endpush

@section('body')
<div class="col-md-8 ps-md-0">
    <div class="auth-form-wrapper px-4 py-5">
        <a href="#" class="noble-ui-logo d-block mb-2">EmreYamanYazılım<span>EYY</span></a>
        <h5 class="text-muted fw-normal mb-4">Ücretsiz bir hesap oluşturun.</h5>
        <form class="forms-sample" {{  route('register') }} method="POST" id="registerForm">
            <div class="mb-3">
                <label for="name" class="form-label">Kullanıcı Adı</label>
                <input type="text" class="form-control" id="name"
                    name="name" placeholder="Ad Soyad">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">E-mail </label>
                <input type="email" class="form-control" id="email"
                    name="email" placeholder="E-mail Adresi">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Şifre</label>
                <input type="password" class="form-control" id="password"
                    name="password" placeholder="Şifreinizi Girin">
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Şifre</label>
                <input type="password" class="form-control" id="password_confirmation"
                    name="password_confirmation" placeholder="Şifreinizi Tekrar Girin">
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" id="authCheck" name="remember">
                <label class="form-check-label" for="authCheck">
                    Beni Hatırla
                </label>
            </div>
            <div>
                <a href="../../dashboard.html"
                    class="btn btn-primary text-white me-2 mb-2 mb-md-0">Kayıt Ol</a>
                <button type="button"
                    class="btn btn-outline-primary btn-icon-text mb-2 mb-md-0">
                    <i class="mdi mdi-google" data-feather="google"></i>
                    Google ile giriş yap
                </button>
            </div>
            <a href="{{ route('login') }}" class="d-block mt-3 text-muted">Zaten bir kullanıcı mısınız? Giriş yapın</a>
        </form>
    </div>
</div>
@endsection

@push('js')

@endpush
