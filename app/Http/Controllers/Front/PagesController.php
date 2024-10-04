<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Newsletter;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    //

    public function home()
    {
        return view('front.pages.home');
    }
    public function about()
    {
        return view('front.pages.about');
    }
    public function services()
    {
        return view('front.pages.services');
    }

    public function blogs()
    {
        $Blogs = Blog::where('status', 1)->orderBy('id', 'DESC')->paginate(6);
        return view('front.pages.blogs', ['Blogs' => $Blogs]);
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        if ($search) {
            $Blogs = Blog::where('title', 'like', "%$search%")->where('status', 1)->orderBy('id', 'DESC')
                ->paginate(6);
            if ($Blogs) {
                return view('front.pages.blogs-search-list', ['search' => $search, 'Blogs' => $Blogs]);
            } else {
                return redirect()->route('front.blogs');
            }
        } else {
            return redirect()->route('front.blogs');
        }
    }

    public function details($id)
    {
        if ($id) {
            $Blog = Blog::where('status', 1)->where('id', $id)->first();
            if ($Blog) {
                // Get the previous blog with status 1
                $prevBlog = Blog::where('status', 1)
                    ->where('id', '<', $Blog->id)
                    ->orderBy('id', 'desc')
                    ->first();

                // Get the next blog with status 1
                $nextBlog = Blog::where('status', 1)
                    ->where('id', '>', $Blog->id)
                    ->orderBy('id', 'asc')
                    ->first();
                $latestBlogs = Blog::where('id', '!=', $id)->where('status', 1)->orderBy('id', 'DESC')->limit(7)->get();
                return view('front.pages.blogs-details', ['Blog' => $Blog, 'latestBlogs' => $latestBlogs, 'prevBlog' => $prevBlog, 'nextBlog' => $nextBlog]);
            } else {
                return redirect()->back()->with('error', 'Somthing Went Wrong..!');
            }
        } else {
            return redirect()->back()->with('error', 'Blog Not Found..!');
        }
    }

    public function authorList($id)
    {
        if ($id) {
            $Author = User::where('status', 1)->where('is_admin', 1)->where('is_verified', 1)->where('id', $id)->first();
            if ($Author) {
                $Blogs = Blog::where('status', 1)->where('user_id', $id)->orderBy('id', 'DESC')->paginate(3);
                return view('front.blogs.author-list', ['Author' => $Author, 'Blogs' => $Blogs]);
            } else {
                return redirect()->back()->with('error', 'Somthing Went Wrong..!');
            }
        } else {
            return redirect()->back()->with('error', 'Author Not Found..!');
        }
    }

    public function newsletterSave(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $Newsletter = Newsletter::where('email', $request->email)->where('status', 1)->first();
        if ($Newsletter) {
            return redirect()->back()->with('message', 'Thank you for subscribing to our newsletter! Stay tuned for the latest updates and exciting news.');
        }
        $Newsletter = Newsletter::where('email', $request->email)->where('status', 0)->first();
        if ($Newsletter) {
            $Newsletter->status = 1;
            $Newsletter->save();
            return redirect()->back()->with('message', 'Thank you for subscribing to our newsletter! Stay tuned for the latest updates and exciting news.');
        }

        $Newsletter = new Newsletter();
        $Newsletter->email = $request['email'];
        $Newsletter->save();

        if ($Newsletter) {
            return redirect()->back()->with('message', 'Thank you for subscribing to our newsletter! Stay tuned for the latest updates and exciting news.');
        } else {
            return redirect()->back()->with('error', 'Somthing Went Wrong..');
        }
    }


    public function newsletterUnSubscribe(Request $request)
    {
        $email = decrypt($request->email);
        $Newsletter = Newsletter::where('email', $email)->first();
        if (!$Newsletter) {
            return redirect()->back()->with('error', 'Not Subscribed..');
        }
        if ($Newsletter && $Newsletter->status == 1) {
            $Newsletter->status = 0;
            $Newsletter->save();
            return redirect()->route('front.home')->with('message', 'UnSubscribed Sucssesfully!..');
        }
        return redirect()->back()->with('error', 'Already UnSubscribed..');
    }

    public function term_and_condition()
    {
        return view('front.pages.term_and_condition');
    }
    public function privacy_policy()
    {
        return view('front.pages.privacy_policy');
    }
}
