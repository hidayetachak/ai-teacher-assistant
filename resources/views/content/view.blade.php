@extends('layouts.dashboard')

@section('title', 'Teacher Dashboard')

@section('page-title', 'Teacher Dashboard')
@section('dashboard-content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>{{ $content->topic }}</h2>
        <div>
            <a href="{{ route('content.download', $content->id) }}" class="btn btn-success">
                <i class="bi bi-download me-1"></i> Download PDF
            </a>
            <a href="{{ url()->previous() }}" class="btn btn-secondary ms-2">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-light">
            <div class="row">
                <div class="col-md-4">
                    <strong>Grade Level:</strong> {{ $content->grade_level }}
                </div>
                <div class="col-md-4">
                    <strong>Type:</strong> {{ ucfirst($content->type) }}
                </div>
                <div class="col-md-4">
                    <strong>Date Created:</strong> {{ $content->created_at->format('Y-m-d') }}
                </div>
            </div>
            @if($content->duration)
                <div class="row mt-2">
                    <div class="col-md-4">
                        <strong>Duration:</strong> {{ $content->duration }} minutes
                    </div>
                </div>
            @endif
            @if($content->tags)
                <div class="mt-2">
                    <strong>Tags:</strong>
                    @foreach(is_array($content->tags) ? $content->tags : [$content->tags] as $tag)
                        <span class="badge bg-info text-dark me-1">{{ $tag }}</span>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="card-body">
            @php
                $data = json_decode($content->data, true);
            @endphp

            @if($content->type === 'lesson_plan' && isset($data['title']))
                <h3>{{ $data['title'] }}</h3>
                <h4>Objectives</h4>
                <ul>
                    @foreach($data['objectives'] as $objective)
                        <li>{{ $objective }}</li>
                    @endforeach
                </ul>
                <h4>Materials</h4>
                <ul>
                    @foreach($data['materials'] as $material)
                        <li>{{ $material }}</li>
                    @endforeach
                </ul>
                <h4>Activities</h4>
                @foreach($data['activities'] as $activity)
                    <div class="mb-3">
                        <strong>Step {{ $activity['step'] }} ({{ $activity['duration'] }})</strong>
                        <p>{{ $activity['description'] }}</p>
                    </div>
                @endforeach
                <h4>Assessments</h4>
                <ul>
                    @foreach($data['assessments'] as $assessment)
                        <li>{{ $assessment }}</li>
                    @endforeach
                </ul>
            @elseif(in_array($content->type, ['quiz', 'assignment']) && isset($data['title']))
                <h3>{{ $data['title'] }}</h3>
                @foreach($data['questions'] as $question)
                    <div class="mb-4">
                        <strong>Question {{ $question['number'] }}</strong>
                        <p>{{ $question['question'] }}</p>
                        @if(isset($question['options']))
                            <ul>
                                @foreach($question['options'] as $option)
                                    <li>{{ $option }}</li>
                                @endforeach
                            </ul>
                        @endif
                        @if(isset($question['instructions']))
                            <p><strong>Instructions:</strong> {{ $question['instructions'] }}</p>
                        @endif
                        <p><strong>Answer:</strong> {{ $question['answer'] }}</p>
                    </div>
                @endforeach
                @elseif($content->type === 'resource' && isset($data['worksheets']))
                <h3>Resource Kit: {{ $content->topic }}</h3>
                
                <h4>Worksheets</h4>
                @foreach($data['worksheets'] as $worksheet)
                    <div class="mb-4">
                        <h5>{{ ucfirst($worksheet['type']) }}</h5>
                        @if($worksheet['type'] === 'multiple choice')
                            @foreach($worksheet['questions'] as $question)
                                <div class="mb-3">
                                    <p><strong>Question:</strong> {{ $question['question'] }}</p>
                                    <ul>
                                        @foreach($question['options'] as $option)
                                            <li>{{ $option }}</li>
                                        @endforeach
                                    </ul>
                                    <p><strong>Answer:</strong> {{ $question['answer'] }}</p>
                                </div>
                            @endforeach
                        @elseif($worksheet['type'] === 'fill in the blanks')
                            @foreach($worksheet['questions'] as $index => $question)
                                <div class="mb-3">
                                    <p><strong>Question:</strong> {{ $question }}</p>
                                    <p><strong>Answer:</strong> {{ $worksheet['answers'][$index] }}</p>
                                </div>
                            @endforeach
                        @endif
                    </div>
                @endforeach

                <h4>Flashcards</h4>
                <ul>
                    @foreach($data['flashcards'] as $flashcard)
                        <li><strong>{{ $flashcard['term'] }}:</strong> {{ $flashcard['definition'] }}</li>
                    @endforeach
                </ul>

                <h4>Summary</h4>
                <p>{{ $data['summary'] }}</p>

                <h4>Question Bank</h4>
                <h5>Recall</h5>
                <ul>
                    @foreach($data['question_bank']['recall'] as $question)
                        <li>{{ $question }}</li>
                    @endforeach
                </ul>
                <h5>Apply</h5>
                <ul>
                    @foreach($data['question_bank']['apply'] as $question)
                        <li>{{ $question }}</li>
                    @endforeach
                </ul>
                <h5>Analyze</h5>
                <ul>
                    @foreach($data['question_bank']['analyze'] as $question)
                        <li>{{ $question }}</li>
                    @endforeach
                </ul>

                <h4>Study Guide</h4>
                <ul>
                    @foreach($data['study_guide'] as $point)
                        <li>{{ $point }}</li>
                    @endforeach
                </ul>
            @else
                <p>Error: Content format not recognized.</p>
            @endif
        </div>
    </div>
</div>
@endsection