@extends('layouts.auth')

@section('title', 'Giriş Yap')

@push('css')
@endpush

@section('body')
    <div class="col-md-8 ps-md-0">
        <div class="auth-form-wrapper px-4 py-5">
            <a href="#" class="noble-ui-logo d-block mb-2">EmreYamanYazılım<span>EYY</span></a>
            <h5 class="text-muted fw-normal mb-4"> Tekrar hoş geldiniz! Hesabınıza giriş yapın.</h5>
            <form class="forms-sample" {{ route('login') }} method="POST">
                <div class="mb-3">
                    <label for="userEmail" class="form-label">E-mail </label>
                    <input type="email" class="form-control" id="userEmail" placeholder="E-mail Adresinizi Girin">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Şifre</label>
                    <input type="password" class="form-control" id="password" placeholder="Şifrenizi Girin">
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="authCheck">
                    <label class="form-check-label" for="authCheck">
                        Beni Hatırla
                    </label>
                </div>
                <div>
                    <a href="javascript:void(0)" class="btn btn-primary me-2 mb-2 mb-md-0 text-white" id="btnLogin">Giriş
                        Yap</a>
                    <button type="button" class="btn btn-outline-primary btn-icon-text mb-2 mb-md-0">
                        <i class="mdi mdi-google" data-feather="google"></i>
                        Google ile giriş yap
                    </button>
                </div>
                <a href="{{ route('register') }}" class="d-block mt-3 text-muted">Kullanıcı değil misiniz? Kayıt olun </a>
            </form>
        </div>
    </div>

@endsection

@push('js')
@endpush
