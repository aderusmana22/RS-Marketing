<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view permission', ['only' => ['index']]);
        $this->middleware('permission:create permission', ['only' => ['create','store']]);
        $this->middleware('permission:update permission', ['only' => ['update','edit']]);
        $this->middleware('permission:delete permission', ['only' => ['destroy']]);
    }

    public function index()
    {
        $permissions = Permission::get();

        // Dialog Sweet Alert
        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view('page.master.permissions.index', ['permissions' => $permissions]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:permissions,name'
            ]
        ]);

        Permission::create([
            'name' => $request->name
        ]);
        Alert::toast('Successfully Create Permission', 'success');
        return redirect()->route('permissions.index');
    }


    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:permissions,name,'.$permission->id
            ]
        ]);

        $permission->update([
            'name' => $request->name
        ]);
        Alert::toast('Successfully Update Permission', 'success');
        return redirect()->route('permissions.index');
    }

    public function destroy($permissionId)
    {
        $permission = Permission::find($permissionId);
        $permission->delete();
        Alert::toast('Successfully Delete Permission', 'success');
        return redirect()->route('permissions.index');
    }

    // ==============================================================Notification===========================================================
    public function markAsRead(Request $request)
    {
        $notificationId = $request->input('notification_id');
        $currentUser = Auth::user();

        if ($notificationId) {
            // Tandai satu notifikasi sebagai dibaca
            $notification = $currentUser->notifications()->find($notificationId);
            if ($notification) {
                $notification->markAsRead();
                $notification->update(['read_at' => now()]);
                return response()->json(['success' => true, 'message' => 'Notification marked as read.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Notification not found.'], 404);
            }
        } else {
            // Tandai semua notifikasi sebagai dibaca
            $currentUser->unreadNotifications->markAsRead();
            $currentUser->unreadNotifications()->update(['read_at' => now()]);
            return response()->json(['success' => true, 'message' => 'All notifications marked as read.']);
        }
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    }

    public function clearAll()
    {
        try {
            DB::table('notifications')->truncate(); // Hapus semua notifikasi
            return response()->json(['message' => 'All notifications deleted successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete notifications.'], 500);
        }
    }
}
