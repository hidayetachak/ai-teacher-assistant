@extends('layouts.schoolDashboard')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('dashboard-content')
<!-- Stats Cards -->
<div class="row">
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="dashboard-card">
            <div class="card-icon primary">
                <i class="fas fa-brain text-danger"></i>
            </div>
            <p class="card-title">Resources</p>
            <h3 class="card-value">{{ $resourceCount }}</h3>
            <div class="d-flex justify-content-between align-items-center">
                @if($resourcePercentChange > 0)
                    <span class="text-success"><i class="fas fa-arrow-up"></i> {{ $resourcePercentChange }}% this week</span>
                @elseif($resourcePercentChange < 0)
                    <span class="text-danger"><i class="fas fa-arrow-down"></i> {{ abs($resourcePercentChange) }}% this week</span>
                @else
                    <span class="text-muted"><i class="fas fa-minus"></i> 0% this week</span>
                @endif
                <a href="{{ route('content.resource') }}" class="text-primary">View All</a>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="dashboard-card">
            <div class="card-icon primary">
                <i class="fas fa-book-open"></i>
            </div>
            <p class="card-title">Lesson Plans</p>
            <h3 class="card-value">{{ $lessonsCount }}</h3>
            <div class="d-flex justify-content-between align-items-center">
                @if($lessonsPercentChange > 0)
                    <span class="text-success"><i class="fas fa-arrow-up"></i> {{ $lessonsPercentChange }}% this week</span>
                @elseif($lessonsPercentChange < 0)
                    <span class="text-danger"><i class="fas fa-arrow-down"></i> {{ abs($lessonsPercentChange) }}% this week</span>
                @else
                    <span class="text-muted"><i class="fas fa-minus"></i> 0% this week</span>
                @endif
                <a href="{{ route('content.lesson-plan') }}" class="text-primary">View All</a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="dashboard-card">
            <div class="card-icon success">
                <i class="fas fa-question-circle"></i>
            </div>
            <p class="card-title">Quizzes</p>
            <h3 class="card-value">{{ $quizzesCount }}</h3>
            <div class="d-flex justify-content-between align-items-center">
                @if($quizzesPercentChange > 0)
                    <span class="text-success"><i class="fas fa-arrow-up"></i> {{ $quizzesPercentChange }}% this week</span>
                @elseif($quizzesPercentChange < 0)
                    <span class="text-danger"><i class="fas fa-arrow-down"></i> {{ abs($quizzesPercentChange) }}% this week</span>
                @else
                    <span class="text-muted"><i class="fas fa-minus"></i> 0% this week</span>
                @endif
                <a href="{{ route('content.quiz') }}" class="text-primary">View All</a>
            </div>
        </div>
    </div>

    
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="dashboard-card">
            <div class="card-icon info">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <p class="card-title">Assignments</p>
            <h3 class="card-value">{{ $assignmentCount }}</h3>
            <div class="d-flex justify-content-between align-items-center">
                @if($assignmentsPercentChange > 0)
                    <span class="text-success"><i class="fas fa-arrow-up"></i> {{ $assignmentsPercentChange }}% this week</span>
                @elseif($assignmentsPercentChange < 0)
                    <span class="text-danger"><i class="fas fa-arrow-down"></i> {{ abs($assignmentsPercentChange) }}% this week</span>
                @else
                    <span class="text-muted"><i class="fas fa-minus"></i> 0% this week</span>
                @endif
                <a href="{{ route('content.assignment') }}" class="text-primary">View All</a>
            </div>
        </div>
    </div>
        
</div>
<div class="row">
    <!-- Quick Actions (Half Width) -->
    <div class="col-lg-9 col-md-12 mb-4 d-flex">
        <div class="dashboard-card mb-4 w-100 h-100">
            <h5 class="mb-4">Quick Actions</h5>
            <div class="quick-actions">
                <a href="{{ route('content.create.assignment') }}" class="quick-action-btn">
                    <i class="fas fa-brain text-danger"></i>
                    <span>Resource Generator</span>
                </a>
                <a href="{{ route('content.create.lesson-plan') }}" class="quick-action-btn">
                    <i class="fas fa-book-open text-primary"></i>
                    <span>Create Lesson Plan</span>
                </a>
                <a href="{{ route('content.create.quiz') }}" class="quick-action-btn">
                    <i class="fas fa-question-circle text-success"></i>
                    <span>Create Quiz</span>
                </a>
                <a href="{{ route('content.create.assignment') }}" class="quick-action-btn">
                    <i class="fas fa-clipboard-check text-info"></i>
                    <span>Create Assignment</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Credits (Half Width) -->
    <div class="col-lg-3 col-md-12 mb-4 d-flex">
        <div class="dashboard-card w-100 h-100">
            <div class="card-icon text-white" style="background-color:rgb(237, 160, 160);">
                <i class="fas fa-coins"></i>
            </div>
            <p class="card-title">Credits</p>
            <h3 class="card-value">{{ $subscriptionStatus }}</h3>
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted">Current Plan</span>
                <a href="#" class="text-primary">Upgrade</a>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row">
    <!-- Content Creation Activity -->
    <div class="col-lg-8 mb-4">
        <div class="dashboard-card">
            <h5 class="mb-4">Content Creation Activity</h5>
            <div class="chart-container">
                <canvas id="contentActivityChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Content Distribution -->
    <div class="col-lg-4 mb-4">
        <div class="dashboard-card">
            <h5 class="mb-4">Content Distribution</h5>
            <div class="chart-container">
                <canvas id="contentDistributionChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity Table -->
<div class="dashboard-card mb-4">
    <h5 class="mb-4">Recent Activity</h5>
    <div class="table-responsive">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Content</th>
                    <th>Type</th>
                    <th>Date Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentActivities as $activity)
                <tr>
                    <td>{{ $activity['title'] }}</td>
                    <td>{{ $activity['type'] }}</td>
                    <td>{{ $activity['date'] }}</td>
                   
                    <td>
                        <a href="#" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-secondary"><i class="fas fa-download"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
// Content Activity Chart
var activityCtx = document.getElementById('contentActivityChart').getContext('2d');
var activityChart = new Chart(activityCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($monthlyData['months']) !!},
        datasets: [
            {
                label: 'Lesson Plans',
                data: {!! json_encode($monthlyData['lessonData']) !!},
                borderColor: '#4361ee',
                backgroundColor: 'rgba(67, 97, 238, 0.1)',
                tension: 0.4,
                fill: true
            },
            {
                label: 'Quizzes',
                data: {!! json_encode($monthlyData['quizData']) !!},
                borderColor: '#4cc9f0',
                backgroundColor: 'rgba(76, 201, 240, 0.1)',
                tension: 0.4,
                fill: true
            },
            {
                label: 'Resources',
                data: {!! json_encode($monthlyData['resourceData']) !!},
                borderColor: '#3cb371',
                backgroundColor: 'rgba(60, 179, 113, 0.1)',
                tension: 0.4,
                fill: true
            },
            {
                label: 'Assignments',
                data: {!! json_encode($monthlyData['assignmentData']) !!},
                borderColor: '#f72585',
                backgroundColor: 'rgba(247, 37, 133, 0.1)',
                tension: 0.4,
                fill: true
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
            },
            tooltip: {
                mode: 'index',
                intersect: false,
                backgroundColor: 'rgba(0, 0, 0, 0.7)',
                titleColor: '#fff',
                bodyColor: '#fff',
                borderColor: '#fff',
                borderWidth: 1
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0, 0, 0, 0.05)'
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});

// Content Distribution Chart
var distributionCtx = document.getElementById('contentDistributionChart').getContext('2d');
var distributionChart = new Chart(distributionCtx, {
    type: 'doughnut',
    data: {
        labels: ['Lesson Plans', 'Quizzes', 'Assignments', 'Resources'],
        datasets: [{
            data: [
                {{ $contentDistribution['lessonCount'] }},
                {{ $contentDistribution['quizCount'] }},
                {{ $contentDistribution['assignmentCount'] }},
                {{ $contentDistribution['resourceCount'] }},
            ],
            backgroundColor: [
                '#4361ee',
                '#4cc9f0',
                '#f72585',
                '#3cb371'
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.7)',
                titleColor: '#fff',
                bodyColor: '#fff',
                borderColor: '#fff',
                borderWidth: 1
            }
        },
        cutout: '70%'
    }
});
</script>
@endsection
