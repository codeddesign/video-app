<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User_account;
use App\Campaign;
use DB;
use Mail;

use Input;
use Validator;
use Session;
use Response;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function test()
    {
        echo "it is working state now.";
    }
    public function example()
    {
        return view('admin/test');
    }
    public function index()
    {
        
        return view('admin/login');
    }
    public function userLogin()
    {
        
        $menu_flag = [1,0,0,0,0,0];
        $page_name = "DASHBOARD";
        $input = Input::all();
        $user_account = User_account::whereRaw('username = ? and password = ?',[$input['username'],md5($input['password'])])->get();
        
        if(count($user_account) == 0)
        {
            $error = "Please enter your account again";
            return view('admin/login')->with(array('error'=>$error));
        }
        else
        {
            Session::put('login',$input['username']);

            $campaign = Campaign::all();
            $success = "Welcome !!!";
            return view('admin/index')->with(array('user_account' =>$user_account[0],'campaign'=>$campaign,'menu_flag'=>$menu_flag,'page_name'=>$page_name,'success'=>$success));
        }
    }
    public function adminDashboard($user_id)
    {
       
        if(!$this->adminCheck($user_id)) return view('admin/login');

        $menu_flag = [1,0,0,0,0,0];
        $page_name = "DASHBOARD";
        $user_account = User_account::find($user_id);
        $campaign = Campaign::all();
        return view('admin/index')->with(array('user_account' =>$user_account,'campaign'=>$campaign,'menu_flag'=>$menu_flag,'page_name'=>$page_name));
    }
    public function adminCreateCampaign($user_id)
    {
        if(!$this->adminCheck($user_id)) return view('admin/login');

        $menu_flag = [0,1,0,0,0,0];
        $page_name = "CREATE CAMPAIGN";
        $user_account = User_account::find($user_id);

        $success = "Please create new campaign";
        return view('admin/create-campaign')->with(array('user_account' =>$user_account,'menu_flag'=>$menu_flag,'page_name'=>$page_name,'success'=>$success));
    }
    public function adminCreateCampaignCheck($user_id)
    {
        if(!$this->adminCheck($user_id)) return view('admin/login');

        $menu_flag = [0,1,0,0,0,0];
        $page_name = "DASHBOARD";

        $input = Input::all();
        $user_account = User_account::find($user_id);

        $check_campaign = Campaign::where('campaign_name','=',$input['campaign_name'])->get();
        if(count($check_campaign)!=0)
        {
            $menu_flag = [0,1,0,0,0,0];
            $page_name = "CREATE CAMPAIGN";
            $user_account = User_account::find($user_id);

            $success = "The campaign exists aleady";
            return view('admin/create-campaign')->with(array('user_account' =>$user_account,'menu_flag'=>$menu_flag,'page_name'=>$page_name,'success'=>$success));
        }

        $campaign = new Campaign();
        $campaign->video_url = $input['youtube_url'];
        $campaign->campaign_name = $input['campaign_name'];
        if($input['video_width'] != "")
        {
            $campaign->video_size = $input['video_width']."+".$input['video_height'];
        }
        
        $campaign->save();
        $campaign = Campaign::all();

        $video_url = explode('=',$input['youtube_url']);
        if(count($video_url) == 2)
        {
            $url = $video_url[1];
        }
        else
        {
            $url = "";
        }
        $video_width =  $input['video_width'];
        $video_height = $input['video_height'];
        $success = "Campaign is created successfully";

         return view('admin/create-campaign')->with(array('user_account' =>$user_account,'video_url'=>$url,'video_width'=>$video_width,'campaign_name'=>$input['campaign_name'],'video_height'=>$video_height,'menu_flag'=>$menu_flag,'page_name'=>$page_name,'success'=>$success));
    }
    public function adminEditAccount($user_id)
    {
        if(!$this->adminCheck($user_id)) return view('admin/login');

        $menu_flag = [1,0,0,0,0,0];
        $page_name = "EDIT ACCOUNT";
        $user_account = User_account::find($user_id);
        return view('admin/account-password')->with(array('user_account' =>$user_account,'menu_flag'=>$menu_flag,'page_name'=>$page_name));
    }
    public function adminDeleteCampaign($pm)
    {
        $menu_flag = [1,0,0,0,0,0];
        $page_name = "DASHBOARD";

        $val_arr = explode('@', $pm);
        $user_id = $val_arr[1];
        $campaign_id = $val_arr[0];

        $campaign = Campaign::find($campaign_id);
        $campaign->delete();

        $user_account = User_account::find($user_id);
        $campaign = Campaign::all();

        $success = "One campaign is deleted successfully";
        
        return view('admin/index')->with(array('user_account' =>$user_account,'campaign'=>$campaign,'menu_flag'=>$menu_flag,'page_name'=>$page_name,'success'=>$success));


    }
    public function adminEditCampaign($pm)
    {
        $menu_flag = [0,1,0,0,0,0];
        $page_name = "EDIT CAMPAIGN";

        $val_arr = explode('@', $pm);
        $user_id = $val_arr[1];
        $campaign_id = $val_arr[0];

        $campaign = Campaign::find($campaign_id);
        $user_account = User_account::find($user_id);

        $video_width = "";
        $video_height = "";
        if($campaign->video_size != "")
        {
            $video_size = explode("+", $campaign->video_size);
            $video_width = $video_size[0];
            $video_height = $video_size[1];
        }
        $video_url = explode('=',$campaign->video_url);
        if(count($video_url) == 2)
        {
            $url = $video_url[1];
        }
        else
        {
            $url = "";
        }

        $success = "Please edit the campaign";

         return view('admin/create-campaign')->with(array('user_account' =>$user_account,'campaign_name'=>$campaign->campaign_name,'video_url'=>$url,'video_width'=>$video_width,'video_height'=>$video_height,'menu_flag'=>$menu_flag,'page_name'=>$page_name,'success'=>$success));
    }
    public function adminSearch($user_id)
    {
        if(!$this->adminCheck($user_id)) return view('admin/login');

        $menu_flag = [1,0,0,0,0,0];
        $page_name = "DASHBOARD";
        $input = Input::all();

        $user_account = User_account::find($user_id);
        $campaign = Campaign::all();

       // if($input['campaign_name']!="")
       // {
       //      if($input['campaign_select'] == "Campaign Name")
       //      {
       //          $campaign = Campaign::whereRaw('campaign_name like %?%',[$input['campaign_name']]);
       //      }
       //      else
       //      {
       //           $campaign = Campaign::whereRaw('ad_name like %?%',[$input['campaign_name']]);
       //      }
       // }
       // if($input['plays_min'] !="" && $input['plays_max'] !="")
       // {
       //      if($input['plays_select'] == "Video Plays")
       //      {
       //          $campaign = Campaign::whereRaw('campaign_name like %?%',[$input['campaign_name']]);
       //      }
            
       // }
        
        return view('admin/index')->with(array('user_account' =>$user_account,'campaign'=>$campaign,'menu_flag'=>$menu_flag,'page_name'=>$page_name));

    }
    public function adminChangePassword($user_id)
    {
        if(!$this->adminCheck($user_id)) return view('admin/login');

        $menu_flag = [1,0,0,0,0,0];
        $page_name = "EDIT ACCOUNT";
        $input = Input::all();
        $user_account = User_account::find($user_id);

        if($input['password'] != $input['confirm_password'] || $input['password'] == "")
        {
            $error = "Please enter new password correctly";
            return view('admin/account-password')->with(array('user_account' =>$user_account,'menu_flag'=>$menu_flag,'page_name'=>$page_name,'error'=>$error));
        }
        else
        {
            $user_account->password = md5($input['password']);
            $user_account->save();
            
            $success = "Your password is changed";
            return view('admin/login')->with(array('success'=>$success));

        }
    }
    public function adminRegisterCheck()
    {
        $input = Input::all();
        $user_account = User_account::whereRaw('username = ?',[$input['username']])->get();
        
        if($input['password'] != $input['confirm_password'] || count($user_account) != 0)
        {
            $error = "Please enter all fields correctly";
            return view('admin/register')->with(array('error'=>$error));
        }
        else
        {
            $user_account = new User_account();
            $user_account->username = $input['username'];
            $user_account->password = md5($input['password']);
            $user_account->save();

            $success = "Your account is created successfully";
            return view('admin/login')->with(array('success'=>$success));
        }
    }
    public function adminLostPasswordCheck()
    {
        $input::all();
        //will code later
        return view('admin/login');
    }
    public function adminRegister()
    {
        return view('admin/register');
    }
    public function adminLostPassword()
    {
        return view('admin/lost-password');
    }
    public function adminLogout()
    {
        Session::put('login',"false");
        return view('admin/login');
    }

//////////////////////////////
    private function adminCheck($user_id)
    {
        if(!Session::has('login') || Session::get('login')=="false")
        {
           return false;
        }
        else
        {
           $user_account = User_account::find($user_id);
            if(count($user_account) == 0 || Session::get('login') != $user_account->username)
            {
                Session::put('login',"false");
                return false;
            }
            else
            {
                return true;
            }
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
