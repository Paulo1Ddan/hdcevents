    @extends("layouts.main")
    @section('title', 'HDC Events')
    @section("content")
        <img src="/img/banner.jpg" alt="">
        @if(10 < 5)

            <p>Condição Verdadeira</p>

        @else

            <p>Consição falsa</p>

            @endif

        @if($name == "Paulo")
            <p>O usuário {{$name}} é um admin. Idade: {{$idade}} anos, e trabalha com {{$profissao}}</p>
        @elseif($name == "Ricardo Millos")
            <p>Admin Gigachad</p>
        @else
            <p>O usuário {{$name}} é um usuário comum.</p>
        @endif

        @for($i = 0; $i < count($arr); $i++)
            <p>{{$arr[$i]}} - {{$i}}</p>
            @if($i == 2)
                <p>O $i é igual a 2</p>
            @endif
        @endfor

        @php
            $name = "Jão";
            echo $name;
        @endphp

        {{-- Comentario do blade --}}

        @foreach($arrName as $name)
            <p>[{{$loop->index}}] - {{$name}}</p>
        @endforeach
    @endsection
