@extends('auth.template.index')

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ route('login') }}"><b>A</b>dminlte</a>
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Digite seus dados para criar sua conta !!</p>

                <form action="{{ route('register') }}" method="post">
                    @csrf

                    <div class="input-group mb-3">
                        <label for="name"></label>
                        <input type="text" @error('name') has-error @enderror value="{{ old('name') ?? '' }}"
                            name="name" id="name" class="form-control" placeholder="Nome">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        <hr>
                    @enderror

                    <div class="input-group mb-3">
                        <label for="email"></label>
                        <input type="email" @error('email') has-error @enderror value="{{ old('email') ?? '' }}"
                            name="email" id="email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                        <hr>
                    @enderror

                    <div class="input-group mb-3">
                        <label for="password"></label>
                        <input type="password" @error('password') has-error @enderror value="{{ old('password') ?? '' }}"
                            name="password" id="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                        <hr>
                    @enderror

                    <div class="input-group mb-3">
                        <label for="password_confirmation"></label>
                        <input type="password" @error('password_confirmation') has-error @enderror
                            value="{{ old('password_confirmation') ?? '' }}" name="password_confirmation"
                            id="password_confirmation" class="form-control" placeholder="Confirme a senha">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    @error('password_confirmation')
                        <span class="text-danger">{{ $message }}</span>
                        <hr>
                    @enderror

                    <div class="row">
                        <div class="col-8"></div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Registrar</button>
                        </div>
                    </div>
                </form>

                <div class="social-auth-links text-center mb-3">
                    <hr>
                    <a href="{{ route('password.email') }}" class="btn btn-block btn-primary">
                        <i class="fa fa-lock mr-2"></i> Esqueci minha senha
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-block btn-danger">
                        <i class="fa fa-user-plus mr-2"></i> Já tenho conta.
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
