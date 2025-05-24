<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Follow;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
        // Follow a member
        public function follow(Request $request,$id_follow)
        {
            $member = Auth::guard('member')->user(); // Get the authenticated user or member

            if ($member->id_member == $id_follow) {
                return back()->with('error', 'คุณไม่สามารถติดตามตัวเองได้');
            }

            // Check if the user is already following this member
            if (!$member->isFollowing($id_follow)) {
                Follow::create([
                    'id_member' => $member->id_member,    // Authenticated user's ID
                    'id_follow' => $id_follow, // ID of the member to be followed
                ]);
            }

            return back()->with('success', 'You are now following this member!');
        }

        // Unfollow a member
        public function unfollow(Request $request,$id_follow)
        {
            $member = Auth::guard('member')->user(); // Get the authenticated user or member

            // หาข้อมูลการติดตามแล้วลบ
            $follow = Follow::where('id_member', $member->id_member)
                            ->where('id_follow', $id_follow)
                            ->first();

            if ($follow) {
                $follow->delete();
                return back()->with('success', 'คุณได้ยกเลิกการติดตามสมาชิกนี้แล้ว!');
            }

            return back()->with('error', 'คุณไม่ได้ติดตามสมาชิกนี้!');
        }
}

