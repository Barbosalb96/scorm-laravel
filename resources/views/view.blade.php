<!-- resources/views/scorm/show.blade.php -->

{{--@extends('layouts.app') --}}{{-- Se você estiver usando um layout --}}
<?php
$html = file_get_contents(storage_path('app/' . $scorm->uuid) . '/' . $scorm->entry_url);
$pattern = '/https:\/\/scorm\.onilearning\.com\.br\/scorm\.php\?scorm=[a-zA-Z0-9]+/';
preg_match($pattern, $html, $matches);

if (isset($matches[0])) {
    echo "URL encontrado: " . $matches[0];
} else {
    echo "URL não encontrado.";
}
?>
{{--@section('content')--}}
<div class="container">
    <h1>Visualizar SCORM</h1>
    @if( $matches[0])
        <iframe src="{{ $matches[0]}}" width="100%" height="1000vh"></iframe>
    @else
        Scorm com erro
    @endif
</div>
{{--@endsection--}}
