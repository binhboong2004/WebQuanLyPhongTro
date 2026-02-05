<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Issue;
use App\Models\AdminResponse;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    // List all issues
    public function index()
    {
        $issues = Issue::with('user')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.pages.danhsachphanhoi', compact('issues'));
    }

    // View single issue and reply form
    public function show($id)
    {
        $issue = Issue::with('user', 'responses.admin')->findOrFail($id);
        return view('admin.pages.traloiphanhoi', compact('issue'));
    }

    // Store admin response
    public function storeResponse(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $issue = Issue::findOrFail($id);

        AdminResponse::create([
            'issue_id' => $issue->id,
            'admin_id' => auth()->id(),
            'content' => $request->input('content'),
        ]);

        return redirect()->route('issues.show', $issue->id)->with('success', 'Đã gửi phản hồi thành công.');
    }

    // Update issue status
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:open,resolved,closed',
        ]);

        $issue = Issue::findOrFail($id);
        $issue->update([
            'status' => $request->input('status'),
        ]);

        return redirect()->route('issues.show', $issue->id)->with('success', 'Đã cập nhật trạng thái thành công.');
    }
}
