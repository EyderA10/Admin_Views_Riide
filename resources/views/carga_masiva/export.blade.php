<table>
    <thead>
        <tr>
            <th style="font-weight: bold; font-size: 14px; text-align:center; width: 25px;">CATEGORIAS</th>
            <th style="font-weight: bold; font-size: 14px; text-align:center; width: 120px;">PASOS</th>
            <th></th>
            <th style="font-weight: bold; font-size: 14px; text-align:center; width: 25px;">PRODUCTO</th>
            <th style="font-weight: bold; font-size: 14px; text-align:center; width: 25px;">DESCRIPCION</th>
            <th style="font-weight: bold; font-size: 14px; text-align:center; width: 25px;">PRECIO_A</th>
            <th style="font-weight: bold; font-size: 14px; text-align:center; width: 25px;">PRECIO_B</th>
            <th style="font-weight: bold; font-size: 14px; text-align:center; width: 25px;">IMAGEN</th>
            @foreach ($tiendas as $tienda)
            <th style="font-weight: bold; font-size: 14px; text-align:center; width: 25px;">{{Auth::user()->roles->id === 7 ? $tienda->tienda : $tienda->tienda->tienda}}</th>
            <th style="font-weight: bold; font-size: 14px; text-align:center; width: 25px;">CANTIDAD-{{Auth::user()->roles->id === 7 ? $tienda->id : $tienda->tienda->id}}</th>
            <th style="font-weight: bold; font-size: 14px; text-align:center; width: 25px;">INVENTARIABLE-{{Auth::user()->roles->id === 7 ? $tienda->id : $tienda->tienda->id}}</th>
            @endforeach
            <th style="font-weight: bold; font-size: 14px; text-align:center; width: 25px;">CATEGORIA</th>
            <th style="font-weight: bold; font-size: 14px; text-align:center; width: 25px;">ADICIONAL</th>
            <th style="font-weight: bold; font-size: 14px; text-align:center; width: 25px;">PRECIO</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($categories as $key => $category)
        <tr>
            <td>{{$category->categoria}}</td>
            @if ($key === 0)
            <td>{{$pasos[$key]}}</td>
            @endif
            @if ($key === 1)
            <td>{{$pasos[$key]}}</td>
            @endif
            @if ($key === 2)
            <td>{{$pasos[$key]}}</td>
            @endif
            @if ($key === 3)
            <td>{{$pasos[$key]}}</td>
            @endif
            @if ($key === 4)
            <td>{{$pasos[$key]}}</td>
            @endif
            @if ($key === 5)
            <td>{{$pasos[$key]}}</td>
            @endif
            @if ($key === 6)
            <td>{{$pasos[$key]}}</td>
            @endif
        </tr>
        @endforeach
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tbody>

</table>