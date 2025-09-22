@extends('layouts.app')

@section('title', 'نتائج الاختبار')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-10">

            {{-- Results Header --}}
            <div class="text-center mb-5">
                <div class="mb-4">
                    @if($score >= 80)
                        <i class="bi bi-trophy-fill display-1 text-warning"></i>
                    @elseif($score >= 60)
                        <i class="bi bi-award-fill display-1 text-success"></i>
                    @else
                        <i class="bi bi-emoji-smile-fill display-1 text-primary"></i>
                    @endif
                </div>

                <h1 class="display-5 text-primary mb-3">نتائج الاختبار</h1>

                {{-- Score Card --}}
                <div class="card border-0 shadow-lg mb-4" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                    <div class="card-body py-4">
                        <div class="row text-center">
                            <div class="col-md-4 mb-3">
                                <div class="score-circle mx-auto mb-2
                                    {{ $score >= 80 ? 'bg-warning' : ($score >= 60 ? 'bg-success' : 'bg-primary') }}">
                                    <span class="h2 text-white mb-0">{{ $score }}%</span>
                                </div>
                                <h6 class="text-muted">النتيجة الإجمالية</h6>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <i class="bi bi-check-circle-fill text-success me-2" style="font-size: 2rem;"></i>
                                    <span class="h3 text-success mb-0">{{ $
