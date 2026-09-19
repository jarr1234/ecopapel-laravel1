@extends('layouts.app')

@section('title', 'Finalizar compra | Ecopapel')

@section('content')

<div class="comprar-container">

    <h2>💳 Finalizar compra</h2>

    <form action="{{ route('comprar.procesar') }}" method="POST">

        @csrf

        <div class="form-group">

            <label for="direccion">
                📍 Dirección
            </label>

            <input
                type="text"
                id="direccion"
                name="direccion"
                value="{{ old('direccion') }}"
                placeholder="Escribe tu dirección"
                maxlength="500"
                required
            >

            @error('direccion')
                <span class="form-error">
                    {{ $message }}
                </span>
            @enderror

        </div>

        <div class="form-group">

            <label for="telefono">
                📞 Número telefónico
            </label>

            <input
                type="tel"
                id="telefono"
                name="telefono"
                value="{{ old('telefono') }}"
                placeholder="Escribe tu número telefónico"
                maxlength="20"
                required
            >

            @error('telefono')
                <span class="form-error">
                    {{ $message }}
                </span>
            @enderror

        </div>

        <div class="form-group">

            <label for="metodo_pago">
                💰 Método de pago
            </label>

            <select
                id="metodo_pago"
                name="metodo_pago"
                required
            >
                <option value="">
                    Selecciona
                </option>

                <option
                    value="Efectivo"
                    @selected(old('metodo_pago') === 'Efectivo')
                >
                    Efectivo
                </option>

                <option
                    value="Tarjeta"
                    @selected(old('metodo_pago') === 'Tarjeta')
                >
                    Tarjeta
                </option>

                <option
                    value="Transferencia"
                    @selected(old('metodo_pago') === 'Transferencia')
                >
                    Transferencia
                </option>
            </select>

            @error('metodo_pago')
                <span class="form-error">
                    {{ $message }}
                </span>
            @enderror

        </div>

        <button type="submit" class="btn-confirmar">
            ✅ Confirmar compra
        </button>

    </form>

</div>

@endsection