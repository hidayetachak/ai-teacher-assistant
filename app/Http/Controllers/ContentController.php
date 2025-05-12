<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonPlanRequest;
use App\Http\Requests\QuizRequest;
use App\Http\Requests\ResourceRequest;
use App\Models\Content;
use App\Models\User;
use App\Models\Usage;
use App\Models\CreditTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class ContentController extends Controller
{
    public function resourceKit(ResourceRequest $request)
    {
        $authUser = auth()->user();
    
        // Handle credit validation and deduction
        if ($authUser->role === 'teacher') {
            $school = User::where('id', $authUser->school_id)
                        ->where('role', 'school')
                        ->first();
    
            if (!$school) {
                return back()->with('error', 'Associated school account not found.');
            }
    
            if ($school->credits < 1) {
                return back()->with('error', 'Your school account does not have enough credits.');
            }
    
            $school->decrement('credits', 1);
    
            CreditTransaction::create([
                'user_id' => $school->id,
                'performed_by' => $authUser->id,
                'amount' => 1,
                'type' => 'debit',
                'reason' => 'Resource kit generated'
            ]);
        } elseif ($authUser->role === 'school') {
            if ($authUser->credits < 1) {
                return back()->with('error', 'You do not have enough credits.');
            }
    
            $authUser->decrement('credits', 1);
    
            CreditTransaction::create([
                'user_id' => $authUser->id,
                'performed_by' => $authUser->id,
                'amount' => 1,
                'type' => 'debit',
                'reason' => 'Resource kit generation'
            ]);
        }
    
        $data = $request->validated();
        $topic = $data['topic'];
        $grade_level = $data['grade_level'] ?? 'unspecified';
    
        $prompt = <<<EOT
    You are an expert in educational content creation. Generate a teacher resource kit in JSON format for the topic: "$topic", grade level: "$grade_level". 
    
    Return a valid, parseable JSON object with NO additional text or explanation. The JSON should be in the following exact structure:
    
    {
      "worksheets": [
        {
          "type": "multiple choice",
          "questions": [
            {
              "question": "...",
              "options": ["A", "B", "C", "D"],
              "answer": "..."
            }
          ]
        },
        {
          "type": "fill in the blanks",
          "questions": ["...", "..."],
          "answers": ["...", "..."]
        }
      ],
      "flashcards": [
        {"term": "...", "definition": "..."},
        {"term": "...", "definition": "..."}
      ],
      "summary": "...",
      "question_bank": {
        "recall": ["Question 1", "Question 2"],
        "apply": ["Question 1", "Question 2"],
        "analyze": ["Question 1", "Question 2"]
      },
      "study_guide": [
        "Key point 1",
        "Key point 2",
        "Tip or explanation..."
      ]
    }
    
    Important: Do not include code blocks, backticks, or any other formatting. Return only the raw JSON object.
    EOT;
    
        $resourceKit = $this->callLlamaApi($prompt);
    
        $view = $authUser->role === 'school'
            ? 'school.content.view'
            : 'content.view';
    
        return $this->saveAndReturnContent(
            $resourceKit,
            'resource',
            $data,
            $view
        );
    }

    public function lessonPlan(LessonPlanRequest $request)
    {
            $authUser = auth()->user();

           
            if ($authUser->role === 'teacher') {
                $school = User::where('id', $authUser->school_id)->where('role', 'school')->first();

                if (!$school) {
                    return back()->with('error', 'Associated school account not found.');
                }

                if ($school->credits < 1) {
                    return back()->with('error', 'Your school account does not have enough credits.');
                }

                $school->decrement('credits', 1);

                // Optional: log the credit usage
                CreditTransaction::create([
                    'user_id' => $school->id, 
                    'performed_by' => $authUser->id, 
                    'amount' => 1,
                    'type' => 'debit',
                    'reason' => 'Lesson plan generated'
                ]);
            } elseif ($authUser->role === 'school') {
                // Normal school account flow
                if ($authUser->credits < 1) {
                    return back()->with('error', 'You do not have enough credits.');
                }

                $authUser->decrement('credits', 1);

                CreditTransaction::create([
                    'user_id' => $authUser->id,
                    'performed_by' => $authUser->id,
                    'amount' => 1,
                    'type' => 'debit',
                    'reason' => 'Lesson plan generation'
                ]);
            }

        $data = $request->validated();
        $prompt = "Generate a lesson plan in JSON format for topic: {$data['topic']}, grade level: {$data['grade_level']}, duration: {$data['duration']} minutes. Structure the response as follows:
        ```json
        {
            \"title\": \"Lesson Plan: [Topic]\",
            \"objectives\": [\"Objective 1\", \"Objective 2\", ...],
            \"materials\": [\"Material 1\", \"Material 2\", ...],
            \"activities\": [
                {\"step\": 1, \"description\": \"Description\", \"duration\": \"X minutes\"},
                ...
            ],
            \"assessments\": [\"Assessment 1\", \"Assessment 2\", ...]
        }
        ```";

        $lessonPlan = $this->callLlamaApi($prompt);
        $view = auth()->user()->role === 'school' 
        ? 'school.content.view' 
        : 'content.view';
        return $this->saveAndReturnContent(
            $lessonPlan,
            'lesson_plan',
            $data,
            $view
        );
    }

    public function quiz(QuizRequest $request)
    {
        $authUser = auth()->user();

           
        if ($authUser->role === 'teacher') {
            $school = User::where('id', $authUser->school_id)->where('role', 'school')->first();

            if (!$school) {
                return back()->with('error', 'Associated school account not found.');
            }

            if ($school->credits < 1) {
                return back()->with('error', 'Your school account does not have enough credits.');
            }

            $school->decrement('credits', 1);

            // Optional: log the credit usage
            CreditTransaction::create([
                'user_id' => $school->id, 
                'performed_by' => $authUser->id, 
                'amount' => 1,
                'type' => 'debit',
                'reason' => 'Quiz generated' 
            ]);
        } elseif ($authUser->role === 'school') {
            // Normal school account flow
            if ($authUser->credits < 1) {
                return back()->with('error', 'You do not have enough credits.');
            }

            $authUser->decrement('credits', 1);

            CreditTransaction::create([
                'user_id' => $authUser->id,
                'performed_by' => $authUser->id,
                'amount' => 1,
                'type' => 'debit',
                'reason' => 'Quiz generation'
            ]);
        }
        $data = $request->validated();
        $prompt = "Generate a quiz in JSON format for topic: {$data['topic']}, grade level: {$data['grade_level']}, with {$data['num_questions']} {$data['question_type']} questions. Structure the response as follows:
        ```json
        {
            \"title\": \"Quiz: [Topic]\",
            \"questions\": [
                {
                    \"number\": 1,
                    \"question\": \"Question text\",
                    \"options\": [\"Option 1\", \"Option 2\", ...] (if applicable),
                    \"answer\": \"Correct answer\"
                },
                ...
            ]
        }
        ```";

        $quiz = $this->callLlamaApi($prompt);
        $view = auth()->user()->role === 'school' 
        ? 'school.content.view' 
        : 'content.view';
        return $this->saveAndReturnContent(
            $quiz,
            'quiz',
            $data,
            $view
        );
    }

    public function assignment(QuizRequest $request)
    {$authUser = auth()->user();

           
        if ($authUser->role === 'teacher') {
            $school = User::where('id', $authUser->school_id)->where('role', 'school')->first();

            if (!$school) {
                return back()->with('error', 'Associated school account not found.');
            }

            if ($school->credits < 1) {
                return back()->with('error', 'Your school account does not have enough credits.');
            }

            $school->decrement('credits', 1);

            // Optional: log the credit usage
            CreditTransaction::create([
                'user_id' => $school->id, 
                'performed_by' => $authUser->id, 
                'amount' => 1,
                'type' => 'debit',
                'reason' => 'Assignment generated' 
            ]);
        } elseif ($authUser->role === 'school') {
            // Normal school account flow
            if ($authUser->credits < 1) {
                return back()->with('error', 'You do not have enough credits.');
            }

            $authUser->decrement('credits', 1);

            CreditTransaction::create([
                'user_id' => $authUser->id,
                'performed_by' => $authUser->id,
                'amount' => 1,
                'type' => 'debit',
                'reason' => 'Assignment generation'
            ]);
        }
        $data = $request->validated();
        $prompt = "Generate an assignment in JSON format for topic: {$data['topic']}, grade level: {$data['grade_level']}, with {$data['num_questions']} {$data['question_type']} questions. Structure the response as follows:
        ```json
        {
            \"title\": \"Assignment: [Topic]\",
            \"questions\": [
                {
                    \"number\": 1,
                    \"question\": \"Question text\",
                    \"instructions\": \"Instruction text\",
                    \"answer\": \"Expected answer\"
                },
                ...
            ]
        }
        ```";

        $assignment = $this->callLlamaApi($prompt);
        $view = auth()->user()->role === 'school' 
        ? 'school.content.view' 
        : 'content.view';
        return $this->saveAndReturnContent(
            $assignment,
            'assignment',
            $data,
            $view
        );
    }

        public function download(Request $request, Content $content)
    {
        $authUser = auth()->user();

        // Allow if the authenticated user is the content owner
        if ($content->user_id == $authUser->id) {
            return $this->generatePdf($content);
        }

        // Allow if the user is a school and the content belongs to one of its teachers
        if ($authUser->role === 'school') {
            $creator = User::find($content->user_id);

            if ($creator && $creator->school_id == $authUser->id) {
                return $this->generatePdf($content);
            }
        }

        abort(403, 'Unauthorized action.');
    }
    

    private function generatePdf(Content $content)
    {
        $data = [
            'content' => $content,
            'title' => $content->topic,
            'timestamp' => now()->format('Y-m-d H:i:s')
        ];

        $pdf = Pdf::loadView('content.pdf', $data);
        return $pdf->download($content->topic . '.pdf');
    }


    private function callLlamaApi($promptContent, $maxRetries = 3)
{
    for ($attempt = 1; $attempt <= $maxRetries; $attempt++) {
        try {
            $response = Http::withToken(config('services.llama.api_key'))
                ->timeout(60)
                ->post('https://api.llama.com/v1/chat/completions', [
                    'model' => 'Llama-4-Maverick-17B-128E-Instruct-FP8',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'You are a helpful assistant that generates educational content in JSON format as specified.',
                        ],
                        [
                            'role' => 'user',
                            'content' => $promptContent,
                        ],
                    ],
                    'max_tokens' => 2000,
                ]);

            Log::info('Llama API response attempt ' . $attempt, [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            if ($response->successful()) {
                $responseData = $response->json();
                
                if (isset($responseData['completion_message']['content']['text'])) {
                    $text = $responseData['completion_message']['content']['text'];
                    
                    // Find the JSON content using regex - extract everything between { and } including nested braces
                    if (preg_match('/(\{(?:[^{}]|(?R))*\})/s', $text, $matches)) {
                        $jsonContent = $matches[0];
                        
                        // Log the extracted JSON for debugging
                        Log::info('Extracted JSON content', ['content' => $jsonContent]);
                        
                        // Decode the JSON string
                        $decodedContent = json_decode($jsonContent, true);
                        
                        if (json_last_error() === JSON_ERROR_NONE) {
                            return $decodedContent;
                        }
                        
                        Log::warning('JSON decoding failed for attempt ' . $attempt, [
                            'json_error' => json_last_error_msg(),
                            'content' => $jsonContent,
                        ]);
                    } else {
                        Log::warning('Could not extract JSON from response', [
                            'text' => $text
                        ]);
                    }
                }
            }

            Log::warning('Llama API failed attempt ' . $attempt, [
                'status' => $response->status(),
                'response' => $response->body(),
            ]);

            if ($attempt < $maxRetries) {
                usleep(2000 * 1000);
            }
        } catch (\Exception $e) {
            Log::error('Llama API exception attempt ' . $attempt, [
                'error' => $e->getMessage(),
            ]);
            if ($attempt < $maxRetries) {
                usleep(2000 * 1000);
            }
        }
    }

    return ['error' => "Failed to generate content after $maxRetries attempts."];
}

private function saveAndReturnContent($contentData, $type, $data, $view)
{
    // Check if we have an error response
    if (is_array($contentData) && isset($contentData['error'])) {
        return back()->with('error', $contentData['error']);
    }
    
    // Ensure contentData is an array
    if (!is_array($contentData)) {
        Log::error('Content data is not an array', [
            'type' => $type,
            'data' => $contentData
        ]);
        return back()->with('error', 'Invalid content format. Expected an array.');
    }
    
    try {
        // Encode the content data as JSON
        $jsonData = json_encode($contentData, JSON_THROW_ON_ERROR);
        
        $content = Content::create([
            'user_id' => auth()->id(),
            'type' => $type,
            'topic' => $data['topic'] ?? null,
            'grade_level' => $data['grade_level'] ?? null,
            'num_questions' => $data['num_questions'] ?? null,
            'question_type' => $data['question_type'] ?? null,
            'duration' => $data['duration'] ?? null,
            'data' => $jsonData,
            'tags' => $data['tags'] ?? [],
        ]);

        Usage::create([
            'user_id' => auth()->id(),
            'content_id' => $content->id,
            'type' => $type,
        ]);

        return view($view, compact('content'));
    } catch (\Exception $e) {
        Log::error('Error saving content', [
            'message' => $e->getMessage(),
            'type' => $type,
            'data' => $contentData
        ]);
        return back()->with('error', 'Failed to save content: ' . $e->getMessage());
    }
}

    public function view($id)
{
    $content = Content::findOrFail($id);
    $authUser = auth()->user();

    // If the content is owned by the authenticated user
    if ($content->user_id == $authUser->id && $authUser->role=='teacher') {
        return view('content.view', compact('content'));
    }
    if ($content->user_id == $authUser->id) {
        return view('school.content.view', compact('content'));
    }

  
    if ($authUser->role === 'school') {
        $creator = User::find($content->user_id);

        if ($creator && $creator->school_id == $authUser->id) {
            return view('school.content.view', compact('content'));
        }
    }

    abort(403, 'Unauthorized action.');
}


    public function destroy($id)
    {
        $content = Content::findOrFail($id);
        $authUser = auth()->user();

        // If the authenticated user is the content owner
        if ($content->user_id == $authUser->id) {
            $content->delete();
            return redirect()->back()->with('success', 'Content deleted successfully.');
        }

        // If the authenticated user is a school and owns the teacher who created the content
        if ($authUser->role === 'school') {
            $creator = User::find($content->user_id);

            if ($creator && $creator->school_id == $authUser->id) {
                $content->delete();
                return redirect()->back()->with('success', 'Content deleted successfully.');
            }
        }

        abort(403, 'Unauthorized action.');
    }

}