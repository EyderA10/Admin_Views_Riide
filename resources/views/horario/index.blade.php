@extends('layout.app')

@section('content')
@include('includes.navbar', compact('name', 'icon'))

<div class="container w-50 mb-5">
    <form id="form" action="{{route('create.horario')}}" method="POST">
        @csrf
        <input type="hidden" id="apertura" name="apertura" value="" />
        <input type="hidden" id="cierre" name="cierre" value="" />
        <div class="col form-label-group mx-auto w-25">
            <select class="form-control" id="tienda_id" name="tienda_id">
                @foreach ($tiendas as $tienda)
                @if (Auth::user()->roles->id === 7)
                <option value="{{$tienda->id}}">{{$tienda->tienda}}</option>
                @else
                <option value="{{$tienda->tienda->id}}">{{$tienda->tienda->tienda}}</option>
                @endif
                @endforeach
            </select>
        </div>
        <div class="d-flex justify-content-between text-center">
            <div>
                <p style="color: #2fcece; font-size: 22px;" class="font-weight-bold">Apertura</p>
                <div class="input-group" id="inputDateTimeStart" data-placement="bottom" data-autoclose="true">
                    <input id="time-start" type="text" class="form-control d-none">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-time"></span>
                    </span>
                </div>
                <!---Inicio--->
                <div id="inicio">
                </div>
                <!---Inicio--->
                <button type="button" onclick="handleClickPickerStart()" style="border-radius: 100px; background-color: #2fcece; color: white;" class="mt-3 btn btn-md"><i class="fas fa-plus"></i>
                </button>
            </div>
            <div>
                <div>
                    <p style="color: #2fcece; font-size: 22px;" class="font-weight-bold">Cierre</p>
                    <div class="input-group" id="inputDateTimeEnd" data-placement="bottom" data-autoclose="true">
                        <input id="time-end" type="text" class="form-control d-none">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div>
                    <!---Fin--->
                    <div id="fin">
                    </div>
                    <!---Fin--->
                    <button type="button" onclick="handleClickPickerEnd()" style="border-radius: 100px; background-color: #2fcece; color: white;" class="mt-3 btn btn-md"><i class="fas fa-plus"></i></button>
                </div>
            </div>
        </div>
        <div class="text-center d-flex flex-wrap justify-content-center align-content-end" style="min-height: 250px;">
            <button style="width: 150px; background-color: #2fcece; border: none;" class="btn btn-md btn-save text-white mb-2" type="submit">
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        days = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];
        console.log("tiendas = ", horarios)
        $('#inputDateTimeStart').clockpicker();
        $('#inputDateTimeEnd').clockpicker();
        $('#multiple-checkboxes').multiselect({
            buttonWidth: '200px',
            includeSelectAllOption: true,
            nonSelectedText: 'Selecciona un dia'
        });
    });


    function handleClickPickerStart() {
        $(document).ready(function() {
            $('#time-start').click();
        });
    }

    function handleClickPickerEnd() {
        $(document).ready(function() {
            $('#time-end').click();
        })
    }

    function handleChangePickerStart(e) {
        let time = e.target.value;
        cont_add = window.crypto.getRandomValues(new Uint32Array(1))[0];
        cont_add = cont_add.toString(16);
        $('#inicio').append(`<div id="div-inicio" class="d-flex justify-content-around my-3" style="border-bottom: 1px solid #2fcece">
                        <div>
                            <input type="time" data-type="inicio" data-id="${cont_add}" id="inicio-${cont_add}" name="inicio-${cont_add}" class="col-6 mx-auto form-control" value="${time}">
                            <select name="dia_inicio-${cont_add}" data-id="${cont_add}" id="dia-${cont_add}" multiple="multiple">
                            </select>
                        </div>
                        <div>
                            <div class="dropdown"><input data-id="${cont_add}" value="0" onchange="checkStatusInicio(event)" type="checkbox" name="status_inicio-${cont_add}" data-toggle="toggle" id="status-${cont_add}"></div>
                        </div>
                    </div>`);
        days.forEach((day, i) => {
            i++
            $(`#dia-${cont_add}`).append(`
                <option value="${i}">${day}</option>
            `);
        });
        $(document).ready(function() {
            $(`#status-${cont_add}`).bootstrapToggle({
                on: 'On',
                off: 'Off'
            });

            $(`#dia-${cont_add}`).multiselect({
                buttonWidth: '200px',
                includeSelectAllOption: true,
                nonSelectedText: 'Selecciona un dia'
            });
        });
    }

    function checkStatusInicio(e) {
        if (e.checked || $(`#status-${e.target.dataset.id}`).val() === "1") {
            $(`#status-${e.target.dataset.id}`).val("0");
        } else {
            $(`#status-${e.target.dataset.id}`).val("1");
        }
    }

    function handleChangePickerEnd(e) {
        let time = e.target.value;
        cont_add = window.crypto.getRandomValues(new Uint32Array(1))[0];
        cont_add.toString(16);
        cont_add = cont_add.toString(16);
        $('#fin').append(`<div id="cont-add-${cont_add}" class="d-flex justify-content-around my-3" style="border-bottom: 1px solid #2fcece">
                                <div>
                                    <input type="time" data-type="fin" data-id="${cont_add}" id="fin-${cont_add}" class="col-6 mx-auto form-control" name="fin-${cont_add}" value="${time}">
                                    <select name="dia_fin-${cont_add}" data-id="${cont_add}" id="dia-${cont_add}" multiple="multiple">
                                    </select>
                                </div>
                                <div>
                                    <div class="dropdown"><input data-id="${cont_add}" name="status_fin-${cont_add}" onchange="checkStatusFin(event)" value="0" type="checkbox" data-toggle="toggle" id="status-${cont_add}"></div>
                                </div>
                            </div>`);
            days.forEach((day, i) => {
                i++
                $(`#dia-${cont_add}`).append(`
                    <option value="${i}">${day}</option>
                `);
            });
        $(document).ready(function() {
            $(`#status-${cont_add}`).bootstrapToggle({
                on: 'On',
                off: 'Off'
            });
            $(`#dia-${cont_add}`).multiselect({
                buttonWidth: '200px',
                includeSelectAllOption: true,
                nonSelectedText: 'Selecciona un dia'
            });
        });
    }

    function checkStatusFin(e) {
        let dias = $(`#dia-${e.target.dataset.id}`).val();
        if (e.checked || $(`#status-${e.target.dataset.id}`).val() === "1") {
            $(`#status-${e.target.dataset.id}`).val("0");
        } else {
            $(`#status-${e.target.dataset.id}`).val("1");
        }
    }

    $("#form").submit(function(e) {
        // e.preventDefault();
        const input_inicio = $("input[data-type=inicio]");
        const input_fin = $("input[data-type=fin]");
        let apertura = [];
        let cierre = [];
        for (let i = 0; i < input_inicio.length; i++) {
            console.log("id = ", input_inicio[i].dataset.id, "value = ", input_inicio[i].value, "dias = ", $(`#dia-${input_inicio[i].dataset.id}`).val(), "status = ", $(`#status-${input_inicio[i].dataset.id}`).val());
            apertura.push({
                hora: input_inicio[i].value,
                dias: $(`#dia-${input_inicio[i].dataset.id}`).val(),
                state: $(`#status-${input_inicio[i].dataset.id}`).val(),
                type: 'inicio'
            });
        }
        for (let i = 0; i < input_fin.length; i++) {
            console.log("id = ", input_fin[i].dataset.id, "value = ", input_fin[i].value, "dias = ", $(`#dia-${input_fin[i].dataset.id}`).val(), "status = ", $(`#status-${input_fin[i].dataset.id}`).val());
            cierre.push({
                hora: input_fin[i].value,
                dias: $(`#dia-${input_fin[i].dataset.id}`).val(),
                state: $(`#status-${input_fin[i].dataset.id}`).val(),
                type: 'fin'
            });
        }
        console.log(apertura);
        console.log(cierre);
        apertura = JSON.stringify(apertura);
        $("#apertura")[0].value = apertura;
        cierre = JSON.stringify(cierre);
        $("#cierre")[0].value = cierre;
        console.log($("#apertura")[0].value);
        console.log($("#cierre")[0].value);
    });

    $('#time-start').on('change', handleChangePickerStart);
    $('#time-end').on('change', handleChangePickerEnd);
</script>
@endsection