@extends("layouts.main")
@section("title", "Produtos")
@section("content")
<h1>Pagina de Produtos</h1>
@if($busca != '')
    <p>{{$busca}}</p>
@endif
@endsection
