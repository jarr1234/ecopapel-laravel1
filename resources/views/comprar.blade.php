@extends('layouts.app')

@section('title', 'Finalizar compra | Ecopapel')

@section('content')

<section class="pagina-compra">

    <div class="compra-encabezado">

        <span class="compra-etiqueta">
            Último paso
        </span>

        <h1>Finalizar compra</h1>

        <p>
            Completa tus datos para confirmar tu pedido.
        </p>

    </div>

    <div class="compra-layout">

        <div class="compra-formulario">

            <div class="compra-formulario-titulo">

                <span>📦</span>

                <div>
                    <h2>Datos de entrega</h2>
                    <p>Ingresa la información necesaria para tu pedido.</p>
                </div>

            </div>

            <form
                action="{{ route('comprar.procesar') }}"
                method="POST"
                class="form-compra"
                id="form-compra"
            >

                @csrf

                <div class="form-group">

                    <label for="direccion">
                        Dirección de entrega
                    </label>

                    <input
                        type="text"
                        id="direccion"
                        name="direccion"
                        value="{{ old('direccion') }}"
                        placeholder="Ej. Calle, número, colonia y referencias"
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
                        Número telefónico
                    </label>

                    <input
                        type="tel"
                        id="telefono"
                        name="telefono"
                        value="{{ old('telefono') }}"
                        placeholder="Ej. 963 123 4567"
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
                        Método de pago
                    </label>

                    <select
                        id="metodo_pago"
                        name="metodo_pago"
                        required
                    >

                        <option value="">
                            Selecciona un método de pago
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

                <div
                    id="pago-efectivo"
                    class="metodo-detalle"
                    style="display: none;"
                >

                    <div class="metodo-titulo">
                        <span>💵</span>

                        <div>
                            <h3>Pago en efectivo</h3>
                            <p>Realiza el pago al momento de recibir tu pedido.</p>
                        </div>
                    </div>

                    <div class="aviso-pago aviso-efectivo">
                        <span>✓</span>

                        <p>
                            Ten preparado el importe de tu compra
                            al momento de la entrega.
                        </p>
                    </div>

                </div>

                <div
                    id="pago-tarjeta"
                    class="metodo-detalle"
                    style="display: none;"
                >

                    <div class="metodo-titulo">

                        <span>💳</span>

                        <div>
                            <h3>Pago con tarjeta</h3>
                            <p>Simulación del formulario de pago.</p>
                        </div>

                    </div>

                    <div class="aviso-demostracion">

                        <strong>
                            MODO DEMOSTRACIÓN
                        </strong>

                        <p>
                            No se realizará ningún cargo.
                            No introduzcas datos de una tarjeta real.
                            La información escrita aquí no será enviada
                            ni almacenada.
                        </p>

                    </div>

                    <div class="tarjeta-simulacion">

                        <div class="tarjeta-chip">
                            ▰
                        </div>

                        <div
                            class="tarjeta-numero-vista"
                            id="tarjeta-numero-vista"
                        >
                            0000 0000 0000 0000
                        </div>

                        <div class="tarjeta-inferior">

                            <div>
                                <span>TITULAR</span>

                                <strong id="tarjeta-titular-vista">
                                    USUARIO DE PRUEBA
                                </strong>
                            </div>

                            <div>
                                <span>VENCE</span>

                                <strong id="tarjeta-fecha-vista">
                                    MM/AA
                                </strong>
                            </div>

                        </div>

                    </div>

                    <div class="campos-tarjeta">

                        <div class="form-group campo-completo">

                            <label for="tarjeta_titular">
                                Nombre del titular
                            </label>

                            <input
                                type="text"
                                id="tarjeta_titular"
                                placeholder="Ej. Usuario de prueba"
                                maxlength="50"
                                autocomplete="off"
                            >

                        </div>

                        <div class="form-group campo-completo">

                            <label for="tarjeta_numero">
                                Número de tarjeta de demostración
                            </label>

                            <input
                                type="text"
                                id="tarjeta_numero"
                                placeholder="0000 0000 0000 0000"
                                maxlength="19"
                                inputmode="numeric"
                                autocomplete="off"
                            >

                        </div>

                        <div class="form-group">

                            <label for="tarjeta_fecha">
                                Vencimiento
                            </label>

                            <input
                                type="text"
                                id="tarjeta_fecha"
                                placeholder="MM/AA"
                                maxlength="5"
                                inputmode="numeric"
                                autocomplete="off"
                            >

                        </div>

                        <div class="form-group">

                            <label for="tarjeta_cvv">
                                CVV de demostración
                            </label>

                            <input
                                type="password"
                                id="tarjeta_cvv"
                                placeholder="000"
                                maxlength="3"
                                inputmode="numeric"
                                autocomplete="off"
                            >

                        </div>

                    </div>

                </div>

                <div
                    id="pago-transferencia"
                    class="metodo-detalle"
                    style="display: none;"
                >

                    <div class="metodo-titulo">

                        <span>🏦</span>

                        <div>
                            <h3>Transferencia bancaria</h3>
                            <p>Datos de demostración para realizar la transferencia.</p>
                        </div>

                    </div>

                    <div class="aviso-demostracion">

                        <strong>
                            MODO DEMOSTRACIÓN
                        </strong>

                        <p>
                            Los siguientes datos son ficticios.
                            No realices una transferencia real.
                        </p>

                    </div>

                    <div class="datos-transferencia">

                        <div class="dato-transferencia">

                            <span>Titular</span>

                            <strong>
                                ECOPAPEL DEMOSTRACIÓN
                            </strong>

                        </div>

                        <div class="dato-transferencia">

                            <span>Banco</span>

                            <strong>
                                BANCO DEMO
                            </strong>

                        </div>

                        <div class="dato-transferencia">

                            <span>Número de cuenta</span>

                            <strong>
                                0000000000
                            </strong>

                        </div>

                        <div class="dato-transferencia">

                            <span>CLABE</span>

                            <strong>
                                000000000000000000
                            </strong>

                        </div>

                        <div class="dato-transferencia">

                            <span>Concepto</span>

                            <strong>
                                COMPRA ECOPAPEL
                            </strong>

                        </div>

                    </div>

                </div>

                <div class="compra-seguridad">

                    <span>🔒</span>

                    <p>
                        Esta versión de Ecopapel utiliza métodos
                        de pago únicamente con fines de demostración.
                    </p>

                </div>

                <button
                    type="submit"
                    class="btn-confirmar"
                >
                    Confirmar compra
                </button>

            </form>

        </div>

        <aside class="compra-ayuda">

            <div class="compra-ayuda-icono">
                🛍️
            </div>

            <h2>Estás por terminar</h2>

            <p>
                Verifica que tu dirección y teléfono sean correctos
                antes de confirmar tu compra.
            </p>

            <div class="compra-paso">

                <span>1</span>

                <p>
                    Agregaste tus productos
                </p>

            </div>

            <div class="compra-paso">

                <span>2</span>

                <p>
                    Revisaste tu carrito
                </p>

            </div>

            <div class="compra-paso activo">

                <span>3</span>

                <p>
                    Confirma tus datos
                </p>

            </div>

            <a
                href="{{ route('carrito') }}"
                class="volver-carrito"
            >
                ← Volver al carrito
            </a>

        </aside>

    </div>

</section>

<script>
const metodoPago = document.getElementById('metodo_pago');
const pagoEfectivo = document.getElementById('pago-efectivo');
const pagoTarjeta = document.getElementById('pago-tarjeta');
const pagoTransferencia = document.getElementById('pago-transferencia');

const tarjetaTitular = document.getElementById('tarjeta_titular');
const tarjetaNumero = document.getElementById('tarjeta_numero');
const tarjetaFecha = document.getElementById('tarjeta_fecha');
const tarjetaCvv = document.getElementById('tarjeta_cvv');

const tarjetaTitularVista = document.getElementById('tarjeta-titular-vista');
const tarjetaNumeroVista = document.getElementById('tarjeta-numero-vista');
const tarjetaFechaVista = document.getElementById('tarjeta-fecha-vista');

function mostrarMetodoPago() {
    pagoEfectivo.style.display = 'none';
    pagoTarjeta.style.display = 'none';
    pagoTransferencia.style.display = 'none';

    if (metodoPago.value === 'Efectivo') {
        pagoEfectivo.style.display = 'block';
    }

    if (metodoPago.value === 'Tarjeta') {
        pagoTarjeta.style.display = 'block';
    }

    if (metodoPago.value === 'Transferencia') {
        pagoTransferencia.style.display = 'block';
    }
}

metodoPago.addEventListener('change', mostrarMetodoPago);

tarjetaTitular.addEventListener('input', function () {
    let valor = this.value.trim().toUpperCase();

    tarjetaTitularVista.textContent =
        valor || 'USUARIO DE PRUEBA';
});

tarjetaNumero.addEventListener('input', function () {
    let valor = this.value.replace(/\D/g, '').slice(0, 16);

    valor = valor.replace(/(.{4})/g, '$1 ').trim();

    this.value = valor;

    tarjetaNumeroVista.textContent =
        valor || '0000 0000 0000 0000';
});

tarjetaFecha.addEventListener('input', function () {
    let valor = this.value.replace(/\D/g, '').slice(0, 4);

    if (valor.length >= 3) {
        valor =
            valor.slice(0, 2) +
            '/' +
            valor.slice(2);
    }

    this.value = valor;

    tarjetaFechaVista.textContent =
        valor || 'MM/AA';
});

tarjetaCvv.addEventListener('input', function () {
    this.value =
        this.value
            .replace(/\D/g, '')
            .slice(0, 3);
});

mostrarMetodoPago();
</script>

@endsection