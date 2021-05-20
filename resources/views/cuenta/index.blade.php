@extends('layout.app')
@section('content')
@include('includes.navbar', compact('name', 'icon'))
<div class="container">
    <div class="d-flex justify-content-center align-items-center"">
        <form>
            <div class=" form-inline">
        <button class="btn btn-secondary mr-1" type="submit"><i class="fas fa-search text-white"></i></button>
        <input class="form-control" type="search" placeholder="Buscar" aria-label="Search" style="width: 500px;">
    </div>
    </form>
    <div class="dropdown ml-0">
        <button style="background-color: #2fcece; color: white;" class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Todos
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="#">Pendiente</a>
            <a class="dropdown-item" href="#">Pagado</a>
            <a class="dropdown-item" href="#">Anulado</a>
        </div>
    </div>
</div>
<table class="table w-100 mt-4 text-center">
    <thead style="background-color: #2fcece; color: white;">
        <tr>
            <th scope="col"><i class="far fa-calendar-alt d-block"></i> Fecha</th>
            <th scope="col"><i class="far fa-clock d-block"></i> Hora</th>
            <th scope="col"><i class="fas fa-list-ol d-block"></i> Numero de Pedido</th>
            <th scope="col"><i class="fas fa-clipboard-list d-block"></i> Detalle</th>
            <th scope="col"><i class="fas fa-file-invoice-dollar d-block"></i> Monto</th>
            <th scope="col"><i class="fas fa-truck d-block"></i> Entrega</th>
            <th scope="col"><i class="fas fa-file-signature d-block"></i> Estado</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th style="border-top: 1px solid #2fcece;" scope="row">1</th>
            <td style="border-top: 1px solid #2fcece;">Mark</td>
            <td style="border-top: 1px solid #2fcece;">Otto</td>
            <td style="border-top: 1px solid #2fcece;">@mdo</td>
            <td style="border-top: 1px solid #2fcece;">Mark</td>
            <td style="border-top: 1px solid #2fcece;">Otto</td>
            <td style="border-top: 1px solid #2fcece;">@mdo</td>
        </tr>
        <tr>
            <th style="border-top: 1px solid #2fcece;" scope="row">2</th>
            <td style="border-top: 1px solid #2fcece;">Jacob</td>
            <td style="border-top: 1px solid #2fcece;">Thornton</td>
            <td style="border-top: 1px solid #2fcece;">@fat</td>
            <td style="border-top: 1px solid #2fcece;">Jacob</td>
            <td style="border-top: 1px solid #2fcece;">Thornton</td>
            <td style="border-top: 1px solid #2fcece;">@fat</td>
        </tr>
    </tbody>
</table>
</div>
@endsection