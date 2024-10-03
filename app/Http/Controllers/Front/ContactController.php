<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ContactUsEnquiry;
use Illuminate\Http\Request;
use App\Models\ContactUsSetting;
use Carbon\Carbon;

class ContactController extends Controller
{
    //
    public function contact()
    {
        $ContactUsSetting = ContactUsSetting::where('static_id', 1)->where('status', 1)->first();
        return view('front.pages.contact', ['ContactUsSetting' => $ContactUsSetting]);
    }
    public function contactMessageSave(Request $request)
    {
        $request->validate([
            'name' => 'required|max:40',
            'email' => 'required|email',
            'phone' => 'required',
            'goal' => 'required',
        ]);

        $ContactUsEnquiry = new ContactUsEnquiry();
        $ContactUsEnquiry->name = $request['name'];
        $ContactUsEnquiry->email = $request['email'];
        $ContactUsEnquiry->phone = $request['phone'];
        $ContactUsEnquiry->goal = $request['goal'];
        $ContactUsEnquiry->save();

        // $data = [
        //     'name' => $request['name'],
        //     'email' => $request['email'],
        //     'phone' => $request['phone'],
        //     'subject' => $request['subject'],
        //     'message' => $request['message'],
        //     'id' => $ContactUsEnquiry->id,
        //     'created_at' => $ContactUsEnquiry->created_at ? Carbon::parse($ContactUsEnquiry->created_at)->setTimezone('Asia/Kolkata')->toDateTimeString() : '',
        // ];
        if ($ContactUsEnquiry) {
            return redirect()->back()->with('message', 'Thanks for contacting us. We will contact you ASAP!..');
        } else {
            return redirect()->back()->with('error', 'Somthing Went Wrong..');
        }
    }
}
