@extends('layouts.app')

@section('titulo')
    Inicia sesión en DevStagram
@endsection

@section('contenido')
    <div class="md:flex justify-center md:gap-10  md:items-center">
        <div class="md:w-6/12 p-5">
            <img src="{{ asset('img/login.jpg') }}" alt="Imagen de login de usuarios">
        </div>
        <div class="md:w-4/12 p-6 bg-white rounded-lg shadow-xl">
            <form method="POST" action="{{ route('login', ['id' => 1]) }}">
                @csrf
                @if (session('mensaje'))
                    <p class="bg-red-500 text-white my-2 rounded-lg p-2 text-center">
                        {{ session('mensaje') }}
                    </p>
                @endif
                <div class="mb-5">
                    <label for="email" class="mb-2 block uppercase text-gray-500 font-bold">
                        E-mail
                    </label>
                    <input id="email" name="email" type="email" placeholder="Tu E-mail"
                        class="border p-3 w-full rounded-lg
                    @error('username')
                    border-red-500
                @enderror"
                        value="{{ old('email') }}" />
                    @error('email')
                        <p class="bg-red-500 text-white my-2 rounded-lg p-2 text-center">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="password" class="mb-2 block uppercase text-gray-500 font-bold">
                        Password
                    </label>
                    <input id="password" name="password" type="password" placeholder="Password de registro"
                        class="border p-3 w-full rounded-lg 
                    @error('password')
                    border-red-500
                @enderror" />
                    @error('password')
                        <p class="bg-red-500 text-white my-2 rounded-lg p-2 text-center">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-5">
                    <input type="checkbox" name="remember">
                    <label class="text-sm text-gray-500">Mantener mi sesión abierta</label>
                </div>

                <input type="submit" value="Iniciar sesion"
                    class="bg-sky-600 hover:bg-sky-700 transition-colors 
                rounded-md
                cursor-pointer font-bold uppercase p-3 w-full text-white">
            </form>
        </div>
    </div>
@endsection
