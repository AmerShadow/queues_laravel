<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmail;
use App\Mail\SendEmailTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{

    public function sendMail(Request $request)
    {

        if ($request->type == "Normal_mail") {
            return $this->sendMailNormal($request->email);
        }else{
            return $this->sendMailViaQueue($request->email);
        }
    }
    public function sendMailNormal($email)
    {
        $start_time = microtime(true);
        $mail=new SendEmailTest();

        Mail::to($email)->send($mail);

        $end_time = microtime(true);
        $execution_time = ($end_time - $start_time);
        return "E-mail has been sent Successfully "." Execution time of script = ".$execution_time." sec";
    }


    public function sendMailViaQueue($email)
    {
        $start_time = microtime(true);
        $emailJob=new SendEmail($email);
        dispatch($emailJob);


        $end_time = microtime(true);
        $execution_time = ($end_time - $start_time);
        return "E-mail has been sent Successfully "." Execution time of script = ".$execution_time." sec";

    }
}
