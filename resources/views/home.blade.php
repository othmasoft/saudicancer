@extends('layouts.app')

@section('title', __('app.support'))

@section('content')

    <div class="row justify-content-center mt-4">
        <div class="col-md-8">

            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-0">{{ __('app.support') }}</h5>
                </div>

                <div class="card-body text-center">

                    <div class="d-grid gap-3">
                        {{-- زر إضافة رسالة دعم --}}
                        <a href="{{ route('support.create') }}" class="btn btn-success btn-lg">
                            <i class="bi bi-plus-circle"></i> {{ __('app.add_support_message') }}
                        </a>

                        {{-- زر عرض الرسائل --}}
                        <a href="{{ route('support.show') }}" class="btn btn-info btn-lg">
                            <i class="bi bi-chat-dots"></i> {{ __('app.show_support_message') }}
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>

@endsection
