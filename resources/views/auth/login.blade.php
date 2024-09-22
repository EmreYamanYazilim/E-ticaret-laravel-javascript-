@extends('layouts.auth')

@section('title', 'Giriş Yap')

@push('css')
@endpush

@section('body')
    <div class="col-md-8 ps-md-0">
        <div class="auth-form-wrapper px-4 py-5">
            <a href="#" class="noble-ui-logo d-block mb-2">EmreYamanYazılım<span>EYY</span></a>
            <h5 class="text-muted fw-normal mb-4"> Tekrar hoş geldiniz! Hesabınıza giriş yapın.</h5>
            <form class="forms-sample" id="loginForm" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail </label>
                    <input type="email" class="form-control" name="email" id="email"
                        placeholder="E-mail Adresinizi Girin" value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Şifre</label>
                    <input type="password" class="form-control" name="password" id="password"
                        placeholder="Şifrenizi Girin">
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="authCheck">
                    <label class="form-check-label" for="authCheck">
                        Beni Hatırla
                    </label>
                </div>
                <div>
                    <a href="javascript:void(0)" id="btnLogin"
                       class="btn btn-primary me-2 mb-2 mb-md-0 text-white">Giriş Yap</a>
                    <a href="{{ route('login.socialite', ['driver' => 'google']) }}"
                            class="btn btn-outline-primary btn-icon-text mb-2 mb-md-0">
                        <i class="mdi mdi-google"></i>
                        Google İle Giriş Yap
                    </a>
                </div>
                <a href="{{ route('register') }}" class="d-block mt-3 text-muted">Kullanıcı değil misiniz? Kayıt olun </a>
            </form>
        </div>
    </div>

@endsection

@push('js')
    <script src="{{ asset('assets/js/auth/login.js') }}"></script>
@endpush
