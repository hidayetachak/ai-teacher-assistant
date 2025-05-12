<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20mm;
            color: #333;
        }
        h1, h2, h3, h4 {
            color: #2c3e50;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 10px;
        }
        .meta {
            background-color: #f5f6fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .meta p {
            margin: 5px 0;
        }
        .content-body {
            margin-top: 20px;
        }
        .content-body h3 {
            margin-top: 20px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        .content-body ul {
            padding-left: 20px;
        }
        .content-body li {
            margin-bottom: 10px;
        }
        .question {
            margin-bottom: 20px;
        }
        .footer {
            text-align: center;
            font-size: 10px;
            color: #7f8c8d;
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
    </div>

    <div class="meta">
        <p><strong>Topic:</strong> {{ $content->topic }}</p>
        <p><strong>Grade Level:</strong> {{ $content->grade_level }}</p>
        @if($content->duration)
            <p><strong>Duration:</strong> {{ $content->duration }} minutes</p>
        @endif
        @if($content->tags)
            <p><strong>Tags:</strong> {{ is_array($content->tags) ? implode(', ', $content->tags) : $content->tags }}</p>
        @endif
        <p><strong>Generated:</strong> {{ $timestamp }}</p>
    </div>

    <div class="content-body">
        @php
            $data = json_decode($content->data, true);
        @endphp

        @if($content->type === 'lesson_plan' && isset($data['title']))
            <h2>{{ $data['title'] }}</h2>
            <h3>Objectives</h3>
            <ul>
                @foreach($data['objectives'] as $objective)
                    <li>{{ $objective }}</li>
                @endforeach
            </ul>
            <h3>Materials</h3>
            <ul>
                @foreach($data['materials'] as $material)
                    <li>{{ $material }}</li>
                @endforeach
            </ul>
            <h3>Activities</h3>
            @foreach($data['activities'] as $activity)
                <div class="activity">
                    <strong>Step {{ $activity['step'] }} ({{ $activity['duration'] }})</strong>
                    <p>{{ $activity['description'] }}</p>
                </div>
            @endforeach
            <h3>Assessments</h3>
            <ul>
                @foreach($data['assessments'] as $assessment)
                    <li>{{ $assessment }}</li>
                @endforeach
            </ul>
        @elseif(in_array($content->type, ['quiz', 'assignment']) && isset($data['title']))
            <h2>{{ $data['title'] }}</h2>
            @foreach($data['questions'] as $question)
                <div class="question">
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
            @elseif($content->type === 'resource' && isset($content->data['worksheets']))
        <h2>Resource Kit: {{ $content->topic }}</h2>
        <h3>Worksheets</h3>
        @foreach($content->data['worksheets'] as $worksheet)
            <h4>{{ ucfirst($worksheet['type']) }}</h4>
            @if($worksheet['type'] === 'multiple choice')
                @foreach($worksheet['questions'] as $question)
                    <p><strong>Question:</strong> {{ $question['question'] }}</p>
                    <ul>
                        @foreach($question['options'] as $option)
                            <li>{{ $option }}</li>
                        @endforeach
                    </ul>
                    <p><strong>Answer:</strong> {{ $question['answer'] }}</p>
                @endforeach
            @elseif($worksheet['type'] === 'fill in the blanks')
                @foreach($worksheet['questions'] as $index => $question)
                    <p><strong>Question:</strong> {{ $question }}</p>
                    <p><strong>Answer:</strong> {{ $worksheet['answers'][$index] }}</p>
                @endforeach
            @endif
        @endforeach
        <h3>Flashcards</h3>
        <ul>
            @foreach($content->data['flashcards'] as $flashcard)
                <li><strong>{{ $flashcard['term'] }}:</strong> {{ $flashcard['definition'] }}</li>
            @endforeach
        </ul>
        <h3>Summary</h3>
        <p>{{ $content->data['summary'] }}</p>
        
    @else
            <p>Error: Content format not recognized.</p>
        @endif
    </div>

    <div class="footer">
        <p>Generated on {{ $timestamp }}</p>
    </div>
</body>
</html>