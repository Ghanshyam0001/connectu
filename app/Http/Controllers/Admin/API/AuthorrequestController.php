<?php

namespace App\Http\Controllers\Admin\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Author;
use App\Mail\RequestApproved;
use Illuminate\Support\Facades\Mail;



class AuthorrequestController extends Controller
{
    public function authorrequestapproved(string $id)
    {
        $author = Author::where('id', $id)->first();

        $apr = "1";
        $author->status = $apr;
        $author->save();

        $toEamil = $author->email;
        $name = $author->name;
        $request = "Author Request";
        $approve = "Approved";
        $bestwhishes = "Congratulations " . $name . ", your author profile has been successfully approved. We are pleased to welcome you to our platform and look forward to your valuable contributions, meaningful insights, and continued professional success.";

        $login = "/openautherlogin";


        Mail::to($toEamil)->send(new RequestApproved($toEamil, $request, $approve, $bestwhishes, $login));

        return response()->json(['message' => 'Request Approved successfully']);
    }

    public function authorrequestreject(string $id)
    {

        $author = Author::where('id', $id)->first();



        $toEamil = $author->email;
        $name = $author->name;
        $request = "Author Request";
        $approve = "Rejected";
        $bestwhishes = "Hi" . $name . " we appreciate your interest in joining our platform. After careful review, your author request has not been approved at this time. We encourage you to improve your profile and apply again in the future. Wishing you continued success in your endeavors.";

        $login = "/connectU";


        if ($author->image) {
            $filepath = public_path('uploads/' . $author->image);
            if (file_exists($filepath)) {
                unlink($filepath);
            }
        }

        $author->delete();


        Mail::to($toEamil)->send(new RequestApproved($toEamil, $request, $approve, $bestwhishes, $login));

        return response()->json(['message' => 'Request Delete successfully']);
    }

    public function approveorreject(Request $request)
    {
        $data = Author::where('status', 0)->paginate(6);

        return response()->json([
            'message' => 'All Author Request',
            'data' => $data->items(),          // only author records
            'pagination' => [
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
            ]
        ]);
    }

 public function showactive(Request $request)
{
   
    $data = Author::where('status', 1)->paginate(6);

    return response()->json([
        'message' => 'Active Authors fetched successfully',
        'data' => $data->items(),          // only author records for this page
        'pagination' => [
            'current_page' => $data->currentPage(),
            'last_page' => $data->lastPage(),
        ]
    ]);
}

 public function showdiactive(Request $request)
{
   
    $data = Author::where('status', 3)->paginate(6);

    return response()->json([
        'message' => 'Active Authors fetched successfully',
        'data' => $data->items(),          // only author records for this page
        'pagination' => [
            'current_page' => $data->currentPage(),
            'last_page' => $data->lastPage(),
        ]
    ]);
}

    public function diactiveauthor(string $id)
    {

        $author = Author::where('id', $id)->first();

        $diactive = 3;
        $author->status = $diactive;
        $author->save();

        $toEamil = $author->email;
        $name = $author->name;
        $request = "Author Account";
        $approve = "Diacticated";
        $bestwhishes = "Hi " . $name . ",
         We have identified repeated violations of our content guidelines, including offensive material. As a result, your author account has been temporarily deactivated.This is a serious matter — further violations may lead to permanent removal from our platform. Please review our community standards and ensure all future content complies with our policies.We encourage you to reflect on this feedback and return with improved contributions. Our platform values respectful, professional, and constructive content.";


        $login = "/connectU";

        Mail::to($toEamil)->send(new RequestApproved($toEamil, $request, $approve, $bestwhishes, $login));

        return response()->json(['message' => 'Diactivated Account successfully']);
    }

    public function activeauthor(string $id)
    {

        $author = Author::where('id', $id)->first();

        $active = 1;
        $author->status = $active;
        $author->save();

        $toEamil = $author->email;
        $name = $author->name;
        $request = "Author Account";
        $approve = "Activate";
        $bestwhishes = "Hi " . $name . ", 

        We have identified repeated violations of our content guidelines, including offensive material. As a result, your author account has been temporarily deactivated.This is a serious matter — further violations may result in permanent removal from our platform.Please take this time to carefully review our community standards and ensure all future content follows our policies.We value constructive, professional, and respectful contributions, and we encourage you to return with improved content once your account is reactivated.";



        $login = "/openautherlogin";

        Mail::to($toEamil)->send(new RequestApproved($toEamil, $request, $approve, $bestwhishes, $login));

        return response()->json(['message' => 'activated Account successfully']);
    }
}
