<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FutureMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class FutureController extends Controller
{
    /**
     * Display the future messages list
     */
    public function index()
    {
        // Get user's future messages if authenticated
        if (Auth::check()) {
            $messages = FutureMessage::where('created_by', Auth::id())
                ->orderBy('scheduled_at', 'desc')
                ->paginate(10);
        } else {
            $messages = collect();
        }

        return view('future.index', compact('messages'));
    }



    /**
     * Show the form for creating a new future message
     */
    public function create()
    {
        return view('future.create');
    }

    /**
     * Store a newly created future message
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|string|min:10',
            'email'   => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        try {
            $futureMessage = FutureMessage::create([
                'email'   => $request->email,
                'message' => $request->message,
            ]);

            // if you have a show page
            return redirect()->route('future.create')->with('success', 'تم حفظ رسالتك للمستقبل بنجاح! ستصلك في الموعد المحدد.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ في حفظ الرسالة. يرجى المحاولة مرة أخرى.')
                ->withInput();
        }
    }



    /**
     * Search messages by email (for guests)
     */
    public function searchByEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $messages = FutureMessage::where('email', $request->email)
            ->orderBy('scheduled_at', 'desc')
            ->paginate(10);

        return view('future.index', compact('messages'));
    }

    /**
     * Send scheduled messages (called by cron job)
     */
    public function sendScheduledMessages()
    {
        $messages = FutureMessage::where('status', 'scheduled')
            ->where('scheduled_at', '<=', now())
            ->where('send_email', true)
            ->get();

        $sentCount = 0;

        foreach ($messages as $message) {
            try {
                // Send email
                Mail::send('emails.future-message', compact('message'), function($mail) use ($message) {
                    $mail->to($message->email, $message->recipient_name)
                        ->subject('رسالة من الماضي: ' . $message->title);
                });

                // Update message status
                $message->update([
                    'status' => 'sent',
                    'published_at' => now()
                ]);

                $sentCount++;
            } catch (\Exception $e) {
                // Log error but continue with other messages
                \Log::error('Failed to send future message: ' . $e->getMessage(), [
                    'message_id' => $message->id
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'sent_count' => $sentCount
        ]);
    }

    /**
     * Get message statistics
     */
    public function getStats()
    {
        $stats = [
            'total' => FutureMessage::count(),
            'scheduled' => FutureMessage::where('status', 'scheduled')->count(),
            'sent' => FutureMessage::where('status', 'sent')->count(),
            'public' => FutureMessage::where('is_public', true)->count(),
            'this_month' => FutureMessage::whereMonth('created_at', now()->month)->count(),
            'upcoming' => FutureMessage::where('status', 'scheduled')
                ->where('scheduled_at', '>', now())
                ->count()
        ];

        return response()->json($stats);
    }

    /**
     * Delete a future message (soft delete)
     */
    public function destroy($id)
    {
        $message = FutureMessage::findOrFail($id);

        // Check permissions
        if (Auth::id() !== $message->created_by) {
            abort(403, 'غير مصرح لك بحذف هذه الرسالة');
        }

        $message->delete();

        return redirect()->route('future.index')
            ->with('success', 'تم حذف الرسالة بنجاح');
    }

    /**
     * Update message before it's sent
     */
    public function update(Request $request, $id)
    {
        $message = FutureMessage::findOrFail($id);

        // Check permissions and status
        if (Auth::id() !== $message->created_by || $message->status !== 'scheduled') {
            abort(403, 'لا يمكن تعديل هذه الرسالة');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:10',
            'scheduled_date' => 'required|date|after:today',
            'scheduled_time' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $scheduledDateTime = Carbon::createFromFormat(
                'Y-m-d H:i',
                $request->scheduled_date . ' ' . $request->scheduled_time
            );

            $message->update([
                'title' => $request->title,
                'content' => $request->content,
                'scheduled_at' => $scheduledDateTime,
                'is_public' => $request->has('is_public')
            ]);

            return redirect()->route('future.view', $message->id)
                ->with('success', 'تم تحديث الرسالة بنجاح');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ في تحديث الرسالة')
                ->withInput();
        }
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $message = FutureMessage::findOrFail($id);

        if (Auth::id() !== $message->created_by || $message->status !== 'scheduled') {
            abort(403, 'لا يمكن تعديل هذه الرسالة');
        }

        return view('future.edit', compact('message'));
    }

    /**
     * Get messages scheduled for today
     */
    public function getTodaysMessages()
    {
        $messages = FutureMessage::whereDate('scheduled_at', today())
            ->where('status', 'scheduled')
            ->orderBy('scheduled_at')
            ->get();

        return response()->json($messages);
    }

    /**
     * Preview message before saving
     */
    public function preview(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'recipient_name' => 'nullable|string|max:255'
        ]);

        return view('future.preview', $data);
    }
}
