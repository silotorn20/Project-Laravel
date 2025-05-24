<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class reviewController extends Controller
{
    public function review(Request $request,$id_book)
    {
        // ตรวจสอบว่าได้รับข้อมูลจากผู้ใช้ที่ล็อกอินอยู่
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'กรุณาล็อกอินก่อนทำการรีวิว');
        }

        $id_member = auth()->guard('member')->user()->id_member;

        Review::create([
            'score_review' => $request->input('score_review'),
            'detail' => $request->input('detail'),
            'date' => now(),
            'id_book' => $id_book,
            'id_member' => $id_member,
        ]);

        return redirect()->back()->with('success', 'รีวิวของคุณถูกบันทึกเรียบร้อยแล้ว!');
    }

    public function reviewMybook(Request $request,$id_book)
    {
        // ตรวจสอบว่าได้รับข้อมูลจากผู้ใช้ที่ล็อกอินอยู่
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'กรุณาล็อกอินก่อนทำการรีวิว');
        }

        $id_member = auth()->guard('member')->user()->id_member;

        Review::create([
            'score_review' => $request->input('score_review'),
            'detail' => $request->input('detail'),
            'date' => now(),
            'id_book' => $id_book,
            'id_member' => $id_member,
        ]);

        return redirect()->back()->with('success', 'รีวิวของคุณถูกบันทึกเรียบร้อยแล้ว!');
    }
}
