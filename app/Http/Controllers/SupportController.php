<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Support;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SupportController extends Controller
{
    /**
     * Display the support home page
     */
    public function index()
    {
        return view('support.home');
    }

    /**
     * Show the form for creating a new support message
     */
    public function create()
    {
        return view('support.create');
    }

    /**
     * Store a newly created support message in storage
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|min:10',
        ], [
            'name.string' => 'الاسم يجب أن يكون نص',
            'email.email' => 'البريد الإلكتروني غير صالح',
            'phone.string' => 'رقم الهاتف غير صالح',
            'subject.string' => 'الموضوع يجب أن يكون نص',
            'message.required' => 'الرسالة مطلوبة',
            'message.min' => 'الرسالة يجب ألا تقل عن 10 حروف',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $m = Support::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject,
                'message' => $request->message,
                'status' => 'open',
                'user_id' => Auth::id(), // if user is logged in
            ]);

            return redirect()->route('support.create')
                ->with('success', __('app.support_message_sent_successfully'));

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', __('app.error_occurred'))
                ->withInput();
        }
    }


    public function show(Request $request)
    {
        if ($request->ajax()) {
            $count = Support::count();
            $lastMessage = Support::orderBy('id', 'desc')->first();

            return response()->json([
                'count'   => $count,
                'message' => $lastMessage ? trim($lastMessage->message) : null
            ]);
        }

        $supports = Support::take(20)->get();
        return view('support.show', compact('supports'));
    }




    /**
     * Display a specific support message
     */
    public function view($id)
    {
        $support = Support::findOrFail($id);

        // Ensure user can only view their own messages (if not admin)
        if (Auth::id() !== $support->user_id && !Auth::user()?->is_admin) {
            abort(403, 'Unauthorized access');
        }

        return view('support.view', compact('support'));
    }

    /**
     * Search support messages by email (for guests)
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

        $supports = Support::where('email', $request->email)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('support.show', compact('supports'));
    }

    /**
     * Admin methods (if you have admin functionality)
     */

    /**
     * Display all support messages for admin
     */
    public function adminIndex()
    {
        // Check if user is admin
        if (!Auth::user()?->is_admin) {
            abort(403, 'Unauthorized access');
        }

        $supports = Support::with('user')
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('support.admin.index', compact('supports'));
    }

    /**
     * Update support message status (admin only)
     */
    public function updateStatus(Request $request, $id)
    {
        if (!Auth::user()?->is_admin) {
            abort(403, 'Unauthorized access');
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:open,in_progress,resolved,closed'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $support = Support::findOrFail($id);
        $support->update([
            'status' => $request->status,
            'updated_by' => Auth::id()
        ]);

        return redirect()->back()
            ->with('success', __('app.status_updated_successfully'));
    }

    /**
     * Add admin response to support message
     */
    public function addResponse(Request $request, $id)
    {
        if (!Auth::user()?->is_admin) {
            abort(403, 'Unauthorized access');
        }

        $validator = Validator::make($request->all(), [
            'response' => 'required|string|min:10'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $support = Support::findOrFail($id);
        $support->update([
            'admin_response' => $request->response,
            'responded_at' => now(),
            'responded_by' => Auth::id(),
            'status' => 'responded'
        ]);

        // You might want to send an email notification here
        // Mail::to($support->email)->send(new SupportResponseMail($support));

        return redirect()->back()
            ->with('success', __('app.response_added_successfully'));
    }

    /**
     * Delete support message (admin only)
     */
    public function destroy($id)
    {
        if (!Auth::user()?->is_admin) {
            abort(403, 'Unauthorized access');
        }

        $support = Support::findOrFail($id);
        $support->delete();

        return redirect()->back()
            ->with('success', __('app.support_message_deleted'));
    }

    /**
     * Get support statistics (admin dashboard)
     */
    public function getStats()
    {
        if (!Auth::user()?->is_admin) {
            abort(403, 'Unauthorized access');
        }

        $stats = [
            'total' => Support::count(),
            'open' => Support::where('status', 'open')->count(),
            'in_progress' => Support::where('status', 'in_progress')->count(),
            'resolved' => Support::where('status', 'resolved')->count(),
            'urgent' => Support::where('priority', 'urgent')->count(),
        ];

        return response()->json($stats);
    }
}
