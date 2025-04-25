@extends('layouts.app')

@section('content')
<div id="header">
    <div class="btn-back" onclick="loadPage('{{ route('join') }}')"><i class="ri-arrow-left-line cursor-pointer"></i></div>
    <div class="title">Product Details</div>
</div>


<div id="page-content">
    <!-- Project list -->
    <div class="project-list-view">
        <div class="list-group">
            @foreach($projects as $project)
            <div class="list-group-item cursor-pointer" onclick="loadPage('{{ route('single_project',['project'=>$project->id]) }}')">
                <div class="project-item d-flex align-items-center">
                    <div class="thumbnail-wrapper">
                        <div class="thumbnail" style="background-image: url('{{ env('BACKEND_URL') }}/storage/{{ $project->thumbnail->file_path ?? '' }}')"></div>
                    </div>
                    <div class="project-info">
                        <div class="project-name">{{ $project->product_name }}</div>
                        <div class="project-details">
                            <div class="category">Belong to: {{ $project->category->category_name }}</div>
                            <div class="user-level">User Level: {{ $project->user_level }}</div>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="100.00" aria-valuemin="0" aria-valuemax="100" style="width: {{ $project->product_percentage }}%;">
                                    <div class="label">{{ $project->product_percentage }}%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="project-min-invest">MYR {{ number_format($project->product_price,2,'.',',') }}</div>
                </div>
                <div class="divider"></div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
@section('custom')
<script>
    $('.menu-item').removeClass('active');
</script>
@endsection