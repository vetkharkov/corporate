{{--наследуем главный макет layouts/site.blade.php--}}
@extends(env('THEME').'.layouts.site')
{{--переопределяем секцию навигации--}}
@section('navigation')
	{!! $navigation !!}
@endsection
{{--переопределяем секцию слайдера--}}
@section('slider')
    {!! $sliders !!}
@endsection
{{--переопределяем секцию контента--}}
@section('content')
    {!! $content !!}
@endsection

{{--переопределяем секцию правого сайтбара--}}
@section('bar')
    {!! $rightBar !!}
@endsection

{{--переопределяем секцию COPYRIGHT FOOTER --}}
@section('footer')
    {!! $footer !!}
@endsection