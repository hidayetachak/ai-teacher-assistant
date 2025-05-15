@extends('layouts.schoolDashboard')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('dashboard-content')
<style>
    <style>
    .package-card {
        transition: transform 0.3s ease-in-out;
        background: rgba(161, 161, 161, 0.1);
    }

    .package-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .popular-badge {
        position: absolute;
        top: 10px;
        right: 10px;
    }

    @media screen and (min-width: 768px){
        .heading{
            display: block;
            margin: 0px;
        }
    }
    @media screen and (max-width: 767px){
        .heading{
            display: none;
        }
    }
</style>
</style>
<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Subscription</h2>
    <a href="{{ route('subscriptions.history') }}" class="btn btn-primary">
      <i class="bi bi-clock-history me-1"></i> History
    </a>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  <div class="container py-3">
        <div class="row g-4 justify-content-center">
            @foreach($packages as $package)
                <div class="col-md-4">
                    <div class="card h-100 package-card border-0 shadow-sm">
                        <div class="card-body p-4">
                            @if($package->is_featured)
                                <span class="badge bg-success popular-badge">Most Popular</span>
                            @endif
                            <div class="d-flex align-items-center mb-4">
                                <h3 class="card-title h4 mb-0">{{ $package->title }}</h3>
                            </div>
                            <p class="card-text text-muted mb-4">{{ $package->description }}</p>
                            <div class="mb-4">
                                <h4 class="display-6 mb-0">
                                @if($package->price == 0)
                                    Free
                                @else
                                    ${{ number_format($package->price, 2) }}
                                @endif
                                   
                                </h4>
                                <small class="text-muted">Duration: {{ $package->duration }} {{ Str::plural('Days', $package->duration) }}</small>
                            </div>
                            <ul class="list-unstyled mb-4">
                                @php
                                    $features = json_decode($package->features);
                                    if (json_last_error() !== JSON_ERROR_NONE || !$features) {
                                        $features = [];
                                    }
                                @endphp

                                @foreach($features as $feature)
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>{{ $feature }}</li>
                                @endforeach

                                @if(empty($features))
                                    <li class="mb-2"><i class="fas fa-info-circle text-muted me-2"></i>No features listed</li>
                                @endif
                            </ul>

                            <a href="{{ route('stripe.payment', $package->id) }}" class="card shadow-sm border-0 text-decoration-none">
                                <button class="btn btn-primary w-100">
                                    {{ $package->id == 3 ? 'Select Package' : 'Select Package' }}
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
</div>
@endsection
