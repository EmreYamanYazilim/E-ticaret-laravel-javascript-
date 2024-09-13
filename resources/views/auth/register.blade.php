@extends('layouts.auth')

@section('title', 'Kayıt Ol')

@push('css')
@endpush

@section('body')
    <div class="col-md-8 ps-md-0">
        <div class="auth-form-wrapper px-4 py-5">
            <a href="#" class="noble-ui-logo d-block mb-2">EmreYamanYazılım<span>EYY</span></a>
            <h5 class="text-muted fw-normal mb-4">Ücretsiz bir hesap oluşturun.</h5>
            <form class="forms-sample" {{ route('register') }} method="POST" id="registerForm">
                @csrf
                {{-- backend tarafından  RegisterRequest ile ilettiğim hatalr ben frontendtten devam edicem --}}

                {{-- <div class="alert alert-danger">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div> --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Kullanıcı Adı</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Ad Soyad"
                        value="{{ old('name') }}">
                    {{-- yukarıda toplu şekilde hataları verdim ama özel olarak altında backendten gelen hatalrı vermeke istersek tek tek belirterek böyle verebiliyoruz --}}
                    @error('name')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail </label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="E-mail Adresi"
                        value="{{ old('email') }}">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Şifre</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Şifreinizi Girin">
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Şifre Tekrarı</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                        placeholder="Şifreinizi Tekrar Girin">
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="authCheck" name="remember">
                    <label class="form-check-label" for="authCheck">
                        Beni Hatırla
                    </label>
                </div>
                <div>
                    <a href="javascript:void(0)" class="btn btn-primary text-white me-2 mb-2 mb-md-0" id="btnRegister">Kayıt
                        Ol</a>
                    <button type="button" class="btn btn-outline-primary btn-icon-text mb-2 mb-md-0">
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
    <script src="{{ asset('assets/js/auth/register.js') }}"></script>
@endpush
